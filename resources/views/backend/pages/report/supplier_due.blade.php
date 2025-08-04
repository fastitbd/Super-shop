@extends('backend.layouts.master')
@section('section-title', 'Supplier')
@section('page-title', 'Supplier Due')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('report.supplier-due') }}" method="GET">
                        @php
                            $supliers = App\Models\Supplier::get();
                        @endphp
                        <div class="row">
                            
                            <div class="col-md-3 mt-3">
                                <select name="supplier_id" id="" class="select2">
                                    <option value="">All Supplier</option>
                                    @foreach ($supliers as $item)
                                        <option value="{{ $item->id }}" {{ ($supplier_id == $item->id)? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <input type="text" placeholder="Enter Phone No" name="phone_no" value="{{ $phone_no }}" class="form-control">
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-12">
                                        <button type="submit" class="btn add_list_btn">Filter</button>
                                        <a href="{{ route('supplier.index') }}" class="btn add_list_btn_reset" >Reset</a>
                                        <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <h4 style="text-align: center; font-weight:bold; margin-top:50px;font-size:30px">Supplier Due Report</h4>
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name & Email & Phone</th>
                                    <th>Total Purchase</th>
                                    <th>Purchase Paid</th>
                                    <th>Purchase Due</th>
                                    <th>Previous Due</th>
                                    <th class="header_style_right">Total Due</th>
                                </tr>
                            </thead>
                                @php
                                    $sub_total = 0;
                                @endphp
                            <tbody>
                                @forelse($suppliers as $data)
                                    @php
                                    $count_sup = App\Models\Purchase::where('supplier_id', $data->id)->count();
                                    $count_tra = App\Models\Transaction::where('supplier_id', $data->id)->count();
                                    $open_balance = open_balance_supplier($data->id, $data->open_receivable, $data->open_payable);
                                    $pur_total = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_amount');
                                    $pur_paid = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_paid');
                                    $pur_due = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_due');
                                    $sub_total += ($pur_due + $open_balance);
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} <br> {{ $data->phone }} <br> {{ ($data->email == Null)?'NULL':$data->email; }}</td>
                                        <td class="font-weight-bold">{{ $pur_total }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $pur_paid }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $pur_due }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $open_balance }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold table_data_style_right">{{ $open_balance + $pur_due }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('supplier.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Supplier" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name"
                                                required md="6" value="{{ $data->name }}" />
                                            <x-input label="Email" type="email" name="email" placeholder="Enter Email"
                                                md="6" value="{{ $data->email }}" />
                                            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone"
                                                required md="6" value="{{ $data->phone }}" />
                                            <x-input label="Address" type="text" name="address"
                                                placeholder="Enter Address" md="6"
                                                value="{{ $data->address }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('supplier.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Supplier" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfooter>
                                <tr style="background: #000ce2; font-size: 20px; font-width: 700; font-family:sans-serif">
                                    <td class="header_style_left" colspan="4"></td>
                                    <td colspan="1"> <strong class="text-white"> Total Price: </strong></td>
                                    <td class="header_style_right text-white" colspan="2"><strong> {{number_format($sub_total,2)}} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </strong></td>
                                </tr>
                            </tfooter>
                        </table>
                        {{ $suppliers->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
