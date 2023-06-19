<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System;

use Socialite;
use App\Models\Player;
use App\Models\PlayerSession;

class LoginController extends Controller
{
    //
    public function index(){

        $system = System::latest()->first();

        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                return redirect('');
            }
        }

        return view('login', ['system' => $system]);
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $name = $user->name;
            $email = $user->email;
            $profile = $user->avatar;
            $googleId = $user->id;


            // $findplayer = Player::where('googleId', $user->id)->first();
            $player = Player::where('email', $email)->first();

            if($player){
                // Set session
                $newSession = hash("sha256", $user->email.now());
                PlayerSession::create([
                    "player" => $player->id,
                    "session" => $newSession
                ]);
                session(["session" => $newSession]);

                return redirect('');
            }else {
                $newUser = Player::create([
                    'name' => $name,
                    'email' => $email,
                    'profile' => $profile,
                    'google_id'=> $googleId,

                ]);
                // Set session
                $newSession = hash("sha256", $user->email.now());
                PlayerSession::create([
                    "player" => $newUser->id,
                    "session" => $newSession
                ]);
                session(["session" => $newSession]);
                
                return redirect('');
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }

    }


    public function logout(){
        session()->flush();
        return redirect('');
    }
}
