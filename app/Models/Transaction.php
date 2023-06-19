<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "user",
        "seller",
        "coins",
        "price"

    ];

    public function user(){
        return $this->belongsTo(Player::class, 'user');

    }

    public function seller(){
        return $this->belongsTo(Player::class, 'seller');

    }

    use HasFactory;
}
