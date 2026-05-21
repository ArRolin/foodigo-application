@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Offer') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Offer') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Offer') }} >> {{ __('translate.Offer') }}</p>
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
                            <form action="{{ route('admin.update-offer') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Offer') }}</h4>
                                            </div>


                                            <div class="row mg-top-30">

                                                <div class="col-md-6">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title') }} * </label>
                                                        <input class="crancy__item-input" type="text" name="title" id="title" value="{{ $offer->title }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} * </label>
                                                        <input class="crancy__item-input" type="text" name="description" id="description" value="{{ $offer->description }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Offer (%)') }} * </label>
                                                        <input class="crancy__item-input" type="number" name="offer" id="offer" value="{{ $offer->offer }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.End Time') }} * </label>
                                                        <input class="crancy__item-input datetimepicker_mask" type="text" name="end_time" id="end_time" value="{{ $offer->end_time }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{__('translate.Status')}} </label>
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                            <input name="status" type="checkbox" {{ $offer->status == 1 ? 'checked' : '' }}>
                                                            <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Save') }}</button>

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



@push('style_section')
    <link rel="stylesheet" href="{{ asset('global/datetimepicker/jquery.datetimepicker.css') }}">

@endpush




@push('js_section')

<script src="{{ asset('global/datetimepicker/jquery.datetimepicker.js') }}"></script>

<script>
    (function($) {
        "use strict"
        $(document).ready(function () {
            $('.datetimepicker_mask').datetimepicker({
                format:'Y-m-d H:i',

            });
        });
    })(jQuery);
</script>


@endpush


