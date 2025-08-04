@extends('backend.layouts.master')
@section('section-title', 'Purchase')
@section('page-title', 'Edit Purchase')
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
                    <form class="needs-validation" novalidate id="purchaseForm"
                        action="{{ route('purchase.updat', $purchase->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            {{-- Purchase Date --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label font-weight-bold">
                                    Date *
                                </label>
                                <input type="date" class="form-control" value="{{ $purchase->date }}" name="date"
                                    required>
                            </div>
                            {{-- Purchase No --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom02" class="form-label font-weight-bold">Purchase No *</label>
                                <input type="text" class="form-control" value="{{ $purchase->purchase_no }}"
                                    name="purchase_no" required readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            {{-- supplier invoice no --}}
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom02" class="form-label font-weight-bold">Supplier Invoice No
                                </label>
                                <input type="text" class="form-control" value="{{ $purchase->supplier_invoice_no }}"
                                    name="supplier_invoice_no" placeholder="Please Enter Supplier Invoice No" required>
                            </div>
                            {{-- Purchase Date --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label font-weight-bold">
                                    Supplier Invoice Date
                                </label>
                                <input type="date" class="form-control" value="{{ $purchase->supplier_invoice_date }}"
                                    name="supplier_invoice_date" required>
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
                                        <label class="form-label font-weight-bold">Suppliers *</label>
                                        <select class="select2" id="supplier" name="supplier_id" required>
                                            {{-- <option selected value="">Select Supplier</option> --}}
                                            @foreach ($supplier as $supplier)
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
                                                        <th
                                                            style="border-radius: 25px 0 0 25px; padding: 10px;">Sl
                                                        </th>
                                                        <th class="product-col">Product</th>
                                                        <th class="rate-col">Rate</th>
                                                        <th class="qty-col">Qty</th>
                                                        <th class="subtotal-col">Sub Total</th>
                                                        <th style="border-radius: 0 25px 25px 0; padding: 10px;">
                                                            <i class="fa fa-trash"></i>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    @php
                                                        $purchaseItem = App\Models\PurchaseItem::where(
                                                            'purchase_id',
                                                            $purchase->id,
                                                        )->get();
                                                        $purchase_item = App\Models\PurchaseItem::where(
                                                            'purchase_id',
                                                            $purchase->id,
                                                        )->first();
                                                        // dd($purchaseItem);
                                                    @endphp
                                                    <input type="hidden" name="id" value="{{ $purchase->id }}">
                                                    @forelse ($purchaseItem as $key => $item)
                                                        @php
                                                            $product_variation = App\Models\ProductVariation::where('id',$item->product_variation_id)->first();
                                                            // dd($product_variation);
                                                        @endphp
                                                        <tr>
                                                            <input type="hidden" name="itemID[]"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="variation_id[]"
                                                                value="{{ $item->product_variation_id }}">
                                                            <td class="table_data_style_left">{{ $key + 1 }}</td>
                                                            <td>
                                                                {{ $item->product?->name }} -
                                                                {{ $item->product?->barcode }}
                                                                @if($item->product_variation_id != null)
                                                                    ({{ $product_variation->size?->size }} - {{ $product_variation->color?->color }})
                                                                @endif
                                                                <input type="hidden" value="{{ $item->product_id }}"
                                                                    name="product_id[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" style="min-width: 70px;"
                                                                    class="form-control rate"
                                                                    name="new_rate[]"
                                                                    value="{{ $item->rate }}" />
                                                            </td>
                                                            <td style="width:250px">
                                                                <div class="form-row">
                                                                    @if ($item->product->unit->related_unit == null)
                                                                        <input type="text" class="has_sub_unit" hidden
                                                                            value="false">
                                                                        <label class="ml-2 mt-2  mr-2"
                                                                            style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                        <input type="number"
                                                                            value="{{ $item->main_qty }}"
                                                                            class="form-control col main_qty"
                                                                            name="new_main_qty[]"
                                                                            data-value="{{ product_stock($item->product) }}"
                                                                            data-related="{{ $item->product->unit->related_value }}"
                                                                            onkeydown="return event.keyCode !== 190"
                                                                            min="1">
                                                                        <input type="hidden"
                                                                            value="{{ $item->sub_qty }}"
                                                                            class="form-control col sub_qty mr-1"
                                                                            name="new_sub_qty[]"
                                                                            onkeydown="return event.keyCode !== 190"
                                                                            min="0"
                                                                            max="{{ $item->product->unit->related_value - 1 }}">
                                                                        {{-- @dd($item->product->has_serial == 1) --}}
                                                                        {{-- @if ($item->product->has_serial == 1)
                                                            <textarea name="new_imei[{{ $item->product_id }}]" class="form-control" placeholder="IMEI">{{ $imei->pluck('serial')->join("\n") }}</textarea>
                                                            @foreach ($imei as $imei)
                                                                <input type="hidden" name="serialList[]"
                                                                    value="{{ $imei->id }}">
                                                            @endforeach
                                                        @endif --}}
                                                                    @else
                                                                        {{-- HAS SUB UNIT --}}
                                                                        <input type="text" class="has_sub_unit" hidden
                                                                            value="true">
                                                                        <input type="text" class="conversion" hidden
                                                                            value="{{ $item->product->unit->related_value }}">

                                                                        <label class="mr-1 ml-1"
                                                                            style="padding-top: 5px;">{{ $item->product->unit->name }}:</label>
                                                                        <input type="number"
                                                                            value="{{ $item->main_qty }}"
                                                                            class="form-control col main_qty mr-1"
                                                                            name="new_main_qty[]"
                                                                            data-value="{{ product_stock($item->product) }}"
                                                                            data-related="{{ $item->product->unit->related_value }}"
                                                                            onkeydown="return event.keyCode !== 190"
                                                                            min="0">

                                                                        <label class="mr-1"
                                                                            style="padding-top: 5px;">{{ $item->product->unit->related_unit->name }}:</label>
                                                                        <input type="number"
                                                                            value="{{ $item->sub_qty }}"
                                                                            class="form-control col sub_qty mr-1"
                                                                            name="new_sub_qty[]"
                                                                            onkeydown="return event.keyCode !== 190"
                                                                            min="0"
                                                                            max="{{ $item->product->unit->related_value - 1 }}">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            {{-- @dd($item->subtotal) --}}
                                                            {{-- <td>
                                                <textarea name="warranty[{{ $item->product_id }}]" class="form-control" placeholder="">{{ $purchase->warranty }}</textarea>
                                            </td> --}}
                                                            <td>
                                                                {{-- <input type="number" style="min-width: 100px;" readonly
                                                        name="sub_total[{{ $item->product_id }}]"
                                                        class="form-control sub_total"
                                                        value="{{ $item->subtotal }}" /> --}}
                                                                <strong><span
                                                                        class="sub_total">{{ $item->subtotal }}</span>
                                                                    {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}</strong>
                                                                <input type="hidden"
                                                                    name="new_subtotal_input[]"
                                                                    class="subtotal_input" value="{{ $item->subtotal }}">
                                                            </td>
                                                            <td class="table_data_style_right">
                                                                {{-- <a href="#" class="remove-btn item-index" data-value="${index}"><i class="fa fa-undo text-danger"></i></a> --}}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="10" class="text-center">No Invoice Found</td>
                                                        </tr>
                                                    @endforelse

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
                                                <input type="number" step="any" name="estimated_amount"
                                                    value="{{ $purchase->total_amount }}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        {{-- Discount --}}
                                        <div class="mb-3 row">
                                            <label class="col-6 text-right fw-bold">Discount:</label>
                                            <div class="col-6">
                                                <input type="number" step="any" name="discount_amount"
                                                    min="0" value="0" class="form-control discount_amount"
                                                    required>
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
                                                    value="0" class="form-control due_amount text-danger" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row submitAndReset">
                                    <div class="text-center col-md-12">
                                        <button type="reset" class="btn col-sm-4 reset_button"
                                            style="padding: 5px 20px; background: #f04438;color:white; border-radius:25px;margin-top:10px">Reset</button>
                                        <button class="btn  col-sm-6 submit_button"
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
            <x-input label="Father Name" type="text" name="father_name" placeholder="Enter Father Name"
                md="6" />
            <x-select label="suplier_type" name="suplier_type" md="6">
                <option value="">Select Suplier Type</option>

                <option value="Parmanent">Parmanent Suplier</option>
                <option value="One Time">One Time Suplier</option>
            </x-select>
            <x-input label="Reference Name" type="text" name="ref_name" placeholder="Enter reference name"
                md="6" />
            <x-input label="NID NO" type="text" name="nid_no" placeholder="Enter nid no" md="6" />
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
        var count = 0;
        var db_pid_array;

        $(document).ready(function() {
            $("#product_search").autocomplete({
                source: function(req, res) {
                    let url = "{{ route('product-search') }}";
                    $.get(url, {
                        req: req.term
                    }, (data) => {
                        res($.map(data, function(item) {
                            return {
                                id: item.id,
                                value: item.name + " - " + item.barcode,
                                price: item.selling_price
                            }
                        })); // end res
                    });
                },
                select: function(event, ui) {
                    //check is supplier is selected.
                    if ($("#supplier").val() == '') {
                        iziToast.warning({
                            title: "Please Select Supplier First !",
                            position: "topRight",
                        });
                        return false;
                    }

                    if (db_pid_array && db_pid_array.includes(ui.item.id)) {
                        //SHOW ERROR
                        iziToast.warning({
                            title: "Product already added.",
                            position: "topRight",
                        });
                        return;
                    }

                    count++;
                    $(this).val(ui.item.value);
                    $("#search_product_id").val(ui.item.id);
                    let url = "{{ route('search-product-id', 'my_id') }}".replace('my_id', ui.item.id);
                    $.get(url, (data) => {
                        // console.log(product.unit.name);
                        // product add
                        var quantity_data = '';

                        // if(data.product.has_serial == 1){

                        //     serial_data = `
                    //     `;
                        // }<textarea name="new_imei[${data.product.id}]" class="form-control " placeholder="IMEI"></textarea>
                        if (data.product.unit.related_unit == null) {
                            if (data.product.has_serial == 1) {
                                quantity_data =
                                    `<input type="text" class="has_sub_unit" hidden value="false">
                                    <label class="ml-4 mr-2" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                    <input type="number" value="" class="form-control col main_qty" name="new_main_qty[${data.product.id}]"  onkeydown="return event.keyCode !== 190" min="1">
                                    
                                    `;
                            } else {
                                quantity_data =
                                    `<input type="text" class="has_sub_unit" hidden value="false">
                                    <label class="ml-4 mr-2" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                    <input type="number" value="" class="form-control col main_qty" name="new_main_qty[${data.product.id}]"  onkeydown="return event.keyCode !== 190" min="1">`;
                            }

                        } else {
                            quantity_data =
                                `<input type="text" class="has_sub_unit" hidden value="true">
                                    <input type="text" class="conversion" hidden value="${data.product.unit.related_value}">
                                    <label class="mr-2 ml-4" style="padding-top: 8px;">${data.product.unit.name}:</label>
                                    <input type="number" value="" class="form-control col main_qty mr-4" name="new_main_qty[${data.product.id}]"  onkeydown="return event.keyCode !== 190" min="1">
                                    <label class="mr-2" style="padding-top: 8px;">${data.product.unit.related_unit.name}:</label>
                                    <input type="number" value="0" class="form-control col sub_qty" name="new_sub_qty[${data.product.id}]"  onkeydown="return event.keyCode !== 190" min="1">`;
                        }

                        // }

                        // <input type="number" value="1" class="form-control sale_qty" name="qty[]">
                        let row = `
                            <tr>
                                <td>${count}</td>
                                <td>
                                ${data.product.name + " - " + data.product.barcode}
                                <input type="hidden" value="${data.product.id}" name="new_product[${data.product.id}]" class="product">
                                <input type="hidden" value="${data.product.id}" name="product_id[${data.product.id}]" class="product">
                                </td>
                                <td >
                                    <div style="width:100px" class="form-row"> 
                                        <input type="text" value="${data.product.purchase_price}" class="form-control rate" name="new_rate[${data.product.id}]">
                                    </div>
                                </td>
                                <td class="" >
                                    <div class="form-row" style="width:300px" >
                                        ${quantity_data}
                                    </div>
                                </td>
                                
                                <td>
                                <strong><span class="sub_total">0</span> {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}</strong>
                                <input type="hidden" name="new_subtotal_input[${data.product.id}]" class="subtotal_input" value="0">
                                </td>
                                <td>
                                <a href="#" class="remove">
                                    <i class="fa fa-trash"></i>
                                </a>
                                </td>
                            </tr>`;

                        // Duplicate check
                        let tableBody = document.querySelector('#table_body');
                        let products = tableBody.querySelectorAll('.product');
                        let isDuplicate = false;
                        products.forEach(function(item) {
                            if (ui.item.id == item.value) {
                                isDuplicate = true;
                            } else {
                                isDuplicate = false;
                            }
                        });

                        if (isDuplicate) {
                            iziToast.warning({
                                title: "Product already added.",
                                position: "topRight",
                            });
                            return false;
                        } else {
                            $("#table_body").append(row);
                        }
                        tFootShowHide();

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
        });

        //calculate total amount with order tax is percentage shipping charge,others charge and discount on keyup and change
        $(document).on(
            "keyup change",
            "input[name='discount_amount']",
            function() {
                totalAmount();
            }
        );

        //paid_amount on keyup and change
        $(document).on("keyup change", "input[name='paid_amount']", function() {
            due_calculation();
        });

        //submit_button
        $(document).on("click", ".submit_button", function() {
            //get all buying price value and check if any value is 0

            var total_price = $(".subtotal_input").val();
            console.log(total_price);

            if (total_price <= 0) {
                iziToast.warning({
                    title: "Buying price can't be 0",
                    position: "topRight",
                });
                return false;
            } else {
                //submit purchaseForm
                $("#purchaseForm").submit();
            }
        });

        //reset_button
        $(document).on("click", ".reset_button", function() {
            $("tbody").html("");
            tFootShowHide();
        });

        //table footer show hide function
        function tFootShowHide() {
            if ($("tbody tr").length == 0) {
                $(".submitAndReset").hide();
            } else {
                $(".submitAndReset").show();
            }
        }

        function calculate_sub_total(obj) {
            var imeis = obj.parents('tr').find('.imei').val();
            var qty = 0;
            if (imeis != undefined) {
                var imeis = imeis.split('\n');
                imeis = imeis.filter(function(value) {
                    return value !== '';
                });
                var qty = imeis.length;
            }
            if (qty > 0) {
                var rate = obj.parents('tr').find('.rate').val();
                var sub_total = qty * rate;

                return sub_total;
            }


            var has_sub_unit = $(obj).parents('tr').find('.has_sub_unit').val();
            var rate = $(obj).parents('tr').find('.rate').val();
            var sub_total = parseFloat($(obj).parents('tr').find('.main_qty').val() * rate);
            if (has_sub_unit == "true") {
                sub_total += parseFloat(($(obj).parents('tr').find('.sub_qty').val() / $(obj).parents('tr').find(
                    '.conversion').val()) * rate);
            } else {

            }
            return sub_total;
        }

        // change rate
        $(document).on('keyup change', '.rate', function() {
            let subTotal = calculate_sub_total($(this));
            $(this).parents('tr').children('td').find('.sub_total').text(subTotal);
            $(this).parents('tr').children('td').find('.subtotal_input').val(subTotal);
            estimatedAmount();
            updateTotalQty();
            updateTotal();
        });
        estimatedAmount()

        // change qty
        $(document).on('keyup change', '.main_qty', function() {
            // let main = $(this).parents('tr').find('.main_qty').val();
            let subTotal = calculate_sub_total($(this));
            $(this).parents('tr').children('td').find('.sub_total').text(subTotal);
            $(this).parents('tr').children('td').find('.subtotal_input').val(subTotal);
            updateTotalQty();
            updateTotal();
            estimatedAmount();

            // console.log(main);
        });
        $(document).on('keyup change', '.sub_qty', function() {
            // let rate = $(this).parents('tr').find('.rate').val();
            let subTotal = calculate_sub_total($(this));
            $(this).parents('tr').children('td').find('.sub_total').text(subTotal);
            $(this).parents('tr').children('td').find('.subtotal_input').val(subTotal);
            estimatedAmount();
            updateTotalQty();
            updateTotal();
        });
        $(document).on('change', '.imei', function() {
            // let rate = $(this).parents('tr').find('.rate').val();
            let subTotal = calculate_sub_total($(this));
            // alert(subTotal);
            $(this).parents('tr').children('td').find('.sub_total').text(subTotal);
            $(this).parents('tr').children('td').find('.subtotal_input').val(subTotal);
            estimatedAmount();
            updateTotalQty();
            updateTotal();
        });

        // Remove DOM
        $(document).on('click', '.remove', function() {
            $(this).parents('tr').remove();
            updateTotal();
            updateTotalQty();
            itemUpdate();
            count--;
            estimatedAmount();
        });

        function updateTotalQty() {
            let totalQty = 0;
            $(".main_qty").each((i, element) => {
                if ($(element).is(":visible")) {
                    totalQty += parseInt(element.value == '' ? 0 : element.value);
                }
            });

            $(".imei").each((i, element) => {
                var imeis = element.value;
                var qty = 0;
                if (imeis != undefined) {
                    var imeis = imeis.split('\n');

                    imeis = imeis.filter(function(value) {
                        return value != '';
                    });
                    qty = imeis.length;
                }
                totalQty += parseInt(qty);
            });

            $("#total_qty").val(totalQty);
        }

        //  Update item function
        function itemUpdate() {
            let totalItems = 0
            $(".sale_qty").each((i, obj) => {
                totalItems += 1;
            });
            $("#total_items").text(totalItems);
        }

        // update total amount
        function updateTotal() {
            let totalAmount = 0;
            $(".sub_total").each((i, obj) => {
                let subtotal = obj.innerHTML;
                totalAmount += parseFloat(subtotal);
            });
            $("input[name='estimated_amount']").val(totalAmount);
        }
        //estimatedAmount function
        function estimatedAmount() {
            var sum = 0;
            $(".subtotal_input").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            $("input[name='estimated_amount']").val(sum);
            totalAmount();
            due_calculation();
        }

        //due calculation
        function due_calculation() {
            var total_amount = parseFloat($("input[name='total_amount']").val());

            var paid_amount = parseFloat($("input[name='paid_amount']").val());

            var due_amount = $("input[name='due_amount']").val();

            due_amount = total_amount - paid_amount;

            $("input[name='due_amount']").val(due_amount);
        }

        //total amount calculation
        function totalAmount() {
            var discount_amount = parseFloat($("input[name='discount_amount']").val());
            var estimated_amount = parseFloat($("input[name='estimated_amount']").val());

            var total_amount = estimated_amount - discount_amount;

            $("input[name='total_amount']").val(total_amount);
            //set max value for paid amount

            $("input[name='paid_amount']").attr("max", total_amount);
            //set max value for due amount

            $("input[name='due_amount']").attr("max", total_amount);

            var due = $("input[name='due_amount']").val();

            $("input[name='paid_amount']").val(total_amount - due);
        }
    </script>
@endpush
