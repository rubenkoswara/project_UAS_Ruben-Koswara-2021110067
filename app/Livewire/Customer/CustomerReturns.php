<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\ReturnRequest;

class CustomerReturns extends Component
{
    use WithFileUploads, WithPagination;

    public $shipmentProof = []; 
    public $selectedReturnId = null;
    public $selectedReturn = null;
    public $showDetailModal = false;

    public function openDetailModal($returnId)
    {
        $this->selectedReturnId = $returnId;
        $this->selectedReturn = ReturnRequest::with('order', 'orderItem.product')
            ->findOrFail($returnId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->selectedReturnId = null;
        $this->selectedReturn = null;
        $this->showDetailModal = false;
    }

    public function uploadShipment($returnId)
    {
        $return = ReturnRequest::where('user_id', auth()->id())->findOrFail($returnId);
    
        if (!isset($this->shipmentProof[$returnId])) {
            session()->flash('toast_error', 'Silakan upload bukti resi terlebih dahulu.');
            return;
        }
    
        $this->validate([
            "shipmentProof.$returnId" => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
    
        $path = $this->shipmentProof[$returnId]->store('shipment_proofs', 'public');
    
        $return->update([
            'shipment_proof' => $path,
            'status' => 'shipped'
        ]);
    
        $this->shipmentProof[$returnId] = null;
        $this->selectedReturn = $return;

        session()->flash('toast_success', 'Resi berhasil diupload.');
    }

    public function render()
    {
        $returns = ReturnRequest::with('order', 'orderItem.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.customer.customer-returns', compact('returns'))
            ->layout('layouts.app');
    }
}


