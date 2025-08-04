@extends('backend.layouts.master')
@section('section-title', 'Expense')
@section('page-title', 'Expense Category List')

@if (check_permission('category.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Expense Category
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
                                    <th class="header_style_left">#</th>
                                    <th>Name</th>
                                    <th class="header_style_right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $data)
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
                                                    @if (check_permission('category.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    {{-- delete --}}
                                                    @php
                                                        $use_category = App\Models\Expense::where('category_id', $data->id)->count();
                                                    @endphp
                                                    @if (check_permission('category.destroy'))
                                                        @if($use_category<1)
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
                                    <form action="{{ route('expense.category-update', $data->id) }}" method="POST">
                                        @csrf
                                        <x-edit-modal title="Edit Category" sizeClass="modal-md" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name" required value="{{ $data->name }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('expense.category-destroy', $data->id) }}" method="POST">
                                        @csrf
                                        <x-delete-modal title="Category" id="{{ $data->id }}" />
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
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('expense.category-store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Category" sizeClass="modal-md">
            <x-input label="Category Name *" type="text" name="name" placeholder="Enter Category Name" required />
        </x-add-modal>
    </form>

@endsection
