<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("Register")}}</title>
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
                <h2>{{__('translate.Sign Up')}}</h2>
            </div>

            <div class="sign-up-top-btn">
                <a href="#">
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

                    {{__('translate.Sign Up with Google')}}
                </a>
            </div>

            <div class="sign-up-top-btn-text">
                <p>{{__('translate.Or sign In with email')}}</p>
            </div>

            <form class="sign-up-from" action="{{route('user.register')}}" method="post">
                @csrf
                <div class="sign-up-from-item">
                    <div class="sign-up-from-inner">
                        <label for="exampleFormControlInput1" class="form-label">{{__('translate.Full name')}}</label>
                        <input type="text" class="form-control" id="one" name="name" placeholder="Enter email address">
                    </div>
                    <div class="sign-up-from-inner">
                        <label for="exampleFormControlInput1" class="form-label">{{__('translate.Email address')}}</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                               placeholder="Enter email address">
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

                    <div class="sign-up-from-inner">
                        <label for="sign_in_confirm_pass" class="form-label">{{__('translate.Confirm Password')}}</label>
                        <input type="password" class="form-control" id="sign_in_confirm_pass"
                               placeholder="{{ __('translate.Enter password') }}" name="password_confirmation">

                        <div class="icon password_view" id="sign_in_confirm_pass_view">
                                <span>
                                    <i class="fa-regular fa-eye-slash"></i>
                                </span>
                        </div>
                    </div>
                </div>


                <div class="sign_in_btn">
                    <button type="submit" class="thm-btn w-100">{{ __('translate.Sign Up') }}</button>
                </div>

            </form>


            <div class="sign_up_btm_txt">
                <p>
                    {{__('translate.Already have an account?')}}
                    <span>
                            <a href="{{route('login')}}">{{__('translate.Sign In')}}</a>
                        </span>
                </p>
            </div>

            <div class="sign_up_btm_txt_p">
                <p>
                    {{__("By clicking 'Sign Up', you that you have read and accept the")}} <span><a
                            href="{{route('terms.and.conditions')}}">
                            {{__('translate.Terms of Service')}}</a></span> {{__('translate.and')}}
                    <span>

                            <a href="{{route('privacy.policy')}}">{{__('translate.Privacy Policy')}}.</a>
                        </span>
                </p>
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

    let is_password = true;
    let is_confirm_password = true;
    (function($) {
        "use strict"
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

            $("#sign_in_confirm_pass_view").on("click",function(e){
                is_confirm_password = !is_confirm_password;
                if(is_confirm_password){
                    $("#sign_in_confirm_pass").attr('type', 'password');

                    $("#sign_in_confirm_pass_view").html(`<span><i class="fa-regular fa-eye-slash"></i></span>`)

                }else{
                    $("#sign_in_confirm_pass").attr('type', 'text');
                    $("#sign_in_confirm_pass_view").html(`<span><i class="fa-regular fa-eye"></i></span>`)
                }
            })
        });
    })(jQuery);
</script>


</body>

</html>
