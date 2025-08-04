@extends('backend.layouts.master')
@section('section-title', 'Expense')
@section('page-title', 'Expense List')
@if (check_permission('expense.create'))
    @section('action-button')
        <a href="{{ route('expense.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Expense
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
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('expense.index') }}" method="GET">
                        @php
                            $categorys = App\Models\ExpenseCategory::get();
                            $total_expense = 0 ;
                        @endphp
                        <div class="row h-hide">
                            <div class="col-md-3 mt-2">
                                <input type="date" class="form-control" name="startDate" value="{{ $startDate }}" />
                            </div>
                            <div class="col-md-3 mt-2">
                                <input type="date" class="form-control" name="endDate" value="{{ $endDate }}" />
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                <select name="category_id" id="" class="select2">
                                    <option value="">Select Category</option>
                                    @foreach ($categorys as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $category_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="col-md-12 col-12">
                                    <button type="submit" class="btn add_list_btn" style="margin-left: -10px">Filter</button>
                                    <a href="{{ route('expense.index') }}" class="btn add_list_btn_reset">Reset</a>
                                    <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th class="h-hide header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse($expenses as $data)
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->expense_category->name }}</td>
                                        <td>{{ $data->amount }} - {{ $data->bank_account->bank_name }}</td>
                                        <td>{{ $data->note == null ? '--' : $data->note }}</td>
                                        <td class="h-hide table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    {{-- edit --}}
                                                    @if (check_permission('expense.update'))
                                                        <a href="{{ route('expense.edit', $data->id) }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    {{-- delete --}}
                                                    @if (check_permission('expense.destroy'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $data->id }}"
                                                            class="dropdown-item text-danger">
                                                            <i class="feather icon-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                    
                                @endphp
                                    {{-- delete modal --}}
                                    <form action="{{ route('expense.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Expense" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- @php
                                dd($data->amount)
                            @endphp --}}
                            <tfoot>
                                <tr class="text-right header_bg">
                                    <td colspan="4" class="header_style_left"><strong style="font-size: 18px;color:rgb(255, 255, 255);">Total: </strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_amt, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td colspan="2" class="header_style_right"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <span class="h-hide">{{ $expenses->onEachSide(1)->links() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
