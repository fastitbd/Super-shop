@extends('backend.layouts.master')
@section('section-title', 'Account')
@section('page-title', 'Transaction History')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2" style="margin-top: -5px" id="h-hide">
                <form action="{{ route('transaction-history')}}">
                    <div class="form-row"> 
                        <div class="form-group col-md-6">
                            <input type="date" name="start_date" class="form-control" value="{{ (isset($sdate))?date('Y-m-d', strtotime($sdate)):''; }}">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="date" name="end_date" class="form-control" value="{{ (isset($edate))?date('Y-m-d', strtotime($edate)):''; }}">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <button class="btn add_list_btn" type="submit">
                                    <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('transaction-history') }}" class="btn add_list_btn_reset">Reset</a>
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
                                <tr class="text-center">
                                    <th class="header_style_left"> Date </th>
                                    <th> Transaction Type </th>
                                    <th> Note </th>
                                    <th> Amount </th>
                                    <th class="header_style_right"> Created By </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bank_transactions as $transaction)
                                    <tr class="text-center">
                                        <td class="table_data_style_left"> {{ date('d-m-Y',strtotime($transaction->date)) }} </td>
                                        <td> {{ ucfirst($transaction->trans_type) }} from  {{ $transaction->bank_account->bank_name }} </td>
                                        <td> {{ ($transaction->note != NULL)?$transaction->note:'NULL' }} </td>
                                        <td> {{ number_format($transaction->amount,2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </td>
                                        <td class="table_data_style_right"> {{ $transaction->user->name }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center no_data_style">No Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{-- {{ $bank_transactions->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
