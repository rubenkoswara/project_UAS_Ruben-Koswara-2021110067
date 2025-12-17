<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ReturnRequest;

class OrderReturnManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $selectedReturn;
    public $refundProof;
    public $rejectReason;
    public $toastMessage = '';

    public function selectReturn($id)
    {
        $this->selectedReturn = ReturnRequest::with('order.user', 'orderItem.product')->findOrFail($id);
        $this->refundProof = null;
        $this->rejectReason = null;
    }

    public function approveReturn()
    {
        if (!$this->selectedReturn || $this->selectedReturn->status !== 'pending') return;
        $this->selectedReturn->update(['status' => 'reviewed']);
        $this->toastMessage = "Pengajuan retur disetujui. Customer diminta mengirim barang dan upload resi.";
    }

    public function rejectReturn()
    {
        if (!$this->selectedReturn || !in_array($this->selectedReturn->status, ['pending','reviewed','shipped'])) return;
        $this->selectedReturn->update([
            'status' => 'rejected_by_admin',
            'review_reason' => $this->rejectReason
        ]);
        $this->toastMessage = "Retur ditolak oleh admin.";
    }

    public function confirmReceived()
    {
        if (!$this->selectedReturn || $this->selectedReturn->status !== 'shipped') return;
        $this->selectedReturn->update(['status' => 'received']);
        $this->toastMessage = "Barang diterima, silakan upload bukti pengembalian dana.";
    }

    public function uploadRefundProof()
    {
        if (!$this->selectedReturn || !$this->refundProof) return;
        $path = $this->refundProof->store('refund-proofs', 'public');
        $this->selectedReturn->update(['refund_proof' => $path]);
        $this->refundProof = null;
        $this->toastMessage = "Bukti pengembalian dana berhasil diupload.";
    }

    public function closeModal()
    {
        $this->selectedReturn = null;
        $this->refundProof = null;
        $this->rejectReason = null;
    }

    public function render()
    {
        $returns = ReturnRequest::with('order.user', 'orderItem.product')->latest()->paginate(10);
        return view('livewire.admin.order-return-management', compact('returns'))->layout('layouts.app');
    }
}
