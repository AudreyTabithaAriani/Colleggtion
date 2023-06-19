<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Player;

class PlayerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'player',
        'session'
    ];

    protected $table = "playerSessions";

    public function player()
    {
        return $this->belongsTo(Player::class, "player");
    }
}
