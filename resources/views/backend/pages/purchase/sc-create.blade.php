@extends('backend.layouts.master')
@section('section-title', 'Purchase')
@section('page-title', 'Add Purchase')
@section('action-button')
    <a href="{{ route('purchase.index') }}" class="btn add_list_btn">
        <i class="mr-2 feather icon-list"></i>
        Purchase List
    </a>
@endsection

@section('content')
    <div class="row width-auto">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form class="needs-validation" novalidate id="purchaseForm" action="{{ route('purchase.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            {{-- Purchase Date --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label font-weight-bold">
                                    Date *
                                </label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date"
                                    required>
                            </div>
                            {{-- Purchase No --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom02" class="form-label font-weight-bold">Purchase No *</label>
                                <input type="text" class="form-control" value="{{ $purchase_no }}" name="purchase_no"
                                    required readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            {{-- Note --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label font-weight-bold">
                                    Note</label>
                                <input type="text" class="form-control" placeholder="Enter Note" name="note">
                            </div>
                            {{-- Supplier --}}
                            <div class="mb-3 col-md-6">
                                <div class="row">
                                    <div class="col-md-11 col-10" style="margin-right: -7px">
                                        <label class="form-label font-weight-bold">Supplier *</label>
                                        <select class="select2" id="supplier" name="supplier_id" required>
                                            {{-- <option selected value="">Select Supplier</option> --}}
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-2 m-0 p-0">
                                        <label class="form-label font-weight-bold"></label>
                                        <div class="" style="margin-top: 10px">
                                            {{-- <button type="button" class="btn btn-primary"></button> --}}
                                            <a href="#" data-toggle="modal" data-target="#addModal"
                                                class="btn extra_btn">
                                                <i class="feather icon-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            {{-- Product --}}
                            <div class="mb-3 col-md-12 text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text barcod_style" id="basic-addon1"><i
                                                class="fa fa-barcode"></i></span>
                                    </div>
                                    <input type="text" id="product_search" class="form-control"
                                        placeholder="Type & Barcode" aria-label="Type & Barcode"
                                        onkeydown="return event.keyCode !== 13" autocomplete="off">
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="responsive-table-wrapper">
                                            <table class="table table-bordered text-center table-sm responsive-table w-100">
                                                <thead>
                                                    <tr style="background: #000ce2; color: white;">
                                                         <th class="sl-col">#SL</th>
                                                        <th class="products-col" >Product</th>
                                                        <th class="variations-col">Variation</th>
                                                        <th class="rates-col">Rate</th>
                                                        <th class="qtys-col">Qty</th>
                                                        <th class="subtotals-col">Sub Total</th>
                                                        <th style=" padding: 10px;">
                                                            <i class="fa fa-trash"></i>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    {{-- Your dynamic rows go here --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-sm-12 col-md-6 offset-md-3 col-lg-4 offset-lg-7">
                                        {{-- Grand Total --}}
                                     <div class="mb-3 row">
                                        <label class="col-6 text-right fw-bold col-form-label">Grand Total:</label>
                                        <div class="col-6">
                                            <input type="number" step="any" style="min-width:100px"
                                                    name="estimated_amount" value="0" class="form-control" readonly>
                                        </div>
                                    </div>
                                        {{-- Discount --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold">Discount:</label>
                                            <div class="col-6">
                                                <input type="number" step="any" name="discount_amount" min="0"
                                                    value="0" class="form-control discount_amount" required>
                                            </div>
                                        </div>

                                        {{-- Payable Amount --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold">Payable Amount:</label>
                                            <div class="col-6">
                                               <input type="number" step="any" name="total_amount" min="0"
                                                    value="0" class="form-control total_amount" readonly>
                                            </div>
                                        </div>

                                        {{-- Bank Account --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold">Bank Account:</label>
                                            <div class="col-6">
                                            <select class="select2" name="bank_id" required>
                                                    @foreach ($bank_accounts as $bank_account)
                                                        <option value="{{ $bank_account->id }}">
                                                            {{ $bank_account->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Paid Amount --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold">Paid Amount:</label>
                                            <div class="col-6">
                                                 <input type="number" step="any" name="paid_amount" min="0"
                                                    value="0" class="form-control paid_amount" required>
                                            </div>
                                        </div>

                                        {{-- Due Amount --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold text-danger">Due Amount:</label>
                                            <div class="col-6">
                                                <input type="number" step="any" name="due_amount" min="0"
                                                    value="0" class="form-control due_amount" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="row submitAndReset" style="display: none;">
                                    <div class="text-center col-md-12">
                                        <button type="reset" class="btn col-sm-4 reset_button"
                                            style="padding: 5px 20px; background: #f04438;color:white; border-radius:25px;margin-top:10px">Reset</button>
                                        <button class="btn save_btn col-sm-6 submit_button"
                                            style="padding: 5px 20px; background: #12b76a;color:white; border-radius:25px;margin-right: 5px;margin-top:10px">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

            
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Modal --}}
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Supplier" sizeClass="modal-lg">
            <x-input label="Supplier Name *" type="text" name="name" placeholder="Enter Supplier Name" required
                md="6" />
            <x-input label="Email" type="email" name="email" placeholder="Enter Email" md="6" />
            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" />
            <x-input label="Address" type="text" name="address" placeholder="Enter Address" md="6" />
            <x-input label="Opening Receivable" type="text" name="open_receivable" value="0" md="6" />
            <x-input label="Opening Payable" type="text" name="open_payable" value="0" md="6" />
        </x-add-modal>
    </form>
@endsection

@push('js')
    <script>
        // Select the input field when the page loads
        window.onload = function() {
            var inputField = document.getElementById('product_search');
            inputField.select();
        };
    </script>

    <script>
        $(document).ready(function() {
            let count = 0;
            let db_pid_array = []; // Track added product IDs to prevent duplication

            // Function to toggle the visibility of the Submit and Reset buttons
            function toggleSubmitAndResetButtons() {
                if ($("#table_body tr").length > 0) {
                    $(".submitAndReset").show();
                } else {
                    $(".submitAndReset").hide();
                }
            }

            // Autocomplete for product search
            $("#product_search").autocomplete({
                source: function(req, res) {
                    let url = "{{ route('product-search') }}";
                    $.get(url, {
                        req: req.term
                    }, (data) => {
                        res(
                            $.map(data, (item) => {
                                return {
                                    id: item.id,
                                    value: item.name + " - " + item.barcode,
                                    price: item.selling_price,
                                };
                            })
                        );
                    });
                },
                select: function(event, ui) {
                    if ($("#supplier").val() === "") {
                        iziToast.warning({
                            title: "Please Select Supplier First!",
                            position: "topRight",
                        });
                        return false;
                    }

                    if (db_pid_array.includes(ui.item.id)) {
                        iziToast.warning({
                            title: "Product already added.",
                            position: "topRight",
                        });
                        return false;
                    }

                    $(this).val(ui.item.value);
                    let url = "{{ route('sc-search-product-id', 'my_id') }}".replace(
                        "my_id",
                        ui.item.id
                    );
                    $.get(url, (data) => {
                        // Iterate over variations
                        if (data.variations.length > 0) {
                            data.variations.forEach((variation) => {
                                console.log(variation);
                                count++;
                                if (data.product.unit.related_unit == null) {
                                    quantity_data =
                                        `<input type="text" class="has_sub_unit" hidden value="false">
                                            <label class="ml-4 mr-2" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                            <input type="number" value="" class="form-control col main_qty" name="new_main_qty[]"  onkeydown="return event.keyCode !== 190" min="1">`;
                                } else {
                                    quantity_data =
                                        `<input type="text" class="has_sub_unit" hidden value="true">
                                            <input type="text" class="conversion" hidden value="${data.product.unit.related_value}">
                                            <label class="mr-2 ml-4" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                            <input type="number" value="0" class="form-control col main_qty mr-4" name="new_main_qty[]"  onkeydown="return event.keyCode !== 190" min="1">
                                            <label class="mr-2" style="padding-top: 8px;">${data.product.unit.related_unit.name}:</label>
                                            <input type="number" value="0" class="form-control col sub_qty" name="new_sub_qty[]"  onkeydown="return event.keyCode !== 190" min="0">`;
                                }
                                let row = `
                                    <tr>
                                        <td>${count}</td>
                                        <td>
                                            ${data.product.name} - ${data.product.barcode}
                                            <input type="hidden" value="${data.product.id}" 
                                                name="new_product[]" class="product">
                                        </td>
                                        <td>
                                            ${variation.size}-${variation.color}
                                            <input type="hidden" value="${variation.id}" name="variation[]">
                                        </td>
                                        <td>
                                            <input type="number" style="width:100px" value="${data.product.purchase_price}" 
                                                class="form-control rate" name="new_rate[]" required>
                                        </td>
                                        <td class="" >
                                            <div class="form-row" style="width:300px" >
                                                ${quantity_data}
                                            </div>
                                        </td>
                                        <td>
                                            <strong><span class="sub_total">0</span></strong>
                                            <input type="hidden" name="new_subtotal_input[]" class="subtotal_input" value="0">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                $("#table_body").append(row);
                            });
                        } else {
                            // Handle product without variations
                            count++;
                            if (data.product.unit.related_unit == null) {
                                quantity_data =
                                    `<input type="text" class="has_sub_unit" hidden value="false">
                                        <label class="ml-4 mr-2" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                        <input type="number" value="" class="form-control col main_qty" name="new_main_qty[]"  onkeydown="return event.keyCode !== 190" min="1">`;
                            } else {
                                quantity_data =
                                    `<input type="text" class="has_sub_unit" hidden value="true">
                                        <input type="text" class="conversion" hidden value="${data.product.unit.related_value}">
                                        <label class="mr-2 ml-4" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                        <input type="number" value="0" class="form-control col main_qty mr-4" name="new_main_qty[]"  onkeydown="return event.keyCode !== 190" min="1">
                                        <label class="mr-2" style="padding-top: 8px;">${data.product.unit.related_unit.name}:</label>
                                        <input type="number" value="0" class="form-control col sub_qty" name="new_sub_qty[]"  onkeydown="return event.keyCode !== 190" min="0">`;
                            }
                            let row = `
                                <tr>
                                    <td>${count}</td>
                                    <td>
                                        ${data.product.name} - ${data.product.barcode}
                                        <input type="hidden" value="${data.product.id}" name="new_product[]" class="product">
                                    </td>
                                    <td>No Variation</td>
                                    <td>
                                        <input type="number" value="${data.product.purchase_price}" 
                                            class="form-control rate" name="new_rate[]" required>
                                    </td>
                                    <td class="" >
                                        <div class="form-row" style="width:300px" >
                                            ${quantity_data}
                                        </div>
                                    </td>
                                    <td>
                                        <strong><span class="sub_total">0</span></strong>
                                        <input type="hidden" name="new_subtotal_input[]" class="subtotal_input" value="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>`;
                            $("#table_body").append(row);
                        }

                        db_pid_array.push(ui.item.id);
                        toggleSubmitAndResetButtons(); // Show buttons after adding a product
                    });

                    $(this).val("");
                    return false;
                },
                response: function(event, ui) {
                    if (ui.content.length === 1) {
                        ui.item = ui.content[0];
                        $(this).data("ui-autocomplete")._trigger("select", "autocompleteselect", ui);
                        $(this).autocomplete("close");
                    }
                },
                minLength: 0,
            });

            // Remove row from the table
            $(document).on("click", ".remove", function() {
                let row = $(this).closest("tr");
                let productId = row.find(".product").val();
                row.remove();

                // Remove product ID from array if no other rows exist for it
                if ($(`.product[value="${productId}"]`).length === 0) {
                    db_pid_array = db_pid_array.filter((id) => id !== productId);
                }

                toggleSubmitAndResetButtons(); // Hide buttons if table is empty
                updateGrandTotal(); // Recalculate grand total after removing a row
            });

            // Update subtotal and Grand Total on quantity or rate change
            $(document).on("input", ".main_qty, .rate", function() {
                let row = $(this).closest("tr");
                let qty = parseFloat(row.find(".main_qty").val()) || 0;
                let rate = parseFloat(row.find(".rate").val()) || 0;
                let subtotal = qty * rate;

                row.find(".sub_total").text(subtotal.toFixed(2) +
                    " {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}");
                row.find(".subtotal_input").val(subtotal.toFixed(2));

                updateGrandTotal();
            });

            $(document).on("input", ".main_qty, .sub_qty, .rate", function() {
                let row = $(this).closest("tr");
                let mainQty = parseFloat(row.find(".main_qty").val()) || 0;
                let subQty = parseFloat(row.find(".sub_qty").val()) || 0;
                let rate = parseFloat(row.find(".rate").val()) || 0;
                let hasSubUnit = row.find(".has_sub_unit").val() === "true";
                let conversion = parseFloat(row.find(".conversion").val()) || 1;

                let totalQty = mainQty;
                if (hasSubUnit) {
                    totalQty += subQty / conversion; // Convert sub_qty to main unit equivalent
                }

                let subtotal = totalQty * rate;

                row.find(".sub_total").text(subtotal.toFixed(2) +
                    " {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}");
                row.find(".subtotal_input").val(subtotal.toFixed(2));

                updateGrandTotal();
            });

            // Function to calculate and update the Grand Total, Payable Amount, and Due Amount
            function updateGrandTotal() {
                let grandTotal = 0;
                $(".subtotal_input").each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });

                $("input[name='estimated_amount']").val(grandTotal.toFixed(2));
                updatePayableAmount(); // Update Payable Amount when Grand Total changes
            }

            // Function to calculate and update the Payable Amount
            function updatePayableAmount() {
                let estimatedAmount = parseFloat($("input[name='estimated_amount']").val()) || 0;
                let discountAmount = parseFloat($("input[name='discount_amount']").val()) || 0;

                // Ensure discount does not exceed the estimated amount
                if (discountAmount > estimatedAmount) {
                    discountAmount = estimatedAmount;
                    $("input[name='discount_amount']").val(discountAmount.toFixed(2));
                }

                let payableAmount = estimatedAmount - discountAmount;
                $("input[name='total_amount']").val(payableAmount.toFixed(2));
                $("input[name='paid_amount']").val(payableAmount.toFixed(2));
                updateDueAmount(); // Update Due Amount whenever the Payable Amount changes
            }

            // Function to calculate and update the Due Amount
            function updateDueAmount() {
                let payableAmount = parseFloat($("input[name='total_amount']").val()) || 0;
                let paidAmount = parseFloat($("input[name='paid_amount']").val()) || 0;

                let dueAmount = payableAmount - paidAmount;
                if (dueAmount < 0) dueAmount = 0; // Prevent negative due amounts

                $("input[name='due_amount']").val(dueAmount.toFixed(2));
            }

            // Update Payable Amount on Discount Amount change
            $(document).on("input", "input[name='discount_amount']", function() {
                updatePayableAmount();
            });

            // Update Due Amount on Paid Amount change
            $(document).on("input", "input[name='paid_amount']", function() {
                updateDueAmount();
            });

            // Handle Reset button click
            $(".reset_button").on("click", function() {
                $("#table_body").empty();
                db_pid_array = [];
                $("input[name='estimated_amount']").val("0");
                $("input[name='discount_amount']").val("0");
                $("input[name='total_amount']").val("0");
                $("input[name='paid_amount']").val("0");
                $("input[name='due_amount']").val("0");
                toggleSubmitAndResetButtons();
            });
        });
    </script>
@endpush
