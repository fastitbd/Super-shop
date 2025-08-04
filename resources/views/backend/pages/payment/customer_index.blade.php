@extends('backend.layouts.master')
@section('section-title', 'Product')
@section('page-title', 'Pay Customer')
@if (check_permission('payment.pay-customer-store'))
    @section('action-button')
    <a href="#" id="modal_btn" class="btn add_list_btn">
        <i class="mr-2 feather icon-plus"></i>
        Pay Customer
    </a>
    @endsection
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2" style="margin-top: -5px" id="h-hide">
                <form action="{{ route('payment.pay-customer')}}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="select2" name="customer_id">
                                <option selected value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="start_date" class="form-control" value="{{ (isset($sdate))?date('Y-m-d', strtotime($sdate)):''; }}">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="end_date" class="form-control" value="{{ (isset($edate))?date('Y-m-d', strtotime($edate)):''; }}">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <button class="btn add_list_btn" type="submit">
                                    <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('payment.pay-customer') }}" class="btn cancel_btn">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#</th>
                                    <th>Date</th>
                                    <th>Wallet Type</th>
                                    <th>Pay Type</th>
                                    <th>Amount</th>
                                    <th>Discount Amount</th>
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payment as $data)
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ date('d-m-Y',strtotime($data->date)) }}</td>
                                        <td>{{ $data->wallet_type }}</td>
                                        <td>{{ $data->pay_type }} ({{ $data->transaction->customer->name }})</td>
                                        <td>{{ $data->amount }}</td>
                                        <td>
                                            @if($data->discount_amount == null )
                                                0.00
                                            @endif
                                            @if($data->discount_amount != null)
                                            {{ $data->discount_amount }}
                                            @endif
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    {{-- delete --}}
                                                    @if (check_permission('payment.customer-destroy'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $data->id }}"
                                                            class="dropdown-item text-danger">
                                                            <i class="feather icon-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- delete modal --}}
                                    <form action="{{ route('payment.customer-destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Pay Customer" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="pagination justify-content-center">
                        {{ $payment->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @include('backend.pages.payment.customer_model')
@endsection

@push('js')
    <script type="text/javascript">
        $("#modal_btn").on("click", function () {
            //show payment_modal
            $("#modal").modal("show");
        });

        $(document).on('change', '.customer_id', function () {
            let customer_id = $(this).val();
            let url = "{{ route('customer-account-balance', 'my_id') }}".replace('my_id', customer_id);
            $.get(url, data => {
                $("#details").show(500);
                $("#account_name").text(data.customer_name);
                $("#due_invoice").text(data.due_invoice);
                $("#total_invoice_due").text(data.invoice_due);
                $("#wallet_balance").text(data.walletBalance);
                $("#id_hint").html('*** বিক্রয় বাবদ পাওনা আছে '+Math.abs(data.invoice_due)+' {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} ***');

                if(data.walletBalance>=0){
                        $("#wb_hint").html('**** কাস্টমারের ওয়ালেটে জমা আছেঃ '+Math.abs(data.walletBalance)+'{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} ****');
                }else{
                        $("#wb_hint").html('**** কাস্টমারের কাছে পাওনা আছেঃ '+Math.abs(data.walletBalance)+'{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} ****');
                }

                //for input
                $(".invoice_due").val(data.invoice_due);
                $(".wallet_balance").val(data.walletBalance);
            });
        });

        $("#customer_id").change(function(){
            if($(this).val() == '') {
                $("#details").hide(500);
            }
        });

        $("#details").hide();
    </script>

    {{-- Payment Options --}}
    <script type="text/javascript">
        $(document).on('change', '#wallet_type', function(){
          // alert('ok');
          var wallet_type = $(this).val();
          let html = '<option value="">Select Pay Type</option>';
          if(wallet_type == 'Due Adjust'){
            let data = ['Money Received'];
            $.each(data,function(key,v){
                html +='<option value="'+v+'">'+v+'</option>';
            });
            $('#pay_type').html(html);
            $('#pay_type').trigger('change');
          } else if(wallet_type == 'Balance Adjust'){
            let data = ['Money Received', 'Money Payment'];
            $.each(data,function(key,v){
                html +='<option value="'+v+'">'+v+'</option>';
            });
            $('#pay_type').html(html);
            $('#pay_type').trigger('change');
          } else {
            $('#pay_type').html(html);
            $('#pay_type').trigger('change');
          }
        });
      </script>
@endpush
