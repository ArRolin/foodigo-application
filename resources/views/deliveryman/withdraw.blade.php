@extends('deliveryman.master_layout')
@section('title')
    <title>{{ __('translate.My Withdraw') }}</title>
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
                                            <h4 class="crancy-product-card__title">{{ __('translate.My Withdraw') }}</h4>

                                            <a href="{{ route('deliveryman.withdraw.create') }}" class="crancy-btn "><span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
																<path d="M8 1V15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
																<path d="M1 8H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>
                                            </span> {{ __('translate.New Withdraw') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- crancy Table -->
                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                  <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                    <!-- crancy Table Head -->
                                    <thead class="crancy-table__head">
                                      <tr>
                                        <th class="crancy-table__column-1 crancy-table__h2 sorting" >
                                            {{ __('translate.SN') }}
                                        </th>
                                        <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                            {{ __('translate.Method') }}
                                        </th>
                                        <th class="crancy-table__column-3 crancy-table__h2 sorting" >
                                            {{ __('translate.Charge') }}
                                        </th>
                                        <th class="crancy-table__column-4 crancy-table__h2 sorting" >
                                            {{ __('translate.Total') }}
                                        </th>
                                        <th class="crancy-table__column-5 crancy-table__h2 sorting" >
                                            {{ __('translate.Withdraw') }}
                                        </th>
                                        <th class="crancy-table__column-6 crancy-table__h2 sorting" >
                                            {{ __('translate.Status') }}
                                        </th>
                                        <th class="crancy-table__column-7 crancy-table__h2 sorting" >
                                            {{ __('translate.Action') }}
                                        </th>
                                    </tr>

                                    </thead>
                                    <!-- crancy Table Body -->
                                    <tbody class="crancy-table__body">
                                        @foreach ($withdraws as $index => $withdraw)

                                        <tr class="odd">

                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                            </td>

                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">{{ $withdraw->method }}</h4>
                                            </td>

                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">{{$withdraw->total_amount - $withdraw->withdraw_amount}}</h4>
                                            </td>
                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">{{$withdraw->total_amount}}</h4>
                                            </td>
                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">{{$withdraw->withdraw_amount}}</h4>
                                            </td>

                                            <td class="crancy-table__column-2 crancy-table__data-2">
                                                <h4 class="crancy-table__product-title">
                                                    @if($withdraw->status == 1)
                                                        <strong class="text-success">
                                                            {{ __('translate.Success') }}
                                                        </strong>
                                                    @else
                                                        <strong class="text-danger">
                                                            {{__('translate.Pending')}}
                                                        </strong>
                                                    @endif
                                                </h4>
                                            </td>
                                            <td>
                                              <a href="{{ route('deliveryman.withdraw.show',$withdraw->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

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
            $("#item_delect_confirmation").attr("action",'{{ url("admin/banner-delete") }}'+"/"+id)
        }
    </script>
@endpush
