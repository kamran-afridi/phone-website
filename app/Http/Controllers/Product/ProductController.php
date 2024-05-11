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
		$products = Product::all();

 		return view('products.index', [
			'products' => $products,
		]);
	}

	public function create(Request $request)
	{

		if(auth()->user()->role !== 'admin') {
			return abort(404);
		}

		$categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
		$product = Product::where('uuid', auth()->id())->first();
		// $devices = Device::where('user_id', auth()->id())->get(['id', 'name']);

		// $sub_categories = SubCategory::where("category_id", $categories[0]['id'])->get(['id', 'sub_category_name']);

		if ($request->has('category')) {
			$categories = Category::where("user_id", auth()->id())->whereSlug($request->get('category'))->get();
		}

		return view('products.create', [
			'categories' => $categories,
			'product' => $product,
			// 'devices' => $devices,
		]);
	}

	public function store(StoreProductRequest $request)
	{
		/**
		 * Handle upload image
		 */

		 if(auth()->user()->role !== 'admin') {
			return abort(404);
		 }

		$image = "";
		if ($request->hasFile('product_image')) {
			$image = $request->file('product_image')->store('products', 'public');
		}

		Product::create([
			'name' => $request->name,
			'category_id' => $request->category,
			'sub_category' => $request->sub_category,
			'product_description' => $request->description,
			'price' => $request->price,
			'quantity' => $request->quantity,
			'user_id' => auth()->id(),
			'device_id' => $request->device,
			'slug' => Str::slug($request->name, '-'),
			'uuid' => Str::uuid(),
		]);

		return to_route('products.index')->with('success', 'Product has been created!');
	}

	public function show($uuid)
	{	
		if(auth()->user()->role !== 'admin') {
			return abort(404);
		}
	
		$product = Product::join('categories', 'products.category_id', '=', 'categories.id')
			->join('sub_categories', 'products.sub_category', '=', 'sub_categories.id')
			->select('products.*', 'categories.name as category_name', 'sub_categories.sub_category_name as sub_category_name')
			->where('products.uuid', $uuid)->firstOrFail();

		// Generate a barcode
		// $generator = new BarcodeGeneratorHTML();
		// dd($product);
		// $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

		return view('products.show', [
			'product' => $product,
			// 'barcode' => $barcode,
		]);
	}

	public function edit($uuid)
	{
		if(auth()->user()->role !== 'admin') {
			return abort(404);
		}

		$categories = Category::where("user_id", auth()->id())->get(['id', 'name']);

		$product = Product::where("uuid", $uuid)->firstOrFail();

		return view('products.edit', [
			'categories' => $categories,
			'product' => $product,
		]);
	}

	public function update(UpdateProductRequest $request, $uuid)
	{
		if(auth()->user()->role !== 'admin') {
			return abort(404);
		}

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
		$product->price = $request->price;
		$product->quantity = $request->quantity;
		$product->user_id = auth()->id();
		$product->uuid = Str::uuid();
		$product->save();


		return redirect()
			->route('products.index')
			->with('success', 'Product has been updated!');
	}

	public function destroy($uuid)
	{
		if(auth()->user()->role !== 'admin') {
			return abort(404);
		}

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
}
