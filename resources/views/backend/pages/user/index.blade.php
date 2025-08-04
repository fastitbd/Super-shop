@extends('backend.layouts.master')
@section('section-title', 'User Management')
@section('page-title', 'User List')
@if (check_permission('user.create'))
    @section('action-button')
        <a class="btn add_list_btn" href="{{ route('user.create') }}">
            <i class="mr-2 feather icon-plus"></i>
            Add User
        </a>
    @endsection
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-header">
                    <h5 class="card-title">User List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead>
                                <tr class="header_bg">
                                    <th class="header_style_left">ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>User Role</th>
                                    <th>Status</th>
                                    <th class="header_style_right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>
                                            <img src="{{ (!empty($user->image))?url('public/uploads/users/'.$user->image):url('public/backend/images/users/profile.svg') }}" alt="{{ $user->name }}" style="height: 30px; width: 30px;">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->phone!=NULL)?$user->phone:'--'; }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>
                                            <input type="checkbox" data-toggle="toggle" data-on="Active"
                                                class="status-update" {{ $user->status == 1 ? 'checked' : '' }}
                                                data-off="Inactive" data-onstyle="success" data-offstyle="danger"
                                                data-id="{{ $user->id }}" data-model="User">
                                        </td>
                                        <td class="table_data_style_right">
                                            @if (check_permission('user.edit'))
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-primary-rgba">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
