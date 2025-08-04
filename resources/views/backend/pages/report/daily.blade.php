@extends('backend.layouts.master')
@section('section-title', 'Report')
@section('page-title', 'Daily Report')

@push('css')
    <style>
        @media print {

            table,
            table th,
            table td {
                color: black !important;
            }

            .h-hide {
                display: none;
            }
        }

        .font_size {
            font-size: 13px;
            font-weight: 700;
        }

        .font-size_td {
            font-size: 11px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2 h-hide" style="margin-top: -5px" id="h-hide">
                <form action="{{ route('report.daily') }}">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ isset($sdate) ? date('Y-m-d', strtotime($sdate)) : '' }}">
                        </div>
                        <div class="form-group col-6 text-right">
                            <button class="btn add_list_btn" type="submit">
                                <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('report.daily') }}" class="btn add_list_btn_reset mr-3">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                        {{-- <div class="form-group col-md-6">
                        <input type="date" name="end_date" class="form-control" value="{{ (isset($edate))?date('Y-m-d', strtotime($edate)):''; }}">
                        </div> --}}
                    </div>
                    {{-- <div class="form-row mt-2">
                        
                    </div> --}}
                </form>
            </div>
            <div class="card card_style m-b-30 print_area">
                <div class="card-header">
                    <h4 style="text-align: center; font-weight:bold; margin-top:30px;">Petty Cash
                        ({{ isset($sdate) ? date('m-d-Y', strtotime($sdate)) : '' }})</h4>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($invoices))
                            {{-- @dd($sdate) --}}
                            <div class="col-12">
                                @php
                                    $data = App\Models\BankAccount::first();
                                    $previous_balance =
                                        previous_balance($data->id, $sdate) 
                                            // ? number_format(previous_balance($data->id, $sdate), 2)
                                            // : number_format(previous_balance($data->id, $sdate), 2);
                                @endphp
                                <h3 class=" text-center py-2" style="border-radius: 25px; background:#000ce2;color:white;">Previous Balance : {{ $previous_balance }}</h3>
                            </div>
                            <div class="col-12">
                                        @php
                                            $total_today_sales = 0;
                                            $today_sales_bank_amount = 0;
                                            $today_total_due = 0;
                                            $total_sale=0;
                                            $bank_amount_sal = 0;
                                            $amount = 0;
                                        @endphp
                                <table class="table">
                                    <tbody>
                                        @php
                                            $bankAccount = App\Models\BankAccount::where('status',1)->get();
                                            $today_sale = App\Models\BankTransaction::where('pay_type','invpay')->where('date',$sdate)->sum('amount');
                                            $today_total_due = App\Models\Invoice::where('date', $sdate)->sum('total_due');
                                            $today_due_coll = App\Models\BankTransaction::where('pay_type','duepay')->where('date',$sdate)->sum('amount');
                                            $today_deposit = App\Models\BankTransaction::where('pay_type','ownpay')->where('date',$sdate)->sum('amount');
                                            $today_expense = App\Models\BankTransaction::where('pay_type','expense')->where('date',$sdate)->sum('amount');
                                            $today_purchase = App\Models\BankTransaction::where('pay_type','purchase')->where('date',$sdate)->sum('amount');
                                            $today_pur_due_pay = App\Models\BankTransaction::where('pay_type','purdue')->where('date',$sdate)->sum('amount');
                                            $today_transfer = App\Models\BankTransaction::where('pay_type','transfer')->where('date',$sdate)->sum('amount');
                                            $today_withdraw = App\Models\BankTransaction::where('pay_type','ownwith')->where('date',$sdate)->sum('amount');
                                            // $today_transfer_from = App\Models\BankTransaction::where('pay_type','transfer')->where('date',$sdate)->sum('amount');
                                            // dd($today_transfer_from->from_bank_id);
                                            $today_total_inc = $today_sale + $today_due_coll + $today_deposit ;
                                            $today_total_exp = $today_expense + $today_purchase + $today_pur_due_pay + $today_withdraw ;

                                            $today_balance = $today_total_inc - $today_total_exp;
                                            $current_balance = $today_balance + $previous_balance;
                                        @endphp   

                                        {{-- today sales --}}

                                        <tr class="text-center header_bg">
                                            <th colspan="2" style="border-radius: 25px;">
                                                <h4 class="text-white">Income</h4>
                                            </th>
                                        </tr>
                                        <tr class=" text-center table-striped text-white" style="background: #747be4">
                                            <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Sales</th>
                                            <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td>{{$today_sale}}</td>  
                                            <td>     
                                                @foreach($bankAccount as $cash)
                                                    @php
                                                        $cash_amount = App\Models\BankTransaction::where('pay_type','invpay')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                    @endphp
                                                    @if($cash_amount)
                                                        {{$cash->bank_name}}= {{$cash_amount}} <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>

                                        {{-- today due --}}
                                        @if($today_total_due != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Today Due</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Due</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_total_due }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $due_collect_amount = App\Models\BankTransaction::where('pay_type','duepay')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        @if($due_collect_amount != 0)
                                                            {{-- {{$cash->bank_name}}= {{$due_collect_amount}} <br> --}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- due collection --}}
                                        @if($today_due_coll != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Due Collection</td>
                                            </tr>
                                            <tr class="text-center"  style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Due Collection</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_due_coll }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $due_collect_amount = App\Models\BankTransaction::where('pay_type','duepay')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        @if($due_collect_amount != 0)
                                                            {{$cash->bank_name}}= {{$due_collect_amount}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- deposit --}}

                                        @if($today_deposit != 0)

                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Deposit</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Deposit</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_deposit }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $deposit_amount = App\Models\BankTransaction::where('pay_type','ownpay')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        {{$cash->bank_name}}= {{$deposit_amount}} <br>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        @if($today_withdraw != 0)

                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Withdraw</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Withdraw</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_withdraw }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $deposit_amount = App\Models\BankTransaction::where('pay_type','ownwith')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        {{$cash->bank_name}}= {{$deposit_amount}} <br>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- expenses --}}

                                        @if($today_expense != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Expenses</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Expense</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_expense }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $expense_amount = App\Models\BankTransaction::where('pay_type','expense')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        @if($expense_amount != 0)
                                                        {{$cash->bank_name}}= {{$expense_amount}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- Purchase --}}

                                        @if($today_purchase != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Purchase</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Purchase</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_purchase }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $purchase_amount = App\Models\BankTransaction::where('pay_type','purchase')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        @if($purchase_amount != 0)
                                                        {{$cash->bank_name}}= {{$purchase_amount}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
                                    {{-- Purchase due pay --}}

                                        @if($today_pur_due_pay != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Purchase Due Payment</td>
                                            </tr>
                                            <tr class="text-center" style="background: #747be4">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px">Today Purchase Due Payment</th>
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Method</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>{{ $today_pur_due_pay }} </td>
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $purchase_due_pay = App\Models\BankTransaction::where('pay_type','purdue')->where('bank_id',$cash->id)->where('date',$sdate)->sum('amount');
                                                        @endphp
                                                        @if($purchase_due_pay != 0)
                                                        {{$cash->bank_name}}= {{$purchase_due_pay}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                            {{-- bank transfar --}}
                                        @if($today_transfer != 0)
                                            <tr class="text-center header_bg">
                                                <td colspan="2" style="font-size: 16px;border-radius: 25px;color:white;">Bank Transfer</td>
                                            </tr>
                                            <tr class="text-center">
                                                <th style="border-top-left-radius: 25px; border-bottom-left-radius:25px"> Account</th>
                                                {{-- <th>From Account</th> --}}
                                                <th style="border-top-right-radius: 25px; border-bottom-right-radius:25px">Amount</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td>
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $purc_due_pay = App\Models\BankTransaction::where('pay_type','transfer')->where('from_bank_id',$cash->id)->where('date',$sdate)->get();
                                                        @endphp
                                                        @foreach($purc_due_pay as $trans)
                                                            From {{$trans->from_bank_account->bank_name}} Transfer To 
                                                            {{$trans->to_bank_account->bank_name}} <br>
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                                <td>  
                                                    @foreach($bankAccount as $cash)
                                                        @php
                                                            $purc_due_pay = App\Models\BankTransaction::where('pay_type','transfer')->where('from_bank_id',$cash->id)->where('date',$sdate)->get();
                                                        @endphp
                                                        @foreach($purc_due_pay as $trans)
                                                            {{$trans->amount}} <br>
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Total Transfer </td>
                                                <td>{{$today_transfer}}</td>
                                            </tr>
                                        @endif
                                    </tbody>

                                        @php
                                            $count_bank = App\Models\BankTransaction::where('bank_id', $data->id)->count();
                                            $count_tra = App\Models\Transaction::where('bank_id', $data->id)->count();
                                            $current = 0;
                                            $current += current_balance($data->id);
                                        @endphp
                                        {{-- today balance --}}
                                        <tr class="header_bg"
                                            style=" font-size: 20px; font-width: 700; font-family:sans-serif;text-align:center;">
                                            <td class="text-center text-white header_style_left"> <strong> Today Balance : {{ $today_balance }} </strong></td>
                                            <td class="text-white header_style_right">
                                                @foreach($bankAccount as $cash)
                                                    {{$cash->bank_name}}= {{date_current_balance($cash->id,$sdate)}} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        {{-- current balance --}}
                                        <tr
                                            style="background:#747be4;font-size: 20px; font-width: 700; font-family:sans-serif;text-align:center;">
                                            <td colspan="3" class="text-center" style="border-radius: 25px;color:white"> <strong> Current Balance : {{ $today_balance + previous_balance($data->id, $sdate) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                        </tr>
                                </table>
                            </div>
                        @else
                            <div class="col-md-12" style="padding-bottom: 30px;">
                                <div class="alert alert-danger text-center" role="alert"> Please Select Start and End
                                    Month</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
