@extends('admin.master_layout')
@section('title')
<title>{{ __('translate.Dashboard') }}</title>
@endsection
@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Dashboard') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Dashboard') }}</p>
@endsection
@push('style_section')
    <link rel="stylesheet" href="{{ asset('backend/css/charts.min.css') }}">
@endpush
@section('body-content')
    <!-- crancy Dashboard -->

    <!-- End crancy Dashboard -->

    @section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <div class="row">
                                <div class="col-lg-3 col-12 mg-top-30">
                                    <!-- Progress Card -->
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">

                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                <div class="crancy-ecom-card__icon">
                                                    <h4 class="crancy-ecom-card__title">{{ __('translate.Active Order') }} </h4>
                                                </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                <div class="crancy-ecom-card__camount">
                                                    <div class="crancy-ecom-card__camount__inside">
                                                        <h3 class="crancy-ecom-card__amount">{{ $active_orders }}</h3>

                                                    </div>

                                                </div>

                                                </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.4167 9.33331H23.562C24.291 9.33331 24.6554 9.33331 24.9223 9.45096C26.1026 9.97136 25.5749 11.2825 25.3763 12.2248C25.3385 12.4037 25.222 12.5126 25.0834 12.6015M8.75004 9.33331H4.43801C3.70913 9.33331 3.34469 9.33331 3.07785 9.45096C1.89751 9.97136 2.42524 11.2825 2.62381 12.2248C2.65948 12.3941 2.7755 12.5381 2.93819 12.6154C3.6129 12.9355 4.08544 13.5428 4.20946 14.2489L4.90081 18.1857C5.20499 19.9179 5.30898 22.3932 6.82691 23.6135C7.94061 24.5 9.54527 24.5 12.7546 24.5H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M20.4157 15.1667C18.9383 15.1667 17.9803 16.1089 16.8473 16.4524C16.3865 16.592 16.1562 16.6618 16.063 16.7602C15.9698 16.8586 15.9425 17.0024 15.8879 17.2901C15.3036 20.3682 16.5807 23.2139 19.6259 24.3215C19.9532 24.4405 20.1167 24.5 20.4174 24.5C20.718 24.5 20.8817 24.4405 21.2088 24.3215C24.254 23.2139 25.5297 20.3682 24.9453 17.2901C24.8907 17.0024 24.8633 16.8586 24.7701 16.7601C24.6769 16.6617 24.4466 16.5919 23.9859 16.4524C22.8524 16.109 21.8933 15.1667 20.4157 15.1667Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                                                            <h4 class="crancy-ecom-card__title">{{ __('translate.Pending Order') }} </h4>
                                                        </div>

                                                    </div>
                                                    <div class="crancy-ecom-card__content">
                                                        <div class="crancy-ecom-card__camount">
                                                            <div class="crancy-ecom-card__camount__inside">
                                                                <h3 class="crancy-ecom-card__amount">{{ $pending_orders }}</h3>

                                                            </div>

                                                        </div>

                                                    </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.4167 9.33331H23.562C24.291 9.33331 24.6554 9.33331 24.9223 9.45096C26.1026 9.97136 25.5749 11.2825 25.3763 12.2248C25.3406 12.3941 25.2245 12.5381 25.0619 12.6154C24.3872 12.9355 23.9146 13.5428 23.7906 14.2489L23.0992 18.1857C22.7951 19.9179 22.6911 22.3933 21.1732 23.6135C20.0595 24.5 18.4548 24.5 15.2455 24.5H12.7546C9.54527 24.5 7.94061 24.5 6.82691 23.6135C5.30898 22.3932 5.20499 19.9179 4.90081 18.1857L4.20946 14.2489C4.08544 13.5428 3.6129 12.9355 2.93819 12.6154C2.7755 12.5381 2.65948 12.3941 2.62381 12.2248C2.42524 11.2825 1.89751 9.97136 3.07785 9.45096C3.34469 9.33331 3.70913 9.33331 4.43801 9.33331H8.75004" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Complete Order') }} </h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $complete_orders }}</h3>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.4167 9.33331H23.562C24.291 9.33331 24.6554 9.33331 24.9223 9.45096C26.1026 9.97136 25.5749 11.2825 25.3763 12.2248C25.3406 12.3941 25.2245 12.5381 25.0619 12.6154C24.4354 12.9126 24.0782 13.4066 23.8776 14M8.75004 9.33331H4.43801C3.70913 9.33331 3.34469 9.33331 3.07785 9.45096C1.89751 9.97136 2.42524 11.2825 2.62381 12.2248C2.65948 12.3941 2.7755 12.5381 2.93819 12.6154C3.6129 12.9355 4.08544 13.5428 4.20946 14.2489L4.90081 18.1857C5.20499 19.9179 5.30898 22.3932 6.82691 23.6135C7.94061 24.5 9.54527 24.5 12.7546 24.5H13.4167" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Cancel Order') }} </h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $cancel_orders }}</h3>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.1666 24.5H12.7545C9.54514 24.5 7.94049 24.5 6.82679 23.6135C5.30886 22.3932 5.20486 19.9179 4.90069 18.1857L4.20934 14.2489C4.08532 13.5428 3.61277 12.9355 2.93807 12.6154C2.77537 12.5381 2.65936 12.3941 2.62368 12.2248C2.42512 11.2825 1.89739 9.97136 3.07773 9.45096C3.34457 9.33331 3.70901 9.33331 4.43789 9.33331H8.74992M13.4166 9.33331H23.5619C24.2909 9.33331 24.6553 9.33331 24.9221 9.45096C26.1025 9.97136 25.5748 11.2825 25.3762 12.2248C25.3405 12.3941 25.2244 12.5381 25.0618 12.6154C24.1989 13.0249 23.9118 13.7582 23.7379 14.5833" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                            <div class="row">
                                <div class="col-lg-3 col-12 mg-top-30">
                                    <!-- Progress Card -->
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                <div class="crancy-ecom-card__icon">
                                                    <h4 class="crancy-ecom-card__title">{{ __('translate.Total Earning') }} </h4>
                                                </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                <div class="crancy-ecom-card__camount">
                                                    <div class="crancy-ecom-card__camount__inside">
                                                        <h3 class="crancy-ecom-card__amount">{{ currency($total_earning) }}</h3>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.3333 14.875C16.3333 13.7475 15.2886 12.8334 14 12.8334C12.7113 12.8334 11.6666 13.7475 11.6666 14.875C11.6666 16.0026 12.7113 16.9167 14 16.9167C15.2886 16.9167 16.3333 17.8308 16.3333 18.9584C16.3333 20.086 15.2886 21 14 21C12.7113 21 11.6666 20.086 11.6666 18.9584" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M14 11.0834V12.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M14 21V22.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M6.79916 12.2693C7.61585 9.81921 9.90868 8.16663 12.4913 8.16663H15.5088C18.0914 8.16663 20.3842 9.81921 21.2009 12.2693L23.0343 17.7693C24.3293 21.6544 21.4375 25.6666 17.3422 25.6666H10.6579C6.56259 25.6666 3.67077 21.6544 4.96583 17.7693L6.79916 12.2693Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                        <path d="M16.4336 8.16671L11.5665 8.16671L9.93191 6.29182C8.32956 4.45394 10.1989 1.70685 12.5383 2.46153L13.6207 2.81071C13.8671 2.8902 14.133 2.8902 14.3794 2.81071L15.4618 2.46153C17.8012 1.70685 19.6705 4.45394 18.0682 6.29183L16.4336 8.16671Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
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
                                                    <h4 class="crancy-ecom-card__title">{{ __('translate.Total Pending') }} </h4>
                                                </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ currency($total_pending)}}</h3>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.9545 25.6666H12.0452C7.26726 25.6666 3.89347 20.9857 5.40438 16.453L6.57105 12.953C7.52384 10.0946 10.1988 8.16663 13.2118 8.16663H14.7879C17.8009 8.16663 20.4758 10.0946 21.4286 12.953L22.5554 16.3333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16.4336 8.16671L11.5665 8.16671L9.93191 6.29182C8.32956 4.45394 10.1989 1.70685 12.5383 2.46153L13.6207 2.81071C13.8671 2.8902 14.133 2.8902 14.3794 2.81071L15.4618 2.46153C17.8012 1.70685 19.6705 4.45394 18.0682 6.29183L16.4336 8.16671Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                        <rect x="23.0742" y="19.7036" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 23.0742 19.7036)" stroke="currentColor" stroke-width="1.25"/>
                                                        <rect x="20.8704" y="17.5" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 20.8704 17.5)" stroke="currentColor" stroke-width="1.25"/>
                                                        <rect x="21.4214" y="21.9072" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 21.4214 21.9072)" stroke="currentColor" stroke-width="1.25"/>
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
                                                    <h4 class="crancy-ecom-card__title">{{ __('translate.Total Withdraw') }} </h4>
                                                </div>

                                            </div>
                                            <div class="crancy-ecom-card__content">
                                                <div class="crancy-ecom-card__camount">
                                                    <div class="crancy-ecom-card__camount__inside">
                                                        <h3 class="crancy-ecom-card__amount">{{ currency($total_withdraw) }}</h3>

                                                    </div>

                                                </div>

                                            </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.33337 9.33337H4.66671L12.1815 12.6211C13.188 13.0615 13.6509 14.2314 13.2181 15.2412L13.0379 15.6618C12.6028 16.677 11.427 17.1473 10.4118 16.7122L8.16671 15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M2.66878 19.1626C2.2983 18.9773 1.8478 19.1275 1.66255 19.498C1.47731 19.8684 1.62748 20.319 1.99796 20.5042L2.66878 19.1626ZM13.1688 15.6626L12.498 15.3271L11.8271 16.6688L12.498 17.0042L13.1688 15.6626ZM18.9164 18.6667V19.4167H21.3334V18.6667V17.9167H18.9164V18.6667ZM23.3334 20.6667H22.5834V21.3334H23.3334H24.0834V20.6667H23.3334ZM21.3334 23.3334V22.5834H11.2219V23.3334V24.0834H21.3334V23.3334ZM7.64421 22.4888L7.97962 21.818L2.66878 19.1626L2.33337 19.8334L1.99796 20.5042L7.3088 23.1596L7.64421 22.4888ZM16.2332 18.0333L16.5686 17.3625L13.1688 15.6626L12.8334 16.3334L12.498 17.0042L15.8978 18.7041L16.2332 18.0333ZM11.2219 23.3334V22.5834C10.0964 22.5834 8.98632 22.3213 7.97962 21.818L7.64421 22.4888L7.3088 23.1596C8.52378 23.7671 9.86352 24.0834 11.2219 24.0834V23.3334ZM23.3334 21.3334H22.5834C22.5834 22.0237 22.0237 22.5834 21.3334 22.5834V23.3334V24.0834C22.8522 24.0834 24.0834 22.8522 24.0834 21.3334H23.3334ZM21.3334 18.6667V19.4167C22.0237 19.4167 22.5834 19.9764 22.5834 20.6667H23.3334H24.0834C24.0834 19.1479 22.8522 17.9167 21.3334 17.9167V18.6667ZM18.9164 18.6667V17.9167C18.1014 17.9167 17.2976 17.7269 16.5686 17.3625L16.2332 18.0333L15.8978 18.7041C16.835 19.1727 17.8685 19.4167 18.9164 19.4167V18.6667Z" fill="currentColor"/>
                                                        <path d="M21.875 9.02595C21.875 8.4234 21.2874 7.93494 20.5625 7.93494C19.8376 7.93494 19.25 8.4234 19.25 9.02595C19.25 9.6285 19.8376 10.117 20.5625 10.117C21.2874 10.117 21.875 10.6054 21.875 11.208C21.875 11.8105 21.2874 12.299 20.5625 12.299C19.8376 12.299 19.25 11.8105 19.25 11.208" stroke="currentColor" stroke-linecap="round"/>
                                                        <path d="M20.5625 7V7.93516" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M20.5625 12.2994V13.2346" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16.3025 8.38189C16.8848 6.51864 18.6104 5.25 20.5625 5.25V5.25C22.5146 5.25 24.2402 6.51864 24.8225 8.38189L25.1676 9.48622C26.1384 12.593 23.8174 15.75 20.5625 15.75V15.75C17.3076 15.75 14.9866 12.593 15.9574 9.48622L16.3025 8.38189Z" stroke="currentColor" stroke-width="1.25" stroke-linejoin="round"/>
                                                        <path d="M21.9314 5.03125L19.1936 5.03125L18.2742 3.97663C17.3729 2.94282 18.4243 1.39758 19.7403 1.82209L20.3491 2.0185C20.4877 2.06322 20.6373 2.06322 20.7759 2.0185L21.3847 1.82209C22.7007 1.39758 23.7521 2.94282 22.8508 3.97663L21.9314 5.03125Z" stroke="currentColor" stroke-width="1.25" stroke-linejoin="round"/>
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
                                                <h4 class="crancy-ecom-card__title">{{ __('translate.Admin Income') }} </h4>
                                            </div>

                                        </div>
                                        <div class="crancy-ecom-card__content">
                                            <div class="crancy-ecom-card__camount">
                                                <div class="crancy-ecom-card__camount__inside">
                                                    <h3 class="crancy-ecom-card__amount">{{ currency($admin_income) }}</h3>

                                                </div>

                                            </div>

                                        </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 8C15 5.23858 12.7614 3 10 3C7.23858 3 5 5.23858 5 8C5 10.7614 7.23858 13 10 13C12.7614 13 15 10.7614 15 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M3 20C3 16.134 6.13401 13 10 13C11.9587 13 13.7295 13.8045 15 15.101" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M18.2375 19.9152C18.2375 19.591 17.9213 19.3281 17.5312 19.3281C17.1412 19.3281 16.825 19.591 16.825 19.9152C16.825 20.2394 17.1412 20.5023 17.5312 20.5023C17.9213 20.5023 18.2375 20.7651 18.2375 21.0893C18.2375 21.4136 17.9213 21.6764 17.5312 21.6764C17.1412 21.6764 16.825 21.4136 16.825 21.0893" stroke="currentColor" stroke-width="0.5" stroke-linecap="round"/>
                                                        <path d="M17.5312 18.825V19.3282" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M17.5312 21.6766V22.1798" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M15.239 19.5686C15.5523 18.566 16.4808 17.8833 17.5313 17.8833V17.8833C18.5817 17.8833 19.5102 18.566 19.8235 19.5686L20.0092 20.1628C20.5316 21.8345 19.2827 23.5333 17.5313 23.5333V23.5333C15.7798 23.5333 14.5309 21.8345 15.0533 20.1628L15.239 19.5686Z" stroke="currentColor" stroke-width="0.75" stroke-linejoin="round"/>
                                                        <path d="M18.2677 17.7656L16.7946 17.7656L16.2998 17.1981C15.8148 16.6418 16.3806 15.8104 17.0887 16.0388L17.4163 16.1445C17.4909 16.1685 17.5714 16.1685 17.646 16.1445L17.9736 16.0388C18.6817 15.8104 19.2475 16.6418 18.7625 17.1981L18.2677 17.7656Z" stroke="currentColor" stroke-width="0.75" stroke-linejoin="round"/>
                                                        </svg>


                                                </div>
                                            </span>

                                        </div>
                                    </div>
                                    <!-- End Progress Card -->
                                </div>

                            </div>

                            <div class="row crancy-gap-30">
                                <div class="col-12">
                                    <!-- Charts One -->
                                    <div class="charts-main charts-home-one mg-top-30">
                                        <!-- Top Heading -->
                                        <div class="charts-main__heading  mg-btm-20">
                                            <h4 class="charts-main__title">{{ __('translate.Order Statitics') }}</h4>

                                        </div>
                                        <div class="charts-main__one">
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="crancy-chart__s1" role="tabpanel" aria-labelledby="crancy-chart__s1">
                                                    <div class="crancy-chart__inside crancy-chart__three">
                                                        <!-- Chart One -->
                                                        <canvas id="myChart_recent_statics"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Charts One -->
                                </div>
                            </div>

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                <div class="crancy-customer-filter">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Latest Order') }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- crancy Table -->
                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">

                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <!-- crancy Table Head -->
                                        <thead class="crancy-table__head">
                                        <tr>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Order Id') }}
                                            </th>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Customer') }}
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
                                                    <h4 class="crancy-table__product-title">{{ $order->user->name }}</h4>
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
                                <!-- End crancy Table -->
                            </div>



                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>


            </div>


        </div>
    </section>
    <!-- End crancy Dashboard -->

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
    <script src="{{ asset('backend/js/charts.js') }}"></script>

    <script>
        "use strict";

        let purchase_data = @json($data);
		purchase_data = JSON.parse(purchase_data);

        let date_lable = @json($lable);
		date_lable = JSON.parse(date_lable);

        // Chart Three
        const ctx_myChart_recent_statics = document.getElementById('myChart_recent_statics').getContext('2d');
        const gradientBgs = ctx_myChart_recent_statics.createLinearGradient(400, 100, 100, 400);

        gradientBgs.addColorStop(0, 'rgba(253, 73, 23, 0.2)');
        gradientBgs.addColorStop(1, 'rgba(253, 73, 23, 0.5)');

        const myChart_recent_statics = new Chart(ctx_myChart_recent_statics, {
            type: 'line',

            data: {

                labels: date_lable,
                datasets: [{
                    label: 'Sells',
                    data: purchase_data,
                    backgroundColor: gradientBgs,
                    borderColor: 'rgb(253, 73, 23)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    fillColor: '#fff',
                    fill: 'start',
                    pointRadius: 2,
                }]
            },

            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: 'rgb(253, 73, 23)',
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                            color: '#E6F3FF',
                        },
                        suggestedMax: 100,
                        suggestedMin: 50,

                    },
                    y: {
                        ticks: {
                            color: 'rgb(253, 73, 23)',
                            callback: function(value, index, values) {
                                return (value / 10) * 10 + '$';
                            }
                        },
                        grid: {
                            drawBorder: false,
                            color: '#D7DCE7',
                            borderDash: [5, 5]
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        padding: 10,
                        displayColors: true,
                        yAlign: 'bottom',
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        titleFont: {
                            weight: 'normal'
                        },
                        bodyColor: '#2F3032',
                        cornerRadius: 12,
                        boxPadding: 3,
                        usePointStyle: true,
                        borderWidth: 0,
                        font: {
                            size: 14
                        },
                        caretSize: 9,
                        bodySpacing: 100,
                    },
                    legend: {
                        position: 'bottom',
                        display: false,
                    },
                    title: {
                        display: false,
                        text: "{{ __('translate.Purchase History') }}"
                    }
                }
            }
        });

        function itemDeleteConfrimation(id){
            $("#item_delect_confirmation").attr("action",'{{ url("admin/order-delete/") }}'+"/"+id)
        }

    </script>
@endpush
