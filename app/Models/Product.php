<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
	protected $fillable = [
		'category',
		'sub_category',
		'name',
		'uuid',
		'user_id',
		'product_description',
		'quantity',
		'price',
		'category_id',
		'created_at',
		'slug',
		'update_at',
		// 'manufacturer',
		// 'device',
		// 'sku',
		// 'upc_code',
		// 'is_barcode',
		// 'valuation_method',
		// 'new_stock_adjustment',
		// 'new_inventory_item_cost',
		// 'tax_class',
		// 'tax_inclusive',
		// 'retail_price',
		// 'cost_price',
		// 'sale_price',
		// 'minimum_price',
		// 'on_hand_quantity',
		// 'stock_warning',
		// 're_order_level',
		// 'manage_serialized',
		// 'condition',
		// 'device_id',
		// 'product_image',
		// 'supplier',
		// 'physical_location',
		// 'warranty',
		// 'warranty_time_frame',
		// 'imei',
		// 'display_on_point_of_sale',
		// 'display_on_widget',
		// 'comission_percentage',
		// 'comission_amount',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'tax_type' => TaxType::class
	];

	public function getRouteKeyName(): string
	{
		return 'slug';
	}

	public function category_id(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
	public function device_id(): BelongsTo
	{
		return $this->belongsTo(Device::class);
	}

	public function scopeSearch($query, $value): void
	{
		$query->where('products.name', 'like', "%{$value}%")
			->orWhere('products.category_id', 'like', "%{$value}%");
	}
	/**
	 * Get the user that owns the Category
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
