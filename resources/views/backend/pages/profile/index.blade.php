@extends('backend.layouts.master')
@section('section-title', 'User Profile')
@section('page-title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header profile">
                    Update User Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <label for="exampleInputEmail1">Name <span class="text-danger">*</span> </label>
                            <input class="form-control" type="text" name="name" value="{{ $data->name }}">
                            <div class="errors">{{ ($errors->has('name'))?$errors->first('name'):''; }}</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address <span class="text-danger">*</span> </label>
                            <input class="form-control" type="email" value="{{ $data->email }}" name="email">
                            <div class="errors">{{ ($errors->has('email'))?$errors->first('email'):''; }}</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Phone No <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" id="" name="phone" value="{{ $data->phone }}">
                            <div class="errors">{{ ($errors->has('phone'))?$errors->first('phone'):''; }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header profile">
                    Change Password
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <label for="exampleInputEmail1">Current Password <span class="text-danger">*</span> </label>
                            <input class="form-control" type="password" name="password">
                            <div class="errors">{{ ($errors->has('password'))?$errors->first('password'):''; }}</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password <span class="text-danger">*</span> </label>
                            <input class="form-control" type="password" name="new_password">
                            <div class="errors">{{ ($errors->has('new_password'))?$errors->first('new_password'):''; }}</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password <span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" id="" name="con_password">
                            <div class="errors">{{ ($errors->has('con_password'))?$errors->first('con_password'):''; }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
