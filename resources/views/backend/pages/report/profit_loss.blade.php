@extends('backend.layouts.master')
@section('section-title', 'Report')
@section('page-title', 'Profit Loss Report')

@push('css')
    <style>
        @media print {

            table,
            table th,
            table td {
                color: black !important;
            }

            #h-hide {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2" style="margin-top: -5px;" id="h-hide">
                <form action="{{ route('report.profit-loss') }}">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="month" name="start_month" placeholder="Enter Start Month" class="form-control"
                                value="{{ isset($sdate) ? date('Y-m', strtotime($sdate)) : '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="month" name="end_month" placeholder="Enter End Month" class="form-control"
                                value="{{ isset($edate) ? date('Y-m', strtotime($edate)) : '' }}">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <button class="btn add_list_btn" type="submit">
                                <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('report.profit-loss') }}" class="btn add_list_btn_reset">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-b-30 card_style print_area">
                <div class="card-header">
                    <h4 style="text-align: center; font-weight:bold; margin-top:25px;font-size:30px">Profit Loss
                        ({{ isset($sdate) ? date('F Y', strtotime($sdate)) : '' }} -
                        {{ isset($edate) ? date('F Y', strtotime($edate)) : '' }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($groupedDates))
                            <table class="table">
                                <thead>
                                    <tr class="header_bg">
                                        <th class="header_style_left">Month</th>
                                        <th>Sales</th>
                                        <th>Cost of Goods Sold</th>
                                        <th>Gross Profit </th>
                                        <th>Expenses</th>
                                        <th class="header_style_right">Net Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($groupedDates as $key => $data)
                                        @php
                                            $sale_amount = App\Models\Invoice::whereMonth(
                                                'date',
                                                '=',
                                                date('m', strtotime($key)),
                                            )
                                                ->whereYear('date', '=', date('Y', strtotime($key)))
                                                ->sum('total_amount');

                                            $purchase_amount = App\Models\InvoiceItem::whereMonth(
                                                'date',
                                                '=',
                                                date('m', strtotime($key)),
                                            )
                                                ->whereYear('date', '=', date('Y', strtotime($key)))
                                                ->sum('pur_subtotal');

                                            $profit = $sale_amount - $purchase_amount;
                                            $expense = App\Models\Expense::whereMonth(
                                                'date',
                                                '=',
                                                date('m', strtotime($key)),
                                            )
                                                ->whereYear('date', '=', date('Y', strtotime($key)))
                                                ->sum('amount');
                                            $net_profit = (float) ($profit - $expense);
                                        @endphp
                                        <tr>
                                            <td class="table_data_style_left">{{ date('F Y', strtotime($key)) }}</td>
                                            <td>{{ number_format($sale_amount, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                            <td>{{ number_format($purchase_amount, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                            <td>{{ number_format($profit, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                            <td>{{ number_format($expense, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                            <td class="table_data_style_right">{{ $net_profit >= 0 ? number_format($net_profit, 2) : '(' . number_format(abs($net_profit), 2) . ')' }}
                                                {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-danger no_data_style">No Data Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
