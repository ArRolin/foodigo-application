@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Splash Screens') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Splash Screens') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Website Setup') }} >> {{ __('translate.Splash Screens') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.screens.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Splash Screens') }}
                                                </h4>
                                            </div>


                                            <div class="row mg-top-30">
                                                <h4>{{ __('translate.Splash Screens One') }}</h4>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="crancy__item-form--group w-100 h-100">
                                                                <label
                                                                    class="crancy__item-label">{{ __('translate.Image') }}
                                                                    * </label>
                                                                <div
                                                                    class="crancy-product-card__upload crancy-product-card__upload--border">
                                                                    <input type="file" class="btn-check"
                                                                        name="splash_image_one" id="input-img1"
                                                                        autocomplete="off" onchange="splashOne(event)">
                                                                    <label class="crancy-image-video-upload__label"
                                                                        for="input-img1">
                                                                        <img id="splash_one"
                                                                            src="{{ asset($data['one']['image']) }}">
                                                                        <h4 class="crancy-image-video-upload__title">
                                                                            {{ __('translate.Click here to') }}
                                                                            <span
                                                                                class="crancy-primary-color">{{ __('translate.Choose File') }}</span>
                                                                            {{ __('translate.and upload') }}
                                                                        </h4>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-8">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Heading') }} *
                                                        </label>
                                                        <input class="crancy__item-input" type="text" name="heading_one"
                                                            id="name" value="{{ $data['one']['heading'] ?? '' }}"
                                                            required>
                                                    </div>
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Subheading') }}
                                                            *
                                                        </label>
                                                        <input class="crancy__item-input" type="text"
                                                            name="subheading_one" id="name"
                                                            value="{{ $data['one']['subheading'] ?? '' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mg-top-30">
                                                <h4 class="mt-4">{{ __('translate.Splash Screens Two') }}</h4>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="crancy__item-form--group w-100 h-100">
                                                                <label
                                                                    class="crancy__item-label">{{ __('translate.Image') }}
                                                                    * </label>
                                                                <div
                                                                    class="crancy-product-card__upload crancy-product-card__upload--border">
                                                                    <input type="file" class="btn-check"
                                                                        name="splash_image_two" id="input-img2"
                                                                        autocomplete="off" onchange="splashTwo(event)">
                                                                    <label class="crancy-image-video-upload__label"
                                                                        for="input-img2">
                                                                        <img id="splash_two"
                                                                            src="{{ asset($data['two']['image']) }}">
                                                                        <h4 class="crancy-image-video-upload__title">
                                                                            {{ __('translate.Click here to') }}
                                                                            <span
                                                                                class="crancy-primary-color">{{ __('translate.Choose File') }}</span>
                                                                            {{ __('translate.and upload') }}
                                                                        </h4>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-8">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Heading') }} *
                                                        </label>
                                                        <input class="crancy__item-input" type="text" name="heading_two"
                                                            id="name" value="{{ $data['two']['heading'] ?? '' }}" required>
                                                    </div>
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Subheading') }}
                                                            *
                                                        </label>
                                                        <input class="crancy__item-input" type="text"
                                                            name="subheading_two" id="name"
                                                            value="{{ $data['two']['subheading'] ?? '' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mg-top-30">
                                                <h4 class="mt-4">{{ __('translate.Splash Screens Three') }}</h4>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="crancy__item-form--group w-100 h-100">
                                                                <label
                                                                    class="crancy__item-label">{{ __('translate.Image') }}
                                                                    * </label>
                                                                <div
                                                                    class="crancy-product-card__upload crancy-product-card__upload--border">
                                                                    <input type="file" class="btn-check"
                                                                        name="splash_image_three" id="input-img3"
                                                                        autocomplete="off" onchange="splashThree(event)">
                                                                    <label class="crancy-image-video-upload__label"
                                                                        for="input-img3">
                                                                        <img id="splash_three"
                                                                            src="{{ asset($data['three']['image']) }}">
                                                                        <h4 class="crancy-image-video-upload__title">
                                                                            {{ __('translate.Click here to') }}
                                                                            <span
                                                                                class="crancy-primary-color">{{ __('translate.Choose File') }}</span>
                                                                            {{ __('translate.and upload') }}
                                                                        </h4>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-8">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Heading') }} *
                                                        </label>
                                                        <input class="crancy__item-input" type="text"
                                                            name="heading_three" id="name"
                                                            value="{{ $data['three']['heading'] ?? '' }}" required>
                                                    </div>
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Subheading') }}
                                                            *
                                                        </label>
                                                        <input class="crancy__item-input" type="text"
                                                            name="subheading_three" id="name"
                                                            value="{{ $data['three']['subheading'] ?? '' }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="crancy-btn mg-top-25"
                                                type="submit">{{ __('translate.Update') }}</button>

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
@endsection

@push('js_section')
    <script>
        function splashOne(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('splash_one');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function splashTwo(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('splash_two');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };

        function splashThree(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('splash_three');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
