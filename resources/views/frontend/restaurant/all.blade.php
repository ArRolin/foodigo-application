@extends('frontend.layouts.master')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}" />
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}" />
@endsection

@section('content')

    <main class="search_V1_bg">
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.All Restaurants')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->

        <!--  Restaurant part start -->

        <section class="restaurant restaurant_three">
            <div class="container">
                <div class="row mb_25px ">
                    <div class="col-xxl-10">
                        <h2 class="titel">{{__('translate.All Restaurants')}} </h2>
                    </div>
                </div>


                <div class="row g-4">
                    @forelse($restaurants as $restaurant)
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="food_card_item">
                                <div class="food_card_item_thumb_main">
                                    <div class="food_card_item_thumb">
                                        <img src="{{$restaurant->cover_image}}" alt="thumb">
                                    </div>
                                    <div class="food_card_item_thumb_overlay">
                                        @if ($restaurant->is_featured == 'enable')
                                            <div class="badge">
                                                <h6>{{__('translate.Featured')}} </h6>
                                            </div>
                                        @endif

                                        @php
                                            $currentTime = now()->format('H:i');
                                            $openingHour = $restaurant->opening_hour;
                                            $closingHour = $restaurant->closing_hour;
                                        @endphp

                                        @if ($currentTime >= $openingHour && $currentTime <= $closingHour)
                                            <a href="javascript:;" class="open_btn">
                                                {{__('translate.Open')}}
                                            </a>
                                        @else
                                            <a href="javascript:;" class="open_btn closed_btn">
                                                {{__('translate.Closed')}}
                                            </a>
                                        @endif

                                    </div>
                                </div>

                                <div class="food_card_restaurant_logo_main">
                                    <div class="food_card_restaurant_logo">
                                        <img src="{{asset($restaurant->logo)}}" alt="logo">
                                    </div>
                                </div>
                                <a href="{{route('single.restaurant', $restaurant->slug)}}"
                                   class="food_card_restaurant_name">
                                    <h5>
                                        {{$restaurant->restaurant_name}}
                                        @if($restaurant->is_trusted == 1)
                                        <span>
                                            <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.1557 7.68198C16.8851 7.52464 16.6419 7.32423 16.4357 7.08865C16.4566 6.76066 16.5347 6.43885 16.6666 6.13781C16.9091 5.45365 17.1832 4.67865 16.7432 4.07615C16.3032 3.47365 15.4724 3.49281 14.7432 3.50948C14.421 3.54263 14.0955 3.52065 13.7807 3.44448C13.613 3.17157 13.4932 2.87197 13.4266 2.55865C13.2199 1.85448 12.9841 1.05865 12.2599 0.820313C11.5616 0.595313 10.9149 1.09031 10.3432 1.52531C10.0966 1.75058 9.81074 1.92879 9.4999 2.05115C9.18581 1.92979 8.89681 1.75153 8.6474 1.52531C8.0774 1.09281 7.43323 0.592813 6.73156 0.821147C6.00906 1.05615 5.77323 1.85448 5.5649 2.55865C5.49834 2.87095 5.37974 3.16984 5.21406 3.44281C4.89866 3.51878 4.57275 3.54131 4.2499 3.50948C3.51823 3.48948 2.69406 3.46781 2.2499 4.07615C1.80573 4.68448 2.08323 5.45365 2.32656 6.13698C2.46026 6.43757 2.53955 6.75951 2.56073 7.08781C2.35496 7.32371 2.11204 7.52441 1.84156 7.68198C1.23156 8.09865 0.539062 8.57281 0.539062 9.34281C0.539062 10.1128 1.23156 10.5853 1.84156 11.0036C2.11198 11.161 2.3549 11.3614 2.56073 11.597C2.54178 11.9252 2.46475 12.2474 2.33323 12.5486C2.09156 13.232 1.81823 14.007 2.2574 14.6095C2.69656 15.212 3.5249 15.1928 4.2574 15.1761C4.57987 15.143 4.90564 15.1649 5.22073 15.2411C5.38771 15.5143 5.50718 15.8139 5.57406 16.127C5.78073 16.8311 6.01656 17.627 6.74073 17.8653C6.85683 17.9025 6.97797 17.9217 7.0999 17.922C7.6859 17.8379 8.23055 17.5714 8.65656 17.1603C8.90324 16.935 9.18906 16.7568 9.4999 16.6345C9.81398 16.7558 10.103 16.9341 10.3524 17.1603C10.9232 17.5961 11.5699 18.0936 12.2691 17.8645C12.9916 17.6295 13.2274 16.8311 13.4357 16.1278C13.5025 15.8149 13.622 15.5157 13.7891 15.2428C14.1033 15.1663 14.4282 15.1438 14.7499 15.1761C15.4816 15.1936 16.3057 15.2178 16.7499 14.6095C17.1941 14.0011 16.9166 13.232 16.6732 12.5478C16.5404 12.2475 16.4612 11.9263 16.4391 11.5986C16.6449 11.3625 16.8882 11.1618 17.1591 11.0045C17.7691 10.5878 18.4616 10.1128 18.4616 9.34281C18.4616 8.57281 17.7666 8.09948 17.1557 7.68198Z"
                                                    fill="#49ADF4"/>
                                                <path
                                                    d="M8.6667 11.6345C8.58462 11.6347 8.50332 11.6186 8.42751 11.5871C8.3517 11.5556 8.28288 11.5094 8.22504 11.4512L6.55837 9.78452C6.44797 9.66604 6.38787 9.50934 6.39072 9.34742C6.39358 9.1855 6.45917 9.03102 6.57368 8.91651C6.68819 8.802 6.84268 8.7364 7.0046 8.73354C7.16652 8.73069 7.32322 8.79079 7.4417 8.90119L8.72504 10.1845L11.625 8.00952C11.7576 7.91007 11.9243 7.86736 12.0884 7.89081C12.2525 7.91425 12.4006 8.00192 12.5 8.13452C12.5995 8.26713 12.6422 8.43382 12.6188 8.59791C12.5953 8.76201 12.5076 8.91007 12.375 9.00952L9.0417 11.5095C8.93349 11.5906 8.80192 11.6345 8.6667 11.6345Z"
                                                    fill="white"/>
                                            </svg>
                                        </span>
                                        @endif
                                    </h5>
                                </a>
                                <div class="food_card_item_inner">
                                    <div class="food_card_btm_item">
                                        <p class="food_card_company_location">
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <ellipse cx="8" cy="7.33333" rx="2" ry="2" stroke-width="1.5"></ellipse>
                                                <path
                                                    d="M14 7.25926C14 10.5321 10.25 14.6667 8 14.6667C5.75 14.6667 2 10.5321 2 7.25926C2 3.98646 4.68629 1.33333 8 1.33333C11.3137 1.33333 14 3.98646 14 7.25926Z"
                                                    stroke-width="1.5"></path>
                                            </svg>

                                        </span>
                                            {{Illuminate\Support\Str::limit($restaurant?->address, 15)}}
                                        </p>

                                        <span class="dot"></span>

                                        <div class="food_card_item_inner_top">
                                            <p>

                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                        </svg>

                                                </span>

                                                {{ round($restaurant->reviews_avg_rating ?? 0) }}
                                                <span>({{ $restaurant->reviews_count }})</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <div class="row restaurant_pagination">
                    {{ $restaurants->links('frontend.layouts.partials.pagination') }}
                </div>
            </div>
        </section>


        <!-- Restaurant part end -->

        @if($offer_status && $foods->count() > 0)
        <!-- discount part start  -->
        <section class="discount discount_two discount_four ">
            <div class="container discount_bg" >
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="discount_txt_item">
                            <div class="discount_txt">
                                <h4>
                                    {{$offer_data->title}}
                                </h4>

                                <p>{{$offer_data->description}}</p>
                            </div>
                        </div>
                    </div>

                    @php
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

                        $today = date("Y-m-d H:i:s");

                        if ($offer_data && $offer_data->status == 1) {
                            if ($today <= $offer_data->end_time) {
                                $offer_status = 1;
                            }
                        }
                    @endphp

                    <div class="col-xxl-6 col-sm-6">
                        <div class="discount_time">
                            <div class="discount_time_item">
                                <h5 id="dayOffer">{{ str_pad($days, 2, '0', STR_PAD_LEFT) }}</h5>
                                <span>d</span>
                            </div>

                             <div class="discount_time_item">
                                <h5 id="hourOffer">{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}</h5>
                                <span>h</span>
                            </div>

                            <div class="discount_time_item">
                                <h5 id="minuteOffer">{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}</h5>
                                <span>m</span>
                            </div>
                            <div class="discount_time_item">
                                <h5 id="secondOffer">{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</h5>
                                <span>s</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="discount_slick_main">
                        <div class="discount_slick_arrow">
                            <span class="slick_arrow slick_arrow_left">
                                <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.66667 8.33331L11 4.99998M11 4.99998L7.66667 1.66665M11 4.99998L0.999999 4.99998"
                                        stroke="#28303F" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                              <span class="slick_arrow slick_arrow_right ">
                                <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.66667 8.33331L11 4.99998M11 4.99998L7.66667 1.66665M11 4.99998L0.999999 4.99998"
                                        stroke="#28303F" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>

                        <div class="discount_slick popular">
                            @forelse($foods as $discount_key => $food)
                            <div class="food_card_item">
                                <div class="food_card_item_thumb_main">
                                    <div class="food_card_item_thumb">
                                        <img src="{{asset($food->image)}}" alt="thumb">
                                    </div>
                                    <div class="food_card_item_thumb_overlay">
                                        @if ($food->created_at >= \Carbon\Carbon::now()->subWeek())
                                            <div class="badge">
                                                <h6>{{__('translate.NEW')}}</h6>
                                            </div>
                                        @endif
                                        <a  href="{{route('user.add-to-wishlist', ['id' => $food->id])}}" class="wishlist_icon {{ $wishlist->contains('item_id', $food->id) ? 'wihslist_active' : '' }}">
                                    <span>
                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.166 3.41668C15.0865 3.41668 15.8327 4.16287 15.8327 5.08334M9.99935 2.75212L10.5702 2.16668C12.346 0.345605 15.2251 0.345603 17.0009 2.16668C18.7289 3.93884 18.782 6.79484 17.1211 8.63328L12.3491 13.9151C11.0814 15.3183 8.9173 15.3183 7.64956 13.9151L2.87762 8.6333C1.21667 6.79487 1.26977 3.93886 2.99785 2.16669C4.77362 0.345615 7.65271 0.345617 9.42848 2.16669L9.99935 2.75212Z"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                        </a>
                                    </div>
                                </div>

                                <div class="food_card_item_inner">
                                    <div class="food_card_item_inner_top">
                                        <h5>{{currency(calculateFinalPrice($food))}}</h5>
                                        <p>


                                            <span>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                    </svg>

                                            </span>


                                            {{ round($food->reviews_avg_rating ?? 0) }}


                                            <span>({{ $food->reviews_count }}+)</span>
                                        </p>
                                    </div>

                                    <a class="food_card_modal_btn" onClick="loadProductModal({{ $food->id }})" href="javascript:;">
                                        <h5>{{$food->name}}</h5>
                                    </a>


                                    <ul class="food_card_list">
                                        @php
                                            $specifications = array_slice(json_decode($food->specification, true), 0, 2);
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
                                                <img src="{{asset($food?->restaurant?->logo)}}"
                                                     alt="logo">
                                            </div>

                                            <a href="{{route('single.restaurant', $food?->restaurant->slug)}}" class="food_card_company_name">
                                                {{$food?->restaurant->restaurant_name}}
                                            </a>
                                        </div>

                                        <a onClick="loadProductModal({{ $food->id }})" href="javascript:;" class="thm-btn_three">
                                            <span>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1610_24994)">
                                                    <path d="M5.33398 10.6667L11.1474 10.1822C12.9664 10.0307 13.3747 9.63333 13.5763 7.81927L14.0007 4" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M4 4H4.33333M14.6667 4H13" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M6.33398 4.00008H11.0007M8.66732 6.33341V1.66675" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M3.99935 14.6667C4.73573 14.6667 5.33268 14.0697 5.33268 13.3333C5.33268 12.597 4.73573 12 3.99935 12C3.26297 12 2.66602 12.597 2.66602 13.3333C2.66602 14.0697 3.26297 14.6667 3.99935 14.6667Z" stroke="#0C1321" stroke-width="1.5"></path>
                                                    <path d="M11.3333 14.6667C12.0697 14.6667 12.6667 14.0697 12.6667 13.3333C12.6667 12.597 12.0697 12 11.3333 12C10.597 12 10 12.597 10 13.3333C10 14.0697 10.597 14.6667 11.3333 14.6667Z" stroke="#0C1321" stroke-width="1.5"></path>
                                                    <path d="M5.33398 13.3333H10.0007" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M1.33398 1.33325H1.97798C2.60777 1.33325 3.15674 1.74965 3.30949 2.34321L5.293 10.0509C5.39323 10.4405 5.30745 10.8531 5.05948 11.1743L4.42207 11.9999" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                    </g>
                                                    </svg>

                                            </span>
                                            {{ __('translate.Add') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- discount part end  -->
        @endif


        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->

    </main>
@endsection
