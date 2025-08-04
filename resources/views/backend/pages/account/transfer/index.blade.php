@extends('backend.layouts.master')
@section('section-title', 'Account')
@section('page-title', 'Transfer')
@if (check_permission('bank-transfer-create'))
    @section('action-button')
        <a href="#" id="modal_btn" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Transfer
        </a>
    @endsection
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead class="header_bg">
                                <tr class="text-center">
                                    <th class="header_style_left"> Date </th>
                                    <th> From Account </th>
                                    <th> To Account </th>
                                    <th> Note </th>
                                    <th> Amount </th>
                                    <th class="header_style_right"> Created By </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @forelse ($bank_transfers as $transfer)
                                    <tr class="text-center">
                                        <td class="table_data_style_left"> {{ date('d-m-Y',strtotime($transfer->date)) }} </td>
                                        <td> {{ $transfer->from_bank_account->bank_name }} </td>
                                        <td> {{ $transfer->to_bank_account->bank_name }} </td>
                                        <td> {{ ($transfer->note != NULL)?$transfer->note:'NULL' }} </td>
                                        <td> {{ number_format($transfer->amount,2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="table_data_style_right"> {{ $transfer->user->name }} </td>
                                    </tr>
                                    @php
                                        $total += $transfer->amount;
                                    @endphp
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="header_bg">
                                    <th colspan="4" class="text-right text-white header_style_left"> Total Amount </th>
                                    <th class="text-center text-white"> {{ number_format($total,2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</th>
                                    <th class="text-center header_style_right"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{ $bank_transfers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.pages.account.transfer.model')
@endsection

@push('js')
    <script type="text/javascript">
        $("#modal_btn").on("click", function () {
            //show payment_modal
            $("#modal").modal("show");
        });

        $(function(){
            $(document).on('change', '.from_bank_id', function(){
                var bank_id = $(this).val();
                if (bank_id != '') {
                    $.ajax({
                        url: "{{ route('get-account-balance') }}",
                        type: "GET",
                        data: { bank_id: bank_id },
                        success: function(data){
                            // Format the balance
                            var formattedBalance = parseFloat(data.balance).toLocaleString('en-US');
                            
                            // Display formatted balance
                            var balance = 'Current Balance: ' + formattedBalance + ' {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}';
                            $('#from_amount').text(balance);
                            
                            // Store the original numeric balance in the hidden input
                            $('.from_amount').val(data.balance);
                        }
                    });
                }
            });
        });


        $(function(){
            $(document).on('change', '.to_bank_id', function(){
                var bank_id = $(this).val();
                if (bank_id != '') {
                    $.ajax({
                        url: "{{ route('get-account-balance') }}",
                        type: "GET",
                        data: { bank_id: bank_id },
                        success: function(data){
                            // Format the balance
                            var formattedBalance = parseFloat(data.balance).toLocaleString('en-US');
                            
                            // Display formatted balance
                            var balance = 'Current Balance: ' + formattedBalance + ' {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}';
                            $('#to_amount').text(balance);
                        }
                    });
                }
            });
        });


        $(function(){
            $(document).on('change', '#from_bank_id', function(){
            var from_bank_id = $(this).val();
            if (from_bank_id != '') {
                $.ajax({
                    url:"{{ route('get-to-account') }}",
                    type:"GET",
                    data:{from_bank_id:from_bank_id},
                    success:function(data){
                    var html = '<option value="">Select Account</option>';
                    $.each(data,function(key,v){
                        html +='<option value="'+v.id+'">'+v.bank_name+'</option>';
                    });
                    $('#to_bank_id').html(html);
                    $('.to_bank_id').trigger('change');
                    }
                });
            }
            });
        });
    </script>
@endpush
