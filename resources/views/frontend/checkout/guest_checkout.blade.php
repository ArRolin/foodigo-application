@extends('frontend.layouts.master')

@section('title')
    <title>{{ env('APP_NAME') }} - {{ __('translate.Checkout') }}</title>
@endsection

@section('content')
    <main class="search_V1_bg">
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }});">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{ __('translate.Checkout') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- Checkout part start -->
        <section class="checkout">
            <div class="container">
                <div class="row">

                    <div class="col-xxl-8 col-xl-8">
                        <form action="{{ route('continue.order') }}" class="pickup_item_from" method="post"
                            id="order-form">
                            @csrf

                            {{-- when user as a guest --}}
                            <div class="f-guest-warn">
                                {{-- icon --}}
                                <div class="icon">
                                    <span>
                                        <svg width="38" height="35" viewBox="0 0 38 35" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M36.8717 26.7364L23.8156 2.73582C21.7179 -0.795662 16.6043 -0.800354 14.5038 2.73582L1.44826 26.7364C-0.696142 30.345 1.90008 34.9146 6.10305 34.9146H32.2159C36.4153 34.9146 39.0161 30.3487 36.8717 26.7364ZM19.1597 30.5834C17.9658 30.5834 16.9941 29.6116 16.9941 28.4177C16.9941 27.2239 17.9658 26.2521 19.1597 26.2521C20.3535 26.2521 21.3253 27.2239 21.3253 28.4177C21.3253 29.6116 20.3535 30.5834 19.1597 30.5834ZM21.3253 21.9209C21.3253 23.1147 20.3535 24.0865 19.1597 24.0865C17.9658 24.0865 16.9941 23.1147 16.9941 21.9209V11.0928C16.9941 9.89892 17.9658 8.92713 19.1597 8.92713C20.3535 8.92713 21.3253 9.89892 21.3253 11.0928V21.9209Z"
                                                fill="#FF6648" />
                                        </svg>

                                    </span>
                                </div>
                                {{-- message --}}

                                @if (!Auth::check())
                                <div class="warn-message-text-wrapper">
                                    <p class="warn-message-heading">{{ __('translate.You are ordering as a guest') }}</p>
                                    <p class="warn-message-para">{{ __('translate.You can continue without signing in, or') }} <a class="anchor"
                                        href="{{ route('user.register') }}">{{ __('translate.Create an account') }}</a> / <a href="{{ route('user.login', ['from_checkout' => 'yes']) }}" class="anchor">{{ __('translate.Log in') }}</a> {{ __('translate.to save your order history.') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="delivery">
                                <div class="delivery_top_txt">
                                    <h4>{{ __('translate. Delivery Option') }}</h4>
                                </div>

                                <!-- Hidden input to store the selected type -->
                                <input type="hidden" name="order_type" id="order-type" value="delivery">
                                <input type="hidden" class="delivery_charged" name="delivery_charge" value="0">
                                <!-- Hidden fields to capture latitude and longitude -->
                                <input type="hidden" name="latitude" id="latitude" value="{{ Session::get('latitude') ?? '' }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ Session::get('longitude') ?? '' }}">
                                <input type="hidden" name="address_id" id="addresss" value="{{ Session::get('address') ?? '' }}">

                                <div class="pickup_item_df">

                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                data-type="delivery" aria-controls="pills-home" aria-selected="true">


                                                <span>
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="0.75" y="0.75" width="18.5" height="18.5" rx="9.25"
                                                            stroke="black" stroke-width="1.5" />
                                                    </svg>
                                                </span>

                                                <span class="hidden_svg">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="20" height="20" rx="10" fill="#0C1321" />
                                                        <path d="M6 10.5L8.5 13L13.5 8" stroke="#F9C200" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>

                                                </span>


                                                {{ __('translate.Delivery') }}
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-profile" type="button" role="tab"
                                                aria-controls="pills-profile" aria-selected="false" data-type="pickup">

                                                <span>
                                                    <svg width="20" height="20" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="0.75" y="0.75" width="18.5" height="18.5"
                                                            rx="9.25" stroke="black" stroke-width="1.5" />
                                                    </svg>
                                                </span>

                                                <span class="hidden_svg">
                                                    <svg width="20" height="20" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="20" height="20" rx="10"
                                                            fill="#0C1321" />
                                                        <path d="M6 10.5L8.5 13L13.5 8" stroke="#F9C200"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>

                                                </span>
                                                {{ __('translate.Pickup') }}
                                            </a>
                                        </li>
                                    </ul>


                                    @if (Auth::check())
                                        <button type="button" class="thm-btn_two" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal7">
                                            <span>
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 6V18M18 12L6 12" stroke="#28303F" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            {{ __('translate.Add Address') }}
                                        </button>
                                    @endif


                                </div>



                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">

                                        @if (!Auth::check())
                                            <div class="pickup_item">

                                                <div class="pickup_item_box">
                                                    <div class="pickup_item_from_txt">
                                                        <h4>{{ __('translate.Contact Information') }}</h4>
                                                    </div>

                                                    <div class="pickup_item_from">
                                                        <div class="pickup_item_from_item">
                                                            <div class="pickup_item_from_inner">
                                                                <label for="exampleFormControlInput1" class="form-label">
                                                                    {{ __('translate.Name') }}</label>
                                                                <input type="email" class="form-control" id=""
                                                                    placeholder="{{ __('translate.Name') }}" name="name">
                                                            </div>
                                                        </div>

                                                        <div class="pickup_item_from_item">
                                                            <div class="pickup_item_from_inner">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label">{{ __('translate.Email') }}</label>
                                                                <input type="email" class="form-control" id=""
                                                                    placeholder="{{ __('translate.Email Address') }}"
                                                                    name="email">
                                                            </div>
                                                            <div class="pickup_item_from_inner">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label">{{ __('translate.Phone') }}</label>
                                                                <input type="text" class="form-control" id=""
                                                                    placeholder="{{ __('translate.Phone Number') }}"
                                                                    name="phone">
                                                            </div>
                                                        </div>

                                                        <div class="pickup_item_from_item">
                                                            <div class="pickup_item_from_inner">

                                                                <input id="searchMapInput" type="text"
                                                                    placeholder="{{ __('translate.Enter a location') }}" value="{{ Session::get('address') ?? '' }}">

                                                                <div id="google_map_area">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="pickup_item_from_item">
                                                            <div class="pickup_item_from_inner">
                                                                <label for="exampleFormControlInput1" class="form-label">
                                                                    {{ __('translate.Address') }}</label>
                                                                <input type="text" class="form-control plain_address"
                                                                    placeholder="{{ __('translate.Address') }}" name="address"
                                                                    id="new_plain_address" value="{{ Session::get('address') ?? '' }}">
                                                            </div>
                                                        </div>

                                                        <div class="pickup_item_from_item">
                                                            <div class="pickup_item_from_inner">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label">{{ __('translate.Delivery Type') }}</label>
                                                                <select class="form-select"
                                                                    aria-label="Default select example"
                                                                    name="delivery_type">
                                                                    <option value="home">{{ __('translate.Home') }}</option>
                                                                    <option value="office">{{ __('translate.Office') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    @foreach ($carts as $item)
                                        @php
                                            $product = Modules\Product\App\Models\Product::where('status', 'enable')
                                                ->whereIn('id', [$item['product_id']])
                                                ->first();
                                            $total = 0;
                                        @endphp
                                    @endforeach
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">

                                        <div class="delivery-map" id="restaurant_pickup_address">
                                            {{-- map will be loaded here --}}
                                        </div>
                                        <div class="delivery-address d-flex justify-content-between mt-4">
                                            <p class="mt-1"><strong>{{ __('translate.Address') }} :
                                                </strong>{{ $product?->restaurant?->address }}</p>

                                            <a href="tel:{{ $product?->restaurant?->address }}" class="thm-btn_two">
                                                <span>
                                                    <svg width="25" height="24" viewBox="0 0 25 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21.5 19V17.3541C21.5 16.5363 21.0021 15.8008 20.2428 15.4971L18.2086 14.6835C17.2429 14.2971 16.1422 14.7156 15.677 15.646L15.5 16C15.5 16 13 15.5 11 13.5C9 11.5 8.5 9 8.5 9L8.85402 8.82299C9.78438 8.35781 10.2029 7.25714 9.81654 6.29136L9.00289 4.25722C8.69916 3.4979 7.96374 3 7.14593 3H5.5C4.39543 3 3.5 3.89543 3.5 5C3.5 13.8366 10.6634 21 19.5 21C20.6046 21 21.5 20.1046 21.5 19Z"
                                                            stroke-width="1.5" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                                {{ __('translate.Call Restaurant') }}
                                            </a>

                                        </div>

                                        <div class="delivery_time_box">
                                            <h4>{{ __('translate.Contact Informations') }}</h4>

                                            <div class="delivery_time_box_form">
                                                <div class="delivery_time_box_form_item">
                                                    <div class="delivery_time_box_form_inner">
                                                        <label for=""
                                                            class="form-label">{{ __('translate.Contact person name') }}</label>
                                                        <input type="text" class="form-control delivery-info delivery-info2"
                                                            id="" name="contact_name"
                                                            placeholder="{{ __('translate.Name') }}">
                                                    </div>
                                                    <div class="delivery_time_box_form_inner">
                                                        <label for=""
                                                            class="form-label">{{ __('translate.Contact person phone') }}</label>
                                                        <input type="text" class="form-control delivery-info delivery-info2"
                                                            id="" name="contact_phone"
                                                            placeholder="{{ __('translate.Phone') }}">
                                                    </div>

                                                    <div class="delivery_time_box_form_inner">
                                                        <label for=""
                                                            class="form-label">{{ __('translate.Contact person email') }}</label>
                                                        <input type="email" class="form-control delivery-info delivery-info2"
                                                            id="" name="contact_email"
                                                            placeholder="{{ __('translate.Email') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="additional_notes">
                                    <div class="additional_notes_txt">
                                        <h4>{{ __('translate.Additional Notes') }}</h4>
                                    </div>


                                    <div class="additional_notes_form">
                                        <textarea class="form-control" id="" rows="3" placeholder="{{ __('translate.Additional Notes') }}"
                                            name="additional_note"></textarea>

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-4 col-xl-4">
                        <div class="order_summery_box">
                            <div class="order_summery_txt">
                                <h4>{{ __('translate.Order Summary') }}</h4>
                            </div>

                            <div class="cart-summary-box-item-top">
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($carts as $item)
                                    @php
                                        $product = Modules\Product\App\Models\Product::where('status', 'enable')
                                            ->whereIn('id', [$item['product_id']])
                                            ->first();
                                        $total = 0;
                                        $calculate = 0;
                                        $total = $product['price'] * $item['qty'];
                                    @endphp
                                    <div class="cart-summary-box-item">
                                        <a href="javascript:;">
                                            <div class="cart-summary-box-inner">
                                                <div class="cart-summary-box-img td_thumb">
                                                    <img class="checkout_item_img" src="{{ asset($product['image']) }}"
                                                        alt="img">
                                                </div>
                                                <div class="cart-summary-box-text-two">
                                                    <h5>{{ $product['name'] }}</h5>

                                                    <ul>
                                                        @if ($item['size'])
                                                            <li><span>{{ __('translate.Size') }}:</span>

                                                                @foreach ($item['size'] as $size => $price)
                                                                    {{ $size }}
                                                                    (<strong>{{ currency($price) }}</strong>)
                                                                    @php $total = $total + ($price * $item['qty']) @endphp
                                                                @endforeach

                                                            </li>
                                                        @endif
                                                        @if ($item['addons'] && is_array($item['addons']))
                                                            @foreach ($item['addons'] as $addonId => $quantity)
                                                                <li>
                                                                    @php
                                                                        $addonsDb = Modules\Addon\App\Models\Addon::whereIn(
                                                                            'id',
                                                                            [$addonId],
                                                                        )->get();
                                                                        $calculate +=
                                                                            $addonsDb->first()->price * $quantity;
                                                                    @endphp
                                                                    @if ($addonsDb->isNotEmpty())
                                                                        {{ $addonsDb->first()->name }}
                                                                        ({{ currency($addonsDb->first()->price) }})
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    @php $subtotal += $item['total']; @endphp
                                @endforeach
                            </div>

                            <ul class="order_summery_list">
                                <li>{{ __('translate.Subtotal') }} <span>{{ currency($subtotal) }}</span></li>
                                <li>
                                    <input type="hidden" id="subtotal" value="{{ $subtotal }}"> </li>
                                <li> {{ __('translate.Delivery Charge') }} <span
                                        class="delivery_charges">{{ currency(0.0) }}</span> </li>
                                <li>
                                    <input type="hidden" id="delivery_charge" value="0">
                                </li>
                                <li>{{ __('translate.Coupon Discount') }}
                                    <span id="discountAmount">
                                        @if (session('applied_coupon'))
                                            {{ currency(session('applied_coupon.discount_amount')) }}
                                        @else
                                            {{ Currency(0.0) }}
                                        @endif

                                    </span>
                                </li>
                                <!-- Promo Code Input Field -->
                                @if (!Session::has('applied_coupon'))
                                    <div class="promo_code">
                                        <div class="promo_code_item">
                                            <label for="couponInput"
                                                class="form-label">{{ __('translate.Promo Code') }}</label>
                                            <div class="promo_code_inner">
                                                <input type="text" class="form-control" id="couponInput"
                                                    placeholder="{{ __('translate.Enter code') }}">
                                                <input type="hidden" id="subtotal" value="{{ $subtotal }}">
                                                <div class="promo_code_btn">
                                                    <button type="button" id="applyCouponBtn"
                                                        class="thm-btn">{{ __('translate.Apply') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <li id="total_amount_item" class="{{ Session::has('applied_coupon') ? 'total_amount_border' : '' }}">{{ __('translate.Total Amount') }}
                                    <span id="newTotalAmount">
                                        @if (session('applied_coupon'))
                                            {{ currency(session('applied_coupon.new_total')) }}
                                        @else
                                            {{ currency($subtotal) }}
                                        @endif
                                    </span>
                                </li>

                            </ul>

                            <div class="order_summery_check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('translate. I agree to the company') }} <span>{{ __('translate.Term of Service') }}</span>
                                        {{ __('translate.and') }} <span>{{ __('translate.Privacy') }}
                                            {{ __('translate.Policy') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="order_summery_btn">
                                <button type="button" class="thm-btn"
                                    id="continue-btn">{{ __('translate.Payment Now') }}</button>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </section>
        <!-- Checkout part end -->

    </main>
@endsection

@push('style_section')
    <style>

        .total_amount_border{
            border-top : 1px solid #e5e6eb;
        }
        #google_map_area,
        #restaurant_pickup_address {
            height: 350px;
            width: 100%;
        }

        .pac-container {
            z-index: 100000 !important;
        }

        .tox .tox-promotion,
        .tox-statusbar__branding {
            display: none !important;
        }

        #map {
            width: 100%;
            height: 400px;
        }

        .mapControls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pickupSearchMapInput,
        #searchMapInput {
            margin-top: 8px !important;
        }

        #searchMapInput,
        #pickupSearchMapInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }

        #searchMapInput:focus,
        #pickupSearchMapInput:focus {
            border-color: var(--color-yellow);
        }

        .dashboard_address_item {
            cursor: pointer;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
        }

        .dashboard_address_item.selected {
            border-color: #28a745;
        }

        .delivery-info2{
            background-color: #fff !important;
        }
    </style>
@endpush

@push('js_section')

    <script>
        "use strict"

        var default_lat = 0;
        var default_lang = 0;
        var googleMapsLoaded = false;

        let restaurantLat = {{ $product->restaurant->latitude }};
        let restaurantLng = {{ $product->restaurant->longitude }};


        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("{{ __('translate.Geolocation is not supported by this browser.') }}");
            }
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("{{ __('translate.Please enable to Geolocation in yor browser ') }}");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("{{ __('translate.Location information is unavailable.') }}");
                    break;
                case error.TIMEOUT:
                    alert("{{ __('translate.The request to get user location timed out.') }}");
                    break;
                default:
                    alert("{{ __('translate.An unknown error occurred.') }}");
                    break;
            }
        }

        function showPosition(position) {
            default_lat = position.coords.latitude;
            default_lang = position.coords.longitude;

            if (googleMapsLoaded) {
                initMap();
            }
        }


        function loadGoogleMapsAPI(callback) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API') }}&libraries=places`;
            script.async = true;
            script.defer = true;
            script.onload = function () {
                googleMapsLoaded = true;
                callback();
            };
            document.head.appendChild(script);
        }

        window.initMap = function(){

            var defaultLocation = { lat: default_lat, lng: default_lang };


            var initialLocation = {
                lat: parseFloat("{{ session('latitude') }}") || defaultLocation.lat,
                lng: parseFloat("{{ session('longitude') }}") || defaultLocation.lng
            };

            var map = new google.maps.Map(document.getElementById('google_map_area'), {
                center: initialLocation,
                zoom: 13
            });

            var marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true
            });

            var input = document.getElementById('searchMapInput');

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();

            autocomplete.addListener('place_changed', function() {

                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();

                /* If the place has a geometry, then present it on a map. */
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);

                $("#new_plain_address").val(place.formatted_address);

                $("#latitude").val(place.geometry.location.lat());
                $("#longitude").val(place.geometry.location.lng());

                calculateDeliveryCharge(place.geometry.location.lat(), place.geometry.location.lng());
            });

            // Listener for map clicks
            map.addListener('click', function(event) {
                var clickedLocation = event.latLng;

                marker.setPosition(clickedLocation);
                marker.setVisible(true);

                $("#latitude").val(clickedLocation.lat());
                $("#longitude").val(clickedLocation.lng());

                calculateDeliveryCharge(clickedLocation.lat(), clickedLocation.lng());
                reverseGeocode(clickedLocation);
            });

            marker.addListener('dragend', function(event) {
                var clickedLocation = event.latLng;

                $("#latitude").val(clickedLocation.lat());
                $("#longitude").val(clickedLocation.lng());
                calculateDeliveryCharge(clickedLocation.lat(), clickedLocation.lng());
                reverseGeocode(clickedLocation);


            });



        }

        window.initPickupMap = function(){
            const pickupMap = new google.maps.Map(document.getElementById("restaurant_pickup_address"), {
                center: {
                    lat: restaurantLat,
                    lng: restaurantLng
                },
                zoom: 13,
            });

            const marker = new google.maps.Marker({
                position: {
                    lat: restaurantLat,
                    lng: restaurantLng
                },
                map: pickupMap,
            });
        }

        function reverseGeocode(location) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                location: location
            }, function(results, status) {
                if (status === "OK" && results[0]) {
                    $("#new_plain_address").val(results[0].formatted_address);
                }
            });
        }



        loadGoogleMapsAPI(function () {
            initMap();
            initPickupMap();
        });


        getLocation()

    </script>


    <script>
        "use strict";

        $(document).ready(function() {

            $('#applyCouponBtn').on('click', function() {
                let couponCode = $('#couponInput').val();
                let subtotal = $('#subtotal').val();
                let deliveryCharge = $('#delivery_charge').val();

                $.ajax({
                    url: "{{ route('apply.coupon') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        coupon: couponCode,
                        subtotal: subtotal,
                        delivery: deliveryCharge
                    },
                    success: function(response) {
                        if (response.success) {
                            let totalAmountText = $('#newTotalAmount').text();
                            const symbol = totalAmountText ? totalAmountText.replace(/[0-9.,]/g,
                                '').trim() : '';
                            $('#discountAmount').text(formatCurrency(response.discount, {
                                currencyIcon: symbol
                            }));
                            let newTotal = parseFloat(response.new_total) || 0;
                            let totalAmounts = parseFloat(newTotal) + parseFloat(deliveryCharge)

                            $('#newTotalAmount').text(formatCurrency(totalAmounts, {
                                currencyIcon: symbol
                            }));

                            $('.promo_code').hide();
                            $("#total_amount_item").addClass('total_amount_border')
                            toastr.success('Coupon applied successfully!');

                            recalculateTotalAmount();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error(
                                `{{ __('translate.An unexpected error occurred. Please try again') }}`
                            );
                        }
                    }
                });
            });

            $('.remove-coupon').on('click', function() {
                $.ajax({
                    url: "{{ route('remove.coupon') }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location = "{{ route('view.checkout') }}"
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                });
            });

            $('#continue-btn').on('click', function() {
                if (!$('#flexCheckDefault').is(':checked')) {
                    toastr.warning(
                        'Please agree to the Terms of Service and Privacy Policy before proceeding.');
                } else {
                    $('#order-form').submit();
                }
            });


            $('#pills-tab a').on('click', function () {
                var selectedType = $(this).data('type');
                $('#order-type').val(selectedType);
            });




        });
    </script>


    <script>
        "use strict";

        // Helper function to format currency
        function formatCurrency(amount, options = {}) {
            const {
                currencyIcon = "{{ session::get('currency_icon') }}",
                    currencyCode = "{{ session::get('currency_code') }}",
                    currencyRate = "{{ session::get('currency_rate') }}",
                    currencyPosition = "{{ session::get('currency_position') }}",
            } = options;

            amount = amount * currencyRate;
            amount = amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            switch (currencyPosition) {
                case 'before_price':
                    return currencyIcon + amount;
                case 'before_price_with_space':
                    return currencyIcon + ' ' + amount;
                case 'after_price':
                    return amount + currencyIcon;
                case 'after_price_with_space':
                    return amount + ' ' + currencyIcon;
                default:
                    return currencyIcon + amount;
            }
        }

        // Function to calculate distance using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the Earth in kilometers
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Distance in km
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        // Unified function to calculate the delivery charge based on location
        function calculateDeliveryCharge(userLat, userLon) {
            const restaurantLat = "{{ $product->restaurant->latitude }}";
            const restaurantLon = "{{ $product->restaurant->longitude }}";

            // Calculate the distance
            const distance = calculateDistance(userLat, userLon, restaurantLat, restaurantLon);

            const chargePerKm = "{{ $general_setting->delivery_charge }}";

            let deliveryCharge = 0;

            // Calculate the delivery charge
            if (userLat === undefined || userLat === null || userLat === '' || userLon === undefined || userLon === null ||
                userLon === '') {
                deliveryCharge = 0;
            } else {
                deliveryCharge = distance * chargePerKm;
            }

            // Update the delivery charge input and display
            $('#delivery_charge').val(deliveryCharge.toFixed(2));
            $('.delivery_charges').text(formatCurrency(deliveryCharge));


            // Recalculate total amount
            recalculateTotalAmount();
        }

        // Function to recalculate total amount
        function recalculateTotalAmount() {
            let subtotal = parseFloat($('#subtotal').val()) || 0;
            let discount = parseFloat($('#discountAmount').text().replace(/[^\d.-]/g, '')) || 0;
            let deliveryCharge = parseFloat($('#delivery_charge').val()) || 0;

            let newTotalAmount = subtotal - discount + deliveryCharge;
            $('#newTotalAmount').text(formatCurrency(newTotalAmount));
            $('.delivery_charged').val(deliveryCharge);
        }

        function getInitialDeliveryCharge(){
            calculateDeliveryCharge($("#latitude").val(), $("#longitude").val());

        }

        getInitialDeliveryCharge()


    </script>
@endpush
