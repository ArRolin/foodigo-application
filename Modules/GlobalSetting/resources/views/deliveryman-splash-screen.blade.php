@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Delivery Man Splash Screen') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Delivery Man Splash Screen') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Website Setup') }} >> {{ __('translate.Delivery Man Splash Screen') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.deliveryman-splash-screen.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Delivery Man Splash Screen') }}</h4>
                                            </div>
                                            <div class="row mg-top-30">
                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group w-100 h-100">
                                                        <label class="crancy__item-label">{{ __('translate.Image') }} * </label>
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="splash_image" id="input-img" autocomplete="off" onchange="previewSplashImage(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img">
                                                                <img id="splash_preview" src="{{ asset($data['image'] ?? 'uploads/website-images/default.png') }}" style="max-width: 100%; height: auto;">
                                                                <h4 class="crancy-image-video-upload__title">
                                                                    {{ __('translate.Click here to') }}
                                                                    <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span>
                                                                    {{ __('translate.and upload') }}
                                                                </h4>
                                                            </label>
                                                        </div>
                                                        <small class="text-muted">{{ __('translate.Recommended size') }}: 1080 x 1920 px</small>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Heading') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="heading" id="heading" value="{{ $data['heading'] ?? '' }}" required>
                                                    </div>

                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Subheading') }} *</label>
                                                        <textarea class="crancy__item-input" name="subheading" id="subheading" rows="4" required>{{ $data['subheading'] ?? '' }}</textarea>
                                                        <small class="text-muted">{{ __('translate.A brief description about becoming a delivery partner') }}</small>
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
@endsection

@push('js_section')
    <script>
        function previewSplashImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('splash_preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush

