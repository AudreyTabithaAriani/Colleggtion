<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseAnimal extends Model
{
    protected $fillable = [
        'name',
        'folder',
        // 'price',
        'rarity',
        'base',
        'gene'
    ];

    protected $table = "baseAnimals";


    protected $casts = [
        "rarity" => "float",
    ];

    public function animals(){
        return $this->hasMany(Animal::class, 'baseAnimal');
    }

    
    use HasFactory;
}
