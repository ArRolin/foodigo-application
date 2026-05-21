@extends('frontend.layouts.master')

@section('title')
    <title>{{ __('translate.Apply for restaurant') }}</title>
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
                            <li><a href="{{ route('home') }}">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Apply for restaurant')}}</a></li>
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
                            <div class="create_new_btn_inline_box">
                                <h4 class="crancy-product-card__title mb-3">{{ __('translate.Basic Information') }}</h4>
                            </div>
                        </div>


                        <form class="edit_profile_form" action="{{route('store-restaurant')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="dashbord_edit_profile dashbord_edit_profile_two">
                                    <div class="edit_profile_form_item">

                                        <div class="edit_profile_form_inner">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label mb-2">{{ __('translate.Logo Image') }} * </label>
                                                <div class="crancy-product-card__upload crancy-product-card__upload--border bg-white w-100 h-100">
                                                    <input type="file" class="btn-check" name="logo" id="input-img1" autocomplete="off" onchange="previewImage(event)">
                                                    <label class="crancy-image-video-upload__label" for="input-img1">
                                                        <img id="view_img" class="restaurant-image" src="{{ asset($general_setting->placeholder_image) }}">
                                                        <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="edit_profile_form_inner">
                                            <div class="crancy__item-form--group">
                                                <label class="crancy__item-label mb-2">{{ __('translate.Cover Image') }} * </label>
                                                <div class="crancy-product-card__upload crancy-product-card__upload--border bg-white w-100 h-100">
                                                    <input type="file" class="btn-check" name="cover_image" id="input-img2" autocomplete="off" onchange="previewCoverImage(event)">
                                                    <label class="crancy-image-video-upload__label" for="input-img2">
                                                        <img class="restaurant-cover-image" id="view_cover_img" src="{{ asset($general_setting->placeholder_image) }}">
                                                        <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="edit_profile_form_item">
                                        <div class="edit_profile_form_inner">
                                            <label for="title" class="form-label">{{__('translate.Restaurant Name')}}</label>
                                            <input type="text" class="form-control" id="title"
                                                name="restaurant_name" value="{{ old('restaurant_name') }}">
                                        </div>
                                        <div class="edit_profile_form_inner">
                                            <label for="slug" class="form-label">{{__('translate.Slug')}}</label>
                                            <input type="text" class="form-control" id="slug" value="{{ old('slug') }}"
                                                name="slug">
                                        </div>
                                    </div>

                                    <div class="edit_profile_form_item">
                                        <div class="edit_profile_form_inner">
                                            <label class="crancy__item-label mb-2">{{ __('translate.City') }} * </label>
                                            <select class="form-select crancy__item-input select2" name="city_id">
                                                <option value="">{{ __('translate.Select City') }}</option>
                                                @foreach ($cities as $city)
                                                    <option {{ $city->id == old('city_id') ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->translate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="edit_profile_form_inner">
                                            <label class="crancy__item-label mb-2">{{ __('translate.Cuisine') }} * </label>
                                            <select class="form-select crancy__item-input select2" name="cuisines[]" multiple>
                                                <option value="">{{ __('translate.Select Cuisine') }}</option>
                                                @foreach ($cuisines as $cuisine)
                                                    <option {{ $cuisine->id == old('cuisine') ? 'selected' : '' }} value="{{ $cuisine->id }}">{{ $cuisine->translate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="contact_us_txt mt-2 ">
                                    <div class="create_new_btn_inline_box">
                                        <h4 class="crancy-product-card__title mb-3 mt-5">{{ __('translate.Contact, Address & Delivery Area') }}</h4>
                                    </div>
                                </div>


                                <div class="dashbord_edit_profile dashbord_edit_profile_two">
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="edit_profile_form_inner">
                                                <label for="whatsapp" class="form-label  mb-2">{{__('translate.WhatsApp Phone *')}}</label>
                                                <input type="text" class="form-control" id="whatsapp"
                                                    name="whatsapp" value="{{ old('whatsapp') }}">
                                            </div>
                                            <div class="edit_profile_form_inner">
                                                <label for="plain_address" class="form-label  mb-2 mt-2">{{__('translate.Address *')}}</label>
                                                <input type="text" class="form-control" id="plain_address"
                                                    name="address" value="{{ old('address') }}">
                                            </div>

                                            <div class="edit_profile_form_inner d-none">
                                                <label for="latitude" class="form-label  mb-2 mt-2">{{__('translate.Latitude *')}}</label>
                                                <input type="text" class="form-control" id="latitude"
                                                    name="latitude" readonly>
                                            </div>

                                            <div class="edit_profile_form_inner d-none">
                                                <label for="longitude" class="form-label  mb-2 mt-2">{{__('translate.Longitude *')}}</label>
                                                <input type="text" class="form-control" id="longitude"
                                                    name="longitude" readonly>
                                            </div>

                                            <div class="edit_profile_form_inner">
                                                <label for="distance" class="form-label  mb-2 mt-2">{{__('translate.Maximum Delivery Distance (km) *')}}</label>
                                                <input type="text" class="form-control" id="distance"
                                                    name="max_delivery_distance" value="{{ old('max_delivery_distance') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="b-b" >
                                            <label class="crancy__item-label mb-2">{{ __('translate.Your Location') }} * </label>

                                            <input id="searchMapInput" class="mapControls" type="text" placeholder="{{ __('translate.Enter a location') }}">

                                            <div id="google_map_area">

                                            </div>
                                          </div>
                                        </div>
                                   </div>
                                </div>

                                <div class="contact_us_txt mt-2">
                                    <div class="create_new_btn_inline_box">
                                        <h4 class="crancy-product-card__title mb-3 mt-5">{{ __('translate.Restaurant Owner Information') }}</h4>
                                    </div>
                                </div>


                                <div class="dashbord_edit_profile dashbord_edit_profile_two">
                                   <div class="row">
                                        <div class="col-12">

                                            <div class="e-p-df" >
                                                <div class="edit_profile_form_inner">
                                                    <label for="ownerName" class="form-label  mb-2">{{__('translate.Name *')}}</label>
                                                    <input type="text" class="form-control" id="ownerName"
                                                        name="owner_name" value="{{ old('owner_name') }}">
                                                </div>
                                                <div class="edit_profile_form_inner">
                                                    <label for="ownerEmail" class="form-label  mb-2 mt-2">{{__('translate.Email *')}}</label>
                                                    <input type="email" class="form-control" id="ownerEmail"
                                                        name="owner_email" value="{{ old('owner_email') }}">
                                                </div>

                                                <div class="edit_profile_form_inner">
                                                    <label for="ownerPhone" class="form-label  mb-2 mt-2">{{__('translate.Phone *')}}</label>
                                                    <input type="text" class="form-control" id="ownerPhone"
                                                        name="owner_phone" value="{{ old('owner_phone') }}">
                                                </div>
                                            </div>


                                        </div>
                                   </div>
                                </div>

                                <div class="contact_us_txt mt-2">
                                    <div class="create_new_btn_inline_box">
                                        <h4 class="crancy-product-card__title mb-3 mt-5">{{ __('translate.Account Information') }}</h4>
                                    </div>
                                </div>


                                <div class="dashbord_edit_profile dashbord_edit_profile_two">
                                   <div class="row">
                                        <div class="col-12">

                                            <div class="e-p-df">
                                                <div class="edit_profile_form_inner">
                                                    <label for="name" class="form-label  mb-2">{{__('translate.Name *')}}</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" value="{{ old('name') }}">
                                                </div>
                                                <div class="edit_profile_form_inner">
                                                    <label for="email" class="form-label  mb-2 mt-2">{{__('translate.Email *')}}</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" value="{{ old('email') }}">
                                                </div>

                                                <div class="edit_profile_form_inner">
                                                    <label for="password" class="form-label  mb-2 mt-2">{{__('translate.password *')}}</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" >
                                                </div>
                                            </div>


                                        </div>
                                   </div>
                                </div>

                                <div class="contact_us_txt mt-2">
                                    <div class="create_new_btn_inline_box ">
                                        <h4 class="crancy-product-card__title mb-3 mt-5">{{ __('translate.Others Information') }}</h4>
                                    </div>
                                </div>


                                <div class="dashbord_edit_profile dashbord_edit_profile_two">
                                   <div class="row">
                                        <div class="col-md-6">

                                            <div class="edit_profile_form_inner">
                                                <label for="openHour" class="form-label">{{__('translate.Opening Hour *')}}</label>
                                                <input type="text" class="form-control clockpicker" id="openHour"
                                                    name="opening_hour" data-align="top" data-autoclose="true" autocomplete="off" value="{{ old('opening_hour') }}">
                                            </div>


                                            <div class="edit_profile_form_inner">
                                                <label for="minTime" class="form-label  mb-2 mt-2">{{__('translate.Minimum food processing time(minute) *')}}</label>
                                                <input type="text" class="form-control" id="minTime"
                                                    name="min_processing_time" value="{{ old('min_processing_time') }}">
                                            </div>

                                            <div class="edit_profile_form_inner">
                                                <label for="timeSlot" class="form-label  mb-2 mt-2">{{__('translate.Time slot separated(minute) *')}}</label>
                                                <input type="text" class="form-control" id="timeSlot"
                                                    name="time_slot_separate" value="{{ old('time_slot_separate') }}">
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="edit_profile_form_inner">
                                                <label for="closeHour" class="form-label  mb-2 mt-2">{{__('translate.Closing Hour *')}}</label>
                                                <input type="text" class="form-control clockpicker" id="closeHour"
                                                    name="closing_hour" value="{{ old('closing_hour') }}"  data-align="top" data-autoclose="true" autocomplete="off">
                                            </div>

                                            <div class="edit_profile_form_inner">
                                                <label for="maxTime" class="form-label  mb-2 mt-2">{{__('translate.Maximum food processing time(minute) *')}}</label>
                                                <input type="text" class="form-control" id="maxTime"
                                                    name="max_processing_time" value="{{ old('max_processing_time') }}">
                                            </div>

                                            <div class="edit_profile_form_inner">
                                                <label for="tags" class="form-label  mb-2 mt-2">{{__('translate.Tags')}}</label>
                                                <input type="text" class="form-control tags" id="tags"
                                                    name="tags" value="{{ old('tags') }}">
                                            </div>
                                        </div>

                                        <div class=" col-12 col-lg-2 col-md-6 mt-4">

                                            <div class="crancy__item-form--group two mg-top-form-20">
                                                <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                    <label class="crancy__item-switch">
                                                    <input {{ old('is_pickup_order') ? 'checked' : '' }} name="is_pickup_order" type="checkbox" >
                                                    <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                    </label>
                                                </div>
                                                <label class="crancy__item-label">{{__('translate.Pickup Order')}} </label>

                                            </div>

                                        </div>

                                        <div class=" col-12 col-md-6 col-lg-2 col  mt-0 mt-md-4">

                                            <div class="crancy__item-form--group two mg-top-form-20">
                                                <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                    <label class="crancy__item-switch">
                                                    <input {{ old('is_delivery_order') ? 'checked' : '' }} name="is_delivery_order" type="checkbox" >
                                                    <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                    </label>
                                                </div>
                                                <label class="crancy__item-label">{{__('translate.Delivery Order')}} </label>

                                            </div>

                                        </div>

                                   </div>
                                </div>

                                <div class="edit_profile_form_btn mt-5">
                                    <button type="submit" class="thm-btn">{{__('translate.Save Data')}}</button>
                                </div>

                            </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- contuct part end -->

    </main>
@endsection

@push('style_section')

<link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('global/tagify/tagify.css') }}">

<link rel="stylesheet" href="{{ asset('global/clockpicker/bootstrap-clockpicker.css') }}">

    <style>
        #google_map_area {
            height: 450px;
            width: 100%;
        }

        .tox .tox-promotion,
        .tox-statusbar__branding{
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

        #searchMapInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
            margin-top: 8px !important;
        }

        #searchMapInput:focus {
            border-color: #4d90fe;
        }


    </style>


@endpush

@push('js_section')


    <script src="{{ asset('global/select2/select2.min.js') }}"></script>

    <script src="{{ asset('global/tagify/tagify.js') }}"></script>

    <script src="{{ asset('global/clockpicker/bootstrap-clockpicker.js') }}"></script>

    <script>
        (function($) {
            "use strict"
            $(document).ready(function () {
                $("#title").on("keyup",function(e){
                    let inputValue = $(this).val();
                    let slug = inputValue.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                    $("#slug").val(slug);
                })

                $('.select2').select2();

                $('.tags').tagify();

                $('.clockpicker').clockpicker();

                $('.reset_btn').on('click', function(){
                    location.reload();
                })

            });
        })(jQuery);

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function previewCoverImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_cover_img');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

    </script>


    <script>

        "use strict";

        document.addEventListener("DOMContentLoaded", function() {

        let my_location_lat = 0;
        let my_location_long = 0;
        var googleMapsLoaded = false;
        // get current location


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
            my_location_lat = position.coords.latitude;
            my_location_long = position.coords.longitude;
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

        window.initMap = function(){
            var map = new google.maps.Map(document.getElementById('google_map_area'), {
                center: {
                    lat: my_location_lat,
                    lng: my_location_long
                },
                zoom: 13
            });
            var input = document.getElementById('searchMapInput');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(my_location_lat), lng: parseFloat(my_location_long) },
                map: map,
                draggable: true
            });

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
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
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


                $("#plain_address").val(place.formatted_address);
                $("#latitude").val(place.geometry.location.lat());
                $("#longitude").val(place.geometry.location.lng());

            });
        }


        getLocation()

    });
    </script>
@endpush

