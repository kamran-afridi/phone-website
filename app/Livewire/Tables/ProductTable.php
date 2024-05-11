<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class ProductTable extends Component
{
	use WithPagination;

	public $perPage = 5;
	public $selectedValue;
	public $search = '';

	public $sortField = 'products.id';

	public $sortAsc = false;

	public function sortBy($field): void
	{
		if ($this->sortField === $field) {
			$this->sortAsc = !$this->sortAsc;

		} else {
			$this->sortAsc = true;
		}

		$this->sortField = $field;
	}

	public function render()
	{
			$products = Product::join('categories', 'products.category_id', '=', 'categories.id')->with(['device_id'])
				->join('sub_categories', 'products.sub_category', '=', 'sub_categories.id')
				->select('products.name as product_name', 'categories.name as category_name', 'products.*', 'sub_categories.sub_category_name')
				->with(['category_id'])
				->search($this->search)
				->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
				->paginate($this->perPage);

			return view('livewire.tables.product-table', [
			'products' => $products
		]);
	}

}
