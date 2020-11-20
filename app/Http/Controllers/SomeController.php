<?php

namespace App\Http\Controllers;

use App\settings;
use App\users;
use App\user_plans;
use App\plans;
use App\withdrawals;
use App\deposits;
use App\assets;
use App\markets;
use App\cp_transactions;
use App\tp_transactions;
use App\notifications;
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
    public function settings(Request $request){
      include'currencies.php';
      return view('settings')->with(array(
        'settings' => settings::where('id', '=', '1')->first(),
        'wmethods' => wdmethods::where('type', 'withdrawal')->get(),
        'assets' => assets::all(),
        'markets' => markets::all(),
        'cpd' => cp_transactions::where('id', '=', '1')->first(),
        'currencies' => $currencies,
        'title' =>'System Settings'));
      //return view('settings')->with(array('settings' => settings::where('id', '=', '1')->first(),'title' =>'System Settings'));
    }
    
    
    //Add withdrawal and deposit method
    public function addwdmethod(Request $request){
        $method = new wdmethods;
        $method->name=$request['name'];
        $method->minimum=$request['minimum'];
        $method->maximum=$request['maximum'];
        $method->charges_fixed=$request['charges_fixed'];
        $method->charges_percentage=$request['charges_percentage'];
        $method->duration=$request['duration'];
        $method->type=$request['type'];
        $method->status=$request['status'];
        $method->save();
        return redirect()->back()->with('message','Method added successful!');
        
    }
    
    //Update withdrawal and deposit method
    public function updatewdmethod(Request $request){
        
        wdmethods::where('id', $request['id'])
          ->update([
          'name'=>$request['name'],
          'minimum'=>$request['minimum'],
          'maximum'=>$request['maximum'],
          'charges_fixed'=>$request['charges_fixed'],
          'charges_percentage'=>$request['charges_percentage'],
          'duration'=>$request['duration'],
          'type'=>$request['type'],
          'status'=>$request['status'],
          ]);
          return redirect()->back()
          ->with('message', 'Action Successful');
        
    }
    
    //Delete withdrawal and deposit method
    public function deletewdmethod($id){
        wdmethods::where('id',$id)->delete();
        return redirect()->back()->with('message','Withdrawal method deleted successful!');
    }

        //save Setttings to DB
        public function updatesettings(Request $request){
          
          /*if($request['payment_mode']=='BTC'){
            $currency='BTC';
          }elseif($request['payment_mode']=='ETH'){
            $currency='ETH';
          }else{
            $currency=$request['currency'];
          }*/
        

          settings::where('id', $request['id'])
          ->update([
          'withdrawal_option'=>$request['withdrawal_option'],
          'payment_mode'=>$request['payment_mode1'].$request['payment_mode2'].
          $request['payment_mode3'].$request['payment_mode4'].$request['payment_mode5'].$request['payment_mode6'],
          'bank_name'=>$request['bank_name'],
          'account_name'=>$request['account_name'],
          'account_number'=>$request['account_number'],
          'btc_address'=>$request['btc_address'],
          'ltc_address'=>$request['ltc_address'],
          'eth_address'=>$request['eth_address'],
          's_s_k'=>$request['s_s_k'],
          's_p_k'=>$request['s_p_k'],
          'pp_ci'=>$request['pp_ci'],
          'pp_cs'=>$request['pp_cs'],
          'updated_by'=>Auth::user()->name,
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }
    public function updateasset(Request $request){

      $assets = new assets;
      $assets->category=$request['asset_catgy'];
      $assets->name=$request['asset_name'];
      $assets->symbol=$request['asset_symbol'];
      //$assets->commission_type=$request['coom_type'];
      //$assets->commission_fee=$request['com_fee'];
      $assets->save();

      return redirect()->back()
      ->with('message', 'Action Sucessful');
}

public function updatemarket(Request $request){
    $market = new markets;
    $market->market=$request['mktcatgy'];
    $market->base_curr=$request['base_currency'];
    $market->quote_curr=$request['quote_currency'];
   // $market->commission_type=$request['commfee_type'];
    //$market->commission_fee=$request['live_com_fee'];
    $market->save();
    return redirect()->back()
      ->with('message', 'Action Sucessful');
}

public function updatefee(Request $request){

  settings::where('id', $request->id)
    ->update([
      'commission_type'=> $request->commission_type,
      'commission_fee'=> $request->commission_fee,
      'updated_by'=>Auth::user()->name,
    ]);
  return redirect()->back()
    ->with('message', 'Action Sucessful');
}

public function delmarket($id){
  markets::where('id',$id)->delete();
  return redirect()->back()
          ->with('message', 'Market Sucessfully Deleted');
}

public function delassets($id){
  assets::where('id',$id)->delete();
  return redirect()->back()
          ->with('message', 'Asset Sucessfully Deleted');
}

public function updatemark(Request $request){

      markets::where('id', $request->id)
        ->update([
          'market'=> $request->mktcatgy,
          'base_curr'=> $request->base_currency,
          'quote_curr'=> $request->quote_currency,
          // 'commission_type'=> $request->commission_type,
          // 'commission_fee'=> $request->commission_fee,
        ]);
          return redirect()->back()
          ->with('message', 'Market Sucessfully Updated');
}

public function updateasst(Request $request){

  assets::where('id', $request->id)
    ->update([
      'name'=> $request->assname,
      'symbol'=> $request->assym,
      'category'=> $request->ascat,
      // 'commission_type'=> $request->commission_type,
      // 'commission_fee'=> $request->commission_fee,
    ]);
      return redirect()->back()
      ->with('message', 'Asset Sucessfully Updated');
}


    public function updatewebinfo(Request $request){
     
          $sa=$request['site_address'];

      $this->validate($request, [
        'logo' => 'mimes:jpg,jpeg,png|max:500',
        ]);

        $settings = settings::where('id', '=', '1')->first();
          if(empty($request->file('logo'))){
            $image=$settings->logo;
          }else{
           //process logo
          $img=$request->file('logo');
          $upload_dir="../$settings->files_key/cloud/uploads";
          $image=$img->getClientOriginalName();
          $move=$img->move($upload_dir, $image);
          }
          
          settings::where('id', $request['id'])
          ->update([
          'update'=>$request['update'],
          'site_name'=>$request['site_name'],
          'description'=>$request['description'],
          'keywords'=>$request['keywords'],
          'site_title'=>$request['site_title'],
          'logo'=>$image,
          'tawk_to'=>strip_tags($request['tawk_to']),
          'site_address'=>$request['site_address'],
          'updated_by'=>Auth::user()->name,
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }

    public function updateemail(Request $request){
     
      settings::where('id', $request['id'])
      ->update([
      'regmessage'=>$request['regmessage'],
      'regsubject'=>$request['regsubject'],
      'updated_by'=>Auth::user()->name,
      ]);
      return redirect()->back()
      ->with('message', 'Action Sucessful');
}

    public function updatepreference(Request $request){

      
      if(isset($request['trade_mode']) and $request['trade_mode']=='on'){
        $trade_mode="on";
      }else{
        $trade_mode="off";
      }
      
      if(isset($request['enable_2fa']) and $request['enable_2fa']=='yes'){
        $enable_2fa="yes";
      }else{
        $enable_2fa="no";
      }
      
      if(isset($request['enable_kyc']) and $request['enable_kyc']=='yes'){
        $enable_kyc="yes";
      }else{
        $enable_kyc="no";
      }
      
      if(isset($request['enable_verification']) and $request['enable_verification']=='true'){
        $enable_verification="true";
        
        //change status column to active on users table
        
        $sql=DB::statement("ALTER TABLE `users` CHANGE `status` `status` VARCHAR(25) DEFAULT 'blocked'"); 
        
      }else{
        $enable_verification="false";
        //change status column to active on users table
        
        $sql=DB::statement("ALTER TABLE `users` CHANGE `status` `status` VARCHAR(25) DEFAULT 'active'"); 
      }

      settings::where('id', $request['id'])
          ->update([
          'contact_email'=>$request['contact_email'],
          'currency'=>$request['currency'],
          's_currency'=>$request['s_currency'],
          'site_preference'=>$request['site_preference'],
          'site_colour'=>$request['site_colour'],
          'updated_by'=>Auth::user()->name,

          'enable_verification'=>$enable_verification,
          'trade_mode'=>$trade_mode,
          'enable_2fa'=>$enable_2fa,
          'enable_kyc'=>$enable_kyc,
          'updated_by'=>Auth::user()->name,
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }

    public function updatebot(Request $request){
      $te=$request['telegram_token'];

      if(isset($request['bot_activate']) && $request['bot_activate']=='true' && $request['site_preference']=="Telegram bot only"){
        $bot_activate="true";
        
        //activate bot
        // create a new cURL resource
        $ch = curl_init();
        
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$te/setWebhook?url=$sa/botman");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        // grab URL and pass it to the browser
        curl_exec($ch);
        
        // close cURL resource, and free up system resources
        curl_close($ch);
      }else{
        $bot_activate="false";
        
        //deactivate bot
        // create a new cURL resource
        $ch = curl_init();
        
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$te/deleteWebhook?url=$sa/botman");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        // grab URL and pass it to the browser
        curl_exec($ch);
        
        // close cURL resource, and free up system resources
        curl_close($ch);
      }
      
      /*
      //check if telegram token is not set then set it
      if($settings->telegram_token==""){
          //pass telegram token to the .env file
          $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "TELEGRAM_TOKEN=", "TELEGRAM_TOKEN=$te", file_get_contents($path)
            ));
        }
        }*/
        
    /*    
      if(isset($request['tawk_to'])){
        $file = base_path('resources/views/livechat.blade.php');
        $fp = fopen("$file", 'w');
        $content = $request['tawk_to'];
        fwrite($fp, "$content");
        fclose($fp);
      }*/

      settings::where('id', $request['id'])
          ->update([

          'telegram_token'=>$request['telegram_token'],
          'bot_activate'=>$bot_activate,
          'bot_group_chat'=>$request['bot_group_chat'],
          'bot_channel'=>$request['bot_channel'],
          'bot_link'=>$request['bot_link'],
          'updated_by'=>Auth::user()->name,
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }

    public function updatebotswt(Request $request){
      
      settings::where('id', $request['id'])
          ->update([

          'referral_commission'=>$request['ref_commission'],
          'referral_commission1'=>$request['ref_commission1'],
          'referral_commission2'=>$request['ref_commission2'],
          'referral_commission3'=>$request['ref_commission3'],
          'referral_commission4'=>$request['ref_commission4'],
          'referral_commission5'=>$request['ref_commission5'],
          'signup_bonus'=>$request['signup_bonus'],
          
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }

     //Update Subscription Fees
     public function updatesubfee(Request $request){
       
      settings::where('id', $request['id'])
      ->update([
      'monthlyfee'=>$request['monthlyfee'],
      'quaterlyfee'=>$request['quaterlyfee'],
      'yearlyfee'=>$request['yearlyfee'],
      'updated_by'=>Auth::user()->name,
      ]);
      return redirect()->back()
      ->with('message', 'Action Sucessful');
}


      //Trading history route
     public function tradinghistory(){
      
      return view('thistory')
      ->with(array(
        
        't_history' => tp_transactions::where('user',Auth::user()->id)->orderBy('id', 'desc')
               ->paginate(12),
        'title' => 'Trading History',
        'settings' => settings::where('id', '=', '1')->first(),
      ));
  }
  
  //Notification route
  public function notification(){
      
    return view('notification')
    ->with(array(
      'Notif' => notifications::where('user_id',Auth::user()->id)->orderBy('id', 'desc')
             ->paginate(12),
      'title' => 'Notification',
      'settings' => settings::where('id', '=', '1')->first(),
    ));
}

//Profile route
public function profile(){
  $userinfo = users::where('id',Auth::user()->id)->first();
  return view('profile')->with(array(
    'userinfo' => $userinfo,
    'title' => 'Profile',
    'settings' => settings::where('id', '=', '1')->first(),
  ));
}


//Updating Profile Route
public function updateprofile(Request $request){
    users::where('id', Auth::user()->id)->first()
        ->update([
          'name'=> $request->firstname,
          'l_name'=> $request->surname,
          'dob'=> $request->dob,
		  'phone_number'=> $request->phone,
          'adress'=> $request->address,
        ]);
    return redirect()->back()
    ->with('message', 'Account Update Sucessful!');
    
}

public function delnotif($id){
  notifications::where('id',$id)->delete();
  //$notif =notifcations::where('id',$id)->delete();
  return redirect()->back()
          ->with('message', 'Message Sucessfully Deleted');
}

  //save CoinPayments credentials to DB
        public function updatecpd(Request $request){

          cp_transactions::where('id', '1')
          ->update([
          'cp_p_key'=>$request['cp_p_key'],
          'cp_pv_key'=>$request['cp_pv_key'],
          'cp_m_id'=>$request['cp_m_id'],
          'cp_ipn_secret'=>$request['cp_ipn_secret'],
          'cp_debug_email'=>$request['cp_debug_email'],
          
          ]);
          return redirect()->back()
          ->with('message', 'Action Sucessful');
    }


    //payment route
    public function payment(Request $request){
      
      return view('payment')
      ->with(array(
        'amount'=>$request->session()->get('amount'),
        'payment_mode'=>$request->session()->get('payment_mode'),
        'pay_type' => $request->session()->get('pay_type'),
        'plan_id' => $request->session()->get('plan_id'),
        'title' => 'Make deposit',
        'settings' => settings::where('id', '=', '1')->first(),
      ));
  }



   //payment route
   public function switchaccount(Request $request){
   
    $userplan=user_plans::where('id',$request['id'])->first();
  

    if ($request->time == "later") {
          users::where('id', $request['id'])
          ->update([
          'acnt_type_active'=> "no",
          'plan'=> $request['acnt_change'],
          ]);
          user_plans::where('user',Auth::user()->id)->delete();
          return redirect()->route('mplans')
          ->with('message', 'Account Type Changed Successfully, Please Purchase this account.');
    }else {
      users::where('id', $request['id'])
      ->update([
      'acnt_type_active'=> "no",
      'plan'=> $request['acnt_change'],
      ]);
    }
    
    return redirect()->back()
    ->with('message', 'Account Type Changed Successfully');
}

    //top up route
    public function topup(Request $request){

      $user=users::where('id',$request['user_id'])->first();
      $userdpo = deposits::where('user', $request['user_id'])->first;
      $user_bal=$user->account_bal;
      $user_bonus=$user->bonus;
      $user_roi=$user->roi;
      $user_Ref=$user->ref_bonus;
      $user_deposit = $userdpo->amount;

      if($request['t_type']=="Credit") {
        if ($request['type']=="Bonus") {
          users::where('id', $request['user_id'])
            ->update([
            'bonus'=> $user_bonus + $request['amount'],
            'account_bal'=> $user_bal + $request->amount,
            ]);
        }elseif ($request['type']=="Profit") {
          users::where('id', $request->user_id)
            ->update([
              'roi'=> $user_roi + $request->amount,
              'account_bal'=> $user_bal + $request->amount,
            ]);
        }elseif($request['type']=="Ref_Bonus"){
          users::where('id', $request->user_id)
            ->update([
              'Ref_Bonus'=> $user_Ref + $request->amount,
              'account_bal'=> $user_bal + $request->amount,
            ]);
        }elseif ($request['type']=="Deposit") {
          $dp=new deposits();
          $dp->amount= $request['amount'];
          $dp->payment_mode= 'Admin Top Up';
          $dp->status= 'Processed';
          $dp->plan= $request['user_pln'];
          $dp->user= $request['user_id'];
          $dp->save();
          users::where('id', $request['user_id'])
            ->update([
              'account_bal'=> $user_bal + $request->amount,
            ]);
        }
      }elseif($request['t_type']=="Debit") {
        if ($request['type']=="Bonus") {
          users::where('id', $request['user_id'])
            ->update([
            'bonus'=> $user_bonus - $request['amount'],
            'account_bal'=> $user_bal - $request->amount,
            ]);
        }elseif ($request['type']=="Profit") {
            users::where('id', $request->user_id)
              ->update([
                'roi'=> $user_roi - $request->amount,
                'account_bal'=> $user_bal - $request->amount,
              ]);
          }elseif($request['type']=="Ref_Bonus"){
            users::where('id', $request->user_id)
              ->update([
                'Ref_Bonus'=> $user_Ref - $request->amount,
                'account_bal'=> $user_bal - $request->amount,
              ]);
          }
      }
          return redirect()->route('manageusers')
          ->with('message', 'Action Successful!');
    }
    
    
    //Return KYC route
      public function kyc()
      {
        return view('kyc')
          ->with(array(
          'title'=>'KYC',
          'users' => users::where('id_card','!=', NULL)
          ->where('passport','!=', NULL)->get(),
          'settings' => settings::where('id', '=', '1')->first(),
          ));
      }
      
       //Save verification documents requests
  public function savevdocs(Request $request){

      $this->validate($request, [
      'id' => 'mimes:jpg,jpeg,png|max:4000',
      'passport' => 'mimes:jpg,jpeg,png|max:4000',
      ]);
      
      $settings=settings::where('id','1')->first();
        
        //proofs
        $id=$request->file('id');
        $passport=$request->file('passport');
        $upload_dir="../$settings->files_key/cloud/uploads";
        
        $image1=$id->getClientOriginalName();
        $move=$id->move($upload_dir, $image1);
        
        $image2=$passport->getClientOriginalName();
        $move=$passport->move($upload_dir, $image2);
        //end proofs process
       
    //update user
    users::where('id',Auth::user()->id)
    ->update([
        'id_card' => $image1,
        'passport' => $image2,
        'account_verify' => 'Under review',
        ]);

  return redirect()->back()
  ->with('message', 'Action Sucessful! Please wait for system to validate your submission.');
}
  
  
   //accept KYC route
      public function acceptkyc($id)
      {
        //update user
        users::where('id',$id)
        ->update([
            'account_verify' => 'Verified',
            ]);
    
      return redirect()->back()
      ->with('message', 'Action Sucessful!');
      }
      
       //accept KYC route
      public function rejectkyc($id)
      {
        //update user
        users::where('id',$id)
        ->update([
            'account_verify' => 'Rejected',
            ]);
    
      return redirect()->back()
      ->with('message', 'Action Sucessful!');
      }
    
    

    //Return payment page
    public function deposit(Request $request){
       /*
         //fetch user plan
    $dplan=plans::where('id',Auth::user()->plan)->first();
    
    if(count($dplan)<1){
        return redirect()->route('mplans')
      ->with('message', 'Please choose an investment plan first.');
    }
  
  
    if($request['amount'] != $dplan->price){
        return redirect()->back()->with('message',"The amount must be your current plan price. $dplan->price.");
    }*/
      //store payment info in session
      $request->session()->put('amount', $request['amount']);
      $request->session()->put('payment_mode', $request['payment_mode']);

      if(isset($request['pay_type'])){
      $request->session()->put('pay_type', $request['pay_type']);
      $request->session()->put('plan_id', $request['plan_id']);
      }

      return redirect()->route('payment')
      ->with(array(
        'title' => 'Make deposit',
        'settings' => settings::where('id', '=', '1')->first(),
      ));
  }

  //Save deposit requests
  public function savedeposit(Request $request){

      $this->validate($request, [
      'proof' => 'mimes:jpg,jpeg,png|max:4000',
      ]);
        
        $settings=settings::where('id','1')->first();
        
        //screenshot
        $img=$request->file('proof');
        $upload_dir="../$settings->files_key/cloud/uploads";
        
        $image=$img->getClientOriginalName();
        $move=$img->move($upload_dir, $image);
        //end screenshot process
        
        if($request['pay_type']=='plandeposit'){
          //add the user to this plan for approval
          users::where('id',Auth::user()->id)
          ->update([
            'plan'=> $request['plan_id'],
          ]);
          $plan=$request['plan_id'];
        }elseif($request['pay_type'] == 'Subscription Trading'){
          $plan="Subscription Trading";
        }
        else{
          $plan=Auth::user()->plan;
        }
       
    $dp=new deposits();

    $dp->amount= $request['amount'];
    $dp->payment_mode= $request['payment_mode'];
    $dp->status= 'Pending';
    $dp->proof= $image;
    $dp->plan= $plan;
    $dp->user= Auth::user()->id;
    $dp->save();

    // Kill the session variables
    $request->session()->forget('plan_id');
    $request->session()->forget('pay_type');
    $request->session()->forget('payment_mode');
    $request->session()->forget('amount');


    //send email notification
    $objDemo = new \stdClass();
    $objDemo->message = "This is to inform you that a successful Deposit has just occured on $user->name $user->l_name Account, Amount: $settings->currency$request->amount.";
    $objDemo->sender = $settings->site_name;
    $objDemo->date = \Carbon\Carbon::Now();
    $objDemo->subject ="Successful Deposit";
        
    Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));
     
  return redirect()->route('deposits')
  ->with('message', 'Action Sucessful! Please wait for system to validate this transaction.');
}

    //Save withdrawal requests
     public function withdrawal(Request $request){
            //get settings
            $settings=settings::where('id','1')->first();
            
             if($settings->enable_kyc =="yes"){
                if(Auth::user()->account_verify != "Verified"){
                    return redirect()->back()->with('message','Your account must be verified before you can make withdrawal.');
                }
             }
            
            $method=wdmethods::where('id',$request['method_id'])->first();
            $charges_percentage = $request['amount'] * $method->charges_percentage/100;
            $to_withdraw = $request['amount'] + $charges_percentage + $method->charges_fixed;
            //return if amount is lesser than method minimum withdrawal amount
            

            if(Auth::user()->account_bal < $to_withdraw){
               return redirect()->back()
            ->with('message', 'Sorry, your account balance is insufficient for this request.'); 
            }
            
            if($request['amount'] < $method->minimum){
               return redirect()->back()
            ->with("message", "Sorry, The minimum amount is $settings->currency$method->minimum."); 
            }
            
            //get user last investment package
            $last_user_plan=user_plans::where('user',Auth::user()->id)
            ->where('active','yes')
            ->orderby('activated_at','ASC')->first();
            
            /*if(count($last_user_plan) < 1){
                return redirect()->back()->with('message','You can not make withdrawal yet. You must have an investment running.');
            }*/
            
           //if 30 days has reached since activation
           /*if($last_user_plan->activated_at->diffInDays() < 30){
               return redirect()->back()->with('message','Your investment(s) is not due for withdrawal yet. You must wait till 30 days after your last investment.');
           }*/
           
          //get user
         $user=users::where('id',Auth::user()->id)->first();
         
         $amount= $request['amount'];
         $ui = $user->id;

         if(empty($user->btc_address) && empty($user->ltc_address) && empty($user->eth_address) && empty($user->account_no)){
          return redirect()->route('acountdetails')
          ->with('message', 'You must set up your coins wallet address before you can withdraw.');
        }
         
         //debit user
         users::where('id',$user->id)
          ->update([
          'account_bal' => $user->account_bal-$to_withdraw,
          ]);
      
         //send notification
         $settings=settings::where('id', '=', '1')->first();
        
        //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "This is to inform you that a successful withdrawal has just occured on your account. Amount: $settings->currency$amount.";
        $objDemo->sender = $settings->site_name;
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject ="Successful withdrawal";
        Mail::bcc($user->email)->send(new NewNotification($objDemo));
         

        //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "This is to inform you that a successful withdrawal has just occured on $user->name $user->l_name Account, Amount: $settings->currency$amount.";
        $objDemo->sender = $settings->site_name;
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject ="Successful withdrawal";
        Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));
         

         if($request['payment_mode']=='Bitcoin'){
            if(empty($user->btc_address)){
                return redirect()->route('acountdetails')
                ->with('message', 'You must set up your coins wallet address before you can withdraw.');
            }
          $payment_mode = "Bitcoin";
          $coin="BTC"; 
          $wallet=$user->btc_address;
          //create auto transaction
          if($settings->withdrawal_option =="auto"){
            return $this->cpwithdraw($amount, $coin, $wallet, $ui, $to_withdraw);
          }
         }elseif($request['payment_mode']=='Ethereum'){
            if(empty($user->eth_address)){
                return redirect()->route('acountdetails')
                ->with('message', 'You must set up your coins wallet address before you can withdraw.');
            }
          $payment_mode = "Ethereum";
          $coin="ETH"; 
          $wallet=$user->eth_address;
          //create auto transaction
          if($settings->withdrawal_option =="auto"){
            return $this->cpwithdraw($amount, $coin, $wallet, $ui, $to_withdraw);
          }
         }elseif($request['payment_mode']=='Litecoin'){
            if(empty($user->ltc_address)){
                return redirect()->route('acountdetails')
                ->with('message', 'You must set up your coins wallet address before you can withdraw.');
            }
          $payment_mode = "Litecoin";
          $coin="LTC";  
          $wallet=$user->ltc_address;
          //create transaction
        //create auto transaction
          if($settings->withdrawal_option =="auto"){
            return $this->cpwithdraw($amount, $coin, $wallet, $ui, $to_withdraw);
          }
         }else{
             $payment_mode = "Bank transfer";
         }
         //save withdrawal info
            $dp=new withdrawals();
                      
            //$dp->txn_id= $txn_id;         
            $dp->amount= $amount;
            $dp->to_deduct= $to_withdraw;
            $dp->payment_mode= "$payment_mode";
            $dp->status= 'Pending';
            $dp->user= $user->id;
            
            $dp->save();  
            
            return redirect()->back()
          ->with('message', 'Action Sucessful! Please wait for system to process your request.');
         
          
    }

}
