<?php

namespace App\Http\Controllers;

use App\settings;
use App\users;
use App\user_plans;
use App\plans;
use App\withdrawals;
use App\deposits;
use App\cp_transactions;
use App\tp_transactions;
use App\notifications;
use App\wdmethods;
use App\markets;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;

use App\Http\Traits\CPTrait;

class SomeController extends Controller
{
    use CPTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    

     //return settings form
    public function updatemarket(Request $request){

        $dp=new markets();
        $dp->current_pair= $request['market'];
        $dp->save();
        return data()->json(['success'=>'Market Changed']);
        
      // $mark=markets::where('id',1)->first();
      // $base=$mark->base_curr;
      // $quote=$mark->quote_curr;
      // //$dp->currency_pair= $request['market'];

      // markets::where('id', 1)
      //     ->update([
      //     'currency_pair'=> $request['market'],
      //     'base_curr' => 'BTC',
      //     'quote_curr'=> 'USD',

      //     ]);

      // return response()->json(['success'=>'Market Changed']);
    }

    public function selectmarket(Request $request){
      $market=markets::where('id',1)->first();
      $base=$market->base_curr;
      $quote=$market->quote_curr;
      return view('exchange')
          ->with(array(
          'base'=>$base,
          'quote' => $quote,
          ));
    }
}
