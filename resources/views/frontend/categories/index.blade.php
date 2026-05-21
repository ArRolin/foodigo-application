@extends('frontend.layouts.master')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}" />
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}" />
@endsection

@section('content')
    <main>
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Categories')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- categories part start -->

        <section class="categories categories_two   ">
            <div class="container">
                <div class="row mb_25px ">
                    <div class="col-xxl-12">
                        <h2 class="titel"> {{__('translate.Popular Categories')}}</h2>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($categories as $category)
                        <div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-2">

                            <a href="{{route('search', ['categories' => [$category->id]])}}"  >
                                <div class="categories_item">
                                    <div class="icon" >
                                        <img src="{{ asset($category->icon) }}"   alt="Icon">
                                    </div>
                                    <h4 class="text">
                                        {{ $category?->name }}
                                    </h4>
                                </div>
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>

        <!-- categories part end -->


        <!-- discount part start  -->
        @if($offer_status && $foods->count() > 0)
            <section class="discount  discount_three">
                <div class="container discount_bg ">
                    <div class="row">
                        <div class="col-xxl-6 col-sm-6">
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

                        <div class="discount_slick_main discount_slick_main_two">
                            <div class="discount_slick_arrow ">
                                <span class="slick_arrow slick_arrow_left">
                                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.66667 8.33331L11 4.99998M11 4.99998L7.66667 1.66665M11 4.99998L0.999999 4.99998"
                                            stroke="#28303F" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
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

                            <div class="slickSlider" data-slidestoshow="4" data-desktopitem="3" data-laptop="3" data-mobile="1">
                                @forelse($foods as $food_key => $food)

                                @php
                                    $price = calculateFinalPrice($food);
                                @endphp

                                    <div class="food_card_item">
                                        <div class="food_card_item_thumb_main">
                                            <div class="food_card_item_thumb">
                                                <img src="{{asset($food->image)}}"
                                                    alt="thumb">
                                            </div>

                                            <div class="food_card_item_thumb_overlay">

                                                <a  href="{{route('user.add-to-wishlist', ['id' => $food->id])}}" class="wishlist_icon {{ $wishlist->contains('item_id', $food->id) ? 'wihslist_active' : '' }}">
                                                <span>
                                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.166 3.41668C15.0865 3.41668 15.8327 4.16287 15.8327 5.08334M9.99935 2.75212L10.5702 2.16668C12.346 0.345605 15.2251 0.345603 17.0009 2.16668C18.7289 3.93884 18.782 6.79484 17.1211 8.63328L12.3491 13.9151C11.0814 15.3183 8.9173 15.3183 7.64956 13.9151L2.87762 8.6333C1.21667 6.79487 1.26977 3.93886 2.99785 2.16669C4.77362 0.345615 7.65271 0.345617 9.42848 2.16669L9.99935 2.75212Z"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                                </a>
                                            </div>

                                        </div>

                                        <div class="food_card_item_inner">
                                            <div class="food_card_item_inner_top">
                                                <h5>{{currency($price)}}</h5>
                                                <p> {{ round($food->reviews_avg_rating ?? 0) }}
                                                    <span>
                                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="0.5" y="0.5" width="20" height="20" rx="10" fill="#F9C200">
                                                        </rect>
                                                        <path
                                                            d="M9.51641 6.13571C9.91875 5.2881 11.0812 5.2881 11.4836 6.1357L12.1789 7.60059C12.3387 7.93717 12.6476 8.17047 13.0048 8.22444L14.5597 8.45935C15.4593 8.59527 15.8186 9.74477 15.1676 10.4045L14.0425 11.5448C13.7839 11.8068 13.666 12.1843 13.727 12.5542L13.9926 14.1643C14.1463 15.0959 13.2058 15.8063 12.4011 15.3665L11.0104 14.6063C10.6909 14.4316 10.3091 14.4316 9.98959 14.6063L8.59888 15.3665C7.7942 15.8063 6.85371 15.0959 7.00739 14.1643L7.27299 12.5542C7.33402 12.1843 7.21606 11.8068 6.95754 11.5448L5.83244 10.4045C5.18143 9.74477 5.54066 8.59527 6.44033 8.45935L7.99519 8.22444C8.35244 8.17047 8.66128 7.93717 8.82105 7.60059L9.51641 6.13571Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </span>

                                                    <span>({{$food->reviews_count}}+)</span>
                                                </p>
                                            </div>

                                            <a  class="food_card_modal_btn" href="javascript::" onClick="loadProductModal({{ $food->id }})">
                                                <h5>{{$food->name}} </h5>
                                            </a>


                                            <ul class="food_card_list">
                                                @forelse(json_decode($food->specification, true) as $name)
                                                    <li>
                                                <span>
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 9L7.90101 10.7109C8.22464 11.0022 8.72744 10.9576 8.99475 10.6139L12 6.75M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z"
                                                            stroke="#FE724C" stroke-width="1.3" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>

                                                </span>
                                                        {{$name}}
                                                    </li>
                                                @empty
                                                @endforelse
                                            </ul>


                                            <div class="food_card_btm_item">

                                                <div class="food_card_company">
                                                    <div class="food_card_company_thumb">
                                                        <img src="{{asset($food->restaurant->logo)}}"
                                                            alt="logo">
                                                    </div>

                                                    <a href="{{route('single.restaurant', $food?->restaurant->slug)}}"
                                                    class="food_card_company_name">
                                                        {{$food->restaurant->restaurant_name}}
                                                    </a>
                                                </div>

                                            </div>

                                            <div class="food_card_btn">
                                                <a onClick="loadProductModal({{ $food->id }})" href="javascript:;" class="thm-btn_four">
                                                    <span>
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1610_25047)">
                                                            <path d="M6 12L12.5401 11.455C14.5865 11.2845 15.0458 10.8375 15.2726 8.79667L15.75 4.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M4.5 4.5H4.875M16.5 4.5H14.625" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M7.125 4.5H12.375M9.75 7.125V1.875" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M4.5 16.5C5.32843 16.5 6 15.8284 6 15C6 14.1716 5.32843 13.5 4.5 13.5C3.67157 13.5 3 14.1716 3 15C3 15.8284 3.67157 16.5 4.5 16.5Z" stroke="#0C1321" stroke-width="1.5"/>
                                                            <path d="M12.75 16.5C13.5784 16.5 14.25 15.8284 14.25 15C14.25 14.1716 13.5784 13.5 12.75 13.5C11.9216 13.5 11.25 14.1716 11.25 15C11.25 15.8284 11.9216 16.5 12.75 16.5Z" stroke="#0C1321" stroke-width="1.5"/>
                                                            <path d="M6 15H11.25" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M1.5 1.5H2.2245C2.93301 1.5 3.55061 1.96844 3.72245 2.6362L5.95389 11.3074C6.06665 11.7456 5.97015 12.2098 5.69118 12.5712L4.9741 13.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                                            </g>
                                                            </svg>

                                                    </span>
                                                    {{ __('translate.Add to Cart') }}
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

        @endif
        <!-- discount part end  -->


        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->


    </main>
@endsection


