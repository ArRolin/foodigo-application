<!-- Main Menu -->
<div class="admin-menu__one crancy-sidebar-padding mg-top-20">
    <h4 class="admin-menu__title">{{ __('translate.Main Menu') }}</h4>
    <!-- Nav Menu -->
    <div class="menu-bar">
        <ul id="CrancyMenu" class="menu-bar__one crancy-dashboard-menu">

            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="collapsed"
                                                                              href="{{ route('admin.dashboard') }}">
            <span class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg class="crancy-svg-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="22"
                         viewBox="0 0 20 22" fill="none">
                        <path
                            d="M14 21V17C14 14.7909 12.2091 13 10 13C7.79086 13 6 14.7909 6 17V21M19 9.15033V16.9668C19 19.1943 17.2091 21 15 21H5C2.79086 21 1 19.1943 1 16.9668V9.15033C1 7.93937 1.53964 6.7925 2.46986 6.02652L7.46986 1.90935C8.9423 0.696886 11.0577 0.696883 12.5301 1.90935L17.5301 6.02652C18.4604 6.7925 19 7.93937 19 9.15033Z"
                            stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="menu-bar__name">{{ __('translate.Dashboard') }}</span></span></a>
            </li>

            <li><a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__order_list"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">


                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C21.1491 10.971 20.8738 11.2102 20.6797 11.5M7.5 8H3.80397C3.17922 8 2.86684 8 2.63812 8.10084C1.6264 8.5469 2.07874 9.67075 2.24894 10.4784C2.27952 10.6235 2.37896 10.747 2.51841 10.8132C3.09673 11.0876 3.50177 11.6081 3.60807 12.2134L4.20066 15.5878C4.46138 17.0725 4.55052 19.1942 5.8516 20.2402C6.8062 21 8.18162 21 10.9325 21H13.0675C13.2156 21 12.5 21.0001 13 21"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <g clip-path="url(#clip0_1668_10)">
                    <path d="M14.8333 14.5H19.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M14.8333 17H21.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M14.8333 19.5H19.2778" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    </g>
                    <path d="M6.5 11L10 3M15 3L17.5 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <defs>
                    <clipPath id="clip0_1668_10">
                    <rect width="8.33333" height="8.33333" fill="currentColor" transform="translate(14 12.8333)"/>
                    </clipPath>
                    </defs>
                </svg>
                </span>

                <span class="menu-bar__name">{{ __('translate.Manage Order') }}</span></span> <span class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.order.*') ? 'show' : '' }}"
                     id="menu-item__order_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.order.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.All Order') }}</span></span></a></li>
                        <li><a href="{{ route('admin.order.index', ['order_type' => 'delivery']) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Delivery Order') }}</span></span></a></li>
                        <li><a href="{{ route('admin.order.index', ['order_type' => 'pickup']) }}"><span
                                    class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Pickup Order') }}</span></span></a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.category.*') ? 'active' : '' }}"><a href="#!" class="collapsed"
                                                                               data-bs-toggle="collapse"
                                                                               data-bs-target="#menu-item__category_list"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C20.9033 11.0876 20.4982 11.6081 20.3919 12.2134L19.7993 15.5878C19.5386 17.0725 19.4495 19.1943 18.1484 20.2402C17.1938 21 15.8184 21 13.0675 21H10.9325C8.18162 21 6.8062 21 5.8516 20.2402C4.55052 19.1942 4.46138 17.0725 4.20066 15.5878L3.60807 12.2134C3.50177 11.6081 3.09673 11.0876 2.51841 10.8132C2.37896 10.747 2.27952 10.6235 2.24894 10.4784C2.07874 9.67075 1.6264 8.5469 2.63812 8.10084C2.86684 8 3.17922 8 3.80397 8H7.5"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M14 12H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.5 11L10 3M15 3L17.5 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>

                </span>

                <span class="menu-bar__name">{{ __('translate.Manage Product') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.category.*') || Route::is('admin.addon.*') ||  Route::is('admin.product.*') ? 'show' : '' }}"
                    id="menu-item__category_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.category.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Category List') }}</span></span></a></li>
                        <li><a href="{{ route('admin.addon.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Addon List') }}</span></span></a></li>
                        <li><a href="{{ route('admin.product.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Product List') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.cuisine.*') || Route::is('admin.restaurants.*') || Route::is('admin.city*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__car_list"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 17.9998V9.99976C20 8.11414 20 7.17133 19.4142 6.58554C18.8284 5.99976 17.8856 5.99976 16 5.99976H4V17.9998C4 19.8854 4 20.8282 4.58579 21.414C5.17157 21.9998 6.11438 21.9998 8 21.9998H16C17.8856 21.9998 18.8284 21.9998 19.4142 21.414C20 20.8282 20 19.8854 20 17.9998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 10.9998C13.6569 10.9998 15 12.3429 15 13.9998M12 10.9998C10.3431 10.9998 9 12.3429 9 13.9998M12 10.9998V9.99976M15 13.9998H9M15 13.9998H16M9 13.9998H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 17.9998H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 5.99976L11.3846 2.90562C13.0337 2.21467 13.8582 1.8692 14.5149 2.04518C14.9408 2.1593 15.3173 2.41168 15.5859 2.76312C16 3.30508 16 4.2033 16 5.99976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                </span>

                <span class="menu-bar__name">{{ __('translate.Manage Restaurant') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.cuisine.*') || Route::is('admin.restaurants.*') || Route::is('admin.city*') ? 'show' : '' }}"
                    id="menu-item__car_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.cuisine.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Cuisine List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.city.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.City List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.restaurants.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Restaurant List') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.deliveryman.*') ? 'active' : '' }}">
                <a href="#menu-item__car_list1" class="collapsed" data-bs-toggle="collapse" role="button"
                   aria-expanded="{{ Route::is('admin.deliveryman-index') || Route::is('admin.deliveryman-pending') ? 'true' : 'false' }}"
                   aria-controls="menu-item__car_list1">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 6C14 8.20914 12.2091 10 10 10C7.79086 10 6 8.20914 6 6C6 3.79086 7.79086 2 10 2C12.2091 2 14 3.79086 14 6Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <g clip-path="url(#clip0_1691_52145)">
                                <path d="M17.4167 21.1667C17.0757 21.1667 16.7501 21.0245 16.0987 20.7402C15.3385 20.4083 14.7565 20.1543 14.3527 19.9167H12.8333M17.4167 21.1667C17.7576 21.1667 18.0832 21.0245 18.7346 20.7402C20.356 20.0325 21.1667 19.6786 21.1667 19.0833V14.7083M17.4167 21.1667V16.5833M13.6667 14.7083V15.9583" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.8858 16.0381L14.6686 15.4491C14.0007 15.1259 13.6667 14.9643 13.6667 14.7083C13.6667 14.4524 14.0007 14.2908 14.6686 13.9676L15.8858 13.3786C16.637 13.0151 17.0126 12.8333 17.4167 12.8333C17.8207 12.8333 18.1963 13.0151 18.9475 13.3786L20.1647 13.9676C20.8327 14.2908 21.1667 14.4524 21.1667 14.7083C21.1667 14.9643 20.8327 15.1259 20.1647 15.4491L18.9475 16.0381C18.1963 16.4016 17.8207 16.5833 17.4167 16.5833C17.0126 16.5833 16.637 16.4016 15.8858 16.0381Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.5569 13.6732L15.278 15.7437" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.8333 17.4167H14.0833" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.8333 18.6667H14.0833" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                <path d="M10.5 20H5C3.89543 20 3 19.1046 3 18C3 15.2386 5.23858 13 8 13H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                <clipPath id="clip0_1691_52145">
                                <rect width="10" height="10" fill="white" transform="translate(12 12)"/>
                                </clipPath>
                                </defs>
                                </svg>


                        </span>
                        <span class="menu-bar__name">{{ __('translate.Deliveryman') }}</span>
                    </span>
                    <span class="crancy__toggle"></span>
                </a>

                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.deliveryman-index') || Route::is('admin.deliveryman-pending') || Route::is('admin.document-type.*') || Route::is('admin.vehicle-type.*') ? 'show' : '' }}"
                    id="menu-item__car_list1" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li>
                            <a href="{{ route('admin.deliveryman-index') }}"
                               class="{{ Route::is('admin.deliveryman-index') ? 'active' : '' }}">
                                <span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Deliveryman List') }}</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.deliveryman-pending') }}"
                               class="{{ Route::is('admin.deliveryman-pending') ? 'active' : '' }}">
                                <span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Pending Deliveryman') }}</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.document-type.index') }}"
                               class="{{ Route::is('admin.document-type.*') ? 'active' : '' }}">
                                <span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Document Type') }}</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.vehicle-type.index') }}"
                               class="{{ Route::is('admin.vehicle-type.*') ? 'active' : '' }}">
                                <span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Vehicle Type') }}</span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.coupon.*') || Route::is('admin.offer*') ? 'active' : '' }}"><a href="#!"
                                                                                                          class="collapsed"
                                                                                                          data-bs-toggle="collapse"
                                                                                                          data-bs-target="#menu-item__coupon_list"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.27352 6.10452C7.76151 6.35029 7.21443 6.41187 6.65675 6.28693C6.29177 6.20517 6.10926 6.16429 5.9623 6.14751C4.13743 5.93912 3 7.38342 3 9.04427V9.95573C3 11.6166 4.13743 13.0609 5.9623 12.8525C6.10926 12.8357 6.29178 12.7948 6.65675 12.7131C7.21443 12.5881 7.76151 12.6497 8.27352 12.8955L14.9263 16.089C16.4534 16.8221 17.217 17.1886 18.0684 16.9029C18.9197 16.6172 19.2119 16.0041 19.7964 14.778C21.4012 11.4112 21.4012 7.58885 19.7964 4.22196C19.2119 2.99586 18.9197 2.38281 18.0684 2.0971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.4581 20.7709L9.96674 22C6.60515 19.3339 7.01583 18.0625 7.01583 13H8.14966C8.60978 15.8609 9.69512 17.216 11.1927 18.197C12.1152 18.8012 12.3054 20.0725 11.4581 20.7709Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.5 12.5V6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13 6.6875C13.7965 6.6875 14.4916 6.24388 14.8609 5.58535M13 6.6875C12.2035 6.6875 11.5084 6.24388 11.1391 5.58535M13 6.6875V8M14.8609 5.58535L16 6.24982M14.8609 5.58535C15.0403 5.26554 15.1429 4.89498 15.1429 4.5C15.1429 4.10494 15.0403 3.73429 14.8608 3.41439M11.1391 5.58535L10 6.24982M11.1391 5.58535C10.9597 5.26554 10.8571 4.89498 10.8571 4.5C10.8571 4.10494 10.9597 3.73429 11.1392 3.41439M13 2.3125C13.7965 2.3125 14.4914 2.75604 14.8608 3.41439M13 2.3125C12.2035 2.3125 11.5086 2.75604 11.1392 3.41439M13 2.3125V1M14.8608 3.41439L16 2.74982M11.1392 3.41439L10 2.74982" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                </span>

                <span class="menu-bar__name">{{ __('translate.Manage Promotion') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.coupon.*') || Route::is('admin.offer*') ? 'show' : '' }}"
                    id="menu-item__coupon_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.coupon.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Coupon List') }}</span></span></a></li>
                        <li><a href="{{ route('admin.offer') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Offer') }}</span></span></a></li>
                        <li><a href="{{ route('admin.offer-product') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Offer Product') }}</span></span></a></li>

                    </ul>
                </div>
            </li>

            <li class="{{ Route::is('admin.banner*') || Route::is('admin.promotional.banner.edit') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__banner_list"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.97101 5.02494L3.96358 4.50088C3.94817 3.39489 3.9914 2.91148 4.92274 2.31477C5.23372 2.11552 5.60348 2 6.00022 2H18.0002C19.1048 2 20.0002 2.89543 20.0002 4L20.0001 5.00025C20 6.10472 19.1046 7 18.0001 7H5.97051C4.87755 7 3.98673 6.11778 3.97101 5.02494Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.17268 10.5341H12M9.17268 13.3614H14.8273M9.17268 16.1888H14.8273M7.0522 7H16.9478C17.7285 7 18.3614 7.63291 18.3614 8.41365V19.1252C18.3614 20.1043 17.3902 20.7869 16.4689 20.4552L15.3651 20.0578C15.0201 19.9337 14.6404 19.9483 14.3061 20.0988L12.5801 20.8755C12.2112 21.0415 11.7888 21.0415 11.4199 20.8755L9.69388 20.0988C9.35956 19.9483 8.97987 19.9337 8.63493 20.0578L7.53104 20.4552C6.60981 20.7869 5.63855 20.1043 5.63855 19.1252V8.41365C5.63855 7.63291 6.27146 7 7.0522 7Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                </span>

                <span class="menu-bar__name">{{ __('translate.Manage Banner') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.banner*') || Route::is('admin.promotional.banner.edit') ? 'show' : '' }}"
                    id="menu-item__banner_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.banner') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Offer Deals') }}</span></span></a></li>
                        <li><a href="{{ route('admin.promotional.banner.edit') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Promotional Banner') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.withdraw-methods.*') || Route::is('admin.withdraw-list.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__withdraw_list"
                   aria-expanded="false"><span class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 10C11 8.89543 10.1046 8 9 8C7.89543 8 7 8.89543 7 10C7 11.1046 7.89543 12 9 12C10.1046 12 11 11.1046 11 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13 16C13 13.7909 11.2091 12 9 12C6.79086 12 5 13.7909 5 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.6084 11.0812H17.0792C16.7112 11.0812 16.4117 10.7815 16.4117 10.413C16.4117 10.0433 16.7107 9.74485 17.0791 9.74485C17.0825 9.74485 17.0859 9.74489 17.0893 9.74489H18.5537C18.8167 9.74753 19.0768 9.86565 19.2675 10.0693C19.534 10.3538 19.9807 10.3683 20.2652 10.1019C20.5497 9.83534 20.5643 9.38866 20.2978 9.10414C19.8433 8.61896 19.2106 8.33798 18.562 8.33313C18.5602 8.33313 18.5584 8.33313 18.5567 8.33313H18.5497V7.70588C18.5497 7.31605 18.2336 7 17.8438 7C17.454 7 17.1379 7.31605 17.1379 7.70588V8.33308C15.8568 8.33308 15 9.316 15 10.413C15 11.5599 15.9327 12.4929 17.0792 12.4929H18.6085C18.9765 12.4929 19.2759 12.7927 19.2759 13.1611C19.2759 13.5308 18.9769 13.8293 18.6086 13.8293C18.6052 13.8293 18.6017 13.8292 18.5984 13.8292H17.0006C16.8148 13.8273 16.6176 13.7603 16.4449 13.6405C16.1247 13.418 15.6848 13.4975 15.4625 13.8178C15.2402 14.138 15.3196 14.5778 15.6399 14.8001C16.1483 15.1531 16.6062 15.241 17.138 15.241V15.8682C17.138 16.258 17.454 16.5741 17.8439 16.5741C18.2337 16.5741 18.5497 16.258 18.5497 15.8682V15.241C19.8401 15.241 20.6877 14.2496 20.6877 13.1611C20.6876 12.0143 19.7549 11.0812 18.6084 11.0812Z" fill="currentColor"/>
                        </svg>

                </span>

                <span class="menu-bar__name">{{__('translate.Seller Withdraw')}}</span></span> <span
                        class="crancy__toggle"></span></a>
                <!-- Dropdown Menu -->
                <div
                    class="crancy__dropdown collapse {{ Route::is('admin.withdraw-methods.*') || Route::is('admin.withdraw-list.*') ? 'show' : '' }}"
                    id="menu-item__withdraw_list" data-bs-parent="#CrancyMenu" style="">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{route('admin.withdraw-methods.index')}}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{__('translate.Withdraw Method')}}</span></span></a></li>

                        <li><a href="{{route('admin.withdraw-list.index')}}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{__('translate.Withdraw List')}}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.deliveryman-withdraw-methods.*') || Route::is('admin.deliveryman-withdraw-list.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                   data-bs-target="#menu-item__withdraw_list_delivery" aria-expanded="false"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 6C14 8.20914 12.2091 10 10 10C7.79086 10 6 8.20914 6 6C6 3.79086 7.79086 2 10 2C12.2091 2 14 3.79086 14 6Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 14.8636C18 13.9599 17.1046 13.2273 16 13.2273C14.8954 13.2273 14 13.9599 14 14.8636C14 15.7674 14.8954 16.5 16 16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M16 16.5C17.1046 16.5 18 17.2326 18 18.1364C18 19.0401 17.1046 19.7727 16 19.7727C14.8954 19.7727 14 19.0401 14 18.1364" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M16 12V13.2273" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 19.7727V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 20H5C3.89543 20 3 19.1046 3 18C3 15.2386 5.23858 13 8 13H11.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                </span>

                <span class="menu-bar__name">{{__('translate.Delivery Withdraw')}}</span></span> <span
                        class="crancy__toggle"></span></a>
                <!-- Dropdown Menu -->
                <div
                    class="crancy__dropdown collapse {{ Route::is('admin.deliveryman-withdraw-methods.*') || Route::is('admin.deliveryman-withdraw-list.*') ? 'show' : '' }}"
                    id="menu-item__withdraw_list_delivery" data-bs-parent="#CrancyMenu" style="">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{route('admin.deliveryman-withdraw-methods.index')}}"><span
                                    class="menu-bar__text"><span class="menu-bar__name">{{__('translate.Withdraw Method')}}</span></span></a>
                        </li>

                        <li><a href="{{route('admin.deliveryman-withdraw-list.index')}}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{__('translate.Withdraw List')}}</span></span></a></li>

                    </ul>
                </div>
            </li>

            <li class="{{ Route::is('admin.user-list') || Route::is('admin.pending-user') || Route::is('admin.user-show') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__users"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.08069 15.2964C3.86241 16.0335 0.668176 17.5386 2.61368 19.422C3.56404 20.342 4.62251 21 5.95325 21H13.5468C14.8775 21 15.936 20.342 16.8863 19.422C18.8318 17.5386 15.6376 16.0335 14.4193 15.2964C11.5625 13.5679 7.93752 13.5679 5.08069 15.2964Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M17 5H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 8H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 11H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Manage User') }}</span></span> <span class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.user-list') || Route::is('admin.pending-user')  || Route::is('admin.user-show') ? 'show' : '' }}"
                    id="menu-item__users" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.user-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.User List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.pending-user') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Pending User') }}</span></span></a></li>


                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.contact-message') || Route::is('admin.show-message') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.contact-message') }}">
                <span class="menu-bar__text">
                    <span class="crancy-menu-icon crancy-svg-icon__v1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 11.8045C17 11.4588 17 11.286 17.052 11.132C17.2032 10.6844 17.6018 10.5108 18.0011 10.3289C18.45 10.1244 18.6744 10.0222 18.8968 10.0042C19.1493 9.98378 19.4022 10.0382 19.618 10.1593C19.9041 10.3198 20.1036 10.6249 20.3079 10.873C21.2513 12.0188 21.7229 12.5918 21.8955 13.2236C22.0348 13.7334 22.0348 14.2666 21.8955 14.7764C21.6438 15.6979 20.8485 16.4704 20.2598 17.1854C19.9587 17.5511 19.8081 17.734 19.618 17.8407C19.4022 17.9618 19.1493 18.0162 18.8968 17.9958C18.6744 17.9778 18.45 17.8756 18.0011 17.6711C17.6018 17.4892 17.2032 17.3156 17.052 16.868C17 16.714 17 16.5412 17 16.1955V11.8045Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M7 11.8046C7 11.3694 6.98778 10.9782 6.63591 10.6722C6.50793 10.5609 6.33825 10.4836 5.99891 10.329C5.55001 10.1246 5.32556 10.0224 5.10316 10.0044C4.43591 9.9504 4.07692 10.4058 3.69213 10.8732C2.74875 12.019 2.27706 12.5919 2.10446 13.2237C1.96518 13.7336 1.96518 14.2668 2.10446 14.7766C2.3562 15.6981 3.15152 16.4705 3.74021 17.1856C4.11129 17.6363 4.46577 18.0475 5.10316 17.996C5.32556 17.978 5.55001 17.8757 5.99891 17.6713C6.33825 17.5167 6.50793 17.4394 6.63591 17.3281C6.98778 17.0221 7 16.631 7 16.1957V11.8046Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M20 10.5V9C20 5.13401 16.4183 2 12 2C7.58172 2 4 5.13401 4 9V10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 17.5C20 22 16 22 12 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                    </span>
                    <span class="menu-bar__name">{{ __('translate.Contact Message') }}</span>
                </span>
                </a>
            </li>

            <h4 class="admin-menu__title pt-2">{{ __('translate.CMS & Blogs') }}</h4>

            <li class="{{ Route::is('admin.blog.*') || Route::is('admin.blog-category.*') || Route::is('admin.comment-list') || Route::is('admin.show-comment') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__blog"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.9165 10.5001C21.9351 10.6557 21.9495 10.8127 21.9598 10.9708C22.0134 11.801 22.0134 12.6608 21.9598 13.491C21.6856 17.7333 18.3536 21.1126 14.1706 21.3906C12.7435 21.4855 11.2536 21.4853 9.82937 21.3906C9.33893 21.358 8.80437 21.241 8.34398 21.0514C7.83174 20.8404 7.57557 20.7349 7.44541 20.7509C7.31524 20.7669 7.12637 20.9062 6.74865 21.1847C6.08265 21.6758 5.24364 22.0286 3.9994 21.9983C3.37023 21.983 3.05565 21.9753 2.91481 21.7352C2.77398 21.4951 2.94938 21.1627 3.30018 20.4979C3.78671 19.5759 4.09498 18.5204 3.62788 17.6747C2.8234 16.4667 2.14007 15.0361 2.04021 13.491C1.98656 12.6608 1.98656 11.801 2.04021 10.9708C2.31438 6.7285 5.64636 3.34925 9.82937 3.07119C11.0318 2.99126 12.2812 2.97868 13.5 3.0338" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.49997 15.0001H15.5M8.49997 10.0001H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20.8683 2.43946L21.5607 3.13183C22.1465 3.71761 22.1465 4.66736 21.5607 5.25315L17.9333 8.94881C17.6479 9.23416 17.2829 9.42652 16.8863 9.50061L14.6381 9.98865C14.2832 10.0657 13.9671 9.75054 14.0431 9.39537L14.5216 7.16005C14.5957 6.76336 14.7881 6.39836 15.0734 6.11301L18.747 2.43946C19.3328 1.85368 20.2825 1.85368 20.8683 2.43946Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Manage Blog') }}</span></span> <span class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.blog.*') || Route::is('admin.blog-category.*') || Route::is('admin.comment-list') || Route::is('admin.show-comment') ? 'show' : '' }}"
                    id="menu-item__blog" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.blog-category.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Categroy') }}</span></span></a></li>

                        <li><a href="{{ route('admin.blog-category.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Categroy List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.blog.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Blog') }}</span></span></a></li>

                        <li><a href="{{ route('admin.blog.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Blog List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.comment-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Comment List') }}</span></span></a></li>


                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.terms-conditions') || Route::is('admin.privacy-policy') || Route::is('admin.custom-page.*') || Route::is('admin.contact-us') || Route::is('admin.about-us') || Route::is('admin.login-image') || Route::is('admin.signup-image') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__pages"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2H6C3.79086 2 2 3.79086 2 6V18C2 20.2091 3.79086 22 6 22H12M12 2H18C20.2091 2 22 3.79086 22 6V18C22 20.2091 20.2091 22 18 22H12M12 2V22M15.5 6H18.5M5.5 6H8.5M15.5 10H18.5M5.5 10H8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 17.5C18 18.0523 17.5523 18.5 17 18.5C16.4477 18.5 16 18.0523 16 17.5C16 16.9477 16.4477 16.5 17 16.5C17.5523 16.5 18 16.9477 18 17.5Z" fill="currentColor"/>
                        <path d="M8 17.5C8 18.0523 7.55228 18.5 7 18.5C6.44772 18.5 6 18.0523 6 17.5C6 16.9477 6.44772 16.5 7 16.5C7.55228 16.5 8 16.9477 8 17.5Z" fill="currentColor"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Manage Pages') }}</span></span> <span class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.terms-conditions') || Route::is('admin.privacy-policy') || Route::is('admin.contact-us') || Route::is('admin.about-us') || Route::is('admin.login-image') || Route::is('admin.signup-image') ? 'show' : '' }}"
                    id="menu-item__pages" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.about-us', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.About Us') }}</span></span></a></li>

                        <li><a href="{{ route('admin.terms-conditions', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Terms and Conditions') }}</span></span></a></li>

                        <li><a href="{{ route('admin.privacy-policy', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Privacy Policy') }}</span></span></a></li>


                        <li><a href="{{ route('admin.contact-us', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Contact Us') }}</span></span></a></li>

                        <li><a href="{{ route('admin.login-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Login Page') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.intro-section') || Route::is('admin.join-restaurant') || Route::is('admin.mobile-app') || Route::is('admin.working-step') || Route::is('admin.counter') || Route::is('admin.header-footer') || Route::is('admin.footer') || Route::is('admin.home1-explore') || Route::is('admin.home2-explore') || Route::is('admin.home3-explore') || Route::is('admin.safety-tips') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__for_section"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.6 12.8L6 13.25H6L6.6 12.8ZM7.8 14.4L8.4 13.95L7.8 14.4ZM14.2 14.4L13.6 13.95L14.2 14.4ZM15.4 12.8L14.8 12.35L14.8 12.35L15.4 12.8ZM8 8.25C7.58579 8.25 7.25 8.58579 7.25 9C7.25 9.41421 7.58579 9.75 8 9.75V8.25ZM11 9.75C11.4142 9.75 11.75 9.41421 11.75 9C11.75 8.58579 11.4142 8.25 11 8.25V9.75ZM8 4.25C7.58579 4.25 7.25 4.58579 7.25 5C7.25 5.41421 7.58579 5.75 8 5.75V4.25ZM14 5.75C14.4142 5.75 14.75 5.41421 14.75 5C14.75 4.58579 14.4142 4.25 14 4.25V5.75ZM21 15H20.25V18H21H21.75V15H21ZM18 21V20.25H4V21V21.75H18V21ZM1 18H1.75V15H1H0.25V18H1ZM4 12V12.75H5V12V11.25H4V12ZM6.6 12.8L6 13.25L7.2 14.85L7.8 14.4L8.4 13.95L7.2 12.35L6.6 12.8ZM17 12V12.75H18V12V11.25H17V12ZM14.2 14.4L14.8 14.85L16 13.25L15.4 12.8L14.8 12.35L13.6 13.95L14.2 14.4ZM11 16V16.75C12.4951 16.75 13.9029 16.0461 14.8 14.85L14.2 14.4L13.6 13.95C12.9862 14.7684 12.023 15.25 11 15.25V16ZM17 12V11.25C16.1344 11.25 15.3194 11.6575 14.8 12.35L15.4 12.8L16 13.25C16.2361 12.9352 16.6066 12.75 17 12.75V12ZM7.8 14.4L7.2 14.85C8.09706 16.0461 9.5049 16.75 11 16.75V16V15.25C9.97704 15.25 9.01378 14.7684 8.4 13.95L7.8 14.4ZM5 12V12.75C5.39345 12.75 5.76393 12.9352 6 13.25L6.6 12.8L7.2 12.35C6.68065 11.6575 5.86558 11.25 5 11.25V12ZM4 21V20.25C2.75736 20.25 1.75 19.2426 1.75 18H1H0.25C0.25 20.0711 1.92893 21.75 4 21.75V21ZM21 18H20.25C20.25 19.2426 19.2426 20.25 18 20.25V21V21.75C20.0711 21.75 21.75 20.0711 21.75 18H21ZM21 15H21.75C21.75 12.9289 20.0711 11.25 18 11.25V12V12.75C19.2426 12.75 20.25 13.7574 20.25 15H21ZM1 15H1.75C1.75 13.7574 2.75736 12.75 4 12.75V12V11.25C1.92893 11.25 0.25 12.9289 0.25 15H1ZM19 12H19.75V5H19H18.25V12H19ZM15 1V0.25H7V1V1.75H15V1ZM3 5H2.25V12H3H3.75V5H3ZM7 1V0.25C4.37665 0.25 2.25 2.37665 2.25 5H3H3.75C3.75 3.20507 5.20507 1.75 7 1.75V1ZM19 5H19.75C19.75 2.37665 17.6234 0.25 15 0.25V1V1.75C16.7949 1.75 18.25 3.20507 18.25 5H19ZM8 9V9.75H11V9V8.25H8V9ZM8 5V5.75H14V5V4.25H8V5Z" fill="currentColor"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Manage Section') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.intro-section') || Route::is('admin.join-restaurant') || Route::is('admin.mobile-app') || Route::is('admin.working-step') || Route::is('admin.counter') || Route::is('admin.footer-image-gallery*') || Route::is('admin.footer') || Route::is('admin.header-footer') || Route::is('admin.home1-explore') || Route::is('admin.home2-explore') || Route::is('admin.home3-explore') || Route::is('admin.safety-tips') ? 'show' : '' }}"
                    id="menu-item__for_section" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.intro-section', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Intro Section') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.working-step', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Working Step') }}</span></span></a>
                        </li>


                        <li><a href="{{ route('admin.join-restaurant', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Join Restaurant') }}</span></span></a></li>


                        <li><a href="{{ route('admin.mobile-app', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Mobile App') }}</span></span></a></li>

                        <li><a href="{{ route('admin.footer-image-gallery') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Footer Image Gallery') }}</span></span></a></li>

                        <li><a href="{{ route('admin.footer', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Footer Info') }}</span></span></a></li>


                    </ul>
                </div>
            </li>


            <h4 class="admin-menu__title pt-2">{{ __('translate.Setting & Configuration') }}</h4>


            <li class="{{ Route::is('admin.general-setting') ? 'active' : '' }}"><a class="collapsed"
                                                                                    href="{{ route('admin.general-setting') }}"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.7155 16.134L21.0758 15.7423L21.7155 16.134ZM20.6548 17.866L21.2945 18.2577V18.2577L20.6548 17.866ZM2.28455 7.86602L1.64493 7.47436L1.64493 7.47436L2.28455 7.86602ZM3.34516 6.13397L3.98477 6.52563H3.98477L3.34516 6.13397ZM6.2428 5.40192L6.60138 4.74319L6.60138 4.74319L6.2428 5.40192ZM3.06097 10.5981L2.70238 11.2568H2.70238L3.06097 10.5981ZM17.7572 18.5981L17.3986 19.2568H17.3986L17.7572 18.5981ZM20.939 13.4019L20.5805 14.0606L20.939 13.4019ZM3.34515 17.866L2.70554 18.2577H2.70554L3.34515 17.866ZM2.28454 16.134L2.92415 15.7423L2.92415 15.7423L2.28454 16.134ZM20.6548 6.13398L21.2945 5.74232V5.74232L20.6548 6.13398ZM21.7155 7.86603L21.0758 8.25769V8.25769L21.7155 7.86603ZM20.939 10.5981L21.2976 11.2568H21.2976L20.939 10.5981ZM17.7572 5.40193L18.1158 6.06066V6.06066L17.7572 5.40193ZM3.06096 13.4019L3.41955 14.0607H3.41955L3.06096 13.4019ZM6.24279 18.5981L5.88422 17.9394L5.88421 17.9394L6.24279 18.5981ZM17.6445 5.46331L17.2859 4.80458V4.80458L17.6445 5.46331ZM6.35556 5.4633L5.99697 6.12202H5.99697L6.35556 5.4633ZM17.6445 18.5367L18.003 17.878L18.003 17.878L17.6445 18.5367ZM6.35556 18.5367L6.71413 19.1954L6.71414 19.1954L6.35556 18.5367ZM10.9394 2.75H13.0606V1.25H10.9394V2.75ZM13.0606 21.25H10.9394V22.75H13.0606V21.25ZM10.9394 21.25C10.1399 21.25 9.56817 20.6494 9.56817 20H8.06817C8.06817 21.5598 9.39585 22.75 10.9394 22.75V21.25ZM14.4318 20C14.4318 20.6494 13.8601 21.25 13.0606 21.25V22.75C14.6042 22.75 15.9318 21.5598 15.9318 20H14.4318ZM13.0606 2.75C13.8601 2.75 14.4318 3.35061 14.4318 4H15.9318C15.9318 2.44025 14.6041 1.25 13.0606 1.25V2.75ZM10.9394 1.25C9.39585 1.25 8.06817 2.44025 8.06817 4H9.56817C9.56817 3.35061 10.1399 2.75 10.9394 2.75V1.25ZM21.0758 15.7423L20.0152 17.4744L21.2945 18.2577L22.3551 16.5256L21.0758 15.7423ZM2.92416 8.25768L3.98477 6.52563L2.70554 5.74231L1.64493 7.47436L2.92416 8.25768ZM3.98477 6.52563C4.35198 5.92594 5.20337 5.69002 5.88421 6.06064L6.60138 4.74319C5.25309 4.00924 3.50985 4.42882 2.70554 5.74231L3.98477 6.52563ZM3.41955 9.93934C2.7621 9.58146 2.57418 8.82922 2.92416 8.25768L1.64493 7.47436C0.823397 8.81599 1.3307 10.5101 2.70238 11.2568L3.41955 9.93934ZM20.0152 17.4744C19.648 18.074 18.7966 18.31 18.1158 17.9393L17.3986 19.2568C18.7469 19.9907 20.4902 19.5712 21.2945 18.2577L20.0152 17.4744ZM22.3551 16.5256C23.1766 15.184 22.6693 13.4899 21.2976 12.7432L20.5805 14.0606C21.2379 14.4185 21.4258 15.1708 21.0758 15.7423L22.3551 16.5256ZM3.98476 17.4744L2.92415 15.7423L1.64493 16.5256L2.70554 18.2577L3.98476 17.4744ZM20.0152 6.52564L21.0758 8.25769L22.3551 7.47437L21.2945 5.74232L20.0152 6.52564ZM21.0758 8.25769C21.4258 8.82923 21.2379 9.58147 20.5805 9.93936L21.2976 11.2568C22.6693 10.5101 23.1766 8.816 22.3551 7.47437L21.0758 8.25769ZM18.1158 6.06066C18.7966 5.69004 19.648 5.92596 20.0152 6.52564L21.2945 5.74232C20.4902 4.42884 18.7469 4.00926 17.3986 4.74321L18.1158 6.06066ZM2.92415 15.7423C2.57417 15.1708 2.7621 14.4185 3.41955 14.0607L2.70238 12.7432C1.3307 13.4899 0.823395 15.184 1.64493 16.5256L2.92415 15.7423ZM2.70554 18.2577C3.50985 19.5712 5.25309 19.9908 6.60138 19.2568L5.88421 17.9394C5.20337 18.31 4.35198 18.0741 3.98476 17.4744L2.70554 18.2577ZM18.003 6.12203L18.1158 6.06066L17.3986 4.74321L17.2859 4.80458L18.003 6.12203ZM5.88421 6.06064L5.99697 6.12202L6.71414 4.80457L6.60138 4.74319L5.88421 6.06064ZM18.1158 17.9393L18.003 17.878L17.2859 19.1954L17.3986 19.2568L18.1158 17.9393ZM5.99698 17.878L5.88422 17.9394L6.60137 19.2568L6.71413 19.1954L5.99698 17.878ZM2.70238 11.2568C3.2912 11.5773 3.29121 12.4227 2.70238 12.7432L3.41955 14.0607C5.05215 13.1719 5.05215 10.8281 3.41955 9.93934L2.70238 11.2568ZM6.71414 19.1954C7.32456 18.8631 8.06817 19.305 8.06817 20H9.56817C9.56817 18.167 7.60692 17.0016 5.99697 17.878L6.71414 19.1954ZM15.9318 20C15.9318 19.305 16.6755 18.8631 17.2859 19.1954L18.003 17.878C16.3931 17.0016 14.4318 18.167 14.4318 20H15.9318ZM21.2976 12.7432C20.7088 12.4227 20.7088 11.5773 21.2976 11.2568L20.5805 9.93936C18.9479 10.8281 18.9479 13.1719 20.5805 14.0606L21.2976 12.7432ZM5.99697 6.12202C7.60692 6.99841 9.56817 5.83303 9.56817 4H8.06817C8.06817 4.695 7.32456 5.13686 6.71414 4.80457L5.99697 6.12202ZM17.2859 4.80458C16.6755 5.13687 15.9318 4.69501 15.9318 4H14.4318C14.4318 5.83303 16.3931 6.99842 18.003 6.12203L17.2859 4.80458ZM14.5833 12C14.5833 13.4267 13.4267 14.5833 12 14.5833V16.0833C14.2552 16.0833 16.0833 14.2552 16.0833 12H14.5833ZM12 14.5833C10.5733 14.5833 9.41668 13.4267 9.41668 12H7.91668C7.91668 14.2552 9.74485 16.0833 12 16.0833V14.5833ZM9.41668 12C9.41668 10.5733 10.5733 9.41667 12 9.41667V7.91667C9.74485 7.91667 7.91668 9.74484 7.91668 12H9.41668ZM12 9.41667C13.4267 9.41667 14.5833 10.5733 14.5833 12H16.0833C16.0833 9.74484 14.2552 7.91667 12 7.91667V9.41667Z"
                            fill="currentColor"/>
                    </svg>
                </span>
                <span class="menu-bar__name">{{ __('translate.Setting') }}</span></span></a>
            </li>

            <li class="{{ Route::is('admin.multi-currency.*') ? 'active' : '' }}">
            <a class="collapsed" href="{{ route('admin.multi-currency.index') }}">
                <span class="menu-bar__text">
                    <span class="crancy-menu-icon crancy-svg-icon__v1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1668_55)">
                            <path d="M8.29266 6.82585H6.76339C6.39539 6.82585 6.09595 6.52609 6.09595 6.15766C6.09595 5.78797 6.39492 5.48948 6.76329 5.48948C6.76673 5.48948 6.77012 5.48952 6.77355 5.48952H8.23798C8.50094 5.49216 8.76099 5.61028 8.95172 5.81395C9.21826 6.09846 9.66494 6.11296 9.94946 5.84651C10.234 5.57997 10.2486 5.13329 9.98202 4.84877C9.52753 4.36359 8.89487 4.08261 8.24621 4.07776C8.24442 4.07776 8.24268 4.07776 8.24094 4.07776H8.23393V3.45051C8.23393 3.06068 7.91788 2.74463 7.52805 2.74463C7.13821 2.74463 6.82216 3.06068 6.82216 3.45051V4.07771C5.54099 4.07771 4.68423 5.06063 4.68423 6.15762C4.68423 7.30449 5.61694 8.23757 6.76343 8.23757H8.29271C8.66071 8.23757 8.96014 8.53729 8.96014 8.90571C8.96014 9.27545 8.66118 9.5739 8.29285 9.5739C8.28941 9.5739 8.28598 9.57385 8.28259 9.57385H6.6848C6.49906 9.57197 6.30183 9.50496 6.12918 9.3851C5.80889 9.16265 5.36908 9.24209 5.14678 9.56242C4.92447 9.88265 5.00381 10.3225 5.32409 10.5448C5.83252 10.8978 6.29045 10.9856 6.82221 10.9856V11.6128C6.82221 12.0027 7.13826 12.3187 7.52809 12.3187C7.91793 12.3187 8.23398 12.0027 8.23398 11.6128V10.9856C9.52438 10.9856 10.3719 9.99418 10.3719 8.90571C10.3719 7.75889 9.43915 6.82585 8.29266 6.82585Z" fill="currentColor"/>
                            <path d="M14.8918 9.104C15.8915 4.39628 12.2852 0 7.52809 0C3.37708 0 0 3.37878 0 7.53181C0 12.2915 4.39774 15.9055 9.10918 14.897C8.11012 19.588 11.701 24 16.472 24C20.6229 24 24 20.6213 24 16.4682C24 11.7099 19.6027 8.09318 14.8918 9.104ZM1.41176 7.53181C1.41176 4.15722 4.15553 1.41176 7.52809 1.41176C11.7741 1.41176 14.7432 5.66546 13.2665 9.65449C11.6841 10.4026 10.4027 11.6864 9.65708 13.2707C5.67172 14.7542 1.41176 11.7869 1.41176 7.53181ZM16.472 22.5882C13.0994 22.5882 10.3557 19.8428 10.3557 16.4682C10.3557 13.0937 13.0994 10.3483 16.472 10.3483C19.8445 10.3483 22.5882 13.0937 22.5882 16.4682C22.5882 19.8428 19.8445 22.5882 16.472 22.5882Z" fill="currentColor"/>
                            <path d="M18.8807 18.9434C17.8953 18.6306 16.8655 18.5312 15.8505 18.6464C15.9936 18.2075 16.0944 17.7572 16.1524 17.3001H16.9983C17.3881 17.3001 17.7041 16.984 17.7041 16.5942C17.7041 16.2043 17.3881 15.8883 16.9983 15.8883H16.1946C16.1801 15.6651 16.1711 15.6014 16.1113 15.0562C16.0123 14.1525 17.134 13.6692 17.7278 14.3389C17.9864 14.6306 18.4326 14.6576 18.7243 14.3988C19.016 14.1402 19.0428 13.694 18.7841 13.4023C17.2861 11.7125 14.4586 12.9377 14.708 15.21C14.7717 15.791 14.7669 15.7389 14.7789 15.8882H14.2769C13.887 15.8882 13.571 16.2043 13.571 16.5941C13.571 16.984 13.887 17.3 14.2769 17.3H14.7261C14.6175 17.9871 14.3884 18.6528 14.0431 19.2725C13.7382 19.8197 14.2478 20.4657 14.851 20.2955C16.0463 19.9591 17.1609 19.8784 18.4536 20.2889C18.8246 20.4067 19.2219 20.2018 19.34 19.8297C19.4578 19.4581 19.2522 19.0613 18.8807 18.9434Z" fill="currentColor"/>
                            <path d="M17.5294 2.21987C18.9126 2.21987 20.3826 3.26434 20.3826 5.20001V5.86467L19.7469 5.22862C19.4714 4.95286 19.0244 4.95286 18.7487 5.22834C18.4729 5.50392 18.4728 5.95088 18.7484 6.2266L20.5892 8.06848C20.8623 8.34189 21.3106 8.34589 21.5877 8.06848L23.4286 6.2266C23.7042 5.95088 23.7041 5.50396 23.4283 5.22834C23.1526 4.95272 22.7057 4.95286 22.4301 5.22862L21.7943 5.86472V5.20001C21.7943 2.63196 19.8434 0.808105 17.5293 0.808105C17.1394 0.808105 16.8234 1.12415 16.8234 1.51399C16.8234 1.90382 17.1395 2.21987 17.5294 2.21987Z" fill="currentColor"/>
                            <path d="M6.47064 21.7801C5.08744 21.7801 3.61737 20.7356 3.61737 18.8V18.1353L4.25313 18.7714C4.52866 19.047 4.97553 19.0473 5.25139 18.7716C5.52716 18.4961 5.52725 18.0491 5.25167 17.7734L3.41078 15.9315C3.1377 15.6578 2.68847 15.6547 2.41229 15.9315L0.571297 17.7734C0.29572 18.0492 0.295814 18.4961 0.571579 18.7717C0.84725 19.0473 1.29421 19.0472 1.56984 18.7714L2.2056 18.1353V18.8C2.2056 21.3681 4.15652 23.1919 6.47064 23.1919C6.86047 23.1919 7.17652 22.8758 7.17652 22.486C7.17652 22.0962 6.86047 21.7801 6.47064 21.7801Z" fill="currentColor"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1668_55">
                            <rect width="24" height="24" fill="white"/>
                            </clipPath>
                            </defs>
                            </svg>

                    </span>
                    <span class="menu-bar__name">{{ __('translate.Multi Currency') }}</span>
                </span>

            </a>
            </li>

            <li class="{{ Route::is('admin.language.*') || Route::is('admin.theme-language') ? 'active' : '' }}"><a
                    href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__languages"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_1668_64" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                        <path d="M0 0H20V20H0V0Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0_1668_64)">
                        <path d="M19.4141 10.2363V18.243C19.4141 18.8898 18.8898 19.4141 18.243 19.4141H10.2363C9.58944 19.4141 9.06483 18.8898 9.06483 18.243V10.9352H9.76366C10.4105 10.9352 10.9351 10.4105 10.9351 9.76367V9.06484H13.9242C14.7684 6.93164 16.8269 6.72266 16.8269 6.72266V9.06484H18.243C18.8898 9.06484 19.4141 9.58945 19.4141 10.2363Z" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.9352 1.75703V9.76367C10.9352 10.4105 10.4105 10.9352 9.76367 10.9352H6.07578C5.23164 13.0684 3.17305 13.2773 3.17305 13.2773V10.9352H1.75703C1.11016 10.9352 0.585938 10.4105 0.585938 9.76367V1.75703C0.585938 1.11016 1.11016 0.585937 1.75703 0.585937H9.76367C10.4105 0.585937 10.9352 1.11016 10.9352 1.75703Z" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.4084 4.34918H8.1125" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.76045 4.34918V3.40836" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.58443 4.34921C4.58443 8.11249 8.11251 8.11249 8.11251 8.11249" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.93649 4.34921C6.93649 8.11249 3.4084 8.11249 3.4084 8.11249" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.8875 16.5916L14.2396 11.8875L16.5916 16.5916" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.4755 15.4156H16.0036" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linejoin="round"/>
                        <path d="M14.1102 1.76196H14.6982C17.2962 1.76196 19.4023 3.86806 19.4023 6.46606" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14.6982 2.93799L13.5222 1.76197L14.6982 0.585918" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.87806 18.2263H5.29005C2.69205 18.2263 0.585953 16.1202 0.585953 13.5222" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.29004 17.0503L6.46605 18.2263L5.29004 19.4023" stroke="currentColor" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Language') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.language.*') || Route::is('admin.theme-language') ? 'show' : '' }}"
                    id="menu-item__languages" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.language.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Languages') }}</span></span></a></li>

                        <li><a href="{{ route('admin.theme-language', ['lang_code' => 'en']) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Theme Languages') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.email-setting') || Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__apps_email_config"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 7.5L9.94202 9.23943C11.6572 10.2535 12.3428 10.2535 14.058 9.23943L17 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 19.5C11 19.5 10.0691 19.4878 9.09883 19.4634C5.95033 19.3843 4.37608 19.3448 3.24496 18.2094C2.11383 17.0739 2.08114 15.5412 2.01577 12.4756C1.99475 11.4899 1.99474 10.5101 2.01576 9.52438C2.08114 6.45885 2.11382 4.92608 3.24495 3.79065C4.37608 2.65521 5.95033 2.61566 9.09882 2.53656C11.0393 2.48781 12.9607 2.48781 14.9012 2.53657C18.0497 2.61568 19.6239 2.65523 20.7551 3.79066C21.8862 4.92609 21.9189 6.45886 21.9842 9.52439C21.9918 9.88124 21.9967 10.4995 21.9988 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 20.2143V21.5M18 20.2143C16.8432 20.2143 15.8241 19.6461 15.2263 18.7833M18 20.2143C19.1568 20.2143 20.1759 19.6461 20.7737 18.7833M15.2263 18.7833L14.0004 19.5714M15.2263 18.7833C14.8728 18.273 14.6667 17.6597 14.6667 17C14.6667 16.3403 14.8727 15.7271 15.2262 15.2169M20.7737 18.7833L21.9996 19.5714M20.7737 18.7833C21.1272 18.273 21.3333 17.6597 21.3333 17C21.3333 16.3403 21.1273 15.7271 20.7738 15.2169M18 13.7857C19.1569 13.7857 20.1761 14.354 20.7738 15.2169M18 13.7857C16.8431 13.7857 15.8239 14.354 15.2262 15.2169M18 13.7857V12.5M20.7738 15.2169L22 14.4286M15.2262 15.2169L14 14.4286" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Email Configuration') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.email-setting') || Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'show' : '' }}"
                    id="menu-item__apps_email_config" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.email-setting') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Configuration') }}</span></span></a></li>

                        <li><a href="{{ route('admin.email-template') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Email Template') }}</span></span></a></li>


                    </ul>
                </div>
            </li>

            @include('smssetting::sidebar')


            <li class="{{ Route::is('admin.cookie-consent') || Route::is('admin.error-image')  || Route::is('admin.breadcrumb') || Route::is('admin.social-login') || Route::is('admin.default-avatar') || Route::is('admin.maintenance-mode') || Route::is('admin.admin-login-image') || Route::is('admin.default-cover-image') || Route::is('admin.pwa-icon-settings') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__apps"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.0029 2H10.0062C6.72443 2 5.08355 2 3.92039 2.81382C3.49006 3.1149 3.11577 3.48891 2.81445 3.91891C2 5.08116 2 6.72077 2 10C2 13.2792 2 14.9188 2.81445 16.0811C3.11577 16.5111 3.49006 16.8851 3.92039 17.1862C5.08355 18 6.72443 18 10.0062 18H14.0093C17.2911 18 18.932 18 20.0951 17.1862C20.5254 16.8851 20.8997 16.5111 21.2011 16.0811C21.8156 15.2042 21.9663 14.0941 22 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M18 9.71428V11M18 9.71428C16.8432 9.71428 15.8241 9.14608 15.2263 8.28331M18 9.71428C19.1568 9.71428 20.1759 9.14608 20.7737 8.28331M15.2263 8.28331L14.0004 9.07143M15.2263 8.28331C14.8728 7.77304 14.6667 7.15973 14.6667 6.5C14.6667 5.84035 14.8727 5.22711 15.2262 4.71688M20.7737 8.28331L21.9996 9.07143M20.7737 8.28331C21.1272 7.77304 21.3333 7.15973 21.3333 6.5C21.3333 5.84035 21.1273 5.22711 20.7738 4.71688M18 3.28571C19.1569 3.28571 20.1761 3.854 20.7738 4.71688M18 3.28571C16.8431 3.28571 15.8239 3.854 15.2262 4.71688M18 3.28571V2M20.7738 4.71688L22 3.92857M15.2262 4.71688L14 3.92857" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M11 15H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 18V22" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M8 22H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Website Setup') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.cookie-consent') || Route::is('admin.error-image') || Route::is('admin.breadcrumb') || Route::is('admin.social-login') || Route::is('admin.default-avatar') || Route::is('admin.maintenance-mode') || Route::is('admin.admin-login-image') || Route::is('admin.default-cover-image') || Route::is('admin.pwa-icon-settings') || Route::is('admin.screens.get') ? 'show' : '' }}"
                    id="menu-item__apps" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.cookie-consent') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Cookie Consent') }}</span></span></a></li>

                        <li><a href="{{ route('admin.error-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Error Page') }}</span></span></a></li>

                        <li><a href="{{ route('admin.admin-login-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Admin Login') }}</span></span></a></li>

                        <li><a href="{{ route('admin.breadcrumb') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Breadcrumb Image') }}</span></span></a></li>

                        <li><a href="{{ route('admin.social-login') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Social Login') }}</span></span></a></li>


                        <li><a href="{{ route('admin.default-avatar') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Default Avatar') }}</span></span></a></li>

                        <li><a href="{{ route('admin.default-cover-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Default Cover Image') }}</span></span></a></li>

                        <li><a href="{{ route('admin.screens.get') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Splash Screens') }}</span></span></a></li>

                        <li><a href="{{ route('admin.deliveryman-splash-screen.get') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Delivery Man Splash Screen') }}</span></span></a></li>
                                        
                        <li><a href="{{ route('admin.pwa-icon-settings') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.PWA Icon Settings') }}</span></span></a></li>

                        <li><a href="{{ route('admin.maintenance-mode') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Maintenance mode') }}</span></span></a></li>

                    </ul>
                </div>
            </li>

            <li class="{{ Route::is('admin.seo-setting') ? 'active' : '' }}"><a class="collapsed"
                                                                                href="{{ route('admin.seo-setting') }}"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.5 17.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M9.4924 7.5C8.77591 7.54342 8.31993 7.66286 7.99139 7.99139C7.66286 8.31993 7.54342 8.77591 7.5 9.4924M12.5076 7.5C13.2241 7.54342 13.6801 7.66286 14.0086 7.99139C14.3371 8.31993 14.4566 8.77591 14.5 9.4924M14.4923 12.6214C14.4431 13.273 14.3194 13.6978 14.0086 14.0086C13.6801 14.3371 13.2241 14.4566 12.5076 14.5M9.4924 14.5C8.7759 14.4566 8.31993 14.3371 7.99139 14.0086C7.6806 13.6978 7.55693 13.273 7.50772 12.6214" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>


                </span>
                <span class="menu-bar__name">{{ __('translate.SEO Setup') }}</span></span></a>
            </li>

            <li class="{{ Route::is('admin.paymentgateway') ? 'active' : '' }}"><a class="collapsed"
                                                                                   href="{{ route('admin.paymentgateway') }}"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 14C16 14.8284 16.6716 15.5 17.5 15.5C18.3284 15.5 19 14.8284 19 14C19 13.1716 18.3284 12.5 17.5 12.5C16.6716 12.5 16 13.1716 16 14Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M4 20C2.89543 20 2 19.1046 2 18C2 16.8954 2.89543 16 4 16C5.10457 16 6 17.3333 6 18C6 18.6667 5.10457 20 4 20Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M8 20C6.89543 20 6 18.5 6 18C6 17.5 6.89543 16 8 16C9.10457 16 10 16.8954 10 18C10 19.1046 9.10457 20 8 20Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M13 20H16C18.8284 20 20.2426 20 21.1213 19.1213C22 18.2426 22 16.8284 22 14V13C22 10.1716 22 8.75736 21.1213 7.87868C20.48 7.23738 19.5534 7.06413 18 7.01732M18 7.01732C17.425 7 16.7641 7 16 7H10M18 7.01732C18 6.06917 18 5.5951 17.8425 5.22208C17.6399 4.7421 17.2579 4.36014 16.7779 4.15749C16.4049 4 15.9308 4 14.9827 4H10C6.22876 4 4.34315 4 3.17157 5.17157C2 6.34315 2 7.22876 2 11V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Payment Method') }}</span></span></a>
            </li>

        </ul>
    </div>
    <!-- End Nav Menu -->
</div>


<div class="crancy-sidebar-padding pd-btm-40 pb-btm2">
    <h4 class="admin-menu__title">{{ __('translate.Others') }}</h4>
    <!-- Nav Menu -->
    <div class="menu-bar">
        <ul class="menu-bar__one crancy-dashboard-menu" id="CrancyMenu">
            <li class="{{ Route::is('admin.subscriber-list') || Route::is('admin.subscriber-email') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                   data-bs-target="#menu-item__apps_newsletter"><span class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 8H18.5M10.5 12H13M18.5 12H16M10.5 16H13M18.5 16H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 7.5H6C4.11438 7.5 3.17157 7.5 2.58579 8.08579C2 8.67157 2 9.61438 2 11.5V18C2 19.3807 3.11929 20.5 4.5 20.5C5.88071 20.5 7 19.3807 7 18V7.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.5H11C10.07 3.5 9.60504 3.5 9.22354 3.60222C8.18827 3.87962 7.37962 4.68827 7.10222 5.72354C7 6.10504 7 6.57003 7 7.5V18C7 19.3807 5.88071 20.5 4.5 20.5H16C18.8284 20.5 20.2426 20.5 21.1213 19.6213C22 18.7426 22 17.3284 22 14.5V9.5C22 6.67157 22 5.25736 21.1213 4.37868C20.2426 3.5 18.8284 3.5 16 3.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>


                </span>
                <span class="menu-bar__name">{{ __('translate.Newsletter') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.subscriber-list') || Route::is('admin.subscriber-email') ? 'show' : '' }}"
                    id="menu-item__apps_newsletter" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.subscriber-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Subscriber List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.subscriber-email') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Send Mail') }}</span></span></a></li>

                    </ul>
                </div>
            </li>

            <li class="{{ Route::is('admin.menus.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                   data-bs-target="#menu-item__menus"><span class="menu-bar__text">
                    <span class="crancy-menu-icon crancy-svg-icon__v1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                <span class="menu-bar__name">{{ __('translate.Menu Management') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div
                    class="collapse crancy__dropdown {{ Route::is('admin.menus.*') ? 'show' : '' }}"
                    id="menu-item__menus" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.menus.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Menu List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.menus.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Menu') }}</span></span></a></li>

                    </ul>
                </div>
            </li>




            <li><a class="collapsed" href="{{ route('admin.cache-clear') }}"><span class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M21.6805 5.42846C21.3463 5.19352 20.8912 5.2823 20.6635 5.62676L19.1708 7.88444C18.783 6.02074 17.8848 4.30822 16.5482 2.92959C14.7168 1.04041 12.2819 0 9.69185 0C7.10188 0 4.66687 1.04041 2.83548 2.92959C-0.945161 6.82953 -0.945161 13.1752 2.83548 17.075C4.72581 19.025 7.20883 20 9.69185 20C12.1749 20 14.6579 19.025 16.5482 17.075C16.834 16.7802 16.834 16.3022 16.5482 16.0073C16.2624 15.7125 15.799 15.7125 15.5133 16.0073C12.3033 19.3185 7.08051 19.3185 3.87061 16.0073C0.660715 12.6962 0.660715 7.30837 3.87061 3.99718C5.42555 2.39328 7.49289 1.50989 9.69195 1.50989C11.891 1.50989 13.9584 2.39328 15.5133 3.99728C16.7134 5.23519 17.4956 6.79068 17.7908 8.47934L15.1929 6.65157C14.859 6.41663 14.4037 6.50541 14.176 6.84987C13.9482 7.19432 14.0343 7.664 14.3682 7.89894L18.2435 10.6255C18.2437 10.6256 18.2439 10.6258 18.2441 10.626C18.3054 10.6691 18.3707 10.7008 18.438 10.7224C18.44 10.7231 18.442 10.7242 18.444 10.7248C18.4554 10.7285 18.467 10.7299 18.4786 10.7329C18.5371 10.748 18.5964 10.7573 18.6558 10.7573C18.8896 10.7573 19.1194 10.6419 19.2611 10.4277L21.8727 6.47763C22.1004 6.13307 22.0144 5.66339 21.6805 5.42846Z"
                    fill="currentColor"/>
                </svg>

                </span>
                <span class="menu-bar__name">{{ __('translate.Cache Clear') }}</span></span></a>
            </li>

            <li><a href="javascript:;" onclick="event.preventDefault();
                document.getElementById('admin-sidebar-logout').submit();" class="collapsed"><span
                        class="menu-bar__text">
                <span class="crancy-menu-icon crancy-svg-icon__v1">
                    <svg class="crancy-svg-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="18"
                         viewBox="0 0 22 18" fill="none">
                        <path d="M19 11L20.2929 9.70711C20.6834 9.31658 20.6834 8.68342 20.2929 8.29289L19 7"
                              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path
                            d="M20 9H12M5 17C2.79086 17 1 15.2091 1 13V5C1 2.79086 2.79086 1 5 1M5 17C7.20914 17 9 15.2091 9 13V5C9 2.79086 7.20914 1 5 1M5 17H13C15.2091 17 17 15.2091 17 13M5 1H13C15.2091 1 17 2.79086 17 5"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="menu-bar__name">{{ __('translate.Logout') }}</span></span></a>
            </li>

            <form id="admin-sidebar-logout" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </ul>
    </div>
    <!-- End Nav Menu -->
    <!-- Support Card -->
    <p class=" crancy-ybcolor mg-top-20">{{ __('translate.Version') }} : {{ $general_setting->app_version }}</p>
    <!-- End Support Card -->
</div>
