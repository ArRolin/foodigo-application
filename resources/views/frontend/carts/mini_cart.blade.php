@php
    $totalPrice = 0;
@endphp
<div class="menu_bg_right_icon_cart_box">
    @foreach ($carts as $item)
        @php
            $product = Modules\Product\App\Models\Product::where('status', 'enable')->whereIn('id', [$item['product_id']])->first();
            $total = 0;
            $calculate = 0;
        @endphp
        <div class="menu_bg_right_icon_cart_item">
            <div class="menu_bg_right_icon_cart_item_thumb">
                <img
                    src="{{asset($product->image)}}"
                    alt="thumb">
            </div>

            <div class="menu_bg_right_icon_cart_item_txt">
                <a href="javascript:;">
                    {{$product->name}}
                </a>
                <span>{{currency($item['total'])}}</span>
            </div>


            <a href="javascript:;" onClick="cartRemove('{{ $product['id'] }}')"
            class="menu_bg_right_icon_cart_item_btn">
                <span>
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 7V17C3 19.2091 4.79086 21 7 21H13C15.2091 21 17 19.2091 17 17V7M12 10V16M8 10L8 16M14 4L12.5937 1.8906C12.2228 1.3342 11.5983 1 10.9296 1H9.07037C8.40166 1 7.7772 1.3342 7.40627 1.8906L6 4M14 4H6M14 4H19M6 4H1"
                            stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>

        @php
            $totalPrice +=$item['total'];
        @endphp
    @endforeach
</div>
@if(session('cart') && count(session('cart')) > 0)
    <div class="menu_bg_right_icon_subtotal">
        <h5>{{ __('translate.Subtotal') }} <span>{{currency($totalPrice)}}</span></h5>
    </div>


    <div class="menu_bg_right_icon_btn_main">
        <a href="{{route('view.checkout', ['type' => 'delivery'])}}"
        class="thm-btn">{{__('translate.Checkout')}}</a>
    </div>
@else
    <p class="text-center text-decoration-underline text-fo-black ">{{__('translate.Empty Cart')}}</p>
@endif
