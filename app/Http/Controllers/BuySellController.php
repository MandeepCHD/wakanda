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
use App\assets;
use App\balances;
use App\orders;
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

class BuySellController extends Controller
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

    public function index(){
        //return view('trade.exchange');
        return view('trade.exchange')
          ->with(array(
          //'earnings'=>$earnings,
          'markets' => markets::orderby('id','desc')->where('market','Cryptocurrency')->get(),
          'orders'=>orders::orderby('id','desc')->where('user',Auth::user()->id)->get(),
          'n_orders'=>orders::orderby('id','desc')->where('user',Auth::user()->id)->get(),
          'balances'=>balances::orderby('id','desc')->where('user',Auth::user()->id)->get(),
          'bals'=>balances::orderby('id','desc')->where('user',Auth::user()->id)->get(),
          'cryptopairs' =>markets::orderby('id','desc')->where('market','Cryptocurrency')->get(),
          'title'=>'Live Trading',
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }

    public function updatemarket(Request $request){
        //split the currency pair into unit currency
        $pairs = explode('/',$request->market);
        //save pairs in session
        $request->session()->put('base_c', $pairs[0]);
        $request->session()->put('quote_c', $pairs[1]);
        
        return response()->json(['success'=>'Market Changed']);
    }

    public function exchange(Request $request){

        //get settings
        $settings=settings::where('id','1')->first();

        //split the currency pair into unit currency
        $asset_chars = str_split($request->market_pair,3);
        $base_pair = $asset_chars[0];
        $quote_pair = $asset_chars[1];

        // $pairs = explode('/',$request->market_pair);
        // $base_pair = $pairs[0];
        // $quote_pair = $pairs[1];

        if($request->type=="Buy"){
            //check if the user quote currency balance can cover the order
            //get balance
           $q_bal=balances::where('user',Auth::user()->id)->where('wallet',$quote_pair)->first();

           //calculate amount and fees
           if($settings->commission_type=="Percentage"){
            $amount_plus_fees = $request->quote_amount + (($request->quote_amount * $settings->commission_fee)/100);
           }else{
            $amount_plus_fees = $request->quote_amount + $settings->commission_fee;
           }

           if($q_bal){
            $u_bal = $q_bal->balance;
           }
           elseif($quote_pair == "$settings->s_currency"){
            $u_bal = auth::user()->account_bal;
           }
           else{
            return response()->json(['status'=>203, 'message'=>'Unable to perform operation!']);
           } 

           //check if user balance is sufficient for the operation
           if($u_bal < $amount_plus_fees){
                //redirect to make deposit
                return response()->json(['status'=>201, 'message'=>'Your account is insufficient to perform this operation.']);
            }

            //get base wallet
           $b_w=balances::where('user',Auth::user()->id)->where('wallet',$base_pair)->first();
           if(!$b_w){
                //create wallet and credit wallet
                $wallet=new balances();
                $wallet->user = Auth::user()->id;
                $wallet->wallet = $base_pair;
                $wallet->balance = $request->base_amount;
                $wallet->save();
            
           }else{
               //credit wallet
               balances::where('id', $b_w->id)
               ->update([
               'balance'=> $b_w->balance+$request->base_amount,
               ]);
           }

           //debit quote wallet
           if($q_bal){
           balances::where('id', $q_bal->id)
            ->update([
            'balance'=> $u_bal - $amount_plus_fees,
            ]);
           }else{
            users::where('id', auth::user()->id)
            ->update([
            'account_bal'=> $u_bal - $amount_plus_fees,
            ]);
           }


        }else{//if it is a sell order

            //calculate amount and fees
           if($settings->commission_type=="Percentage"){
            $amount_plus_fees = $request->base_amount + (($request->base_amount * $settings->commission_fee)/100);
           }else{
            $amount_plus_fees = $request->base_amount + $settings->commission_fee;
           }

            //check if the user base currency balance can cover the order
            //get balance
           $b_bal=balances::where('user',Auth::user()->id)->where('wallet',$base_pair)->first();

           if($b_bal){
            $u_bal = $b_bal->balance;
           }
           elseif($base_pair == "$settings->s_currency"){
            $u_bal = auth::user()->account_bal;
           }
           else{
            return response()->json(['status'=>203, 'message'=>'Unable to perform operation!']);
           }

           //get quote wallet
           $q_w=balances::where('user',Auth::user()->id)->where('wallet',$quote_pair)->first();
           
           if($q_w){
            //credit wallet
            balances::where('id', $q_w->id)
            ->update([
            'balance'=> $q_w->balance+$request->quote_amount,
            ]);
           }
           elseif($quote_pair == "$settings->s_currency"){
               //credit wallet
               users::where('id', auth::user()->id)
               ->update([
               'account_bal'=> $u_bal+$request->quote_amount,
               ]);
            
           }else{
               //create wallet and credit wallet
                $wallet=new balances();
                $wallet->user = Auth::user()->id;
                $wallet->wallet = $quote_pair;
                $wallet->balance = $request->quote_amount;
                $wallet->save();
           }

           //debit base wallet
           if($b_bal){
           balances::where('id', $b_bal->id)
            ->update([
            'balance'=> $b_bal->balance-$amount_plus_fees,
            ]);
           }else{
            users::where('id', auth::user()->id)
            ->update([
            'balance'=> $u_bal-$amount_plus_fees,
            ]);
           }

        }

        $order=new orders();
        $order->type= $request->type;
        $order->user= Auth::user()->id;
        $order->base_amount= $request->base_amount;
        $order->quote_amount= $request->quote_amount;
        $order->base_c= $base_pair;
        $order->quote_c= $quote_pair;
        $order->status= "active";
        $order->save();
        
        return response()->json(['status'=>200, 'message'=>'Order placed successfully!']);
    }

    public function closeorder($id){
        //get settings
        $settings=settings::where('id','1')->first();
        //get the order details
        $order=orders::where('id',$id)->first();
        
        //get order value with current rate 
        $price = round($this->get_rates($order->base_c,$order->quote_c,"price"),6);
        //$close_price = $order->base_amount/$price;
        $new_b_amount = $order->quote_amount/$price;
        $new_q_amount = $order->base_amount*$price;

       if($order->type=="Buy"){
            //get balance
            $b_bal=balances::where('user',Auth::user()->id)->where('wallet',$order->base_c)->first();
            $q_bal=balances::where('user',Auth::user()->id)->where('wallet',$order->quote_c)->first();
            if(count($b_bal)==1){
                //debit this user base wallet with new amount
                balances::where('id', $b_bal->id)
                ->update([
                'balance'=> $b_bal->balance-$order->base_amount,
                ]);

                //credit the quote wallet with new amount
                balances::where('id', $q_bal->id)
                ->update([
                'balance'=> $q_bal->balance+$new_q_amount,
                ]);

            }else{
                return response()->json(['status'=>202, 'message'=>'Something went wrong!']);
            }
       }else{
           //get balance
           $q_bal=balances::where('user',Auth::user()->id)->where('wallet',$order->quote_c)->first();
           $b_bal=balances::where('user',Auth::user()->id)->where('wallet',$order->base_c)->first();
           if(count($q_bal)==1){
               //debit this user quote wallet with new amount
               balances::where('id', $q_bal->id)
               ->update([
               'balance'=> $q_bal->balance-$order->quote_amount,
               ]);

               //credit the base wallet with new amount
               balances::where('id', $b_bal->id)
               ->update([
               'balance'=> $b_bal->balance+$new_b_amount,
               ]);
           }else{
            return response()->json(['status'=>202, 'message'=>'Something went wrong!']);
           }

       }

        //mark order closed
        orders::where('id', $id)
        ->update([
        'status'=>'closed',
        'closed_amount' => $new_q_amount,
        //'p_l' => $new_amount,
        'closed_at' => \Carbon\Carbon::Now(), 
        ]);

        return response()->json(['status'=>200, 'message'=>'Order closed successfully!']);
    }

     //Internal transfer
     public function fundtransfer(Request $request){
        if($request->send_from == $request->send_to){
            return redirect()->back()->with('message','Both wallets must be different');
        }

         if($request->send_from == "Trading balance"){
            //get the trading USD balance
            $bal = $this->get_bal(Auth::user()->id,"USD");
            if($bal < $request->amount){
                return redirect()->back()->with('message','Insufficient funds in sending wallet');
            }
            //debit sending wallet and credit recieving wallet
            $dbt=$this->debit_wallet(Auth::user()->id,"USD",$request->amount);
            if($dbt != "OK"){
                return redirect()->back()->with('message','Something went wrong!');
            }
            //credit recieving wallet
            users::where('id',Auth::user()->id)->update([
                'account_bal' => Auth::user()->account_bal + $request->amount,
            ]);

         }else{
            if(Auth::user()->account_bal < $request->amount){
                return redirect()->back()->with('message','Insufficient funds in sending wallet');
            }
            //debit sending wallet
            users::where('id',Auth::user()->id)->update([
                'account_bal' => Auth::user()->account_bal - $request->amount,
            ]);
            
            //check if trading wallet exists
            $t_w=balances::where('user',Auth::user()->id)->where('wallet','USD')->first();
            if(!$t_w){
                    //create wallet
                    $wallet=new balances();
                    $wallet->user = Auth::user()->id;
                    $wallet->wallet = 'USD';
                    $wallet->save();
            }

            //Credit recieving wallet
            $cdt=$this->credit_wallet(Auth::user()->id,"USD",$request->amount);
            if($cdt != "OK"){
                return redirect()->back()->with('message','Something went wrong!');
            }
         }

         return redirect()->back()->with('message','Operation successful!');
    }

    //switch color
    public function switchcolor($color){
        //switch color
        users::where('id', Auth::user()->id)
        ->update([
        'dashboard_style'=>$color,
        ]);

        return response()->json(['status'=>200, 'message'=>'Color changed successfully!']);
    }

     //switch color
     public function switchautotrade($auto){
        //switch autotrade
        
        users::where('id', Auth::user()->id)
        ->update([
        'auto_trade'=>$auto,
        ]);

        $settings=settings::where('id', '=', '1')->first();
        //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "This is to inform you that ".Auth::user()->name.' '. Auth::user()->l_name. " has turned $auto auto trade.";
        $objDemo->sender = $settings->site_name;
        $objDemo->subject ="Auto Trade Status";
        $objDemo->date = \Carbon\Carbon::Now();
        Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));

        return response()->json(['status'=>200, 'message'=>"Auto Trade successfully turned $auto!"]);
    }

    public function get_bal($user,$wallet){
        //fetch balance
        $wallet = balances::where('user',$user)->where('wallet',$wallet)->first();
        //return balance
        return $wallet->balance;
    }

    public function debit_wallet($user,$wallet,$amount){
        $wallet = balances::where('user',$user)->where('wallet',$wallet)->first();
        balances::where('id',$wallet->id)->update([
            'balance' => $wallet->balance - $amount, 
        ]);

        return "OK";
    }

    public function credit_wallet($user,$wallet,$amount){
        $wallet = balances::where('user',$user)->where('wallet',$wallet)->first();
        balances::where('id',$wallet->id)->update([
            'balance' => $wallet->balance + $amount, 
        ]);

        return "OK";
    }

    public function getAssets($market){
        $MarketAssets = '';
        //get asset
        $assets = assets::where('category',$market)->get();
        foreach($assets as $asset){
            $MarketAssets .= "<option>$asset->symbol</option>";
        }

        return $MarketAssets;
    }

    public function getTradeAssets(Request $request, $market){
        //save chart market
       // $request->session()->forget('chart_market');
       // $request->session()->put('chart_market', 'FX');

        if($market=="Forex"){
            $chart_market="FX";
        }
        elseif($market=="Stock"){
            $chart_market="NASDAQ";
        }
        elseif($market=="CFD"){
            $chart_market="TVC";
        }
        elseif($market=="Indices"){
            $chart_market="CURRENCYCOM";
        }
        elseif($market=="Cryptocurrency"){
            $chart_market="COINBASE";
        }

        $MarketAssets = '';
        //get asset
        $assets = markets::where('market',$market)->get();
        foreach($assets as $asset){
            $MarketAssets .= "<div><a href='javascript:void(0)' onclick='getMarketAsset(this)' id='$chart_market:'>$asset->base_curr$asset->quote_curr</a></div>";
        }

        return response()->json(['status'=>200, 'data'=>$MarketAssets, 'message'=>'Action successfully!']);
    }



    
    public function addbuyorder(Request $request){

        //check if the user account balance can buy this plan
        // if(Auth::user()->account_bal < $request->amount){
        //     //redirect to make deposit
        //     return response()->json(['status'=>201, 'message'=>'Your account is insufficient to perform this investment.']);
        // }

        // users::where('id', Auth::user()->id)
        // ->update([
        // 'account_bal'=>Auth::user()->account_bal - $request->amount ,
        // ]);

        $buy = new orders();
        $buy->user= Auth::user()->id;
        $buy->order_type= substr(md5(time()), 0, 5);
        $buy->orders=$request->amount;
        $buy->type=$request->type;
        $buy->market=$request->market;
        $buy->status="Buy";
        $buy->symbol=$request->symbol;
        $buy->stoploss=$request->stoploss;
        $buy->takeprofit=$request->takeprofit;
        $buy->comment=$request->comment;
        $buy->save();


        $settings=settings::where('id', '=', '1')->first();
        $user=users::where('id',Auth::user()->id)->first();
         //send email notification
         $objDemo = new \stdClass();
         $objDemo->message = "This is to inform you that  $user->name $user->l_name has successfully place a buy order Amount: $settings->currency$request->amount.";
         $objDemo->sender = $settings->site_name;
         $objDemo->date = \Carbon\Carbon::Now();
         $objDemo->subject ="Successful Buy Order";
         Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));
        //return redirect()->back()->with('message','Operation successful!');
        return response()->json(['status'=>200, 'message'=>'Order Opened Successfully!']);
    }


    public function addsellorder(Request $request){

        //check if the user account balance can buy this plan
        // if(Auth::user()->account_bal < $request->amount){
        //     //redirect to make deposit
        //     return response()->json(['status'=>201, 'message'=>'Your account is insufficient to perform this investment.']);
        // }

        // users::where('id', Auth::user()->id)
        // ->update([
        // 'account_bal'=>Auth::user()->account_bal - $request->amount ,
        // ]);

        $buy = new orders();
        $buy->user= Auth::user()->id;
        $buy->order_type= substr(md5(time()), 0, 5);
        $buy->orders=$request->amount;
        $buy->type=$request->type;
        $buy->market=$request->market;
        $buy->status="Sell";
        $buy->symbol=$request->symbol;
        $buy->stoploss=$request->stoploss;
        $buy->takeprofit=$request->takeprofit;
        $buy->comment=$request->comment;
        $buy->save();

        $settings=settings::where('id', '=', '1')->first();
        $user=users::where('id',Auth::user()->id)->first();
         //send email notification
         $objDemo = new \stdClass();
         $objDemo->message = "This is to inform you that $user->name $user->l_name has successfully place a Sell order Amount: $settings->currency$request->amount.";
         $objDemo->sender = $settings->site_name;
         $objDemo->date = \Carbon\Carbon::Now();
         $objDemo->subject ="Successful Sell Order";
         Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));
        //return redirect()->back()->with('message','Operation successful!');
        return response()->json(['status'=>200, 'message'=>'Order Opened Successfully!']);
    }

     //get open investment p/l
     public function getUserOpenPL($user){
        
        //get settings
        $settings=settings::where('id','1')->first();
        
        //get single investment p/l
        //get the investment details
        $inv=orders::where('user',$user)
        ->where('status','active')->get();
        
        $s_p_l = 0;
        foreach($inv as $inv){
        //get investment value with current rate 
        $price = round($this->get_rates($inv->base_c,$inv->quote_c,"price"),6);
        $new_amount = ($inv->open_price*$price)-$inv->amount;
       
         $s_p_l += $new_amount;
        }
       
        return number_format($s_p_l,'4','.',','); 
        
    }

    //get open orders
    public function openOrders($user){
        
        //get settings
        $settings=settings::where('id','1')->first();
        
        $orders = '';
        //get orders
        $o_orders = orders::where('users',auth::user()->id)->where('status','active')->get();
        foreach($o_orders as $o_order){
            $orders .= "<option>$o_order->symbol</option>";
        }

        return $orders;
        
    }

    //get closed orders
    public function closedOrders($user){
        
        //get settings
        $settings=settings::where('id','1')->first();
        
        $orders = '';
        //get orders
        $c_orders = orders::where('users',auth::user()->id)->where('status','closed')->get();
        foreach($c_orders as $c_order){
            $orders .= "<option>$c_order->symbol</option>";
        }

        return $orders;
        
    }
}
