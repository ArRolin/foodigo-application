
<div class="modal_body_thumb">
    <img src="{{asset($product->image)}}"
            alt="thumb">
</div>

<div class="modal_body_inner">
    <div class="modal_body_top_txt">
        <div class="modal_body_top_txt_df">
            <h4>{{$product->translate_product?->name}}</h4>
            <h5>{{currency(calculateFinalPrice($product))}}</h5>
        </div>

        <p>{{$product->translate_product?->short_description}}</p>
    </div>
    <form class="add_cart_form" method="post">
        @csrf
        <div class="food_select_size_box">
            <div class="food_select_size_box_txt_item">
                <h5>{{ __('translate.Select Size') }} </h5>
                <p>{{ __('translate.Mandatory') }}</p>
            </div>

            <div class="form_check_main">
                @foreach(json_decode($product->size, true) as $size => $price)
                    <div class="form_check_main_item">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                    name="size" value="{{ $size }},{{ $price }}"
                                    id="size_{{$product->id}}_{{ $loop->index }}_{{$price}}_{{$size}}"
                                    data-info="{{ $size }},{{ $price }}">
                            <label class="form-check-label"
                                    for="size_{{$product->id}}_{{ $loop->index }}_{{$price}}_{{$size}}">
                                {{ $size }}
                            </label>
                        </div>

                        <h6>
                            {{currency(calculateFinalPrice($product, $price))}}
                        </h6>
                    </div>
                @endforeach
            </div>

        </div>

        <input type="hidden" name="product_id"
                value="{{$product->id}}">

        @php
            $addonItems = json_decode($product->addon_items, true) ?? [];
        @endphp

        @if(count($addonItems))
            <div class="food_select_size_box addon">
                <div class="food_select_size_box_txt_item">
                    <h5>{{__('translate.Select Addon')}} </h5>
                    <p>{{__('translate.Optional')}}</p>
                </div>

                <div class="form_check_main">
                    @foreach(json_decode($product->addon_items, true) ?? [] as $feature_index => $id)
                        @php
                            $addons = Modules\Addon\App\Models\Addon::where('id', $id)->get();
                        @endphp
                        @foreach ($addons as $addon)
                            <div class="form_check_main_item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="addons[]" value="{{ $addon->id }}"
                                        id="addon_{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}">
                                    <label class="form-check-label"
                                        for="addon_{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}">
                                        {{$addon?->translate?->name}}
                                        ({{currency($addon->price)}})
                                    </label>
                                </div>

                                <div class="inc_dic_btn">
                                    <button type="button"
                                            class="decrement btn-minus"
                                            data-addon-index="{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}">
                            <span>
                                <svg width="10" height="2" viewBox="0 0 10 2"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.335938 0.333496H9.66927V1.66683H0.335938V0.333496Z"/>
                                </svg>

                            </span>
                                    </button>
                                    <input type="text"
                                        class="inc_dic_input product-qty quantityUpdate_{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}"
                                        value="0" readonly >

                                    <button type="button"
                                            class="decrement incriment btn-plus"
                                            data-addon-index="{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}">
                            <span>
                                <svg width="10" height="10" viewBox="0 0 10 10"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.66927 4.3335H5.66927V0.333496H4.33594V4.3335H0.335938V5.66683H4.33594V9.66683H5.66927V5.66683H9.66927V4.3335Z"/>
                                </svg>
                            </span>
                                    </button>
                                    <input type="hidden" name="addons_qty[{{ $addon->id }}]"
                                        id="qtyInput_{{$product->id}}_{{ $loop->parent->index }}_{{ $loop->index }}"
                                        value="0">
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        <div class="food_modal_quantity">
            <div class="food_modal_quantity_txt">
                <p>{{__('translate.Quantity')}}</p>
            </div>

            <div class="food_modal_quantity_main">
                <div class="quantity_inc_dec_btn">
                    <button type="button" class="decrement dec">
                    <span>
                        <svg width="16" height="2" viewBox="0 0 16 2"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.9727 1C15.9727 1.48953 15.5758 1.88637 15.0863 1.88637L0.904475 1.88637C0.414949 1.88637 0.0181112 1.48953 0.0181112 1C0.0181112 0.510478 0.414949 0.113639 0.904475 0.11364L15.0863 0.11364C15.5758 0.11364 15.9727 0.510478 15.9727 1Z"/>
                        </svg>
                    </span>
                    </button>

                    <input type="text" class="quantity_input" name="qty"
                            value="1">


                    <button type="button" class="decrement  inc">
                    <span>
                        <svg width="16" height="16" viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.88317 0.909092C8.88317 0.419566 8.48633 0.022728 7.9968 0.022728C7.50728 0.022728 7.11044 0.419566 7.11044 0.909092V7.11364H0.905895C0.416369 7.11364 0.0195312 7.51048 0.0195312 8C0.0195312 8.48952 0.416369 8.88636 0.905895 8.88636H7.11044V15.0909C7.11044 15.5804 7.50728 15.9773 7.9968 15.9773C8.48633 15.9773 8.88317 15.5804 8.88317 15.0909V8.88636H15.0877C15.5772 8.88636 15.9741 8.48953 15.9741 8C15.9741 7.51048 15.5772 7.11364 15.0877 7.11364H8.88317V0.909092Z"/>
                        </svg>

                    </span>
                    </button>
                </div>

                <button type="submit" class="thm-btn ">

                <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_381_37439)">
                            <path
                                d="M5.0013 3.33333H15.0013C16.8423 3.33333 18.3346 4.82571 18.3346 6.66666V10.8333C18.3346 12.6743 16.8423 14.1667 15.0013 14.1667H8.33464C6.49369 14.1667 5.0013 12.6743 5.0013 10.8333V3.33333ZM5.0013 3.33333C5.0013 2.41286 4.25511 1.66666 3.33464 1.66666H1.66797"
                                stroke="#0C1321" stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                            <path
                                d="M9.16797 17.0833C9.16797 17.7737 8.60832 18.3333 7.91797 18.3333C7.22761 18.3333 6.66797 17.7737 6.66797 17.0833C6.66797 16.393 7.22761 15.8333 7.91797 15.8333C8.60832 15.8333 9.16797 16.393 9.16797 17.0833Z"
                                stroke="#0C1321" stroke-width="1.5"/>
                            <path
                                d="M16.668 17.0833C16.668 17.7737 16.1083 18.3333 15.418 18.3333C14.7276 18.3333 14.168 17.7737 14.168 17.0833C14.168 16.393 14.7276 15.8333 15.418 15.8333C16.1083 15.8333 16.668 16.393 16.668 17.0833Z"
                                stroke="#0C1321" stroke-width="1.5"/>
                            <path d="M11.668 6.66666L11.668 10.8333"
                                    stroke="#0C1321"
                                    stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            <path d="M13.7487 8.75L9.58203 8.75"
                                    stroke="#0C1321" stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                        </g>
                    </svg>
                </span>
                    {{__('translate.Add to Cart')}}
                </button>
            </div>
        </div>
    </form>
</div>


<script>
    "use strict"
    $(document).ready(function () {
        $(".btn-minus, .btn-plus").on("click", function (e) {
            e.preventDefault();

            var $modal = $(this).closest('.modal');
            var addonIndex = $(this).data("addon-index");

            var $quantityInput = $modal.find(".quantityUpdate_" + addonIndex);
            var $hiddenInput = $modal.find("#qtyInput_" + addonIndex);
            var $checkbox = $modal.find("#addon_" + addonIndex);

            var currentQuantity = parseInt($quantityInput.val()) || 0;

            if ($(this).hasClass("btn-minus")) {
                currentQuantity = Math.max(currentQuantity - 1, 0);
            } else if ($(this).hasClass("btn-plus")) {
                currentQuantity++;
            }

            // Update the quantity fields
            $quantityInput.val(currentQuantity);
            $hiddenInput.val(currentQuantity);

            // Automatically check/uncheck the checkbox based on quantity
            if (currentQuantity > 0) {
                $checkbox.prop('checked', true);
            } else {
                $checkbox.prop('checked', false);
            }
        });

        // Checkbox change listener
        $('.form-check-input').on('change', function () {
            let index = $(this).attr('id').replace('addon_', '');
            let $modal = $(this).closest('.modal');

            let qtyInput = $modal.find('#qtyInput_' + index);
            let displayInput = $modal.find('.quantityUpdate_' + index);

            if ($(this).is(':checked')) {
                qtyInput.val(1);
                displayInput.val(1);
            } else {
                qtyInput.val(0);
                displayInput.val(0);
            }
        });



        $(".quantity_inc_dec_btn").on("click", "button.dec, button.inc", function (e) {
                e.preventDefault();

                var container = $(this).closest(".quantity_inc_dec_btn");
                var quantityInput = container.find(".quantity_input");
                var currentQuantity = parseInt(quantityInput.val());


                if ($(this).hasClass("dec")) {

                    currentQuantity = Math.max(currentQuantity - 1, 1);
                } else if ($(this).hasClass("inc")) {
                    currentQuantity++;
                }

                quantityInput.val(currentQuantity);
        });


        $(".add_cart_form").on("submit", function(e){
            e.preventDefault();

            var $form = $(this);
            var $modal = $form.closest('.modal');

            $.ajax({
                type:"post",
                data: $(this).serialize(),
                url: "{{ route('cart.add.product') }}",
                success:function(response){
                    toastr.success(response.message);
                    $modal.modal('hide');
                    let cart_header_qty = $("#cart_header_qty").html();
                    cart_header_qty = parseInt(cart_header_qty) + parseInt(1);
                    $("#cart_header_qty").html(cart_header_qty);
                    $("#cart_qty_mobile_menu").html(cart_header_qty);
                    $("#sidebar_mini_cart_body").html(response.mini_cart);
                },
                error:function(err){
                    if(err.status === 422){
                        if (err?.responseJSON?.errors?.size) {
                            toastr.error(err.responseJSON.errors.size[0]);
                        }
                        if (err?.responseJSON?.errors?.product_id) {
                            toastr.error(err.responseJSON.errors.product_id[0]);
                        }
                    }else if(err.status === 403){
                        if (err?.responseJSON?.message) {
                            toastr.error(err.responseJSON.message);
                        }

                    }else{
                        toastr.error(`{{ __('translate.Something Went Wrong') }}`);
                    }

                }
            })
        })



    });




</script>
