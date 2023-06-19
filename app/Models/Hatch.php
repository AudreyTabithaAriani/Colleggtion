<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hatch extends Model
{
    protected $fillable = [
        "user",
        "bought",
        "hatched"
    ];

    protected $table = 'hatches';

    public function user(){
        return $this->belongsTo(Player::class, 'user');
    }
    
    use HasFactory;
}
