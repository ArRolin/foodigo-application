<?php

namespace App\Http\Controllers\Restaurant\Auth;

use Auth, Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Modules\Restaurant\Entities\Restaurant;

class RestaurantLoginController extends Controller
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = '/restaurant/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return Factory|Application|View
     */

    public function restaurant_login_page(): Factory|Application|View
    {
        return view('restaurant.auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function restaurant_login(Request $request): RedirectResponse
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $custom_errors = [
            'email.required' => trans('translate.Email is required'),
            'email.email' => trans('translate.Invalid email format'),
            'password.required' => trans('translate.Password is required'),
        ];

        $this->validate($request, $rules, $custom_errors);

        $restaurant = Restaurant::where('email', $request->email)->first();

        if (!$restaurant) {
            return $this->redirectWithError(trans('translate.Email not found'));
        }

        if (!Hash::check($request->password, $restaurant->password)) {
            return $this->redirectWithError(trans('translate.Credentials do not match'));
        }

        if ($restaurant->admin_approval !== 'enable') {
            return $this->redirectWithError(trans('translate.Your account is not approved yet'));
        }

        if ($restaurant->is_banned === 'enable') {
            return $this->redirectWithError(trans('translate.Your account is banned'));
        }

        // Attempt login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('restaurant')->attempt($credentials, $request->remember)) {
            return redirect()->route('restaurant.dashboard')->with([
                'message' => trans('translate.Login successfully'),
                'alert-type' => 'success'
            ]);
        }

        return $this->redirectWithError(trans('translate.Login failed due to unknown reasons'));
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



    public function restaurant_logout(): RedirectResponse
    {
        Auth::guard('restaurant')->logout();

        $notify_message = trans('translate.Logout successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('restaurant.login')->with($notify_message);

    }
}
