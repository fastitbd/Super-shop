@extends('backend.layouts.master')
@section('section-title', 'Return')
@section('page-title', 'Return Purchase')
@section('action-button')
    <a href="{{ route('purchase.index') }}" class="btn add_list_btn">
        <i class="mr-2 feather icon-list"></i>
        Purchase List
    </a>
@endsection
@push('css')
    <style>
        .footerpos {
            display: grid;
            grid-template-columns: 1fr 50%;
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
            border-top-right-radius: 35px;
            border-bottom-right-radius: 35px;
        }

        .footerpos_right div {
            font-size: 25px;
            color: #fff;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="row width-auto">
        <div class="col-lg-12">
            <div class="card card_style">
                <form action="{{ route('rtnPurchase.update', $purchase->id) }}" id="pur_rtn_form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="cart-container">
                        <div class="cart-head">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr class="header_bg">
                                            <th class="header_style_left" width="17%">Product</th>
                                            <th width="45%">Quantity</th>
                                            <th width="19%">Rate</th>
                                            <th width="19%">Total</th>
                                            <th class="header_style_right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @php
                                            $returnProductIds = App\Models\ReturnPurchaseItem::where(
                                                'purchase_id',
                                                $purchase->id,
                                            )->pluck('product_id');
                                            // $purchaseItem = App\Models\PurchaseItem::where(
                                            //     'purchase_id',
                                            //     $purchase->id,
                                            // )->get();
                                            // dd($returnProductIds);
                                            $purchaseItem = App\Models\PurchaseItem::where('purchase_id', $purchase->id)
                                                ->where('is_return', 0)
                                                // ->whereNotIn('product_id', $returnProductIds)
                                                ->get();
                                        @endphp
                                        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}">
                                        @forelse ($purchaseItem as $item)
                                            @if ($item->stock_qty > 0)
                                                <tr>
                                                    <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                                    <td class="table_data_style_left">
                                                        {{ $item->product?->name }} - {{ $item->product?->barcode }}
                                                        @if ($item->product_variation_id != null)
                                                            ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }})
                                                        @endif
                                                        <input type="hidden" value="{{ $item->product?->id }}"
                                                            name="product_id[]" />
                                                        <input type="hidden" value="{{ $item->product_variation_id }}"
                                                            name="product_variation_id[]" />
                                                    </td>
                                                    <td style="width:250px">
                                                        <div class="form-row">
                                                            @if ($item->product->unit->related_unit == null)
                                                                {{-- ONLY MAIN UNIT --}}
                                                                <input type="text" class="has_sub_unit" hidden
                                                                    value="false">
                                                                <label class="ml-2  mr-2"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>

                                                                <input type="number" value="{{ $item->stock_qty }}"
                                                                    class="form-control col main_qty" name="main_qty[]"
                                                                    data-value="{{ product_stock($item->product) }}"
                                                                    data-related="{{ $item->product->unit->related_value }}"
                                                                    onkeydown="return event.keyCode !== 190" min="1">
                                                                <input type="hidden" name="sub_qty[]"
                                                                    value="{{ $item->sub_qty }}">
                                                            @else
                                                                {{-- HAS SUB UNIT --}}
                                                                <input type="text" class="has_sub_unit" hidden
                                                                    value="true">
                                                                <input type="text" class="conversion" hidden
                                                                    value="{{ $item->product->unit->related_value }}">

                                                                <label class="mr-1 ml-1"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                <input type="number" value="{{ $item->stock_qty }}"
                                                                    class="form-control col main_qty mr-1" name="main_qty[]"
                                                                    data-value="{{ product_stock($item->product) }}"
                                                                    data-related="{{ $item->product->unit->related_value }}"
                                                                    onkeydown="return event.keyCode !== 190" min="0">

                                                                <label class="mr-1"
                                                                    style="padding-top: 5px;">{{ $item->product->unit->related_unit->name }}:</label>
                                                                <input type="number"
                                                                    value="@if ($item->rtn_sub != null) {{ $item->sub_qty - $item->rtn_sub }}@else{{ $item->sub_qty }} @endif"
                                                                    class="form-control col sub_qty mr-1" name="sub_qty[]"
                                                                    onkeydown="return event.keyCode !== 190" min="0"
                                                                    max="{{ $item->product->unit->related_value - 1 }}">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" style="min-width: 100px;"
                                                            class="form-control rate" name="new_rate[]"
                                                            value="{{ $item->rate }}" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="min-width: 100px;" readonly
                                                            name="sub_total[]" class="form-control sub_total"
                                                            value="0" />
                                                    </td>
                                                    <td class="table_data_style_right">
                                                        <a href="#" class="remove-btn item-index"
                                                            data-value="${index}"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No Purchase Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light-primary">
                                            <td colspan="3" class="text-right fw-bold">Total</td>
                                            <td colspan="1">
                                                <input type="number" step="any" name="estimated_amount"
                                                    value="0" class="form-control estimated_amount" readonly>
                                            </td>
                                            <td class="text-right"></td>
                                        </tr>
                                        {{-- Discount --}}
                                        <tr class="bg-light-primary">
                                            <td colspan="3" class="text-right fw-bold">Discount</td>
                                            <td>
                                                <input type="text" class="form-control discount_amount" readonly
                                                    name="discount_amount" placeholder="0%"
                                                    value="{{ $item->purchase?->discount == 0.0 ? '0' : $item->purchase?->discount }}">

                                                <input type="hidden" class="form-control discount" name="discount"
                                                    placeholder="0%">
                                            </td>
                                            <td class="text-right"></td>
                                        </tr>
                                        <tr class="bg-light-primary">
                                            <td colspan="3" class="text-right fw-bold">Payment</td>
                                            <td>
                                                <select class="select2" name="bank_id" required>
                                                    @foreach ($bank_accounts as $bank_account)
                                                        <option value="{{ $bank_account->id }}">
                                                            {{ $bank_account->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-right"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <footer class="footerpos">
                                <div class="footerpos_left">
                                    <div class="text-center" id="grand_total"></div>
                                    <input type="hidden" name="payable_amount" id="payable_amount" value="">
                                </div>
                                <div class="footerpos_right">
                                    <div class="text-center" id="purchaseBtn"> Return Now </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.main_qty').forEach((mainQtyInput, index) => {
                const row = mainQtyInput.closest('tr');

                const rateInput = row.querySelector('.rate');
                const subTotalInput = row.querySelector('.sub_total');

                const mainQty = parseFloat(mainQtyInput.value) || 0;
                const rate = parseFloat(rateInput.value) || 0;

                const subtotal = (mainQty * rate).toFixed(2);
                subTotalInput.value = subtotal;
            });
        });
    </script>

    <script>
        // Select the input field when the page loads
        window.onload = function() {
            var inputField = document.getElementById('product_search');
            inputField.select();
        };
        $('#purchaseBtn').click(function() {
            $('#pur_rtn_form').submit();
        });
    </script>
    <script>
        // Page Load
        var empty = '';
        // $('body').addClass('toggle-menu');
        $('#product_search').blur();

        var localData = localStorage.getItem('pos-items') ? JSON.parse(localStorage.getItem('pos-items')) : [];

        function showList() {
            if (localData.length <= 0) {
                $("#tbody");
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
                    // console.log(product);
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
            var variation_data = ``;

            if (data.variations.length > 0) {
                variation_data +=
                    `<input type="text" class="has_size" data-has-size="true" hidden>
                                <select name="variation[]" id="" class="form-control size" required>
                                    <option value="">Select Variation</option>`;

                $.each(data.variations, function(index, value) {
                    variation_data += "<option stock=" + value.stock + " value=\"" +
                        value.id + "\">" + value.name + " - " + value.stock + "</option>";
                });

                variation_data += '</select>';
            } else {
                variation_data =
                    `<input type="text" class="has_size" data-has-size="false" hidden>`;
            }

            if (data.product.unit.related_unit == null) {
                // alert("NO SUB UNIT");
                quantity_data =
                    `<input type="text" class="has_sub_unit" hidden value="false">
                        <label class="ml-2 mr-2" style="padding-top: 5px;">${data.product.unit.name}:</label>
                        <input type="number" value="1" class="form-control col main_qty" name="main_qty[]" 
                        data-value="${data.stock_qty}" data-related="${data.product.unit.related_value}" 
                        onkeydown="return event.keyCode !== 190" min="0">`;
            } else {
                // alert("SUB UNIT");
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

            let dom = `
                <tr id="tbody_tr">
                    <td class="table_data_style_left">
                    ${data.product.name + " - " + data.product.barcode}
                    
                    <input type="hidden" value="${data.product.id}" name="product_id[]" />
                    </td>
                    <td style="min-width: 120px;">
                        ${variation_data}
                    </td>
                    <td>
                        <div class="form-row" style="min-width: 100px;">
                            ${quantity_data}
                        </div>
                    </td>
                    <td>
                    <input type="number" style="min-width: 100px;" value="${data.product.selling_price}" class="form-control rate" name="new_rate[]" />
                    </td>
                    <td>
                    <input type="number" style="min-width: 100px;" readonly name="sub_total[]" class="form-control sub_total" value="${data.product.selling_price}"/>
                    </td>
                    <td class="table_data_style_right">
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

            // alert(converted_sub);

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
            $(".sub_total").text(estimated_amount.toFixed(2));
            $(".discount_amount").text(discountAmount.toFixed(2));
            $(".discount").val(discountAmount.toFixed(2));
            $(".payable_amount").text(total_amount.toFixed(2));
            let pay = $("#payable_amount").val(total_amount.toFixed(2));
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
        // $(".pay_amount").on("keyup change", function() {
        //     var pay_amount = $(this).val();
        //     if (pay_amount == "") {
        //         pay_amount = '0.00';
        //     }
        //     pay_amount = parseFloat(pay_amount);
        //     pay_amount = pay_amount.toFixed(2);
        //     var payable_amount = $("#payment_modal")
        //         .find("input[name=payable_amount]")
        //         .val();

        //     var due_amount = payable_amount - pay_amount;
        //     due_amount = parseFloat(due_amount);
        //     due_amount = due_amount.toFixed(2);
        //     var balance = '0.00';
        //     if (due_amount < 0) {
        //         balance = Math.abs(due_amount);
        //         due_amount = '0.00';
        //     }

        //     $("#payment_modal").find(".due_amount").text(due_amount);
        //     $("#payment_modal").find("input[name=due_amount]").val(due_amount);

        //     $("#payment_modal").find(".balance").text(balance);
        //     $("#payment_modal").find("input[name=balance]").val(balance);

        //     $("#payment_modal").find(".paid_amount").text(pay_amount);
        //     $("#payment_modal").find("input[name=paid_amount]").val(pay_amount);
        // });

        //id="checkout"
        // $("#checkout").on("click", function() {
        //     var customer_id = $("#customer_id").val();
        //     var payable_amount = $("#payable_amount").val();
        //     var pay_amount = $(".pay_amount").val();
        //     var paid_amount = $("#paid_amount").val();
        //     var due_amount = $("#due_amount").val();
        //     if (parseFloat(pay_amount) > parseFloat(payable_amount)) {
        //         iziToast.warning({
        //             title: "Sorry Over Payment Not Allowed.",
        //             position: "topRight",
        //         });
        //         return false;
        //     }
        //     if (parseFloat(pay_amount) < 0) {
        //         iziToast.warning({
        //             title: "Sorry Below Payment Not Allowed.",
        //             position: "topRight",
        //         });
        //         return false;
        //     }
        //     if (paid_amount == 0.00 && due_amount == 0.00) {
        //         iziToast.warning({
        //             title: "Please Enter Pay Amount.",
        //             position: "topRight",
        //         });
        //         return false;
        //     }
        //     if (customer_id == 1 && due_amount != 0.00) {
        //         iziToast.warning({
        //             title: "Walking Customer Can't to Create a Due",
        //             position: "topRight",
        //         });
        //         return false;
        //     }
        //     localStorage.clear();
        //     $("#payment_form").submit();
        // });

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
