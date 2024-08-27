<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;

class SearchOrders extends Component
{
	use WithPagination;

	public $perPage = 15;
	public $selectedValue;
	public $search = '';

	public $sortField = 'products.id';

	public $customer_id;
	public $sortAsc = 'desc';

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
			->paginate($this->perPage);
		return view(
			'livewire.search-orders',
			[
				'products' => $products,
				'customer_id' => $this->customer_id,
			]
		);
	}
}
