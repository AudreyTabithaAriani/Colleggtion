<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction;
use App\Models\System;
use App\Models\PlayerSession;
use App\Models\Hatch;
use App\Models\BaseAnimal;
use App\Models\Animal;

class AnimalController extends Controller{
    public function buyEgg(Request $request){
        $system = System::latest()->first();
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();
                if ($player){
                    $eggPrice = $player->eggPrice();
                    $coins = $player->coins();
                    if ($coins < $eggPrice) {
                        return redirect()->back()->withErrors(['error' => 'Not enough '.$system->currency.' to buy egg.']);
                    }
                    $transaction = Transaction::create([
                        'user' => 1,
                        'seller' => $player->id,
                        'coins' => $eggPrice,
                        'price' => 0,
                    ]);
                    $player->cooldownBuy++;
                    $player->save();
                    $hatch = Hatch::create([
                        'user' => $player->id,
                        'bought' => now(),
                    ]);
                    return redirect()->back()->with('success', 'Egg purchased successfully');
                }
            }
        }
        return view('login', ['system' => $system]);
    }
    public function hatch(Request $request){
        $system = System::latest()->first();
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();
                if ($player){
                    $eggId = $request->input("egg");
                    $egg = Hatch::where('id', $eggId)->where('user', $player->id)->where('hatched', false)->first();
                    if (!$egg) {
                        return redirect()->back()->withErrors(['error' => 'The selected egg does not exist or has already hatched.']);
                    }
                    $baseAnimals = BaseAnimal::where('base', true)
                             ->whereNotNull('rarity')
                             ->inRandomOrder()
                             ->get();
                    $totalRarity = $baseAnimals->sum('rarity');
                    $rand = mt_rand(1, $totalRarity);
                    $cumulativeRarity = 0;
                    foreach ($baseAnimals as $baseAnimal) {
                        $cumulativeRarity += $baseAnimal->rarity;
                        if ($rand <= $cumulativeRarity) {
                            // create a new animal with the selected base animal
                            $files = glob($baseAnimal->folder.'/*.*');
                            if ($baseAnimal->rarity <= 0.7){
                                $price = $system->base * $system->common;
                            } elseif ($baseAnimal->rarity <= 0.2){
                                $price = $system->base * $system->uncommon;
                            } elseif ($baseAnimal->rarity <= 0.07){
                                $price = $system->base * $system->rare;
                            } elseif ($baseAnimal->rarity <= 0.02){
                                $price = $system->base * $system->superRare;
                            } elseif ($baseAnimal->rarity <= 0.01){
                                $price = $system->base * $system->epic;
                            }
                            $animal = Animal::create([
                                'user' => $player->id,
                                'image' => $files[array_rand($files)],
                                'price' => $price,
                                'rarity' => $baseAnimal->rarity,
                                'gene' => $baseAnimal->gene ,
                                'baseAnimal' => $baseAnimal->id,
                            ]);
                            break;
                        }
                    }
                    $egg->hatched = true;
                    $egg->save();
                    return redirect()->back()->with('success', 'The egg has hatched successfully.');
                }
            }
        }
        return view('login', ['system' => $system]);
    }
    public function burn(Request $request){
        $system = System::latest()->first();
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();
                if ($player){
                    $animalId = $request->input("animal");
                    $animal = Animal::where('id', $animalId)->where('user', $player->id)->first();
                    if (!$animal) {
                        return redirect()->back()->withErrors(['error' => 'The selected animal does not exist or doesn\'t belong to you.']);
                    }
                    $price = $animal->price;
                    $transaction = Transaction::create([
                        'user' => $player->id,
                        'seller' => 1,
                        'coins' => $price,
                        'price' => 0,
                    ]);
                    $animal->user = 1;
                    $animal->save();
                    return redirect()->back()->with('success', 'The animal has been burned. '.$price.' has been added to your account.');
                }
            }
        }
        return view('login', ['system' => $system]);
    }
    public function breedIndex(){
        $system = System::latest()->first();
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();
                if ($player){
                    return view('breed', [
                        'system' => $system,
                        'player' => $player
                    ]);
                }
            }
        }
        return view('login', ['system' => $system]);
    }
    public function breed(Request $request){
        $system = System::latest()->first();
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();
                if ($player){
                    if($request->has('confirmBreed')){
                        $validator = Validator::make($request->all(), [
                            'animalOne' => 'required|exists:animals,id',
                            'animalTwo' => 'required|exists:animals,id',
                        ]);
                        if ($validator->fails()) {
                            return redirect()->back()->withErrors($validator);
                        }
                        $animalOne = Animal::find($request->input("animalOne"));
                        $animalTwo = Animal::find($request->input("animalTwo"));
                        $seed = random_int(1, 4);
                        if ($seed == 1){
                            $rarity = max([$animalOne->rarity, $animalTwo->rarity]);
                        } elseif ($seed == 4){
                            $rarity = min([$animalOne->rarity, $animalTwo->rarity]);
                        } else {
                            $rarity = ($animalOne->rarity + $animalTwo->rarity)/2;
                        }
                        $gene = substr($animalOne->gene, rand(0, strlen($animalOne->gene) - 1), 1).substr($animalTwo->gene, rand(0, strlen($animalTwo->gene) - 1), 1);
                        $price = $animalOne->price + $animalTwo->price;
                        $first_letter_upper = ctype_upper(substr($gene, 0, 1));
                        $second_letter_upper = ctype_upper(substr($gene, 1, 1));
                        if ($first_letter_upper && $second_letter_upper) {
                            $capitalized_letters = $gene;
                        } elseif ($first_letter_upper) {
                            $capitalized_letters = substr($gene, 0, 1);
                        } elseif ($second_letter_upper) {
                            $capitalized_letters = substr($gene, 1, 1);
                        } else {
                            $capitalized_letters = $gene;
                        }
                        if (strlen($capitalized_letters) == 1){
                            $base = DB::table('baseAnimals')->where('gene', '=', $capitalized_letters.strtolower($capitalized_letters))->first();
                        } else {
                            $base = DB::table('baseAnimals')->where('gene', '=', $capitalized_letters)
                            ->orWhere('gene', '=', strrev($capitalized_letters))
                            ->first();
                        }
                        $files = glob($base->folder.'/*.*');
                        $animal = Animal::create([
                            'user' => $player->id,
                            'image' => $files[array_rand($files)],
                            'price' => $price,
                            'rarity' => $rarity,
                            'gene' => $gene,
                            'baseAnimal' => $base->id,
                        ]);
                        $animalOne->user = 1;
                        $animalOne->save();
                        $animalTwo->user = 1;
                        $animalTwo->save();
                        return redirect("");
                    }elseif ($request->has('animalOne') && $request->has('animalTwo')){
                        return view('breed', [
                            'system' => $system,
                            'player' => $player,
                            'animalOne' => $request->input("animalOne"),
                            'animalTwo' => $request->input("animalTwo")
                        ]);
                    }elseif($request->has('animalOne')){
                        return view('breed', [
                            'system' => $system,
                            'player' => $player,
                            'animalOne' => $request->input("animalOne"),
                        ]);
                    }elseif($request->has('animalTwo')){
                        return view('breed', [
                            'system' => $system,
                            'player' => $player,
                            'animalOne' => $request->input("animalTwo"),
                        ]);
                    } else {
                        return view('breed', [
                            'system' => $system,
                            'player' => $player
                        ]);
                    }
                }
            }
        }
        return view('login', ['system' => $system]);
    }
}
