<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UsersLog extends Model
{
    use HasFactory;
    protected $gaurded = ['id'];
    protected $table = 'users_log';
    protected $fillable = [
        'date',
        'time',
        'status',
        "user_id",
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
