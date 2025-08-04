@extends('backend.layouts.master')
@section('section-title', 'Report')
@section('page-title', 'Sale Report')

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
                <form action="{{ route('report.daily.stock') }}">
                    <div class="form-row mt-2">
                        <div class="form-group col-3">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date', $sdate ?? '') }}">
                        </div>
                        <div class="form-group col-3">
                            <input type="date" name="end_date" class="form-control"
                                value="{{ old('end_date', $edate ?? '') }}">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" name="product_name" class="form-control" placeholder="Search Product Name"
                                value="{{ old('product_name', $product_name ?? '') }}">
                        </div>
                        <div class="form-group col-3">
                            <button class="btn add_list_btn" type="submit">
                                <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('report.daily.stock') }}" class="btn add_list_btn_reset">Reset</a>
                        </div>
                    </div>
                </form>

            </div>
            <div class="card m-b-30 print_area card_style">
                <div class="card-header">
                    <h4 style="text-align: center; font-weight:bold; margin-top:25px;font-size:30px">
                        Daily Stock Report ({{ date('d-m-Y', strtotime($sdate)) }} to {{ date('d-m-Y', strtotime($edate)) }})
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($products))
                            <table class="table">
                                <thead class="header_bg">
                                    <tr>
                                        <th>#SL</th>
                                        <th>Product</th>
                                        <th>Previous Stock</th>
                                        <th>Stock In</th>
                                        <th>pRevious Stock Out</th>
                                        <th>Stock Out</th>
                                        <th>Previous Retun</th>
                                        <th>Return</th>
                                        <th>Previous Damage</th>
                                        <th>Damage</th>
                                        <th>Available Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
    @php
        $quantities = $productQuantities ?? [];
    @endphp

    @forelse($products as $index => $product)
        @php
            $q = $quantities[$product->id] ?? [
                'prev_purchase' => 0,
                'purchase' => 0,
                'invoice' => 0,
                'return' => 0,
                'damage' => 0,
            ];

            $available_stock = $q['prev_purchase'] + $q['purchase'] + $q['return'] - ($q['invoice'] + $q['damage']);
        @endphp
       <tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $product->name }}</td>
    <td>{{ $q['prev_purchase'] }}</td>
    <td>{{ $q['purchase'] }}</td>
    <td>{{ $q['prev_invoice'] }}</td>
    <td>{{ $q['invoice'] }}</td>
    <td>{{ $q['prev_return'] }}</td>
    <td>{{ $q['return'] }}</td>
    <td>{{ $q['prev_damage'] }}</td>
    <td>{{ $q['damage'] }}</td>
    <td>
        {{
            ($q['prev_purchase'] + $q['purchase'] + $q['prev_return'] + $q['return'])
            -
            ($q['prev_invoice'] + $q['invoice'] + $q['prev_damage'] + $q['damage'])
        }}
    </td>
</tr>

    @empty
        <tr>
            <td colspan="10" class="text-center text-danger no_data_style">No Data Found</td>
        </tr>
    @endforelse
</tbody>

                                {{-- <tfooter>
                                    <tr class="header_bg" style="font-size: 20px; font-width: 700; font-family:sans-serif">
                                        <td class="header_style_left" colspan="6"></td>
                                        <td colspan="2"> <strong class="text-white"> Total Price: </strong></td>
                                        <td class="header_style_right text-white" colspan="1"></td>
                                    </tr>
                                </tfooter> --}}
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
