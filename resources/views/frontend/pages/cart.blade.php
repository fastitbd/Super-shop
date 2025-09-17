@extends('frontend.layouts.website')
@section('content')

    <section>
        <div class="cart_part">
            <div class="container">
                @if($cartItems->Count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="cart_heading">
    <h3>Cart Items({{ \Cart::instance('cart')->count() }})</h3>
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
                                                            <img src="{{ asset('uploads/products/' . $items->model->images) }}"
                                                                alt="">
                                                        </div>
                                                        <div class="cart_product_name ">
                                                            <h5>{{$items->model->name}}</h5>
                                                            <p>CODE: {{$items->model->barcode}}</p>
                                                        </div>
                                                        <div class="cart_product_cancel" data-rowid="{{ $items->rowId }}">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">৳{{$items->price}}</td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group input_group">
                                                            <button class="btn btn-outline-secondary btn-decrement"
                                                                data-id="{{ $items->id }}" type="button">-</button>
                                                            <input data-rowid="{{$items->rowId}}" type="text"
                                                                class="form-control text-center quantity-input"
                                                                value="{{ $items->qty }}" data-id="{{ $items->id }}">

                                                            <button class="btn btn-outline-secondary btn-increment"
                                                                data-id="{{ $items->id }}" type="button">+</button>
                                                        </div>

                                                    </div>

                                                </td>
                                                <td class="text-center">৳{{ $items->price * $items->qty }}</td>
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
                                            <span>৳{{ number_format($cartItems->sum(fn($items) => $items->price * $items->qty), 2) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Shipping Cost
                                            <span><a href="#"
                                                    class="text-decoration-underline text-primary">Calculate</a></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Including Discount
                                            <span class="text-danger">-৳00.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                            Total Cost
                                            <span>
                                                ৳{{ number_format($cartItems->sum(fn($items) => $items->price * $items->qty) - session('cart_discount', 0), 2) }}
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                          <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row mt-3 mb-5">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Continue Shopping</a>
                                <button type="submit" id="clearCartBtn" class="btn btn-danger">Clear Cart</button>
                                
                            </div>
                        </div>

                    </div>

                @else
                    <div class="row mb-5">
                        <div class="col-md-12 text-center">
                            <h2>Your cart is empty !</h2>
                            <h5 class="mt-3">Add Items to it now.</h5>
                            <a href="{{ route('home') }}" class="btn btn-warning mt-5">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <form id="updateCartQty" action="{{route('cart.update')}}" method="POST">
        @csrf
        @method('put')
        <input type="hidden" id="rowId" name="rowId" />
        <input type="hidden" id="quantity" name="quantity" />
    </form>

    <form id="deleteFromCart" action="{{ route('cart.remove') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" id="rowId_D" name="rowId">
    </form>

    <form id="clearCart" action="{{ route('cart.clear') }}" method="POST">
        @csrf
        @method('DELETE')
    </form>



    <script>
        function updateQuantity(qty) {
            $('#rowId').val($(qty).data('rowid'));
            $('#quantity').val($(qty).val());
            $('#updateCartQty').submit();
        }


    </script>


    <!-- remove cart item -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Listen for clicks on all remove icons
            document.querySelectorAll(".cart_product_cancel").forEach(cancelBtn => {
                cancelBtn.addEventListener("click", function () {
                    let rowId = this.dataset.rowid;

                    // Optional: Confirm before removing
                    if (confirm("Are you sure you want to remove this item?")) {
                        document.getElementById("rowId_D").value = rowId;
                        document.getElementById("deleteFromCart").submit();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Clear Cart Button
            const clearCartBtn = document.getElementById("clearCartBtn");
            if (clearCartBtn) {
                clearCartBtn.addEventListener("click", function () {
                    if (confirm("Are you sure you want to clear your entire cart?")) {
                        document.getElementById("clearCart").submit();
                    }
                });
            }
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handle Increment
            document.querySelectorAll(".btn-increment").forEach(button => {
                button.addEventListener("click", function () {
                    let input = this.closest(".input_group").querySelector(".quantity-input");
                    let rowId = input.dataset.rowid;
                    let currentQty = parseInt(input.value) || 1;
                    input.value = currentQty + 1;

                    updateCartQuantity(rowId, input.value);
                });
            });

            // Handle Decrement
            document.querySelectorAll(".btn-decrement").forEach(button => {
                button.addEventListener("click", function () {
                    let input = this.closest(".input_group").querySelector(".quantity-input");
                    let rowId = input.dataset.rowid;
                    let currentQty = parseInt(input.value) || 1;
                    if (currentQty > 1) {
                        input.value = currentQty - 1;
                        updateCartQuantity(rowId, input.value);
                    }
                });
            });

            // Handle Direct Input Change
            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("change", function () {
                    let rowId = this.dataset.rowid;
                    updateCartQuantity(rowId, this.value);
                });
            });

            // Function to Submit Quantity Update
            function updateCartQuantity(rowId, quantity) {
                document.getElementById('rowId').value = rowId;
                document.getElementById('quantity').value = quantity;
                document.getElementById('updateCartQty').submit();
            }
        });
    </script>


@endsection