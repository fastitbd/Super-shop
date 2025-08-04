@extends('backend.layouts.master')
@section('section-title', 'Brand')
@section('page-title', 'Brand List')

@section('action-button')
    <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
        <i class="mr-2 feather icon-plus"></i>
        Add Brand
    </a>
@endsection

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
                                    <th class="header_style_right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brands as $data)
                                    @php
                                        $count_brand = App\Models\Product::where('brand_id', $data->id)->count();
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    
                                                    {{-- edit --}}
                                                    @if (check_permission('brand.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    {{-- delete --}}
                                                    @if (check_permission('brand.destroy'))
                                                        @if ($count_brand<1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('brand.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Brand" sizeClass="modal-md" id="{{ $data->id }}">
                                            <x-input label="Name:" type="text" name="name" placeholder="Enter Name"
                                                required value="{{ $data->name }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('brand.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Brand" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('brand.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Brand" sizeClass="modal-md">
            <x-input label="Brand Name:" type="text" name="name" placeholder="Enter Brand Name" required />
        </x-add-modal>
    </form>

@endsection
