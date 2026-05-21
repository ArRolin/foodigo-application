@extends('frontend.layouts.master')

@section('title')
    <title>{{ env('APP_NAME') }} - {{ __('translate.Payment') }}</title>
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
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Payment')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- banner-part end -->


        <!-- Checkout part start -->
        <section class="checkout payment_sec">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-xxl-7 col-xl-7 col-lg-7">
                                <div class="order_summery_box two">
                                    <div class="order_summery_txt">
                                        <h4>{{ __('translate.Order Summary') }}</h4>
                                    </div>

                                    <div class="cart-summary-box-item-top">
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($carts as $item)
                                            @php
                                                $product = Modules\Product\App\Models\Product::where('status', 'enable')->whereIn('id', [$item['product_id']])->first();
                                                $total = 0;
                                                $calculate = 0;
                                                $total = ($product['price'] * $item['qty']);
                                            @endphp
                                            <div class="cart-summary-box-item">
                                                <a href="javascript:;">
                                                    <div class="cart-summary-box-inner">
                                                        <div class="cart-summary-box-img td_thumb">
                                                            <img src="{{ asset($product['image']) }}" class="checkout_item_img"  alt="img">
                                                        </div>
                                                        <div class="cart-summary-box-text-two">
                                                            <h5>{{ $product['name'] }}</h5>
                                                            <ul>

                                                                @if($item['size'])
                                                                <li><span>{{ __('translate.Size') }}:</span>

                                                                    @foreach ($item['size'] as $size => $price)
                                                                        {{ $size }} (<strong>{{currency( $price) }}</strong>)
                                                                        @php $total = $total + ($price * $item['qty']) @endphp
                                                                    @endforeach

                                                                </li>
                                                                @endif
                                                                @if ($item['addons'] && is_array($item['addons']))


                                                                    @foreach ($item['addons'] as $addonId => $quantity)
                                                                    <li>
                                                                        @php
                                                                            $addonsDb = Modules\Addon\App\Models\Addon::whereIn('id', [$addonId])->get();
                                                                            $calculate += ($addonsDb->first()->price * $quantity);
                                                                        @endphp
                                                                        @if ($addonsDb->isNotEmpty())
                                                                        {{ $addonsDb->first()->name }} ({{ currency($addonsDb->first()->price) }})
                                                                        @endif
                                                                    </li>
                                                                    @endforeach

                                                                @endif
                                                            </ul>


                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @php $subtotal += $item['total']; @endphp
                                        @endforeach
                                    </div>

                                    <ul class="order_summery_list">
                                        <li>{{__('translate.Subtotal')}} <span>{{ currency($subtotal) }}</span></li>
                                        <input type="hidden" id="subtotal" value="{{$subtotal}}">
                                        <li>{{__('translate.Delivery Charge')}} <span class="delivery_charges">{{currency(session('order_data.delivery_charge'))}}</span></li>
                                        <li>{{ __('translate.Coupon Discount') }}
                                            <span id="discountAmount">
                                                @if(session('applied_coupon'))
                                                    {{ currency(session('applied_coupon.discount_amount')) }}
                                                @else
                                                    {{Currency(0.00)}}
                                                @endif

                                            </span>
                                        </li>
                                        <li>{{__('translate.Total Amount')}}
                                            <span id="newTotalAmount">
                                                @if(session('order_data'))
                                                    {{ currency(session('order_data.new_total')) }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </li>

                                    </ul>

                                </div>
                            </div>


                            <div class="col-xxl-5 col-xl-5 col-lg-5">
                                <div class="delivery">
                                    <div class="payment_method_box">

                                        <div class="payment_method_btn_main">

                                            @if($payment_setting->stripe_status)
                                                <a href="javascript:;" class="payment_method_btn">
                                                    <div class="payment_method_btn_item" data-bs-toggle="modal" data-bs-target="#stripemodal">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->stripe_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif


                                            @if($payment_setting->paypal_status)
                                            <a href="{{ url('paypal/' . session('order_data.new_total')) }}" class="payment_method_btn">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->paypal_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($payment_setting->flutterwave_status)
                                                <a href="javascript:;" class="payment_method_btn" id="payWithFlutterwave">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->flutterwave_logo)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif

                                            @if ($payment_setting->razorpay_status == 1)
                                                <a href="javascript:;" class="payment_method_btn" id="razorpay_btn">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}" alt="icon">
                                                        </div>
                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{ asset($payment_setting->razorpay_image) }}" alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>

                                                <form id="razorpay_payment_form" action="{{ route('razorpay', ['amount' => session('order_data.new_total')]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                                </form>
                                            @endif
                                            @if($payment_setting->paystack_status)
                                                <a href="javascript:;" class="payment_method_btn" id="paystackPayment">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->paystack_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($payment_setting->mollie_status)
                                                <a href="javascript:;" class="payment_method_btn" id="mollie_payment">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->mollie_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($payment_setting->instamojo_status)
                                                <a href="{{ route('pay-via-instamojo') }}" class="payment_method_btn">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->instamojo_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($payment_setting->bank_status)
                                                <a href="javascript:;" class="payment_method_btn"  data-bs-toggle="modal"
                                                data-bs-target="#bankPayment">
                                                    <div class="payment_method_btn_item">
                                                        <div class="cheak_thumb">
                                                            <img src="{{ check_icon() }}"
                                                                 alt="icon">
                                                        </div>

                                                        <div class="payment_method_btn_thumb">
                                                            <img src="{{asset($payment_setting->bank_image)}}"
                                                                 alt="thumb">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Checkout part end -->

        @if ($payment_setting->stripe_status )
            <!-- Modal -->
            <div class="modal fade" id="stripemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title"
                                id="staticBackdropLabel">{{ __('translate.Payment with stripe') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-popup__top payment-popup__top--digital">
                                <div class="payment-popup">
                                    <div class="payment-popup__inner">
                                        <!-- Sign in Form -->

                                        <form role="form" action="{{ route('pay-with-stripe') }}" method="POST"
                                              class="require-validation ecom-wc__form-main p-0" data-cc-on-file="false"
                                              data-stripe-publishable-key="{{ $payment_setting->stripe_key }}" id="payment-form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group homec-form-input">
                                                        <input class="ecom-wc__form-input card-number form-control" type="text"
                                                               name="card_number"
                                                               placeholder="{{ __('translate.Card Number') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-group homec-form-input">
                                                        <input class="ecom-wc__form-input card-expiry-month form-control" type="text"
                                                               name="month" placeholder="{{ __('translate.Month') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-group homec-form-input">
                                                        <input class="ecom-wc__form-input card-expiry-year form-control" type="text"
                                                               name="year" placeholder="{{ __('translate.Year') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group homec-form-input">
                                                        <input class="ecom-wc__form-input card-cvc form-control" type="text"
                                                               name="cvc" placeholder="{{ __('translate.CVV') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 mg-top-20 pb-3">


                                                    <button type="submit"
                                                            class="thm-btn d-block mt-3">
                                                        <span>{{ __('translate.Payment Now') }} ( {{currency(session('order_data.new_total'))}})</span></button>
                                                </div>
                                                <br>
                                                <div class="col-12 errors d-none">
                                                    <div

                                                        class="payment-popup__error alert alert-danger">{{ __('translate.Please provide your valid card information') }}</div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

    </main>

                  {{-- start bank modal --}}
                  <div class="modal fade" id="bankPayment" tabindex="-1" aria-labelledby="jobDetailsModalLabel"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-body">
                                <div class="bg-white rounded-3">
                                    <div class="proposal-container">
                                        <div class="proposal-header d-flex justify-content-between align-items-center ">
                                            <h3 class="text-dark-300 text-24 fw-bold">{{ __('translate.Pay via Bank') }}</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('bank', session('order_data.new_total')) }}" method="POST">
                                            @csrf

                                            <div class="my-2">
                                                {!! clean(nl2br($payment_setting->bank_account_info)) !!}
                                            </div>


                                            <div class="bank_modal">

                                                <div class="proposal-input-container">
                                                    <label for="time" class="proposal-form-label" >{{ __('translate.Transaction information') }}*</label >
                                                    <textarea placeholder="{{ ('Transaction information') }}" class="form-control" rows="5" name="tnx_info"></textarea>
                                                </div>

                                                <div class="d-flex gap-4 align-items-center justify-content-end" >
                                                    <button type="button" class="thm-btn_two" data-bs-dismiss="modal">
                                                        {{ __('translate.Cancel') }}
                                                    </button>
                                                    <button class="thm-btn">
                                                        {{ __('translate.Submit Now') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              {{-- end bank modal --}}

                {{-- start mollie payment --}}
                <form id="mollie_form" action="{{ route('mollie') }}" method="POST" class="d-none">
                @csrf
                    <input type="hidden" name="amount" value="{{ session('order_data.new_total') }}">
                </form>

@endsection

@push('style_section')
    <style>
        .btn--payment,
        .homec-btn--payment {
            padding: 15px 15px;
            border-radius: 5px;
            background-color: var(--color-yellow);
            color: #fff;
            border: none;
            margin-top: 17px;
        }

        .card-number,
        .card-expiry-month,
        .card-expiry-year,
        .card-cvc {
            padding: 15px 15px;
        }

        .ecom-wc__form-input:focus {
            border-color: gray;
            outline: none;
        }

        .card-expiry-month,
        .card-expiry-year {
            margin: 24px 0;
        }

        .payment-popup__heading {
            padding: 10px 0 20px 0;
        }
    </style>
@endpush

@push('js_section')
    {{-- start stripe payment --}}
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script>
        "use strict"
        $(function () {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', (e) => {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.errors'),
                    valid = true;
                $errorMessage.addClass('d-none');

                $('.has-error').removeClass('has-error');
                $inputs.each(function (i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('d-none');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.errors')
                        .removeClass('d-none')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

            /*====================================
                Payment Button
            ======================================*/

            // Add event listener to the bank button
            $('.payment-stripe-button').on("click", () => {
                $('.payment-popup__top--digital').toggleClass('active');
            });

            $("#mollie_payment").on("click", function(){
                $("#mollie_form").submit();
            });



            // Add event listener to the body
            $('body').on("click", (e) => {
                // Check if the clicked element is not the payment button or any of its children
                if (!$(e.target).is('.payment-popup') && !$(e.target).is('.payment-stripe-button') && !$.contains($('.payment-stripe-button')[0], e.target)) {
                    // If not, remove the 'active' class from the payment popup
                    $('.payment-popup__top--digital').removeClass('active');
                }
            });


            // Add event listener to the modal body
            $('.payment-popup__top--digital').on("click", (e) => {
                // Stop the event from propagating up to the body element
                e.stopPropagation();
            });

            // Add event listener to the modal body
            $('.payment-popup__top--bank').on("click", (e) => {
                // Stop the event from propagating up to the body element
                e.stopPropagation();
            });


        });
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function () {
            $('#razorpay_btn').on('click', function (e) {
                e.preventDefault();

                let options = {
                    "key": "{{ $payment_setting->razorpay_key }}",
                    "amount": "{{ round(session('order_data.new_total') * $razorpay_currency->currency_rate * 100) }}",
                    "currency": "{{ $razorpay_currency->currency_code }}",
                    "name": "{{ $payment_setting->razorpay_name }}",
                    "description": "{{ $payment_setting->razorpay_description }}",
                    "image": "{{ asset($payment_setting->razorpay_image) }}",
                    "handler": function (response){
                        $('#razorpay_payment_id').val(response.razorpay_payment_id);
                        $('#razorpay_payment_form').submit();
                    },
                    "theme": {
                        "color": "{{ $payment_setting->razorpay_theme_color }}"
                    }
                };

                let rzp = new Razorpay(options);
                rzp.open();
            });
        });
    </script>

@if ($payment_setting->paystack_status == 1)
<script src="https://js.paystack.co/v1/inline.js"></script>

@php
    $order_info = session('order_data');
    $public_key = $payment_setting->paystack_public_key;
    $currency = $paystack_currency->currency_code;
    $currency = strtoupper($currency);

    $ngn_amount = session('order_data.new_total') * $paystack_currency->currency_rate;
    $ngn_amount = $ngn_amount * 100;
    $ngn_amount = round($ngn_amount);
@endphp

    <script>
        "use strict";
        $(function() {
            $("#paystackPayment").on("click", function(){

                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                var handler = PaystackPop.setup({
                                key: '{{ $public_key }}',
                                email: '{{ $order_info['email'] }}',
                                amount: '{{ $ngn_amount }}',
                                currency: "{{ $currency }}",
                                callback: function(response){
                                    let reference = response.reference;
                                    let tnx_id = response.transaction;
                                    let _token = "{{ csrf_token() }}";
                                    var amount = parseFloat("{{ session('order_data.new_total') }}");
                                    $.ajax({
                                        type: "post",
                                        data: {reference, tnx_id, _token},
                                        url: "{{ url('paystack') }}" + "/" + amount ,
                                        success: function(response) {
                                            if(response.status == 'success'){
                                                toastr.success(response.message);
                                                window.location.href = "{{ route('paystack-success') }}";
                                            }else{
                                                toastr.error(response.message);
                                                window.location.reload();
                                            }
                                        },
                                        error: function(response){
                                                toastr.error('Server Error');
                                                window.location.reload();
                                        }
                                    });
                                },
                                onClose: function(){
                                    alert('window closed');
                                }
                            });
                    handler.openIframe();

            })
        });
    </script>

@endif


@if ($payment_setting->flutterwave_status == 1)

    <script src="https://checkout.flutterwave.com/v3.js"></script>

        @php
            $order_info = session('order_data');
            $payable_amount = session('order_data.new_total') * $flutterwave_currency->currency_rate;
            $payable_amount = round($payable_amount, 2);
        @endphp

    <script>
    "use strict";
    $(function() {
        $("#payWithFlutterwave").on("click", function(){

            var isDemo = "{{ env('APP_MODE') }}"
            if(isDemo == 'DEMO'){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            FlutterwaveCheckout({
                public_key: "{{ $payment_setting->flutterwave_public_key }}",
                tx_ref: "{{ substr(rand(0,time()),0,10) }}",
                amount: {{ $payable_amount }},
                currency: "{{ $flutterwave_currency->currency_code }}",
                country: "{{ $flutterwave_currency->country_code }}",
                payment_options: " ",
                customer: {
                email: "{{ $order_info['email'] }}",
                phone_number: "{{ $order_info['phone'] }}",
                name: "{{ $order_info['name'] }}",
                },
                callback: function (data) {
                    var tnx_id = data.transaction_id;
                    var _token = "{{ csrf_token() }}";
                    var amount = parseFloat("{{ session('order_data.new_total') }}");

                    $.ajax({
                        type: 'post',
                        data: {tnx_id, _token},
                        url: "{{ url('flutterwave/') }}" + "/" + amount,
                        success: function (response) {
                            if (response.status == 'success') {
                                toastr.success(response.message);
                                window.location.href = response.redirect_url ?? "{{ route('flutterwave-success') }}";
                            } else {
                                toastr.error(response.message);
                                window.location.reload();
                            }
                        },
                        error: function (err) {
                            toastr.error("{{ __('translate.Something went wrong, please try again') }}");
                            window.location.reload();
                        }
                    });
                },
                customizations: {
                title: "{{ $payment_setting->flutterwave_title }}",
                logo: "{{ asset($payment_setting->flutterwave_logo) }}",
                },
            });

        })
    });

    </script>
@endif


    {{-- end stripe payment --}}
@endpush
