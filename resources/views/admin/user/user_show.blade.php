@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.User Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.User Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.User Details') }}</p>
@endsection

@section('body-content')

    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">


            <div class="row">
                <div class="col-lg-3 col-12 mg-top-30">
                    <!-- Progress Card -->
                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                        <div class="flex-main">

                            <div class="flex-1">
                                <div class="crancy-ecom-card__heading">
                                <div class="crancy-ecom-card__icon">
                                    <h4 class="crancy-ecom-card__title">{{ __('translate.Active Orders') }} </h4>
                                </div>

                                </div>
                                <div class="crancy-ecom-card__content">
                                <div class="crancy-ecom-card__camount">
                                    <div class="crancy-ecom-card__camount__inside">
                                        <h3 class="crancy-ecom-card__amount">{{$active_orders}}</h3>

                                    </div>

                                </div>

                                </div>
                            </div>
                            <span>
                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4167 9.33337H23.562C24.291 9.33337 24.6554 9.33337 24.9223 9.45102C26.1026 9.97142 25.5749 11.2826 25.3763 12.2248C25.3385 12.4038 25.222 12.5127 25.0834 12.6016M8.75004 9.33337H4.43801C3.70913 9.33337 3.34469 9.33337 3.07785 9.45102C1.89751 9.97142 2.42524 11.2826 2.62381 12.2248C2.65948 12.3941 2.7755 12.5382 2.93819 12.6154C3.6129 12.9356 4.08544 13.5428 4.20946 14.249L4.90081 18.1858C5.20499 19.918 5.30898 22.3933 6.82691 23.6136C7.94061 24.5 9.54527 24.5 12.7546 24.5H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M20.4157 15.1666C18.9383 15.1666 17.9803 16.1088 16.8473 16.4523C16.3865 16.5919 16.1562 16.6617 16.063 16.7602C15.9698 16.8585 15.9425 17.0024 15.8879 17.2901C15.3036 20.3681 16.5807 23.2138 19.6259 24.3215C19.9532 24.4405 20.1167 24.5 20.4174 24.5C20.718 24.5 20.8817 24.4405 21.2088 24.3215C24.254 23.2138 25.5297 20.3681 24.9453 17.2901C24.8907 17.0024 24.8633 16.8585 24.7701 16.7601C24.6769 16.6616 24.4466 16.5918 23.9859 16.4523C22.8524 16.1089 21.8933 15.1666 20.4157 15.1666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.58337 12.8333L11.6667 3.5M17.5 3.5L20.4167 9.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                </div>
                            </span>
                        </div>
                    </div>
                    <!-- End Progress Card -->
                </div>

                <div class="col-lg-3 col-12 mg-top-30">
                    <!-- Progress Card -->
                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                        <div class="flex-main">


                            <div class="flex-1">
                            <div class="crancy-ecom-card__heading">
                             <div class="crancy-ecom-card__icon">
                                <h4 class="crancy-ecom-card__title">{{ __('translate.Pending Orders') }} </h4>
                            </div>

                             </div>
                            <div class="crancy-ecom-card__content">
                                <div class="crancy-ecom-card__camount">
                                    <div class="crancy-ecom-card__camount__inside">
                                        <h3 class="crancy-ecom-card__amount">{{$pending_orders}}</h3>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <span>
                            <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4167 9.33337H23.562C24.291 9.33337 24.6554 9.33337 24.9223 9.45102C26.1026 9.97142 25.5749 11.2826 25.3763 12.2248C25.3406 12.3941 25.2245 12.5382 25.0619 12.6154C24.3872 12.9356 23.9146 13.5428 23.7906 14.249L23.0992 18.1858C22.7951 19.918 22.6911 22.3934 21.1732 23.6136C20.0595 24.5 18.4548 24.5 15.2455 24.5H12.7546C9.54527 24.5 7.94061 24.5 6.82691 23.6136C5.30898 22.3933 5.20499 19.918 4.90081 18.1858L4.20946 14.249C4.08544 13.5428 3.6129 12.9356 2.93819 12.6154C2.7755 12.5382 2.65948 12.3941 2.62381 12.2248C2.42524 11.2826 1.89751 9.97142 3.07785 9.45102C3.34469 9.33337 3.70913 9.33337 4.43801 9.33337H8.75004" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M16.3333 14H11.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.58337 12.8333L11.6667 3.5M17.5 3.5L20.4167 9.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>

                            </div>
                        </span>
                        </div>

                    </div>
                    <!-- End Progress Card -->
                </div>

                <div class="col-lg-3 col-12 mg-top-30">
                    <!-- Progress Card -->
                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                        <div class="flex-main">

                            <div class="flex-1">
                            <div class="crancy-ecom-card__heading">
                            <div class="crancy-ecom-card__icon">
                                <h4 class="crancy-ecom-card__title">{{ __('translate.Completed Orders') }} </h4>
                            </div>

                        </div>
                        <div class="crancy-ecom-card__content">
                            <div class="crancy-ecom-card__camount">
                                <div class="crancy-ecom-card__camount__inside">
                                    <h3 class="crancy-ecom-card__amount">{{$complete_orders}}</h3>

                                </div>

                            </div>

                        </div>
                            </div>
                            <span>
                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4167 9.33337H23.562C24.291 9.33337 24.6554 9.33337 24.9223 9.45102C26.1026 9.97142 25.5749 11.2826 25.3763 12.2248C25.3406 12.3941 25.2245 12.5382 25.0619 12.6154C24.4354 12.9127 24.0782 13.4067 23.8776 14M8.75004 9.33337H4.43801C3.70913 9.33337 3.34469 9.33337 3.07785 9.45102C1.89751 9.97142 2.42524 11.2826 2.62381 12.2248C2.65948 12.3941 2.7755 12.5382 2.93819 12.6154C3.6129 12.9356 4.08544 13.5428 4.20946 14.249L4.90081 18.1858C5.20499 19.918 5.30898 22.3933 6.82691 23.6136C7.94061 24.5 9.54527 24.5 12.7546 24.5H13.4167" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M16.3334 22.1667C16.3334 22.1667 17.5 22.1667 18.6667 24.5C18.6667 24.5 22.3726 18.6667 25.6667 17.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.58337 12.8333L11.6667 3.5M17.5 3.5L20.4167 9.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>

                                </div>
                            </span>
                        </div>
                    </div>
                    <!-- End Progress Card -->
                </div>

                <div class="col-lg-3 col-12 mg-top-30">
                    <!-- Progress Card -->
                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                        <div class="flex-main">

                            <div class="flex-1">
                            <div class="crancy-ecom-card__heading">
                            <div class="crancy-ecom-card__icon">
                                <h4 class="crancy-ecom-card__title">{{ __('translate.Cancel Orders') }} </h4>
                            </div>

                        </div>
                        <div class="crancy-ecom-card__content">
                            <div class="crancy-ecom-card__camount">
                                <div class="crancy-ecom-card__camount__inside">
                                    <h3 class="crancy-ecom-card__amount"> {{$cancel_orders}}</h3>

                                </div>

                            </div>

                        </div>
                            </div>
                            <span>
                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.1666 24.5H12.7545C9.54514 24.5 7.94049 24.5 6.82679 23.6136C5.30886 22.3933 5.20486 19.918 4.90069 18.1858L4.20934 14.249C4.08532 13.5428 3.61277 12.9356 2.93807 12.6154C2.77537 12.5382 2.65936 12.3941 2.62368 12.2248C2.42512 11.2826 1.89739 9.97142 3.07773 9.45102C3.34457 9.33337 3.70901 9.33337 4.43789 9.33337H8.74992M13.4166 9.33337H23.5619C24.2909 9.33337 24.6553 9.33337 24.9221 9.45102C26.1025 9.97142 25.5748 11.2826 25.3762 12.2248C25.3405 12.3941 25.2244 12.5382 25.0618 12.6154C24.1989 13.0249 23.9118 13.7583 23.7379 14.5834" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M18.6667 17.5L22.1667 21M22.1667 21L25.6667 24.5M22.1667 21L18.6667 24.5M22.1667 21L25.6667 17.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M7.58325 12.8333L11.6666 3.5M17.4999 3.5L20.4166 9.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>


                                </div>
                            </span>
                        </div>
                    </div>
                    <!-- End Progress Card -->
                </div>

            </div>

            <div class="row mg-top-30 row__bscreen">
                <div class=" col-xxl-3 col-xl-4 col-lg-4">
                    <div class="overview-profile">
                        <div class="overview-profile-thumb-main">
                            <div class="overview-profile-thumb">
                                @if ($user->image)
                                <img src="{{ asset($user->image) }}" alt="thumb">
                                @else
                                <img src="{{ asset($general_setting->default_avatar) }}" alt="thumb">
                                @endif

                            </div>
                            <div class="overview-profile-txt">
                                <h4>{{ html_decode($user->name) }}</h4>
                            </div>
                        </div>

                        <div class="overview-researcher">
                            <p>{{ html_decode($user->designation) }} </p>
                        </div>


                        <div class="overview-profile-item">
                            <div class="overview-profile-inner">
                                <h4>{{ __('translate.About') }}</h4>
                                <p>{{ html_decode($user->about_me) }} </p>
                            </div>

                            <div class="overview-profile-inner">
                                <h4>{{ __('translate.Contact Information') }} </h4>


                                <ul class="overview-profile-inner-contact">
                                    <li>
                                        <a href="tel:{{ html_decode($user->phone) }}">
                                            <span>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13 14L12.8529 14.7354C13.1846 14.8018 13.5196 14.6379 13.6708 14.3354L13 14ZM6 7L5.66459 6.32918C5.36208 6.48043 5.19824 6.81544 5.26456 7.14709L6 7ZM6.35402 6.82299L6.68943 7.49381L6.68943 7.49381L6.35402 6.82299ZM7.31654 4.29136L8.0129 4.01281L7.31654 4.29136ZM6.50289 2.25722L5.80653 2.53576L6.50289 2.25722ZM17.7428 13.4971L17.4642 14.1935L17.7428 13.4971ZM15.7086 12.6835L15.9872 11.9871H15.9872L15.7086 12.6835ZM13.177 13.646L13.8478 13.9814V13.9814L13.177 13.646ZM14.25 9C14.25 9.41421 14.5858 9.75 15 9.75C15.4142 9.75 15.75 9.41421 15.75 9H14.25ZM14.6955 7.46927L15.3884 7.18225L14.6955 7.46927ZM12.5307 5.30448L12.8177 4.61157L12.5307 5.30448ZM11 4.25C10.5858 4.25 10.25 4.58579 10.25 5C10.25 5.41421 10.5858 5.75 11 5.75V4.25ZM18.25 9C18.25 9.41421 18.5858 9.75 19 9.75C19.4142 9.75 19.75 9.41421 19.75 9H18.25ZM18.391 5.93853L19.0839 5.65152L18.391 5.93853ZM14.0615 1.60896L14.3485 0.916054V0.916054L14.0615 1.60896ZM11 0.25C10.5858 0.25 10.25 0.585786 10.25 1C10.25 1.41421 10.5858 1.75 11 1.75V0.25ZM18.25 15.3541V17H19.75V15.3541H18.25ZM3 1.75H4.64593V0.25H3V1.75ZM13 14C13.1471 13.2646 13.1473 13.2646 13.1475 13.2646C13.1476 13.2647 13.1477 13.2647 13.1479 13.2647C13.1481 13.2648 13.1483 13.2648 13.1484 13.2648C13.1487 13.2649 13.1488 13.2649 13.1488 13.2649C13.1488 13.2649 13.1482 13.2648 13.147 13.2645C13.1447 13.264 13.14 13.2631 13.1331 13.2615C13.1193 13.2585 13.0967 13.2533 13.0659 13.2459C13.0044 13.2309 12.9104 13.2066 12.7898 13.1711C12.5482 13.1 12.2016 12.9847 11.7954 12.8106C10.9796 12.461 9.94391 11.8833 9.03033 10.9697L7.96967 12.0303C9.05609 13.1167 10.2704 13.789 11.2046 14.1894C11.6734 14.3903 12.0768 14.525 12.3665 14.6101C12.5115 14.6528 12.6285 14.6832 12.7114 14.7034C12.7529 14.7135 12.7859 14.721 12.8097 14.7263C12.8217 14.7289 12.8313 14.7309 12.8385 14.7325C12.8421 14.7332 12.8451 14.7339 12.8475 14.7343C12.8487 14.7346 12.8498 14.7348 12.8507 14.735C12.8511 14.7351 12.8515 14.7352 12.8519 14.7352C12.8521 14.7353 12.8523 14.7353 12.8524 14.7353C12.8527 14.7354 12.8529 14.7354 13 14ZM9.03033 10.9697C8.11675 10.0561 7.53901 9.02042 7.18936 8.20456C7.01527 7.79836 6.89996 7.45184 6.8289 7.21025C6.79342 7.08962 6.76912 6.99565 6.75414 6.93406C6.74666 6.90329 6.74151 6.88065 6.73847 6.86687C6.73695 6.85999 6.73595 6.85532 6.73546 6.85296C6.73521 6.85178 6.73509 6.85118 6.73508 6.85117C6.73508 6.85116 6.73511 6.8513 6.73517 6.85159C6.7352 6.85174 6.73524 6.85192 6.73528 6.85214C6.7353 6.85225 6.73534 6.85244 6.73535 6.8525C6.73539 6.8527 6.73544 6.85291 6 7C5.26456 7.14709 5.26461 7.14732 5.26466 7.14756C5.26468 7.14765 5.26473 7.1479 5.26477 7.14809C5.26484 7.14846 5.26492 7.14887 5.26501 7.14932C5.2652 7.15022 5.26541 7.15127 5.26566 7.15247C5.26615 7.15488 5.26677 7.15789 5.26753 7.1615C5.26905 7.16873 5.27111 7.17834 5.27374 7.19026C5.279 7.21408 5.28655 7.2471 5.29664 7.28859C5.31682 7.37154 5.34721 7.48851 5.38985 7.6335C5.47504 7.92316 5.60973 8.32664 5.81064 8.79544C6.21099 9.72958 6.88325 10.9439 7.96967 12.0303L9.03033 10.9697ZM6.33541 7.67082L6.68943 7.49381L6.01861 6.15217L5.66459 6.32918L6.33541 7.67082ZM8.0129 4.01281L7.19925 1.97868L5.80653 2.53576L6.62018 4.5699L8.0129 4.01281ZM18.0213 12.8008L15.9872 11.9871L15.4301 13.3798L17.4642 14.1935L18.0213 12.8008ZM12.5062 13.3106L12.3292 13.6646L13.6708 14.3354L13.8478 13.9814L12.5062 13.3106ZM15.9872 11.9871C14.6592 11.4559 13.1458 12.0313 12.5062 13.3106L13.8478 13.9814C14.1386 13.3999 14.8265 13.1384 15.4301 13.3798L15.9872 11.9871ZM6.68943 7.49381C7.96868 6.85419 8.54408 5.34076 8.0129 4.01281L6.62018 4.5699C6.86163 5.17351 6.60008 5.86143 6.01861 6.15217L6.68943 7.49381ZM4.64593 1.75C5.15706 1.75 5.6167 2.06119 5.80653 2.53576L7.19925 1.97868C6.78162 0.934616 5.77042 0.25 4.64593 0.25V1.75ZM19.75 15.3541C19.75 14.2296 19.0654 13.2184 18.0213 12.8008L17.4642 14.1935C17.9388 14.3833 18.25 14.8429 18.25 15.3541H19.75ZM17 18.25C8.57766 18.25 1.75 11.4223 1.75 3H0.25C0.25 12.2508 7.74923 19.75 17 19.75V18.25ZM17 19.75C18.5188 19.75 19.75 18.5188 19.75 17H18.25C18.25 17.6904 17.6904 18.25 17 18.25V19.75ZM1.75 3C1.75 2.30964 2.30964 1.75 3 1.75V0.25C1.48122 0.25 0.25 1.48122 0.25 3H1.75ZM15.75 9C15.75 8.37622 15.6271 7.75855 15.3884 7.18225L14.0026 7.75628C14.1659 8.15059 14.25 8.5732 14.25 9H15.75ZM15.3884 7.18225C15.1497 6.60596 14.7998 6.08232 14.3588 5.64124L13.2981 6.7019C13.5999 7.00369 13.8393 7.36197 14.0026 7.75628L15.3884 7.18225ZM14.3588 5.64124C13.9177 5.20016 13.394 4.85028 12.8177 4.61157L12.2437 5.99739C12.638 6.16072 12.9963 6.40011 13.2981 6.7019L14.3588 5.64124ZM12.8177 4.61157C12.2415 4.37286 11.6238 4.25 11 4.25V5.75C11.4268 5.75 11.8494 5.83406 12.2437 5.99739L12.8177 4.61157ZM19.75 9C19.75 7.85093 19.5237 6.71312 19.0839 5.65152L17.6981 6.22554C18.0625 7.10516 18.25 8.04792 18.25 9H19.75ZM19.0839 5.65152C18.6442 4.58992 17.9997 3.62533 17.1872 2.81282L16.1265 3.87348C16.7997 4.5467 17.3338 5.34593 17.6981 6.22554L19.0839 5.65152ZM17.1872 2.81282C16.3747 2.0003 15.4101 1.35578 14.3485 0.916054L13.7745 2.30187C14.6541 2.66622 15.4533 3.20025 16.1265 3.87348L17.1872 2.81282ZM14.3485 0.916054C13.2869 0.476325 12.1491 0.25 11 0.25V1.75C11.9521 1.75 12.8948 1.93753 13.7745 2.30187L14.3485 0.916054Z"
                                                        fill="#fd4917" />
                                                </svg>
                                            </span>
                                            {{ html_decode($user->phone) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mailto:{{ html_decode($user->email) }}">
                                            <span>
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2 12V7C2 4.79086 3.79086 3 6 3H18C20.2091 3 22 4.79086 22 7V17C22 19.2091 20.2091 21 18 21H8M6 8L9.7812 10.5208C11.1248 11.4165 12.8752 11.4165 14.2188 10.5208L18 8M2 15H8M2 18H8"
                                                        stroke="#fd4917" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                </svg>


                                            </span>
                                            {{ html_decode($user->email) }}
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:;">
                                            <span>
                                                <svg width="18" height="22" viewBox="0 0 18 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 20.25C2.58579 20.25 2.25 20.5858 2.25 21C2.25 21.4142 2.58579 21.75 3 21.75V20.25ZM15 21.75C15.4142 21.75 15.75 21.4142 15.75 21C15.75 20.5858 15.4142 20.25 15 20.25V21.75ZM15.75 8.5C15.75 10.2065 14.6599 12.4136 13.1547 14.2468C12.4148 15.1481 11.6072 15.9179 10.8465 16.4554C10.0624 17.0094 9.42269 17.25 9 17.25V18.75C9.88982 18.75 10.8438 18.294 11.7121 17.6804C12.6038 17.0504 13.5071 16.1815 14.314 15.1987C15.9026 13.2638 17.25 10.7209 17.25 8.5H15.75ZM9 17.25C8.59247 17.25 7.95947 16.9993 7.171 16.4074C6.409 15.8353 5.59932 15.0178 4.85679 14.0668C3.34675 12.1327 2.25 9.82498 2.25 8.11111H0.75C0.75 10.3246 2.09075 12.9614 3.67446 14.9899C4.4788 16.0201 5.38006 16.9385 6.27041 17.6069C7.13428 18.2555 8.09503 18.75 9 18.75V17.25ZM2.25 8.11111C2.25 4.48059 5.47857 1.75 9 1.75V0.25C4.78944 0.25 0.75 3.51941 0.75 8.11111H2.25ZM9 1.75C12.4938 1.75 15.75 4.45503 15.75 8.5H17.25C17.25 3.54497 13.2382 0.25 9 0.25V1.75ZM11.25 8C11.25 9.24264 10.2426 10.25 9 10.25V11.75C11.0711 11.75 12.75 10.0711 12.75 8H11.25ZM9 10.25C7.75736 10.25 6.75 9.24264 6.75 8H5.25C5.25 10.0711 6.92893 11.75 9 11.75V10.25ZM6.75 8C6.75 6.75736 7.75736 5.75 9 5.75V4.25C6.92893 4.25 5.25 5.92893 5.25 8H6.75ZM9 5.75C10.2426 5.75 11.25 6.75736 11.25 8H12.75C12.75 5.92893 11.0711 4.25 9 4.25V5.75ZM3 21.75H15V20.25H3V21.75Z"
                                                        fill="#fd4917" />
                                                </svg>


                                            </span>
                                            {{ html_decode($user->address) }}
                                        </a>
                                    </li>

                                </ul>

                            </div>


                            <div class="overview-profile-inner">

                                @if ($user->is_dealer == 1)
                                <a target="_blank" href="{{ route('agent', $user->username) }}" class="crancy-btn crancy-full-width mg-top-20"> <i class="fas fa-eye    "></i> {{ __('translate.Go To Public Profile') }}</a>
                                @endif

                                <a onclick="itemDeleteConfrimation({{ $user->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="crancy-btn crancy-full-width mg-top-20 user_delete_btn"> <i class="fas fa-trash    "></i> {{ __('translate.Delete User') }}</a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-xxl-9 col-xl-8 col-lg-8">
                    <div class="container container__bscreen ">
                        <div class="row">
                            <div class="col-12">
                                <div class="crancy-body">
                                    <div class="crancy-dsinner">

                                        <div class="crancy-table crancy-table--v3">

                                            <div class="crancy-customer-filter">
                                                <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                                    <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                                        <h4 class="crancy-product-card__title">{{ __('translate.All Orders') }}</h4>
                                                    </div>
                                                </div>
                                            </div>



                                            <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                                <!-- crancy Table Head -->
                                                <thead class="crancy-table__head">
                                                <tr>

                                                    <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                        {{ __('translate.Order Id') }}
                                                    </th>

                                                    <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                        {{ __('translate.Date') }}
                                                    </th>

                                                    <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                        {{ __('translate.Amount') }}
                                                    </th>

                                                    <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                        {{ __('translate.Order Status') }}
                                                    </th>

                                                    <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                        {{ __('translate.Action') }}
                                                    </th>




                                                </tr>
                                                </thead>
                                                <!-- crancy Table Body -->
                                                <tbody class="crancy-table__body">
                                                    @foreach ($orders as $index => $order)

                                                    <tr class="odd">

                                                        <td class="crancy-table__column-2 crancy-table__data-2">
                                                            <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                        </td>

                                                        <td class="crancy-table__column-2 crancy-table__data-2">
                                                            <h4 class="crancy-table__product-title">{{$order->created_at->format('F j, Y') }}</h4>
                                                        </td>

                                                        <td class="crancy-table__column-2 crancy-table__data-2">
                                                            <h4 class="crancy-table__product-title">
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
                                                            </h4>
                                                        </td>
                                                        <td class="crancy-table__column-2 crancy-table__data-2">
                                                            <h4 class="crancy-table__product-title">
                                                                <span class="mb-1">

                                                                @if($order->order_status == 1)
                                                                    {{__('translate.State')}} : <span class="tag denger">{{__('translate.Pending')}}</span>
                                                                @elseif($order->order_status == 2)
                                                                    {{__('translate.State')}} : <span
                                                                        class="tag">{{__('translate.Confirmed')}}</span>
                                                                @elseif($order->order_status == 3)
                                                                    {{__('translate.State')}} : <span
                                                                        class="tag">{{__('translate.Processing')}}</span>
                                                                @elseif($order->order_status == 4)
                                                                    {{__('translate.State')}} : <span
                                                                        class="tag">{{__('translate.Food on the way')}}</span>
                                                                @elseif($order->order_status == 5)
                                                                    {{__('translate.State')}} : <span
                                                                        class="tag">{{__('translate.Delivered')}}</span>
                                                                @elseif($order->order_status == 6)
                                                                    {{__('translate.State')}} : <span
                                                                        class="tag">{{__('translate.Canceled')}}</span>
                                                                @endif
                                                                </span>
                                                            </h4>
                                                            <div class="text-capitalize opacity-7">
                                                                <span>{{__('translate.Type')}}:</span>
                                                                <span class="text-success">{{$order->order_type}}</span>
                                                            </div>
                                                        </td>


                                                        <td class="crancy-table__column-2 crancy-table__data-2">
                                                            <a href="{{route('admin.order.details', ['id' => $order->id])}}" class="crancy-btn"><i class="fas fa-eye"></i> {{ __('translate.View') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                                <!-- End crancy Table Body -->
                                            </table>



                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->



    {{-- Edit Modal --}}

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Edit User Basic Information') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.user-update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.Name') }} * </label>
                                    <input class="crancy__item-input" type="text" name="name" value="{{ html_decode($user->name) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.Designation') }} </label>
                                    <input class="crancy__item-input" type="text" name="designation" value="{{ html_decode($user->designation) }}" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.Phone') }} *</label>
                                    <input class="crancy__item-input" type="text" name="phone" value="{{ html_decode($user->phone) }}" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.Whatsapp') }} </label>
                                    <input class="crancy__item-input" type="text" name="whatsapp_phone" value="{{ html_decode($user->whatsapp_phone) }}" >
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.Address') }} *</label>
                                    <input class="crancy__item-input" type="text" name="address" value="{{ html_decode($user->address) }}" >
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{ __('translate.About') }} </label>
                                    <textarea class="crancy__item-input crancy__item-textarea seo_description_box"  name="about_me" id="about_me">{{ html_decode($user->about_me) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="crancy__item-form--group mg-top-form-20">
                                    <label class="crancy__item-label">{{__('translate.Status')}} </label>
                                    <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                        <label class="crancy__item-switch">
                                        <input {{ $user->status == 'enable' ? 'checked' : '' }} name="status" type="checkbox" >
                                        <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>


                </div>
                <div class="modal-footer delet_modal_form">

                    <button type="submit" class="btn btn-primary">{{ __('translate.Update Info') }}</button>
                </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to delete this item?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="item_delect_confirmation" class="delet_modal_form" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary btn-type-dlt">{{ __('translate.Yes, Delete') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js_section')
    <script>
        "use strict"
        function itemDeleteConfrimation(id){
            $("#item_delect_confirmation").attr("action",'{{ url("admin/user-delete/") }}'+"/"+id)
        }

        function manageStatus(id){
            var appMODE = "{{ env('APP_MODE') }}"
            if(appMODE == 'DEMO'){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            $.ajax({
                type:"put",
                data: { _token : '{{ csrf_token() }}' },
                url:"{{url('/admin/user-status/') }}"+"/"+id,
                success:function(response){
                    toastr.success(response)
                },
                error:function(err){}
            })
        }

    </script>
@endpush
