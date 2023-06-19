<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\System;
use App\Models\PlayerSession;
use App\Models\Player;



class HomeController extends Controller
{
    public function index(){
        $system = System::latest()->first();


        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){
                    return view('home', [
                        'system' => $system,
                        'player' => $player
                    ]);
                }
                
            }
        }
        
        return view('landing', ['system' => $system]);
    
        
    }
}
