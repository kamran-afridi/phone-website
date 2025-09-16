<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Http\Requests\Product\StoreProductRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductExportController extends Controller
{
    public function create()
    {
        $products = Product::all()->sortBy('product_name');

        $product_array[] = array(
            'Product Name',
            'Product Slug',
            'Category Id',
            'Unit Id',
            'Product Code',
            'Stock',
            "Stock Alert",
            'Buying Price',
            'Selling Price',
            'Product Image',
            "Note"
        );

        foreach ($products as $product) {
            $product_array[] = array(
                'Product Name' => $product->name,
                'Product Slug' => $product->slug,
                'Category Id' => $product->category_id,
                'Unit Id' => $product->unit_id,
                'Product Code' => $product->code,
                'Stock' => $product->quantity,
                "Stock Alert" => $product->quantity_alert,
                'Buying Price' => $product->buying_price,
                'Selling Price' => $product->selling_price,
                'Product Image' => $product->product_image,
                "Note" => $product->note
            );
        }

        $this->store($product_array);
    }

    public function store($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="products.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }


   public function ManualProductCreation(Request $request)
	{
		/**
		 * Handle upload image
		 */ 
        $rand = rand(1000, 9999); 
		$imageName = ""; 
		$Product = Product::create([
			'name' => $request->name,
			'cost_price' => '0',
			'whole_sale_price' => $request->whole_sale_price,
			'sale_price' => $request->whole_sale_price,
			'quantity' => $request->quantity,
			'sku' => 'PF-'.$rand,
			'bar_code' => 'PF-'.$rand,
			'product_image' => 'products/' . $imageName,
			'item_type' => 'Default',
			'user_id' => auth()->id(),
			'uuid' => Str::uuid(),
		]);
		// dd($Product);
        Log::info('Product created successfully: ' . $Product->id);
		if (str_contains(url()->previous(), '/orders/create')) {
			return to_route('orders.create');
		}
		return to_route('orders.create')->with('success', 'Product has been created!');
	}
}
    
