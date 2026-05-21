
  <!-- Main Menu -->
<div class="admin-menu__one crancy-sidebar-padding mg-top-20">
  <h4 class="admin-menu__title">{{ __('translate.Main Menu') }}</h4>
  <!-- Nav Menu -->
  <div class="menu-bar">
      <ul id="CrancyMenu" class="menu-bar__one crancy-dashboard-menu">

          <li class="{{ Route::is('deliveryman.dashboard') ? 'active' : '' }}"><a class="collapsed" href="{{ route('deliveryman.dashboard') }}"><span class="menu-bar__text">
              <span class="crancy-menu-icon crancy-svg-icon__v1">
                  <svg class="crancy-svg-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                      <path d="M14 21V17C14 14.7909 12.2091 13 10 13C7.79086 13 6 14.7909 6 17V21M19 9.15033V16.9668C19 19.1943 17.2091 21 15 21H5C2.79086 21 1 19.1943 1 16.9668V9.15033C1 7.93937 1.53964 6.7925 2.46986 6.02652L7.46986 1.90935C8.9423 0.696886 11.0577 0.696883 12.5301 1.90935L17.5301 6.02652C18.4604 6.7925 19 7.93937 19 9.15033Z"  stroke-width="1.5"/>
                  </svg>
              </span>
              <span class="menu-bar__name">{{ __('translate.Dashboard') }}</span></span></a>
          </li>

          <li>
            <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__order_list">
                <span class="menu-bar__text">
                    <span class="crancy-menu-icon crancy-svg-icon__v1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C21.1491 10.971 20.8738 11.2102 20.6797 11.5M7.5 8H3.80397C3.17922 8 2.86684 8 2.63812 8.10084C1.6264 8.5469 2.07874 9.67075 2.24894 10.4784C2.27952 10.6235 2.37896 10.747 2.51841 10.8132C3.09673 11.0876 3.50177 11.6081 3.60807 12.2134L4.20066 15.5878C4.46138 17.0725 4.55052 19.1942 5.8516 20.2402C6.8062 21 8.18162 21 10.9325 21H13.0675C13.2156 21 12.5 21.0001 13 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <g clip-path="url(#clip0_1673_9569)">
                            <path d="M14.8333 14.5H19.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.8333 17H21.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.8333 19.5H19.2778" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <path d="M6.5 11L10 3M15 3L17.5 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <defs>
                            <clipPath id="clip0_1673_9569">
                            <rect width="8.33333" height="8.33333" fill="white" transform="translate(14 12.8334)"/>
                            </clipPath>
                            </defs>
                            </svg>

                    </span>
                    <span class="menu-bar__name">{{ __('translate.Manage Order') }}</span>
                </span>
                <span class="crancy__toggle"></span>
            </a>

            <!-- Dropdown Menu -->
            <div class="collapse crancy__dropdown {{ request()->routeIs('deliveryman.order-request', 'deliveryman.orders', 'deliveryman.completed-order', 'deliveryman.cancel-order') ? 'show' : '' }}" id="menu-item__order_list" data-bs-parent="#CrancyMenu">
                <ul class="menu-bar__one-dropdown">
                    <li class="{{ request()->routeIs('deliveryman.order-request') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('deliveryman.order-request') }}">
                            <span>{{ __('translate.Order Request') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('deliveryman.orders') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('deliveryman.orders') }}">
                            <span>
                                {{ __('translate.Running Orders') }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('deliveryman.completed-order') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('deliveryman.completed-order') }}">
                            <span>
                                {{ __('translate.Completed Orders') }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('deliveryman.cancel-order') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('deliveryman.cancel-order') }}">
                            <span>
                                {{ __('translate.Cancel Orders') }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="{{ Route::is('deliveryman.my-withdraw.*') ? 'active' : '' }}"><a href="{{route('deliveryman.my-withdraw.index')}}" class="collapsed"><span
          class="menu-bar__text">
          <span class="crancy-menu-icon crancy-svg-icon__v1">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.3333 14.875C16.3333 13.7475 15.2887 12.8334 14 12.8334C12.7113 12.8334 11.6667 13.7475 11.6667 14.875C11.6667 16.0026 12.7113 16.9167 14 16.9167C15.2887 16.9167 16.3333 17.8308 16.3333 18.9584C16.3333 20.086 15.2887 21 14 21C12.7113 21 11.6667 20.086 11.6667 18.9584" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M14 11.0834V12.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 21V22.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.79913 12.2693C7.61582 9.81921 9.90865 8.16663 12.4912 8.16663H15.5088C18.0914 8.16663 20.3842 9.81921 21.2009 12.2693L23.0342 17.7693C24.3293 21.6544 21.4375 25.6666 17.3421 25.6666H10.6579C6.56256 25.6666 3.67074 21.6544 4.9658 17.7693L6.79913 12.2693Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M16.4335 8.16671L11.5665 8.16671L9.93188 6.29182C8.32953 4.45394 10.1988 1.70685 12.5383 2.46153L13.6207 2.81071C13.8671 2.8902 14.1329 2.8902 14.3794 2.81071L15.4618 2.46153C17.8012 1.70685 19.6705 4.45394 18.0681 6.29183L16.4335 8.16671Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
          </span>
          <span class="menu-bar__name">{{ __('translate.My Earnings') }}</span></span></a>
        </li>

          <li><a href="{{ route('deliveryman.logout') }}" class="collapsed"><span class="menu-bar__text">
              <span class="crancy-menu-icon crancy-svg-icon__v1">
                  <svg class="crancy-svg-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                      <path d="M19 11L20.2929 9.70711C20.6834 9.31658 20.6834 8.68342 20.2929 8.29289L19 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M20 9H12M5 17C2.79086 17 1 15.2091 1 13V5C1 2.79086 2.79086 1 5 1M5 17C7.20914 17 9 15.2091 9 13V5C9 2.79086 7.20914 1 5 1M5 17H13C15.2091 17 17 15.2091 17 13M5 1H13C15.2091 1 17 2.79086 17 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
              </span>
              <span class="menu-bar__name">{{ __('translate.Logout') }}</span></span></a>
          </li>


      </ul>
  </div>
  <!-- End Nav Menu -->

</div>
