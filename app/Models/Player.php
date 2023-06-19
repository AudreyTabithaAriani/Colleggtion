<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\System;


class Player extends Model
{
    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
        "bio",
        "profile",
        "cooldownBuy",
        "cooldownBreed",
        "googleId"

    ];

    public function eggs(){
        return $this->hasMany(Hatch::class, 'user');
    }

    public function unhatchedEggs(){
        return $this->eggs()->where('hatched', false)->get();
    }

    public function coinBuys(){
        return $this->hasMany(Transaction::class, 'user');
    }

    public function coinSells(){
        return $this->hasMany(Transaction::class, 'seller');
    }

    public function coins()
    {
        $coinBuys = $this->coinBuys()->sum('coins');
        $coinSells = $this->coinSells()->sum('coins');
        return $coinBuys - $coinSells;
    }

    public function deposits(){
        return $this->hasMany(Deposit::class, 'user');
    }

    public function withdraws(){
        return $this->hasMany(Withdraw::class, 'user');
    }

    public function balance()
    {
        $deposits = $this->deposits()->sum('amount');
        $withdraws = $this->withdraws()->sum('amount');
        $coinBuys = $this->coinBuys()->sum('price');
        $coinSells = $this->coinSells()->sum('price');
        return $deposits - $withdraws - $coinBuys + $coinSells;
    }

    public function trades()
    {
        return $this->hasMany(Trade::class, 'user');
    }

    public function eggPrice(){
        $system = System::latest()->first();

        $cooldown = $system->cooldown;
        $resetPrice = $system->reset;
        $basePrice = $system->base;

        if ($this->cooldownBuy > 0){
            //How long the cooldown is
            $cooldownTime = $this->cooldownBuy * $cooldown;
            $timeSinceLastBuy = now()->diffInMinutes($this->lastBuyTime());

            if ($timeSinceLastBuy < $cooldownTime) {
                // If the player is still in their cooldown period, calculate the price based on the reset price
                $timeRemaining = $cooldownTime - $timeSinceLastBuy;
                $price = $basePrice + $timeRemaining * $resetPrice;
            } else {
                // If the player is not in their cooldown period, calculate the price based on the base price
                $price = $basePrice;
            }

        return $price;
        } else {
            return $basePrice;
        }

        
    }

    public function lastBuyTime()
    {
        // Get the timestamp of the player's last egg purchase
        $lastBuy = $this->eggs()->where('hatched', false)->orderByDesc('bought')->first();

        if (!$lastBuy) {
            // If the player has never bought an egg, return the current time
            return now();
        }

        return $lastBuy->bought;
    }

    // public function buyCooldown(){
    //     $system = System::latest()->first();

    //     $cooldown = $system->cooldown;
    //     return $this->Carbon::parse(lastBuyTime())->addMinutes($this->cooldownBuy * $cooldown);
    // }

    public function breedPrice(){
        $system = System::latest()->first();

        $cooldown = $system->cooldown;
        $resetPrice = $system->reset;

        if ($this->cooldownBreed > 0){
            //How long the cooldown is
            $cooldownTime = $this->cooldownBreed * $cooldown;
            $timeSinceLastBreed = $currentTime->diffInMinutes($this->lastBreedTime());

            if ($timeSinceLastBreed < $cooldownTime) {
                
                $timeRemaining = $cooldownTime - $timeSinceLastBreed;
                $price = $timeRemaining * $resetPrice;
            } else {
                
                $price = 0;
            }

        return $price;
        } else {
            return 0;
        }

        
    }

    public function lastBreedTime()
    {
        // Get the timestamp of the player's last egg purchase
        $lastBuy = $this->animals()->orderByDesc('bought')->first();

        if (!$lastBuy) {
            // If the player has never bought an egg, return the current time
            return now();
        }

        return $lastBuy->created_at;
    }



    public function animals(){
        return $this->hasMany(Animal::class, 'user');
    }

    public function owned(){
        return $this->animals()->get();
    }

    public function sessions(){
        return $this->hasMany(PlayerSession::class, 'player');
    }


    use HasFactory;
}
