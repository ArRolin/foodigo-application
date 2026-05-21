@extends('frontend.layouts.master')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection

@section('content')
    <main>
        <!-- banner-part start  -->

        <div class="profile_bg"
             style="background-image: url({{ asset($general_setting->breadcrumb_image) }});">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Contact us')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- contuct part start  -->


        <section class="contact_us">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-10">
                        <div class="contact_us_txt">
                            <h2>{{$contact_us?->title}}</h2>
                        </div>


                        <form class="contact_us_form" action="{{ route('store-contact-message') }}" method="post">


                            <div class="contuct_info_item">
                                <div class="contuct_info_inner">
                                    <div class="contuct_info_inner_icon">
                                        <span>
                                            <svg width="60" height="61" viewBox="0 0 60 61" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_381_70954)">
                                                    <path
                                                        d="M49.0207 7.47196C45.8638 4.84488 42.1969 2.90015 38.2512 1.76031C34.3055 0.620464 30.1664 0.310214 26.0949 0.849108C18.5627 1.82763 11.6853 5.63603 6.85904 11.501C2.03277 17.366 -0.380546 24.8479 0.109118 32.4275C0.598783 40.0072 3.95472 47.1164 9.49551 52.3116C15.0363 57.5069 22.3466 60.3987 29.942 60.3999H47.3389C50.6418 60.396 53.8083 59.0821 56.1439 56.7466C58.4794 54.4111 59.7932 51.2445 59.7972 47.9416V28.7782V28.6212C59.5335 24.5485 58.4418 20.5723 56.5889 16.9358C54.7359 13.2994 52.1607 10.0791 49.0207 7.47196ZM19.9305 18.0416H29.8972C30.558 18.0416 31.1918 18.3041 31.6591 18.7714C32.1263 19.2387 32.3889 19.8724 32.3889 20.5333C32.3889 21.1941 32.1263 21.8279 31.6591 22.2951C31.1918 22.7624 30.558 23.0249 29.8972 23.0249H19.9305C19.2697 23.0249 18.6359 22.7624 18.1686 22.2951C17.7014 21.8279 17.4389 21.1941 17.4389 20.5333C17.4389 19.8724 17.7014 19.2387 18.1686 18.7714C18.6359 18.3041 19.2697 18.0416 19.9305 18.0416ZM39.8639 42.9583H19.9305C19.2697 42.9583 18.6359 42.6958 18.1686 42.2285C17.7014 41.7612 17.4389 41.1274 17.4389 40.4666C17.4389 39.8058 17.7014 39.172 18.1686 38.7047C18.6359 38.2375 19.2697 37.9749 19.9305 37.9749H39.8639C40.5247 37.9749 41.1585 38.2375 41.6257 38.7047C42.093 39.172 42.3555 39.8058 42.3555 40.4666C42.3555 41.1274 42.093 41.7612 41.6257 42.2285C41.1585 42.6958 40.5247 42.9583 39.8639 42.9583ZM39.8639 32.9916H19.9305C19.2697 32.9916 18.6359 32.7291 18.1686 32.2618C17.7014 31.7945 17.4389 31.1608 17.4389 30.4999C17.4389 29.8391 17.7014 29.2053 18.1686 28.7381C18.6359 28.2708 19.2697 28.0083 19.9305 28.0083H39.8639C40.5247 28.0083 41.1585 28.2708 41.6257 28.7381C42.093 29.2053 42.3555 29.8391 42.3555 30.4999C42.3555 31.1608 42.093 31.7945 41.6257 32.2618C41.1585 32.7291 40.5247 32.9916 39.8639 32.9916Z"
                                                        fill="url(#paint0_linear_381_70954)"/>
                                                </g>
                                                <circle cx="13.8" cy="14.4" r="13.8" fill="#F9C200"/>
                                                <path d="M8.04688 15.1666L13.3517 18.9999L20.6969 9.79993" stroke="#EFF6FF"
                                                      stroke-width="2.3" stroke-linecap="round"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_381_70954" x1="59.7972" y1="0.591987"
                                                                    x2="2.59356" y2="62.7439"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#F9963B"/>
                                                        <stop offset="0.0001" stop-color="#F9963B"/>
                                                        <stop offset="1" stop-color="#F95D3B"/>
                                                    </linearGradient>
                                                    <clipPath id="clip0_381_70954">
                                                        <rect width="59.8" height="59.8" fill="white"
                                                              transform="translate(0 0.599976)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                        </span>
                                    </div>

                                    <div class="contuct_info_inner_txt">
                                        <h4>{{__('translate.Contact Info')}}</h4>
                                        <p>{{__('translate.Open a chat or give us call at')}}</p>

                                        <a href="tel:{{$contact_us?->phone}}">
                                            {{$contact_us?->phone}}
                                        </a>
                                    </div>
                                </div>
                                <div class="contuct_info_inner">
                                    <div class="contuct_info_inner_icon">
                                        <span>
                                            <svg width="65" height="66" viewBox="0 0 65 66" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M35.4683 6H29.565C14.8936 6 3 18.0137 3 32.8333V47.7407C3 54.3272 8.28602 59.6667 14.8067 59.6667H35.4683C50.1398 59.6667 62.0333 47.653 62.0333 32.8333C62.0333 18.0137 50.1398 6 35.4683 6Z"
                                                    fill="url(#paint0_linear_381_70963)"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M26.3307 26.9152V23C26.3307 21.8954 27.2262 21 28.3307 21H44.3307C45.4353 21 46.3307 21.8954 46.3307 23V36.3333C46.3307 37.4379 45.4353 38.3333 44.3307 38.3333H36.5716C35.9949 38.3333 35.4462 38.0844 35.0664 37.6503L26.8256 28.2322C26.5066 27.8676 26.3307 27.3996 26.3307 26.9152ZM31.6641 26.25C31.2498 26.25 30.9141 26.5858 30.9141 27C30.9141 27.4142 31.2498 27.75 31.6641 27.75H40.9974C41.4116 27.75 41.7474 27.4142 41.7474 27C41.7474 26.5858 41.4116 26.25 40.9974 26.25H31.6641ZM34.9141 32.3333C34.9141 31.9191 35.2498 31.5833 35.6641 31.5833H40.9974C41.4116 31.5833 41.7474 31.9191 41.7474 32.3333C41.7474 32.7475 41.4116 33.0833 40.9974 33.0833H35.6641C35.2498 33.0833 34.9141 32.7475 34.9141 32.3333ZM28.9974 34.3333C28.9974 35.8061 27.8035 37 26.3307 37C24.858 37 23.6641 35.8061 23.6641 34.3333C23.6641 32.8606 24.858 31.6667 26.3307 31.6667C27.8035 31.6667 28.9974 32.8606 28.9974 34.3333ZM19.6641 40.3333C19.6641 39.2288 20.5595 38.3333 21.6641 38.3333H22.8356C23.3661 38.3333 23.8748 38.544 24.2498 38.9191L24.9165 39.5858C25.6976 40.3668 26.9639 40.3668 27.7449 39.5858L28.4116 38.9191C28.7867 38.544 29.2954 38.3333 29.8258 38.3333H30.9974C32.102 38.3333 32.9974 39.2288 32.9974 40.3333V43C32.9974 44.1046 32.102 45 30.9974 45H21.6641C20.5595 45 19.6641 44.1046 19.6641 43V40.3333Z"
                                                      fill="white"/>
                                                <circle cx="13.8" cy="14.6" r="13.8" fill="#F9C200"/>
                                                <path d="M8.04688 15.3669L13.3517 19.2002L20.6969 10.0002" stroke="#EFF6FF"
                                                      stroke-width="2.3" stroke-linecap="round"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_381_70963" x1="62.0333" y1="6.00001"
                                                                    x2="11.3433" y2="66.6409"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#F9963B"/>
                                                        <stop offset="0.0001" stop-color="#F9963B"/>
                                                        <stop offset="1" stop-color="#F95D3B"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                        </span>
                                    </div>

                                    <div class="contuct_info_inner_txt">
                                        <h4>{{__('translate.Live Support')}}</h4>
                                        <p>{{__('translate.Live Chat Service')}}</p>

                                        <a href="mailto:{{$contact_us?->email}}">
                                            {{$contact_us?->email}}
                                        </a>
                                    </div>
                                </div>
                            </div>




                            @csrf
                            <div class="contact_us_form_item">
                                <div class="contact_us_form_inner">
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{__('translate.Your Full Name')}}</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput2"
                                           placeholder="{{__('translate.Your Full Name')}}" name="name">

                                    <span class="icon">
                                        <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.0039 10.9375C13.6055 10.9375 15.75 13.082 15.75 15.6836V16.5625C15.75 17.5117 14.9766 18.25 14.0625 18.25H1.6875C0.738281 18.25 0 17.5117 0 16.5625V15.6836C0 13.082 2.10938 10.9375 4.71094 10.9375C5.73047 10.9375 6.1875 11.5 7.875 11.5C9.52734 11.5 9.98438 10.9375 11.0039 10.9375ZM14.0625 16.5625V15.6836C14.0625 13.9961 12.6914 12.625 11.0039 12.625C10.4766 12.625 9.66797 13.1875 7.875 13.1875C6.04688 13.1875 5.23828 12.625 4.71094 12.625C3.02344 12.625 1.6875 13.9961 1.6875 15.6836V16.5625H14.0625ZM7.875 10.375C5.0625 10.375 2.8125 8.125 2.8125 5.3125C2.8125 2.53516 5.0625 0.25 7.875 0.25C10.6523 0.25 12.9375 2.53516 12.9375 5.3125C12.9375 8.125 10.6523 10.375 7.875 10.375ZM7.875 1.9375C6.01172 1.9375 4.5 3.48438 4.5 5.3125C4.5 7.17578 6.01172 8.6875 7.875 8.6875C9.70312 8.6875 11.25 7.17578 11.25 5.3125C11.25 3.48438 9.70312 1.9375 7.875 1.9375Z"/>
                                        </svg>

                                    </span>
                                </div>
                                <div class="contact_us_form_inner">
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{__('translate.Enter Email Address')}}</label>
                                    <input type="email" class="form-control" id="exampleFormControlInput3"
                                           placeholder="{{__('translate.Enter Email Address')}}" name="email">

                                    <span class="icon">
                                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.3125 0.5C17.2266 0.5 18 1.27344 18 2.1875V12.3125C18 13.2617 17.2266 14 16.3125 14H1.6875C0.738281 14 0 13.2617 0 12.3125V2.1875C0 1.27344 0.738281 0.5 1.6875 0.5H16.3125ZM16.3125 2.1875H1.6875V3.62891C2.46094 4.29688 3.72656 5.28125 6.39844 7.39062C6.99609 7.84766 8.15625 8.97266 9 8.9375C9.80859 8.97266 10.9688 7.84766 11.5664 7.39062C14.2383 5.28125 15.5039 4.29688 16.3125 3.62891V2.1875ZM1.6875 12.3125H16.3125V5.80859C15.5039 6.44141 14.3438 7.35547 12.6211 8.72656C11.8125 9.32422 10.4766 10.6602 9 10.625C7.48828 10.6602 6.11719 9.32422 5.34375 8.72656C3.62109 7.35547 2.46094 6.44141 1.6875 5.80859V12.3125Z"
                                                fill="#475569"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="contact_us_form_item">
                                <div class="contact_us_form_inner">
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{__('translate.Phone Number')}}</label>
                                    <input type="tel" class="form-control" id="exampleFormControlInput5"
                                           placeholder="{{__('translate.Phone Number')}}" name="phone">

                                    <span class="icon">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.7344 1.05859C18.4727 1.23438 19 1.90234 19 2.64062C19 11.2891 11.9688 18.25 3.35547 18.25C2.61719 18.25 1.94922 17.7578 1.77344 17.0195L1.03516 13.7148C0.859375 12.9414 1.24609 12.168 1.94922 11.8516L5.53516 10.3398C6.16797 10.0586 6.94141 10.2344 7.39844 10.7969L8.55859 12.2031C10.3867 11.1836 11.9336 9.67188 12.918 7.84375L11.5117 6.68359C10.9492 6.22656 10.7734 5.45312 11.0547 4.82031L12.6016 1.23438C12.8828 0.53125 13.6562 0.144531 14.4297 0.320312L17.7344 1.05859ZM3.42578 16.5625C11.0547 16.5273 17.2773 10.3398 17.3125 2.71094L14.1133 1.97266L12.6367 5.41797L15.0273 7.38672C13.375 10.8672 11.582 12.6602 8.10156 14.3125L6.13281 11.9219L2.6875 13.3984L3.42578 16.5625Z"
                                                fill="#475569"/>
                                        </svg>


                                    </span>
                                </div>
                                <div class="contact_us_form_inner">
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{__('translate.Your Subject')}}</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput5"
                                           placeholder="{{__('translate.Your Subject')}}" name="subject">
                                </div>
                            </div>

                            <div class="contact_us_form_item">
                                <div class="contact_us_form_inner">
                                    <label for="exampleFormControlTextarea1"
                                           class="form-label">{{__('translate.Write Message')}}</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                              placeholder="{{__('translate.Write Message')}}" name="message"></textarea>
                                </div>

                            </div>


                            <div class="contact_us_form_item_btn">
                                @if($general_setting->recaptcha_status==1)
                                <div class="contact_us_form_item">
                                    <div class="contact_us_form_inner">
                                        <div class="g-recaptcha" data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                                    </div>
                                </div>
                                @endif
                                <button type="submit" class="thm-btn">{{__('translate.Send Message')}}</button>


                            </div>




                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- contuct part end -->

        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->

    </main>
@endsection

@push('js_section')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endpush
