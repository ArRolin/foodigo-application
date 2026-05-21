@extends('deliveryman.master_layout')
@section('title')
    <title>{{ __('translate.deliveryman || My Earnings') }}</title>
@endsection
@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Dashboard') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.My Earnings') }}</p>
@endsection
@section('body-content')

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
                                                <h4 class="crancy-ecom-card__title">{{ __('translate.Request Order') }} </h4>
                                            </div>

                                            </div>
                                            <div class="crancy-ecom-card__content">
                                            <div class="crancy-ecom-card__camount">
                                                <div class="crancy-ecom-card__camount__inside">
                                                    <h3 class="crancy-ecom-card__amount">{{ $request_orders }}</h3>

                                                </div>

                                            </div>

                                            </div>
                                        </div>
                                        <span>
                                            <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.4167 9.33333H23.562C24.291 9.33333 24.6554 9.33333 24.9223 9.45098C26.1026 9.97138 25.5749 11.2825 25.3763 12.2248C25.3385 12.4038 25.222 12.5126 25.0834 12.6015M8.75004 9.33333H4.43801C3.70913 9.33333 3.34469 9.33333 3.07785 9.45098C1.89751 9.97138 2.42524 11.2825 2.62381 12.2248C2.65948 12.3941 2.7755 12.5382 2.93819 12.6154C3.6129 12.9355 4.08544 13.5428 4.20946 14.249L4.90081 18.1858C5.20499 19.9179 5.30898 22.3932 6.82691 23.6136C7.94061 24.5 9.54527 24.5 12.7546 24.5H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    <path d="M20.4157 15.1667C18.9383 15.1667 17.9803 16.1089 16.8473 16.4523C16.3865 16.592 16.1562 16.6618 16.063 16.7602C15.9698 16.8586 15.9425 17.0024 15.8879 17.2901C15.3036 20.3681 16.5807 23.2139 19.6259 24.3215C19.9532 24.4405 20.1167 24.5 20.4174 24.5C20.718 24.5 20.8817 24.4405 21.2088 24.3215C24.254 23.2139 25.5297 20.3681 24.9453 17.2901C24.8907 17.0024 24.8633 16.8586 24.7701 16.7601C24.6769 16.6616 24.4466 16.5919 23.9859 16.4523C22.8524 16.109 21.8933 15.1667 20.4157 15.1667Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                                                <h4 class="crancy-ecom-card__title">{{ __('translate.Running Order') }} </h4>
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
                                                    <path d="M13.4167 9.33333H23.562C24.291 9.33333 24.6554 9.33333 24.9223 9.45098C26.1026 9.97138 25.5749 11.2825 25.3763 12.2248C25.3406 12.3941 25.2245 12.5382 25.0619 12.6154C24.3872 12.9355 23.9146 13.5428 23.7906 14.249L23.0992 18.1858C22.7951 19.9179 22.6911 22.3934 21.1732 23.6136C20.0595 24.5 18.4548 24.5 15.2455 24.5H12.7546C9.54527 24.5 7.94061 24.5 6.82691 23.6136C5.30898 22.3932 5.20499 19.9179 4.90081 18.1858L4.20946 14.249C4.08544 13.5428 3.6129 12.9355 2.93819 12.6154C2.7755 12.5382 2.65948 12.3941 2.62381 12.2248C2.42524 11.2825 1.89751 9.97138 3.07785 9.45098C3.34469 9.33333 3.70913 9.33333 4.43801 9.33333H8.75004" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                                                        <path d="M13.4167 9.33333H23.562C24.291 9.33333 24.6554 9.33333 24.9223 9.45098C26.1026 9.97138 25.5749 11.2825 25.3763 12.2248C25.3406 12.3941 25.2245 12.5382 25.0619 12.6154C24.4354 12.9127 24.0782 13.4066 23.8776 14M8.75004 9.33333H4.43801C3.70913 9.33333 3.34469 9.33333 3.07785 9.45098C1.89751 9.97138 2.42524 11.2825 2.62381 12.2248C2.65948 12.3941 2.7755 12.5382 2.93819 12.6154C3.6129 12.9355 4.08544 13.5428 4.20946 14.249L4.90081 18.1858C5.20499 19.9179 5.30898 22.3932 6.82691 23.6136C7.94061 24.5 9.54527 24.5 12.7546 24.5H13.4167" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                                                        <path d="M15.1666 24.5H12.7545C9.54514 24.5 7.94049 24.5 6.82679 23.6136C5.30886 22.3932 5.20486 19.9179 4.90069 18.1858L4.20934 14.249C4.08532 13.5428 3.61277 12.9355 2.93807 12.6154C2.77537 12.5382 2.65936 12.3941 2.62368 12.2248C2.42512 11.2825 1.89739 9.97138 3.07773 9.45098C3.34457 9.33333 3.70901 9.33333 4.43789 9.33333H8.74992M13.4166 9.33333H23.5619C24.2909 9.33333 24.6553 9.33333 24.9221 9.45098C26.1025 9.97138 25.5748 11.2825 25.3762 12.2248C25.3405 12.3941 25.2244 12.5382 25.0618 12.6154C24.1989 13.0249 23.9118 13.7583 23.7379 14.5833" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                                                    <h3 class="crancy-ecom-card__amount">{{ currency($total_income) }}</h3>


                                                </div>

                                            </div>

                                            </div>
                                        </div>
                                        <span>
                                            <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.3333 14.875C16.3333 13.7474 15.2886 12.8333 14 12.8333C12.7113 12.8333 11.6666 13.7474 11.6666 14.875C11.6666 16.0026 12.7113 16.9167 14 16.9167C15.2886 16.9167 16.3333 17.8308 16.3333 18.9583C16.3333 20.0859 15.2886 21 14 21C12.7113 21 11.6666 20.0859 11.6666 18.9583" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    <path d="M14 11.0833V12.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14 21V22.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M6.79916 12.2693C7.61585 9.81924 9.90868 8.16666 12.4913 8.16666H15.5088C18.0914 8.16666 20.3842 9.81924 21.2009 12.2693L23.0343 17.7693C24.3293 21.6545 21.4375 25.6667 17.3422 25.6667H10.6579C6.56259 25.6667 3.67077 21.6545 4.96583 17.7693L6.79916 12.2693Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                    <path d="M16.4336 8.16668L11.5665 8.16668L9.93191 6.29179C8.32956 4.45391 10.1989 1.70682 12.5383 2.4615L13.6207 2.81067C13.8671 2.89017 14.133 2.89017 14.3794 2.81067L15.4618 2.4615C17.8012 1.70682 19.6705 4.45391 18.0682 6.2918L16.4336 8.16668Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
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
                                                <h4 class="crancy-ecom-card__title">{{ __('translate.Available Balance') }}</h4>
                                            </div>

                                             </div>
                                            <div class="crancy-ecom-card__content">
                                                <div class="crancy-ecom-card__camount">
                                                    <div class="crancy-ecom-card__camount__inside">
                                                        <h3 class="crancy-ecom-card__amount">{{ currency($current_balance) }}</h3>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <span>
                                            <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.9545 25.6667H12.0452C7.26726 25.6667 3.89347 20.9858 5.40438 16.4531L6.57105 12.9531C7.52384 10.0947 10.1988 8.16666 13.2118 8.16666H14.7879C17.8009 8.16666 20.4758 10.0947 21.4286 12.9531L22.5554 16.3333M22.5554 16.3333H16.3332C15.0445 16.3333 13.9998 17.378 13.9998 18.6667C13.9998 19.9553 15.0445 21 16.3332 21C15.0445 21 13.9998 22.0447 13.9998 23.3333C13.9998 24.622 15.0445 25.6667 16.3332 25.6667H23.3332C24.6218 25.6667 25.6665 24.622 25.6665 23.3333C25.6665 22.0447 24.6218 21 23.3332 21C24.6218 21 25.6665 19.9553 25.6665 18.6667C25.6665 17.378 24.6218 16.3333 23.3332 16.3333H22.5554Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                    <path d="M16.4336 8.16668L11.5665 8.16668L9.93191 6.29179C8.32956 4.45391 10.1989 1.70682 12.5383 2.4615L13.6207 2.81067C13.8671 2.89017 14.133 2.89017 14.3794 2.81067L15.4618 2.4615C17.8012 1.70682 19.6705 4.45391 18.0682 6.2918L16.4336 8.16668Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                    <path d="M20.7667 20.1833C20.7667 19.7323 20.3488 19.3667 19.8334 19.3667C19.3179 19.3667 18.9 19.7323 18.9 20.1833C18.9 20.6344 19.3179 21 19.8334 21C20.3488 21 20.7667 21.3656 20.7667 21.8167C20.7667 22.2677 20.3488 22.6333 19.8334 22.6333C19.3179 22.6333 18.9 22.2677 18.9 21.8167" stroke="currentColor" stroke-width="0.75" stroke-linecap="round"/>
                                                    <path d="M19.8334 18.6667V19.3667" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M19.8334 22.6333V23.3333" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
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
                                                    <h3 class="crancy-ecom-card__amount"> {{ currency($total_withdraw_amount) }}</h3>

                                                </div>

                                            </div>

                                        </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.33337 9.33334H4.66671L12.1815 12.621C13.188 13.0614 13.6509 14.2313 13.2181 15.2412L13.0379 15.6617C12.6028 16.677 11.427 17.1473 10.4118 16.7122L8.16671 15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M2.66878 19.1625C2.2983 18.9773 1.8478 19.1274 1.66255 19.4979C1.47731 19.8684 1.62748 20.3189 1.99796 20.5042L2.66878 19.1625ZM13.1688 15.6625L12.498 15.3271L11.8271 16.6688L12.498 17.0042L13.1688 15.6625ZM18.9164 18.6667V19.4167H21.3334V18.6667V17.9167H18.9164V18.6667ZM23.3334 20.6667H22.5834V21.3333H23.3334H24.0834V20.6667H23.3334ZM21.3334 23.3333V22.5833H11.2219V23.3333V24.0833H21.3334V23.3333ZM7.64421 22.4888L7.97962 21.8179L2.66878 19.1625L2.33337 19.8333L1.99796 20.5042L7.3088 23.1596L7.64421 22.4888ZM16.2332 18.0332L16.5686 17.3624L13.1688 15.6625L12.8334 16.3333L12.498 17.0042L15.8978 18.7041L16.2332 18.0332ZM11.2219 23.3333V22.5833C10.0964 22.5833 8.98632 22.3213 7.97962 21.8179L7.64421 22.4888L7.3088 23.1596C8.52378 23.7671 9.86352 24.0833 11.2219 24.0833V23.3333ZM23.3334 21.3333H22.5834C22.5834 22.0237 22.0237 22.5833 21.3334 22.5833V23.3333V24.0833C22.8522 24.0833 24.0834 22.8521 24.0834 21.3333H23.3334ZM21.3334 18.6667V19.4167C22.0237 19.4167 22.5834 19.9763 22.5834 20.6667H23.3334H24.0834C24.0834 19.1479 22.8522 17.9167 21.3334 17.9167V18.6667ZM18.9164 18.6667V17.9167C18.1014 17.9167 17.2976 17.7269 16.5686 17.3624L16.2332 18.0332L15.8978 18.7041C16.835 19.1727 17.8685 19.4167 18.9164 19.4167V18.6667Z" fill="currentColor"/>
                                                        <path d="M21.875 9.02598C21.875 8.42343 21.2874 7.93497 20.5625 7.93497C19.8376 7.93497 19.25 8.42343 19.25 9.02598C19.25 9.62853 19.8376 10.117 20.5625 10.117C21.2874 10.117 21.875 10.6055 21.875 11.208C21.875 11.8106 21.2874 12.299 20.5625 12.299C19.8376 12.299 19.25 11.8106 19.25 11.208" stroke="currentColor" stroke-linecap="round"/>
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
                                                <h4 class="crancy-ecom-card__title">{{ __('translate.Pending Withdraw') }} </h4>
                                            </div>

                                        </div>
                                        <div class="crancy-ecom-card__content">
                                            <div class="crancy-ecom-card__camount">
                                                <div class="crancy-ecom-card__camount__inside">
                                                    <h3 class="crancy-ecom-card__amount">{{ currency($pending_withdraw) }}</h3>

                                                </div>

                                            </div>

                                        </div>
                                            </div>
                                            <span>
                                                <div class="d-inline-flex justify-content-center align-items-center bg-success-white rounded-circle grid-icon-size text-primary">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.9545 25.6667H12.0452C7.26726 25.6667 3.89347 20.9858 5.40438 16.4531L6.57105 12.9531C7.52384 10.0947 10.1988 8.16666 13.2118 8.16666H14.7879C17.8009 8.16666 20.4758 10.0947 21.4286 12.9531L22.5554 16.3333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16.4335 8.16668L11.5664 8.16668L9.93178 6.29179C8.32944 4.45391 10.1987 1.70682 12.5382 2.4615L13.6206 2.81067C13.867 2.89017 14.1328 2.89017 14.3793 2.81067L15.4617 2.4615C17.8011 1.70682 19.6704 4.45391 18.0681 6.2918L16.4335 8.16668Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                                        <rect x="23.0742" y="19.7036" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 23.0742 19.7036)" stroke="currentColor" stroke-width="1.25"/>
                                                        <rect x="20.8704" y="17.5" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 20.8704 17.5)" stroke="currentColor" stroke-width="1.25"/>
                                                        <rect x="21.4214" y="21.9073" width="2.20376" height="6.61129" rx="1.10188" transform="rotate(90 21.4214 21.9073)" stroke="currentColor" stroke-width="1.25"/>
                                                        </svg>

                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- End Progress Card -->
                                </div>

                            </div>
                            @if($withdraw_list->count() > 0)
                                <div class="crancy-table crancy-table--v3 mg-top-30">

                                    <div class="crancy-customer-filter">
                                        <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                            <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Withdraw List') }}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- crancy Table -->
                                    <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer bg-white">

                                        <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                            <!-- crancy Table Head -->
                                            <thead class="crancy-table__head">
                                            <tr>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Serial') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.delivery Method') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Total Amount') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Withdraw Amount') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Withdraw Charge') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Status') }}
                                                </th>

                                                <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                    {{ __('translate.Action') }}
                                                </th>

                                            </tr>
                                            </thead>
                                            <!-- crancy Table Body -->
                                            <tbody class="crancy-table__body">
                                            @foreach ($withdraw_list as $index => $withdraw)

                                                <tr class="odd">

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">
                                                            <a href="#">{{ $withdraw->withdraw_method_name}}</a>
                                                        </h4>
                                                    </td>


                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ currency($withdraw->total_amount) }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ currency($withdraw->withdraw_amount) }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ currency($withdraw->charge_amount) }}</h4>
                                                    </td>


                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($withdraw->status == 'approved')
                                                            <span class="badge bg-success text-white">{{ __('translate.Approved') }}</span>
                                                        @elseif ($withdraw->status == 'rejected')
                                                            <span class="badge bg-danger text-white">{{ __('translate.Rejected') }}</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">{{ __('translate.Pending') }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a data-bs-toggle="modal"
                                                                data-bs-target="#withdrawShow{{ $withdraw->id }}" class="crancy-btn"><i class="fas fa-eye"></i> {{ __('translate.View') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            <!-- End crancy Table Body -->
                                        </table>
                                    </div>
                                </div>
                            @endif


                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>


            </div>


        </div>
    </section>





    @foreach ($withdraw_list as $index => $withdraw)
        <div class="modal fade" id="withdrawShow{{ $withdraw->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Withdraw Details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td>{{ __('translate.Withdraw Method') }}</td>
                                <td>{{ $withdraw->withdraw_method_name }}</td>
                            </tr>
                            <tr>
                                <td> {{ __('translate.Total Amount') }}</td>
                                <td>{{ currency($withdraw->total_amount) }}</td>
                            </tr>

                            <tr>
                                <td> {{ __('translate.Withdraw Amount') }}</td>
                                <td>{{ currency($withdraw->withdraw_amount) }}</td>
                            </tr>

                            <tr>
                                <td> {{ __('translate.Charge Amount') }}</td>
                                <td>{{ currency($withdraw->charge_amount) }}</td>
                            </tr>

                            <tr>
                                <td> {{ __('translate.Status') }}</td>
                                <td>
                                    @if ($withdraw->status == 'approved')
                                        <span class="status-badge in-progress"> {{ __('translate.Approved') }} </span>
                                    @elseif ($withdraw->status == 'rejected')
                                        <span class="status-badge pending"> {{ __('translate.Rejected') }} </span>
                                    @else
                                        <span class="status-badge pending"> {{ __('translate.Pending') }} </span>
                                    @endif
                                </td>
                            </tr>


                            <tr>
                                <td> {{ __('translate.Bank/Account Info') }}</td>
                                <td>{!! clean(nl2br(html_decode($withdraw->description))) !!}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

@endsection
