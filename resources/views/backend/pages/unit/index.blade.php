@extends('backend.layouts.master')
@section('section-title', 'Unit')
@section('page-title', 'Unit List')
@if (check_permission('unit.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Unit
        </a>
    @endsection
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name</th>
                                    <th>Related To</th>
                                    <th>Related Value</th>
                                    <th>Final Value</th>
                                    <th class="header_style_right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $data)
                                    @php
                                        $count_ru = App\Models\Unit::where('related_unit_id', $data->id)->count();
                                        $count_pro = App\Models\Product::where('unit_id', $data->id)->count();
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->related_unit ? $data->related_unit->name : '-' }}</td>
                                        <td>{{ $data->related_value ? $data->related_value : '-' }}</td>
                                        <td>
                                            @if ($data->related_unit)
                                                {{ $data->name }} = 1
                                                {{ $data->related_unit ? $data->related_unit->name : '-' }}
                                                {{ $data->related_sign ? $data->related_sign : '-' }}
                                                {{ $data->related_value ? $data->related_value : '-' }}
                                            @endif
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('units.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary {{ $data->id == 1 ? 'disabled' : '' }}">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                    {{-- print --}}
                                                    {{-- <a class="dropdown-item text-success" href="#">
                                                        <i class="feather icon-printer"></i> Print
                                                    </a> --}}

                                                    {{-- delete --}}
                                                    @if (check_permission('units.destroy'))
                                                        @if ($count_ru < 1 && $count_pro < 1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger {{ $data->id == 1 ? 'disabled' : '' }}">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('unit.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Customer" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Unit Name *" type="text" name="name"
                                                placeholder="Enter Unit Name" required md="6"
                                                value="{{ $data->name }}" />
                                            <x-select label="Related Unit" name="related_unit_id" md="6">
                                                <option value="">Select Related Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        @if ($unit->id == $data->related_unit_id) selected @endif>
                                                        {{ $unit->name }}</option>
                                                @endforeach
                                            </x-select>
                                            <x-input label="Related Sign" type="text" name="related_sign" value="*"
                                                md="6" readonly />
                                            <x-input label="Related Value *" type="number" name="related_value"
                                                placeholder="Enter Related Value" required md="6"
                                                value="{{ $data->related_value }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('unit.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Unit" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{ $units->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('unit.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Unit" sizeClass="modal-lg">
            <x-input label="Unit Name *" type="text" name="name" placeholder="Enter Unit Name" required
                md="6" />
            <x-select label="Related Unit" name="related_unit_id" md="6">
                <option value="">Select Related Unit</option>
                @foreach ($units as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </x-select>
            <x-input label="Related Sign" type="text" name="related_sign" value="*" md="6" readonly />
            <x-input label="Related Value *" type="number" name="related_value" placeholder="Enter Related Value" required
                md="6" />
        </x-add-modal>
    </form>

@endsection
