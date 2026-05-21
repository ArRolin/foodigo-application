@extends('deliveryman.master_layout')
@section('title')
<title>{{__('translate.admin.My withdraw')}}</title>
@endsection
@section('deliveryman-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('translate.admin.My withdraw')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('seller.dashboard') }}">{{__('translate.admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('translate.admin.My withdraw')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('deliveryman.withdraw.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('translate.admin.My withdraw')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <td width="50%">{{__('translate.admin.Withdraw Method')}}</td>
                                <td width="50%">{{ $withdraw->method }}</td>
                            </tr>

                            <tr>
                                <td width="50%">{{__('translate.admin.Withdraw Charge Amount')}}</td>
                                <td width="50%">{{ $setting->currency_icon }}{{ $withdraw->total_amount - $withdraw->withdraw_amount }}</td>
                            </tr>

                            <tr>
                                <td width="50%">{{__('translate.admin.Total amount')}}</td>
                                <td width="50%">{{ $setting->currency_icon }}{{ $withdraw->total_amount }}</td>
                            </tr>
                            <tr>
                                <td width="50%">{{__('translate.admin.Withdraw amount')}}</td>
                                <td width="50%">{{ $setting->currency_icon }}{{ $withdraw->withdraw_amount }}</td>
                            </tr>
                            <tr>
                                <td width="50%">{{__('translate.admin.Status')}}</td>
                                <td width="50%">
                                    @if ($withdraw->status==1)
                                    <span class="badge badge-success">{{__('translate.admin.Success')}}</span>
                                    @else
                                    <span class="badge badge-danger">{{__('translate.admin.Pending')}}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">{{__('translate.admin.Requested Date')}}</td>
                                <td width="50%">{{ $withdraw->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @if ($withdraw->status==1)
                                <tr>
                                    <td width="50%">{{__('translate.admin.Approved Date')}}</td>
                                    <td width="50%">{{ $withdraw->approved_date }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td width="50%">{{__('translate.admin.Account Information')}}</td>
                                <td width="50%">
                                    {!! clean(nl2br($withdraw->account_info)) !!}
                                </td>
                            </tr>

                        </table>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>


@endsection
