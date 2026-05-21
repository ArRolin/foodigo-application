<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    @yield('meta')
    <link rel="shortcut icon" href="{{asset($general_setting->favicon)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css')}}">
    @if(!Route::is('view.checkout*') && !Route::is('user.address*'))
        <link rel="stylesheet" href="{{ asset('frontend/css/googlemap.css')}}">
    @endif
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/cookie_consent.css')}}">

    @if ($general_setting->google_analytic_status == 1)
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ $general_setting->google_analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ $general_setting->google_analytic_id }}');
        </script>
    @endif


    @if ($general_setting->pixel_status == 1)
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $general_setting->pixel_app_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id={{ $general_setting->pixel_app_id }}&ev=PageView&noscript=1"
            /></noscript>
    @endif


    @stack('style_section')
    
    @laravelPWA
</head>

<body>


<!-- preloder start -->

@if($general_setting->preloader_status == 'enable')
    <div id="preloader">
        <div id="container" class="container-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">

                @foreach (str_split($general_setting->app_name) as $single_char)
                    <span data-text="{{ strtoupper($single_char) }}" class="characters">{{ strtoupper($single_char) }}</span>
                @endforeach
                </div>
            </div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    </div>
@endif
<!-- preloder end -->



<!-- preloder two start -->

<div id="add_to_cart_loader" class="d-none">
    <div class="spinner"></div>
  </div>
<!-- preloder two end -->







@if(!Route::is('view.checkout*') && !Route::is('user.address*') && !Route::is('apply-for-restaurant') && !Route::is('view.payment'))
<!-- header_location_modal Modal -->
<div class="modal fade header_location_modal " id="staticBackdrop" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('translate.Set Location') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('save-address') }}"   id="map_form" method="POST">

                    @csrf

                    <input id="searchMapInput" class="mapControls form-control" type="text" required placeholder="{{ __('translate.Enter a location') }}" value="{{ session::get('address') ?? '' }}">

                    <div id="google_map_area">

                    </div>


                    <input type="hidden" class="form-control" name="address" id="plain_address" value="{{ old('address') }}">
                    <input class="form-control latitude" type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly>
                    <input class="form-control longitude" type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly>

                </form>

                <div class="location_modal-btn">
                    <button type="submit" onclick="handleSubmit(event)" class="thm-btn">{{ __('translate.Save') }}</button>
                </div>


            </div>
        </div>
    </div>
</div>
@endif

<!-- header part start  -->
@include('frontend.layouts.partials.header')

<!-- Main Content part start  -->
@yield('content')


<!-- footer part start  -->
@include('frontend.layouts.partials.footer')

<!-- Delete Confirmation Modal -->

<!-- log out modal  -->

<div class="modal fade logout_modal" id="exampleModal6" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <div class="logout_icon_main">
                        <span class="logout_icon">
                            <svg width="83" height="82" viewBox="0 0 83 82" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="41.5" cy="41" r="41" fill="#F98C3B" />
                                <path
                                    d="M42.6328 21.5786C43.4012 21.7273 44.1838 21.8244 44.936 22.0328C49.6633 23.3397 53.1156 27.4565 53.5297 32.327C53.8637 36.2456 52.535 39.5532 49.6389 42.2175C48.6329 43.1431 47.5559 43.9907 46.5256 44.891C46.3967 45.0032 46.2993 45.2227 46.2962 45.3937C46.2769 46.5923 46.2861 47.792 46.2861 49.0169C43.2388 49.0169 40.2158 49.0169 37.1503 49.0169C37.1503 48.8753 37.1503 48.7408 37.1503 48.6052C37.1503 46.1523 37.1553 43.6994 37.1432 41.2475C37.1421 40.9633 37.2345 40.7883 37.4467 40.6102C39.4251 38.9473 41.3923 37.2722 43.3677 35.6063C44.0661 35.0176 44.464 34.2893 44.4559 33.3678C44.4437 31.9052 43.2215 30.6984 41.7517 30.6843C40.2727 30.6711 39.0332 31.8384 38.9835 33.3021C38.9693 33.7036 38.9815 34.1062 38.9815 34.53C35.9342 34.53 32.9194 34.53 29.8548 34.53C29.8548 33.9545 29.8274 33.3658 29.8589 32.7791C30.1746 26.9508 34.71 22.2331 40.5518 21.6403C40.6381 21.6312 40.7213 21.5999 40.8056 21.5786C41.4146 21.5786 42.0237 21.5786 42.6328 21.5786Z"
                                    fill="white" />
                                <path
                                    d="M41.188 60.4203C40.3901 60.2493 39.6318 59.9975 38.968 59.4968C37.5073 58.3932 36.8485 56.5371 37.3012 54.7396C37.7438 52.9826 39.2156 51.6535 41.0215 51.3794C43.4719 51.0081 45.8411 52.6771 46.2096 55.034C46.6197 57.6497 45.0077 59.9186 42.4294 60.3555C42.3685 60.3656 42.3117 60.397 42.2538 60.4193C41.8985 60.4203 41.5432 60.4203 41.188 60.4203Z"
                                    fill="white" />
                            </svg>
                        </span>

                    <form action="{{route('user.logout')}}" class="delet_modal_form" method="POST">
                        @csrf
                        <div class="logout_txt">
                            <h4>{{__('translate.Are you sure Logout?')}}</h4>
                        </div>
                    </form>

                    <div class="logout_btn">
                        <button class="thm-btn user-logout" id="user-logout">{{__('translate.Yes! Logout')}}</button>
                        <button class="thm-btn_two user-logout-cancel" data-bs-dismiss="modal">{{__('translate.No! Cancel')}}</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



@if ($general_setting->cookie_consent_status == 1)
    <!-- common-modal start  -->
    <div class="common-modal cookie_consent_modal d-none bg-white">
        <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>

        <h5>{{ __('translate.Cookies') }}</h5>
        <p>{{ $general_setting->cookie_consent_message }}</p>


        <a href="javascript:;"
           class="thm-btn cookie_consent_accept_btn">
                                        <span class="td_btn_in td_accent_color">
                                        <span>{{ __('translate.Accept') }}</span>
                                        </span>
        </a>

    </div>
    <!-- common-modal end  -->
@endif



<!--food_card_modal-->
<div class="modal food_card_modal fade" id="productDetailModal" tabindex="-1"
        aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>


            <div class="modal-body" id="product_details_modal_body">

            </div>
        </div>
    </div>
</div>


<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/slick.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/aos.js')}}"></script>
<script src="{{asset('frontend/assets/js/main.js')}}"></script>

<script src="{{ asset('global/toastr/toastr.min.js') }}"></script>

<script>
    "use strict";
    $(document).ready(function() {

        const session_notify_message = @json(Session::get('message'));
        const demo_mode_message = @json(Session::get('demo_mode'));

        if(session_notify_message != null){
            const session_notify_type = @json(Session::get('alert-type', 'info'));
            switch (session_notify_type) {
                case 'info':
                    toastr.info(session_notify_message);
                    break;
                case 'success':
                    toastr.success(session_notify_message);
                    break;
                case 'warning':
                    toastr.warning(session_notify_message);
                    break;
                case 'error':
                    toastr.error(session_notify_message);
                    break;
            }
        }

        if(demo_mode_message != null){
            toastr.warning("{{ __('translate.All Language keywords are not implemented in the demo mode') }}");
            toastr.info("{{ __('translate.Admin can translate every word from the admin panel') }}");
        }

        const validation_errors = @json($errors->all());

        if (validation_errors.length > 0) {
            validation_errors.forEach(error => toastr.error(error));
        }

        $('#user-logout').on('click', function(e) {
            e.preventDefault();
            $('.delet_modal_form').submit();
        });

        $('.cookie_consent_close_btn').on('click', function () {
            $('.cookie_consent_modal').addClass('d-none');
        });


        if (localStorage.getItem('foodigo-cookie') != '1') {
                $('.cookie_consent_modal').removeClass('d-none');
            }

        $('.cookie_consent_accept_btn').on('click', function () {
            localStorage.setItem('foodigo-cookie', '1');
            $('.cookie_consent_modal').addClass('d-none');
        });

        $('.goto_select_location').on('click', function () {
            let home_url = "{{ route('home') }}";
            home_url = `${home_url}?choose_location=enable`;
            window.location = home_url
        });




    });

    function handleSubmit(event) {
        event.preventDefault();

        const address = document.getElementById('plain_address').value;
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (!address || !latitude || !longitude) {

            document.getElementById('searchMapInput').focus();

            toastr.error(`{{ __('translate.Please select an address first') }}`);

            return false;
        }

        document.getElementById('map_form').submit();
    }

    function loadProductModal(product_id){
        $("#add_to_cart_loader").removeClass('d-none');
        $.ajax({
            type : "get",
            url: "{{ url('get-single-product') }}" + "/" + product_id,
            success : function(response){
                $("#product_details_modal_body").html(response);
                $("#add_to_cart_loader").addClass('d-none');
                $("#productDetailModal").modal("show");
            },
            error : function(err){
                toastr.error(`{{ __('translate.Something Went Wrong') }}`);
            }
        })
    }

    function cartRemove(productId) {
        $.ajax({
            type: "get",
            url: "{{ url('cart/remove') }}/" + productId,
            success: function(response) {
                toastr.success(response.message);
                $("#sidebar_mini_cart_body").html(response.mini_cart);
                $("#cart_item_td_"+productId).remove();

                $("#cart_header_qty").html(response.cart_qty);
                $("#cart_qty_mobile_menu").html(response.cart_qty);
                if(response.cart_qty == 0){
                    $("#empty_cart").removeClass('d-none')
                    $("#cart_table").addClass('d-none')
                    $("#checkout_btn").addClass('d-none')
                }
            },
            error: function(err) {
                toastr.error(`{{ __('translate.Something Went Wrong') }}`);
            }
        });
    }

</script>

@if(!Route::is('view.checkout*') && !Route::is('user.address*') && !Route::is('apply-for-restaurant') && !Route::is('view.payment'))

<script>
    "use strict";

    document.addEventListener("DOMContentLoaded", function() {

        var map;
        var marker;
        var autocomplete;
        var default_lat = 0;
        var default_lang = 0;
        var googleMapsLoaded = false;


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

        loadGoogleMapsAPI(function () {
            initMap();
        });



        window.initMap = function () {

            var defaultLocation = { lat: default_lat, lng: default_lang };

            var initialLocation = {
                lat: parseFloat("{{ session('latitude') }}") || defaultLocation.lat,
                lng: parseFloat("{{ session('longitude') }}") || defaultLocation.lng
            };


            map = new google.maps.Map(document.getElementById('google_map_area'), {
                center: initialLocation,
                zoom: 13,
            });

            marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true
            });

            var input = document.getElementById('searchMapInput');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            autocomplete.setFields(['geometry', 'name', 'formatted_address']);

            // Listener for autocomplete
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    alert(`{{ __('translate.No details available for the input:') }} ${place.name}`)
                    return;
                }

                // Move the map to the selected place
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                }

                // Move marker to the new location
                marker.setPosition(place.geometry.location);

                // Update address input field
                updateAddressFields(place);
            });

            // Update latitude and longitude on marker drag event
            google.maps.event.addListener(marker, 'dragend', function() {
                var position = marker.getPosition();
                updateAddressFromLatLng(position);
            });

            // Update latitude and longitude on map click event
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                updateAddressFromLatLng(event.latLng);
            });
        }

        function updateAddressFields(place) {
            var formattedAddress = place.formatted_address || "Address not found";
            $("#plain_address").val(formattedAddress);
            $(".latitude").val(place.geometry.location.lat());
            $(".longitude").val(place.geometry.location.lng());
        }

        function updateAddressFromLatLng(latLng) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'location': latLng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var formattedAddress = results[0].formatted_address;
                        $("#plain_address").val(formattedAddress);
                        $(".latitude").val(latLng.lat());
                        $(".longitude").val(latLng.lng());
                    } else {
                        toastr.error(`{{ __('translate.No results found') }}`)
                    }
                } else {

                    toastr.error(`{{ __('translate.Geocoder failed due to') }} ${status}`)
                }
            });
        }

        function getQueryParam(param) {

        const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const chooseLocation = getQueryParam('choose_location');

        if (chooseLocation === 'enable') {
            $('#staticBackdrop').modal('show');
        }

        getLocation()

    });

</script>
<script>
fetch("http://127.0.0.1:8000//payment-api/pay-with-stripe?address_id=13&coupon_code=newyear25&discount_amount=0&delivery_charge=3.0&vat=6.4&order_type=delivery", {
    method: "GET",
    headers: {
        "Authorization": "Bearer 5|C5tUvqTby3bEuLgomCF1PIBTH2MGK6Dl6Xt1LpZXd8c80100",
        "Accept": "application/json",
        "Content-Type": "application/json"
    }
})
.then(res => res.json())
.then(data => console.log(data))
.catch(err => console.error(err));
</script>



@endif

@stack('js_section')

</body>

</html>
