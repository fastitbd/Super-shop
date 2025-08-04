@extends('backend.layouts.master')
@section('section-title', 'OwnerShip')
@section('page-title', 'OwnerShip List')
@if (check_permission('ownership.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Owner
        </a>
    @endsection
@endif
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
                    {{-- <form action="{{ route('customer.index') }}" method="GET">
                        @php
                            $custommer = App\Models\Customer::get();
                        @endphp
                        <div class="row h-hide">
                            
                            <div class="col-md-3 mt-3">
                                <select name="customer_id" id="" class="select2">
                                    <option value="">All Customer</option>
                                    {{-- @foreach ($custommer as $item)
                                        <option value="{{ $item->id }}" {{ ($customer_id == $item->id)? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach --}
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
                                        <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Balance</th>
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ownerships as $data)
                                    @php
                                        $deposit = App\Models\BankTransaction::where('owner_id',$data->id)->where('pay_type','ownpay')->sum('amount');
                                        $withdraw = App\Models\BankTransaction::where('owner_id',$data->id)->where('pay_type','ownwith')->sum('amount');
                                        $balance = $deposit - $withdraw;
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="font-weight-bold">{{ $data->phone }}</td>
                                        <td class="font-weight-bold">{{ ($data->email == Null)?'NULL':$data->email; }}</td>
                                        <td class="font-weight-bold">{{ $deposit }} </td>
                                        <td class="font-weight-bold">{{ $withdraw }} </td>
                                        <td class="font-weight-bold">{{ $balance }} </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    {{-- @if (check_permission('ownership.show')) --}}
                                                        <a href="{{ route('ownership.show',$data->id) }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-list"></i> Ledger
                                                        </a>
                                                    {{-- @endif --}}
                                                    @if (check_permission('ownership.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    {{-- @if (check_permission('customers.destroy'))
                                                        @if ($count_cus<1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif --}}

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('ownership.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Owner" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name" required md="6" value="{{ $data->name }}" />
                                            <x-input label="Email" type="email" name="email" placeholder="Enter Email" md="6" value="{{ $data->email }}" />
                                            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" value="{{ $data->phone }}" />
                                            <x-input label="Address" type="text" name="address" placeholder="Enter Address" md="6" value="{{ $data->address }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    {{-- <form action="{{ route('customer.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Customer" id="{{ $data->id }}" />
                                    </form> --}}
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('ownership.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add OwnerShip" sizeClass="modal-lg">
            <x-input label="Owner Name *" type="text" name="name" placeholder="Enter Owner Name" required
                md="6" />
            <x-input label="Email" type="email" name="email" placeholder="Enter Email" md="6" />
            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" />
            <x-input label="Address" type="text" name="address" placeholder="Enter Address" md="6" />
            <x-select label="Bank Account" name="bank_id" md="6">
                @foreach ($bank_accounts as $bank)
                    <option value="{{ $bank->id }}"> {{ $bank->bank_name }}</option>
                @endforeach
            </x-select>
            <x-input label="Deposit" type="text" name="deposit" value="0" md="6" />
            {{-- <x-input label="Opening Payable" type="text" name="open_payable" value="0" md="6" /> --}}
        </x-add-modal>
    </form>

@endsection
