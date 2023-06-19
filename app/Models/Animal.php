<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        "user",
        "image",
        "price",
        "rarity",
        "gene",
        "baseAnimal",
        "parentOne",
        "parentTwo"
    ];

    protected $casts = [
        "rarity" => "float",
    ];


    public function user(){
        return $this->belongsTo(Player::class, 'user');
    }

    public function base(){
        return $this->belongsTo(BaseAnimal::class, 'baseAnimal');
    }

    public function name(){
        return $this->base()->first()->name;
    }

    public function parentOne(){
        return $this->belongsTo(BaseAnimal::class, 'parentOne');
    }

    public function parentTwo(){
        return $this->belongsTo(BaseAnimal::class, 'parentTwo');
    }
    
    use HasFactory;
}
