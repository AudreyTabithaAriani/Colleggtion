<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $fillable = [
        'base',
        'common',
        'uncommon',
        'rare',
        'superRare',
        'epic',
        'currency',
        'commission',
        'cooldown',
        'reset',
        'gameName',
        'gameIcon',
    ];

    protected $table = "system";
}
