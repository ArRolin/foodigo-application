<section class="mobile_app">
    <div class="container mobile_app_bg">
        <div class="row">


            <div class="col-xxl-12">
                <div class="mobile_app_animetion"></div>
                <div class="mobile_app_animetion two"></div>
                <div class="mobile_app_animetion three"></div>
                <div class="mobile_app_animetion four"></div>
            </div>


            <div class="col-xxl-6 col-xl-6">
                <div class="mobile_app_txt" data-aos="fade-up" data-aos-delay="100">
                    <h2>
                        {{$home_translate->mobile_app_title}}
                    </h2>

                    <p>
                        {{$home_translate->mobile_app_des}}
                    </p>
                </div>

                <div class="mobile_app_btn" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{$homepage->mobile_playstore}}" class="thm-btn_two">

                                <span>
                                    <svg width="22" height="24" viewBox="0 0 22 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_733_11089)">
                                            <path
                                                d="M10.1387 11.4414L0.0898438 21.9696C0.202692 22.3695 0.405483 22.7383 0.682716 23.0479C0.959948 23.3574 1.30428 23.5995 1.6894 23.7555C2.07451 23.9116 2.49021 23.9775 2.90471 23.9483C3.31922 23.9191 3.72155 23.7955 4.08097 23.5869L15.3879 17.1473L10.1387 11.4414Z"
                                                fill="#EA4335"/>
                                            <path
                                                d="M20.2994 9.65218L15.41 6.85156L9.90625 11.6812L15.4324 17.1326L20.2846 14.362C20.7144 14.1369 21.0745 13.7984 21.3257 13.3833C21.5769 12.9682 21.7097 12.4922 21.7097 12.007C21.7097 11.5218 21.5769 11.0459 21.3257 10.6307C21.0745 10.2156 20.7144 9.87718 20.2846 9.6521L20.2994 9.65218Z"
                                                fill="#FBBC04"/>
                                            <path
                                                d="M0.089922 1.9917C0.0291822 2.21625 -0.00105395 2.44796 2.80397e-05 2.68058V21.2807C0.000657792 21.5133 0.0308649 21.7448 0.089922 21.9697L10.4833 11.7111L0.089922 1.9917Z"
                                                fill="#4285F4"/>
                                            <path
                                                d="M10.2136 11.9808L15.4103 6.85154L4.11845 0.381885C3.6936 0.133071 3.2104 0.00130453 2.71806 5.20116e-06C1.49626 -0.00236936 0.422112 0.808542 0.0898438 1.98437L10.2136 11.9808Z"
                                                fill="#34A853"/>
                                        </g>
                                    </svg>

                                </span>
                        {{__('translate.Google Play')}}
                    </a>

                    <a href="{{$homepage->mobile_appstore}}" class="thm-btn_two two">

                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.498 0C15.2185 0.0884995 13.723 0.907495 12.8515 1.97399C12.0565 2.94148 11.4025 4.37847 11.6575 5.77497C13.0555 5.81847 14.5 4.97997 15.337 3.89548C16.12 2.88598 16.7125 1.45799 16.498 0Z"/>
                                        <path
                                            d="M21.5534 8.05167C20.3249 6.51118 18.5984 5.61719 16.9679 5.61719C14.8154 5.61719 13.9049 6.64768 12.4094 6.64768C10.8674 6.64768 9.69594 5.62019 7.83445 5.62019C6.00596 5.62019 4.05897 6.73768 2.82448 8.64867C1.08899 11.3397 1.38599 16.3991 4.19847 20.7086C5.20496 22.2506 6.54896 23.9846 8.30695 23.9996C9.87144 24.0146 10.3124 22.9961 12.4319 22.9856C14.5514 22.9736 14.9534 24.0131 16.5149 23.9966C18.2744 23.9831 19.6919 22.0616 20.6984 20.5196C21.4199 19.4141 21.6884 18.8576 22.2479 17.6096C18.1784 16.0601 17.5259 10.2732 21.5534 8.05167Z"/>
                                    </svg>

                                </span>
                        {{__('translate.Apple Store')}}
                    </a>
                </div>

            </div>


            <div class="col-xxl-6 col-xl-6" data-aos="fade-left" data-aos-delay="300">
                <div class="mobile_app_thumb_main">
                    <div class="mobile_app_thum">
                        <img src="{{asset($homepage->mobile_app_image)}}" alt="thumb">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
