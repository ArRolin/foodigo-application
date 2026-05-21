@extends('frontend.layouts.master')

@section('title')
    <title>{{ __('translate.Wishlist') }}</title>
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
                            <li><a href="javascript:;" class="active">{{__('translate.Wishlist')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- dashboard part start  -->


        <section class="dashboard wishlist">
            <div class="container">
                <div class="row">
                    <div class=" col-lg-4 col-xxl-3">
                        @include('frontend.layouts.partials.dashboard_partials')
                    </div>

                    <div class="col-lg-8 col-xxl-9  ">
                        <div class="row change_password">
                            <div class="col-lg-12">
                                <div class="dashbord_taitel mb_25px">
                                    <h4>{{__('translate.My Wishlist')}}</h4>
                                </div>
                                <div class="row  g-4 ">
                                    @forelse($wishlists ?? [] as $pro_key => $wishlist)
                                        <div class="col-xxl-6">
                                            <div class="food_card_item">
                                                <div class="food_card_item_thumb_main">
                                                    <div class="food_card_item_thumb">
                                                        <img src="{{asset($wishlist['product']['image'])}}" alt="thumb">
                                                    </div>
                                                    <div class="food_card_item_thumb_overlay">
                                                        @if ($wishlist['product']['created_at'] >= \Carbon\Carbon::now()->subWeek())
                                                        <div class="badge">
                                                            <h6>{{__('translate.NEW')}}</h6>
                                                        </div>
                                                        @endif
                                                        <a href="{{ route('user.remove-wishlist', $wishlist['wishlist_item']['id']) }}" class="wishlist_icon wihslist_active">
                                                            <span>
                                                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                        <h5>{{currency($wishlist['product']['offer_price'] > 0 ? $wishlist['product']['offer_price'] : $wishlist['product']['price'])}}</h5>
                                                        <p>

                                                            <span>
                                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                                                    </svg>

                                                            </span>

                                                            {{ round($wishlist['product']['reviews_avg_rating'] ?? 0) }}

                                                            <span>({{ $wishlist['product']['reviews_count'] }}+)</span>
                                                        </p>
                                                    </div>

                                                    <a  class="food_card_modal_btn" onClick="loadProductModal({{ $wishlist['product']['id'] }})" href="javascript:;">
                                                        <h5>{{$wishlist['translated_name']}}</h5>
                                                    </a>

                                                    <ul class="food_card_list">
                                                        @php
                                                            $specifications = array_slice(json_decode($wishlist['product']['specification'], true), 0, 2);
                                                        @endphp

                                                        @forelse($specifications as $name)
                                                            <li>{{$name}}</li>
                                                        @empty
                                                        @endforelse
                                                    </ul>

                                                    <div class="food_card_btm_item">
                                                        <div class="food_card_company">
                                                            <div class="food_card_company_thumb">
                                                                <img src="{{asset($wishlist['product']['restaurant']['logo'])}}" alt="logo">
                                                            </div>
                                                            <a href="{{route('single.restaurant', $wishlist['product']['restaurant']['slug'])}}" class="food_card_company_name">
                                                                {{$wishlist['product']['restaurant']['restaurant_name']}}
                                                            </a>
                                                        </div>
                                                        <a onClick="loadProductModal({{ $wishlist['product']['id'] }})" href="javascript:;" class="thm-btn_three">
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
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- dashboard part end -->

    </main>
@endsection
