@extends('frontend.layouts.master')

@section('title')
    <title>{{ __('translate.Order List') }}</title>
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
                            <li><a href="javascript:;" class="active">{{__('translate.Order List')}}</a></li>
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

                    <div class="col-lg-8 col-xxl-9">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="dashboard_tabel">
                                    <div class="dashboard_tabel_txt">
                                        <h4>{{__('translate.Recent Order')}} </h4>
                                    </div>

                                    <div class="dashboard_tabel_main">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Order ID')}}</p>

                                                        <div class="th_item_icon">
                                                                <span class="arrow_top">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M1.16602 4L3.66602 1.5M3.66602 1.5L6.16602 4M3.66602 1.5L3.66602 11.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>
                                                                </span>
                                                            <span class="arrow_bottom">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M5.83398 9L3.33398 11.5M3.33398 11.5L0.833984 9M3.33398 11.5L3.33398 1.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>

                                                                </span>
                                                        </div>


                                                    </div>
                                                </th>

                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Restaurant')}}</p>

                                                        <div class="th_item_icon">
                                                                <span class="arrow_top">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M1.16602 4L3.66602 1.5M3.66602 1.5L6.16602 4M3.66602 1.5L3.66602 11.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>
                                                                </span>
                                                            <span class="arrow_bottom">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M5.83398 9L3.33398 11.5M3.33398 11.5L0.833984 9M3.33398 11.5L3.33398 1.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>

                                                                </span>
                                                        </div>


                                                    </div>
                                                </th>

                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Date')}}</p>

                                                        <div class="th_item_icon">
                                                                <span class="arrow_top">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M1.16602 4L3.66602 1.5M3.66602 1.5L6.16602 4M3.66602 1.5L3.66602 11.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>
                                                                </span>
                                                            <span class="arrow_bottom">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M5.83398 9L3.33398 11.5M3.33398 11.5L0.833984 9M3.33398 11.5L3.33398 1.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>

                                                                </span>
                                                        </div>


                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Amount')}}</p>

                                                        <div class="th_item_icon">
                                                                <span class="arrow_top">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M1.16602 4L3.66602 1.5M3.66602 1.5L6.16602 4M3.66602 1.5L3.66602 11.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>
                                                                </span>
                                                            <span class="arrow_bottom">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M5.83398 9L3.33398 11.5M3.33398 11.5L0.833984 9M3.33398 11.5L3.33398 1.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>

                                                                </span>
                                                        </div>


                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Status')}}</p>

                                                        <div class="th_item_icon">
                                                                <span class="arrow_top">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M1.16602 4L3.66602 1.5M3.66602 1.5L6.16602 4M3.66602 1.5L3.66602 11.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>
                                                                </span>
                                                            <span class="arrow_bottom">
                                                                    <svg width="7" height="13" viewBox="0 0 7 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                                d="M5.83398 9L3.33398 11.5M3.33398 11.5L0.833984 9M3.33398 11.5L3.33398 1.5"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                    </svg>

                                                                </span>
                                                        </div>


                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="th_item">
                                                        <p>{{__('translate.Action')}}</p>
                                                    </div>
                                                </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders ?? [] as $order)
                                            <tr>
                                                <td>
                                                    <div class="td_order_id">
                                                        <a href="javascript:;">
                                                            #{{$order->id}}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="td_food">
                                                        <a href="{{ route('single.restaurant', $order?->restaurant?->slug) }}">
                                                            {{$order?->restaurant?->restaurant_name}}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="td_date">
                                                        <p>{{$order->created_at->format('F j, Y') }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="td_amount">
                                                        <p>{{ currency($order->grand_total) }}</p>
                                                        @if($order->payment_status == 'success')
                                                            <strong class="text-success">
                                                                {{ __('translate.Paid') }}
                                                            </strong>
                                                        @else
                                                            <strong class="text-danger">
                                                                {{__('translate.Unpaid')}}
                                                            </strong>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="td_badge">


                                                        @if($order->order_status == 1)
                                                            <span class="badge pending "> {{__('translate.Pending')}}</span>
                                                        @elseif($order->order_status == 2)
                                                            <span class="badge successful "> {{__('translate.Confirmed')}}</span>
                                                        @elseif($order->order_status == 3)
                                                            <span class="badge successful "> {{__('translate.Processing')}}</span>
                                                        @elseif($order->order_status == 4)
                                                            <span class="badge successful "> {{__('translate.Food on the way')}}</span>
                                                        @elseif($order->order_status == 5)
                                                            <span class="badge successful "> {{__('translate.Delivered')}}</span>
                                                        @elseif($order->order_status == 6)
                                                            <span class="badge pending "> {{__('translate.Cancel')}}</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="td_view_btn">
                                                        <a href="{{route('user.order-details', ['id' => $order->id])}}" class="view_btn">
                                                                <span>
                                                                    <svg width="18" height="12" viewBox="0 0 18 12"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                              d="M16.6079 7.78892C17.5743 6.77219 17.5743 5.22748 16.6079 4.21075C14.9781 2.49595 12.1789 0.166504 8.99935 0.166504C5.81975 0.166504 3.02059 2.49595 1.39077 4.21075C0.42443 5.22748 0.424431 6.77219 1.39077 7.78892C3.02059 9.50373 5.81975 11.8332 8.99935 11.8332C12.1789 11.8332 14.9781 9.50373 16.6079 7.78892ZM8.99935 8.49984C10.3801 8.49984 11.4993 7.38055 11.4993 5.99984C11.4993 4.61913 10.3801 3.49984 8.99935 3.49984C7.61864 3.49984 6.49935 4.61913 6.49935 5.99984C6.49935 7.38055 7.61864 8.49984 8.99935 8.49984Z" />
                                                                    </svg>

                                                                </span>
                                                        </a>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        {{ $orders->links('frontend.layouts.partials.pagination') }}
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
