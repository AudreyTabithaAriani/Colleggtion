<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\System;
use App\Models\PlayerSession;
use App\Models\Transaction;
use App\Models\Trade;
use App\Models\Deposit;
use App\Models\Withdraw;

use Illuminate\Support\MessageBag;

class TransactionController extends Controller
{
    //
    public function index(){
        $system = System::latest()->first();




        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){
                    $trades = Trade::all();

                    return view('transaction', [
                        'system' => $system,
                        'player' => $player,
                        'trades' => $trades,
                    ]);
                }
                
            }
        }
        
        return view('login', ['system' => $system]);
    
        
    }

    public function sellCoin(Request $request){
        $system = System::latest()->first();

        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){
                    $coins = $player->coins();

                    $validatedData = $request->validate([
                        'amount' => 'required|numeric|gt:0',
                        'price' => 'required|numeric|gt:0',
                    ]);

                    if ($validatedData['amount'] > $coins) {
                        return redirect()->back()->withErrors(['error' => 'You do not have enough '.$system->currency.' to sell.']);
                    }


                    $trade = Trade::create([
                        'user' => $player->id,
                        'coins' => $validatedData['amount'],
                        'price' => $validatedData['price'],
                    ]);

                    if($trade->user != $player->id){
                        return redirect()->back()->with('success', 'Your trade has been listed successfully.');    
                    } else {
                        return redirect()->back()->with('success', 'Your trade has been removed successfully.');
                    }
                    


                }
                
            }
        }
        
        return view('login', ['system' => $system]);

        
    }

    public function buyCoin(Request $request){
        $system = System::latest()->first();

        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){
                    $balance = $player->balance();

                    $trade = Trade::find($request->input("trade"));

                    if (!$trade) {
                        return redirect()->back()->with('error', 'Invalid trade ID');
                    }

                    if ($balance < $trade->price) {
                        return redirect()->back()->with('error', 'Insufficient balance');
                    }

                    $transaction = Transaction::create([
                        'user' => $player->id,
                        'seller' => $trade->user,
                        'coins' => $trade->coins,
                        'price' => $trade->price,
                    ]);

                    $trade->delete();



                    return redirect()->back()->with('success', $system->currency.' purchased successfully');

                }
                
            }
        }
        
        return view('login', ['system' => $system]);

        
    }

    public function deposit(Request $request){
        $system = System::latest()->first();

        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){

                    $validatedData = $request->validate([
                        'amount' => 'required|numeric|gt:0',
                    ]);

                    $deposit = Deposit::create([
                        'user' => $player->id,
                        'amount' => $validatedData['amount'],
                    ]);



                    return redirect()->back()->with('success', 'Deposit Successful!');



                }
                
            }
        }
        
        return view('login', ['system' => $system]);

        
    }

    public function withdraw(Request $request){
        $system = System::latest()->first();

        if (session()->exists("session")){
            $session = PlayerSession::where('session', session('session'))->first();
            if ($session) {
                $player = $session->player()->first();

                if ($player){
                    $balance = $player->balance();

                    $validatedData = $request->validate([
                        'amount' => 'required|numeric|gt:0',
                    ]);

                    if ($validatedData['amount'] > $balance) {
                        return redirect()->back()->withErrors(['error' => 'You do not have enough balance to withdraw.']);
                    }

                    $withdraw = Withdraw::create([
                        'user' => $player->id,
                        'amount' => $validatedData['amount'],
                    ]);



                    return redirect()->back()->with('success', 'Withdraw Successful!');



                }
                
            }
        }
        
        return view('login', ['system' => $system]);

        
    }
}
