<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} || {{ __('translate.Login') }}</title>
    <link rel="shortcut icon" href="{{asset($general_setting->favicon)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css')}}">

</head>

<body>


<!-- mobile navigation start -->
<header class="mobile-header">
    <div class="container-full">
        <div class="mobile-header__container">
            <div class="p-left">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{asset($general_setting->logo)}}" alt="logo">
                    </a>
                </div>
            </div>
            <div class="p-right">
                <button id="nav-opn-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<aside id="offcanvas-nav">
    <nav class="m-nav">
        <button id="nav-cls-btn"><i class="fa-solid fa-xmark"></i></button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{asset($general_setting->logo)}}" class="w-100" alt="logo">
            </a>
        </div>

        <ul class="nav-links">
            <li class="dropdown"><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>

            <li class="dropdown"><a href="{{route('website.categories')}}">{{__('translate.Categories')}}</a></li>

            <li class="dropdown"><a href="{{route('about')}}">{{__('translate.About')}}</a></li>

            <li class="dropdown"><a href="{{route('offer')}}">{{__('translate.Offer')}}</a></li>


            <li class="dropdown">
                <a href="{{route('contact')}}">{{__('translate.Contact Us')}}</a>

            </li>

            <li class="dropdown">
                <a href="{{route('blog')}}">{{__('translate.Blog')}}</a>
            </li>

        </ul>


        <div class="language_btn_main">
            <div class="dropdown">
                <button class="language_btn" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <span class="usd_icon">
                            {{ Session::get('currency_icon') }}
                        </span>

                        {{ Session::get('currency_name') }}
                    <span>
                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0.345964 0.942963C0.561595 0.673424 0.954903 0.629723 1.22444 0.845354L5.00067 3.86634L8.77691 0.845354C9.04645 0.629723 9.43975 0.673424 9.65538 0.942963C9.87102 1.2125 9.82731 1.60581 9.55778 1.82144L5.39111 5.15477C5.16285 5.33738 4.8385 5.33738 4.61024 5.15477L0.443573 1.82144C0.174034 1.60581 0.130333 1.2125 0.345964 0.942963Z">
                                </path>
                            </svg>

                        </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                    @foreach($currency_list as $currency)
                        <li><a class="dropdown-item" href="{{ route('currency-switcher', ['currency_code' => $currency->currency_code]) }}"> {{ $currency->currency_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown">
                <button class="language_btn" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown"
                        aria-expanded="false">


                        <span class="lun_icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.3327 9.99996C18.3327 14.6023 14.6017 18.3333 9.99935 18.3333M18.3327 9.99996C18.3327 5.39759 14.6017 1.66663 9.99935 1.66663M18.3327 9.99996C18.3327 8.61925 14.6017 7.49996 9.99935 7.49996C5.39698 7.49996 1.66602 8.61925 1.66602 9.99996M18.3327 9.99996C18.3327 11.3807 14.6017 12.5 9.99935 12.5C5.39698 12.5 1.66602 11.3807 1.66602 9.99996M9.99935 18.3333C5.39698 18.3333 1.66602 14.6023 1.66602 9.99996M9.99935 18.3333C11.8403 18.3333 13.3327 14.6023 13.3327 9.99996C13.3327 5.39759 11.8403 1.66663 9.99935 1.66663M9.99935 18.3333C8.1584 18.3333 6.66602 14.6023 6.66602 9.99996C6.66602 5.39759 8.1584 1.66663 9.99935 1.66663M1.66602 9.99996C1.66602 5.39759 5.39698 1.66663 9.99935 1.66663"
                                    stroke-width="1.2"></path>
                            </svg>


                        </span>


                        {{ strtoupper(session::get('front_lang')) }}
                    <span>
                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0.345964 0.942963C0.561595 0.673424 0.954903 0.629723 1.22444 0.845354L5.00067 3.86634L8.77691 0.845354C9.04645 0.629723 9.43975 0.673424 9.65538 0.942963C9.87102 1.2125 9.82731 1.60581 9.55778 1.82144L5.39111 5.15477C5.16285 5.33738 4.8385 5.33738 4.61024 5.15477L0.443573 1.82144C0.174034 1.60581 0.130333 1.2125 0.345964 0.942963Z">
                                </path>
                            </svg>

                        </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($language_list as $language)
                        <li><a class="dropdown-item"
                               href="{{ route('set.language', $language->lang_code) }}">{{$language->lang_name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


    </nav>
</aside>



<div class="sign_up">






    <div class="sign_up_left_side">


        <div class="s-logo">
            <a href="{{ route('home') }}">
                <img src="{{asset($general_setting->logo)}}" alt="logo">
            </a>
        </div>


        <div class="sign_up_left_slider_main">
            <div class="sign_up_left_slider">
                <div class="sign_up_left_slider_thumb">
                    <img src="{{asset($general_setting->login_image_one)}}" alt="thumb">
                </div>

                <div class="sign_up_left_slider_txt">
                    <h3>{{$general_setting->login_title_one}}</h3>

                    <p>{{$general_setting->login_description_one}}</p>
                </div>
            </div>
            <div class="sign_up_left_slider">
                <div class="sign_up_left_slider_thumb">
                    <img src="{{asset($general_setting->login_image_two)}}" alt="thumb">
                </div>

                <div class="sign_up_left_slider_txt">
                    <h3>{{$general_setting->login_title_two}}</h3>

                    <p>{{$general_setting->login_description_two}}</p>
                </div>
            </div>
            <div class="sign_up_left_slider">
                <div class="sign_up_left_slider_thumb">
                    <img src="{{asset($general_setting->login_image_three)}}" alt="thumb">
                </div>

                <div class="sign_up_left_slider_txt">
                    <h3>{{$general_setting->login_title_three}}</h3>

                    <p>{{$general_setting->login_description_three}}</p>
                </div>
            </div>
        </div>


    </div>
    <div class="sign_up_right_side">
        <div class="sign-up-main">
            <div class="sign-up-text">
                <h2>{{__('translate.Sign In')}}</h2>
            </div>

            <div class="signup-df">
                @if ($general_setting->is_gmail == 1)
                <div class="sign-up-top-btn">
                    <a href="{{ route('login-google') }}">
                            <span>
                                <svg width="23" height="22" viewBox="0 0 23 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.8758 11.2139C20.8758 10.4225 20.8103 9.84497 20.6685 9.24609H11.4473V12.818H16.8599C16.7508 13.7057 16.1615 15.0425 14.852 15.9408L14.8336 16.0603L17.7492 18.2738L17.9512 18.2936C19.8063 16.6145 20.8758 14.1441 20.8758 11.2139Z"
                                        fill="#4285F4"></path>
                                    <path
                                        d="M11.4467 20.6248C14.0984 20.6248 16.3245 19.7692 17.9506 18.2934L14.8514 15.9405C14.022 16.5073 12.9089 16.903 11.4467 16.903C8.84946 16.903 6.64512 15.224 5.85933 12.9033L5.74415 12.9129L2.7125 15.2122L2.67285 15.3202C4.28791 18.4644 7.60536 20.6248 11.4467 20.6248Z"
                                        fill="#34A853"></path>
                                    <path
                                        d="M5.86006 12.9034C5.65272 12.3045 5.53273 11.6628 5.53273 10.9997C5.53273 10.3366 5.65272 9.695 5.84915 9.09612L5.84366 8.96857L2.774 6.63232L2.67357 6.67914C2.00792 7.98388 1.62598 9.44905 1.62598 10.9997C1.62598 12.5504 2.00792 14.0155 2.67357 15.3203L5.86006 12.9034Z"
                                        fill="#FBBC05"></path>
                                    <path
                                        d="M11.4467 5.09664C13.2909 5.09664 14.5349 5.87733 15.2443 6.52974L18.0161 3.8775C16.3138 2.32681 14.0985 1.375 11.4467 1.375C7.60539 1.375 4.28792 3.53526 2.67285 6.6794L5.84844 9.09638C6.64514 6.77569 8.84949 5.09664 11.4467 5.09664Z"
                                        fill="#EB4335"></path>
                                </svg>
                            </span>

                        {{__('translate.Sign In with Google')}}
                    </a>
                </div>

            @endif

            @if ($general_setting->is_facebook == 1)

                <div class="sign-up-top-btn">
                    <a href="{{ route('login-facebook') }}">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 10C20 14.9914 16.343 19.1285 11.5625 19.8785V12.8906H13.8926L14.3359 10H11.5625V8.12422C11.5625 7.3332 11.95 6.5625 13.1922 6.5625H14.4531V4.10156C14.4531 4.10156 13.3086 3.90625 12.2145 3.90625C9.93047 3.90625 8.4375 5.29063 8.4375 7.79688V10H5.89844V12.8906H8.4375V19.8785C3.65703 19.1285 0 14.9914 0 10C0 4.47734 4.47734 0 10 0C15.5227 0 20 4.47734 20 10Z" fill="#1877F2"/>
                                    <path d="M13.8926 12.8906L14.3359 10H11.5625V8.12418C11.5625 7.33336 11.9499 6.5625 13.1921 6.5625H14.4531V4.10156C14.4531 4.10156 13.3088 3.90625 12.2146 3.90625C9.93043 3.90625 8.4375 5.29063 8.4375 7.79688V10H5.89844V12.8906H8.4375V19.8785C8.94664 19.9584 9.46844 20 10 20C10.5316 20 11.0534 19.9584 11.5625 19.8785V12.8906H13.8926Z" fill="white"/>
                                    </svg>
                            </span>

                        {{__('translate.Sign In with Facebook')}}
                    </a>
                </div>

            @endif
            </div>



                <div class="sign-up-top-btn-text">
                    <p>{{__('translate.Or sign In with email')}}</p>
                </div>



            <form class="sign-up-from" action="{{route('user.login')}}" method="post">
                @csrf

                <input type="hidden" name="from_checkout" value="{{ request()->get('from_checkout') }}">
                <div class="sign-up-from-item">
                    <div class="sign-up-from-inner">
                        <label for="sign_in_email" class="form-label">{{ __('translate.Email') }}</label>
                        <input type="email" class="form-control" id="sign_in_email"
                               placeholder="{{ __('translate.Enter email address') }}" name="email">
                    </div>
                    <div class="sign-up-from-inner">
                        <label for="sign_in_pass" class="form-label">{{ __('translate.Password') }}</label>
                        <input type="password" class="form-control" id="sign_in_pass"
                               placeholder="{{ __('translate.Enter password') }}" name="password">

                        <div class="icon password_view" id="sign_in_pass_view">
                                <span>
                                    <i class="fa-regular fa-eye-slash"></i>
                                </span>
                        </div>

                    </div>
                </div>


                <div class="sign-up_df">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{ __('translate.Remember Me') }}
                        </label>
                    </div>
                    <a href="javascript:;" class="forgot_password_btn" data-bs-toggle="modal"
                       data-bs-target="#exampleModal7">{{__('translate.Forgot Password')}}</a>
                </div>


                <button type="submit" class="thm-btn w-100">{{ __('translate.Sign In') }}</button>
            </form>


            <div class="sign_up_btm_txt">
                <p>
                    {{ __('translate.Do not have an account?') }}
                    <span>
                            <a href="{{route('register')}}">{{ __('translate.Sign Up') }}</a>
                        </span>
                </p>
            </div>


        </div>
    </div>
</div>

<!-- reset_password_modal  -->

<div class="modal fade   reset_password_modal " id="exampleModal7" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L13 13M1 13L13 1L1 13Z" stroke="#64748B" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </span>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{ route('home') }}" class="modal_logo">
                    <img src="{{asset($general_setting->logo)}}" alt="logo">
                </a>

                <div class="modal-body_txt">
                    <h3>{{__('translate.Reset your Password')}}</h3>

                    <p>
                        {{__('translate.Enter the email address associated with your account and will send you a link to reset your password')}}</p>
                </div>


                <form class="modal_body_form" action="{{route('forgot-password')}}" method="post">
                    @csrf

                    <label for="forget_email" class="form-label">{{__('translate.Email address')}}</label>
                    <input type="email" class="form-control" id="forget_email" name="email"
                           placeholder="{{ __('translate.Enter email address') }}">

                    <div class="reset_password_modal_btn">
                        <button class="thm-btn w-100"
                                type="submit">{{__('translate.Send Mail')}}
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/slick.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/aos.js')}}"></script>
<script src="{{asset('frontend/assets/js/main.js')}}"></script>
<script src="{{ asset('global/toastr/toastr.min.js') }}"></script>

<script>

    "use strict"

    let is_password = true;
    (function($) {
        $(document).ready(function () {

            const session_notify_message = @json(Session::get('message'));
            const demo_mode_message = @json(Session::get('demo_mode'));

            if(session_notify_message != null){
                const session_notify_type = @json(Session::get('alert-type', 'info'));
                switch (session_notify_type) {
                    case 'info':
                        toastr.info(session_notify_message);
                        break;
                    case 'success':
                        toastr.success(session_notify_message);
                        break;
                    case 'warning':
                        toastr.warning(session_notify_message);
                        break;
                    case 'error':
                        toastr.error(session_notify_message);
                        break;
                }
            }

            if(demo_mode_message != null){
                toastr.warning("{{ __('translate.All Language keywords are not implemented in the demo mode') }}");
                toastr.info("{{ __('translate.Admin can translate every word from the admin panel') }}");
            }

            const validation_errors = @json($errors->all());

            if (validation_errors.length > 0) {
                validation_errors.forEach(error => toastr.error(error));
            }

            $("#sign_in_pass_view").on("click",function(e){
                is_password = !is_password;
                if(is_password){
                    $("#sign_in_pass").attr('type', 'password');

                    $("#sign_in_pass_view").html(`<span><i class="fa-regular fa-eye-slash"></i></span>`)

                }else{
                    $("#sign_in_pass").attr('type', 'text');
                    $("#sign_in_pass_view").html(`<span><i class="fa-regular fa-eye"></i></span>`)
                }
            })
        });
    })(jQuery);
</script>


</body>

</html>
