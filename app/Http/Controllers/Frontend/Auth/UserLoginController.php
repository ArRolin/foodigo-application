<?php

namespace App\Http\Controllers\Frontend\Auth;

use Str;

use Auth;
use Mail, Config;
Use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class UserLoginController extends Controller
{
    public function index(Request $request)
    {

        $general_settings = GlobalSetting::first();

        return view('frontend.auth.login',compact('general_settings'));
    }

    public function login(Request $request): RedirectResponse
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $custom_error = [
            'email.required' => trans('translate.Email is required'),
            'password.required' => trans('translate.Password is required'),
        ];

        $this->validate($request, $rules, $custom_error);

        $user = User::where([
            'email' => $request->email
        ])->first();


        if (!$user) {
            return $this->redirectWithError(trans('translate.Email not found'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->redirectWithError(trans('translate.Credentials do not match'));
        }

        if($user->email_verified_at == null){
            $notification = trans('translate.Please verify your email');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if ($user->status !== 'enable') {
            return $this->redirectWithError(trans('translate.Your account is inactive'));
        }

        if ($user->is_banned == 'enable') {
            return $this->redirectWithError(trans('translate.Your account is banned'));
        }

        // Attempt login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {

            if($request->from_checkout && $request->from_checkout == 'yes'){
                return redirect()->route('view.checkout')->with([
                    'message' => trans('translate.Login successfully'),
                    'alert-type' => 'success'
                ]);
            }
            return redirect()->route('user.dashboard')->with([
                'message' => trans('translate.Login successfully'),
                'alert-type' => 'success'
            ]);
        }

        return $this->redirectWithError(trans('translate.Login failed due to unknown reasons'));
    }

    public function log_out(): RedirectResponse
    {
        Auth::logout();
        $notify_message = trans('translate.Logout successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('login')->with($notify_message);
    }

    public function redirect_to_google(){

        $gmail_client_id = GlobalSetting::where('key', 'gmail_client_id')->first();
        $gmail_secret_id = GlobalSetting::where('key', 'gmail_secret_id')->first();
        $gmail_redirect_url = GlobalSetting::where('key', 'gmail_redirect_url')->first();


        \Config::set('services.google.client_id', $gmail_client_id->value);
        \Config::set('services.google.client_secret', $gmail_secret_id->value);
        \Config::set('services.google.redirect', $gmail_redirect_url->value);

        return Socialite::driver('google')->redirect();

    }


    public function google_callback(){

        $gmail_client_id = GlobalSetting::where('key', 'gmail_client_id')->first();
        $gmail_secret_id = GlobalSetting::where('key', 'gmail_secret_id')->first();
        $gmail_redirect_url = GlobalSetting::where('key', 'gmail_redirect_url')->first();


        \Config::set('services.google.client_id', $gmail_client_id->value);
        \Config::set('services.google.client_secret', $gmail_secret_id->value);
        \Config::set('services.google.redirect', $gmail_redirect_url->value);

        $user = Socialite::driver('google')->user();
        $user = $this->create_user($user,'google');

        auth()->login($user);

        $notify_message= trans('translate.Login Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');

        return redirect()->route('user.dashboard')->with($notify_message);

    }


    public function redirect_to_facebook(){

        $facebook_client_id = GlobalSetting::where('key', 'facebook_client_id')->first();
        $facebook_secret_id = GlobalSetting::where('key', 'facebook_secret_id')->first();
        $facebook_redirect_url = GlobalSetting::where('key', 'facebook_redirect_url')->first();

        \Config::set('services.facebook.client_id', $facebook_client_id->value);
        \Config::set('services.facebook.client_secret', $facebook_secret_id->value);
        \Config::set('services.facebook.redirect', $facebook_redirect_url->value);

        return Socialite::driver('facebook')->redirect();
    }

    public function facebook_callback(){

        $facebook_client_id = GlobalSetting::where('key', 'facebook_client_id')->first();
        $facebook_secret_id = GlobalSetting::where('key', 'facebook_secret_id')->first();
        $facebook_redirect_url = GlobalSetting::where('key', 'facebook_redirect_url')->first();

        \Config::set('services.facebook.client_id', $facebook_client_id->value);
        \Config::set('services.facebook.client_secret', $facebook_secret_id->value);
        \Config::set('services.facebook.redirect', $facebook_redirect_url->value);

        $user = Socialite::driver('facebook')->user();
        $user = $this->create_user($user,'facebook');
        auth()->login($user);

        $notify_message= trans('translate.Login Successfully');
        $notify_message=array('message'=>$notify_message,'alert-type'=>'success');

        return redirect()->route('user.dashboard')->with($notify_message);

    }

    public function create_user($get_info, $provider){
        $user = User::where('email', $get_info->email)->first();
        if (!$user) {

            $user = User::create([
                'name'     => $get_info->name,
                'username'     => Str::slug($get_info->name).'-'.date('Ymdhis'),
                'email'    => $get_info->email,
                'provider' => $provider,
                'provider_id' => $get_info->id,
                'status' => 'enable',
                'is_banned' => 'disable',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'verification_token' => null,
            ]);

        }
        return $user;
    }

    /**
     * Helper function to handle redirect with error message.
     *
     * @param string $message
     * @return RedirectResponse
     */
    protected function redirectWithError(string $message): RedirectResponse
    {
        return redirect()->back()->with([
            'message' => $message,
            'alert-type' => 'error'
        ]);
    }


}
