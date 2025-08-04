@extends('backend.layouts.master')
@section('section-title', 'Purchase')
@section('page-title', 'Purchase List')
@if (check_permission('purchase.create'))
    @section('action-button')
        <a href="{{ route('purchase.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Purchase
        </a>
    @endsection
@endif
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
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30" style="margin: 0px 30px;margin-top: -25px;margin-bottom:70px;padding-top:10px">
                <div class="card-body">
                    <form action="{{ route('purchase.index') }}" method="GET">
                        @php
                            $suppliers = App\Models\Supplier::get();
                            $products = App\Models\Product::get();
                        @endphp
                        <div class="row h-hide">
                            <div class="col-md-3 mt-2">
                                <input type="date" class="form-control" name="startDate" value="{{ $startDate }}" />
                            </div>
                            <div class="col-md-3 mt-2">
                                <input type="date" class="form-control" name="endDate" value="{{ $endDate }}" />
                            </div>
                            <div class="col-md-3 mt-2">
                                <input type="text" placeholder="Enter Purchase No" value="{{ $purchase_no }}"
                                    name="purchase_no" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <select name="product_id" id="" class="select2">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $product_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <select name="supplier_id" id="" class="select2">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $supplier_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 h-hide d-flex justify-content-between">
                            <div class="col-md-12 col-12">
                                <button type="submit" class="btn add_list_btn">Filter</button>
                                <a href="{{ route('purchase.index') }}" class="btn add_list_btn_reset">Reset</a>
                                <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table text-white table-striped">
                            <thead class="" style="background: #000ce2;border:none">
                                <tr class="text-center">
                                    <th class="header_style_left"> Purchase Date </th>
                                    <th> Purchase No </th>
                                    <th> Product </th>
                                    <th> Supplier </th>
                                    <th> Creator </th>
                                    <th> Total Amount </th>
                                    <th> Total Paid </th>
                                    <th> Total Due </th>
                                    <th> Return Amount </th>
                                    <th> Status </th>
                                    <th class="header_style_right"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_paid = 0;
                                    $total_amt = 0;
                                    $total_due = 0;
                                @endphp
                                @forelse($purchases as $data)
                                    @php
                                        $total_paid += $data->total_paid;
                                        $total_amt += $data->total_amount;
                                        $total_due += $data->total_due;
                                        // dd($data);
                                        // if($data->status == 2){
                                            $purchase_item = App\Models\PurchaseItem::where(
                                                'purchase_id',
                                                $data->id, 
                                            )->first();
                                            $purchase_items = App\Models\PurchaseItem::where(
                                                'purchase_id',
                                                $data->id, 
                                            )->get();
                                        // }else{
                                        //     $purchase_item = App\Models\PurchaseItem::where('is_return',0)->where(
                                        //         'purchase_id',
                                        //         $data->id, 
                                        //     )->first();
                                        //     $purchase_items = App\Models\PurchaseItem::where('is_return',0)->where(
                                        //         'purchase_id',
                                        //         $data->id, 
                                        //     )->get();
                                        // }
                                    @endphp
                                    <tr class="text-center">
                                        <td class="table_data_style_left">{{ $data->date }}</td>
                                        <td>{{ $data->purchase_no }}</td>
                                        {{-- @if(env('APP_IMEI') == 'yes')
                                            <td>{{ $purchase_item->product?->name }}</td>
                                        @else --}}
                                            <td>
                                                @foreach ($purchase_items as $item)
                                                    <ul>
                                                        <li>
                                                            @if($data->status == 2)
                                                                {{ $item->product?->name }} @if(env('APP_SC') == 'yes')  ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }}) @endif
                                                            @else
                                                                {{ $item->product?->name }} @if($item->is_return == 1) <span class="badge bg-danger">Return</span> @endif  @if(env('APP_SC') == 'yes')  ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }}) @endif
                                                            @endif
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                        {{-- @endif --}}
                                        <td>{{ $data->supplier->name }}</td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->total_amount }}</td>
                                        <td>{{ $data->total_paid }}</td>
                                        <td>{{ $data->total_due }}</td>
                                        <td>{{ $data->return_amount }}</td>
                                        <td>
                                            @if ($data->status == 0)
                                                <span class="badge badge-warning">Due</span>
                                            @elseif($data->status == 1)
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($data->status == 2)
                                                <span class="badge badge-danger">Returned</span>
                                            @endif
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    {{-- pay button  --}}
                                                    @if (check_permission('purchase.pay'))
                                                        @if ($data->total_due > 0)
                                                            <a class="dropdown-item text-success" href="{{ url('purchase/pay/' . $data->id) }}">
                                                                <i class="feather icon-dollar-sign"></i> Due
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (check_permission('rtnPurchase.edit'))
                                                        <a class="dropdown-item text-warning" href="{{ route('rtnPurchase.edit',$data->id) }}">
                                                            <i class="fa fa-undo"></i> Return
                                                        </a>
                                                    @endif
                                                    @if (check_permission('purchase.edit'))
                                                        <a class="dropdown-item text-info" href="{{ url('purchase/edit/' . $data->id) }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                    @if (env('APP_IMEI') == 'yes')
                                                        {{-- print --}}
                                                        <a class="dropdown-item text-success" href="{{ route('purchase.imei-print', $data->id) }}">
                                                            <i class="feather icon-printer"></i> Print
                                                        </a>
                                                    @else
                                                        {{-- print --}}
                                                        <a class="dropdown-item text-success" href="{{ route('purchase.print', $data->id) }}">
                                                            <i class="feather icon-printer"></i> Print
                                                        </a>
                                                    @endif
                                                    {{-- delete --}}
                                                    @if (check_permission('purchase.destroy'))
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $data->id }}">
                                                            <i class="feather icon-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- delete modal --}}
                                    <form action="{{ route('purchase.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Purchase" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-danger no_data_style">No Purchase Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="">
                                <tr class=" text-right text-white"  style="background: #000ce2;color:white;border-radius:25px">
                                    <td colspan="5" style="border-radius: 25px 0 0 25px; padding: 10px; background: #000ce2;color:white"><strong>Total: </strong></td>
                                    <td> <strong class="text-white">{{ number_format($total_amt,2) }} </strong></td>
                                    <td> <strong class="text-white">{{ number_format($total_paid,2) }}</strong></td>
                                    <td> <strong class="text-white">{{ number_format($total_due,2) }}</strong></td>
                                    <td colspan="3" style="border-radius: 0 25px 25px 0; padding: 10px; background: #000ce2;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $purchases->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
