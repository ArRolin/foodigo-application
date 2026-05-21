<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helper\EmailHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserForgotPassword;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Modules\EmailSetting\App\Models\EmailTemplate;
use Str;
use Session;

use Modules\GeneralSetting\Entities\SocialLoginInfo;

class UserPasswordController extends Controller
{

    /**
     * Display the password reset link request view.
     */
    public function reset_password_page(Request $request): Factory|Application|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::select('id','name','email','forget_password_token')->where('forget_password_token', $request->token)->where('email', $request->email)->first();
        if(!$user){
            $notification = trans('translate.Invalid token, please try again');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('login')->with($notification);
        }
        $token = $request->token;
        return view('frontend.auth.reset-password-page', compact('token', 'user'));
    }

    public function custom_forgot_password(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ],[
            'email.required' => trans('translate.Email is required')
        ]);

        $user = User::where('email', $request->email)->first();

        if($user){
            $user->forget_password_token = Str::random(100);
            $user->save();

            $reset_link = route('reset-password-page').'?token='.$user->forget_password_token.'&email='.$user->email;
            $reset_link = '<a href="'.$reset_link.'">'.$reset_link.'</a>';

            EmailHelper::mail_setup();
            $template = EmailTemplate::where('id',1)->first();
            $subject = $template->subject;
            $message = $template->description;
            $message = str_replace('{{user_name}}',$user->name,$message);
            $message = str_replace('{{reset_link}}',$reset_link,$message);
            Mail::to($user->email)->send(new UserForgotPassword($message,$subject,$user));

            $notification= trans('translate.A password reset link has been send to your mail');
            $notification = array('message'=>$notification,'alert-type'=>'success');

        }else{
            $notification = trans('translate.Email does not exist');
            $notification=array('message'=>$notification,'alert-type'=>'error');
        }
        return redirect()->back()->with($notification);
    }

    /**
     * @throws ValidationException
     */
    public function custom_reset_password_store(Request $request, $token): RedirectResponse
    {
        $rules = [
            'email'=>'required',
            'password'=>'required|min:4|confirmed',
        ];
        $customMessages = [
            'email.required' => trans('translate.Email is required'),
            'password.required' => trans('translate.Password is required'),
            'password.min' => trans('translate.Password must be 4 characters'),
            'password.confirmed' => trans('translate.Confirm password does not match'),
        ];
        $this->validate($request, $rules,$customMessages);


        $user = User::select('id','name','email','forget_password_token')->where('forget_password_token', $token)->where('email', $request->email)->first();

        if(!$user){
            $notification = trans('translate.Invalid token, please try again');
            $notification = array('message'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user->password=Hash::make($request->password);
        $user->forget_password_token=null;
        $user->save();

        $notification = trans('translate.Password Reset successfully');
        $notification = array('message'=>$notification,'alert-type'=>'success');
        return redirect()->route('login')->with($notification);

    }

}
