@extends('frontend.layouts.master')

@section('title')
    <title>{{html_decode($restaurant->restaurant_name)}}</title>
@endsection

@section('content')
    <main class="search_V1_bg" >
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="{{ route('all.restaurant') }}" >{{__('translate.Restaurant')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{html_decode($restaurant->restaurant_name)}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- profile Information part start -->

        <section class="profile_informetion">
            <div class="container paddiing_0 ">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="profile_informetion_bg_main">
                            <div class="profile_informetion_bg">
                                <img src="{{asset($restaurant->cover_image)}}" alt="thumb">
                            </div>
                            <div class="profile_informetion_main">
                                <div class="company_logo">
                                    <img src="{{asset($restaurant->logo)}}" alt="logo">
                                </div>

                                <div class="company_name">
                                    <h6>{{html_decode($restaurant->restaurant_name)}}</h6>
                                    @if($restaurant->is_trusted == 1)
                                        <span>
                                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M23.7184 10.6749C23.3395 10.4546 22.9991 10.174 22.7104 9.84419C22.7396 9.385 22.849 8.93447 23.0336 8.51302C23.3731 7.55519 23.7569 6.47019 23.1409 5.62669C22.5249 4.78319 21.3617 4.81002 20.3409 4.83335C19.8898 4.87977 19.4342 4.84899 18.9934 4.74235C18.7586 4.36028 18.5909 3.94083 18.4976 3.50219C18.2082 2.51635 17.8781 1.40219 16.8642 1.06852C15.8866 0.753519 14.9812 1.44652 14.1809 2.05552C13.8356 2.37089 13.4354 2.62039 13.0002 2.79169C12.5605 2.62179 12.1559 2.37222 11.8067 2.05552C11.0087 1.45002 10.1069 0.750019 9.12458 1.06969C8.11308 1.39869 7.78291 2.51635 7.49125 3.50219C7.39807 3.93941 7.23203 4.35786 7.00008 4.74002C6.55852 4.84637 6.10224 4.87792 5.65025 4.83335C4.62591 4.80535 3.47208 4.77502 2.85025 5.62669C2.22841 6.47835 2.61691 7.55519 2.95758 8.51185C3.14476 8.93268 3.25576 9.38339 3.28541 9.84302C2.99734 10.1733 2.65725 10.4543 2.27858 10.6749C1.42458 11.2582 0.455078 11.922 0.455078 13C0.455078 14.078 1.42458 14.7395 2.27858 15.3252C2.65716 15.5454 2.99725 15.826 3.28541 16.1559C3.25888 16.6153 3.15104 17.0664 2.96691 17.4882C2.62858 18.4449 2.24591 19.5299 2.86075 20.3734C3.47558 21.2169 4.63525 21.19 5.66075 21.1667C6.11221 21.1202 6.56828 21.151 7.00941 21.2577C7.24319 21.6402 7.41045 22.0595 7.50408 22.4979C7.79341 23.4837 8.12358 24.5979 9.13741 24.9315C9.29995 24.9836 9.46955 25.0104 9.64025 25.0109C10.4607 24.8931 11.2232 24.52 11.8196 23.9445C12.1649 23.6291 12.5651 23.3796 13.0002 23.2084C13.44 23.3783 13.8446 23.6278 14.1937 23.9445C14.9929 24.5547 15.8982 25.2512 16.8771 24.9304C17.8886 24.6014 18.2187 23.4837 18.5104 22.499C18.6039 22.061 18.7712 21.642 19.0051 21.26C19.4449 21.1529 19.8998 21.1214 20.3502 21.1667C21.3746 21.1912 22.5284 21.225 23.1502 20.3734C23.7721 19.5217 23.3836 18.4449 23.0429 17.487C22.857 17.0666 22.7461 16.6169 22.7151 16.1582C23.0033 15.8276 23.3438 15.5466 23.7231 15.3264C24.5771 14.743 25.5466 14.078 25.5466 13C25.5466 11.922 24.5736 11.2594 23.7184 10.6749Z"
                                                    fill="#49ADF4"/>
                                                <path
                                                    d="M11.833 16.2084C11.7181 16.2086 11.6043 16.186 11.4981 16.142C11.392 16.0979 11.2956 16.0332 11.2147 15.9517L8.88133 13.6184C8.72677 13.4525 8.64262 13.2331 8.64662 13.0064C8.65062 12.7798 8.74245 12.5635 8.90277 12.4032C9.06308 12.2428 9.27936 12.151 9.50605 12.147C9.73273 12.143 9.95212 12.2272 10.118 12.3817L11.9147 14.1784L15.9747 11.1334C16.1603 10.9941 16.3937 10.9344 16.6234 10.9672C16.8531 11 17.0604 11.1227 17.1997 11.3084C17.3389 11.494 17.3987 11.7274 17.3659 11.9571C17.333 12.1869 17.2103 12.3941 17.0247 12.5334L12.358 16.0334C12.2065 16.1469 12.0223 16.2083 11.833 16.2084Z"
                                                    fill="white"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>


                                <div class="profile_other_informetion">

                                    <div class="profile_other_informetion_item">
                                        <a target="_blank" href="https://maps.google.com/?q={{ html_decode($restaurant?->address)}}" class="profile_location">
                                            <span>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <ellipse cx="10" cy="9.16669" rx="2.5" ry="2.5" stroke="#475569"
                                                             stroke-width="1.5"/>
                                                    <path
                                                        d="M17.5 9.07409C17.5 13.1651 12.8125 18.3334 10 18.3334C7.1875 18.3334 2.5 13.1651 2.5 9.07409C2.5 4.9831 5.85786 1.66669 10 1.66669C14.1421 1.66669 17.5 4.9831 17.5 9.07409Z"
                                                        stroke="#475569" stroke-width="1.5"/>
                                                </svg>

                                            </span>
                                            {{ html_decode($restaurant?->address)}}
                                        </a>
                                        <span class="dot"></span>


                                        <!-- Button trigger modal -->
                                        <button type="button" class="profile_riview" >
                                                {{ round($restaurant->reviews_avg_rating ?? 0) }}
                                            <span>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                    </svg>

                                            </span>
                                            <span>
                                                ({{ $restaurant->reviews_count }}+)
                                            </span>
                                        </button>
                                        <span class="dot"></span>
                                        <div class="profile_informetion_date">
                                            <p>
                                                <span>
                                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M1.75 11C1.75 5.89137 5.89137 1.75 11 1.75C16.1086 1.75 20.25 5.89137 20.25 11C20.25 16.1086 16.1086 20.25 11 20.25C5.89137 20.25 1.75 16.1086 1.75 11ZM11 0.25C5.06294 0.25 0.25 5.06294 0.25 11C0.25 16.9371 5.06294 21.75 11 21.75C16.9371 21.75 21.75 16.9371 21.75 11C21.75 5.06294 16.9371 0.25 11 0.25ZM11 4.25C10.5858 4.25 10.25 4.58579 10.25 5V9.14538C9.51704 9.44207 9 10.1607 9 11C9 12.1046 9.89543 13 11 13C12.1046 13 13 12.1046 13 11C13 10.1607 12.483 9.44207 11.75 9.14538V5C11.75 4.58579 11.4142 4.25 11 4.25Z"/>
                                                    </svg>
                                                </span>
                                                {{$restaurant->opening_hour }} - {{$restaurant->closing_hour}}
                                            </p>
                                        </div>

                                    </div>


                                    <div class="profile_other_informetion_link">


                                        <a href="tel:{{$restaurant->owner_phone}}" class="icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M22.3139 10.4636C22.222 7.84575 21.1619 5.39775 19.3004 3.53625C17.3492 1.58475 14.7561 0.510376 11.9991 0.510376C6.43074 0.510376 1.88086 4.9425 1.68473 10.4636C0.834984 10.8413 0.240234 11.6917 0.240234 12.6802V15.4035C0.240234 16.7407 1.32811 17.829 2.66573 17.829C3.53123 17.829 4.23511 17.1251 4.23511 16.2596V11.8238C4.23511 11.0111 3.61186 10.3485 2.81948 10.2697C3.11198 5.45963 7.11624 1.63538 11.9991 1.63538C14.4561 1.63538 16.7665 2.59313 18.5054 4.332C20.1021 5.92875 21.0366 8.01 21.1772 10.2701C20.3856 10.3496 19.7635 11.0119 19.7635 11.8238V16.2593C19.7635 17.0786 20.3965 17.7454 21.1982 17.8148V18.9356C21.1982 20.1979 20.1711 21.2246 18.9089 21.2246H17.2135C17.1302 20.9869 16.9997 20.7671 16.8167 20.5849C16.4961 20.2628 16.0686 20.0854 15.6134 20.0854H13.8659C13.615 20.0854 13.3742 20.1386 13.1537 20.2414C12.5522 20.5177 12.1637 21.1245 12.1637 21.7871C12.1637 22.2424 12.3411 22.6699 12.6625 22.9897C12.9839 23.3119 13.4114 23.4893 13.8659 23.4893H15.6134C16.3379 23.4893 16.9765 23.0209 17.2146 22.3496H18.9089C20.7917 22.3496 22.3232 20.8181 22.3232 18.9356V17.6145C23.1677 17.2346 23.758 16.3871 23.758 15.4028V12.6795C23.758 11.6918 23.1632 10.8413 22.3139 10.4636ZM3.10973 11.8238V16.2593C3.10973 16.5041 2.91061 16.7036 2.66536 16.7036C1.94836 16.7036 1.36486 16.1201 1.36486 15.4031V12.6799C1.36486 11.9625 1.94836 11.3794 2.66536 11.3794C2.91061 11.3794 3.10973 11.5789 3.10973 11.8238ZM16.1777 21.9079C16.1219 22.1726 15.8841 22.365 15.613 22.365H13.8655C13.7117 22.365 13.5674 22.305 13.4571 22.1947C13.3484 22.0864 13.2884 21.9416 13.2884 21.7879C13.2884 21.5632 13.42 21.3581 13.6262 21.2632C13.6997 21.2287 13.7804 21.2111 13.8655 21.2111H15.613C15.7667 21.2111 15.9111 21.2707 16.021 21.381C16.1297 21.4894 16.1897 21.6341 16.1897 21.7879C16.1901 21.8291 16.1856 21.8704 16.1777 21.9079ZM22.633 15.4031C22.633 16.1201 22.0495 16.7036 21.3325 16.7036C21.0876 16.7036 20.8881 16.5045 20.8881 16.2593V11.8238C20.8881 11.5789 21.0872 11.3794 21.3325 11.3794C22.0495 11.3794 22.633 11.9629 22.633 12.6799V15.4031Z"
                                                    fill="black"/>
                                                <path
                                                    d="M15.6409 15.597C16.9553 15.597 18.0244 14.5275 18.0244 13.2135V8.35689C18.0244 7.72164 17.7762 7.12314 17.3254 6.67239C16.8747 6.22164 16.2765 5.97339 15.6409 5.97339H8.35616C7.04178 5.97339 5.97266 7.04251 5.97266 8.35689V13.2135C5.97266 14.5279 7.04178 15.597 8.35616 15.597H8.40078V16.8555C8.40078 17.3355 8.68691 17.7615 9.12941 17.9411C9.27228 17.9985 9.42078 18.027 9.56778 18.027C9.87416 18.027 10.1727 17.9055 10.3913 17.6794L12.4849 15.597H15.6409ZM11.8568 14.6355L9.59103 16.8889C9.58091 16.8994 9.57341 16.9073 9.55203 16.8979C9.52616 16.8874 9.52616 16.8705 9.52616 16.8555V15.0345C9.52616 14.724 9.27453 14.472 8.96366 14.472H8.35653C7.66241 14.472 7.09803 13.9073 7.09803 13.2135V8.35689C7.09803 7.66276 7.66241 7.09839 8.35653 7.09839H15.6413C15.9765 7.09839 16.2919 7.22964 16.5304 7.46776C16.7689 7.70626 16.8998 8.02201 16.8998 8.35689V13.2135C16.8998 13.9076 16.335 14.472 15.6413 14.472H12.2535C12.1047 14.472 11.9622 14.5309 11.8568 14.6355Z"
                                                    fill="black"/>
                                                <path
                                                    d="M9.26737 10.0451C8.80987 10.0451 8.4375 10.4179 8.4375 10.875C8.4375 11.3321 8.81025 11.7049 9.26737 11.7049C9.72525 11.7049 10.098 11.3321 10.098 10.875C10.098 10.4179 9.72562 10.0451 9.26737 10.0451Z"
                                                    fill="black"/>
                                                <path
                                                    d="M11.9978 10.0451C11.5403 10.0451 11.168 10.4179 11.168 10.875C11.168 11.3321 11.5407 11.7049 11.9978 11.7049C12.4561 11.7049 12.8285 11.3321 12.8285 10.875C12.8285 10.4179 12.4561 10.0451 11.9978 10.0451Z"
                                                    fill="black"/>
                                                <path
                                                    d="M14.7303 10.0451C14.2728 10.0451 13.9004 10.4179 13.9004 10.875C13.9004 11.3321 14.2731 11.7049 14.7303 11.7049C15.1881 11.7049 15.5609 11.3321 15.5609 10.875C15.5609 10.4179 15.1881 10.0451 14.7303 10.0451Z"
                                                    fill="black"/>
                                            </svg>

                                        </a>
                                        <a href="javascript:;" class="icon" id="share_btn">
                                      <span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 13.229C10.1416 13.4609 10.3097 13.6804 10.5042 13.8828C11.7117 15.1395 13.5522 15.336 14.9576 14.4722C15.218 14.3121 15.4634 14.1157 15.6872 13.8828L18.9266 10.5114C20.3578 9.02184 20.3578 6.60676 18.9266 5.11718C17.4953 3.6276 15.1748 3.62761 13.7435 5.11718L13.03 5.85978" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M10.9703 18.14L10.2565 18.8828C8.82526 20.3724 6.50471 20.3724 5.07345 18.8828C3.64218 17.3932 3.64218 14.9782 5.07345 13.4886L8.31287 10.1172C9.74413 8.62761 12.0647 8.6276 13.4959 10.1172C13.6904 10.3195 13.8584 10.539 14 10.7708" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M21 16H18.9211M16 21V18.9211" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3 8H5.07889M8 3V5.07889" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                      </span>
                                        </a>
                                    </div>

                                </div>

                                <div class="profile_informetion_sarch_main">
                                    <ul class="informetion_sarch_link ">
                                        <li>
                                            <a href="#" class="active">{{ __('translate.All') }} <span>({{ $categories->sum('filtered_products_count') }})</span></a>
                                        </li>
                                        @foreach($categories as $category)
                                            @if ($category->filtered_products_count > 0)
                                            <li>
                                                <a href="#{{ e($category->name) }}">{{ $category->name }} <span>({{ $category->filtered_products_count }})</span></a>
                                            </li>
                                            @endif

                                        @endforeach
                                    </ul>
                                    <div class="profile_informetion_sarch_item">
                                        <form class="profile_informetion_sarch_box">

                                            <input name="search" type="text" class="form-control" id=""
                                                   placeholder="{{ __('translate.Search in menu') }}" value="{{ request()->get('search') }}" >
                                                   <button type="submit" class="sarch">
                                                    <span>
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.8743 8.58335C15.8743 12.6104 12.6098 15.875 8.58268 15.875C4.55561 15.875 1.29102 12.6104 1.29102 8.58335C1.29102 4.55628 4.55561 1.29169 8.58268 1.29169C12.6098 1.29169 15.8743 4.55628 15.8743 8.58335ZM8.58268 17.125C13.3001 17.125 17.1243 13.3008 17.1243 8.58335C17.1243 3.86592 13.3001 0.041687 8.58268 0.041687C3.86525 0.041687 0.0410156 3.86592 0.0410156 8.58335C0.0410156 13.3008 3.86525 17.125 8.58268 17.125ZM16.108 15.2247C15.8639 14.9807 15.4682 14.9807 15.2241 15.2247C14.98 15.4688 14.98 15.8646 15.2241 16.1086L16.8907 17.7753C17.1348 18.0194 17.5305 18.0194 17.7746 17.7753C18.0187 17.5312 18.0187 17.1355 17.7746 16.8914L16.108 15.2247Z" fill="#64748B"/>
                                                            </svg>

                                                    </span>
                                                </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- profile Information part  end -->

        <!-- Popular part start  -->

        <section class=" popular  popular_two">
            <div class="container">

                @if (request()->has('search'))

                    <h3 class="mb-4"> {{ __('translate.We found') }} {{ $search_foods->count() }} {{ __('translate.results for') }} "{{ request()->get('search') }}" </h3>

                    <div class="row g-4 mb-4">
                        @forelse($search_foods as $popular_key => $pro)
                            <div class="col-xxl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="food_card_item">
                                    <div class="food_card_item_thumb_main">
                                        <div class="food_card_item_thumb">
                                            <img src="{{asset($pro->image)}}" alt="thumb">

                                        </div>
                                        <div class="food_card_item_thumb_overlay">
                                            @if ($pro->created_at >= \Carbon\Carbon::now()->subWeek())
                                            <div class="badge">
                                                <h6>{{__('translate.NEW')}}</h6>
                                            </div>
                                            @endif
                                            <a href="{{route('user.add-to-wishlist', ['id' => $pro->id])}}"
                                               class="wishlist_icon {{ $wishlist->contains('item_id', $pro->id) ? 'wihslist_active' : '' }}">
                                                <span>
                                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.166 3.41668C15.0865 3.41668 15.8327 4.16287 15.8327 5.08334M9.99935 2.75212L10.5702 2.16668C12.346 0.345605 15.2251 0.345603 17.0009 2.16668C18.7289 3.93884 18.782 6.79484 17.1211 8.63328L12.3491 13.9151C11.0814 15.3183 8.9173 15.3183 7.64956 13.9151L2.87762 8.6333C1.21667 6.79487 1.26977 3.93886 2.99785 2.16669C4.77362 0.345615 7.65271 0.345617 9.42848 2.16669L9.99935 2.75212Z"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="food_card_item_inner">
                                        <div class="food_card_item_inner_top">
                                            <h5>{{currency(calculateFinalPrice($pro))}}</h5>
                                            <p>
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                        </svg>

                                                </span>
                                                {{ round($pro->reviews_avg_rating ?? 0) }}
                                                <span>({{ $pro->reviews_count }}+)</span>
                                            </p>
                                        </div>

                                        <a  class="food_card_modal_btn" onClick="loadProductModal({{ $pro->id }})" href="javascript:;" >
                                            <h5>{{$pro->name}}</h5>
                                        </a>


                                        <ul class="food_card_list">

                                            @php
                                                $specifications = [];
                                                if(!empty($pro->specification)) {
                                                    $specifications = array_slice(json_decode($pro->specification, true) ?? [], 0, 2); 
                                                }
                                            @endphp

                                            @forelse($specifications as $popular_name)
                                                <li>
                                                    {{$popular_name}}
                                                </li>
                                            @empty
                                            @endforelse
                                        </ul>


                                        <div class="food_card_btm_item">

                                            <div class="food_card_company">
                                                <div class="food_card_company_thumb">
                                                    <img src="{{asset($pro?->restaurant?->logo)}}"
                                                         alt="logo">
                                                </div>

                                                <a href="{{route('single.restaurant', $pro?->restaurant->slug)}}"
                                                   class="food_card_company_name">
                                                    {{$pro?->restaurant->restaurant_name}}
                                                </a>
                                            </div>

                                            <a onClick="loadProductModal({{ $pro->id }})" href="javascript:;"  class="thm-btn_three">
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_1610_24994)">
                                                        <path d="M5.33398 10.6667L11.1474 10.1822C12.9664 10.0307 13.3747 9.63333 13.5763 7.81927L14.0007 4" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M4 4H4.33333M14.6667 4H13" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M6.33398 4.00008H11.0007M8.66732 6.33341V1.66675" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M3.99935 14.6667C4.73573 14.6667 5.33268 14.0697 5.33268 13.3333C5.33268 12.597 4.73573 12 3.99935 12C3.26297 12 2.66602 12.597 2.66602 13.3333C2.66602 14.0697 3.26297 14.6667 3.99935 14.6667Z" stroke="#0C1321" stroke-width="1.5"/>
                                                        <path d="M11.3333 14.6667C12.0697 14.6667 12.6667 14.0697 12.6667 13.3333C12.6667 12.597 12.0697 12 11.3333 12C10.597 12 10 12.597 10 13.3333C10 14.0697 10.597 14.6667 11.3333 14.6667Z" stroke="#0C1321" stroke-width="1.5"/>
                                                        <path d="M5.33398 13.3333H10.0007" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M1.33398 1.33325H1.97798C2.60777 1.33325 3.15674 1.74965 3.30949 2.34321L5.293 10.0509C5.39323 10.4405 5.30745 10.8531 5.05948 11.1743L4.42207 11.9999" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                        </g>
                                                        </svg>

                                                </span>
                                                {{ __('translate.Add') }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        @empty
                        @endforelse
                    </div>

                @endif

                @forelse($categories as $cat)
                    @if ($cat->filtered_products_count > 0)
                        <h3 class="mb-4" id="{{$cat->name}}">{{$cat->name}}</h3>

                        <div class="row g-4 mb-4">
                            @forelse($cat->products as $popular_key => $pro)
                                <div class="col-xxl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">


                                    <div class="food_card_item">
                                        <div class="food_card_item_thumb_main">
                                            <div class="food_card_item_thumb">
                                                <img src="{{asset($pro->image)}}" alt="thumb">

                                            </div>
                                            <div class="food_card_item_thumb_overlay">
                                                @if ($pro->created_at >= \Carbon\Carbon::now()->subWeek())
                                                <div class="badge">
                                                    <h6>{{__('translate.NEW')}}</h6>
                                                </div>
                                                @endif
                                                <a href="{{route('user.add-to-wishlist', ['id' => $pro->id])}}"
                                                   class="wishlist_icon {{ $wishlist->contains('item_id', $pro->id) ? 'wihslist_active' : '' }}">
                                                    <span>
                                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M14.166 3.41668C15.0865 3.41668 15.8327 4.16287 15.8327 5.08334M9.99935 2.75212L10.5702 2.16668C12.346 0.345605 15.2251 0.345603 17.0009 2.16668C18.7289 3.93884 18.782 6.79484 17.1211 8.63328L12.3491 13.9151C11.0814 15.3183 8.9173 15.3183 7.64956 13.9151L2.87762 8.6333C1.21667 6.79487 1.26977 3.93886 2.99785 2.16669C4.77362 0.345615 7.65271 0.345617 9.42848 2.16669L9.99935 2.75212Z"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="food_card_item_inner">
                                            <div class="food_card_item_inner_top">
                                                <h5>{{currency(calculateFinalPrice($pro))}}</h5>
                                                <p>
                                                    <span>
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                            </svg>

                                                    </span>
                                                    {{ round($pro->reviews_avg_rating ?? 0) }}
                                                    <span>({{ $pro->reviews_count }}+)</span>
                                                </p>
                                            </div>

                                            <a  class="food_card_modal_btn" onClick="loadProductModal({{ $pro->id }})" href="javascript:;" >
                                                <h5>{{$pro->name}}</h5>
                                            </a>


                                            <ul class="food_card_list">

                                               @php
                                                $specifications = [];
                                                if(!empty($pro->specification)) {
                                                    $specifications = array_slice(json_decode($pro->specification, true) ?? [], 0, 2); 
                                                }
                                            @endphp

                                                @forelse($specifications as $popular_name)
                                                    <li>
                                                        {{$popular_name}}
                                                    </li>
                                                @empty
                                                @endforelse
                                            </ul>


                                            <div class="food_card_btm_item">

                                                <div class="food_card_company">
                                                    <div class="food_card_company_thumb">
                                                        <img src="{{asset($pro?->restaurant?->logo)}}"
                                                             alt="logo">
                                                    </div>

                                                    <a href="{{route('single.restaurant', $pro?->restaurant->slug)}}"
                                                       class="food_card_company_name">
                                                        {{$pro?->restaurant->restaurant_name}}
                                                    </a>
                                                </div>

                                                <a onClick="loadProductModal({{ $pro->id }})" href="javascript:;"  class="thm-btn_three">
                                                    <span>
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1610_24994)">
                                                            <path d="M5.33398 10.6667L11.1474 10.1822C12.9664 10.0307 13.3747 9.63333 13.5763 7.81927L14.0007 4" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M4 4H4.33333M14.6667 4H13" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M6.33398 4.00008H11.0007M8.66732 6.33341V1.66675" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M3.99935 14.6667C4.73573 14.6667 5.33268 14.0697 5.33268 13.3333C5.33268 12.597 4.73573 12 3.99935 12C3.26297 12 2.66602 12.597 2.66602 13.3333C2.66602 14.0697 3.26297 14.6667 3.99935 14.6667Z" stroke="#0C1321" stroke-width="1.5"/>
                                                            <path d="M11.3333 14.6667C12.0697 14.6667 12.6667 14.0697 12.6667 13.3333C12.6667 12.597 12.0697 12 11.3333 12C10.597 12 10 12.597 10 13.3333C10 14.0697 10.597 14.6667 11.3333 14.6667Z" stroke="#0C1321" stroke-width="1.5"/>
                                                            <path d="M5.33398 13.3333H10.0007" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M1.33398 1.33325H1.97798C2.60777 1.33325 3.15674 1.74965 3.30949 2.34321L5.293 10.0509C5.39323 10.4405 5.30745 10.8531 5.05948 11.1743L4.42207 11.9999" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            </g>
                                                            </svg>

                                                    </span>
                                                    {{ __('translate.Add') }}
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            @empty
                            @endforelse
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </section>


        <!-- Popular  part end  -->


        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->

    </main>
@endsection

@push('js_section')
    <script>
        "use strict"
        document.addEventListener('DOMContentLoaded', function () {
            // Listen for clicks on anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const headerHeight = document.querySelector('.menu_bg, .nav-bg').offsetHeight;

                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop - headerHeight;

                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#wishlist').on('click', function (e) {
                e.preventDefault();

                var restaurantId = $(this).data('restaurant-id');

                $.ajax({
                    url: "{{ route('user.restaurant.toggle-wishlist', ['id' => ':restaurantId']) }}".replace(':restaurantId', restaurantId),
                    type: 'GET',
                    success: function (response) {
                        if (response.success) {
                            if (response.action === 'added') {
                                toastr.success("{{ __('translate.Restaurant added to wishlist successfully!') }}");
                                setTimeout(function () {
                                    location.reload();
                                }, 1000); // 1 second delay
                            } else if (response.action === 'removed') {
                                toastr.success("{{ __('translate.Restaurant removed from wishlist successfully!!') }}");
                                setTimeout(function () {
                                    location.reload();
                                }, 1000); // 1 second delay
                            }
                        } else {
                            toastr.warning(response.message);
                        }
                    },

                    error: function (xhr) {
                        toastr.error("Something went wrong, please try again.");
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#share_btn').on('click', function (e) {
                e.preventDefault();
                const url = window.location.href;

                navigator.clipboard.writeText(url).then(function () {
                    toastr.success("{{ __('translate.Restaurant URL copied!') }}");
                }).catch(function (error) {
                    toastr.error("{{ __('translate.Failed to copy URL!') }}");
                });
            });
        });

    </script>
@endpush
