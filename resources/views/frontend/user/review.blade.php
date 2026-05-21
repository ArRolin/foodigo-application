@extends('frontend.layouts.master')

@section('title')
    <title>{{ __('translate.Review') }}</title>
@endsection

@section('content')
    <main class="search_V1_bg" >
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Review')}}</a></li>
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
                    <div class=" col-lg-4 col-xxl-3">
                        @include('frontend.layouts.partials.dashboard_partials')
                    </div>

                    <div class="col-lg-8 col-xxl-9  ">

                        <div class="row change_password">
                            <div class="col-lg-12">

                        <div class="dashbord_taitel mb_25px">
                            <h4>{{__('translate.Reviews')}}</h4>
                            <p>{{__('translate.Let check your today')}}</p>
                        </div>


                        <div class="dashboard_review">

                            <div class="dashboard_review_item">
                                @foreach($reviews ?? [] as $review)
                                    <div class="dashboard_review_inner">
                                        <div class="dashboard_review_ratting">
                                            <p>{{ $review?->product?->name }}</p>

                                            <ul class="dashboard_review_ratting_icon">
                                                @php
                                                $rating = $review->rating;
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <span>
                                                        @if ($i <= $rating)
                                                            <i class="fa-solid fa-star"></i>
                                                        @else
                                                            <i class="fa-regular fa-star"></i>
                                                        @endif
                                                    </span>
                                                </li>
                                            @endfor
                                            </ul>
                                        </div>
                                        <div class="dashboard_review_inner_txt">
                                            <p>
                                                “{{$review->review}}.”
                                            </p>
                                        </div>

                                        <div class="dashboard_review_inner_btm">
                                            <div class="dashboard_review_inner_item">
                                                <div class="dashboard_review_inner_thumb">
                                                    <img src="{{asset($review?->user?->image)}}"
                                                        alt="thumb">
                                                </div>

                                                <a href="javascript:;">{{ $review?->user?->name }}</a>
                                            </div>

                                            <span class="dot"></span>

                                            <div class="dashboard_review_inner_item_txt">
                                                <p>
                                                    {{  Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>

        <!-- dashboard part end -->

    </main>
@endsection
