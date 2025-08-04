@extends('backend.layouts.master')
@section('page-title', 'Invoice Edit')

@push('css')
    <style>
        .invoice-contentbar {
            margin: 80px 5px 0 5px;
            padding: 20px;
            margin-bottom: 60px;
        }

        /* pos footer section start */

        .footerpos {
            display: grid;
            grid-template-columns: 1fr 50%;
            text-align: center;
        }

        .footerpos .footerpos_left {
            background-color: #000ce2 !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 12px 10px;
            border-top-left-radius: 35px;
            border-bottom-left-radius: 35px;
        }

        .footerpos .footerpos_left div {
            font-size: 25px;
            color: #fff;
        }

        .footerpos_right {
            background-color: #00a65a !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 12px 10px;
            /* border-top-right-radius: 35px;
                border-bottom-right-radius: 35px; */
            border-radius: 35px;
            text-align: center;
        }

        .footerpos_right div {
            font-size: 25px;
            color: #fff;
            cursor: pointer;
        }

        .productcss {
            border: 1px solid #DDD;
            cursor: pointer;
            padding-bottom: 30px;
            height: 262px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('invoice')
    <div class="invoice-contentbar">
        <div class="row">
            <!-- Start col -->
            <div class="col-md-10 offset-1">
                <div class="card card_top">
                    <form action="{{ route('invoice.up', $invoice->id) }}" id="payment_form" method="POST">
                        @csrf
                        <div class="cart-container">
                            <div class="cart-head">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" id="date" value="{{ $invoice->date }}"
                                        name="date" required>
                                </div>
                                <div class="row align-items-center ecommerce-sortby">
                                    <!-- Start col -->
                                    <div class="col-md-12 col-12 " style="margin-right: -6px">
                                        <input type="text" class="form-control" readonly name=""
                                            value="{{ $invoice->customer?->name }}" id="">
                                    </div>
                                    <!-- End col -->
                                </div>
                            </div>
                            <div class="cart-head">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr class="header_bg">
                                                <th class="header_style_left" width="5%">#Sl</th>
                                                <th width="15%">Product</th>
                                                <th width="25%">Quantity</th>
                                                <th width="8%">Rate</th>
                                                <th class="header_style_right" width="10%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoiceItem as $key => $item)
                                                <input type="hidden" name="itemId[]" value="{{ $item->id }}">
                                                <tr>
                                                    <td class="table_data_style_left">{{ ++$key }}</td>
                                                    <td style="">
                                                        {{ $item->product->name }}
                                                        <input type="hidden" value="{{ $item->product_id }}"
                                                            name="product_id[]" />
                                                    </td>
                                                    <td>
                                                        <div class="form-row" style="min-width: 100px;">
                                                            @if ($item->product->is_service == 0)
                                                                @if ($item->product->unit->related_unit == null)
                                                                    <input type="text" class="has_sub_unit" hidden
                                                                        value="false">
                                                                    <label class="ml-2 mr-2"
                                                                        style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                    <input type="number" value="{{ $item->main_qty }}"
                                                                        class="form-control col main_qty" name="main_qty[]"
                                                                        data-related="{{ $item->product->unit->related_value }}"
                                                                        onkeydown="return event.keyCode !== 190"
                                                                        min="0">
                                                                @else
                                                                    <input type="text" class="has_sub_unit" hidden
                                                                        value="true">
                                                                    <input type="text" class="conversion" hidden
                                                                        value="${data.product.unit.related_value}">
                                                                    <label class="mr-1 ml-1"
                                                                        style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                    <input type="number" value="{{ $item->main_qty }}"
                                                                        class="form-control col main_qty mr-1"
                                                                        name="main_qty[]"
                                                                        data-related="{{ $item->product->unit->related_value }}"
                                                                        onkeydown="return event.keyCode !== 190"
                                                                        min="0">

                                                                    <label class="mr-1"
                                                                        style="padding-top: 5px;">{{ $item->product->unit->related_unit->name }}:</label>
                                                                    <input type="number" value="{{ $item->sub_qty }}"
                                                                        class="form-control col sub_qty mr-1"
                                                                        name="sub_qty[]"
                                                                        onkeydown="return event.keyCode !== 190"
                                                                        min="0" max="">
                                                                @endif
                                                            @else
                                                                <label class="ml-2 mr-2"
                                                                    style="padding-top: 5px;">Pcs:</label>
                                                                <input type="number" value="{{ $item->main_qty }}"
                                                                    class="form-control col main_qty" name="main_qty[]"
                                                                    min="0">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" value="{{ $item->rate }}"
                                                            class="form-control rate" name="rate[]" />
                                                    </td>
                                                    <td class="table_data_style_right">
                                                        <input type="number" readonly name="sub_total[]"
                                                            class="form-control sub_total" value="{{ $item->subtotal }}" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light-primary">
                                                <td colspan="4" class="text-right fw-bold">Grand Total</td>
                                                <td colspan="2">
                                                    <input type="number" step="any" name="estimated_amount"
                                                        value="0" class="form-control estimated_amount" readonly>
                                                </td>
                                            </tr>
                                            {{-- Discount --}}
                                            <tr class="bg-light-primary">
                                                <td colspan="4" class="text-right fw-bold">Discount</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control discount_amount"
                                                        name="discount_amount" placeholder="0%"
                                                        value="{{ $invoice->discount }}">

                                                    <input type="hidden" class="form-control discount" name="discount">
                                                </td>
                                            </tr>
                                            <tr class="bg-light-primary">
                                                <td colspan="4" class="text-right fw-bold">Total</td>
                                                <td colspan="2">
                                                    <div class="text-center" style="font-size: 20px;" id="grand_total">
                                                    </div>
                                                    <input type="hidden" id="grandTotal" name="total_amount">
                                                </td>
                                            </tr>
                                            <input type="hidden" name="total_paid" value="{{ $invoice->total_paid }}">
                                            <input type="hidden" name="total_due" value="{{ $invoice->total_due }}">
                                            <input type="hidden" name="customer_id"
                                                value="{{ $invoice->customer_id }}">
                                        </tfoot>
                                    </table>
                                </div>
                                <footer class="footerpos">
                                    <div></div>
                                    <div class="footerpos_right"><button class="border-0" style="background: #00a65a;">
                                            <div class="text-center" id=""> Update </div>
                                        </button>
                                    </div>
                                </footer>
                            </div>
                        </div>
                        {{-- @include('backend.pages.invoice.payment-modal') --}}
                    </form>
                </div>
            </div>
            <!-- End col -->
        </div>
    </div>
    <!-- Payment Modal -->


@endsection

@push('js')
    <script>
        // Page Load
        var empty = '';
        $('#product_search').blur();

        var localData = localStorage.getItem('pos-items') ? JSON.parse(localStorage.getItem('pos-items')) : [];

        function showList() {
            if (localData.length <= 0) {
                $("#tbody").html(empty);
            } else {
                localData.forEach((item, index) => {
                    domPrepend(item, index);
                });
            }
        }

        showList();
        estimatedAmount();

        var cartList = [];

        // Helper Functions
        function empty_field_check(placeholder) {
            // console.log(typeof placeholder);
            if (typeof placeholder == NaN) {
                placeholder = 0;
            } else if (placeholder == null) {
                placeholder = 0;
            } else if (placeholder.trim() == "") {
                placeholder = 0;
            } else if (placeholder == 'null') {
                placeholder = 0;
            }
            return placeholder;
        }

        function to_sub_unit(main_val, sub_val, related_by, has_sub_unit) {
            if (has_sub_unit == 'true') {
                return (main_val * related_by) + sub_val;
            }
            return main_val;


        }

        function convert_to_main_and_sub(quantity, has_sub_unit, related_by) {
            var main_qty = 0;
            var main_qty_as_sub = 0;
            var sub_qty = 0;

            main_qty = parseInt(quantity);

            if (has_sub_unit == "true" && quantity != 0 && related_by != 0) {
                main_qty = parseInt(quantity / related_by);
                main_qty_as_sub = main_qty * related_by;
                sub_qty = quantity - main_qty_as_sub;
            }

            return {
                'main_qty': main_qty,
                'sub_qty': sub_qty
            };
        }

        function calculate_sub_total(main_qty, sub_qty, unit_price, related_by, has_sub_unit) {
            var sub_unit_price = 0;

            if (has_sub_unit == "true" && related_by != 0) {
                sub_unit_price = parseFloat(unit_price / related_by);
            }
            var main_price = main_qty * unit_price;
            var sub_price = sub_qty * sub_unit_price;

            return parseFloat(main_price + sub_price).toFixed(2);
        }

        // Manage Addition and Removal from LocalStorage
        function pExist(pid) {
            let ldata = localStorage.getItem('pos-items') ? JSON.parse(localStorage.getItem('pos-items')) : [];
            return ldata.some(function(el) {
                return el.product.id === pid
            });
        }

        function storedata(data) {
            if (localStorage.getItem('pos-items') != null) {
                cartList = JSON.parse(localStorage.getItem('pos-items'))
                cartList.push(data);
            } else {
                cartList.push(data);
            }
            localStorage.setItem('pos-items', JSON.stringify(cartList));
        }

        function addProductToCard(data) {
            storedata(data);
            var x = 0;
            domPrepend(data, x++);
            estimatedAmount();
        }

        // Search Product
        $("#product_search").autocomplete({
            source: function(req, res) {
                let url = "{{ route('product-search') }}";
                $.get(url, {
                    req: req.term
                }, (data) => {
                    res($.map(data, function(item) {
                        return {
                            id: item.id,
                            value: item.name + " " + item.barcode,
                            price: item.selling_price
                        }
                    })); // end res

                });
            },
            select: function(event, ui) {

                $(this).val(ui.item.value);
                $("#search_product_id").val(ui.item.id);
                let url = "{{ route('search-product-id', 'my_id') }}".replace('my_id', ui.item.id);
                $.get(url, (data) => {

                    // check stock
                    if (data.stock_qty <= 0) {
                        iziToast.warning({
                            title: "This product is Stock out. Please Purchases the Product.",
                            position: "topRight",
                        });
                        return false;
                    }


                    if (pExist(data.product.id) == true) {
                        iziToast.warning({
                            title: "Please Increase the quantity.",
                            position: "topRight",
                        });
                    } else {
                        addProductToCard(data);
                    }

                });

                $(this).val('');

                return false;
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');

                }
            },
            minLength: 0
        });

        // Manage Cart items
        $(document).on('click', '.product', function() {
            let productId = $(this).attr('data-value');
            let url = "{{ route('pos-product-id', 'my_id') }}".replace('my_id', productId);
            $.get(url, data => {
                // console.log(data.product.variations);
                // check stock
                if (data.stock_qty <= 0) {
                    iziToast.warning({
                        title: "This product is Stock out. Please Purchases the Product.",
                        position: "topRight",
                    });
                    return false;
                }

                if (pExist(data.product.id) == true) {
                    iziToast.warning({
                        title: "Please Increase the quantity.",
                        position: "topRight",
                    });
                } else {
                    addProductToCard(data);
                }
            }); // Load Data to cart

        });


        $(document).on('click', '.remove-btn', function() {
            let itemIndex = $(this).attr('data-value');
            localData.splice(itemIndex, 1);
            localStorage.removeItem('pos-items');
            localStorage.setItem('pos-items', JSON.stringify(localData))
            $(this).parents('tr').remove();
            estimatedAmount();
        });

        $("#clearList").on('click', function() {
            localStorage.removeItem('pos-items');
            $("#tbody").html(empty);
            estimatedAmount();
        });



        function domPrepend(data = null, index = null) {
            var name = data.product.name;
            var quantity_data = '';

            if (data.product.unit.related_unit == null) {
                quantity_data =
                    `<input type="text" class="has_sub_unit" hidden value="false">
                        <label class="ml-2 mr-2" style="padding-top: 5px;">${data.product.unit.name}:</label>
                        <input type="number" value="1" class="form-control col main_qty" name="main_qty[]" 
                        data-value="${data.stock_qty}" data-related="${data.product.unit.related_value}" 
                        onkeydown="return event.keyCode !== 190" min="0">`;
            } else {
                quantity_data =
                    `<input type="text" class="has_sub_unit" hidden value="true">
                        <input type="text" class="conversion" hidden value="${data.product.unit.related_value}">
                        <label class="mr-1 ml-1" style="padding-top: 5px;">${data.product.unit.name}:</label>
                        <input type="number" value="1" class="form-control col main_qty mr-1" name="main_qty[]" 
                        data-value="${data.stock_qty}" data-related="${data.product.unit.related_value}" 
                        onkeydown="return event.keyCode !== 190" min="0">

                        <label class="mr-1" style="padding-top: 5px;">${data.product.unit.related_unit.name}:</label>
                        <input type="number" value="0" class="form-control col sub_qty mr-1" name="sub_qty[]"  
                        onkeydown="return event.keyCode !== 190" min="0" max="${data.product.unit.related_value-1}">`;
            }

            // ${data.product.name + " - Stock (" + data.stock_qty +")"}
            let dom = `
                <tr id="tbody_tr">
                    <td style="min-width: 100px;">
                    ${data.product.name + " - " + data.product.barcode }
                    <input type="hidden" class="name" value="${name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '')}" name="name[]" />
                    <input type="hidden" value="${data.product.id}" name="product_id[]" />
                    </td>
                    
                    <td>
                        <div class="form-row" style="min-width: 100px;">
                            ${quantity_data}
                        </div>
                    </td>
                    <td>
                    <input type="number" style="min-width: 100px;" value="${data.product.selling_price}" class="form-control rate" name="rate[]" />
                    </td>
                    <td>
                    <input type="number" style="min-width: 100px;" readonly name="sub_total[]" class="form-control sub_total" value="${data.product.selling_price}"/>
                    </td>
                    <td>
                    <a href="#" class="remove-btn item-index" data-value="${index}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            `;
            $("#tbody").prepend(dom);
        }

        function handle_change(obj) {
            var main_val = parseInt(empty_field_check(obj.parents('tr').find('.main_qty').val()));
            var sub_val = parseInt(empty_field_check(obj.parents('tr').find('.sub_qty').val()));
            let related_by = parseInt(empty_field_check(obj.parents('tr').find('.main_qty').attr('data-related')));
            var has_sub_unit = obj.parents('tr').find('.has_sub_unit').val();
            let converted_sub = to_sub_unit(main_val, sub_val, related_by, has_sub_unit);
            let stock = obj.parents('tr').find('.main_qty').attr('data-value');
            // alert(stock);


            if (stock < converted_sub) {
                // put the max stock
                var converted;
                if (has_sub_unit == "true") {
                    converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                    obj.parents('tr').find('.main_qty').val(converted.main_qty);
                    obj.parents('tr').find('.sub_qty').val(converted.sub_qty);
                } else {
                    converted = convert_to_main_and_sub(stock, has_sub_unit, related_by);
                    obj.parents('tr').find('.main_qty').val(converted.main_qty);
                }

                let price = obj.parents('tr').find('.rate').val();
                price = parseFloat(price);

                let subTotal = calculate_sub_total(converted.main_qty, converted.sub_qty, price, related_by, has_sub_unit);

                obj.parents('tr').find('.sub_total').val(subTotal);
                estimatedAmount();

                iziToast.warning({
                    title: "Not Enough Stock.",
                    position: "topRight",
                });
            } else {
                let price = obj.parents('tr').find('.rate').val();
                price = parseFloat(price);
                let subTotal = calculate_sub_total(main_val, sub_val, price, related_by, has_sub_unit);
                obj.parents('tr').find('.sub_total').val(subTotal);
                estimatedAmount();
            }
        }

        // main_qty
        $(document).on('keyup change', '.main_qty', function(e) {
            handle_change($(this));
        });

        //sub_qty change
        $(document).on('keyup change', '.sub_qty', function(e) {
            handle_change($(this));
        });

        // rate change
        $(document).on('keyup change', '.rate', function(e) {
            handle_change($(this));
            return;
        });

        //estimatedAmount function
        function estimatedAmount() {
            var sum = 0;

            $(".sub_total").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            $("input[name='estimated_amount']").val(sum);
            totalCalculate();
        }

        // Other Calculations - discount
        $(document).on(
            "keyup change",
            "input[name='discount_amount']",
            function() {
                totalCalculate();
            }
        );


        function totalCalculate() {
            let discount = $(".discount_amount").val();
            let estimated_amount = parseFloat(
                $("input[name='estimated_amount']").val()
            );

            discount = empty_field_check(discount);


            let discountAmount = 0;
            if ((typeof discount === 'string' || discount instanceof String) && discount.includes("%")) {
                let removed_percent_discount = discount.replace('%', '');
                discount = parseFloat(removed_percent_discount);
                discountAmount = Math.round($(".estimated_amount").val() * (discount / 100));
            } else {
                discountAmount = parseFloat(discount);
            }
            let total_amount = estimated_amount - discountAmount;
            $("#grand_total").text(total_amount.toFixed(2));
            $("#grandTotal").val(total_amount.toFixed(2));
            $(".sub_total").text(estimated_amount.toFixed(2));
            $(".discount_amount").text(discountAmount.toFixed(2));
            $(".discount").val(discountAmount.toFixed(2));
            $(".payable_amount").text(total_amount.toFixed(2));
            $("#payable_amount").val(total_amount.toFixed(2));
        }

        // ===================order modal===================
        //payment_modal_btn
        $("#payment_modal_btn").on("click", function() {
            //date
            var date = $("#date").val();
            if (date == '') {
                //Walking Customer Can't to Create a Due
                iziToast.warning({
                    title: "Please select a date.",
                    position: "topRight",
                });
                return false;
            }
            //customer_id
            var customer_id = $("#customer_id").val();
            if (customer_id == '') {
                //Walking Customer Can't to Create a Due
                iziToast.warning({
                    title: "Please select a customer.",
                    position: "topRight",
                });
                return false;
            }
            //order_modal_obj
            if ($.trim($('.name').val()) == '') {
                iziToast.warning({
                    title: "Please select at least one product",
                    position: "topRight",
                });
                return false;
            }
            // count of tr in cart_list table
            var count = $("#tbody").find("tr#tbody_tr").length;
            $(".total_item").text(count);
            //get customer name from id="customer_id"
            var customer_name = $("#customer_id").find("option:selected").text();
            $("#payment_modal").find("#customer_name").text(customer_name);
            var customer_id = $("#customer_id").val();
            $("#payment_modal").find("input[name=customer_id]").val(customer_id);
            //show payment_modal
            $("#payment_modal").modal("show");
        });

        //.full_pay_btn
        $(".full_pay_btn").on("click", function() {
            var payable_amount = $("#grand_total").text();
            payable_amount = parseFloat(payable_amount);
            payable_amount = payable_amount.toFixed(2);

            $(".pay_amount").val(payable_amount);
            $("#paid_amount").val(payable_amount);
            $(".paid_amount").text(payable_amount);
            $("#due_amount").val('0.00');
            $(".due_amount").text('0.00');
        });

        //.full_due_btn
        $(".full_due_btn").on("click", function() {
            var payable_amount = $("#grand_total").text();
            payable_amount = parseFloat(payable_amount);
            payable_amount = payable_amount.toFixed(2);

            $(".pay_amount").val('0.00');
            $("#due_amount").val(payable_amount);
            $(".due_amount").text(payable_amount);
            $("#paid_amount").val('0.00');
            $(".paid_amount").text('0.00');
        });

        //name="pay_amount"
        $(".pay_amount").on("keyup change", function() {
            var pay_amount = $(this).val();
            if (pay_amount == "") {
                pay_amount = '0.00';
            }
            pay_amount = parseFloat(pay_amount);
            pay_amount = pay_amount.toFixed(2);
            var payable_amount = $("#payment_modal")
                .find("input[name=payable_amount]")
                .val();

            var due_amount = payable_amount - pay_amount;
            due_amount = parseFloat(due_amount);
            due_amount = due_amount.toFixed(2);
            var balance = '0.00';
            if (due_amount < 0) {
                balance = Math.abs(due_amount);
                due_amount = '0.00';
            }

            $("#payment_modal").find(".due_amount").text(due_amount);
            $("#payment_modal").find("input[name=due_amount]").val(due_amount);

            $("#payment_modal").find(".balance").text(balance);
            $("#payment_modal").find("input[name=balance]").val(balance);

            $("#payment_modal").find(".paid_amount").text(pay_amount);
            $("#payment_modal").find("input[name=paid_amount]").val(pay_amount);
        });

        //id="checkout"
        $("#checkout").on("click", function() {
            var customer_id = $("#customer_id").val();
            var payable_amount = $("#payable_amount").val();
            var pay_amount = $(".pay_amount").val();
            var paid_amount = $("#paid_amount").val();
            var due_amount = $("#due_amount").val();
            if (parseFloat(pay_amount) > parseFloat(payable_amount)) {
                iziToast.warning({
                    title: "Sorry Over Payment Not Allowed.",
                    position: "topRight",
                });
                return false;
            }
            if (parseFloat(pay_amount) < 0) {
                iziToast.warning({
                    title: "Sorry Below Payment Not Allowed.",
                    position: "topRight",
                });
                return false;
            }
            if (paid_amount == 0.00 && due_amount == 0.00) {
                iziToast.warning({
                    title: "Please Enter Pay Amount.",
                    position: "topRight",
                });
                return false;
            }
            if (customer_id == 1 && due_amount != 0.00) {
                iziToast.warning({
                    title: "Walking Customer Can't to Create a Due",
                    position: "topRight",
                });
                return false;
            }
            localStorage.clear();
            $("#payment_form").submit();
        });

        // Product Search
        $(document).on("change", "#getProductsByCat", function() {
            var cat_id = $(this).val();
            $.ajax({
                url: "{{ route('posProducts') }}",
                type: "GET",
                data: {
                    cat_id: cat_id
                },
                success: function(data) {
                    $("#products").html(data);
                    // console.log(data)
                },
                error: function() {
                    alert('Error !');
                }
            });
        });
    </script>
@endpush
