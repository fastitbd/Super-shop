@extends('backend.layouts.master')
@section('section-title', 'Shop Banner')
@section('page-title', 'Shop Banner List')

@if (check_permission('shopBanner.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Shop Banner
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
                                    <th>Image</th>
                                    <th class="header_style_right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allshopbanner as $data)
                                    @php
                                        $count_cat = App\Models\Product::where('category_id', $data->id)->count();
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="cat_image" style="width: 60px;">
                                            <img class="img-fluid" src="{{ asset('uploads/shopbanner/' . $data->images) }}" alt="">
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('shopBanner.update'))
                                                        <a href="#" data-toggle="modal" data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary{{ $data->id == 1 ? 'disabled' : '' }}">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    {{-- delete --}}
                                                    @if (check_permission('shopBanner.destroy'))
                                                        @if ($count_cat < 1)
                                                            <a href="#" data-toggle="modal" data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger {{ $data->id == 1 ? 'disabled' : '' }}">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal --}}
                                    <form action="{{ route('shopBanner.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Banner" sizeClass="modal-md" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name"
                                                value="{{ $data->name }}" />
                                            <x-input label="Banner Order *" type="number" name="order_by"
                                                placeholder="Enter Banner order" value="{{ $data->order_by }}" />
                                            <x-input label="Banner Image *" type="file" name="images"  required/>
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('shopBanner.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Banner" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger">No Data Available</td>
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
    <form action="{{ route('shopBanner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-add-modal title="Add Banner" sizeClass="modal-md">
            <x-input label="Banner Name *" type="text" name="name" placeholder="Enter Banner Name"  />
            <x-input label="Banner Order *" type="number" name="order_by" placeholder="Enter Banner order" />
            <x-input label="Banner Image *" type="file" name="images" required/>
        </x-add-modal>
    </form>

@endsection