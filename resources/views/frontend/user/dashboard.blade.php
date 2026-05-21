@extends('frontend.layouts.master')

@section('title')
    <title>{{ __('translate.Dashboard') }}</title>
@endsection

@section('content')
    <main class="search_V1_bg"  >
        <!-- banner-part start  -->

        <div class="profile_bg" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">{{__('translate.Home')}}</a></li>
                            <li><a href="javascript:;">/</a></li>
                            <li><a href="javascript:;" class="active">{{__('translate.Dashboard')}}</a></li>
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

                    <div class=" col-lg-8 col-xxl-9">

                        <div class="row g-4 mt_20px">
                            <div class="col-sm-6 col-xl-4 col-xxl-4">
                                <div class="dashboard_item">
                                    <span class="icon">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.5 7L10.5 8.16667C10.5 10.0997 12.067 11.6667 14 11.6667C15.933 11.6667 17.5 10.0997 17.5 8.16667V7"
                                                stroke="#334155" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M24.1106 15.1667L22.8161 7.39947C22.441 5.14926 20.4942 3.5 18.2129 3.5H9.78609C7.50484 3.5 5.55796 5.14926 5.18292 7.39947L3.23848 19.0661C2.7644 21.9106 4.95793 24.5 7.84165 24.5H15.1662"
                                                stroke="#334155" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M18.666 22.1668L20.711 23.8028C21.1985 24.1928 21.9067 24.1299 22.3178 23.66L25.666 19.8335"
                                                stroke="#334155" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                    </span>

                                    <div class="dashboard_item_txt">
                                        <h4>{{$orders->count()}}+</h4>

                                        <p>
                                            {{__('translate.Total Orders')}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4 col-xxl-4">
                                <div class="dashboard_item two">
                                    <span class="icon">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.33398 8.16683C9.33398 6.87817 10.3787 5.8335 11.6673 5.8335H21.0007C22.2893 5.8335 23.334 6.87817 23.334 8.16683V17.5002C23.334 18.7888 22.2893 19.8335 21.0007 19.8335H11.6673C10.3787 19.8335 9.33398 18.7888 9.33398 17.5002V8.16683Z"
                                                stroke="#0C1321" stroke-width="2" stroke-linejoin="round"/>
                                            <path
                                                d="M8.16667 23.3333C8.16667 24.622 7.122 25.6667 5.83333 25.6667C4.54467 25.6667 3.5 24.622 3.5 23.3333C3.5 22.0447 4.54467 21 5.83333 21C7.122 21 8.16667 22.0447 8.16667 23.3333Z"
                                                stroke="#0C1321" stroke-width="2"/>
                                            <path
                                                d="M5.83398 21.0002V4.66683C5.83398 3.37817 4.78932 2.3335 3.50065 2.3335H2.33398"
                                                stroke="#0C1321" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M8.16602 23.3335H25.666" stroke="#0C1321" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15.166 9.3335H17.4993" stroke="#0C1321" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </span>

                                    <div class="dashboard_item_txt">
                                        <h4>{{$orders->where('order_status', 5)->count()}}+</h4>

                                        <p>
                                            {{__('translate.Delivery completed')}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4 col-xxl-4">
                                <div class="dashboard_item three">
                                    <span class="icon">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.00065 4.66683H21.0007C23.578 4.66683 25.6673 6.75617 25.6673 9.3335V15.1668C25.6673 17.7442 23.578 19.8335 21.0007 19.8335H11.6673C9.08999 19.8335 7.00065 17.7442 7.00065 15.1668V4.66683ZM7.00065 4.66683C7.00065 3.37817 5.95598 2.3335 4.66732 2.3335H2.33398"
                                                stroke="#334155" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M12.834 23.9165C12.834 24.883 12.0505 25.6665 11.084 25.6665C10.1175 25.6665 9.33398 24.883 9.33398 23.9165C9.33398 22.95 10.1175 22.1665 11.084 22.1665C12.0505 22.1665 12.834 22.95 12.834 23.9165Z"
                                                stroke="#334155" stroke-width="2"/>
                                            <path
                                                d="M23.334 23.9165C23.334 24.883 22.5505 25.6665 21.584 25.6665C20.6175 25.6665 19.834 24.883 19.834 23.9165C19.834 22.95 20.6175 22.1665 21.584 22.1665C22.5505 22.1665 23.334 22.95 23.334 23.9165Z"
                                                stroke="#334155" stroke-width="2"/>
                                            <path d="M16.334 9.3335L16.334 15.1668" stroke="#334155" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M19.2493 12.25L13.416 12.25" stroke="#334155" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>

                                    <div class="dashboard_item_txt">
                                        <h4>{{$orders->whereBetween('created_at', [
                                            Carbon\Carbon::now()->subDays(30)->startOfDay(),
                                            Carbon\Carbon::now()->endOfDay()
                                        ])->count()}}+</h4>

                                        <p>
                                            {{__('translate.New order')}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if($orders->count() > 0)
                            <div class="row mt_30px">
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
                                                                <a href="#">
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
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="td_view_btn">
                                                                <a href="{{route('user.order-details', ['id' => $order->id])}}"
                                                                class="view_btn">
                                                                    <span>
                                                                        <svg width="18" height="12" viewBox="0 0 18 12"
                                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M16.6079 7.78892C17.5743 6.77219 17.5743 5.22748 16.6079 4.21075C14.9781 2.49595 12.1789 0.166504 8.99935 0.166504C5.81975 0.166504 3.02059 2.49595 1.39077 4.21075C0.42443 5.22748 0.424431 6.77219 1.39077 7.78892C3.02059 9.50373 5.81975 11.8332 8.99935 11.8332C12.1789 11.8332 14.9781 9.50373 16.6079 7.78892ZM8.99935 8.49984C10.3801 8.49984 11.4993 7.38055 11.4993 5.99984C11.4993 4.61913 10.3801 3.49984 8.99935 3.49984C7.61864 3.49984 6.49935 4.61913 6.49935 5.99984C6.49935 7.38055 7.61864 8.49984 8.99935 8.49984Z"/>
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


                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>



        <!-- dashboard part end -->




    </main>
@endsection
