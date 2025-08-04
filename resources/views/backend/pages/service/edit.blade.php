@extends('backend.layouts.master')
@section('section-title', 'Edit Service')
@section('page-title', 'Service Edit')

@if (check_permission('service.index'))
    @section('action-button')
        <a href="{{ route('service.index') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-list"></i>
            All Service
        </a>
    @endsection
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="border rounded">
                        <form class="row g-3 needs-validation" method="POST"
                            action="{{ route('service.update', $data->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            {{-- Service name --}}
                            <div class="mt-2 col-md-6">
                                <label for="name" class="form-label fw-bold">Service Name *</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Service name"
                                    value="{{ $data->name }}">
                                <div class="errors">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
                            </div>
                            {{-- Service barcode  --}}
                            <div class="mt-2 col-md-6">
                                <label for="barcode" class="form-label fw-bold">Service Barcode</label>
                                <input type="text" class="form-control" placeholder="Enter Service barcode"
                                    name="barcode" value="{{ $data->barcode }}">
                                <div class="errors">{{ $errors->has('barcode') ? $errors->first('barcode') : '' }}</div>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="selling_price" class="form-label fw-bold">Price *</label>
                                <input type="text" class="form-control" name="selling_price"
                                    value="{{ $data->selling_price }}">
                                <div class="errors">
                                    {{ $errors->has('selling_price') ? $errors->first('selling_price') : '' }}</div>
                            </div>
                            {{-- status --}}
                            <div class="col-md-6 mt-2" style="margin-right: -6px">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="select2" name="status">
                                    <option value="1" {{ ($data->status == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($data->status == 0) ? 'selected' : '' }}>Deactive</option>
                                </select>
                                <div class="errors">{{ ($errors->has('status'))?$errors->first('status'):''; }}</div>
                            </div>
                            {{-- Description --}}
                            <div class="mt-2 col-md-12">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" name="description" rows="2">{{ $data->description }}</textarea>
                            </div>
                            <div class="mt-3 text-center col-12">
                                <button class="btn save_btn" type="submit"> Update </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
