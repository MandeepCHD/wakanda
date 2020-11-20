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
use App\balances;
use App\orders;
use App\assets;
use App\investments;
use App\investment_packs;
use App\user_packs;
use App\fees;
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

class InvestmentsController extends Controller
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

     //return investment page
    public function investpage() {
        return view('invest.invest')
        ->with(array(
        'title'=>'Invest',
        'assets' => assets::all(),
        'investments' => investments::where('user',auth::user()->id)->get(),
        'mix_packs' => investment_packs::where('status','active')->get(),
        'user_packs' => user_packs::where('user',auth::user()->id)->get(),
        'settings' => settings::where('id', '=', '1')->first(),
        ));
    }

    public function invest(Request $request){

        //check if the user account balance can buy this plan
        if(Auth::user()->account_bal < $request->amount){
            //redirect to make deposit
            return response()->json(['status'=>201, 'message'=>'Your account is insufficient to perform this investment.']);
        }

        //debit user
        $setup_fee = settings::where('id', '=', '1')->first();
        $commission = $setup_fee->commission_fee;
        $total_amount = $request->amount + $commission;

        users::where('id', Auth::user()->id)
        ->update([
        'account_bal'=>Auth::user()->account_bal - $total_amount ,
        ]);

        $invfee = new fees();
        $invfee->user_id= Auth::user()->id;
        $invfee->last_fee=$request->amount;
        $invfee->save();

        $inv=new investments();
        $inv->asset= $request->asset;
        $inv->user= Auth::user()->id;
        $inv->amount= $request->amount;
        $inv->open_price= $request->amount2;
        $inv->status= 'active';
        $inv->save();

        return response()->json(['status'=>200, 'message'=>'Investment opened successfully!']);
    }
    public function manageinvestment() {
        return view('invest.minvesments')
        ->with(array(
        'title'=>'Manage Investments',
        // 'assets' => assets::all(),
        'investments' => investments::all(),
        // 'mix_packs' => investment_packs::where('status','active')->get(),
        // 'user_packs' => user_packs::where('user',auth::user()->id)->get(),
        'settings' => settings::where('id', '=', '1')->first(),
        ));
    }

    public function closeinvestment($id){
        //get settings
        $settings=settings::where('id','1')->first();
        //get the investment details
        $inv=investments::where('id',$id)->first();
        
        //get investment value with current rate 
        $price = round($this->get_rates($inv->asset,$settings->s_currency,"price"),6);
        $close_price = $inv->amount/$price;
        $new_amount = $inv->open_price*$price;
       // return $new_amount;


        //mark investment closed
        investments::where('id', $id)
        ->update([
        'status'=>'closed',
        'close_price' => $close_price,
        'p_l' => $new_amount,
        'closed_at' => \Carbon\Carbon::Now(), 
        ]);

        //credit user with new amount
        users::where('id', auth::user()->id)
        ->update([
        'account_bal'=> auth::user()->account_bal+$new_amount,
        ]);

        return redirect()->back()->with('message','Investment closed');
    }

    public function investmentrecord(Request $request){
        
    }

    //Investment packs route
    public function packs()
    {
    	return view('invest.packs')
        ->with(array(
        'title'=>'Investment mix packs',
        'plans'=> investment_packs::where('status', 'active')->orderby('created_at','ASC')->get(),
        'settings' => settings::where('id','1')->first(),
        ));
    }

    //Add pack requests
    public function addpack(Request $request){
       
        $pack=new investment_packs();
  
        $pack->name = $request->name;
        $pack->price = $request->price;
        $pack->duration = $request->duration;
        $pack->cur_1 = $request->cur_1;
        $pack->share_1 = $request->share_1;
        $pack->cur_2 = $request->cur_2;
        $pack->share_2 = $request->share_2;
        $pack->cur_3 = $request->cur_3;
        $pack->share_3 = $request->share_3;
        $pack->cur_4 = $request->cur_4;
        $pack->share_4 = $request->share_4;
        $pack->cur_5 = $request->cur_5;
        $pack->share_5 = $request->share_5;
        $pack->cur_6 = $request->cur_6;
        $pack->share_6 = $request->share_6;
        $pack->cur_7 = $request->cur_7;
        $pack->share_7 = $request->share_7;
        $pack->cur_8 = $request->cur_8;
        $pack->share_8 = $request->share_8;
        $pack->cur_9 = $request->cur_9;
        $pack->share_9 = $request->share_9;
        $pack->cur_10 = $request->cur_10;
        $pack->share_10 = $request->share_10;
        $pack->cur_11 = $request->cur_11;
        $pack->share_11 = $request->share_11;
        $pack->cur_12 = $request->cur_12;
        $pack->share_12 = $request->share_12;
        $pack->cur_13 = $request->cur_13;
        $pack->share_13 = $request->share_13;
        $pack->cur_14 = $request->cur_14;
        $pack->share_14 = $request->share_14;
        $pack->cur_15 = $request->cur_15;
        $pack->share_15 = $request->share_15;
        $pack->cur_16 = $request->cur_16;
        $pack->share_16 = $request->share_16;
        $pack->cur_17 = $request->cur_17;
        $pack->share_17 = $request->share_17;
        $pack->cur_18 = $request->cur_18;
        $pack->share_18 = $request->share_18;
        $pack->cur_19 = $request->cur_19;
        $pack->share_19 = $request->share_19;
        $pack->cur_20 = $request->cur_20;
        $pack->share_20 = $request->share_20;
        $pack->cur_21 = $request->cur_21;
        $pack->share_21 = $request->share_21;
        
        $pack->save();
      return redirect()->back()
      ->with('message', 'Pack created Sucessful!');
    }

     //edit packs
     public function updatepack(Request $request)
     {
         investment_packs::where('id', $request->pack)
         ->update([
         'name'=> $request->name,
         'price'=> $request->price,
         'duration'=> $request->duration,
         'cur_1'=> $request->cur_1,
         'share_1'=> $request->share_1,
         'cur_2'=> $request->cur_2,
         'share_2'=> $request->share_2,
         'cur_3'=> $request->cur_3,
         'share_3'=> $request->share_3,
         'cur_4'=> $request->cur_4,
         'share_4'=> $request->share_4,
         'cur_5'=> $request->cur_5,
         'share_5'=> $request->share_5,
         'cur_6'=> $request->cur_6,
         'share_6'=> $request->share_6,
         'cur_7'=> $request->cur_7,
         'share_7'=> $request->share_7,
         'cur_8'=> $request->cur_8,
         'share_8'=> $request->share_8,
         'cur_9'=> $request->cur_9,
         'share_9'=> $request->share_9,
         'cur_10'=> $request->cur_10,
         'share_10'=> $request->share_10,
         'cur_11'=> $request->cur_11,
         'share_11'=> $request->share_11,
         'cur_12'=> $request->cur_12,
         'share_12'=> $request->share_12,
         'cur_13'=> $request->cur_13,
         'share_13'=> $request->share_13,
         'cur_14'=> $request->cur_14,
         'share_14'=> $request->share_14,
         'cur_15'=> $request->cur_15,
         'share_15'=> $request->share_15,
         'cur_16'=> $request->cur_16,
         'share_16'=> $request->share_16,
         'cur_17'=> $request->cur_17,
         'share_17'=> $request->share_17,
         'cur_18'=> $request->cur_18,
         'share_18'=> $request->share_18,
         'cur_19'=> $request->cur_19,
         'share_19'=> $request->share_19,
         'cur_20'=> $request->cur_20,
         'share_20'=> $request->share_20,
         'cur_21'=> $request->cur_21,
         'share_21'=> $request->share_21,
         ]);
 
         return redirect()->back()->with('message','Investment pack trashed successfully!');
     }

    //trash packs route
    public function trashpack($pack)
    {
        //mark pack trashed
        investment_packs::where('id', $pack)
        ->update([
        'status'=> 'trashed',
        ]);

        return redirect()->back()->with('message','Investment pack trashed successfully!');
    }

    //Add or Edit Investment packs route
    public function addeditpack($pack)
    {
        if($pack=="new"){
            $pack = $pack;
        }else{
            $pack = investment_packs::where('id', $pack)->first();
        }

    	return view('invest.addeditpack')
        ->with(array(
        'title'=>'Add or Edit investment mix packs',
        'pack'=> $pack,
        'settings' => settings::where('id','1')->first(),
        ));
    }

    //buy investment pack
    public function buypack($pack){

        //get pack 
        $pack = investment_packs::where('id',$pack)->first();
        $settings = settings::where('id','1')->first();

        //check if the user account balance can buy this plan
        if(Auth::user()->account_bal < $pack->price){
            //redirect to make deposit
            return redirect()->back()->with('message','Your account is insufficient to perform this investment.');
        }

        //get the coins prices then calculate and open investment
        $open_price_1=null;
        $open_price_2=null;
        $open_price_3=null;
        $open_price_4=null;
        $open_price_5=null;
        $open_price_6=null;
        $open_price_7=null;
        $open_price_8=null;
        $open_price_9=null;
        $open_price_10=null;
        $open_price_11=null;
        $open_price_12=null;
        $open_price_13=null;
        $open_price_14=null;
        $open_price_15=null;
        $open_price_16=null;
        $open_price_17=null;
        $open_price_18=null;
        $open_price_19=null;
        $open_price_20=null;
        $open_price_21=null;

        if($pack->cur_1 != NULL){
            $price = $this->get_rates($pack->cur_1,$settings->s_currency,"price");
            $share_price = $pack->price * $pack->share_1/100;
            $open_price_1 = $share_price/$price;
        }
        if($pack->cur_2 != NULL){
            $price = round($this->get_rates($pack->cur_2,$settings->s_currency,"price"),6);
            $share_price = ($pack->price * $pack->share_2)/100;
            $open_price_2 = $share_price/$price;
        }
        if($pack->cur_3 != NULL){
            $price = round($this->get_rates($pack->cur_3,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_3/100;
            $open_price_3 = $share_price/$price;
        }
        if($pack->cur_4 != NULL){
            $price = round($this->get_rates($pack->cur_4,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_4/100;
            $open_price_4 = $share_price/$price;
        }
        if($pack->cur_5 != NULL){
            $price = round($this->get_rates($pack->cur_5,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_5/100;
            $open_price_5 = $share_price/$price;
        }
        if($pack->cur_6 != NULL){
            $price = round($this->get_rates($pack->cur_6,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_6/100;
            $open_price_6 = $share_price/$price;
        }
        if($pack->cur_7 != NULL){
            $price = round($this->get_rates($pack->cur_7,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_7/100;
            $open_price_7 = $share_price/$price;
        }
        if($pack->cur_8 != NULL){
            $price = round($this->get_rates($pack->cur_8,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_8/100;
            $open_price_8 = $share_price/$price;
        }
        if($pack->cur_9 != NULL){
            $price = round($this->get_rates($pack->cur_9,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_9/100;
            $open_price_9 = $share_price/$price;
        }
        if($pack->cur_10 != NULL){
            $price = round($this->get_rates($pack->cur_10,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_10/100;
            $open_price_10 = $share_price/$price;
        }
        if($pack->cur_11 != NULL){
            $price = round($this->get_rates($pack->cur_11,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_11/100;
            $open_price_11 = $share_price/$price;
        }
        if($pack->cur_12 != NULL){
            $price = round($this->get_rates($pack->cur_12,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_12/100;
            $open_price_12 = $share_price/$price;
        }
        if($pack->cur_13 != NULL){
            $price = round($this->get_rates($pack->cur_13,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_13/100;
            $open_price_13 = $share_price/$price;
        }
        if($pack->cur_14 != NULL){
            $price = round($this->get_rates($pack->cur_14,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_14/100;
            $open_price_14 = $share_price/$price;
        }
        if($pack->cur_15 != NULL){
            $price = round($this->get_rates($pack->cur_15,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_15/100;
            $open_price_15 = $share_price/$price;
        }
        if($pack->cur_16 != NULL){
            $price = round($this->get_rates($pack->cur_16,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_16/100;
            $open_price_16 = $share_price/$price;
        }
        if($pack->cur_17 != NULL){
            $price = round($this->get_rates($pack->cur_17,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_17/100;
            $open_price_17 = $share_price/$price;
        }
        if($pack->cur_18 != NULL){
            $price = round($this->get_rates($pack->cur_18,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_18/100;
            $open_price_18 = $share_price/$price;
        }
        if($pack->cur_19 != NULL){
            $price = round($this->get_rates($pack->cur_19,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_19/100;
            $open_price_19 = $share_price/$price;
        }
        if($pack->cur_20 != NULL){
            $price = round($this->get_rates($pack->cur_20,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_20/100;
            $open_price_20 = $share_price/$price;
        }
        if($pack->cur_21 != NULL){
            $price = round($this->get_rates($pack->cur_21,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_21/100;
            $open_price_21 = $share_price/$price;
        }

        //debit user
        users::where('id', Auth::user()->id)
        ->update([
        'account_bal'=>Auth::user()->account_bal-$pack->price,
        ]);

        $inv=new user_packs();
        $inv->investment_pack= $pack->id;
        $inv->user= Auth::user()->id;
        $inv->duration= $pack->duration;
        $inv->open_price_1= $open_price_1;
        $inv->open_price_2= $open_price_2;
        $inv->open_price_3= $open_price_3;
        $inv->open_price_4= $open_price_4;
        $inv->open_price_5= $open_price_5;
        $inv->open_price_6= $open_price_6;
        $inv->open_price_7= $open_price_7;
        $inv->open_price_8= $open_price_8;
        $inv->open_price_9= $open_price_9;
        $inv->open_price_10= $open_price_10;
        $inv->open_price_11= $open_price_11;
        $inv->open_price_12= $open_price_12;
        $inv->open_price_13= $open_price_13;
        $inv->open_price_14= $open_price_14;
        $inv->open_price_15= $open_price_15;
        $inv->open_price_16= $open_price_16;
        $inv->open_price_17= $open_price_17;
        $inv->open_price_18= $open_price_18;
        $inv->open_price_19= $open_price_19;
        $inv->open_price_20= $open_price_20;
        $inv->open_price_21= $open_price_21;
        $inv->save();
        
        return redirect()->back()->with('message','Investment opened successfully!');
    }

    //close investment pack
    public function closepack($pack){
        //get pack 
        $u_pack = user_packs::where('id',$pack)->first();
        $pack = investment_packs::where('id',$u_pack->investment_pack)->first();

        //get settings
        $settings=settings::where('id','1')->first();
        
        //get investment value with current rate 
        //get the coins prices then calculate and open investment
        $close_price_1=null;    $new_price_1 = 0;
        $close_price_2=null;    $new_price_2 = 0;   
        $close_price_3=null;    $new_price_3 = 0;
        $close_price_4=null;    $new_price_4 = 0;
        $close_price_5=null;    $new_price_5 = 0;
        $close_price_6=null;    $new_price_6 = 0;
        $close_price_7=null;    $new_price_7 = 0;
        $close_price_8=null;    $new_price_8 = 0;
        $close_price_9=null;    $new_price_9 = 0;
        $close_price_10=null;   $new_price_10 = 0;
        $close_price_11=null;   $new_price_11 = 0;
        $close_price_12=null;   $new_price_12 = 0;
        $close_price_13=null;   $new_price_13 = 0;
        $close_price_14=null;   $new_price_14 = 0;
        $close_price_15=null;   $new_price_15 = 0;
        $close_price_16=null;   $new_price_16 = 0;
        $close_price_17=null;   $new_price_17 = 0;
        $close_price_18=null;   $new_price_18 = 0;
        $close_price_19=null;   $new_price_19 = 0;
        $close_price_20=null;   $new_price_20 = 0;
        $close_price_21=null;   $new_price_21 = 0;

        if($pack->cur_1 != NULL){
            $price = round($this->get_rates($pack->cur_1,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_1/100;
            $close_price_1 = $share_price/$price;
            $new_price_1 = $u_pack->open_price_1*$price;
        }
        if($pack->cur_2 != NULL){
            $price = round($this->get_rates($pack->cur_2,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_2/100;
            $close_price_2 = $share_price/$price;
            $new_price_2 = $u_pack->open_price_2*$price;
        }
        if($pack->cur_3 != NULL){
            $price = round($this->get_rates($pack->cur_3,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_3/100;
            $close_price_3 = $share_price/$price;
            $new_price_3 = $u_pack->open_price_3*$price;
        }
        if($pack->cur_4 != NULL){
            $price = round($this->get_rates($pack->cur_4,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_4/100;
            $close_price_4 = $share_price/$price;
            $new_price_4 = $u_pack->open_price_4*$price;
        }
        if($pack->cur_5 != NULL){
            $price = round($this->get_rates($pack->cur_5,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_5/100;
            $close_price_5 = $share_price/$price;
            $new_price_5 = $u_pack->open_price_5*$price;
        }
        if($pack->cur_6 != NULL){
            $price = round($this->get_rates($pack->cur_6,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_6/100;
            $close_price_6 = $share_price/$price;
            $new_price_6 = $u_pack->open_price_6*$price;
        }
        if($pack->cur_7 != NULL){
            $price = round($this->get_rates($pack->cur_7,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_7/100;
            $close_price_7 = $share_price/$price;
            $new_price_7 = $u_pack->open_price_7*$price;
        }
        if($pack->cur_8 != NULL){
            $price = round($this->get_rates($pack->cur_8,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_8/100;
            $close_price_8 = $share_price/$price;
            $new_price_8 = $u_pack->open_price_8*$price;
        }
        if($pack->cur_9 != NULL){
            $price = round($this->get_rates($pack->cur_9,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_9/100;
            $close_price_9 = $share_price/$price;
            $new_price_9 = $u_pack->open_price_9*$price;
        }
        if($pack->cur_10 != NULL){
            $price = round($this->get_rates($pack->cur_10,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_10/100;
            $close_price_10 = $share_price/$price;
            $new_price_10 = $u_pack->open_price_10*$price;
        }
        if($pack->cur_11 != NULL){
            $price = round($this->get_rates($pack->cur_11,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_11/100;
            $close_price_11 = $share_price/$price;
            $new_price_11 = $u_pack->open_price_11*$price;
        }
        if($pack->cur_12 != NULL){
            $price = round($this->get_rates($pack->cur_12,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_12/100;
            $close_price_12 = $share_price/$price;
            $new_price_12 = $u_pack->open_price_12*$price;
        }
        if($pack->cur_13 != NULL){
            $price = round($this->get_rates($pack->cur_13,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_13/100;
            $close_price_13 = $share_price/$price;
            $new_price_13 = $u_pack->open_price_13*$price;
        }
        if($pack->cur_14 != NULL){
            $price = round($this->get_rates($pack->cur_14,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_14/100;
            $close_price_14 = $share_price/$price;
            $new_price_14 = $u_pack->open_price_14*$price;
        }
        if($pack->cur_15 != NULL){
            $price = round($this->get_rates($pack->cur_15,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_15/100;
            $close_price_15 = $share_price/$price;
            $new_price_15 = $u_pack->open_price_15*$price;
        }
        if($pack->cur_16 != NULL){
            $price = round($this->get_rates($pack->cur_16,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_16/100;
            $close_price_16 = $share_price/$price;
            $new_price_16 = $u_pack->open_price_16*$price;
        }
        if($pack->cur_17 != NULL){
            $price = round($this->get_rates($pack->cur_17,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_17/100;
            $close_price_17 = $share_price/$price;
            $new_price_17 = $u_pack->open_price_17*$price;
        }
        if($pack->cur_18 != NULL){
            $price = round($this->get_rates($pack->cur_18,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_18/100;
            $close_price_18 = $share_price/$price;
            $new_price_18 = $u_pack->open_price_18*$price;
        }
        if($pack->cur_19 != NULL){
            $price = round($this->get_rates($pack->cur_19,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_19/100;
            $close_price_19 = $share_price/$price;
            $new_price_19 = $u_pack->open_price_19*$price;
        }
        if($pack->cur_20 != NULL){
            $price = round($this->get_rates($pack->cur_20,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_20/100;
            $close_price_20 = $share_price/$price;
            $new_price_20 = $u_pack->open_price_20*$price;
        }
        if($pack->cur_21 != NULL){
            $price = round($this->get_rates($pack->cur_21,$settings->s_currency,"price"),6);
            $share_price = $pack->price * $pack->share_21/100;
            $close_price_21 = $share_price/$price;
            $new_price_21 = $u_pack->open_price_21*$price;
        }

        $new_amount = $new_price_1 + $new_price_2 + $new_price_3 + $new_price_4 + $new_price_5
        + $new_price_6 + $new_price_7 + $new_price_8 + $new_price_9 + $new_price_10 + $new_price_11
        + $new_price_12 + $new_price_13 + $new_price_14 + $new_price_15 + $new_price_16 + $new_price_17
        + $new_price_18 + $new_price_19 + $new_price_20 + $new_price_21;

        //mark investment closed
        user_packs::where('id', $u_pack->id)
        ->update([
        'status'=>'closed',
        'close_price_1' => $close_price_1,
        'close_price_2' => $close_price_2,
        'close_price_3' => $close_price_3,
        'close_price_4' => $close_price_4,
        'close_price_5' => $close_price_5,
        'close_price_6' => $close_price_6,
        'close_price_7' => $close_price_7,
        'close_price_8' => $close_price_8,
        'close_price_9' => $close_price_9,
        'close_price_10' => $close_price_10,
        'close_price_11' => $close_price_11,
        'close_price_12' => $close_price_12,
        'close_price_13' => $close_price_13,
        'close_price_14' => $close_price_14,
        'close_price_15' => $close_price_15,
        'close_price_16' => $close_price_16,
        'close_price_17' => $close_price_17,
        'close_price_18' => $close_price_18,
        'close_price_19' => $close_price_19,
        'close_price_20' => $close_price_20,
        'close_price_21' => $close_price_21,
        'p_l' => $new_amount,
        'closed_at' => \Carbon\Carbon::Now(), 
        ]);

        //credit user with new amount
        users::where('id', auth::user()->id)
        ->update([
        'account_bal'=> auth::user()->account_bal+$new_amount,
        ]);
        
        return redirect()->back()->with('message','Investment closed successfully!');
    }
    

    //Get investment assets
  public function investment_assets($type) {
    $assets= assets::where("category","$type")->get();
    $asts .='';
    foreach ($assets as $asset) {
        
            $asts .= "<option value=$asset->symbol>$asset->name</option>";
        }
       return $asts; 
    }
}
