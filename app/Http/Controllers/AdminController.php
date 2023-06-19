<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\System;
use App\Models\PlayerSession;

class AdminController extends Controller{
    public function index(){
        $system = System::latest()->first(); #1
        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session->player()->first()->role == "Admin") {
                return view("admin", [
                    "system" => $system,
                    "player" => $session->player()->first()
                ]);
            }
        }
        return view('login', ['system' => $system]);
    }
    public function handleForm(Request $request){
        $adminPassword = $request->input("password");
    }
}
