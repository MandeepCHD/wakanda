<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

/*Route::get('/', function () {
    return view('home/index');
});*/

Route::get ('');
Route::get('cloud/app/images/{file}', [ function ($file) {
    
    $settings = DB::table('settings')->where('id', '1')->first();

    $path = storage_path("../../$settings->files_key/cloud/uploads/".$file);

    if (file_exists($path)) {

        return response()->file($path, array('Content-Type' =>'image/jpeg'));

    }

    abort(503);

}]);

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');


Route::get('/', 'UsersController@index')->name('home');
Route::get('terms', 'UsersController@terms')->name('terms');
Route::get('privacy', 'UsersController@privacy')->name('privacy');
Route::get('about', 'UsersController@about')->name('about');
Route::get('contact', 'UsersController@contact')->name('contact');
Route::get('faq', 'UsersController@faq')->name('faq');
//cron url
Route::get('cron', 'Controller@autotopup')->name('cron');

/*
Route::get('autotopup', 'Controller@autotopup')->name('autotopup');
*/
Route::get('autoconfirm', 'CoinPaymentsAPI@autoconfirm')->name('autoconfirm');


Auth::routes();

    // Two Factor Authentication
    
    Route::get('2fa', 'TwoFactorController@showTwoFactorForm')->name('2fa');
    
    Route::post('2fa', 'TwoFactorController@verifyTwoFactor');
    
    Route::get('dashboard/switchuser/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@switchuser', 'as'=>'switchuser']);
    
    Route::post('dashboard/paypalverify/{amount}', 'Controller@paypalverify')->name('paypalverify');
    
     //activate account
    Route::get('activate/{session}', 'UsersController@activate_account')->name('activate');
    
    // KYC Routes
	Route::get('dashboard/kyc', ['middleware' => 'auth', 'uses'=>'SomeController@kyc', 'as'=>'kyc']);
	Route::get('dashboard/acceptkyc/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'SomeController@acceptkyc', 'as'=>'acceptkyc']);
	Route::get('dashboard/rejectkyc/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'SomeController@rejectkyc', 'as'=>'rejectkyc']);
	Route::post('dashboard/savevdocs', 'SomeController@savevdocs');


	Route::get('licensing', 'UsersController@licensing')->name('licensing');

	Route::get('dashboard/deposits', ['middleware' => 'auth', 'uses' => 'Controller@deposits'])->name('deposits');
	
	Route::get('dashboard/skip_account', ['middleware' => 'auth', 'uses' => 'Controller@skip_account'])->name('skip_account');
	Route::get('dashboard/payment', 'SomeController@payment')->name('payment');
	Route::get('dashboard/agents', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@agents'])->name('agents');
	Route::get('dashboard/viewagent/{agent}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@viewagent'])->name('viewagent');
	Route::get('dashboard/tradinghistory', 'SomeController@tradinghistory')->name('tradinghistory');
	Route::get('dashboard/manageusers', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@manageusers'])->name('manageusers')->middleware('2fa');
	Route::get('dashboard/mwithdrawals', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@mwithdrawals'])->name('mwithdrawals')->middleware('2fa');
	Route::get('dashboard/mdeposits', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@mdeposits'])->name('mdeposits')->middleware('2fa');
	Route::get('dashboard/withdrawals', ['middleware' => 'auth', 'uses' => 'Controller@withdrawals'])->name('withdrawalsdeposits')->middleware('2fa');
	
	//dashboard
	Route::get('dashboard', ['middleware' => 'auth', 'uses'=>'Controller@dashboard','as'=>'dashboard'])->middleware('2fa');
	
	Route::get('dashboard/ublock/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@ublock']);
	Route::get('dashboard/pdeposit/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@pdeposit']);

	Route::get('dashboard/closeorder/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@closeorder']);
	// Route::get('dashboard/closeinvest/{id}', 'InvestmentsController@closeinvestment');

	Route::get('dashboard/pwithdrawal/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@pwithdrawal']);
	
	Route::get('dashboard/unblock/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@unblock']);
	Route::get('dashboard/paywithcard/{amount}', ['middleware' => 'auth', 'uses' => 'UsersController@paywithcard'])->name('paywithcard');
	Route::get('dashboard/cpay/{amount}/{coin}/{ui}/{msg}', ['uses' => 'Controller@cpay'])->name('cpay');
	Route::get('dashboard/mplans', ['middleware' => 'auth', 'uses' => 'Controller@mplans'])->name('mplans');
	
	Route::get('dashboard/myplans', ['middleware' => 'auth', 'uses' => 'Controller@myplans'])->name('myplans')->middleware('2fa');

	Route::get('dashboard/makeadmin/{id}/{action}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@makeadmin', 'as'=>'makeadmin']);
	
	Route::get('dashboard/delagent/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@delagent', 'as'=>'delagent']);

	Route::get('dashboard/plans', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@plans'])->name('plans');
	Route::get('dashboard/pplans', ['middleware' => 'auth', 'uses' => 'Controller@pplan'])->name('pplans');
	Route::get('dashboard/trashplan/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'Controller@trashplan']);
	Route::get('dashboard/deletewdmethod/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'SomeController@deletewdmethod']);
	Route::get('dashboard/deldeposit/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@deldeposit', 'as'=>'deldeposit']);
	//Route::get('dashboard/joinplan/{id}', ['middleware' => 'auth', 'uses' => 'Controller@joinplan']);
	Route::get('ref/{id}', ['middleware' => 'auth', 'uses'=>'Controller@ref', 'as'=>'ref']);
	Route::get('dashboard/resetpswd/{id}', ['middleware' => 'auth', 'uses'=>'UsersController@resetpswd', 'as'=>'resetpassword']);
	Route::get('dashboard/clearacct/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'Controller@clearacct', 'as'=>'clearacct']);
	Route::get('dashboard/deluser/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@deluser', 'as'=>'deluser']);

	Route::get('dashboard/delcard/{id}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@delcard', 'as'=>'delcard']);
	
	Route::get('dashboard/usertrademode/{id}/{action}', ['middleware' => ['auth', 'admin'], 'uses'=>'UsersController@usertrademode', 'as'=>'usertrademode']);
	
	Route::get('dashboard/settings', ['middleware' => ['auth', 'admin'], 'uses'=>'SomeController@settings', 'as'=>'settings'])->middleware('2fa');
	

	//Search Routes
	Route::post('dashboard/search', ['middleware' => 'auth', 'uses' => 'Controller@search']);
	Route::post('dashboard/searchdp', ['middleware' => 'auth', 'uses' => 'Controller@searchDp']);
	Route::post('dashboard/searchWith', ['middleware' => 'auth', 'uses' => 'Controller@searchWt']);
	Route::post('dashboard/searchsub', ['middleware' => 'auth', 'uses' => 'Controller@searchsub']);

    Route::post('dashboard/joinplan', ['middleware' => 'auth', 'uses' => 'Controller@joinplan']);
	Route::post('dashboard/paywithcard/charge', ['middleware' => 'auth', 'uses' => 'UsersController@charge']);
	Route::post('dashboard/edituser', ['middleware' => 'auth', 'uses' => 'UsersController@edituser'])->middleware('admin');
	Route::post('dashboard/editorder', ['middleware' => 'auth', 'uses' => 'Controller@editorder'])->middleware('admin');
	Route::post('dashboard/updateplan', ['middleware' => 'auth', 'uses' => 'Controller@updateplan']);
	Route::post('dashboard/withdrawal', 'SomeController@withdrawal');
	Route::post('sendcontact', 'UsersController@sendcontact');
	Route::post('dashboard/deposit', 'SomeController@deposit');
	Route::post('dashboard/sendmail', 'UsersController@sendmail');
	Route::post('dashboard/sendmailsingle', 'UsersController@sendmailtooneuser');
	Route::post('dashboard/topup', 'SomeController@topup');
	Route::post('dashboard/paywcard/', ['middleware' => 'auth', 'uses' => 'UsersController@paywcard']);
	Route::post('dashboard/addagent', 'UsersController@addagent');
	Route::post('dashboard/chngemail', 'UsersController@chngemail');

	Route::post('dashboard/savedeposit', 'SomeController@savedeposit');
	Route::post('dashboard/addwdmethod', 'SomeController@addwdmethod');
	Route::post('dashboard/updatewdmethod', 'SomeController@updatewdmethod');
	Route::post('dashboard/saveuser', ['middleware' => 'auth', 'uses' => 'Controller@saveuser']);
	Route::post('dashboard/addplan', ['middleware' => 'auth', 'uses' => 'Controller@addplan']);
	
	Route::post('dashboard/updatecpd', 'SomeController@updatecpd')->middleware("admin");
	Route::post('dashboard/updatesettings', 'SomeController@updatesettings')->middleware("admin");
	Route::post('dashboard/updatepreference', 'SomeController@updatepreference')->middleware("admin");
	Route::post('dashboard/updatewebinfo', 'SomeController@updatewebinfo')->middleware("admin");
	Route::post('dashboard/updateemail', 'SomeController@updateemail')->middleware("admin");
	Route::post('dashboard/updatebot', 'SomeController@updatebot')->middleware("admin");
	Route::post('dashboard/updatebotswt', 'SomeController@updatebotswt')->middleware("admin");
	Route::post('dashboard/updateasset', 'SomeController@updateasset')->middleware("admin");
	Route::post('dashboard/updatemarket', 'SomeController@updatemarket')->middleware("admin");
	Route::post('dashboard/updatefee', 'SomeController@updatefee')->middleware("admin");
	Route::post('dashboard/updatesubfee', 'SomeController@updatesubfee')->middleware("admin");
	

	Route::get('dashboard/accountdetails', ['middleware' => 'auth', 'uses'=>'UsersController@accountdetails', 'as'=>'acountdetails']);

	Route::post('dashboard/switchaccount', ['middleware' => 'auth', 'uses'=>'SomeController@switchaccount', 'as'=>'switchaccount']);

	Route::get('dashboard/changepassword', ['middleware' => 'auth', 'uses'=>'UsersController@changepassword', 'as'=>'changepassword']);
	Route::get('dashboard/support', ['middleware' => 'auth', 'uses'=>'Controller@support', 'as'=>'support']);
	Route::get('dashboard/withdrawal', ['middleware' => 'auth', 'uses'=>'SomeController@withdrawal', 'as'=>'withdrawal']);
	Route::get('dashboard/phusers', ['middleware' => 'auth', 'uses'=>'SomeController@phusers', 'as'=>'phusers']);
	Route::get('dashboard/matchinglist', ['middleware' => 'auth', 'uses'=>'SomeController@matchinglist', 'as'=>'matchinglist']);
	Route::get('dashboard/ghuser', ['middleware' => 'auth', 'uses'=>'SomeController@ghuser', 'as'=>'ghuser']);
	Route::get('dashboard/confirmation/{id}', ['middleware' => 'auth', 'uses'=>'UsersController@confirmation', 'as'=>'confirmation']);
	Route::get('dashboard/tupload/{id}', ['middleware' => 'auth', 'uses'=>'UsersController@tupload', 'as'=>'tupload']);
	Route::get('dashboard/dnpagent', ['middleware' => 'auth', 'uses'=>'UsersController@dnpagent', 'as'=>'dnpagent']);
	Route::get('dashboard/referuser', ['middleware' => 'auth', 'uses'=>'UsersController@referuser', 'as'=>'referuser']);

	//Route::get('dashboard/notification', 'UsersController@notification');
	Route::get('dashboard/notification', ['middleware' => 'auth', 'uses'=>'SomeController@notification', 'as'=>'notification']);
	Route::get('dashboard/subtrade', ['middleware' => 'auth', 'uses' => 'Controller@subtrade'])->name('subtrade');
	Route::get('dashboard/transaction', ['middleware' => 'auth', 'uses' => 'Controller@transaction'])->name('transaction');
	Route::get('dashboard/msubtrade', ['middleware' => 'auth', 'uses' => 'Controller@msubtrade'])->name('subtrade');


	Route::post('dashboard/addbuyorder', ['middleware' => 'auth', 'uses' => 'BuySellController@addbuyorder'])->name('addbuyorder');
	Route::post('dashboard/addsellorder', ['middleware' => 'auth', 'uses' => 'BuySellController@addsellorder'])->name('addbuyorder');

	Route::get('dashboard/subpricechange', 'Controller@subpricechange')->middleware("admin");
	//Route::get('dashboard/mtransactions', 'Controller@mtransactions')->middleware("admin");
	Route::get('dashboard/mtransactions', ['middleware' => 'auth', 'uses' => 'Controller@mtransactions'])->name('mtransactions');

	Route::get('dashboard/mcards', ['middleware' => 'auth', 'uses' => 'Controller@mcards'])->name('mcards');


	Route::post('dashboard/savemt4details', ['middleware' => 'auth', 'uses'=>'Controller@savemt4details', 'as'=>'savemt4details']);

	Route::get('dashboard/profile', ['middleware' => 'auth', 'uses'=>'SomeController@profile', 'as'=>'profile']);

	Route::get('dashboard/{auto}', 'BuySellController@autotrade');

	// Upadting user profile info
	Route::post('dashboard/profileinfo', ['middleware' => 'auth', 'uses'=>'SomeController@updateprofile', 'as'=>'userprofile']);
	//Route::get('dashboar

	//Route::get('dashboard/plans', ['middleware' => 'auth', 'uses'=>'Controller@showplans', 'as'=>'plans']);
	Route::get('dashboard/delsub/{id}', 'Controller@delsub' );
	Route::get('dashboard/confirmsub/{id}', 'Controller@confirmsub' );
	Route::get('dashboard/delnotif/{id}', 'SomeController@delnotif' );
	Route::get('dashboard/delmarket/{id}', 'SomeController@delmarket' );
	Route::get('dashboard/delassets/{id}', 'SomeController@delassets' );
	Route::post('dashboard/AddHistory', 'Controller@addHistory');

	
	Route::post('dashboard/updatemark', 'SomeController@updatemark');
	Route::post('dashboard/updateasst', 'SomeController@updateasst');
	Route::post('dashboard/upload', 'UsersController@upload');
	Route::post('dashboard/confirm', 'UsersController@confirm');
	Route::get('dashboard/mconfirm/{id}/{ph_id}/{amount}', 'UsersController@mconfirm');
	Route::get('dashboard/mdelete/{id}/{ph_id}/{amount}', 'UsersController@mdelete');
	Route::post('dashboard/withdraw', 'SomeController@withdraw');
	Route::post('dashboard/updatephoto', 'UsersController@updatephoto');
	Route::post('dashboard/updateacct', 'UsersController@updateacct');
	Route::post('dashboard/updatepass', 'UsersController@updatepass');
	Route::post('dashboard/dnate', 'UsersController@dnate');
	Route::get('dashboard/donation', ['uses'=>'UsersController@donation', 'as'=>'donation']);
	Route::get('dashboard/donate/{plan}', ['uses'=>'UsersController@donate', 'as'=>'donate']);
	Route::get('ref/{id}', ['uses'=>'UsersController@ref', 'as'=>'ref']);
	Route::post('reguser', 'Auth\AuthController@reguser');
	Route::post('dashboard/saveagent', 'UsersController@saveagent');


Route::group(['middleware' => 'web'], function () {
	
});

Route::any('/activate', function () {
    return view('activate/index');
});

// ////////////////////////////////////////This is Route for invest feature
Route::post('dashboard/invest', 'InvestmentsController@invest');
Route::get('dashboard/invest', 'InvestmentsController@investpage');
Route::get('dashboard/closeinvest/{id}', 'InvestmentsController@closeinvestment');
Route::get('dashboard/investmentpacks', 'InvestmentsController@packs');
Route::get('dashboard/addeditpack/{pack}', 'InvestmentsController@addeditpack');
Route::post('dashboard/addpack', 'InvestmentsController@addpack');
Route::post('dashboard/updatepack', 'InvestmentsController@updatepack');
Route::get('dashboard/trashpack/{pack}', 'InvestmentsController@trashpack');
Route::get('dashboard/buypack/{pack}', 'InvestmentsController@buypack');
Route::get('dashboard/closepack/{pack}', 'InvestmentsController@closepack');
Route::get('dashboard/manageinvestment', ['middleware' => ['auth', 'admin'], 'uses' => 'InvestmentsController@manageinvestment'])->name('manageinvestment');
Route::get('dashboard/autotrade/{val}', 'BuySellController@switchautotrade');


// ////////////////////////////////////////This is Route for buy and sell

Route::get('trade/exchange', 'BuySellController@index');

//Route for sending ajax request on select market
Route::post('trade/changemarket', 'BuySellController@updatemarket');
Route::get('trade/closeorder/{id}', 'BuySellController@closeorder');
Route::post('trade/exchange', 'BuySellController@exchange');
Route::post('trade/fundtransfer', 'BuySellController@fundtransfer');
Route::get('trade/switchcolor/{color}', 'BuySellController@switchcolor');
Route::any('dashboard/getTradeAssets/{market}', 'BuySellController@getTradeAssets');
Route::any('dashboard/getMarketPrice/{asset}', 'GetRates@getMarketPrice');
Route::get('dashboard/getopl/{user}', 'BuySellController@getUserOpenPL');

