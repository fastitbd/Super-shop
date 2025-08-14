@extends('frontend.layouts.website')
@section('content')

    <section>
        <div class="cart_part">
            <div class="container">
                @if($cartItems->Count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="cart_heading">
                                <h3>Cart Items(1)</h3>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $items)
                                        <tr>
                                            <td>
                                                <div class="cart_product d-flex">
                                                    <div class="cart_product_img">
                                                        <img src="images/product/alu.png" alt="">
                                                    </div>
                                                    <div class="cart_product_name ">
                                                        <h5>{{$items->model->name}}</h5>
                                                        <p>CODE: {{$items->model->barcode}}</p>
                                                    </div>
                                                    <div class="cart_product_cancel">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">৳{{ $items->selling_price }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="input-group input_group">
                                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                                        <input type="text" class="form-control text-center" value="1">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>

                                                </div>

                                            </td>
                                            <td class="text-center">৳{{$item->subtotal()}}</td>
                                        </tr>
                                        @endforeach
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Order Summary</h5>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Subtotal
                                            <span>৳155.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Shipping Cost
                                            <span><a href="#"
                                                    class="text-decoration-underline text-primary">Calculate</a></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Including Discount
                                            <span class="text-danger">-৳10.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                            Total Cost
                                            <span>৳145.00</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary">Proceed to Checkout</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row mt-3 mb-5">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="#" class="btn btn-outline-secondary">← Continue Shopping</a>
                                <form action="#" method="POST">
                                    <!-- Include CSRF token if in Laravel -->
                                    <button type="submit" class="btn btn-danger">Clear Cart</button>
                                </form>
                            </div>
                        </div>

                    </div>

                @else
                    <div class="row mb-5">
                        <div class="col-md-12 text-center">
                            <h2>Your cart is empty !</h2>
                            <h5 class="mt-3">Add Items to it now.</h5>
                            <a href="#" class="btn btn-warning mt-5">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection