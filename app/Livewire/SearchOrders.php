<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class SearchOrders extends Component
{
    use WithPagination;

    // public $perPage = 8;
    public $selectedValue;
    public $search = '';

    public $sortField = 'products.id';

    public $customer_id;
    public $sortAsc = 'desc';

    //add to Cart
    public $productId, $productName, $productsalePrice, $productSKU;

    public function addCartItem($productId, $name, $salePrice, $sku){
        // $request->all();
		//dd($request);
        // dd($productId, $name, $salePrice, $sku);
        try{
            Cart::add($productId, $name, 1, $salePrice, ['sku' => $sku]);
            $this->dispatch('addedTocart');
            session()->flash('success', value: 'Product has been added to cart!');
        }
        catch(\Exception $e){
            dd($e);
            Session::flash('error', 'Product already in cart');
            }
        $this->dispatch('addedTocart');
        session()->flash('success', value: 'Product has been added to cart!');

    }
    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Reset to the first page when search query changes
    }
    protected $listeners = ['customerChanged' => 'handleCustomerChanged'];

    public function handleCustomerChanged($customerId)
    {
        $this->customer_id = $customerId;
        // dd($this->customer_id);
        // Perform any additional actions, such as updating a list of orders
    }
    public function render()
    {
        $products = Product::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->get();
        // ->paginate($this->perPage);
        return view('livewire.search-orders', [
            'products' => $products,
            'customer_id' => $this->customer_id,
        ]);
    }
}
