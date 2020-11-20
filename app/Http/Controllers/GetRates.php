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
use App\wdmethods;
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
use App\Http\Traits\assetstrait;

class GetRates extends Controller
{
    use CPTrait, assetstrait;
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
    
    //Get any coin, any currency rate
     public function get_rate($coin,$currency,$option){
         //get rates
        return $this->get_rates($coin,$currency,$option);
     }

     //Get any coin, any currency rate AJAX
     public function getMarketPrice($asset){
         $asset_chars = str_split($asset,3);
         $base_pair = $asset_chars[0];
         $quote_pair = $asset_chars[1];

         $option = 'price';

        //get rates
       $price_data = $this->get_rates($base_pair,$quote_pair,$option);

       return response()->json(['status'=>200, 'data'=>$price_data, 'message'=>'Action successfully!']);
    }

}
