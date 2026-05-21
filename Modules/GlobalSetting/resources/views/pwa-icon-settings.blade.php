@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.PWA Icon Settings') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.PWA Icon Settings') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Website Setup') }} >> {{ __('translate.PWA Icon Settings') }}</p>
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
                            <form action="{{ route('admin.pwa-icon-settings-update') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.PWA Icon Settings') }}</h4>
                                            <p class="crancy-product-card__text">{{ __('translate.Manage PWA icons for different sizes. Upload custom icons for each size or use default icons.') }}</p>

                                            <div class="row">
                                                @foreach($pwaIcons as $icon)
                                                <div class="col-md-6 col-lg-4 mg-top-25">
                                                    <div class="crancy-product-card crancy-product-card--border">
                                                        <div class="crancy-product-card__header">
                                                            <h5 class="crancy-product-card__title">{{ $icon->icon_size }}</h5>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="icons[{{ $icon->icon_size }}][is_active]"
                                                                       value="1"
                                                                       {{ $icon->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label">{{ __('translate.Active') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check"
                                                                   name="icons[{{ $icon->icon_size }}][icon]"
                                                                   id="input-img-{{ $icon->icon_size }}"
                                                                   autocomplete="off"
                                                                   onchange="previewImage(event, '{{ $icon->icon_size }}')"
                                                                   accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                                                            <label class="crancy-image-video-upload__label" for="input-img-{{ $icon->icon_size }}">
                                                                <img id="view_img_{{ $icon->icon_size }}"
                                                                     src="{{ $icon->icon_path ? asset($icon->icon_path) : asset('/images/icons/logo-' . $icon->icon_size . '.png') }}"
                                                                     alt="{{ $icon->icon_size }}"
                                                                     style="max-width: 100px; max-height: 100px;">
                                                                <h4 class="crancy-image-video-upload__title">
                                                                    {{ __('translate.Click here to') }}
                                                                    <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span>
                                                                    {{ __('translate.and upload') }}
                                                                </h4>
                                                            </label>
                                                        </div>

                                                        <div class="crancy__item-form--group mg-top-15">
                                                            <label class="crancy__item-form--label">{{ __('translate.Icon Type') }}</label>
                                                            <select class="crancy__item-form--input"
                                                                    name="icons[{{ $icon->icon_size }}][icon_type]">
                                                                <option value="image/png" {{ $icon->icon_type == 'image/png' ? 'selected' : '' }}>PNG</option>
                                                                <option value="image/jpeg" {{ $icon->icon_type == 'image/jpeg' ? 'selected' : '' }}>JPEG</option>
                                                                <option value="image/svg+xml" {{ $icon->icon_type == 'image/svg+xml' ? 'selected' : '' }}>SVG</option>
                                                            </select>
                                                        </div>

                                                        <div class="crancy__item-form--group mg-top-15">
                                                            <label class="crancy__item-form--label">{{ __('translate.Purpose') }}</label>
                                                            <select class="crancy__item-form--input"
                                                                    name="icons[{{ $icon->icon_size }}][purpose]">
                                                                <option value="any maskable" {{ $icon->purpose == 'any maskable' ? 'selected' : '' }}>Any Maskable</option>
                                                                <option value="any" {{ $icon->purpose == 'any' ? 'selected' : '' }}>Any</option>
                                                                <option value="maskable" {{ $icon->purpose == 'maskable' ? 'selected' : '' }}>Maskable</option>
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="icons[{{ $icon->icon_size }}][icon_size]" value="{{ $icon->icon_size }}">
                                                    </div>
                                                </div>
                                                @endforeach
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

        function previewImage(event, iconSize) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img_' + iconSize);
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
