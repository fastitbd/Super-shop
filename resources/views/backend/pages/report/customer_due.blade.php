@extends('backend.layouts.master')
@section('section-title', 'Report')
@section('page-title', 'Customer Due')
@push('css')
<style>
    @media print{
        table,table th,table td {
            color:black !important;
        }

        .h-hide {
            display: none;
        }
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('report.customer-due') }}" method="GET">
                        @php
                            $custommer = App\Models\Customer::get();
                        @endphp
                        <div class="row h-hide">
                            <div class="col-md-3 mt-3">
                                <select name="customer_id" id="" class="select2">
                                    <option value="">All Customer</option>
                                    @foreach ($custommer as $item)
                                        <option value="{{ $item->id }}" {{ ($customer_id == $item->id)? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <input type="text" placeholder="Enter Phone No" name="phone_no" value="{{ $phone_no }}" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-12 ">
                                        <button type="submit" class="btn add_list_btn">Filter</button>
                                        <a href="{{ route('customer.index') }}" class="btn add_list_btn_reset" >Reset</a>
                                        <a href="#" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <h4 style="text-align: center; font-weight:bold; margin-top:50px;">Customer Due Report</h4>
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name & Email & Phone</th>
                                    <th>Total Invoice</th>
                                    <th>Paid Invoice</th>
                                    <th>Due Invoice</th>
                                    <th>Previous Due</th>
                                    <th class="header_style_right">Total Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sub_total = 0;
                                @endphp
                                @forelse($customers as $data)
                                    @php
                                    $count_cus = App\Models\Invoice::where('customer_id', $data->id)->count();
                                    $count_tra = App\Models\Transaction::where('customer_id', $data->id)->count();
                                    $open_balance = open_balance_customer($data->id, $data->open_receivable, $data->open_payable);
                                    $inv_total = App\Models\Invoice::where('customer_id', $data->id)->sum('total_amount');
                                    $inv_paid = App\Models\Invoice::where('customer_id', $data->id)->sum('total_paid');
                                    $inv_due = App\Models\Invoice::where('customer_id', $data->id)->sum('total_due');
                                    $inv_due_cust = App\Models\Invoice::where('customer_id', $data->id)->get();
                                    $sub_total += ($inv_due + $open_balance);
                                    @endphp
                                    @if( $inv_due + $open_balance > 0)
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} <br> {{ $data->phone }} <br> {{ ($data->email == Null)?'NULL':$data->email; }}</td>
                                        <td class="font-weight-bold">{{ $inv_total }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $inv_paid }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $inv_due }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $open_balance }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold table_data_style_right">
                                            {{ $inv_due + $open_balance }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfooter>
                                <tr style="background:#000ce2;font-size: 20px; font-width: 700; font-family:sans-serif">
                                    <td class="header_style_left" colspan="4"></td>
                                    <td class="text-white" colspan="1"> <strong> Total Price: </strong></td>
                                    <td class="header_style_right text-white" colspan="2"><strong> {{number_format($sub_total,2)}} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </strong></td>
                                </tr>
                            </tfooter>
                        </table>
                        {{ $customers->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
