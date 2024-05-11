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
		'name',
		'uuid',
		'user_id',
		'cost_price',
		'sale_price',
		'whole_sale_price',
		'created_at',
		'update_at',
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
		$query->where('products.name', 'like', "%{$value}%");
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
