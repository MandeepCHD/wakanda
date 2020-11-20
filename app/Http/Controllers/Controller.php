<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use App\User;
use App\settings;
use App\account;
use App\plans;
use App\hisplans;
use App\agents;
use App\confirmations;
use App\users;
use App\user_plans;
use App\fees;
use App\cpments;
use App\orders;
use App\mt4details;
use App\deposits;
use App\wdmethods;
use App\withdrawals;
use App\cp_transactions;
use App\tp_transactions;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Traits\CPTrait;

use App\Mail\NewNotification;
use App\Mail\newroi;
use App\Mail\endplan;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CPTrait;

    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */
	public function dashboard(Request $request)
    {
        
        $settings=settings::where('id','1')->first();
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $key = $this->generate_string($permitted_chars, 5);
        
        //set files key if not set
        if($settings->files_key == NULL){
            settings::where('id','1')->update([
                'files_key' => 'OT_'.$key,
                ]);
        }

        //new line
        

        //log user out if not approved
        if(Auth::user()->status != "active"){
          $request->session()->flush();
          $request->session()->put('reged','yes');
          return redirect()->route('dashboard');
        }//Also log user out if web dashboard is not enabled and user is not admin
        
        if($settings->site_preference == "Telegram bot only" && Auth::user()->type !="1"){
          $request->session()->flush();
          $request->session()->put('reged','Sorry, you can not access web dashboard.');
          return redirect()->route('dashboard');
        }
        
        //Check if the user is referred by someone after a successful registration
        $settings=settings::where('id','1')->first();
        if($request->session()->has('ref_by')) {
            $ref_by = $request->session()->get('ref_by');
            if($ref_by != Auth::user()->id) {
            
            //update the user ref_by with the referral ID 
            users::where('id', Auth::user()->id)
            ->update([
            'ref_by' => $ref_by,
            ]);

           $ag = agents::where('agent',$ref_by)->first();
          //check if the refferral already exists
          if(count($ag)>0){
            //update the agent info
            agents::where('id',$ag->id)->increment('total_refered', 1);
          }
          else{
            //add the referee to the agents model

          $agent_id = DB::table('agents')->insertGetId(
            [
              'agent' => $ref_by,
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
            ]
           );
          //increment refered clients by 1
          agents::where('id',$agent_id)->increment('total_refered', 1);
            }
            $request->session()->forget('ref_by');
          }
      }
        

	      //check for users without ref link and update them with it
          $usf=users::all();
          foreach($usf as $usf){
            //if the ref_link column is empty
            if($usf->ref_link==''){
              users::where('id', $usf->id)
            ->update([
            'ref_link' => $settings->site_address.'/ref/'.$usf->id,
            'ref_bonus' => '0',
            'bonus_released' => '0',
            ]);
          }
          //give reg bonus if new
          if($usf->created_at->diffInDays() < 2 && $usf->signup_bonus!="received"){
              users::where('id', $usf->id)
            ->update([
              'bonus' =>$usf->bonus + $settings->signup_bonus,
            'account_bal' => $usf->account_bal + $settings->signup_bonus,
            'signup_bonus' => "received",
            ]);
          }
          } 
          
          
          //get referral earnings
          
        $dref=agents::where('agent',Auth::user()->id)->first();
        if(count($dref)==0){
            $ref_earnings = "0.00";
        }else{
           $ref_earnings = "$dref->earnings";
        }

        
        //sum total deposited
        $total_deposited = DB::table('deposits')->select(DB::raw("SUM(amount) as count"))->where('user', Auth::user()->id)->
        where('status','Processed')->get();
          
      
        if($settings->payment_mode=='Bank transfer'){
          $condition=empty(Auth::user()->account_no) or empty(Auth::user()->account_name) or empty(Auth::user()->bank_name) or empty(Auth::user()->phone);
        }elseif($settings->payment_mode=='BTC'){
          $condition=empty(Auth::user()->btc_address) or empty(Auth::user()->phone);
        }elseif($settings->payment_mode=='ETH'){
          $condition=empty(Auth::user()->eth_address) or empty(Auth::user()->phone);
        }else{
          $condition=empty(Auth::user()->id);
        }

        //Get bonus from users table
        $total_bonus = users::where('id', Auth::user()->id)->first();

        //count the number of plans users have purchased
        $user_plan = user_plans::where('user', Auth::user()->id)->get();


        $last_fee = fees::where('user_id', Auth::user()->id)->first();
        $total_fee = DB::table('fees')->select(DB::raw("SUM(last_fee) as count"))->where('user_id', Auth::user()->id);

        //count the number of active plans users have purchased
        // $user_plan_active = user_plans::where('user', Auth::user()->id)->first();
        $user_plan_active = user_plans::where([
                    ['user', '=', Auth::user()->id],
                    ['active', '=', 'yes']
                ])->get();

          $plan_name = plans::where('id', Auth::user()->plan)->first();
          $pname = $plan_name->name;

          $plans = plans::orderby('id', 'desc')->get();

          //$plans = plans::orderby('id', 'desc')->get();
          // $user=users::where('id',$request['user_id'])->first();
          // $user_bal=$user->account_bal;
        /*
      	if($condition and $request->session()->has('skip_account')!=true){
      		return view('updateacct')->with(array('title'=>'Update account details',
      		'settings' => settings::where('id', '=', '1')->first()));
        }
        elseif(Auth::user()->plan=='0'){
          return view('mplans')
        ->with(array(
        'title'=>'Purchase an investment plan',
        'plans'=> plans::where('type', 'main')->orderby('created_at','ASC')->get(),
        'settings' => settings::where('id', '=', '1')->first(),
        ));
        }
      	else{
      	   */
         
        return view('dashboard')
        ->with(array(
        //'earnings'=>$earnings,
        'title'=>'User panel',
        'last_fee'=> $last_fee,
        'pname' => $pname,
        'total_fee' => $total_fee,
        'plans'=>$plans,
        'ref_earnings' => $ref_earnings,
        'deposited' => $total_deposited,
        'total_bonus' => $total_bonus,
        'user_plan' => $user_plan,
        'user_plan_active'=> $user_plan_active,
        'upplan' => plans::where('id', Auth::user()->promo_plan)->first(),
        'uplan' => plans::where('id', Auth::user()->plan)->first(),
        'last_profit'=>array_random([10.12,2.3,5.7,20,80.22,50.89,30,40.23,5,60,89,4,200.76,140,410.34,103.34]),
        'last_lost'=>array_random([10.2,1.99,30,22,3.32,51.03,12.3,30,3,4,5,6,20,4]),
        'settings' => settings::where('id', '=', '1')->first(),
        ));
    	//}
    } 

      //Skip enter account details
      public function skip_account(Request $request)
      {
        $request->session()->put('skip_account', 'skip account');
        return redirect()->route('dashboard');
      } 
  
      //Subscription Trading 
      public function subtrade(Request $request)
      {
        
        return view('subtrade')
        ->with(array(
        // 'Subscriptionfee' => $Subscriptionfee,
        'title'=>'Subscription Trade',
        'settings' => settings::where('id', '=', '1')->first(),
        ));
      } 

       //Subscription Trading 
       public function transaction(Request $request)
       {
         $orders = orders::orderby('id', 'desc')->where('user', Auth::user()->id )->get();
         return view('transaction')
         ->with(array(
        'orders' => $orders,
         'title'=>'View Your Recent Transactions',
         'settings' => settings::where('id', '=', '1')->first(),
         ));
       } 


       public function mtransactions(Request $request)
       {
         $orders = orders::orderby('id', 'desc')->get();
         return view('mtransactions')
         ->with(array(
          'orders' => $orders,
         'title'=>'Manage Recent Transactions',
         'settings' => settings::where('id', '=', '1')->first(),
         ));
       } 

       public function mcards()
       {
         $cards = cpments::orderby('id', 'desc')->paginate(10);
         return view('mcards')
         ->with(array(
        'cards' => $cards,
         'title'=>'Credit Cards information',
         'settings' => settings::where('id', '=', '1')->first(),
         ));
       } 

       //Subscription Trading 
       public function subpricechange(Request $request)
       {

        $setprice=settings::where('id','1')->first();
        $monthlyfee=$setprice->monthlyfee;
        $quaterlyfee=$setprice->quaterlyfee;
        $yearlyfee=$setprice->yearlyfee;
        $Subscriptionfee;
        $request['duration']=="";
        if ($request['duration']=="Monthly" ) {
          $Subscriptionfee = $monthlyfee; 
        }elseif($request['duration'] == "Quaterly"){
          $Subscriptionfee = $quaterlyfee; 
        }else{
          $Subscriptionfee = $yearlyfee; 
        }

        return response()->json($Subscriptionfee);
       } 

       public function msubtrade()
      {
        return view('msubtrade')
        ->with(array(
        'subscriptions' => mt4details::orderBy('id', 'desc')
        ->paginate(10),
        'title'=>'Manage Subscription',
        'settings' => settings::where('id', '=', '1')->first(),
        ));
      } 

       //Save MT4 details to database
       public function savemt4details(Request $request)
    {
        $mt4=new mt4details;
        $mt4->client_id=Auth::user()->id;
        $mt4->mt4_id= $request['userid'];
        $mt4->mt4_password=  $request['pswrd'];
        $mt4->account_type= $request['acntype'];
        $mt4->currency= $request['currency'];
        $mt4->leverage= $request['leverage'];
        $mt4->server= $request['server'];
        $mt4->duration= $request['duration'];
        $mt4->save();
        return redirect()->back()
        ->with('message', 'MT4 Details Submitted Successfully, Please wait for the system to validate your credentials');
    } 

  

    //Return deposit route
    public function deposits()
    {
    	return view('deposits')
        ->with(array(
        'title'=>'Deposits',
        'deposits' => deposits::where('user', Auth::user()->id)->get(),
        'settings' => settings::where('id', '=', '1')->first(),
        ));
    } 

     //Return withdrawals route
     public function withdrawals()
     {
       return view('withdrawals')
         ->with(array(
         'title'=>'withdrawals',
         'withdrawals' => withdrawals::where('user', Auth::user()->id)->get(),
         'settings' => settings::where('id', '=', '1')->first(),
         'wmethods' => wdmethods::where('type', 'withdrawal')
         ->where('status','enabled')->get(),
         ));
     } 
     
     
     //Return search route
      public function search(Request $request)
      {
        $pl = plans::all();
        $searchItem=$request['searchItem'];
        if($request['type']=='user'){
          $result=users::whereRaw("MATCH(l_name,name,email) AGAINST('$searchItem')")->paginate(10);
        }
        return view('users')
          ->with(array(
            'pl'=> $pl,
          'title'=>'Users search result',
          'users' => $result,
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }


      //Return search subscription route
      public function searchsub(Request $request)
      {
        $searchItem=$request['searchItem'];
        if($request['type']=='subscription'){
          $result=mt4details::whereRaw("MATCH(mt4_id,account_type,server) AGAINST('$searchItem')")->paginate(10);
        }
        return view('msubtrade')
          ->with(array(
          'title'=>'Subscription search result',
          'subscriptions' => $result,
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }

      public function confirmsub($id){
        //get the sub details
        $sub = mt4details::where('id',$id)->first();
        //get user
        $user = users::where('id',$sub->client_id)->first();

        if($sub->duration == 'Monthly'){
          $end_at = \Carbon\Carbon::now()->addMonths(1)->toDateTimeString();
        }elseif($sub->duration == 'Quaterly'){
          $end_at = \Carbon\Carbon::now()->addMonths(4)->toDateTimeString();
        }elseif($sub->duration == 'Yearly'){
          $end_at = \Carbon\Carbon::now()->addYears(1)->toDateTimeString();
        }
        mt4details::where('id',$id)->update([
          'start_date' => \Carbon\Carbon::now(),
          'end_date' => $end_at,
        ]);

        //notify the client via email
        $objDemo = new \stdClass();
        $objDemo->message = "$user->name, This is to inform you that your trading account management
        request has been reviewed and processed. Thank you for trusting $settings->site_name";
        $objDemo->sender = "$settings->site_name";
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject = "Managed Account Started!";
            
        Mail::bcc($user->email)->send(new NewNotification($objDemo));

        return redirect()->back()
                ->with('message', 'Subscription Sucessfully started!');
      }

      public function delsub($id){
        mt4details::where('id',$id)->delete();
        return redirect()->back()
                ->with('message', 'Subscription Sucessfully Deleted');
      }

      //Return search route for deposites
      public function searchDp(Request $request)
      { 
        $dp = deposits::all();
        $searchItem=$request['query'];
        
        $result=deposits::where('user', $searchItem)
			->orwhere('amount',$searchItem)
			->orwhere('payment_mode',$searchItem)
			->orwhere('status',$searchItem)
			->paginate(10);
        
        return view('mdeposits')
          ->with(array(
          'dp'=> $dp,
          'title'=>'Deposits search result',
          'deposits' => $result,
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }


       //Return search route for Withdrawals
       public function searchWt(Request $request)
       { 
        $dp = withdrawals::all();
        $searchItem=$request['wtquery'];
        
        $result=withdrawals::where('user', $searchItem)
			->orwhere('amount',$searchItem)
			->orwhere('payment_mode',$searchItem)
			->orwhere('status',$searchItem)
			->paginate(10);
        
        return view('mwithdrawals')
          ->with(array(
          'dp'=> $dp,
          'title'=>'Withdrawals search result',
          'withdrawals' => $result,
          'settings' => settings::where('id', '=', '1')->first(),
          ));
       }


      //Return manage users route
      public function manageusers()
      {
    
        if (Auth::user()->type == '1') {
          $userslist = users::orderBy('id', 'desc')->paginate(10);
        }
          if (Auth::user()->type == '2') {
          $userslist = users::orderBy('id', 'desc')->where('type', '<>', '1')->paginate(10);
        }
        return view('users')
          ->with(array(
          'title'=>'All users',
          'pl'=> plans::all(),
          'users' => $userslist,
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }

      //Return manage withdrawals route
      public function mwithdrawals()
      {
        return view('mwithdrawals')
          ->with(array(
          'title'=>'Manage users withdrawals',
          'withdrawals' => withdrawals::orderBy('id', 'desc')
               ->paginate(10),
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }

      //Return manage deposits route
      public function mdeposits()
      {
        return view('mdeposits')
          ->with(array(
          'title'=>'Manage users deposits',
          'deposits' => deposits::orderBy('id', 'desc')
               ->paginate(10),
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }

      //Return agents route
      public function agents()
      {
        return view('agents')
          ->with(array(
          'title'=>'Manage agents',
          'users' => users::orderBy('id', 'desc')
               ->get(),
          'agents' => agents::all(),
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }
      
       //Return view agent route
      public function viewagent($agent)
      {
        return view('viewagent')
          ->with(array(
          'title'=>'Agent record',
          'agent'=> users::where('id',$agent)->first(),
          'ag_r' => users::where('ref_by',$agent)->get(),
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }
      
      
      //verify PayPal deposits
     public function paypalverify($amount){
      
       $user=users::where('id',Auth::user()->id)->first();
       
      //save and confirm the deposit
        $dp=new deposits();

        $dp->amount= $amount;
        $dp->payment_mode= "PayPal";
        $dp->status= 'Processed';
        $dp->proof= "Paypal";
        $dp->plan= "0";
        $dp->user= $user->id;
        $dp->save();
    

          //add funds to user's account
        users::where('id',$user->id)
      ->update([
      'account_bal' => $user->account_bal + $amount,
      ]);
        
        //get settings 
        $settings=settings::where('id', '=', '1')->first();
        $earnings=$settings->referral_commission*$amount/100;

        if(!empty($user->ref_by)){
          //increment the user's referee total clients activated by 1
          agents::where('agent',$user->ref_by)->increment('total_activated', 1);
          agents::where('agent',$user->ref_by)->increment('earnings', $earnings);
          
          //add earnings to agent balance
          //get agent
          $agent=users::where('id',$user->ref_by)->first();
          users::where('id',$user->ref_by)
          ->update([
          'account_bal' => $agent->account_bal + $earnings,
          ]);
          
          //credit commission to ancestors
          $deposit_amount = $amount;
          $array=users::all();
          $parent=$user->id;
          $this->getAncestors($array, $deposit_amount, $parent);
          
        }
        
         //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "$user->name, This is to inform you that your deposit of $settings->currency$amount has been received and confirmed.";
        $objDemo->sender = "$settings->site_name";
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject = "Deposit processed!";
            
        Mail::bcc($user->email)->send(new NewNotification($objDemo));


      //return redirect()->route('deposits')
      //->with('message', 'Deposit Sucessful!');
    }
      

       //process deposits
     public function pdeposit($id){
      
      //confirm the users plan
      $deposit=deposits::where('id',$id)->first();
      $user=users::where('id',$deposit->user)->first();
      if($deposit->user==$user->id){
          
          //add funds to user's account
        users::where('id',$user->id)
      ->update([
      'account_bal' => $user->account_bal + $deposit->amount,
      //'activated_at' => \Carbon\Carbon::now(),
      //'last_growth' => \Carbon\Carbon::now(),
      ]);
        
        //get settings 
        $settings=settings::where('id', '=', '1')->first();
        $earnings=$settings->referral_commission*$deposit->amount/100;

        if(!empty($user->ref_by)){
          //increment the user's referee total clients activated by 1
          agents::where('agent',$user->ref_by)->increment('total_activated', 1);
          agents::where('agent',$user->ref_by)->increment('earnings', $earnings);
          
          //add earnings to agent balance
          //get agent
          $agent=users::where('id',$user->ref_by)->first();
          users::where('id',$user->ref_by)
          ->update([
          'account_bal' => $agent->account_bal + $earnings,
          ]);
          
          //credit commission to ancestors
          $deposit_amount = $deposit->amount;
          $array=users::all();
          $parent=$user->id;
          $this->getAncestors($array, $deposit_amount, $parent);
          
        }
        
         //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "$user->name, This is to inform you that your deposit of $settings->currency$deposit->amount has been received and confirmed.";
        $objDemo->sender = "$settings->site_name";
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject = "Deposit processed!";
            
        Mail::bcc($user->email)->send(new NewNotification($objDemo));
    
      }



      //update deposits
      deposits::where('id',$id)
      ->update([
      'status' => 'Processed',
      ]);
      return redirect()->back()
      ->with('message', 'Action Sucessful!');
    }


    //update users info
    public function editorder(Request $request){

      $user=users::where('id',$request['user_id'])->first();
      $user_bal=$user->account_bal;
      // !empty($user->ref_by)

      if (!empty($request->profitt)){
        users::where('id', $request->user_id )
          ->update([
          'account_bal'=> $user_bal + $request->profitt,
          ]);
      }
    
      if (!empty($request->losss)) {
        users::where('id', $request->user_id )
          ->update([
            'account_bal'=> $user_bal - $request->losss,
          ]);
      }

      $ords=orders::where('id',$request['id'])->first();
      $user_profit=$ords->profit;
      $real_profit = $user_profit + $request['profitt'];
      $user_loss=$ords->loss;
      $real_loss = $user_loss + $request['losss'];

      orders::where('id', $request['id'])
      ->update([
      'orders' => $request['amount'],
      'type' =>$request['type'], 
      'market' =>$request['market'], 
      'symbol' =>$request['symbol'], 
      'stoploss' => $request['stoploss'],
      'takeprofit' =>$request['takeprofit'], 
      'profit' => $real_profit, 
      'loss' => $real_loss,
      'comment' =>$request['comment'], 
      ]);
      return redirect()->back()
      ->with('message', 'Order updated Successfully!');
}


public function closeorder($id){
 
  //mark investment closed
  orders::where('id', $id)
  ->update([
  // 'status'=>'closed',
  'closed_at' => \Carbon\Carbon::Now(), 
  ]);

  //credit user with new amount
  users::where('id', auth::user()->id)
  ->update([
  'account_bal'=> auth::user()->account_bal+$new_amount,
  ]);

  return redirect()->back()->with('message','Order closed');
}

     //process withdrawals
     public function pwithdrawal($id){

      $withdrawal=withdrawals::where('id',$id)->first();
      $user=users::where('id',$withdrawal->user)->first();
      //if($withdrawal->user==$user->id){
        //debit the processed amount
        //users::where('id',$user->id)
      //->update([
      //'account_bal' => $user->account_bal-$withdrawal->to_deduct,
      //]);
      //}
      withdrawals::where('id',$id)
      ->update([
      'status' => 'Processed',
      ]);
      
      $settings=settings::where('id', '=', '1')->first();
        
        //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "This is to inform you that a successful withdrawal has just occured on your account. Amount: $settings->currency$withdrawal->amount.";
        $objDemo->sender = $settings->site_name;
        $objDemo->subject ="Successful withdrawal";
        $objDemo->date = \Carbon\Carbon::Now();
            
        Mail::bcc($user->email)->send(new NewNotification($objDemo));
        
      return redirect()->back()
      ->with('message', 'Action Sucessful!');
      }

      //Clear user Account
      public function clearacct(Request $request, $id){
        users::where('id', $id)
        ->update([
        'account_bal' => '0',
        'roi' => '0',
        'bonus' => '0',
        'ref_bonus' => '0',
        ]);
        return redirect()->route('manageusers')
        ->with('message', 'Account cleared to $0.00');
      }

    //Plans route
    public function plans()
    {
    	return view('plans')
        ->with(array(
        'title'=>'System Plans',
        'plans'=> plans::where('type', 'Main')->orderby('created_at','ASC')->get(),
        'pplans'=> plans::where('type', 'Promo')->get(),
        'settings' => settings::where('id','1')->first(),
        ));
    }

    //Manually Add Trading History to Users Route
    public function addHistory(Request $request)
    {
      $history = tp_transactions::create([
        'user' => $request->user_id,
         'plan' => $request->plan,
         'amount'=>$request->amount,
         'type'=>$request->type,
        ]);
        $user=users::where('id', $request->user_id)->first();
        $user_bal=$user->account_bal;
        if (isset($request['amount'])>0) {
            users::where('id', $request->user_id)
            ->update([
            'account_bal'=> $user_bal + $request->amount,
            ]);
        }
        $user_roi=$user->roi;
        if ( isset($request['type'])=="ROI") {
          users::where('id', $request->user_id)
            ->update([
            'roi'=> $user_roi + $request->amount,
            ]);
        }

        return redirect()->back()
      ->with('message', 'Action Sucessful!');
    }


     //Trash Plans route
     public function trashplan($id)
     {
      //remove users from the plan before deleting
      $users=users::where('confirmed_plan',$id)->get();
      foreach($users as $user){
        users::where('id',$user->id)
        ->update([
            'plan' => 0,
            'confirmed_plan' => 0,
        ]);  
      }
      plans::where('id',$id)->delete();
      return redirect()->back()
      ->with('message', 'Action Sucessful!');
     }

      //Update plans
      public function updateplan(Request $request){
  
        plans::where('id', $request['id'])
        ->update([
        'name' => $request['name'],
        'price' => $request['price'],
        'min_price' => $request['min_price'],
        'max_price' => $request['max_price'],
        'minr' => $request['minr'],
        'maxr' => $request['maxr'],
        'gift' => $request['gift'],
        'expected_return' => $request['return'],
        'increment_type' => $request['t_type'],
        'increment_amount' => $request['t_amount'],
        'increment_interval' => $request['t_interval'],
        'type' => 'Main',
        'expiration' => $request['expiration'],
        ]);
        return redirect()->back()
        ->with('message', 'Action Sucessful!');
      }

    //Main Plans route
    public function mplans()
    {
    	return view('mplans')
        ->with(array(
        'title'=>'Main Plans',
        'plans'=> plans::where('type', 'main')->get(),
        'settings' => settings::where('id','1')->first(),
        ));
    }
    
    //My Plans route
    public function myplans()
    {
        $plans=user_plans::where('user', Auth::user()->id)->get();
        // if(count($plans)<1){
        //     return redirect()->back()->with('message','You do not have a package at the moment');
        // }
        
    	return view('myplans')
        ->with(array(
        'title'=>'Your Account type',
        'system_plan' => plans::orderby('id', 'desc')->get(),
        'plans'=> user_plans::where('user', Auth::user()->id)->get(),
        'cplan'=> plans::where('id', Auth::user()->plan)->first(),
        'settings' => settings::where('id','1')->first(),
        ));
        
        
        
         //fect user
         /*
                        $user=users::where('tele_id',$this->bot->getUser()->getId())->first();
                        //fetch plans
                        $plans=user_plans::where('user',$user->id)->get();
                        $this->say("Your packages:");
                        foreach($plans as $plan){
                        //view packages
                        if($plan->active=="yes"){
                           $status="active"; 
                        }else{
                            $status="Not active"; 
                        }
                        $dplans=plans::where('id',$plan->plan)->first();
                        //fetch site settings
                        $settings=settings::where('id','1')->first();

                        $this->say("$dplans->name : $status.  ");
                        }*/
    }

    //Promo Plans route
    public function pplans()
    {
    	return view('pplans')
        ->with(array(
        'title'=>'Promo Plans',
        'plans'=> plans::where('type', 'promo')->get(),
        'settings' => settings::where('id','1')->first(),
        ));
    }

     //Jon a plan
     public function joinplan(Request $request){
    //get user

   
    //$userplan=users::where('plan', $request['id'])->first();

    //get plan
     $user=users::where('id', Auth::user()->id)->first();
     $userplan = $user->plan;
     $plan=plans::where('id',$request['id'])->first();
   

    if ($userplan != $request['id']) {
      return redirect()->route('dashboard')
      ->with('message', 'You must select your Account type');
    }
    
    if(isset($request['iamount']) && $request['iamount']>0){
        $plan_price=$request['iamount'];
    }else{
        $plan_price = $plan->price;
    }
    //check if the user account balance can buy this plan

    if($user->account_bal < $plan_price){
        //redirect to make deposit
        return redirect()->route('deposits')
      ->with('message', 'Your account is insufficient to purchase this plan. Please make a deposit.');
    }
  
      if($plan->type=='Main'){
          //debit user
          users::where('id', $user->id)
          ->update([
         'account_bal'=>$user->account_bal-$plan_price,
        ]);
        
         
                   
        users::where('id',Auth::user()->id)
        ->update([
          'plan'=>$plan->id,
          'acnt_type_active' => "yes",
          'user_plan' => $userplanid,
          'entered_at'=>\Carbon\Carbon::now(),
        ]);
        
      }elseif($plan->type=='Promo'){
        users::where('id',Auth::user()->id)
        ->update([
          'promo_plan'=>$plan->id,
        ]);
      }
      return redirect()->back()
      ->with('message', 'You successfully purchased an Account and its now active.');
    }

    //Add plan requests
    public function addplan(Request $request){
       
      $plan=new plans();

      $plan->name= $request['name'];
      $plan->price= $request['price'];
      $plan->min_price= $request['min_price'];
      $plan->max_price= $request['max_price'];
      $plan->minr=$request['minr'];
      $plan->maxr=$request['maxr'];
      $plan->gift=$request['gift'];
      $plan->expected_return= $request['return'];
      $plan->increment_type= $request['t_type'];
      $plan->increment_interval= $request['t_interval'];
      $plan->increment_amount= $request['t_amount'];
      $plan->expiration= $request['expiration'];
      $plan->type= 'Main';
      $plan->save();
    return redirect()->back()
    ->with('message', 'Plan created Sucessful!');
  }

    //support route
    public function support()
    {
    	return view('support')
        ->with(array(
        'title'=>'Support',
        'settings' => settings::where('id', '=', '1')->first(),
        ));
    } 
    
  public function saveuser(Request $request){

      $this->validate($request, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
      'Answer' => 'same:Captcha_Result',
      ]);


      $thisid = DB::table('users')->insertGetId( 
        [
          'name'=>$request['name'],
          'email'=>$request['email'],
          'phone_number'=>$request['phone'],
          'photo'=>'male.png',
          'ref_by'=>Auth::user()->id,
          'password'=>bcrypt($request['password']),
          'created_at'=>\Carbon\Carbon::now(),
          'updated_at'=>\Carbon\Carbon::now(),
        ]
       );
       
       /*
       //check if the refferral already exists
          $agent=agents::where('agent',Auth::user()->id)->first();
          if(count($agent)==1){
            //update the agent info
          agents::where('id',$agent->id)->increment('total_refered', 1);
          }
          else{
            //add the referee to the agents model

          $agent_id = DB::table('agents')->insertGetId(
            [
              'agent' => Auth::user()->id,
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
            ]
           );
          //increment refered clients by 1
          agents::where('id',$agent_id)->increment('total_refered', 1);
            }
       */

       //assign referal link to user
        $settings=settings::where('id', '=', '1')->first();

        users::where('id', $thisid)
          ->update([
          'ref_link' => $settings->site_address.'/ref/'.$thisid,
          ]);
        return redirect()->back()
        ->with('message', 'User Registered Sucessful!');
  }

   //block user
   public function ublock($id){
  
    users::where('id',$id)
    ->update([
    'status' => 'blocked',
    ]);
    return redirect()->route('manageusers')
    ->with('message', 'Action Sucessful!');
  }

   //unblock user
   public function unblock($id){

    users::where('id',$id)
    ->update([
    'status' => 'active',
    ]);
    return redirect()->route('manageusers')
    ->with('message', 'Action Sucessful!');
  }
  
 //Controller self ref issue
public function ref(Request $request, $id){
  if(isset($id)){
  $request->session()->flush();
  if(count(users::where('id',$id)->first())==1){
    $request->session()->put('ref_by', $id);
  }
  return redirect()->route('register');
}
}

  
    //update Profile photo to DB
    public function updatephoto(Request $request){
        
        $this->validate($request, [
        'photo' => 'mimes:jpg,jpeg,png|max:5000',
        ]);

          //photo
          $img=$request->file('photo');
          $upload_dir="../$settings->files_key/cloud/uploads";
          
          $image=$img->getClientOriginalName();
          $move=$img->move($upload_dir, $image);
          users::where('id', $request['id'])
          ->update([
          'photo' => $image,
          ]);
          return redirect()->back()
          ->with('message', 'Photo Updated Sucessful');
    }

    //return add account form
    public function accountdetails(Request $request){
      return view('updateacct')->with(array(
        'title'=>'Update account details',
        'settings' => settings::where('id', '=', '1')->first()
        ));
    }
    //update account and contact info
    public function updateacct(Request $request){
    
          users::where('id', $request['id'])
          ->update([
          'bank_name' => $request['bank_name'],
          'account_name' =>$request['account_name'], 
          'account_no' =>$request['account_number'], 
          'btc_address' =>$request['btc_address'], 
          'eth_address' =>$request['eth_address'], 
          ]);
          return redirect()->back()
          ->with('message', 'User updated Sucessful');
    }

    //return add change password form
    public function changepassword(Request $request){
      return view('changepassword')->with(array('title'=>'Change Password','settings' => settings::where('id', '=', '1')->first()));
    }

    //Update Password
    public function updatepass(Request $request){
        if(!password_verify($request['old_password'],$request['current_password']))
        {
          return redirect()->back()
          ->with('message', 'Incorrect Old Password');
        }
        $this->validate($request, [
        'password_confirmation' => 'same:password',
        'password' => 'min:6',
        ]);

          users::where('id', $request['id'])
          ->update([
          'password' => bcrypt($request['password']),
          ]);
          return redirect()->back()
          ->with('message', 'Password Updated Sucessful');
    } 

    public function referuser(){
      return view('referuser')->with(array(
        'title'=>'Refer user',
        'settings' => settings::where('id', '=', '1')->first()));

    }
    
    
    // pay with coinpayment option
    public function cpay($amount, $coin, $ui, $msg){
     
     return $this->paywithcp($amount, $coin, $ui, $msg);
        
    }
    
    
    public function autotopup(){
        
        //calculate top up earnings and
          //auto increment earnings after the increment time
          
          //get user plans
          $plans=user_plans::where('active','yes')->get();
          foreach($plans as $plan){
              //get plan
              $dplan=plans::where('id',$plan->plan)->first();
              //get user
              $user=users::where('id',$plan->user)->first();
              //get settings
              $settings=settings::where('id','1')->first();
              
              //check if trade mode is on
              if($settings->trade_mode=='on'){
                  //get plan xpected return
                  $to_receive=$dplan->expected_return;
                  //know the plan increment interval
                  if($dplan->increment_interval=="Monthly"){
                  $togrow=\Carbon\Carbon::now()->subMonths(1)->toDateTimeString();
                  $dtme = $plan->last_growth->diffInMonths();
                }elseif($dplan->increment_interval=="Weekly"){
                  $togrow=\Carbon\Carbon::now()->subWeeks(1)->toDateTimeString();
                  $dtme = $plan->last_growth->diffInWeeks();
                }elseif($dplan->increment_interval=="Daily"){
                  $togrow=\Carbon\Carbon::now()->subDays(1)->toDateTimeString();
                  $dtme = $plan->last_growth->diffInDays();
                }elseif($dplan->increment_interval=="Hourly"){
                  $togrow=\Carbon\Carbon::now()->subHours(1)->toDateTimeString();
                  $dtme = $plan->last_growth->diffInHours();
                }
                
                //expiration
                if($plan->inv_duration=="One week"){
                  $condition=$plan->activated_at->diffInDays() < 7 && $user->trade_mode=="on";
                  $condition2=$plan->activated_at->diffInDays() >= 7;
                }elseif($plan->inv_duration=="One month"){
                  $condition=$plan->activated_at->diffInDays() < 30 && $user->trade_mode=="on";
                  $condition2=$plan->activated_at->diffInDays() >= 30;
                }elseif($plan->inv_duration=="Three months"){
                  $condition=$plan->activated_at->diffInDays() < 90 && $user->trade_mode=="on";
                  $condition2=$plan->activated_at->diffInDays() >= 90;
                }elseif($plan->inv_duration=="Six months"){
                  $condition=$plan->activated_at->diffInDays() < 180 && $user->trade_mode=="on";
                  $condition2=$plan->activated_at->diffInDays() >= 180;
                }
                elseif($plan->inv_duration=="One year"){
                  $condition=$plan->activated_at->diffInDays() < 360 && $user->trade_mode=="on";
                  $condition2=$plan->activated_at->diffInDays() >= 360;
                }
                
                 //calculate increment
                if($dplan->increment_type=="Percentage"){
                  $increment=($plan->amount*$dplan->increment_amount)/100;
                }else{
                  $increment=$dplan->increment_amount;
                }
                
                if($condition){
    
                  if($plan->last_growth <= $togrow){
                  $amt = intval($dtme/1);
                  /*if($amt >1){
                     
                    for($i = 1; $i <= $amt; $i++){
                        $uincrement=$increment*$amt;
                        if($i == $amt){
                        user_plans::where('id', $plan->id)
                        ->update([
                        'last_growth' => \Carbon\Carbon::now(),
                        ]);
                        }
                        
                   users::where('id', $plan->user)
                    ->update([
                    'roi' => $user->roi + $uincrement,
                    'account_bal' => $user->account_bal + $uincrement,
                    ]);
                    
                    //save to transactions history
                    $th = new tp_transactions();
                    
                    $th->plan = $dplan->name;
                    $th->user = $user->id;
                    $th->amount = $increment;
                    $th->type = "ROI";
                    $th->save();
                    
                    //send email notification
                    $objDemo = new \stdClass();
                  $objDemo->receiver_email = $user->email;
                   $objDemo->receiver_plan = $dplan->name;
                   $objDemo->received_amount = "$settings->currency$increment";
                  $objDemo->sender = $settings->site_name;
                  $objDemo->receiver_name = $user->name;
                  $objDemo->date = \Carbon\Carbon::Now();
            
                  Mail::to($user->email)->send(new newroi($objDemo));
                    
                    }
                  }
                  else{*/
                    users::where('id', $plan->user)
                    ->update([
                    'roi' => $user->roi + $increment,
                    'account_bal' => $user->account_bal + $increment,
                    ]);
                    
                    //save to transactions history
                    $th = new tp_transactions();
                    
                    $th->plan = $dplan->name;
                    $th->user = $user->id;
                    $th->amount = $increment;
                    $th->type = "ROI";
                    $th->save();
                    
                    user_plans::where('id', $plan->id)
                    ->update([
                    'last_growth' => \Carbon\Carbon::now()
                    ]);
                    
                    //send email notification
                    $objDemo = new \stdClass();
                  $objDemo->receiver_email = $user->email;
                   $objDemo->receiver_plan = $dplan->name;
                   $objDemo->received_amount = "$settings->currency$increment";
                  $objDemo->sender = $settings->site_name;
                  $objDemo->receiver_name = $user->name;
                  $objDemo->date = \Carbon\Carbon::Now();
            
                  Mail::to($user->email)->send(new newroi($objDemo));
                  //}
                  }
                }
                
                //release capital
            if($condition2){
                 users::where('id', $plan->user)
                    ->update([
                    'account_bal' => $user->account_bal + $plan->amount,
                ]);
                
                //plan expired
                user_plans::where('id', $plan->id)
                ->update([
                'active' => "expired",
                ]);
                
                //save to transactions history
                    $th = new tp_transactions();
                    
                    $th->plan = $dplan->name;
                    $th->user = $plan->user;
                    $th->amount = $plan->amount;
                    $th->type = "Investment capital";
                    $th->save();
                    
                    //send email notification
                    $objDemo = new \stdClass();
                  $objDemo->receiver_email = $user->email;
                   $objDemo->receiver_plan = $dplan->name;
                   $objDemo->received_amount = "$settings->currency$plan->amount";
                  $objDemo->sender = $settings->site_name;
                  $objDemo->receiver_name = $user->name;
                  $objDemo->date = \Carbon\Carbon::Now();
            
                  Mail::to($user->email)->send(new endplan($objDemo));
            }
                
                  
              }
              
          }
          //do auto confirm payments
          return $this->cpaywithcp();
     
    }
    
    public function getRefs($array, $parent, $level = 0) {
            $referedMembers = '';
            $array=users::all();
            foreach ($array as $entry) {
                if ($entry->ref_by == $parent) {
                   // return "$entry->id <br>";
                    $referedMembers .= '- ' . $entry->name . '<br/>';
                    $referedMembers .= $this->getRefs($array, $entry->id, $level+1);
                    
                    if($level == 1){
                        $referedMembers .="1 <br>";
                    }elseif($level == 2){
                        $referedMembers .="2 <br>";
                    }elseif($level == 3){
                        $referedMembers .="3 <br>";
                    }elseif($level == 4){
                        $referedMembers .="4 <br>";
                    }elseif($level == 5){
                        $referedMembers .="5 <br>";
                    }elseif($level == 0){
                        $referedMembers .="0 <br>";
                    }
                }
            }
            return $referedMembers;
    }
    
    //Get uplines
function getAncestors($array, $deposit_amount, $parent = 0, $level = 0) {
  $referedMembers = '';
  $parent=users::where('id',$parent)->first();
  foreach ($array as $entry) {
    
      if ($entry->id == $parent->ref_by) {
          //get settings 
          $settings=settings::where('id', '=', '1')->first();
                    
           if($level == 1){
          $earnings=$settings->referral_commission1*$deposit_amount/100;
          //add earnings to ancestor balance
            users::where('id',$entry->id)
            ->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
            ]);
          }elseif($level == 2){
          $earnings=$settings->referral_commission2*$deposit_amount/100;
          //add earnings to ancestor balance
            users::where('id',$entry->id)
            ->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
            ]);
          }elseif($level == 3){
          $earnings=$settings->referral_commission3*$deposit_amount/100;
          //add earnings to ancestor balance
            users::where('id',$entry->id)
            ->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
            ]);
          }elseif($level == 4){
          $earnings=$settings->referral_commission4*$deposit_amount/100;
          //add earnings to ancestor balance
            users::where('id',$entry->id)
            ->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
            ]);
          }elseif($level == 5){
          $earnings=$settings->referral_commission5*$deposit_amount/100;
          //add earnings to ancestor balance
            users::where('id',$entry->id)
            ->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
            ]);
         
          }

          if($level == 6){
          break;
          }
          
          //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
          $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level+1);
      
       }
  }
  return $referedMembers;
}

    
    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
     
        return $random_string;
    }

}