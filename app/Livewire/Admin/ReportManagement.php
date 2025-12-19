<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportManagement extends Component
{
    use WithPagination;

    public $filterType = 'monthly';
    public $startDate;
    public $endDate;
    public $selectedDate;
    public $selectedWeek;
    public $selectedMonth;
    public $selectedYear;
    public $chartLabels = [];
    public $chartIncome = [];
    public $chartOrderCount = [];
    public $totalRevenue = 0;
    public $totalOrders = 0;
    public $avgOrderValue = 0;
    public $perPage = 12;
    protected $paginationTheme = 'tailwind';
    public $showDetailModal = false;
    public $selectedOrder = null;

    public function mount()
    {
        $this->endDate = Carbon::today()->toDateString();
        $this->startDate = Carbon::today()->subDays(29)->toDateString();
        $this->selectedDate = Carbon::today()->toDateString();
        $this->selectedWeek = Carbon::today()->format('Y-\WW');
        $this->selectedMonth = Carbon::today()->format('Y-m');
        $this->selectedYear = Carbon::today()->format('Y');
        $this->generateReport();
    }

    protected function clean($value)
    {
        if ($value === null) return '';
        return preg_replace('/[^\x20-\x7E]/', '', (string) $value);
    }

    private function getDateRange()
    {
        return match ($this->filterType) {
            'daily' => [
                Carbon::parse($this->selectedDate)->startOfDay(),
                Carbon::parse($this->selectedDate)->endOfDay()
            ],
            'weekly' => [
                Carbon::parse($this->selectedWeek)->startOfWeek(),
                Carbon::parse($this->selectedWeek)->endOfWeek()
            ],
            'monthly' => [
                Carbon::parse($this->selectedMonth)->startOfMonth(),
                Carbon::parse($this->selectedMonth)->endOfMonth()
            ],
            'yearly' => [
                Carbon::createFromDate($this->selectedYear)->startOfYear(),
                Carbon::createFromDate($this->selectedYear)->endOfYear()
            ],
            default => [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]
        };
    }

    public function applyFilter()
    {
        $this->resetPage();
        $this->generateReport();
    }

    public function updated($property)
    {
        if (in_array($property, ['filterType', 'selectedDate', 'selectedWeek', 'selectedMonth', 'selectedYear', 'startDate', 'endDate'])) {
            $this->applyFilter();
        }
    }

    public function generateReport()
    {
        [$start, $end] = $this->getDateRange();

        $orders = Order::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->get()
            ->map(function ($o) {
                $o->status = $this->clean($o->status);
                $o->total = (float) $o->total;
                if ($o->user) {
                    $o->user->name = $this->clean($o->user->name);
                }
                return $o;
            });

        $labels = [];
        $income = [];
        $count = [];

        if ($this->filterType === 'daily') {
            $period = new CarbonPeriod($start, '1 hour', $end);
            foreach ($period as $p) {
                $key = $p->format('Y-m-d H');
                $labels[] = $p->format('H:00');
                $income[$key] = 0;
                $count[$key] = 0;
            }
            foreach ($orders as $o) {
                $k = $o->created_at->format('Y-m-d H');
                if (isset($income[$k])) {
                    $income[$k] += $o->total;
                    $count[$k]++;
                }
            }
        } elseif ($this->filterType === 'weekly') {
            $period = new CarbonPeriod($start, '1 week', $end);
            foreach ($period as $p) {
                $key = $p->format('o-\WW');
                $labels[] = $p->format('d M') . ' - ' . $p->copy()->endOfWeek()->format('d M');
                $income[$key] = 0;
                $count[$key] = 0;
            }
            foreach ($orders as $o) {
                $k = $o->created_at->format('o-\WW');
                if (isset($income[$k])) {
                    $income[$k] += $o->total;
                    $count[$k]++;
                }
            }
        } elseif ($this->filterType === 'monthly' || $this->filterType === 'custom') {
            $period = new CarbonPeriod($start, '1 day', $end);
            foreach ($period as $p) {
                $key = $p->format('Y-m-d');
                $labels[] = $p->format('d M');
                $income[$key] = 0;
                $count[$key] = 0;
            }
            foreach ($orders as $o) {
                $k = $o->created_at->format('Y-m-d');
                if (isset($income[$k])) {
                    $income[$k] += $o->total;
                    $count[$k]++;
                }
            }
        } elseif ($this->filterType === 'yearly') {
            $period = new CarbonPeriod($start, '1 month', $end);
            foreach ($period as $p) {
                $key = $p->format('Y-m');
                $labels[] = $p->format('M Y');
                $income[$key] = 0;
                $count[$key] = 0;
            }
            foreach ($orders as $o) {
                $k = $o->created_at->format('Y-m');
                if (isset($income[$k])) {
                    $income[$k] += $o->total;
                    $count[$k]++;
                }
            }
        }

        $this->chartLabels = array_values(array_map([$this, 'clean'], $labels));
        $this->chartIncome = array_map('floatval', array_values($income));
        $this->chartOrderCount = array_map('intval', array_values($count));
        $this->totalRevenue = (float) $orders->sum('total');
        $this->totalOrders = (int) $orders->count();
        $this->avgOrderValue = $this->totalOrders ? (float) ($this->totalRevenue / $this->totalOrders) : 0;

        $this->dispatch('reportUpdated', [
            'labels' => $this->chartLabels,
            'income' => $this->chartIncome,
            'orderCount' => $this->chartOrderCount
        ]);
    }

    public function exportCsv()
    {
        [$start, $end] = $this->getDateRange();
        $filename = 'sales-report-' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($start, $end) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'User', 'Total', 'Status', 'Created At']);
            Order::with('user')->whereBetween('created_at', [$start, $end])->orderByDesc('created_at')
                ->each(function ($o) use ($out) {
                    fputcsv($out, [
                        $o->id,
                        $this->clean($o->user->name ?? '-'),
                        number_format((float) $o->total, 2, '.', ''),
                        $this->clean($o->status),
                        $o->created_at->format('Y-m-d H:i:s')
                    ]);
                });
            fclose($out);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ]);
    }

    public function exportPdf()
    {
        [$start, $end] = $this->getDateRange();
        $orders = Order::with('user')->whereBetween('created_at', [$start, $end])->orderByDesc('created_at')->get()
            ->map(function ($o) {
                $o->status = $this->clean($o->status);
                if ($o->user) $o->user->name = $this->clean($o->user->name);
                return $o;
            });

        $pdf = Pdf::loadView('livewire.admin.reports.pdf', [
            'orders' => $orders,
            'chartLabels' => $this->chartLabels,
            'chartIncome' => $this->chartIncome,
            'chartOrderCount' => $this->chartOrderCount,
            'totalRevenue' => (float) $this->totalRevenue,
            'totalOrders' => (int) $this->totalOrders,
            'avgOrderValue' => (float) $this->avgOrderValue,
            'startDate' => $start->toDateString(),
            'endDate' => $end->toDateString()
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'sales-report-' . now()->format('Ymd_His') . '.pdf');
    }

    public function openDetailModal($id)
    {
        $this->selectedOrder = Order::with('user', 'orderItems.product')->findOrFail($id);
        if ($this->selectedOrder->user) {
            $this->selectedOrder->user->name = $this->clean($this->selectedOrder->user->name);
        }
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->selectedOrder = null;
        $this->showDetailModal = false;
    }

    public function render()
    {
        [$start, $end] = $this->getDateRange();
        return view('livewire.admin.report-management', [
            'orders' => Order::with('user')->whereBetween('created_at', [$start, $end])->orderByDesc('created_at')->paginate($this->perPage)
        ])->layout('layouts.app');
    }
}