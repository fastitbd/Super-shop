<div class="modal" id="payment_modal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content" style="border-radius: 25px;background:#f2f2f2">
            <div class="modal-header ">
                <h5 class="modal-title" id="paymentModalLabel">Payment > <span id="customer_name"></span>
                </h5>
                <button type="button"  style="border-radius: 25px;border:1px solid #eae9e9;padding:5px 10px;background:#fff" class="btn-close " data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="">
                <div class="text-center">
                    <label for="oneAccountPayment">
                        <input type="radio" id="oneAccountPayment" name="payment_type" value="pos" checked>
                        Single Account Payment
                    </label>
                    <label for="multipleAccountPayment">
                        <input type="radio" id="multipleAccountPayment" name="payment_type" value="checking">
                        Multiple Account Payment
                    </label>
                </div>
                <!-- Your existing content for one account payment -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="modal-body">
                            <div class="row">
                                {{-- payment method --}}
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        {{-- single account payment --}}
                                        <div class="row section" id="pos">
                                            <div class="col-md-12">
                                                <label class="form-label font-weight-bold text-black">Bank Account</label>
                                                <select class="select2" name="bank_id" style="border-top-left-radius: 25px" required>
                                                    @foreach ($bank_accounts as $bank_account)
                                                        <option value="{{ $bank_account->id }}">
                                                            {{ $bank_account->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="form-group mt-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5 class="text-center text-black " style="font-size: 16px;margin-top:5px"> <strong> Payment Option </strong></h5>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <a class="text-white btn full_pay_btn" style="padding: 3px 10px; background: #12b76a;border-radius:25px;margin-right: 5px">
                                                                <i class="fa-solid fa-circle-plus"></i>
                                                                Paid
                                                            </a>
                                                            <a class="text-white btn btn-danger full_due_btn" style="padding: 3px 10px; background: #f04438;border-radius:25px">
                                                                <i class="fa-solid fa-circle-minus"></i>
                                                                Due
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- multiple account payment --}}
                                        <div class="row section" id="checking" style="display: none;">
                                            <div class="col-md-12">
                                            <label class="form-label font-weight-bold text-black">Bank Account</label>
                                                <div id="bankAccountList">
                                                    @foreach ($bank_accounts as $bank_account)
                                                        <div class="bank-account-entry" data-bank-id="{{ $bank_account->id }}">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <strong class="text-black">{{ $bank_account->bank_name }}</strong>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input 
                                                                        type="number" 
                                                                        name="amounts[{{ $bank_account->id }}]" 
                                                                        class="form-control bank-amount-input" 
                                                                        placeholder="Enter amount for {{ $bank_account->bank_name }}" 
                                                                        min="0" 
                                                                        value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 input-group input-group-lg">
                                            <span class="input-group-text"  style="border:none;border-right:none;border-top-left-radius: 25px;border-bottom-left-radius: 25px;background:#000ce2;color:white;font-size:14px">Pay Amount</span>
                                            <input type="number"  style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;background:#f2f2f2;" class="form-control pay_amount" name="pay_amount" min="0" value="0.00">
                                        </div>
                                        <div class="mt-3 input-group input-group-lg pay_amount_div">
                                            <span class="input-group-text"  style="border:none;border-right:none;border-top-left-radius: 25px;border-bottom-left-radius: 25px;background:#000ce2;color:white;font-size:14px">Pay Point</span>
                                            <input type="number"  style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;background:#f2f2f2;" class="form-control pay_point" name="pay_point" min="0" value="0.00">
                                        </div>
                                        <div class="form-group mt-3 text-left">
                                            <label for="" class="form-label fw-bold"> Note</label>
                                            <textarea name="note" class="form-control" style="border-radius: 15px;background:#f2f2f2" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{-- order details --}}
                                    <h4 class="text-center">Payment Details</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tfoot>
                                                <tr id="point_row">
                                                    <th class="text-left w-60" colspan="2"> <strong
                                                            class="float-left">Total Point </strong> </th>
                                                    <td class="w-40 text-right"><strong> <span
                                                                class="total_point">0.00</span></strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Subtotal </strong> </th>
                                                    <td class="w-40 text-right"><strong> <span class="sub_total">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Discount </strong> </th>
                                                    <td class="w-40 text-right"><strong> <span class="discount_amount">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Previous Due</strong></th>
                                                    <input type="hidden" name="previous_due" id="previous_due">
                                                    <td class="w-40 text-right"><strong> <span class="previous_due">0.00 {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</span> </strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Payable Amount <small>(<span class="total_item"></span> items)</small></strong></th>
                                                    <input type="hidden" name="payable_amount" id="payable_amount" value="">
                                                    <td class="w-40 text-right"><strong> <span class="payable_amount">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Paid Amount</strong></th>
                                                    <input type="hidden" name="paid_amount" id="paid_amount" value="">
                                                    <td class="w-40 text-right"><strong> <span class="paid_amount">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Due Amount</strong></th>
                                                    <input type="hidden" name="due_amount" id="due_amount" value="">
                                                    <td class="w-40 text-right"><strong> <span class="due_amount">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left w-60" colspan="2"> <strong class="float-left">Balance</strong></th>
                                                    <input type="hidden" name="balance" id="balance" value="">
                                                    <td class="w-40 text-right"><strong> <span class="balance">0.00</span> {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn cancel_btn" id="close"data-dismiss="modal">Close</button>
                <button type="button" class="btn save_btn" id="checkout" id="checkoutButton">Checkout</button>
                <span id="processingText" style="display: none; margin-left: 10px;">Processing...</span>
                <script>
                document.getElementById('checkout').addEventListener('click', function () {
                    // Hide the checkout button
                    this.style.display = 'none';

                    // Show the processing text
                    document.getElementById('processingText').style.display = 'inline-block';

                    // You can place your actual checkout logic here (like form submission or AJAX request)
                });
                </script>
            </div>
        </div>
    </div>
</div>
@push('js')

<script>
    // JavaScript to toggle sections
    document.querySelectorAll('input[name="payment_type"]').forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'pos') {
                document.getElementById('pos').style.display = 'block';
                document.getElementById('checking').style.display = 'none';
            } else if (this.value === 'checking') {
                document.getElementById('pos').style.display = 'none';
                document.getElementById('checking').style.display = 'block';
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        function updateAmounts() {
            var payableAmount = parseFloat($('#payable_amount').val()) || 0; // Payable Amount (এটা স্ট্যাটিক থাকবে)
            var payPoint = parseFloat($('.pay_point').val()) || 0; // Pay Point (ইউজার ইনপুট)
            var payAmount = parseFloat($('.pay_amount').val()) || 0; // Pay Amount (ইউজার ইনপুট)

            // Paid Amount = Pay Point + Pay Amount
            var paidAmount = payPoint + payAmount;

            // Due Amount = Payable Amount - Paid Amount
            var dueAmount = payableAmount - paidAmount;
            if (dueAmount < 0) dueAmount = 0; // নেগেটিভ হলে 0 দেখাবে

            // UI তে আপডেট
            $('.paid_amount').text(paidAmount.toFixed(2)); 
            $('.due_amount').text(dueAmount.toFixed(2)); 

            // Hidden Input ফিল্ডেও আপডেট
            $('#paid_amount').val(paidAmount);
            $('#due_amount').val(dueAmount);
        }

        // Pay Point অথবা Pay Amount ইনপুটে কিছু টাইপ করলে আপডেট হবে
        $('.pay_point, .pay_amount').on('input', updateAmounts);

        // পেজ লোড হওয়ার পরও ফাংশন রান করাবো
        updateAmounts();
    });
</script>
<script>
    function updatePayAmount() {
        let total = 0;

        // Iterate over all bank account input fields and sum their values
        document.querySelectorAll('.bank-amount-input').forEach(input => {
            const value = parseFloat(input.value) || 0; // Use 0 if the value is empty or invalid
            total += value;
        });
        // Update the Pay Amount field
        document.querySelector('.pay_amount').value = total.toFixed(2);
        document.querySelector('#paid_amount').value = total.toFixed(2);
        document.querySelector('.paid_amount').textContent  = total.toFixed(2);
        
        let total_due = document.querySelector('#payable_amount').value;
        let due = total_due-total;
        document.querySelector('#due_amount').value = due.toFixed(2);
        document.querySelector('.due_amount').textContent  = due.toFixed(2);
    }

    // Add event listener to each bank account input field
    document.querySelectorAll('.bank-amount-input').forEach(input => {
        input.addEventListener('input', updatePayAmount);
    });
    // Initialize Pay Amount on page load
    document.addEventListener('DOMContentLoaded', updatePayAmount);
</script>
@endpush