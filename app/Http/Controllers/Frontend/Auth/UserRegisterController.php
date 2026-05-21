<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helper\EmailHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Mail\UserRegistrationMail;
use Modules\EmailSetting\App\Models\EmailTemplate;
use Mail;
use Str;
use Session;

class UserRegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function register_view(): View
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:4|confirmed',
        ],[
            'name.required' => trans('translate.Name is required'),
            'email.required' => trans('translate.Email is required'),
            'email.unique' => trans('translate.Email already exist'),
            'password.required' => trans('translate.Password is required'),
            'password.confirmed' => trans('translate.Password confirmation does not match'),
            'password.min' => trans('translate.You have to provide minimum 4 characters'),
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'enable',
            'is_banned' => 'disable',
            'password' => Hash::make($request->password),
            'verification_token' => Str::random(100),
        ]);

        EmailHelper::mail_setup();

        $verification_link = route('user-verification').'?verification_link='.$user->verification_token.'&email='.$user->email;
        $verification_link = '<a href="'.$verification_link.'">'.$verification_link.'</a>';

        $template= EmailTemplate::where('id',4)->first();
        $subject=$template->subject;
        $message=$template->description;
        $message = str_replace('{{user_name}}',$request->name,$message);
        $message = str_replace('{{varification_link}}',$verification_link,$message);

        try {
            Mail::to($user->email)->send(new UserRegistrationMail($message,$subject,$user));
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }

        $notification= trans('translate.A varification link has been send to your mail, please verify and enjoy our service');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function custom_user_verification(Request $request): RedirectResponse
    {
        $user = User::where('verification_token',$request->verification_link)->where('email', $request->email)->first();
        if($user){

            if($user->email_verified_at != null){
                $notification = trans('translate.Email already verified');
                $notification = array('message'=>$notification,'alert-type'=>'error');
                return redirect()->route('login')->with($notification);
            }

            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_token = null;
            $user->save();

            $notification = trans('translate.Verification Successfully');
            $notification = array('message'=>$notification,'alert-type'=>'success');
            return redirect()->route('login')->with($notification);
        }else{
            $notification = trans('translate.Invalid token');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->route('register')->with($notification);
        }
    }
}
