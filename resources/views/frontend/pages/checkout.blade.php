@extends('frontend.layouts.website')
@section('content')
    <div class="container py-5">
        <form action="{{ route('order.store') }}" method="POST">
            @csrf

   

            <div class="row">

                <div class="col-lg-7 mb-4">
                    <!-- Billing -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Billing Details</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3 col-6 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3 col-6 {{ $errors->has('district') ? ' has-error' : '' }}">
                                    <label class="form-label">District</label>
                                    <input type="text" name="district" class="form-control" value="{{ old('district') }}">
                                    @if ($errors->has('district'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ndistrictame') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3 col-6 {{ $errors->has('thana') ? ' has-error' : '' }}">
                                    <label class="form-label">Thana</label>
                                    <input type="text" name="thana" class="form-control" value="{{ old('thana') }}">
                                    @if ($errors->has('thana'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('thana') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3 col-6 {{ $errors->has('unions') ? ' has-error' : '' }}">
                                    <label class="form-label">Union</label>
                                    <input type="text" name="unions" class="form-control" value="{{ old('unions') }}">
                                    @if ($errors->has('unions'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unions') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3 col-6 {{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label class="form-label">Street Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input type="hidden" name="sale_type" value="Online">
                                <input type="hidden" name="open_receivable" value="0">
                                <input type="hidden" name="open_payable" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Your Order</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group mb-3">
                                @foreach ($cartItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/products/' . $item->model->images) }}"
                                                width="50" class="me-3 rounded">
                                            <div>
                                                <h6 class="mb-0">{{ $item->name }}</h6>
                                                <small>Quantity: {{ $item->qty }}</small>
                                            </div>
                                        </div>
                                        <input class="" type="hidden" value="{{ $item->name }}" name="product_name[]">
                                        <input class="" type="hidden" value="{{ $item->id }}" name="product_id[]">
                                        <span>TK {{ number_format($item->price * $item->qty, 2) }}</span>
                                        <input class="" type="hidden" value="{{ $item->price }}" name="rate[]">
                                        <input class="" type="hidden" value="{{ $item->qty }}" name="main_qty[]">
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Totals -->
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong id="subtotal" data-total="{{ $cartTotal }}">
                                        TK {{ number_format($cartTotal, 2) }}
                                    </strong>
                                </li>
                             
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total</span>
                                    <strong id="grand-total">
                                        TK {{ number_format($cartTotal, 2) }}
                                    </strong>
                                </li>
                            </ul>
                            <!-- Hidden Inputs -->
                            <input type="hidden" name="estimated_amount" id="estimated_amount" value="{{ $cartTotal }}">
                            <input type="hidden" name="delivery_charge" id="shipping_charge"
                               >
                            <input type="hidden" name="payable_amount" id="payable_amount"
                                value="{{ $cartTotal}}">
                            <input type="hidden" name="due_amount" id="due_amount"
                                value="{{ $cartTotal}}">
                            <input type="hidden" name="paid_amount" value="0">

                            <button type="submit" class="btn btn-success w-100 py-2">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection


