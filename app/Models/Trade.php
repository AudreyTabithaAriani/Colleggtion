<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'coins',
        'price'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'user');
    }
}
