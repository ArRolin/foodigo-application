@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Edit Promotional Banner') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Promotional Banner') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Promotional Banner') }} >> {{ __('translate.Edit Promotional Banner') }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.promotional.banner.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Promotional Banner') }}</h4>
                                            <div class="row">
                                                <div class="col-md-4 ml-auto">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <label for="image1" class="form-label">{{ __('translate.Home Promotional Banner One') }}</label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="promotional_banner_one" id="input-img1" autocomplete="off" onchange="previewImage(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img1">
                                                                <img id="view_img10" src="{{ asset($homepage->promotional_banner_one) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mg-top-20">
                                                    <div class="sign-up-from-inner">
                                                        <label for="exampleFormControlInput1" class="form-label">{{ __('translate.Home Promotional Banner Url One') }}</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1"  name="promotional_banner_one_url" value="{{ $homepage->promotional_banner_one_url }}">
                                                    </div>
                                                </div>

                                                <div class="col-12 mg-top-20">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Visibility Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="promotional_banner_one_status" type="checkbox" {{ $homepage->promotional_banner_one_status == 1 ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-4 ml-auto">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <label for="image2" class="form-label">{{ __('translate.Home Promotional Banner Two') }}</label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="promotional_banner_two" id="input-img2" autocomplete="off" onchange="previewImage2(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img2">
                                                                <img id="view_img12" src="{{ asset($homepage->promotional_banner_two) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mg-top-20">
                                                    <div class="sign-up-from-inner">
                                                        <label for="exampleFormControlInput1" class="form-label">{{ __('translate.Home Promotional Banner Url Two') }}</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput1"  name="promotional_banner_two_url" value="{{ $homepage->promotional_banner_two_url }}">
                                                    </div>
                                                </div>

                                                <div class="col-12 mg-top-20">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Visibility Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="promotional_banner_two_status" type="checkbox"  {{ $homepage->promotional_banner_two_status == 1 ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-4 ml-auto">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <label for="image3" class="form-label">{{ __('translate.Search Page Restaurant Banner') }}</label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="promotional_banner_restaurant" id="input-img3" autocomplete="off" onchange="previewImage3(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img3">
                                                                <img id="view9" src="{{ asset($homepage->promotional_banner_restaurant) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mg-top-20">
                                                    <div class="sign-up-from-inner">
                                                        <label for="exampleFormControlInput1" class="form-label">{{ __('translate.Search Page Restaurant Url') }}</label>
                                                        <input type="text" class="form-control" value="{{ $homepage->promotional_banner_restaurant_url }}" id="exampleFormControlInput1" name="promotional_banner_restaurant_url">
                                                    </div>
                                                </div>

                                                <div class="col-12 mg-top-20">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Visibility Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="promotional_banner_restaurant_status" type="checkbox" {{ $homepage->promotional_banner_restaurant_status == 1 ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-4 ml-auto">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <label for="image3" class="form-label">{{ __('translate.Blog Page Banner One') }}</label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="blog_banner_one" id="input-img4" autocomplete="off" onchange="previewImage4(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img4">
                                                                <img id="view4" src="{{ asset($homepage->blog_banner_one) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mg-top-20">
                                                    <div class="sign-up-from-inner">
                                                        <label for="blog_banner_one_link" class="form-label">{{ __('translate.Blog Page Banner One Link') }}</label>
                                                        <input type="text" class="form-control" value="{{ $homepage->blog_banner_one_link }}" id="blog_banner_one_link"  name="blog_banner_one_link">
                                                    </div>
                                                </div>

                                                <div class="col-12 mg-top-20">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Visibility Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="blog_banner_one_status" type="checkbox" {{ $homepage->blog_banner_one_status == 1 ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 ml-auto">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <label for="image3" class="form-label">{{ __('translate.Blog Page Banner Two') }}</label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="blog_banner_two" id="input-img5" autocomplete="off" onchange="previewImage5(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img5">
                                                                <img id="view5" src="{{ asset($homepage->blog_banner_two) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mg-top-20">
                                                    <div class="sign-up-from-inner">
                                                        <label for="blog_banner_two_link" class="form-label">{{ __('translate.Blog Page Banner Two Link') }}</label>
                                                        <input type="text" class="form-control" value="{{ $homepage->blog_banner_two_link }}" id="blog_banner_two_link"  name="blog_banner_two_link">
                                                    </div>
                                                </div>

                                                <div class="col-12 mg-top-20">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Visibility Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="blog_banner_two_status" type="checkbox" {{ $homepage->blog_banner_two_status == 1 ? 'checked' : '' }}>
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>






                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update') }}</button>

                                        </div>
                                        <!-- End Product Card -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection


@push('js_section')
    <script>
        "use strict";

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img10');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function previewImage2(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img12');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function previewImage3(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view9');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function previewImage4(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view4');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function previewImage5(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view5');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

    </script>
@endpush



