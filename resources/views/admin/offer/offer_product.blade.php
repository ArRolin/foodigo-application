@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Offer Product') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Offer Product') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Offer Product') }} >> {{ __('translate.Offer Product') }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('admin.store-offer-product') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Offer Product') }}
                                                </h4>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Product') }}
                                                            * </label>
                                                        <select class="form-select crancy__item-input select2"
                                                            name="product_id" required>
                                                            <option value="">{{ __('translate.Select Product') }}
                                                            </option>
                                                            @foreach ($products as $product)
                                                                <option
                                                                    {{ $product->id == old('product') ? 'selected' : '' }}
                                                                    value="{{ $product->id }}">{{ $product->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <button class="crancy-btn mg-top-25"
                                                type="submit">{{ __('translate.Save') }}</button>

                                        </div>
                                        <!-- End Product Card -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>

            </div>


            <div class="crancy-product-card mt-5">
                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                        <!-- crancy Table Head -->
                        <thead class="crancy-table__head">
                            <tr>

                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                    {{ __('translate.Serial') }}
                                </th>

                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                    {{ __('translate.Product') }}
                                </th>

                                <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                    {{ __('translate.Action') }}
                                </th>

                            </tr>
                        </thead>
                        <!-- crancy Table Body -->
                        <tbody class="crancy-table__body">
                            @foreach ($offer_products as $index => $offer_product)
                                <tr class="odd">

                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                    </td>

                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                        {{ $offer_product?->product?->name }}
                                    </td>


                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                        <a onclick="itemDeleteConfrimation({{ $offer_product->id }}, {{ $index }})"
                                            href="javascript:;" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $index }}"
                                            class="crancy-btn delete_danger_btn"><i class="fas fa-trash"></i>
                                            {{ __('translate.Delete') }}</a>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    {{ __('translate.Delete Confirmation') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('translate.Are you realy want to delete this item?') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="" id="item_delete_confirmation{{ $index }}"
                                                    class="delet_modal_form" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-type-dlt">{{ __('translate.Yes, Delete') }}</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1">
                                                    {{ __('translate.Status Change Confirmation') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('translate.Are you sure you want to change the status of this item?') }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="" id="item_delect_confirmation{{ $index }}"
                                                    class="delet_modal_form" method="POST">
                                                    @csrf
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('translate.Yes, Change') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>
                        <!-- End crancy Table Body -->
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection



@push('style_section')
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
@endpush


@push('js_section')
    <script src="{{ asset('global/select2/select2.min.js') }}"></script>

    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {
                $('.select2').select2();
            });
        })(jQuery);

        function itemDeleteConfrimation(id, indexId) {
            $("#item_delete_confirmation" + indexId).attr("action", '{{ url('admin/delete-offer-product') }}' + "/" + id)
        }
    </script>
@endpush
