@php
    $menu = getMenuByLocation($location ?? 'header');
    $options = array_merge([
        'ul_class' => 'nav-links',
        'li_class' => 'dropdown',
        'a_class' => '',
        'submenu_class' => 'd-menu',
        'active_class' => 'active',
        'current_url' => request()->url(),
    ], $options ?? []);
@endphp

@if($menu)
    <ul class="{{ $options['ul_class'] }}">
        @foreach($menu->menuItems as $item)
            @if($item->is_active)
                @php
                    $isActive = request()->url() === $item->url ||
                               (str_starts_with(request()->url(), $item->url) && $item->url !== '/');
                    $liClass = $options['li_class'];
                    $aClass = $options['a_class'];

                    if ($isActive) {
                        $liClass .= ' ' . $options['active_class'];
                        $aClass .= ' ' . $options['active_class'];
                    }

                    if ($item->hasChildren()) {
                        $liClass .= ' has-dropdown';
                    }
                @endphp

                <li class="{{ $liClass }}">
                    <a href="{{ $item->url }}"
                       class="{{ $aClass }}"
                       @if($item->target) target="{{ $item->target }}" @endif
                       @if($item->css_class) class="{{ $aClass }} {{ $item->css_class }}" @endif>
                        {{ $item->translated_title }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
@else
    {{-- Fallback to static mobile menu if no dynamic menu found --}}
    <ul class="{{ $options['ul_class'] }}">
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('home')}}">{{__('translate.Home')}}</a>
        </li>
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('website.categories')}}">{{__('translate.Categories')}}</a>
        </li>
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('about')}}">{{__('translate.About')}}</a>
        </li>
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('offer')}}">{{__('translate.Offer')}}</a>
        </li>
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('contact')}}">{{__('translate.Contact Us')}}</a>
        </li>
        <li class="{{ $options['li_class'] }}">
            <a href="{{route('blog')}}">{{__('translate.Blog')}}</a>
        </li>
        @if(Auth::user())
            <li class="{{ $options['li_class'] }}">
                <a href="{{route('user.dashboard')}}">{{__('translate.My Dashboard')}}</a>
            </li>
        @else
            <li class="{{ $options['li_class'] }}">
                <a href="{{route('login')}}">{{__('translate.Sign In')}}</a>
            </li>
        @endif
    </ul>
@endif
