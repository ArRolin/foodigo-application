<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} || {{ __('translate.Maintenance') }}</title>
    <link rel="shortcut icon" href="{{asset($general_setting->favicon)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css')}}">

</head>

<body>

    <main>

        <div class="error">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 text-center">
                        @php
                            $maintenance_text = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'maintenance_text')->first();
                            $maintenance_image = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'maintenance_image')->first();
                        @endphp

                        <div class="error_thumb">
                            <span>
                                <img src="{{ asset($maintenance_image->value) }}" alt="thumb">

                            </span>
                        </div>

                        <div class="mt-3">
                        {!! clean(nl2br($maintenance_text->value)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/slick.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/main.js')}}"></script>


</body>

</html>
