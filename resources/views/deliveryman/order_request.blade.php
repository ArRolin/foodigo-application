@extends('deliveryman.master_layout')
@section('title')
    <title>{{ __('translate.Order Request') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Order Request') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Order') }} >> {{ __('translate.Order Request') }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                <div class="crancy-customer-filter">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Order Request') }}</h4>
                                        </div>
                                    </div>
                                </div>

                                 <!-- crancy Table -->


                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <!-- crancy Table Head -->
                                        <thead class="crancy-table__head">
                                        <tr>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.SN') }}
                                            </th>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Customer') }}
                                            </th>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Order Id') }}
                                            </th>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Date') }}
                                            </th>

                                            <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                {{ __('translate.Amount') }}
                                            </th>

                                            <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                {{ __('translate.Order Status') }}
                                            </th>
                                            <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                {{ __('translate.Payment') }}
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
                                                    <h4 class="crancy-table__product-title">
                                                        <a href="#">{{ $order->user->name }}</a>
                                                    </h4>
                                                </td>


                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">{{ $order->id }}</h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">{{ $order->created_at->format('d F, Y') }}</h4>
                                                </td>

                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <h4 class="crancy-table__product-title">{{ round($order->total) }}</h4>
                                                </td>

                                                <td>

                                                    @php $status = (int) $order->order_request; @endphp

                                                    @if ($status == 1)
                                                        <span class="badge bg-primary text-white">{{ __('translate.Progress') }}</span>
                                                    @elseif ($status == 2)
                                                        <span class="badge bg-info text-white">{{ __('translate.Ignored by me') }}</span>
                                                    @elseif ($status == 3)
                                                        <span class="badge bg-success text-white">{{ __('translate.Completed') }}</span>
                                                    @elseif ($status == 4)
                                                        <span class="badge bg-danger text-white">{{ __('translate.Declined') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary text-white">{{ __('translate.Pending') }}</span>
                                                    @endif

                                                </td>

                                                <td>
                                                    @if($order->payment_status == 'success')
                                                        <span class="badge bg-success text-white">{{ __('translate.Success') }}</span>
                                                        @else
                                                        <span class="badge bg-warning text-white">{{ __('translate.Pending') }}</span>
                                                    @endif
                                                </td>


                                                <td class="crancy-table__column-2 crancy-table__data-2">
                                                    <a href="{{ route('deliveryman.order-show',$order->id) }}" class="crancy-btn"><i class="fas fa-eye" aria-hidden="true"></i> {{ __('translate.Details') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <!-- End crancy Table Body -->
                                    </table>
                                </div>

                                </div>
                                <!-- End crancy Table -->

                            </div>

                        </div>
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

@push('js_section')
    <script>
        "use strict"
        function itemDeleteConfrimation(id){
            $("#item_delect_confirmation").attr("action",'{{ url("admin/restaurant/product/") }}'+"/"+id)
        }
    </script>
@endpush
