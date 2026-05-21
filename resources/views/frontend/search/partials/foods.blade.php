<!-- discount part start  -->
@if($offer_status && $discount_products->count() > 0)
    <section class="discount  discount_three d-none">
        <div class="container discount_bg " >
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

                <div class="discount_slick_main">
                    <div class="discount_slick_arrow">
                                <span class="slick_arrow">
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
                        @forelse($discount_products as $food_key => $food)
                        <div class="food_card_item">
                            <div class="food_card_item_thumb_main">
                                <div class="food_card_item_thumb">
                                    <img
                                        src="{{asset($food->image)}}"
                                        alt="thumb">
                                </div>
                                <div class="food_card_item_thumb_overlay">
                                    @if ($food->created_at >= \Carbon\Carbon::now()->subWeek())
                                    <div class="badge">
                                        <h6>{{__('translate.NEW')}}</h6>
                                    </div>
                                    @endif
                                    <a href="{{route('user.add-to-wishlist', ['id' => $food->id])}}" class="wishlist_icon {{ $wishlist->contains('item_id', $food->id) ? 'wihslist_active' : '' }}">
                                    <span>
                                        <svg width="20" height="16" viewBox="0 0 20 16"
                                             fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <h5>{{currency(calculateFinalPrice($food))}}</h5>
                                    <p>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                                            </svg>


                                        {{ round($food->reviews_avg_rating ?? 0) }}


                                        <span>({{ $food->reviews_count }}+)</span>
                                    </p>
                                </div>

                                <a  class="food_card_modal_btn"
                                   onClick="loadProductModal({{ $food->id }})" href="javascript:;" >
                                    <h5>{{$food->translate_product?->name}}</h5>
                                </a>


                                <ul class="food_card_list">
                                    @forelse(json_decode($food->specification, true) as $name)
                                       <li>
                                        {{$name}}
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>


                                <div class="food_card_btm_item">

                                    <div class="food_card_company">
                                        <div class="food_card_company_thumb">
                                            <img
                                                src="{{asset($food?->restaurant?->logo)}}"
                                                alt="logo">
                                        </div>

                                        <a href="{{route('single.restaurant', $food?->restaurant->slug)}}"
                                           class="food_card_company_name">
                                            {{$food?->restaurant?->restaurant_name}}
                                        </a>
                                    </div>
                                </div>

                                <div class="food_card_btn">
                                    <a onClick="loadProductModal({{ $food->id }})" href="javascript:;"  class="thm-btn">
                                        <span>
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1610_25047)">
                                                <path d="M6 12L12.5401 11.455C14.5865 11.2845 15.0458 10.8375 15.2726 8.79667L15.75 4.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M4.5 4.5H4.875M16.5 4.5H14.625" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M7.125 4.5H12.375M9.75 7.125V1.875" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M4.5 16.5C5.32843 16.5 6 15.8284 6 15C6 14.1716 5.32843 13.5 4.5 13.5C3.67157 13.5 3 14.1716 3 15C3 15.8284 3.67157 16.5 4.5 16.5Z" stroke="#0C1321" stroke-width="1.5"></path>
                                                <path d="M12.75 16.5C13.5784 16.5 14.25 15.8284 14.25 15C14.25 14.1716 13.5784 13.5 12.75 13.5C11.9216 13.5 11.25 14.1716 11.25 15C11.25 15.8284 11.9216 16.5 12.75 16.5Z" stroke="#0C1321" stroke-width="1.5"></path>
                                                <path d="M6 15H11.25" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M1.5 1.5H2.2245C2.93301 1.5 3.55061 1.96844 3.72245 2.6362L5.95389 11.3074C6.06665 11.7456 5.97015 12.2098 5.69118 12.5712L4.9741 13.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                                </g>
                                                </svg>

                                        </span>
                                        {{ __('Add to Cart') }}
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

@forelse($foods as $food_keys => $all_food)
    <div class="col-xxl-4 col-sm-6 col-md-6 col-lg-6" @if ($food_keys > 2) data-aos="fade-up" data-aos-delay="100" @endif>
        <div class="food_card_item">
            <div class="food_card_item_thumb_main">
                <div class="food_card_item_thumb">
                    <img
                        src="{{asset($all_food->image)}}"
                        alt="thumb">
                </div>
                <div class="food_card_item_thumb_overlay">
                    @if ($all_food->created_at >= \Carbon\Carbon::now()->subWeek())
                    <div class="badge">
                        <h6>{{__('translate.NEW')}}</h6>
                    </div>
                    @endif
                    <a href="{{route('user.add-to-wishlist', ['id' => $all_food->id])}}" class="wishlist_icon {{ $wishlist->contains('item_id', $all_food->id) ? 'wihslist_active' : '' }}">
                    <span>
                        <svg width="20" height="16" viewBox="0 0 20 16"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    <h5>{{currency(calculateFinalPrice($all_food))}}</h5>
                    <p>

                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z" fill="#F9C200"/>
                            </svg>


                        {{ round($all_food->reviews_avg_rating ?? 0) }}


                        <span>({{ $all_food->reviews_count }}+)</span>
                    </p>
                </div>

                <a  class="food_card_modal_btn"
                onClick="loadProductModal({{ $all_food->id }})" href="javascript:;" >
                    <h5>{{$all_food->translate_product?->name}}</h5>
                </a>


                <ul class="food_card_list">
                    @forelse(json_decode($all_food->specification, true) as $name)
                       <li>
                        {{$name}}
                        </li>
                    @empty
                    @endforelse
                </ul>


                <div class="food_card_btm_item">

                    <div class="food_card_company">
                        <div class="food_card_company_thumb">
                            <img
                                src="{{asset($all_food?->restaurant?->logo)}}"
                                alt="logo">
                        </div>

                        <a href="{{route('single.restaurant', $all_food?->restaurant->slug)}}"
                           class="food_card_company_name">
                            {{$all_food?->restaurant?->restaurant_name}}
                        </a>
                    </div>
                </div>

                <div class="food_card_btn">
                    <a onClick="loadProductModal({{ $all_food->id }})" href="javascript:;"  class="thm-btn_four">
                        <span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1610_25047)">
                                <path d="M6 12L12.5401 11.455C14.5865 11.2845 15.0458 10.8375 15.2726 8.79667L15.75 4.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M4.5 4.5H4.875M16.5 4.5H14.625" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M7.125 4.5H12.375M9.75 7.125V1.875" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M4.5 16.5C5.32843 16.5 6 15.8284 6 15C6 14.1716 5.32843 13.5 4.5 13.5C3.67157 13.5 3 14.1716 3 15C3 15.8284 3.67157 16.5 4.5 16.5Z" stroke="#0C1321" stroke-width="1.5"></path>
                                <path d="M12.75 16.5C13.5784 16.5 14.25 15.8284 14.25 15C14.25 14.1716 13.5784 13.5 12.75 13.5C11.9216 13.5 11.25 14.1716 11.25 15C11.25 15.8284 11.9216 16.5 12.75 16.5Z" stroke="#0C1321" stroke-width="1.5"></path>
                                <path d="M6 15H11.25" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M1.5 1.5H2.2245C2.93301 1.5 3.55061 1.96844 3.72245 2.6362L5.95389 11.3074C6.06665 11.7456 5.97015 12.2098 5.69118 12.5712L4.9741 13.5" stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"></path>
                                </g>
                                </svg>

                        </span>
                        {{ __('translate.Add to Cart') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@empty

    <div class="col-12 text-center">
        <div class="maintenance-item">
            <div class="maintenance-thumb">
                <img src="{{ asset($general_setting->not_found) }}" alt="thumg">
            </div>

            <div class="maintenance-item-txt">
                <h2>{{ __('translate.Sorry!! Food Not Found') }}</h2>
                <p>{{ __('translate.Whoops... this information is not available for a moment') }}</p>
                <a class="thm-btn" href="{{ route('search') }}">
                    {{ __('translate.Back to Home') }}
                </a>
            </div>
        </div>
    </div>
@endforelse

