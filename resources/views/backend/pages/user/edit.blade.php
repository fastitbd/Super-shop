@extends('backend.layouts.master')
@section('section-title', 'User Management')
@section('page-title', 'User Update')
@section('action-button')
    <a href="{{ route('user.index') }}" class="btn add_list_btn">
        <i class="mr-2 feather icon-list"></i>
        User List
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            {{-- Name --}}
                            <div class="mb-3 col-md-12">
                                <label for="validationCustom01" class="form-label font-weight-bold">
                                    Name *
                                </label>
                                <input type="text" class="form-control" id="validationCustom01"
                                    placeholder="Enter User Name" name="name" required value="{{ $user->name }}">
                            </div>
                            {{-- Email --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom02" class="form-label font-weight-bold">
                                    Email *
                                </label>
                                <input type="email" class="form-control" id="validationCustom02"
                                    placeholder="Enter User Email" name="email" required value="{{ $user->email }}">
                            </div>
                            {{-- Phone --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom03" class="form-label font-weight-bold">
                                    Phone *
                                </label>
                                <input type="text" class="form-control" id="validationCustom03"
                                    placeholder="Enter User Phone" name="phone" required value="{{ $user->phone }}">
                            </div>
                            {{-- User Role --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom06" class="form-label font-weight-bold">
                                    User Role *
                                </label>
                                <select class="select2" id="validationCustom06" name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- User Status --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom07" class="form-label font-weight-bold">
                                    User Status *
                                </label>
                                <select class="select2" id="validationCustom07" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            {{-- Address --}}
                            <div class="mb-3 col-md-12">
                                <label for="validationCustom08" class="form-label font-weight-bold">
                                    Address *
                                </label>
                                <textarea class="form-control" id="validationCustom08" rows="5" placeholder="Enter User Address" name="address"
                                    required>{{ $user->address }}</textarea>
                            </div>
                            {{-- Image --}}
                            <div class="col-md-6">
                                <label for="validationCustom10" class="form-label font-weight-bold">
                                    Image
                                </label>
                                <input class="mr-5 form-control" id="validationCustom10" type="file" name="image" onchange="document.getElementById('showImage').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="col-md-6" style="padding-left: 100px !important">
                                <img id="showImage" style="max-width: 100px; max-height: 100px;" src="{{ (!empty($user->image))?url('public/uploads/users/'.$user->image):url('public/backend/images/users/profile.svg') }}" alt="your image" />
                            </div>
                        </div>
                        <hr>
                        <div class="mt-4 form-group d-flex justify-content-center">
                            <button class="mr-2 btn save_btn" type="submit">Submit</button>
                            <button class="btn cancel_btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
