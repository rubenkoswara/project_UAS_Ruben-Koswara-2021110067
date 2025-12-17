<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    use WithFileUploads;

    public $cart = [];
    public $alamat, $kota, $kecamatan, $kelurahan, $no_telp, $note;
    public $payment_method;
    public $shipping_method;
    public $shipping_cost = 0;
    public $bukti_transfer;

    protected $rules = [
        'payment_method'  => 'required',
        'shipping_method' => 'required',
        'bukti_transfer'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);

        if (Auth::check()) {
            $u = Auth::user();
            $this->alamat    = $u->alamat;
            $this->kota      = $u->kota;
            $this->kecamatan = $u->kecamatan;
            $this->kelurahan = $u->kelurahan;
            $this->no_telp   = $u->no_telepon;
        }
    }

    public function updatedShippingMethod($value)
    {
        $shipping = ShippingMethod::find($value);
        $this->shipping_cost = $shipping->cost ?? 0;
    }

    public function placeOrder()
    {
        $this->validate();

        $payment  = PaymentMethod::find($this->payment_method);
        $shipping = ShippingMethod::find($this->shipping_method);

        $subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $grandTotal = $subtotal + ($shipping->cost ?? 0);

        $path = $this->bukti_transfer->store('payment-proof', 'public');

        $order = Order::create([
            'user_id'        => Auth::id(),
            'total'          => $grandTotal,
            'status'         => 'pending',
            'payment_method' => $payment->name,
            'shipping_info'  => json_encode([
                'alamat'        => $this->alamat,
                'kota'          => $this->kota,
                'kecamatan'     => $this->kecamatan,
                'kelurahan'     => $this->kelurahan,
                'no_telp'       => $this->no_telp,
                'note'          => $this->note,
                'shipping'      => $shipping->name,
                'shipping_cost' => $shipping->cost ?? 0
            ]),
            'payment_proof' => $path,
        ]);

        foreach ($this->cart as $product_id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product_id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            $product = Product::find($product_id);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        session()->forget('cart');

        return redirect()->route('customer.catalog')
            ->with('message', 'Order berhasil dibuat!');
    }

    public function render()
    {
        $subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return view('livewire.customer.checkout', [
            'paymentMethods'   => PaymentMethod::all(),
            'shippingMethods'  => ShippingMethod::all(),
            'subtotal'         => $subtotal,
            'grandTotal'       => $subtotal + $this->shipping_cost,
            'selectedPayment'  => $this->payment_method ? PaymentMethod::find($this->payment_method) : null,
            'selectedShipping' => $this->shipping_method ? ShippingMethod::find($this->shipping_method) : null,
        ])->layout('layouts.app');
    }
}
