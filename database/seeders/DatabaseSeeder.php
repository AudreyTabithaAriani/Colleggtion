<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Player;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\System;
use App\Models\BaseAnimal;
use App\Models\Animal;
use App\Models\Trade;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Player::create([
            'name' => 'System',
            'email' => 'system@yourapp.com',
            'password' => '', // Please replace this with the actual password
            'role' => 'Admin',
            'bio' => '',
            'profile' => '',
            'googleId' => '',
        ]);
        Player::create([
            'name' => 'RichAjiVEVO',
            'email' => 'msbumblebee1998@gmail.com',
            'password' => '', // Please replace this with the actual password
            'role' => 'Admin',
            'bio' => '',
            'profile' => 'https://lh3.googleusercontent.com/a/AAcHTte-APJ5gN09aflznLiARbzVE6W8H0PkPJVuOOge=s96-c',
            'googleId' => '',
        ]);
        Transaction::create([
            'user' => Player::find(2)->id,
            'seller' => Player::find(1)->id,
            'coins' => 10000,
            'price' => 10,
        ]);
        Trade::create([
            'user' => 1,
            'coins' => 10000,
            'price' => 500
        ]);
        Deposit::create([
            'user' => 2,
            'amount' => 1000000,
        ]);
        System::create([
            'base' => 100,
            #multiplier
            'common' => 1,
            'uncommon' => 1.5,
            'rare' => 2.5,
            'superRare' => 4,
            'epic' => 6,

            'currency' => 'Ruby',
            'currencyIcon' => 'img/icons/ruby.png',
            'commission' => 0.05,
            'cooldown' => 60,
            'reset' => 2,
            'gameName' => 'Colleggction',
            'gameIcon' => 'img/icons/logo.png',
        ]);
        BaseAnimal::create([
            'name' => "Rabbit",
            'folder' => "img/animals/rabbit",
            'rarity'=> 0.7,
            'base' => true,
            'gene' => "Rr"
        ]);
        BaseAnimal::create([
            'name' => "Penguin",
            'folder' => "img/animals/penguin",
            'rarity'=> 0.7,
            'base' => true,
            'gene' => "Pp"
        ]);
        BaseAnimal::create([
            'name' => "Alpaca",
            'folder' => "img/animals/alpaca",
            'rarity'=> 0.2,
            'base' => true,
            'gene' => "Aa"
        ]);
        BaseAnimal::create([
            'name' => "Panda",
            'folder' => "img/animals/panda",
            'rarity'=> 0.07,
            'base' => true,
            'gene' => "Dd"
        ]);
        BaseAnimal::create([
            'name' => "Pig",
            'folder' => "img/animals/pig",
            'rarity'=> 0.2,
            'base' => true,
            'gene' => "Gg"
        ]);
        BaseAnimal::create([
            'name' => "Lion",
            'folder' => "img/animals/lion",
            'rarity'=> 0.02,
            'base' => true,
            'gene' => "Ll"
        ]);
        BaseAnimal::create([
            'name' => "Cheetah",
            'folder' => "img/animals/cheetah",
            'rarity'=> 0.01,
            'base' => true,
            'gene' => "Cc"
        ]);
        BaseAnimal::create([
            'name' => "Alnguin",
            'folder' => "img/animals/alnguin",
            'gene' => "AP"
        ]);
        BaseAnimal::create([
            'name' => "Alpanda",
            'folder' => "img/animals/alpanda",
            'gene' => "AD"
        ]);
        BaseAnimal::create([
            'name' => "Chalpaca",
            'folder' => "img/animals/chalpaca",
            'gene' => "AC"
        ]);
        BaseAnimal::create([
            'name' => "Chanda",
            'folder' => "img/animals/chanda",
            'gene' => "CD"
        ]);
        BaseAnimal::create([
            'name' => "Chenguin",
            'folder' => "img/animals/chenguin",
            'gene' => "CP"
        ]);
        BaseAnimal::create([
            'name' => "Chion",
            'folder' => "img/animals/chion",
            'gene' => "CL"
        ]);
        BaseAnimal::create([
            'name' => "Chunny",
            'folder' => "img/animals/chunny",
            'gene' => "CR"
        ]);
        BaseAnimal::create([
            'name' => "Lalpaca",
            'folder' => "img/animals/lalpaca",
            'gene' => "AL"
        ]);
        BaseAnimal::create([
            'name' => "Landa",
            'folder' => "img/animals/landa",
            'gene' => "DL"
        ]);
        BaseAnimal::create([
            'name' => "Lenguin",
            'folder' => "img/animals/lenguin",
            'gene' => "LP"
        ]);
        BaseAnimal::create([
            'name' => "Palpaca",
            'folder' => "img/animals/palpaca",
            'gene' => "AG"
        ]);
        BaseAnimal::create([
            'name' => "Pandig",
            'folder' => "img/animals/pandig",
            'gene' => "DG"
        ]);
        BaseAnimal::create([
            'name' => "Panguin",
            'folder' => "img/animals/panguin",
            'gene' => "DP"
        ]);
        BaseAnimal::create([
            'name' => "Peetah",
            'folder' => "img/animals/peetah",
            'gene' => "CG"
        ]);
        BaseAnimal::create([
            'name' => "Piguin",
            'folder' => "img/animals/piguin",
            'gene' => "GP"
        ]);
        BaseAnimal::create([
            'name' => "Pion",
            'folder' => "img/animals/pion",
            'gene' => "DL"
        ]);
        BaseAnimal::create([
            'name' => "Punny",
            'folder' => "img/animals/punny",
            'gene' => "GR"
        ]);
        BaseAnimal::create([
            'name' => "Randa",
            'folder' => "img/animals/randa",
            'gene' => "DR"
        ]);
        BaseAnimal::create([
            'name' => "Ranguin",
            'folder' => "img/animals/ranguin",
            'gene' => "PR"
        ]);
        BaseAnimal::create([
            'name' => "Rapaca",
            'folder' => "img/animals/rapaca",
            'gene' => "AR"
        ]);
        BaseAnimal::create([
            'name' => "Rion",
            'folder' => "img/animals/rion",
            'gene' => "LR"
        ]);
    }
}
