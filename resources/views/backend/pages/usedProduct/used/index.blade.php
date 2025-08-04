@extends('backend.layouts.master')
@section('section-title', 'Used Product')
@section('page-title', 'Used List')
@if (check_permission('used.create'))
    @section('action-button')
        <a href="{{ route('used.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Used
        </a>
    @endsection
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2" id="h-hide">
                <form action="{{ route('used.index')}}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="select2" name="product_id">
                                <option selected value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @isset($oneProduct) @if($product->id == $oneProduct->id) selected @endif @endisset>{{ $product->name }}</option>
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
                            <a href="{{ route('used.index') }}" class="btn add_list_btn_reset">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @php
                                    $sub_total = 0;
                                @endphp
                                @forelse($damages as $key => $data)
                                @php
                                    $sub_total += $data->total_amount;
                                @endphp
                                    <tr>
                                        {{-- @dd($data->damageItems) --}}
                                        <td class="table_data_style_left">{{ $key + 1 }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td>
                                            @foreach ($data->usedItems as $item)
                                                <ul>
                                                    @if ($item->product->unit->related_unit == null)
                                                        <li>{{ $item->product?->name }} ({{ $item->rate }} * {{ $item->main_qty ." ". $item->product->unit->name  }} = {{ $item->subtotal }})</li>
                                                    @else
                                                    <li>{{ $item->product?->name }} ({{ $item->rate }} * {{ $item->main_qty ." ". $item->product->unit->name ." ". $item->sub_qty . " ".$product->unit->related_unit->name  }} = {{ $item->subtotal }})</li>
                                                    @endif
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td>{{ $data->total_amount }}</td>
                                        <td class="table_data_style_right">

                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    

                                                    {{-- delete --}}
                                                    @if (check_permission('used.delete'))
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal" data-target="#deleteModal-{{ $data->id }}">
                                                            <i class="feather icon-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- delete modal --}}
                                    <form action="{{ route('used.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Used Product" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfooter>
                                <tr class="header_bg" style="font-size: 20px; font-width: 700; font-family:sans-serif">
                                    <td class="header_style_left" colspan="2"></td>
                                    <td colspan="1" class="text-right header_bg text-white"> <strong> Total Price: </strong></td>
                                    <td class="header_style_right text-white" colspan="2" class="text-left"><strong> {{number_format($sub_total,2)}} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </strong></td>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
