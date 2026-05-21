@extends('frontend.layouts.master')

@section('title')
    <title>{{__('translate.Edit Address')}}</title>
@endsection

@section('content')
    <main class="search_V1_bg" >
        <!-- banner-part start  -->

        <div class="profile_bg"
             style="background-image: url({{ asset($general_setting->breadcrumb_image) }});">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="{{ route('home') }}">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Address')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->

        <!-- dashboard part start  -->
        <section class="dashboard">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4  col-xxl-3">
                        @include('frontend.layouts.partials.dashboard_partials')
                    </div>

                    <div class="col-lg-8  col-xxl-9">

                        <div class="row">
                            <div class="col-12">

                                <div class="dashbord_taitel mb-4">
                                    <h4>{{__('translate.Edit Address')}}</h4>
                                </div>

                                <div class="dashbord_edit_profile">
                                    <form class="edit_profile_form" method="post"
                                        action="{{route('user.address-update', $address->id)}}">

                                        @csrf
                                        @method('put')

                                        <div class="address_form_item">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mb-3 mt-3">{{ __('translate.Name') }}</label>
                                                <input type="text" class="form-control delivery-info" id="" value="{{$address->name}}"
                                                        name="name"
                                                        >
                                            </div>
                                        </div>

                                        <div class="address_form_item">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mb-3 mt-3">{{ __('translate.Email Address') }}</label>
                                                <input type="email" class="form-control delivery-info" id="" value="{{$address->email}}"
                                                        name="email">
                                            </div>
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mb-3 mt-3">{{ __('translate.Phone Number') }}</label>
                                                <input type="text" class="form-control delivery-info" id="" value="{{$address->phone}}"
                                                        name="phone">
                                            </div>
                                        </div>

                                        <div class="address_form_item">
                                            <div class="address_form_inner">
                                            <label class="crancy__item-label mb-3 mt-3">{{ __('translate.Your Location') }} * </label>

                                            <input id="searchMapInput" class="mapControls" type="text"
                                                   placeholder="{{ __('translate.Enter a location') }}" value="{{ $address->address }}">

                                            <div id="google_map_area">

                                            </div>
                                        </div>

                                        </div>

                                        <div class="address_form_item">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mt-3 mb-2">{{__('translate.Address')}}</label>
                                                <input type="text" class="form-control delivery-info" name="address" id="plain_address" value="{{$address->address}}">
                                            </div>
                                        </div>

                                        <div class="address_form_item d-none">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mt-2 mb-2">{{__('translate.Latitude')}}</label>
                                                <input class="form-control delivery-info latitude" type="text" name="latitude" id="latitude" value="{{$address->lat}}" readonly>
                                            </div>
                                        </div>

                                        <div class="address_form_item d-none">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mt-2 mb-2">{{__('translate.Longitude')}}</label>
                                                <input class="form-control longitude delivery-info" type="text" name="longitude" id="longitude" value="{{$address->lon}}" readonly>
                                            </div>
                                        </div>
                                        <div class="address_form_item mb-4">
                                            <div class="address_form_inner">
                                                <label for="" class="form-label mb-3 mt-3">{{ __('translate.Delivery Type') }}</label>
                                                <select class="form-select delivery-info" aria-label="Default select example"
                                                        name="delivery_type">
                                                    <option {{ $address->delivery_type == 'home' ? 'selected' : '' }} value="home">{{ __('translate.Home') }}</option>
                                                    <option {{ $address->delivery_type == 'office' ? 'selected' : '' }} value="office">{{ __('translate.Office') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="edit_profile_form_btn">
                                            <button type="submit" class="thm-btn">{{__('translate.Update')}}</button>
                                        </div>
                                    </form>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('style_section')
    <style>
        #google_map_area {
            height: 350px;
            width: 100%;
        }

        .pac-container { z-index: 100000 !important; }

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

        #searchMapInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }

        #searchMapInput:focus {
            border-color: #4d90fe;
        }


    </style>
@endpush

@push('js_section')

    <script>

        "use strict";
        let my_location_lat = '{{$address->lat}}';
        let my_location_long = '{{$address->lon}}';


        function initMap() {
            var map = new google.maps.Map(document.getElementById('google_map_area'), {
                center: {
                    lat: parseFloat(my_location_lat),
                    lng: parseFloat(my_location_long)
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

            autocomplete.addListener('place_changed', function () {
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
                $(".latitude").val(place.geometry.location.lat());
                $(".longitude").val(place.geometry.location.lng());

            });
        }
    </script>



    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API') }}&libraries=places&callback=initMap"
            async defer></script>

@endpush
