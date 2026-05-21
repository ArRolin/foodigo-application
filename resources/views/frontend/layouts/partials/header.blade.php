@php
    $carts = session()->get('cart', []);
    $totalPrice = 0;
    $user = Illuminate\Support\Facades\Auth::user();
@endphp

<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-4 col-lg-4">
                <!-- Button trigger modal -->
                @if (
                    !Route::is('view.checkout*') &&
                        !Route::is('user.address*') &&
                        !Route::is('apply-for-restaurant') &&
                        !Route::is('view.payment'))
                    <button type="button" class="header_location" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    @else
                        <button type="button" class="header_location goto_select_location">
                @endif

                <span>
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.5 9.07403C16.5 13.165 11.8125 18.3333 9 18.3333C6.1875 18.3333 1.5 13.165 1.5 9.07403C1.5 4.98304 4.85786 1.66663 9 1.66663C13.1421 1.66663 16.5 4.98304 16.5 9.07403Z"
                            stroke-width="1.5" />
                        <path
                            d="M11.5 9.16663C11.5 10.5473 10.3807 11.6666 9 11.6666C7.61929 11.6666 6.5 10.5473 6.5 9.16663C6.5 7.78591 7.61929 6.66663 9 6.66663C10.3807 6.66663 11.5 7.78591 11.5 9.16663Z"
                            stroke-width="1.5" />
                    </svg>

                </span>
                {{ session::get('address') ?? __('Select Location') }}

                <span class="arrow_icon">
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.345964 0.942963C0.561595 0.673424 0.954903 0.629723 1.22444 0.845354L5.00067 3.86634L8.77691 0.845354C9.04645 0.629723 9.43975 0.673424 9.65538 0.942963C9.87102 1.2125 9.82731 1.60581 9.55778 1.82144L5.39111 5.15477C5.16285 5.33738 4.8385 5.33738 4.61024 5.15477L0.443573 1.82144C0.174034 1.60581 0.130333 1.2125 0.345964 0.942963Z" />
                    </svg>


                </span>
                </button>


            </div>

            <div class="col-xxl-5 col-lg-5">
                <div class="top-header-middel">

                    @php

                        $offer_data = App\Models\Offer::first();
                        $now = new \DateTime();
                        $endTime = new \DateTime($offer_data->end_time);
                        $remainingTime = $endTime->getTimestamp() - $now->getTimestamp();

                        $days = $hours = $minutes = $seconds = 0;

                        if ($remainingTime > 0) {
                            $days = floor($remainingTime / 86400);
                            $remainingTime %= 86400;

                            $hours = floor($remainingTime / 3600);
                            $remainingTime %= 3600;

                            $minutes = floor($remainingTime / 60);
                            $seconds = $remainingTime % 60;
                        }

                        $days = max(0, $days);
                        $hours = max(0, $hours);
                        $minutes = max(0, $minutes);
                        $seconds = max(0, $seconds);

                        $offer_status = 0;

                        $today = date('Y-m-d H:i:s');

                        if ($offer_data && $offer_data->status == 1) {
                            if ($today <= $offer_data->end_time) {
                                $offer_status = 1;
                            }
                        }

                    @endphp


                    @if ($offer_status == 1)
                        <h6 class="header_h6"> {{ $offer_data->title }} —
                            <span>
                                <a href="{{ route('offer') }}">
                                    {{ __('translate.Now on Sale') }}
                                </a>
                            </span>
                        </h6>

                        <input type="hidden" id="topbar_offer_hidden_id"
                            value="{{ date('Y-m-d\TH:i:s', strtotime($offer_data->end_time)) }}">

                        <div class="header_time_item_main">
                            <div class="header_time_item">
                                <h6 id="day">{{ str_pad($days, 2, '0', STR_PAD_LEFT) }} <span>d</span></h6>
                            </div>
                            <div class="header_time_item">
                                <h6 id="hour">{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }} <span>h</span></h6>
                            </div>
                            <div class="header_time_item">
                                <h6 id="minute">{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }} <span>m</span></h6>
                            </div>
                            <div class="header_time_item">
                                <h6 id="second">{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }} <span>s</span></h6>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="col-xxl-3 col-lg-3">
                <div class="language_btn_main">
                    <div class="dropdown">
                        <button class="language_btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">


                            {{ Session::get('currency_icon') }}

                            {{ Session::get('currency_name') }}
                            <span>
                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.345964 0.942963C0.561595 0.673424 0.954903 0.629723 1.22444 0.845354L5.00067 3.86634L8.77691 0.845354C9.04645 0.629723 9.43975 0.673424 9.65538 0.942963C9.87102 1.2125 9.82731 1.60581 9.55778 1.82144L5.39111 5.15477C5.16285 5.33738 4.8385 5.33738 4.61024 5.15477L0.443573 1.82144C0.174034 1.60581 0.130333 1.2125 0.345964 0.942963Z" />
                                </svg>

                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @foreach ($currency_list as $currency)
                                <li><a class="dropdown-item"
                                        href="{{ route('currency-switcher', ['currency_code' => $currency->currency_code]) }}">
                                        {{ $currency->currency_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="language_btn" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                            aria-expanded="false">


                            <span class="lun_icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.3327 9.99996C18.3327 14.6023 14.6017 18.3333 9.99935 18.3333M18.3327 9.99996C18.3327 5.39759 14.6017 1.66663 9.99935 1.66663M18.3327 9.99996C18.3327 8.61925 14.6017 7.49996 9.99935 7.49996C5.39698 7.49996 1.66602 8.61925 1.66602 9.99996M18.3327 9.99996C18.3327 11.3807 14.6017 12.5 9.99935 12.5C5.39698 12.5 1.66602 11.3807 1.66602 9.99996M9.99935 18.3333C5.39698 18.3333 1.66602 14.6023 1.66602 9.99996M9.99935 18.3333C11.8403 18.3333 13.3327 14.6023 13.3327 9.99996C13.3327 5.39759 11.8403 1.66663 9.99935 1.66663M9.99935 18.3333C8.1584 18.3333 6.66602 14.6023 6.66602 9.99996C6.66602 5.39759 8.1584 1.66663 9.99935 1.66663M1.66602 9.99996C1.66602 5.39759 5.39698 1.66663 9.99935 1.66663"
                                        stroke-width="1.2" />
                                </svg>


                            </span>


                            {{ strtoupper(session::get('front_lang')) }}
                            <span>
                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.345964 0.942963C0.561595 0.673424 0.954903 0.629723 1.22444 0.845354L5.00067 3.86634L8.77691 0.845354C9.04645 0.629723 9.43975 0.673424 9.65538 0.942963C9.87102 1.2125 9.82731 1.60581 9.55778 1.82144L5.39111 5.15477C5.16285 5.33738 4.8385 5.33738 4.61024 5.15477L0.443573 1.82144C0.174034 1.60581 0.130333 1.2125 0.345964 0.942963Z" />
                                </svg>

                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @foreach ($language_list as $language)
                                <li><a class="dropdown-item"
                                        href="{{ route('set.language', $language->lang_code) }}">{{ $language->lang_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="menu_bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-lg-8">
                    <div class="memu_bg_left">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset($general_setting->logo) }}" alt="logo">
                        </a>

                        @include('menu::components.dynamic-menu', ['location' => 'header'])
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-4">
                    <div class="menu_bg_right_main">
                        <div class="menu_bg_right">
                            <div class="menu_bg_right_icon">
                                <div class="menu_bg_right_icon_main">
                                    <a href="{{ route('user.wishlist') }}">
                                        <span class="icon">
                                            <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16 4.50005C17.1045 4.50005 18 5.39548 18 6.50005M11 3.70259L11.6851 3.00005C13.816 0.814763 17.2709 0.814761 19.4018 3.00005C21.4755 5.12665 21.5392 8.55385 19.5461 10.76L13.8197 17.0982C12.2984 18.782 9.70154 18.782 8.18026 17.0982L2.45393 10.76C0.460783 8.55388 0.5245 5.12667 2.5982 3.00007C4.72912 0.814774 8.18404 0.814776 10.315 3.00007L11 3.70259Z"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="list-count">
                                                {{ Auth::user() ? $wishlist->count() : 0 }}
                                            </span>
                                        </span>
                                    </a>
                                </div>


                                <div class="menu_bg_right_icon_main">
                                    <div class="d-block">
                                        <a href="{{ route('view.all.carts') }}" class="icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 4H18C20.2091 4 22 5.79086 22 8V13C22 15.2091 20.2091 17 18 17H10C7.79086 17 6 15.2091 6 13V4ZM6 4C6 2.89543 5.10457 2 4 2H2"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M11 20.5C11 21.3284 10.3284 22 9.5 22C8.67157 22 8 21.3284 8 20.5C8 19.6716 8.67157 19 9.5 19C10.3284 19 11 19.6716 11 20.5Z"
                                                    stroke-width="1.5" />
                                                <path
                                                    d="M20 20.5C20 21.3284 19.3284 22 18.5 22C17.6716 22 17 21.3284 17 20.5C17 19.6716 17.6716 19 18.5 19C19.3284 19 20 19.6716 20 20.5Z"
                                                    stroke-width="1.5" />
                                                <path d="M11 8.5H17" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M11 12.5H17" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="list-count"
                                                id="cart_header_qty">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                                        </a>

                                        <div
                                            class="menu_bg_right_icon_cart {{ Route::is('view.payment') ? 'd-none' : '' }}">
                                            <div class="menu_bg_right_icon_cart_header">
                                                <h5>{{ __('translate.My Cart') }}</h5>

                                            </div>

                                            <div id="sidebar_mini_cart_body">
                                                <div class="menu_bg_right_icon_cart_box">
                                                    @foreach ($carts as $item)
                                                        @php
                                                            $product = Modules\Product\App\Models\Product::where(
                                                                'status',
                                                                'enable',
                                                            )
                                                                ->whereIn('id', [$item['product_id']])
                                                                ->first();
                                                            $total = 0;
                                                            $calculate = 0;
                                                        @endphp
                                                        <div class="menu_bg_right_icon_cart_item">
                                                            <div class="menu_bg_right_icon_cart_item_thumb">
                                                                <img src="{{ asset($product?->image) }}"
                                                                    alt="thumb">
                                                            </div>

                                                            <div class="menu_bg_right_icon_cart_item_txt">
                                                                <a href="javascript:;">
                                                                    {{ $product?->name }}
                                                                </a>
                                                                <span>{{ currency($item['total']) }}</span>
                                                            </div>

                                                            @if (isset($product['id']))
                                                                @if (
                                                                    !Route::is('view.checkout*') &&
                                                                        !Route::is('user.address*') &&
                                                                        !Route::is('apply-for-restaurant') &&
                                                                        !Route::is('view.payment'))
                                                                    <a href="javascript:;"
                                                                        onClick="cartRemove('{{ $product['id'] }}')"
                                                                        class="menu_bg_right_icon_cart_item_btn">
                                                                        <span>
                                                                            <svg width="20" height="22"
                                                                                viewBox="0 0 20 22" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M3 7V17C3 19.2091 4.79086 21 7 21H13C15.2091 21 17 19.2091 17 17V7M12 10V16M8 10L8 16M14 4L12.5937 1.8906C12.2228 1.3342 11.5983 1 10.9296 1H9.07037C8.40166 1 7.7772 1.3342 7.40627 1.8906L6 4M14 4H6M14 4H19M6 4H1"
                                                                                    stroke-width="1.5"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('cart.manual.remove', $product['id']) }}"
                                                                        class="menu_bg_right_icon_cart_item_btn">
                                                                        <span>
                                                                            <svg width="20" height="22"
                                                                                viewBox="0 0 20 22" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M3 7V17C3 19.2091 4.79086 21 7 21H13C15.2091 21 17 19.2091 17 17V7M12 10V16M8 10L8 16M14 4L12.5937 1.8906C12.2228 1.3342 11.5983 1 10.9296 1H9.07037C8.40166 1 7.7772 1.3342 7.40627 1.8906L6 4M14 4H6M14 4H19M6 4H1"
                                                                                    stroke-width="1.5"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>

                                                        @php
                                                            $totalPrice += $item['total'];
                                                        @endphp
                                                    @endforeach
                                                </div>
                                                @if (session('cart') && count(session('cart')) > 0)
                                                    <div class="menu_bg_right_icon_subtotal">
                                                        <h5>{{ __('translate.Subtotal') }}
                                                            <span>{{ currency($totalPrice) }}</span>
                                                        </h5>
                                                    </div>


                                                    <div class="menu_bg_right_icon_btn_main">
                                                        <a href="{{ route('view.checkout', ['type' => 'delivery']) }}"
                                                            class="thm-btn">{{ __('translate.Checkout') }}</a>
                                                    </div>
                                                @else
                                                    <p class="text-center text-decoration-underline text-fo-black ">
                                                        {{ __('translate.Empty Cart') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="thm-btn-main">

                                    @if (Auth::user())
                                        <a href="javascript:;" class="thm-btn">
                                            <span>
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <ellipse cx="12" cy="17.5" rx="7"
                                                        ry="3.5" stroke-width="1.5" stroke-linejoin="round" />
                                                    <circle cx="12" cy="7" r="4" stroke-width="1.5"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            {{ __('translate.My Profile') }}

                                        </a>
                                        <div class="login_profile_main">
                                            <div class="login_profile">
                                                <div class="login_profile_thumb">
                                                    <img src="{{ asset($user->image) }}" alt="thumb">
                                                </div>
                                                <div class="login_profile_txt">
                                                    <a href="{{ route('user.dashboard') }}">
                                                        {{ html_decode($user->name) }}
                                                    </a>
                                                    <p>{{ __('translate.User ID') }}: #{{ $user->readable_id }}</p>
                                                </div>
                                            </div>
                                            <ul class="login_profile_link_item">
                                                <li>
                                                    <a href="{{ route('user.edit-profile') }}">
                                                        <span>
                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_564_17509)">
                                                                    <path
                                                                        d="M10.9002 15.7423L10.8745 15.7357C10.2653 15.5792 9.63448 15.5 9 15.5C4.86386 15.5 1.5 18.8639 1.5 23C1.5 23.2759 1.27586 23.5 1 23.5C0.724144 23.5 0.5 23.2759 0.5 23C0.5 18.3141 4.31414 14.5 9 14.5C9.72054 14.5 10.4355 14.5898 11.1248 14.7681L11.1251 14.7682C11.3923 14.8371 11.5534 15.1094 11.4846 15.378C11.4187 15.6356 11.1636 15.7955 10.9002 15.7423ZM19.2316 12.2326L19.2317 12.2324C20.1693 11.294 21.8286 11.2937 22.7674 12.2326C23.2396 12.7047 23.499 13.3305 23.499 14C23.499 14.6694 23.2397 15.2952 22.7664 15.7684L16.0594 22.4754C15.398 23.1369 14.5211 23.501 13.585 23.501H11.999C11.7231 23.501 11.499 23.2769 11.499 23.001V21.415C11.499 20.4788 11.8632 19.6009 12.5246 18.9396L19.2316 12.2326ZM22.0595 15.0606L22.0596 15.0606C22.342 14.7781 22.499 14.401 22.499 14C22.499 13.6 22.3428 13.2215 22.0592 12.9391C21.4861 12.3664 20.5105 12.3659 19.938 12.9399L13.2305 19.6464L13.2304 19.6464C12.7588 20.1181 12.498 20.7473 12.498 21.414V22V22.5H12.998H13.584C14.2513 22.5 14.8806 22.2395 15.3516 21.7675C15.3518 21.7674 15.3519 21.7672 15.352 21.7671L22.0595 15.0606ZM14.5 6C14.5 9.03286 12.0329 11.5 9 11.5C5.96714 11.5 3.5 9.03286 3.5 6C3.5 2.96714 5.96714 0.5 9 0.5C12.0329 0.5 14.5 2.96714 14.5 6ZM13.5 6C13.5 3.51786 11.4821 1.5 9 1.5C6.51786 1.5 4.5 3.51786 4.5 6C4.5 8.48214 6.51786 10.5 9 10.5C11.4821 10.5 13.5 8.48214 13.5 6Z" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        {{ __('translate.Edit Profile') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('user.order') }}">
                                                        <span>
                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9 6L9 7C9 8.65685 10.3431 10 12 10C13.6569 10 15 8.65685 15 7V6"
                                                                    stroke-width="1.8" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path
                                                                    d="M15.6113 3H8.38836C6.433 3 4.76424 4.41365 4.44278 6.3424L2.77612 16.3424C2.36976 18.7805 4.24994 21 6.72169 21H17.278C19.7498 21 21.6299 18.7805 21.2236 16.3424L19.5569 6.3424C19.2355 4.41365 17.5667 3 15.6113 3Z"
                                                                    stroke-width="1.8" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        {{ __('translate.My Orders') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('user.review') }}">
                                                        <span>
                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M10.0328 3.27141C10.8375 1.5762 13.1625 1.57619 13.9672 3.27141L15.3579 6.20118C15.6774 6.87435 16.2951 7.34094 17.0096 7.44888L20.1193 7.91869C21.9187 8.19053 22.6371 10.4895 21.3351 11.8091L19.0849 14.0896C18.5679 14.6136 18.332 15.3685 18.454 16.1084L18.9852 19.3285C19.2926 21.1918 17.4116 22.6126 15.8022 21.7329L13.0208 20.2126C12.3817 19.8633 11.6183 19.8633 10.9792 20.2126L8.19776 21.7329C6.58839 22.6126 4.70742 21.1918 5.01479 19.3286L5.54599 16.1084C5.66804 15.3685 5.43211 14.6136 4.91508 14.0896L2.66488 11.8091C1.36287 10.4895 2.08133 8.19053 3.88066 7.91869L6.99037 7.44888C7.70489 7.34094 8.32257 6.87435 8.64211 6.20118L10.0328 3.27141Z"
                                                                    stroke-width="1.8" stroke-linejoin="round" />
                                                            </svg>

                                                        </span>
                                                        {{ __('translate.My Review') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:;" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal6" class="thm-btn">
                                                        <span>
                                                            <svg width="19" height="16" viewBox="0 0 19 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.4993 8.00004H10.8327M4.99935 14.6667C3.1584 14.6667 1.66602 13.1743 1.66602 11.3334V4.66671C1.66602 2.82576 3.1584 1.33337 4.99935 1.33337M4.99935 14.6667C6.8403 14.6667 8.33268 13.1743 8.33268 11.3334V4.66671C8.33268 2.82576 6.8403 1.33337 4.99935 1.33337M4.99935 14.6667H11.666C13.507 14.6667 14.9993 13.1743 14.9993 11.3334M4.99935 1.33337H11.666C13.507 1.33337 14.9993 2.82576 14.9993 4.66671"
                                                                    stroke-width="1.5" stroke-linecap="round" />
                                                            </svg>

                                                        </span>
                                                        {{ __('translate.Logout') }}
                                                    </a>
                                                    <form id="user-logout-form" action="{{ route('user.logout') }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}" class="thm-btn">
                                            <span>
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <ellipse cx="12" cy="17.5" rx="7"
                                                        ry="3.5" stroke-width="1.5" stroke-linejoin="round" />
                                                    <circle cx="12" cy="7" r="4" stroke-width="1.5"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            {{ __('translate.Sign In') }}
                                        </a>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>
<!-- header part end  -->

<!-- mobile navigation start -->
<header class="mobile-header">
    <div class="container-full">
        <div class="mobile-header__container">
            <div class="p-left">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset($general_setting->logo) }}" alt="logo">
                    </a>
                </div>
            </div>
            <div class="p-right">


                <ul>
                    <li>
                        <a href="{{ route('user.wishlist') }}" class="icon">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">

                                    <path
                                        d="M17 6.50005C18.1045 6.50005 19 7.39548 19 8.50005M12 5.70259L12.6851 5.00005C14.816 2.81476 18.2709 2.81476 20.4018 5.00005C22.4755 7.12665 22.5392 10.5538 20.5461 12.76L14.8197 19.0982C13.2984 20.782 10.7015 20.782 9.18026 19.0982L3.45393 12.76C1.46078 10.5539 1.5245 7.12667 3.5982 5.00007C5.72912 2.81477 9.18404 2.81478 11.315 5.00007L12 5.70259Z"
                                        stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </span>

                            <span class="number"> {{ Auth::user() ? $wishlist->count() : 0 }} </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('view.all.carts') }}" class="icon">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 4H18C20.2091 4 22 5.79086 22 8V13C22 15.2091 20.2091 17 18 17H10C7.79086 17 6 15.2091 6 13V4ZM6 4C6 2.89543 5.10457 2 4 2H2"
                                        stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M11 20.5C11 21.3284 10.3284 22 9.5 22C8.67157 22 8 21.3284 8 20.5C8 19.6716 8.67157 19 9.5 19C10.3284 19 11 19.6716 11 20.5Z"
                                        stroke="#0C1321" stroke-width="1.5" />
                                    <path
                                        d="M20 20.5C20 21.3284 19.3284 22 18.5 22C17.6716 22 17 21.3284 17 20.5C17 19.6716 17.6716 19 18.5 19C19.3284 19 20 19.6716 20 20.5Z"
                                        stroke="#0C1321" stroke-width="1.5" />
                                    <path d="M11 8.5H17" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M11 12.5H17" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>


                            </span>



                            <span class="number" id="cart_qty_mobile_menu">
                                {{ session('cart') ? count(session('cart')) : 0 }} </span>
                        </a>
                    </li>
                </ul>




                <button id="nav-opn-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<!-- offcanvas -->
<aside id="offcanvas-nav">
    <nav class="m-nav">
        <button id="nav-cls-btn"><i class="fa-solid fa-xmark"></i></button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset($general_setting->logo) }}" class="w-100" alt="logo">
            </a>
        </div>

        <ul class="nav-links">
            @include('menu::components.mobile-menu', ['location' => 'header'])
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

                    @foreach ($currency_list as $currency)
                        <li><a class="dropdown-item"
                                href="{{ route('currency-switcher', ['currency_code' => $currency->currency_code]) }}">
                                {{ $currency->currency_name }}</a></li>
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
                                href="{{ route('set.language', $language->lang_code) }}">{{ $language->lang_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


    </nav>
</aside>
