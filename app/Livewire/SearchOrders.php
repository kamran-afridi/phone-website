<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchOrders extends Component
{

	public $search = '';

    public function render()
    {
		$products = Product::where("user_id",auth()->id())
		->search($this->search)
		->get();
        return view('livewire.search-orders', ['products' => $products]);
    }
}