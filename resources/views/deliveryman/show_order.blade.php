@extends('deliveryman.master_layout')
@section('title')
    <title>{{ __('translate.Order Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Order Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Order') }} >> {{ __('translate.Order Details') }}</p>
@endsection

@section('body-content')

    <section class="crancy-adashboard crancy-show mt-5">
        <div class="zum_icvoice">
            <div class="container container__bscreen">
                <div class="crancy-product-card">
                    <div class="create_new_btn_inline_box mb-4">
                        <h4 class="crancy-product-card__title">{{ __('translate.Order Details') }}</h4>

                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-4 col-md-6">
                            <div class="zum_icvoice_item_main">

                                @php
                                    $address = json_decode($order->delivery_address);
                                @endphp

                                @if($order->order_type == 'delivery')
                                    <div class="zum_invoice_text">
                                        <h2>{{__('translate.Billing Address')}}</h2>
                                    </div>
                                    <div class="zum_icvoice_item">
                                        <ul class="zum_invoice_lixt">
                                            <li>{{__('translate.Full Name')}} : <span>{{$address->contact_person_name ?? ''}}</span></li>
                                            <li>
                                                <a href="mailto:{{$address->contact_person_email ?? ''}} ">
                                                    {{__('translate.Email')}} : <span> {{$address->contact_person_email ?? ''}} </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="tel:{{$address->contact_person_number ?? ''}}">
                                                    {{__('translate.Phone')}} : <span> {{$address->contact_person_number ?? ''}}</span>
                                                </a>
                                            </li>
                                            <li>
                                                {{__('translate.Address')}} : <span> {{$address->address ?? ''}} </span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="zum_icvoice_item">
                                    <h2>{{__('translate.Payment Information')}}:</h2>
                                    <ul class="zum_invoice_lixt">
                                        <li>{{__('translate.Method')}} : <span>{{$order->payment_method}}</span></li>
                                        <li>
                                            @if($order->payment_status == 'success')
                                                <a href="javascript:;">
                                                    {{__('translate.State')}} :<span class="tag">{{$order->payment_status}}</span>
                                                </a>
                                            @else
                                                <a href="javascript:;">
                                                    {{__('translate.State')}} :<span
                                                        class="tag denger">{{$order->payment_status}}</span>
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            {{__('translate.Transaction')}} <span> {!! clean(nl2br($order->tnx_info)) !!}</span>
                                        </li>

                                    </ul>
                                </div>

                            </div>

                            @if($order->order_type == 'pickup')
                                <p><strong>{{__('translate.Contact person name')}} : </strong> {{$address->contact_person_name ?? ''}}</p>
                                <p><strong>{{__('translate.Contact person phone')}} : </strong> {{$address->contact_person_number ?? ''}}</p>
                                <p><strong>{{__('translate.Contact person email')}} : </strong> {{$address->contact_person_email ?? ''}}</p>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="zum_icvoice_item_main">
                                @if($order->order_type == 'delivery')
                                    <div class="zum_invoice_text">
                                        <h2>{{__('translate.Shipping Information')}}</h2>


                                    </div>
                                    <div class="zum_icvoice_item">
                                        <ul class="zum_invoice_lixt">
                                            <li>{{__('translate.Full Name')}} : <span>{{$address->contact_person_name ?? ''}}</span></li>
                                            <li>
                                                <a href="mailto:{{$address->contact_person_email ?? ''}}">
                                                    {{__('translate.Email')}} : <span> {{$address->contact_person_email ?? ''}}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="tel:{{$address->contact_person_number ?? ''}}">
                                                    {{__('translate.Phone')}} : <span> {{$address->contact_person_number ?? ''}} </span>
                                                </a>
                                            </li>
                                            <li>
                                                {{__('translate.Address')}} : <span>{{$address->address ?? ''}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="zum_icvoice_item">
                                    <h2>{{__('translate.Order Information')}}:</h2>
                                    <ul class="zum_invoice_lixt">
                                        <li>{{__('translate.Date')}} : <span>{{$order->created_at->format('F j, Y') }}</span></li>

                                        <li>
                                            {{__('translate.Shipping')}} : <span> {{__('translate.Fixed Shipping')}}</span>
                                        </li>

                                        <li>
                                            <a href="javascript:;">
                                                @if($order->order_status == 1)
                                                    {{__('translate.State')}} : <span class="badge bg-warning text-white">{{__('translate.Pending')}}</span>
                                                @elseif($order->order_status == 2)
                                                    {{__('translate.State')}} : <span
                                                        class="badge bg-success text-white">{{__('translate.Confirmed')}}</span>
                                                @elseif($order->order_status == 3)
                                                    {{__('translate.State')}} : <span
                                                        class="badge bg-warning text-white">{{__('translate.Processing')}}</span>
                                                @elseif($order->order_status == 4)
                                                    {{__('translate.State')}} : <span
                                                        class="badge bg-inprocees text-white">{{__('translate.Food on the way')}}</span>
                                                @elseif($order->order_status == 5)
                                                    {{__('translate.State')}} : <span
                                                        class="badge bg-success text-white">{{__('translate.Delivered')}}</span>
                                                @elseif($order->order_status == 6)
                                                    {{__('translate.State')}} : <span
                                                        class="badge bg-warning text-white">{{__('translate.Cancel')}}</span>
                                                @endif
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabel_main">
                                <table class=" zum_tabel table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('translate.Product')}}</th>
                                        <th>{{__('translate.Variant')}}</th>
                                        <th>{{__('translate.Restaurant')}}</th>
                                        <th>{{__('translate.Unit Price')}}</th>
                                        <th>{{__('translate.Quantity')}}</th>
                                        <th>{{__('translate.Total')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                        $calculate = 0;
                                    @endphp
                                    @foreach($order->items ?? [] as $key => $order_item)
                                        @php
                                            $product = Modules\Product\App\Models\Product::where('status', 'enable')->whereIn('id', [$order_item['product_id']])->first();
                                            $total += $order_item->total;
                                        @endphp
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>
                                                <div class="tabel_modal_main">
                                                    @foreach (json_decode($order_item['size']) as $size => $price)
                                                        {{__('translate.Size')}} : {{ $size }}
                                                    @endforeach
                                                    @if(json_decode($order_item['addons']))
                                                    <span data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                                                        {{__('translate.See more')}}
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{$order?->restaurant?->restaurant_name}}
                                            </td>
                                            <td>
                                                @foreach (json_decode($order_item['size']) as $size => $price)
                                                  {{(currency($price))}}
                                                @endforeach
                                            </td>
                                            <td>{{$order_item->qty}}</td>
                                            <td>{{currency($order_item->total)}}</td>
                                        </tr>

                                        <!-- Modal 2 -->
                                        <div class="modal adon_modal_main fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{__('translate.See Addon')}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="modal_adon">
                                                            @foreach (json_decode($order_item['addons']) as $addonId => $quantity)
                                                                @php
                                                                    $addonsDb = Modules\Addon\App\Models\Addon::whereIn('id', [$addonId])->get();
                                                                    $calculate += ($addonsDb->first()->price * $quantity);
                                                                @endphp
                                                                @if ($addonsDb->isNotEmpty())
                                                                    <li> {{ $addonsDb->first()->name }}
                                                                        ({{ currency($addonsDb->first()->price) }}
                                                                        * {{ $quantity }})</li>
                                                                @endif

                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal_btn_main">
                                                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="modal_btn">{{__('translate.Close')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabel_btm">
                                <ul class="tabel_btm_list">
                                    <li><span>{{__('translate.Subtotal')}} : </span>{{currency($total)}}</li>
                                    <li><span>{{__('translate.Discount')}} (-) </span>: {{currency($order->discount_amount)}}</li>
                                    <li><span>{{__('translate.Delivery Charge')}} :</span> {{currency($order->delivery_charge)}}</li>
                                    <li>{{__('translate.Total')}} : {{currency($order->grand_total)}}</li>
                                </ul>

                                @if ($order->order_request==0)
                                    <div class="crancy-table__column-2 crancy-table__data-2">

                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#reviewApproval" class="crancy-btn approval_button"><i class="fas fa-check"></i> {{ __('translate.Make Approval') }}</a>

                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#reviewRejected" class="crancy-btn delete_danger_btn"><i class="fas fa-check"></i> {{ __('translate.Make Reject') }}</a>

                                    </div>

                                @elseif ($order->order_request == 1 )
                                    <div class="crancy-table__column-2 crancy-table__data-2">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Approvalcomplete"
                                           class="crancy-btn approval_button"><i class="fas fa-check"></i> {{ __('translate.Make Complete') }}</a>

                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#ApprovalCancel"
                                           class="crancy-btn delete_danger_btn"><i class="fas fa-check"></i> {{ __('translate.Make Cancel') }}</a>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






    <!-- Approval Confirmation Modal -->
    <div class="modal fade" id="reviewApproval" tabindex="-1" aria-labelledby="reviewApprovalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewApprovalLabel">{{ __('translate.Approval Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to approved this withdraw?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deliveryman.order-request-status', $order->id) }}" class="delet_modal_form" method="POST">
                        @csrf
                        <input type="text" name="order_request_status" value="1" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Approved') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Approval Confirmation Modal -->
    <div class="modal fade" id="reviewRejected" tabindex="-1" aria-labelledby="reviewRejectedLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewRejectedLabel">{{ __('translate.Rejected Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to rejected this withdraw?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deliveryman.order-request-status', $order->id) }}" class="delet_modal_form" method="POST">
                        @csrf
                        <input type="text" name="order_request_status" value="2" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Rejected') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



        <!-- Approval Confirmation Modal -->
        <div class="modal fade" id="Approvalcomplete" tabindex="-1" aria-labelledby="ApprovalcompleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ApprovalcompleteLabel">{{ __('translate.Approval Confirmation') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('translate.Are you realy want to complete this withdraw?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('deliveryman.order-request-status', $order->id) }}" class="delet_modal_form" method="POST">
                            @csrf
                            <input type="text" name="order_request_status" value="3" hidden>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Approved') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Approval Confirmation Modal -->
    <div class="modal fade" id="ApprovalCancel" tabindex="-1" aria-labelledby="CancelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CancelLabel">{{ __('translate.Rejected Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to cancel this withdraw?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deliveryman.order-request-status', $order->id) }}" class="delet_modal_form" method="POST">
                        @csrf
                        <input type="text" name="order_request_status" value="4" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Rejected') }}</button>

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
            $("#item_delect_confirmation").attr("action",'{{ url("admin/order-delete/") }}'+"/"+id)
        }

        function showConfirmationModal(orderId, selectedValue) {

            $("#item_delect_confirmation1").attr("action", '{{ url("admin/order-status-change/") }}' + "/" + orderId);

            $('<input>').attr({
                type: 'hidden',
                name: 'order_status',
                value: selectedValue
            }).appendTo('#item_delect_confirmation1');

            $('#deleteModal1').modal('show');
        }

        function showPaymentConfirmationModal(orderId, selectedValue) {
            $("#paymentConfirmationForm").attr("action", '{{ url("admin/payment-status-change/") }}' + "/" + orderId);

            $("#newPaymentStatus").val(selectedValue);

            $('#paymentConfirmationModal').modal('show');
        }

        function showDeliveryManModal(orderId, selectedValue) {
            $("#showDeliveryManForm").attr("action", '{{ url("admin/deliveryman/") }}' + "/" + orderId);

            $("#newDelivery_id").val(selectedValue);

            $('#showDeliveryManModal').modal('show');
        }

        function showRequestStatus(orderId, selectedValue) {
            $("#showOrderRequestForm").attr("action", '{{ url("deliveryman/order-request-status/") }}' + "/" + orderId);

            $("#newDelivery_id").val(selectedValue);

            $('#showRequestStatus').modal('show');
        }
    </script>
@endpush

