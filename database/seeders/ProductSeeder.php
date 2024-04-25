<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = collect([

            [
                
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'quantity' => 10,
                'product_description' => 'Product 1',
                'manufacturer' => 'Manufacturer 1',
                'device' => 'Device 1',
                'sku' => 'SKU001',
                'upc_code' => 'UPC001',
                'is_barcode' => false,
                'valuation_method' => 'Method 1',
                'new_stock_adjustment' => 'Adjustment 1',
                'new_inventory_item_cost' => 50.00,
                'tax_class' => 'Class 1',
                'tax_inclusive' => false,
                'retail_price' => 100.00,
                'cost_price' => 80.00,
                'sale_price' => 90.00,
                'minimum_price' => 70.00,
                'on_hand_quantity' => 100,
                'stock_warning' => 20,
                're_order_level' => 30,
                'manage_serialized' => 'Yes',
                'condition' => 'New',
                'supplier' => 'Supplier 1',
                'physical_location' => 'Location 1',
                'warranty' => 1.5,
                'warranty_time_frame' => 'Year',
                'imei' => 'IMEI001',
                'display_on_point_of_sale' => 'Yes',
                'display_on_widget' => 'Yes',
                'comission_percentage' => 5.00,
                'comission_amount' => 4.00, 
                'category_id' => 3, 
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/ip14.png', 
            ],

            [
                
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'quantity' => 10,
                'product_description' => 'Product 1',
                'manufacturer' => 'Manufacturer 1',
                'device' => 'Device 1',
                'sku' => 'SKU001',
                'upc_code' => 'UPC001',
                'is_barcode' => false,
                'valuation_method' => 'Method 1',
                'new_stock_adjustment' => 'Adjustment 1',
                'new_inventory_item_cost' => 50.00,
                'tax_class' => 'Class 1',
                'tax_inclusive' => false,
                'retail_price' => 100.00,
                'cost_price' => 80.00,
                'sale_price' => 90.00,
                'minimum_price' => 70.00,
                'on_hand_quantity' => 100,
                'stock_warning' => 20,
                're_order_level' => 30,
                'manage_serialized' => 'Yes',
                'condition' => 'New',
                'supplier' => 'Supplier 1',
                'physical_location' => 'Location 1',
                'warranty' => 1.5,
                'warranty_time_frame' => 'Year',
                'imei' => 'IMEI001',
                'display_on_point_of_sale' => 'Yes',
                'display_on_widget' => 'Yes',
                'comission_percentage' => 5.00,
                'comission_amount' => 4.00, 
                'category_id' => 3, 
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/speaker.png'
            ],

            [
                
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'quantity' => 10,
                'product_description' => 'Product 1',
                'manufacturer' => 'Manufacturer 1',
                'device' => 'Device 1',
                'sku' => 'SKU001',
                'upc_code' => 'UPC001',
                'is_barcode' => false,
                'valuation_method' => 'Method 1',
                'new_stock_adjustment' => 'Adjustment 1',
                'new_inventory_item_cost' => 50.00,
                'tax_class' => 'Class 1',
                'tax_inclusive' => false,
                'retail_price' => 100.00,
                'cost_price' => 80.00,
                'sale_price' => 90.00,
                'minimum_price' => 70.00,
                'on_hand_quantity' => 100,
                'stock_warning' => 20,
                're_order_level' => 30,
                'manage_serialized' => 'Yes',
                'condition' => 'New',
                'supplier' => 'Supplier 1',
                'physical_location' => 'Location 1',
                'warranty' => 1.5,
                'warranty_time_frame' => 'Year',
                'imei' => 'IMEI001',
                'display_on_point_of_sale' => 'Yes',
                'display_on_widget' => 'Yes',
                'comission_percentage' => 5.00,
                'comission_amount' => 4.00, 
                'category_id' => 3, 
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/autocard.png'
            ],

            [
                
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'quantity' => 10,
                'product_description' => 'Product 1',
                'manufacturer' => 'Manufacturer 1',
                'device' => 'Device 1',
                'sku' => 'SKU001',
                'upc_code' => 'UPC001',
                'is_barcode' => false,
                'valuation_method' => 'Method 1',
                'new_stock_adjustment' => 'Adjustment 1',
                'new_inventory_item_cost' => 50.00,
                'tax_class' => 'Class 1',
                'tax_inclusive' => false,
                'retail_price' => 100.00,
                'cost_price' => 80.00,
                'sale_price' => 90.00,
                'minimum_price' => 70.00,
                'on_hand_quantity' => 100,
                'stock_warning' => 20,
                're_order_level' => 30,
                'manage_serialized' => 'Yes',
                'condition' => 'New',
                'supplier' => 'Supplier 1',
                'physical_location' => 'Location 1',
                'warranty' => 1.5,
                'warranty_time_frame' => 'Year',
                'imei' => 'IMEI001',
                'display_on_point_of_sale' => 'Yes',
                'display_on_widget' => 'Yes',
                'comission_percentage' => 5.00,
                'comission_amount' => 4.00, 
                'category_id' => 3, 
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
        ]);

        $products->each(function ($product) {
            Product::create($product);
        });
    }
}
