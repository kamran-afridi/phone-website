<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Device;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
	public function index()
	{
		$products = Product::where("user_id", auth()->id())->count();

		return view('products.index', [
			'products' => $products,
		]);
	}

	public function create(Request $request)
	{
		$categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
		$product = Product::where('uuid', auth()->id())->first();
		$devices = Device::where('user_id', auth()->id())->get(['id', 'name']);

		// $sub_categories = SubCategory::where("category_id", $categories[0]['id'])->get(['id', 'sub_category_name']);

		if ($request->has('category')) {
			$categories = Category::where("user_id", auth()->id())->whereSlug($request->get('category'))->get();
		}

		return view('products.create', [
			'categories' => $categories,
			'product' => $product,
			'devices' => $devices,
			// 'sub_categories' => $sub_categories,
		]);
	}

	public function store(StoreProductRequest $request)
	{
		/**
		 * Handle upload image
		 */
		$image = "";
		if ($request->hasFile('product_image')) {
			$image = $request->file('product_image')->store('products', 'public');
		}

		$sku = $this->generate_SKU(
			$request->name,
			$request->category,
			$request->imei,
			$request->upc_code
		);

		Product::create([
			'name' => $request->name,
			'category_id' => $request->category,
			'sub_category' => $request->sub_category,
			'product_description' => $request->description,
			'manufacturer' => $request->manufacturer,
			'device' => $request->device,
			'sku' => $sku,
			'upc_code' => $request->upc_code,
			'bar_code' => $request->bar_code,
			'valuation_method' => $request->valuation_method,
			'new_stock_adjustment' => $request->new_stock_adjustment,
			'new_inventory_item_cost' => $request->new_inventory_item_cost,
			'tax_class' => $request->tax_class,
			'tax_inclusive' => $request->tax_inclusive,
			'retail_price' => $request->retail_price,
			'cost_price' => $request->cost_price,
			'sale_price' => $request->sale_price,
			'minimum_price' => $request->minimum_price,
			'on_hand_quantity' => $request->on_hand_quantity,
			'quantity' => $request->on_hand_quantity,
			'stock_warning' => $request->stock_warning,
			're_order_level' => $request->reorder_level,
			'manage_serialized' => $request->manage_serialized,
			'condition' => $request->condition,
			'supplier' => $request->supplier,
			'physical_location' => $request->physical_location,
			'warranty' => $request->warranty,
			'warranty_time_frame' => $request->warranty_time_frame,
			'imei' => $request->imei,
			'display_on_point_of_sale' => $request->display_pos,
			'display_on_widget' => $request->display_widget,
			'comission_percentage' => $request->comission_percentage,
			'comission_amount' => $request->comission_amount,
			'user_id' => auth()->id(),
			'device_id' => $request->device,
			'slug' => Str::slug($request->name, '-'),
			'uuid' => Str::uuid(),
		]);

		return to_route('products.index')->with('success', 'Product has been created!');
	}

	public function show($uuid)
	{
		$product = Product::where("uuid", $uuid)->firstOrFail();
		// Generate a barcode
		// $generator = new BarcodeGeneratorHTML();

		// $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

		return view('products.show', [
			'product' => $product,
			// 'barcode' => $barcode,
		]);
	}

	public function edit($uuid)
	{
		$categories = Category::where("user_id", auth()->id())->get(['id', 'name']);

		$product = Product::where("uuid", $uuid)->firstOrFail();

		return view('products.edit', [
			'categories' => $categories,
			'product' => $product,
		]);
	}

	public function update(UpdateProductRequest $request, $uuid)
	{
		$product = Product::where("uuid", $uuid)->firstOrFail();
		// $product->update($request->except('product_image'));

		$image = $product->product_image;
		if ($request->hasFile('product_image')) {

			// Delete Old Photo
			if ($product->product_image) {
				unlink(public_path('storage/') . $product->product_image);
			}
			$image = $request->file('product_image')->store('products', 'public');
		}

		$product->name = $request->name;
		$product->slug = Str::slug($request->name, '-');
		$product->category_id = $request->category;
		$product->sub_category = $request->sub_category;
		$product->product_description = $request->description;
		$product->manufacturer = $request->manufacturer;
		$product->device = $request->device;
		// $product->sku = $request->sku;
		$product->upc_code = $request->upc_code;
		$product->is_barcode = $request->bar_code === 'true' ? 1 : 0;
		$product->valuation_method = $request->valuation_method;
		$product->new_stock_adjustment = $request->new_stock_adjustment;
		$product->new_inventory_item_cost = $request->new_inventory_item_cost;
		$product->tax_class = $request->tax_class;
		$product->tax_inclusive = $request->tax_inclusive;
		$product->retail_price = $request->retail_price;
		$product->cost_price = $request->cost_price;
		$product->sale_price = $request->sale_price;
		$product->minimum_price = $request->minimum_price;
		$product->on_hand_quantity = $request->on_hand_quantity;
		$product->quantity = $request->on_hand_quantity;
		$product->stock_warning = $request->stock_warning;
		$product->re_order_level = $request->reorder_level;
		$product->manage_serialized = $request->manage_serialized;
		$product->condition = $request->condition;
		$product->supplier = $request->supplier;
		$product->physical_location = $request->physical_location;
		$product->warranty = $request->warranty;
		$product->warranty_time_frame = $request->warranty_time_frame;
		$product->imei = $request->imei;
		$product->display_on_point_of_sale = $request->display_pos === 'true' ? 1 : 0;
		$product->display_on_widget = $request->display_widget === 'true' ? 1 : 0;
		$product->comission_percentage = $request->comission_percentage;
		$product->comission_amount = $request->comission_amount;
		$product->user_id = auth()->id();
		$product->uuid = Str::uuid();
		$product->save();


		return redirect()
			->route('products.index')
			->with('success', 'Product has been updated!');
	}

	public function destroy($uuid)
	{
		$product = Product::where("uuid", $uuid)->firstOrFail();
		/**
		 * Delete photo if exists.
		 */
		if ($product->product_image) {
			// check if image exists in our file system
			if (file_exists(public_path('storage/') . $product->product_image)) {
				unlink(public_path('storage/') . $product->product_image);
			}
		}

		$product->delete();

		return redirect()
			->route('products.index')
			->with('success', 'Product has been deleted!');
	}

	private function generate_SKU(
		$name,
		$category_id,
		$imei,
		$upc_code
	): string {
		$sku = substr($name, 0, 2) . '-' . substr(Str::uuid(), 0, 2) . '-' . $category_id . '-' . substr($imei, 0, 2) . '-' . substr($upc_code, 0, 2);

		return strtoupper(str_replace(" ", "", $sku));
	}
}
