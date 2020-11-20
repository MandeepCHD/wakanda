<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\Mail\NewNotification;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\settings;

use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, UserTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    protected function credentials(Request $request)
    {
    return array_merge($request->only($this->username(), 'password'), ['status' => 'active']);
    }

        
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('Wrong login details or account not activated!')],
        ]);
    }
    /*
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }

    
    protected function authenticated(Request $request, $user)
    {
    if ( $user->isAdmin() ) {// do your margic here
        return redirect()->route('dashboard');
    }

    return redirect('/');
    }
    */
    
    //protected $redirectTo = '/dashboard';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
     public function authenticated(Request $request, $user)
    {
        $user = Auth::user();
        $user->token_2fa_expiry = \Carbon\Carbon::now();
        $user->save();
        
        //get settings
         $settings = settings::where('id','1')->first();

        //$clientIP = \Request::getClientIp(true);
        $user_country = $this->ip_info("Visitor", "Country");
        
        $clientIP = $this->getUserIP();
        $browserDetails = $request->header('User-Agent');
        
        //return $browserDetails;

        //send email notification
        $objDemo = new \stdClass();
        $objDemo->message = "This is to inform you of a successful login of $user->name $user->l_name, \n from IP ADDRESS: $clientIP \n Browser & OS Details: $browserDetails \n Country: $user_country";
        $objDemo->sender = $settings->site_name;
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject ="Login Notification";
        Mail::to("$settings->contact_email")->send(new NewNotification($objDemo));
        
        return redirect()->route('dashboard');
    }
     
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
