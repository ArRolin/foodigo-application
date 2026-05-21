<div class="dashboard_sideber">
    <div class="dashboard_profile">
        <div class="dashboard_profile_thumb_main">
            <div class="dashboard_profile_thumb">
                <img src="{{ asset($user->image) }}" alt="thumb">
            </div>
        </div>

        <div class="dashboard_profile_txt">
            <a href="javascript:;">
                {{$user->name}}
            </a>

            <p>{{ __('translate.User ID') }}: #{{$user->readable_id}}</p>

        </div>

    </div>


    <ul class="dashboard_profile_btn">
        <li>
            <a href="{{route('user.dashboard')}}" class="{{ Route::is('user.dashboard') ? 'active' : '' }}">
                <span>
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 4C7 5.65685 5.65685 7 4 7C2.34315 7 1 5.65685 1 4C1 2.34315 2.34315 1 4 1C5.65685 1 7 2.34315 7 4Z"
                            stroke="#0C1321" stroke-width="1.5"/>
                        <path
                            d="M17 14C17 15.6569 15.6569 17 14 17C12.3431 17 11 15.6569 11 14C11 12.3431 12.3431 11 14 11C15.6569 11 17 12.3431 17 14Z"
                            stroke="#0C1321" stroke-width="1.5"/>
                        <path
                            d="M11 3C11 1.89543 11.8954 1 13 1H15C16.1046 1 17 1.89543 17 3V5C17 6.10457 16.1046 7 15 7H13C11.8954 7 11 6.10457 11 5V3Z"
                            stroke="#0C1321" stroke-width="1.5"/>
                        <path
                            d="M1 13C1 11.8954 1.89543 11 3 11H5C6.10457 11 7 11.8954 7 13V15C7 16.1046 6.10457 17 5 17H3C1.89543 17 1 16.1046 1 15V13Z"
                            stroke="#0C1321" stroke-width="1.5"/>
                    </svg>

                </span>
                {{__('translate.Dashboard')}}
            </a>
        </li>
        <li>
            <a href="{{route('user.edit-profile')}}" class="{{ Route::is('user.edit-profile') ? 'active' : '' }}">
                                        <span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9 12C12.309 12 15 9.309 15 6C15 2.691 12.309 0 9 0C5.691 0 3 2.691 3 6C3 9.309 5.691 12 9 12ZM9 2C11.206 2 13 3.794 13 6C13 8.206 11.206 10 9 10C6.794 10 5 8.206 5 6C5 3.794 6.794 2 9 2ZM10.75 16.22C10.182 16.074 9.593 16 9 16C5.14 16 2 19.14 2 23C2 23.552 1.552 24 1 24C0.448 24 0 23.552 0 23C0 18.038 4.038 14 9 14C9.762 14 10.519 14.095 11.25 14.284C11.785 14.422 12.106 14.967 11.969 15.502C11.832 16.037 11.289 16.358 10.751 16.221L10.75 16.22ZM23.121 11.879C21.987 10.745 20.011 10.745 18.878 11.879L12.171 18.586C11.416 19.341 10.999 20.346 10.999 21.415V23.001C10.999 23.553 11.447 24.001 11.999 24.001H13.585C14.654 24.001 15.658 23.584 16.413 22.829L23.12 16.122C23.687 15.555 23.999 14.802 23.999 14C23.999 13.198 23.687 12.445 23.121 11.879ZM21.706 14.707L14.998 21.414C14.621 21.792 14.119 22 13.584 22H12.998V21.414C12.998 20.88 13.206 20.378 13.584 20L20.292 13.293C20.669 12.915 21.328 12.915 21.706 13.293C21.895 13.481 21.999 13.732 21.999 14C21.999 14.268 21.895 14.518 21.706 14.707Z"
                                                    fill="#1E293B"/>
                                            </svg>


                                        </span>
                {{__('translate.Edit Profile')}}
            </a>
        </li>

        <li>
            <a href="{{route('user.address')}}" class="{{ Route::is('user.address*') ? 'active' : '' }}">
                                        <span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="11" r="3" stroke="#0C1321" stroke-width="1.5"/>
                                                <path
                                                    d="M21 10.8889C21 15.7981 15.375 22 12 22C8.625 22 3 15.7981 3 10.8889C3 5.97969 7.02944 2 12 2C16.9706 2 21 5.97969 21 10.8889Z"
                                                    stroke="#0C1321" stroke-width="1.5"/>
                                            </svg>



                                        </span>
                {{__('translate.Address')}}
            </a>
        </li>

        <li>
            <a href="{{route('user.order')}}" class="{{ Route::is('user.order*') ? 'active' : '' }}">
                                        <span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9 6L9 7C9 8.65685 10.3431 10 12 10C13.6569 10 15 8.65685 15 7V6"
                                                    stroke="#28303F" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path
                                                    d="M15.6113 3H8.38836C6.433 3 4.76424 4.41365 4.44278 6.3424L2.77612 16.3424C2.36976 18.7805 4.24994 21 6.72169 21H17.278C19.7498 21 21.6299 18.7805 21.2236 16.3424L19.5569 6.3424C19.2355 4.41365 17.5667 3 15.6113 3Z"
                                                    stroke="#28303F" stroke-width="1.5" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                {{__('translate.Order')}}
            </a>
        </li>


        <li>
            <a href="{{route('user.wishlist')}}" class="{{ Route::is('user.wishlist*') ? 'active' : '' }}">
                                        <span>
                                            <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16 4.4998C17.1045 4.4998 18 5.39523 18 6.4998M11 3.70234L11.6851 2.99981C13.816 0.814519 17.2709 0.814517 19.4018 2.9998C21.4755 5.1264 21.5392 8.55361 19.5461 10.7597L13.8197 17.098C12.2984 18.7818 9.70154 18.7818 8.18026 17.098L2.45393 10.7598C0.460783 8.55363 0.5245 5.12643 2.5982 2.99982C4.72912 0.81453 8.18404 0.814532 10.315 2.99982L11 3.70234Z"
                                                    stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>

                                        </span>
                {{__('translate.Wishlist')}}
            </a>
        </li>
        <li>
            <a href="{{route('user.review')}}" class="{{ Route::is('user.review*') ? 'active' : '' }}">
                                        <span>
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.03281 2.27141C9.8375 0.576198 12.1625 0.576195 12.9672 2.27141L14.3579 5.20118C14.6774 5.87435 15.2951 6.34094 16.0096 6.44888L19.1193 6.91869C20.9187 7.19053 21.6371 9.48954 20.3351 10.8091L18.0849 13.0896C17.5679 13.6136 17.332 14.3685 17.454 15.1084L17.9852 18.3285C18.2926 20.1918 16.4116 21.6126 14.8022 20.7329L12.0208 19.2126C11.3817 18.8633 10.6183 18.8633 9.97917 19.2126L7.19776 20.7329C5.58839 21.6126 3.70742 20.1918 4.01479 18.3286L4.54599 15.1084C4.66804 14.3685 4.43211 13.6136 3.91508 13.0896L1.66488 10.8091C0.362866 9.48954 1.08133 7.19053 2.88066 6.91869L5.99037 6.44888C6.70489 6.34094 7.32257 5.87435 7.64211 5.20118L9.03281 2.27141Z"
                                                    stroke="#0C1321" stroke-width="1.5" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                {{__('translate.Review')}}
            </a>
        </li>


        <li>
            <a href="{{route('user.change-password')}}" class="{{ Route::is('user.change-password') ? 'active' : '' }}">
                                        <span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect x="4" y="7" width="16" height="14" rx="4" stroke="#0C1321"
                                                      stroke-width="1.5"/>
                                                <circle cx="12" cy="14" r="2" stroke="#0C1321" stroke-width="1.5"/>
                                                <path
                                                    d="M15.9993 7C15.9993 4.79086 14.2085 3 11.9993 3C10.9849 3 10.0586 3.37764 9.35352 4"
                                                    stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                {{__('translate.Change Password')}}
            </a>
        </li>


        <li>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal6">
                <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 14L21.2929 12.7071C21.6834 12.3166 21.6834 11.6834 21.2929 11.2929L20 10"
                            stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path
                            d="M21 12H13M6 20C3.79086 20 2 18.2091 2 16V8C2 5.79086 3.79086 4 6 4M6 20C8.20914 20 10 18.2091 10 16V8C10 5.79086 8.20914 4 6 4M6 20H14C16.2091 20 18 18.2091 18 16M6 4H14C16.2091 4 18 5.79086 18 8"
                            stroke="#0C1321" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>

                </span>
                {{__('translate.Logout')}}
            </a>
        </li>

    </ul>

</div>
