@extends('backend.layouts.master')
@section('section-title', 'Account')
@section('page-title', 'Bank Account')
@if (check_permission('bank-account.create'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Bank Account
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
                                    <th class="header_style_left"> Bank Name </th>
                                    <th> Account Number </th>
                                    <th> Opening Balance </th>
                                    <th> Current Balance </th>
                                    <th> Status </th>
                                    <th class="header_style_right"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bank_accounts as $data)
                                    @php
                                        
                                        $count_bank = App\Models\BankTransaction::where('bank_id', $data->id)->count();
                                        $count_tra = App\Models\Transaction::where('bank_id', $data->id)->count();
                                        $current = 0;
                                        $current += current_balance($data->id);
                                        
                                    @endphp
                                    <tr class="text-center">
                                        <td class="table_data_style_left">{{ $data->bank_name }}</td>
                                        <td>{{ $data->account_number }}</td>
                                        <td>{{ number_format($data->opening_balance,2) }}</td>
                                        <td>{{ current_balance($data->id) > 0 ? number_format(current_balance($data->id),2) : number_format(current_balance($data->id),2) }}</td>
                                        <td>
                                            <input type="checkbox" data-toggle="toggle" data-on="Active"
                                                class="status-update" {{ $data->status == 1 ? 'checked' : '' }}
                                                data-off="Inactive" data-onstyle="success" data-offstyle="danger"
                                                {{ $data->id == 2 ? 'disabled' : '' }}
                                                data-id="{{ $data->id }}" data-model="BankAccount">
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('bank-account.edit'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    @if (check_permission('bank-account.destroy'))
                                                        @if ($count_bank<1 && $count_tra<1)
                                                            @if ($data->id != 1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                            @endif
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('bank-account.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Bank Account" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Bank Name *" type="text" name="bank_name" placeholder="Enter Bank Name" required md="6" value="{{ $data->bank_name }}" />
                                            <x-input label="Account Number" type="number" name="account_number" placeholder="Enter Account Number" md="6" value="{{ $data->account_number }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('bank-account.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Bank Account" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
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
    <form action="{{ route('bank-account.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Bank Account" sizeClass="modal-lg">
            <x-input label="Bank Name *" type="text" name="bank_name" placeholder="Enter Bank Name" required md="6" />
            <x-input label="Account Number *" type="number" name="account_number" placeholder="Account Number" required md="6" />
            <x-input label="Opening Balance *" type="number" name="opening_balance" placeholder="Enter Opening Balance" required md="12" />
        </x-add-modal>
    </form>
@endsection
