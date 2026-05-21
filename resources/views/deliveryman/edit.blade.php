@extends('deliveryman.master_layout')
@section('title')
    <title>{{ __('translate.My Profile') }}</title>
@endsection
@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Profile') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Edit Profile') }}</p>
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
                            <form action="{{ route('deliveryman.deliveryman-update', $deliveryman->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Update Deliveryman Information') }}</h4>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="man_image" id="input-img1" autocomplete="off" onchange="reviewImage(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img1">
                                                                <img id="view_img" src="{{ asset($deliveryman->man_image) }}">
                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.First Name') }}</label>
                                                <input class="crancy__item-input" type="text" name="fname" value="{{ $deliveryman->fname }}">
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Last Name') }}</label>
                                                <input class="crancy__item-input" type="text" name="lname" value="{{ $deliveryman->lname }}">
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Email') }}</label>
                                                <input class="crancy__item-input" type="email" name="email" value="{{ $deliveryman->email }}">
                                            </div>


                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Gender') }}</label>
                                                <select class="crancy__item-input" name="man_type" id="man_type">
                                                    <option value="male" {{ $deliveryman->man_type == 'male' ? 'selected' : '' }}>{{ __('translate.Male') }}</option>
                                                    <option value="female" {{ $deliveryman->man_type == 'female' ? 'selected' : '' }}>{{ __('translate.Female') }}</option>
                                                </select>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Idn Type') }}</label>
                                                <input class="crancy__item-input" type="text" name="idn_type" value="{{ $deliveryman->idn_type }}">
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Idn Number') }}</label>
                                                <input class="crancy__item-input" type="text" name="idn_num" value="{{ $deliveryman->idn_num }}">
                                            </div>
                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Phone') }}</label>
                                                <input class="crancy__item-input" type="text" name="phone" value="{{ $deliveryman->phone }}">
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

        function reviewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush

