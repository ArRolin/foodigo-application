@extends('frontend.layouts.master')


@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}" />
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}" />
@endsection

@section('content')
    <main>
        <!-- banner-part start  -->
        <section class="banner">
            <div class="banner_slick_main">
                <div class="banner_slick_main_item">
                    <div class="banner_slick_main_txt">
                        <h1>{{ $home_translate->intro_title }}</h1>
                    </div>

                    <div class="banner_slick_main_item_box_main">
                        <form id="search-form" action="{{ route('search') }}" method="get">
                            <div class="banner_slick_main_item_box">
                                <div class="form-control_main">
                                    <span class="icon">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.7659" cy="12.2666" r="8.98856" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></circle>
                                            <path d="M18.0176 18.9852L21.5416 22.5001" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="search_input"
                                        placeholder="{{ __('translate.Food Title or keyword') }}" name="search_value">
                                </div>
                                <button type="submit" class="thm-btn">{{ __('translate.Search now!') }}</button>
                            </div>
                        </form>
                    </div>


                    <ul class="popular_link">
                        <li>{{ __('translate.Popular') }}:</li>
                        @php
                            $tags = json_decode($home_translate->intro_tags, true) ?? [];
                            $tagsCount = count($tags);
                        @endphp
                        @foreach ($tags as $index => $tag)
                            <li>
                                <a href="{{ route('search', ['search_value' => $tag['value']]) }}">{{ $tag['value'] }}</a>
                                @if ($index < $tagsCount - 1)
                                    ,
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="banner_slick">
                    <div class="banner_slick_thumb">
                        <img src="{{ asset($homepage->intro_banner_one) }}" alt="thumb">
                    </div>
                    <div class="banner_slick_thumb">
                        <img src="{{ asset($homepage->intro_banner_two) }}" alt="thumb">
                    </div>
                </div>
            </div>
        </section>
        <!-- banner-part end -->


        <!-- work prosses start -->
        <section class="work_prosses">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xxl-3 col-sm-6 col-xl-3">
                        <div class="work_prosses_item">
                            <div class="work_prosses_thumb">
                                <img src="{{ asset($homepage->working_step_icon1) }}" alt="icon">
                            </div>

                            <div class="work_prosses_txt">
                                <h4>
                                    {{ $home_translate->working_step_title1 }}
                                </h4>
                                <p>{{ $home_translate->working_step_des1 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6 col-xl-3">
                        <div class="work_prosses_item">
                            <div class="work_prosses_thumb">
                                <img src="{{ asset($homepage->working_step_icon2) }}" alt="icon">
                            </div>

                            <div class="work_prosses_txt">
                                <h4>
                                    {{ $home_translate->working_step_title2 }}
                                </h4>
                                <p>{{ $home_translate->working_step_des2 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6 col-xl-3">
                        <div class="work_prosses_item">
                            <div class="work_prosses_thumb">
                                <img src="{{ asset($homepage->working_step_icon3) }}" alt="icon">
                            </div>

                            <div class="work_prosses_txt">
                                <h4>
                                    {{ $home_translate->working_step_title3 }}
                                </h4>
                                <p>{{ $home_translate->working_step_des3 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6 col-xl-3">
                        <div class="work_prosses_item">
                            <div class="work_prosses_thumb">
                                <img src="{{ asset($homepage->working_step_icon4) }}" alt="icon">
                            </div>

                            <div class="work_prosses_txt">
                                <h4>
                                    {{ $home_translate->working_step_title4 }}
                                </h4>
                                <p>{{ $home_translate->working_step_des4 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- work prosses end -->


        <!-- Categories part start -->
        <section class="categories">
            <div class="container">
                <div class="row  ">
                    <div class="col-xxl-10 col-sm-8">
                        <h2 class="titel"> {{ __('translate.Popular Categories') }}</h2>
                    </div>

                    <div class="col-xxl-2 col-sm-4">
                        <div class="view_btn d-none d-md-block">
                            <a href="{{ route('website.categories') }}"
                                class="thm-btn_two">{{ __('translate.View more') }}</a>
                        </div>

                    </div>
                </div>

                <div class="row categories_slick categories_mb">
                    @forelse($categories as $category)
                        <div class="col-xxl-2">


                            <a href="{{ route('search', ['categories' => [$category->id]]) }}">
                                <div class="categories_item">
                                    <div class="icon">
                                        <img src="{{ asset($category->icon) }}" alt="Icon">
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

                <div class="view_btn d-md-none mb-4 md-mb-0">
                    <a href="{{ route('website.categories') }}" class="thm-btn_two">{{ __('translate.View more') }}</a>
                </div>


                <!-- Featured Foods part start  -->

                <div class="row  mb_25px  ">
                    <div class="col-xxl-10 col-sm-8 " data-aos="fade-down" data-aos-delay="50">
                        <h2 class="titel"> {{ __('translate.Featured Foods') }}</h2>
                    </div>


                    <div class="col-xxl-2  col-sm-4" data-aos="fade-down" data-aos-delay="50">
                        <div class="view_btn d-none d-md-block">
                            <a href="{{ route('search') }}" class="thm-btn_two">{{ __('translate.View more') }}</a>
                        </div>

                    </div>
                </div>


                <div class="row g-4  ">
                    @forelse($featured_products as $featured_key => $featured_product)
                        <div class="col-xxl-3 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="50">
                            <div class="food_card_item">
                                <div class="food_card_item_thumb_main">
                                    <div class="food_card_item_thumb">
                                        <img src="{{ asset($featured_product->image) }}" alt="thumb">
                                    </div>

                                    <div class="food_card_item_thumb_overlay">
                                        @if ($featured_product->created_at >= \Carbon\Carbon::now()->subWeek())
                                            <div class="badge">
                                                <h6>{{ __('translate.NEW') }}</h6>
                                            </div>
                                        @endif

                                        <a href="{{ route('user.add-to-wishlist', ['id' => $featured_product->id]) }}"
                                            class="wishlist_icon {{ $wishlist->contains('item_id', $featured_product->id) ? 'wihslist_active' : '' }}">
                                            <span>
                                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14.166 3.41668C15.0865 3.41668 15.8327 4.16287 15.8327 5.08334M9.99935 2.75212L10.5702 2.16668C12.346 0.345605 15.2251 0.345603 17.0009 2.16668C18.7289 3.93884 18.782 6.79484 17.1211 8.63328L12.3491 13.9151C11.0814 15.3183 8.9173 15.3183 7.64956 13.9151L2.87762 8.6333C1.21667 6.79487 1.26977 3.93886 2.99785 2.16669C4.77362 0.345615 7.65271 0.345617 9.42848 2.16669L9.99935 2.75212Z"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <div class="food_card_item_inner">
                                    <div class="food_card_item_inner_top">
                                        <h5>{{ currency(calculateFinalPrice($featured_product)) }}</h5>

                                        <p>

                                            <span>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z"
                                                        fill="#F9C200" />
                                                </svg>

                                            </span>


                                            {{ round($featured_product->reviews_avg_rating ?? 0) }}


                                            <span>({{ $featured_product->reviews_count }}+)</span>
                                        </p>
                                    </div>

                                    <a href="javascript::" onClick="loadProductModal({{ $featured_product->id }})">
                                        <h5>{{ $featured_product->translate_product?->name }}</h5>
                                    </a>


                                    <ul class="food_card_list">
                                        @forelse(json_decode($featured_product->specification, true) as $name)
                                            <li>
                                                {{ $name }}
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>


                                    <div class="food_card_btm_item">

                                        <div class="food_card_company">
                                            <div class="food_card_company_thumb">
                                                <img src="{{ asset($featured_product?->restaurant?->logo) }}"
                                                    alt="logo">
                                            </div>

                                            <a href="{{ route('single.restaurant', $featured_product?->restaurant?->slug) }}"
                                                class="food_card_company_name">
                                                {{ $featured_product?->restaurant?->restaurant_name }}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="food_card_btn">
                                        <a onClick="loadProductModal({{ $featured_product->id }})" href="javascript:;"
                                            class="thm-btn_four">
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1610_25047)">
                                                        <path
                                                            d="M6 12L12.5401 11.455C14.5865 11.2845 15.0458 10.8375 15.2726 8.79667L15.75 4.5"
                                                            stroke="#0C1321" stroke-width="1.5" stroke-linecap="round" />
                                                        <path d="M4.5 4.5H4.875M16.5 4.5H14.625" stroke="#0C1321"
                                                            stroke-width="1.5" stroke-linecap="round" />
                                                        <path d="M7.125 4.5H12.375M9.75 7.125V1.875" stroke="#0C1321"
                                                            stroke-width="1.5" stroke-linecap="round" />
                                                        <path
                                                            d="M4.5 16.5C5.32843 16.5 6 15.8284 6 15C6 14.1716 5.32843 13.5 4.5 13.5C3.67157 13.5 3 14.1716 3 15C3 15.8284 3.67157 16.5 4.5 16.5Z"
                                                            stroke="#0C1321" stroke-width="1.5" />
                                                        <path
                                                            d="M12.75 16.5C13.5784 16.5 14.25 15.8284 14.25 15C14.25 14.1716 13.5784 13.5 12.75 13.5C11.9216 13.5 11.25 14.1716 11.25 15C11.25 15.8284 11.9216 16.5 12.75 16.5Z"
                                                            stroke="#0C1321" stroke-width="1.5" />
                                                        <path d="M6 15H11.25" stroke="#0C1321" stroke-width="1.5"
                                                            stroke-linecap="round" />
                                                        <path
                                                            d="M1.5 1.5H2.2245C2.93301 1.5 3.55061 1.96844 3.72245 2.6362L5.95389 11.3074C6.06665 11.7456 5.97015 12.2098 5.69118 12.5712L4.9741 13.5"
                                                            stroke="#0C1321" stroke-width="1.5" stroke-linecap="round" />
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
                    @endforelse

                    <div class="view_btn d-md-none">
                        <a href="{{ route('website.categories') }}"
                            class="thm-btn_two">{{ __('translate.View more') }}</a>
                    </div>

                </div>
                <!-- Features Foods part end  -->
            </div>
        </section>
        <!-- Categories part end -->


        <!-- Cuisine part start  -->
        @if (!empty($cuisines))
            <section class="cuisine">
                <div class="container">
                    <div class="row mb_25px ">
                        <div class="col-xxl-10 col-sm-8" data-aos="fade-down" data-aos-delay="50">
                            <h2 class="titel">{{ __('translate.Select Cuisine') }} </h2>
                        </div>

                        <div class="col-xxl-2 col-sm-4" data-aos="fade-down" data-aos-delay="50">
                            <div class="view_btn d-none d-md-block">
                                <a href="{{ route('all.cuisine') }}"
                                    class="thm-btn_two">{{ __('translate.View more') }}</a>
                            </div>

                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-xxl-12">
                            <div class="cuisine_item_main">
                                @forelse($cuisines as $cuisine)
                                    <div class="cuisine_item" data-aos="fade-right" data-aos-delay="50">
                                        <div class="cuisine_item_thumb_main">
                                            <div class="cuisine_item_thumb">
                                                <img src="{{ asset($cuisine->icon) }}" alt="thumb">
                                            </div>
                                        </div>
                                        <div class="cuisine_item_txt_main">
                                            <a href="{{ route('all.restaurant', ['cuisine_id' => $cuisine->id]) }}"
                                                class="cuisine_item_txt">
                                                <h4>{{ $cuisine->name }}</h4>
                                            </a>
                                            <p>
                                                <span></span> {{ $cuisine->total_restaurant }}
                                                {{ __('translate.Restaurants') }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="view_btn  d-md-none">
                        <a href="{{ route('all.cuisine') }}" class="thm-btn_two">{{ __('translate.View more') }}</a>
                    </div>
                </div>
            </section>
        @endif
        <!-- Cuisine part end -->


        <!--  Restaurant part start -->
        <section class="restaurant">
            <div class="container">
                <div class="row g-4 mb_80px">
                    @if ($homepage->promotional_banner_one_status == 1)
                        <div class="col-xxl-6 col-sm-6" data-aos="zoom-in" data-aos-delay="50">
                            <a href="{{ $homepage->promotional_banner_one_url }}" class="restaurant_ads">
                                <img src="{{ asset($homepage->promotional_banner_one) }}" alt="ads">
                            </a>
                        </div>
                    @endif
                    @if ($homepage->promotional_banner_two_status == 1)
                        <div class="col-xxl-6  col-sm-6" data-aos="zoom-in" data-aos-delay="50">
                            <a href="{{ $homepage->promotional_banner_two_url }}" class="restaurant_ads">
                                <img src="{{ asset($homepage->promotional_banner_two) }}" alt="ads">
                            </a>
                        </div>
                    @endif
                </div>

                @if (!empty($restaurants))
                    <div class="row mb_25px ">
                        <div class="col-xxl-10  col-sm-8" data-aos="fade-down" data-aos-delay="50">
                            <h2 class="titel">{{ __('translate.All Restaurant') }} </h2>
                        </div>

                        <div class="col-xxl-2  col-sm-4" data-aos="fade-down" data-aos-delay="50">
                            <div class="view_btn d-none d-md-block">
                                <a href="{{ route('all.restaurant') }}"
                                    class="thm-btn_two">{{ __('translate.View more') }}</a>
                            </div>

                        </div>
                    </div>


                    <div class="row g-4">
                        @forelse($restaurants as $restaurant)
                            <div class="col-xxl-3 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="food_card_item">
                                    <div class="food_card_item_thumb_main">
                                        <div class="food_card_item_thumb">
                                            <img src="{{ asset($restaurant->cover_image) }}" alt="thumb">

                                        </div>
                                        <div class="food_card_item_thumb_overlay">
                                            @if ($restaurant->is_featured == 'enable')
                                                <div class="badge">
                                                    <h6>{{ __('translate.Featured') }} </h6>
                                                </div>
                                            @endif


                                            @php
                                                $currentTime = now()->format('H:i');

                                                $openingHour = $restaurant->opening_hour;
                                                $closingHour = $restaurant->closing_hour;
                                            @endphp

                                            @if ($currentTime >= $openingHour && $currentTime <= $closingHour)
                                                <a href="javascript:;" class="open_btn">
                                                    {{ __('translate.Open') }}
                                                </a>
                                            @else
                                                <a href="javascript:;" class="open_btn closed_btn">
                                                    {{ __('translate.Closed') }}
                                                </a>
                                            @endif


                                        </div>
                                    </div>

                                    <div class="food_card_restaurant_logo_main">
                                        <div class="food_card_restaurant_logo">
                                            <img src="{{ asset($restaurant->logo) }}" alt="logo">
                                        </div>
                                    </div>
                                    <a href="{{ route('single.restaurant', $restaurant->slug) }}"
                                        class="food_card_restaurant_name">
                                        <h5>
                                            {{ $restaurant->restaurant_name }}
                                            @if ($restaurant->is_trusted == 1)
                                                <span>
                                                    <svg width="19" height="18" viewBox="0 0 19 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.1557 7.68198C16.8851 7.52464 16.6419 7.32423 16.4357 7.08865C16.4566 6.76066 16.5347 6.43885 16.6666 6.13781C16.9091 5.45365 17.1832 4.67865 16.7432 4.07615C16.3032 3.47365 15.4724 3.49281 14.7432 3.50948C14.421 3.54263 14.0955 3.52065 13.7807 3.44448C13.613 3.17157 13.4932 2.87197 13.4266 2.55865C13.2199 1.85448 12.9841 1.05865 12.2599 0.820313C11.5616 0.595313 10.9149 1.09031 10.3432 1.52531C10.0966 1.75058 9.81074 1.92879 9.4999 2.05115C9.18581 1.92979 8.89681 1.75153 8.6474 1.52531C8.0774 1.09281 7.43323 0.592813 6.73156 0.821147C6.00906 1.05615 5.77323 1.85448 5.5649 2.55865C5.49834 2.87095 5.37974 3.16984 5.21406 3.44281C4.89866 3.51878 4.57275 3.54131 4.2499 3.50948C3.51823 3.48948 2.69406 3.46781 2.2499 4.07615C1.80573 4.68448 2.08323 5.45365 2.32656 6.13698C2.46026 6.43757 2.53955 6.75951 2.56073 7.08781C2.35496 7.32371 2.11204 7.52441 1.84156 7.68198C1.23156 8.09865 0.539062 8.57281 0.539062 9.34281C0.539062 10.1128 1.23156 10.5853 1.84156 11.0036C2.11198 11.161 2.3549 11.3614 2.56073 11.597C2.54178 11.9252 2.46475 12.2474 2.33323 12.5486C2.09156 13.232 1.81823 14.007 2.2574 14.6095C2.69656 15.212 3.5249 15.1928 4.2574 15.1761C4.57987 15.143 4.90564 15.1649 5.22073 15.2411C5.38771 15.5143 5.50718 15.8139 5.57406 16.127C5.78073 16.8311 6.01656 17.627 6.74073 17.8653C6.85683 17.9025 6.97797 17.9217 7.0999 17.922C7.6859 17.8379 8.23055 17.5714 8.65656 17.1603C8.90324 16.935 9.18906 16.7568 9.4999 16.6345C9.81398 16.7558 10.103 16.9341 10.3524 17.1603C10.9232 17.5961 11.5699 18.0936 12.2691 17.8645C12.9916 17.6295 13.2274 16.8311 13.4357 16.1278C13.5025 15.8149 13.622 15.5157 13.7891 15.2428C14.1033 15.1663 14.4282 15.1438 14.7499 15.1761C15.4816 15.1936 16.3057 15.2178 16.7499 14.6095C17.1941 14.0011 16.9166 13.232 16.6732 12.5478C16.5404 12.2475 16.4612 11.9263 16.4391 11.5986C16.6449 11.3625 16.8882 11.1618 17.1591 11.0045C17.7691 10.5878 18.4616 10.1128 18.4616 9.34281C18.4616 8.57281 17.7666 8.09948 17.1557 7.68198Z"
                                                            fill="#49ADF4" />
                                                        <path
                                                            d="M8.6667 11.6345C8.58462 11.6347 8.50332 11.6186 8.42751 11.5871C8.3517 11.5556 8.28288 11.5094 8.22504 11.4512L6.55837 9.78452C6.44797 9.66604 6.38787 9.50934 6.39072 9.34742C6.39358 9.1855 6.45917 9.03102 6.57368 8.91651C6.68819 8.802 6.84268 8.7364 7.0046 8.73354C7.16652 8.73069 7.32322 8.79079 7.4417 8.90119L8.72504 10.1845L11.625 8.00952C11.7576 7.91007 11.9243 7.86736 12.0884 7.89081C12.2525 7.91425 12.4006 8.00192 12.5 8.13452C12.5995 8.26713 12.6422 8.43382 12.6188 8.59791C12.5953 8.76201 12.5076 8.91007 12.375 9.00952L9.0417 11.5095C8.93349 11.5906 8.80192 11.6345 8.6667 11.6345Z"
                                                            fill="white" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </h5>
                                    </a>
                                    <div class="food_card_item_inner">
                                        <div class="food_card_btm_item">
                                            <p class="food_card_company_location">
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <ellipse cx="8" cy="7.33333" rx="2"
                                                            ry="2" stroke-width="1.5"></ellipse>
                                                        <path
                                                            d="M14 7.25926C14 10.5321 10.25 14.6667 8 14.6667C5.75 14.6667 2 10.5321 2 7.25926C2 3.98646 4.68629 1.33333 8 1.33333C11.3137 1.33333 14 3.98646 14 7.25926Z"
                                                            stroke-width="1.5"></path>
                                                    </svg>

                                                </span>
                                                {{ Illuminate\Support\Str::limit($restaurant?->address, 15) }}
                                            </p>

                                            <span class="dot"></span>

                                            <div class="food_card_item_inner_top">
                                                <p>
                                                    <span>
                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z"
                                                                fill="#F9C200" />
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


                    <div class="view_btn  d-md-none">
                        <a href="{{ route('all.restaurant') }}" class="thm-btn_two">{{ __('translate.View more') }}</a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Restaurant part end -->


        <!-- Popular part start -->

        @if (!empty($popular_products))
            <section class="popular">
                <div class="container">
                    <div class="row mb_25px ">
                        <div class="col-xxl-12" data-aos="fade-down" data-aos-delay="50">
                            <h2 class="titel">{{ __('translate.Most Popular Items') }}</h2>
                        </div>
                    </div>
                    <div class="row g-4">
                        @forelse($popular_products as $popular_key => $popular_product)
                            <div class="col-xxl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="food_card_item">
                                    <div class="food_card_item_thumb_main">
                                        <div class="food_card_item_thumb">
                                            <img src="{{ asset($popular_product->image) }}" alt="thumb">

                                        </div>
                                        <div class="food_card_item_thumb_overlay">
                                            @if ($popular_product->created_at >= \Carbon\Carbon::now()->subWeek())
                                                <div class="badge">
                                                    <h6>{{ __('translate.NEW') }}</h6>
                                                </div>
                                            @endif
                                            <a href="{{ route('user.add-to-wishlist', ['id' => $popular_product->id]) }}"
                                                class="wishlist_icon {{ $wishlist->contains('item_id', $popular_product->id) ? 'wihslist_active' : '' }}">
                                                <span>
                                                    <svg width="20" height="16" viewBox="0 0 20 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                            <h5>{{ currency(calculateFinalPrice($popular_product)) }}</h5>
                                            <p>
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.52461 1.45356C7.12812 0.182149 8.87187 0.182146 9.47539 1.45356L10.5184 3.65088C10.7581 4.15576 11.2213 4.5057 11.7572 4.58666L14.0895 4.93902C15.439 5.1429 15.9779 6.86716 15.0013 7.85681L13.3137 9.56719C12.9259 9.96019 12.749 10.5264 12.8405 11.0813L13.2389 13.4964C13.4694 14.8938 12.0587 15.9595 10.8517 15.2997L8.76562 14.1595C8.28631 13.8975 7.71369 13.8975 7.23438 14.1595L5.14832 15.2997C3.94129 15.9595 2.53057 14.8938 2.76109 13.4964L3.15949 11.0813C3.25103 10.5264 3.07408 9.96019 2.68631 9.56719L0.998656 7.85681C0.0221496 6.86716 0.560996 5.1429 1.9105 4.93902L4.24278 4.58666C4.77867 4.5057 5.24192 4.15576 5.48158 3.65088L6.52461 1.45356Z"
                                                            fill="#F9C200" />
                                                    </svg>

                                                </span>
                                                {{ round($popular_product->reviews_avg_rating ?? 0) }}
                                                <span>({{ $popular_product->reviews_count }}+)</span>
                                            </p>
                                        </div>

                                        <a class="food_card_modal_btn"
                                            onClick="loadProductModal({{ $popular_product->id }})" href="javascript:;">
                                            <h5>{{ $popular_product->name }}</h5>
                                        </a>


                                        <ul class="food_card_list">

                                            @php
                                                $specifications = array_slice(
                                                    json_decode($popular_product->specification, true),
                                                    0,
                                                    2,
                                                );
                                            @endphp

                                            @forelse($specifications as $popular_name)
                                                <li>
                                                    {{ $popular_name }}
                                                </li>
                                            @empty
                                            @endforelse
                                        </ul>


                                        <div class="food_card_btm_item">

                                            <div class="food_card_company">
                                                <div class="food_card_company_thumb">
                                                    <img src="{{ asset($popular_product?->restaurant?->logo) }}"
                                                        alt="logo">
                                                </div>

                                                <a href="{{ route('single.restaurant', $popular_product?->restaurant->slug) }}"
                                                    class="food_card_company_name">
                                                    {{ $popular_product?->restaurant->restaurant_name }}
                                                </a>
                                            </div>

                                            <a onClick="loadProductModal({{ $popular_product->id }})" href="javascript:;"
                                                class="thm-btn_three">
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_1610_24994)">
                                                            <path
                                                                d="M5.33398 10.6667L11.1474 10.1822C12.9664 10.0307 13.3747 9.63333 13.5763 7.81927L14.0007 4"
                                                                stroke="#0C1321" stroke-width="1.5"
                                                                stroke-linecap="round" />
                                                            <path d="M4 4H4.33333M14.6667 4H13" stroke="#0C1321"
                                                                stroke-width="1.5" stroke-linecap="round" />
                                                            <path d="M6.33398 4.00008H11.0007M8.66732 6.33341V1.66675"
                                                                stroke="#0C1321" stroke-width="1.5"
                                                                stroke-linecap="round" />
                                                            <path
                                                                d="M3.99935 14.6667C4.73573 14.6667 5.33268 14.0697 5.33268 13.3333C5.33268 12.597 4.73573 12 3.99935 12C3.26297 12 2.66602 12.597 2.66602 13.3333C2.66602 14.0697 3.26297 14.6667 3.99935 14.6667Z"
                                                                stroke="#0C1321" stroke-width="1.5" />
                                                            <path
                                                                d="M11.3333 14.6667C12.0697 14.6667 12.6667 14.0697 12.6667 13.3333C12.6667 12.597 12.0697 12 11.3333 12C10.597 12 10 12.597 10 13.3333C10 14.0697 10.597 14.6667 11.3333 14.6667Z"
                                                                stroke="#0C1321" stroke-width="1.5" />
                                                            <path d="M5.33398 13.3333H10.0007" stroke="#0C1321"
                                                                stroke-width="1.5" stroke-linecap="round" />
                                                            <path
                                                                d="M1.33398 1.33325H1.97798C2.60777 1.33325 3.15674 1.74965 3.30949 2.34321L5.293 10.0509C5.39323 10.4405 5.30745 10.8531 5.05948 11.1743L4.42207 11.9999"
                                                                stroke="#0C1321" stroke-width="1.5"
                                                                stroke-linecap="round" />
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
            </section>
        @endif

        <!-- Popular part end -->


        <!-- cta part start -->

        <section class="cta" data-aos="fade-up" data-aos-delay="100">
            <div class="container cta_bg ">

                <div class="row">
                    <div class="col-xxl-6">
                        <div class="cta_txt">

                            <span class="icon">
                                <svg width="108" height="108" viewBox="0 0 108 108" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.16" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M38.9975 23.0679C41.7085 37.515 53.7743 53.9161 53.7743 53.9161C53.7743 53.9161 67.1605 35.7204 68.9017 20.7776C69.1487 19.575 69.279 18.3245 69.279 17.0409C69.279 7.62945 62.2749 0 53.6349 0C44.9949 0 37.9908 7.62945 37.9908 17.0409C37.9908 19.1628 38.3469 21.1941 38.9975 23.0679ZM53.7546 53.9397C52.0252 52.6924 36.6849 41.8382 23.0754 39.2813C21.1995 38.6291 19.1656 38.2721 17.0409 38.2721C7.62945 38.2721 0 45.2762 0 53.9162C0 62.5561 7.62945 69.5602 17.0409 69.5602C18.3203 69.5602 19.5667 69.4308 20.7656 69.1854C34.2438 67.6201 50.3736 56.5734 53.4099 54.4201C51.2604 57.4507 40.2153 73.5759 38.6446 87.0545C38.3976 88.2571 38.2673 89.5076 38.2673 90.7914C38.2673 100.203 45.2714 107.832 53.9113 107.832C62.5513 107.832 69.5554 100.203 69.5554 90.7914C69.5554 88.6694 69.1993 86.6381 68.5488 84.7643C66.116 71.8003 56.1507 57.263 54.1302 54.4148C57.1409 56.5508 73.2916 67.6204 86.7848 69.1873C87.9836 69.4327 89.23 69.5621 90.5094 69.5621C99.9208 69.5621 107.55 62.558 107.55 53.9181C107.55 45.2781 99.9208 38.274 90.5094 38.274C88.3847 38.274 86.3508 38.631 84.475 39.2832C70.8568 41.8416 55.5057 52.7079 53.7923 53.944C53.7788 53.9255 53.7719 53.9161 53.7719 53.9161C53.7719 53.9161 53.7661 53.9241 53.7546 53.9397Z"
                                        fill="url(#paint0_linear_585_38982)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_585_38982" x1="53.7751" y1="0"
                                            x2="53.7751" y2="107.832" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white">
                                                <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                            </span>


                            <h2>{!! strip_tags(clean($home_translate->join_restaurant_title), '<span>') !!}</h2>

                            <p>{{ $home_translate->join_restaurant_des }}</p>


                            <a href="{{ route('apply-for-restaurant') }}" class="thm-btn_two">
                                {{ __('translate.Apply') }}
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-6">
                        <div class="cta_thumb_main">

                            <span class="icon">
                                <svg width="137" height="137" viewBox="0 0 137 137" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.2"
                                        d="M66.0611 2.58709C66.3897 -0.526289 70.9214 -0.526272 71.2499 2.58711L74.7955 36.1887C75.0461 38.5639 78.092 39.3815 79.4984 37.4511L99.4076 10.1233C101.251 7.59266 105.174 9.86289 103.899 12.7223L90.1411 43.5613C89.1673 45.7442 91.3976 47.9784 93.5822 47.0085L124.487 33.2875C127.35 32.0167 129.613 35.9456 127.077 37.784L99.7359 57.6076C97.7993 59.0117 98.6158 62.0643 100.995 62.3142L134.604 65.8436C137.719 66.1707 137.719 70.7055 134.604 71.0327L100.995 74.5621C98.6158 74.8119 97.7993 77.8646 99.7359 79.2687L127.077 99.0923C129.613 100.931 127.35 104.86 124.487 103.589L93.5822 89.8678C91.3976 88.8979 89.1673 91.1321 90.1411 93.315L103.899 124.154C105.174 127.013 101.251 129.284 99.4076 126.753L79.4984 99.4252C78.092 97.4947 75.0461 98.3123 74.7955 100.688L71.2499 134.289C70.9214 137.403 66.3897 137.403 66.0611 134.289L62.5156 100.688C62.2649 98.3123 59.219 97.4947 57.8126 99.4252L37.9035 126.753C36.0598 129.284 32.1368 127.013 33.4124 124.154L47.1699 93.315C48.1437 91.1321 45.9135 88.8979 43.7289 89.8678L12.8238 103.589C9.96138 104.86 7.69835 100.931 10.2339 99.0923L37.5752 79.2687C39.5117 77.8646 38.6952 74.8119 36.3163 74.5621L2.70675 71.0327C-0.40836 70.7055 -0.408363 66.1707 2.70675 65.8436L36.3163 62.3142C38.6952 62.0643 39.5117 59.0117 37.5752 57.6076L10.2339 37.784C7.69836 35.9456 9.96138 32.0167 12.8238 33.2875L43.7289 47.0085C45.9135 47.9784 48.1437 45.7442 47.1699 43.5613L33.4124 12.7223C32.1368 9.8629 36.0598 7.59264 37.9035 10.1233L57.8126 37.451C59.219 39.3815 62.2649 38.5639 62.5156 36.1887L66.0611 2.58709Z"
                                        fill="url(#paint0_linear_585_38981)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_585_38981" x1="68.6555" y1="-22"
                                            x2="68.6555" y2="158.876" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.4" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>

                            <span class="icon_two">
                                <svg width="156" height="140" viewBox="0 0 156 140" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.39">
                                        <path
                                            d="M107.596 128.647C95.5828 135.108 81.8687 137.707 68.3239 136.089C54.7791 134.472 42.0629 128.716 31.9091 119.607C21.7553 110.497 14.6581 98.478 11.5852 85.1876C8.51227 71.8972 9.61318 57.9824 14.7378 45.3406L15.357 45.5916C10.284 58.106 9.19413 71.8806 12.2361 85.0371C15.2781 98.1936 22.3038 110.092 32.3553 119.109C42.4068 128.127 54.9949 133.825 68.4032 135.426C81.8115 137.028 95.3874 134.455 107.28 128.058L107.596 128.647Z"
                                            fill="white" />
                                        <path
                                            d="M44.7786 11.8549C56.7922 5.3933 70.5063 2.79419 84.0511 4.41197C97.5959 6.02975 110.312 11.7857 120.466 20.8949C130.62 30.0042 137.717 42.0234 140.79 55.3138C143.863 68.6043 142.762 82.519 137.637 95.1609L137.018 94.9099C142.091 82.3954 143.181 68.6209 140.139 55.4643C137.097 42.3078 130.071 30.4097 120.02 21.3922C109.968 12.3747 97.3801 6.6768 83.9718 5.07533C70.5635 3.47386 56.9876 6.04677 45.0951 12.4433L44.7786 11.8549Z"
                                            fill="white" />
                                        <path
                                            d="M44.2307 0.46582L44.4484 8.34838C44.5294 11.2846 46.8907 13.6459 49.8269 13.7269L57.7095 13.9446L49.8269 14.1622C46.8907 14.2433 44.5294 16.6045 44.4484 19.5408L44.2307 27.4233L44.0131 19.5408C43.932 16.6045 41.5708 14.2433 38.6345 14.1622L30.752 13.9446L38.6345 13.7269C41.5708 13.6459 43.932 11.2846 44.0131 8.34838L44.2307 0.46582Z"
                                            fill="white" />
                                        <path
                                            d="M150.696 89.4656L143.436 92.5436C140.732 93.6901 139.394 96.7499 140.39 99.5134L143.063 106.932L139.985 99.6722C138.838 96.9679 135.778 95.6307 133.015 96.6262L125.596 99.2989L132.856 96.2209C135.56 95.0744 136.898 92.0145 135.902 89.251L133.229 81.8322L136.307 89.0922C137.454 91.7966 140.514 93.1338 143.277 92.1382L150.696 89.4656Z"
                                            fill="white" />
                                        <path
                                            d="M109.344 139.692L108.989 131.815C108.857 128.88 106.455 126.56 103.518 126.53L95.6326 126.45L103.51 126.095C106.445 125.963 108.764 123.561 108.794 120.624L108.875 112.739L109.23 120.616C109.362 123.551 111.764 125.871 114.701 125.901L122.586 125.981L114.708 126.336C111.774 126.468 109.454 128.87 109.424 131.807L109.344 139.692Z"
                                            fill="white" />
                                        <path
                                            d="M28.291 43.5457L20.4818 44.6404C17.5729 45.0481 15.4895 47.6578 15.7361 50.5848L16.3982 58.4425L15.3035 50.6333C14.8957 47.7243 12.2861 45.6409 9.35912 45.8876L1.5014 46.5496L9.31061 45.455C12.2195 45.0472 14.3029 42.4376 14.0563 39.5106L13.3942 31.6528L14.4889 39.4621C14.8967 42.371 17.5063 44.4544 20.4333 44.2078L28.291 43.5457Z"
                                            fill="white" />
                                    </g>
                                </svg>

                            </span>


                            <div class="cta_thumb">
                                <img src="{{ asset($homepage->join_restaurant_image) }}" alt="thumb">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- cta part end -->


        <!-- blog part start -->
        @if (!empty($blogs))
            <section class="blog">
                <div class="container">
                    <div class="row mb_25px ">
                        <div class="col-xxl-12 text-center" data-aos="fade-down" data-aos-delay="50">
                            <h2 class="titel">{{ __('translate.Explore Our latest news') }} </h2>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse($blogs as $blog)
                            <div class="col-xxl-4 col-sm-6 col-lg-4" data-aos="fade-right" data-aos-delay="100">
                                <div class="blog_item">
                                    <div class="blog_item_thumb_main">
                                        <div class="blog_item_thumb">
                                            <img src="{{ asset($blog->image) }}" alt="thumb">

                                        </div>


                                        <div class="blog_item_thumb_over">
                                            <div class="blog_item_thumb_over_txt">
                                                <h6>{{ $blog->category->name }}</h6>
                                                <span class="dot"></span>
                                                <p>{{ $blog->created_at->format('F j, Y') }}</p>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="blog_item_inner">
                                        <h4>
                                            <a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
                                        </h4>


                                        <a href="{{ route('blog.details', $blog->slug) }}" class="blog_inner_btn">
                                            {{ __('translate.Read More') }}

                                            <span>
                                                <svg width="5" height="10" viewBox="0 0 5 10" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.443573 0.344988C0.174034 0.560619 0.130333 0.953927 0.345964 1.22347L3.36695 4.9997L0.345964 8.77593C0.130333 9.04547 0.174034 9.43878 0.443573 9.65441C0.713111 9.87004 1.10642 9.82634 1.32205 9.5568L4.65538 5.39013C4.83799 5.16187 4.83799 4.83753 4.65538 4.60926L1.32205 0.442596C1.10642 0.173058 0.713112 0.129357 0.443573 0.344988Z" />
                                                </svg>

                                            </span>
                                        </a>

                                    </div>


                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        <!-- blog part end -->


        <!-- mobile app  part start -->
        @include('frontend.layouts.partials.mobile_app')
        <!-- mobile app  part end -->

    </main>
@endsection
