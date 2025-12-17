<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;
use App\Models\Product;

class ReviewManagement extends Component
{
    use WithPagination;

    public $searchProduct = '';
    public $searchRating = '';
    public $selectedReview;

    public function render()
    {
        $query = Review::with('product','user')->latest();

        if($this->searchProduct){
            $query->whereHas('product', function($q){
                $q->where('name','like','%'.$this->searchProduct.'%');
            });
        }

        if($this->searchRating){
            $query->where('rating', $this->searchRating);
        }

        return view('livewire.admin.review-management', [
            'reviews' => $query->paginate(10)
        ])->layout('layouts.app');
    }

    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        session()->flash('message', 'Review berhasil dihapus!');
    }

    public function selectReview($reviewId)
    {
        $this->selectedReview = Review::with('product','user')->findOrFail($reviewId);
    }
}
