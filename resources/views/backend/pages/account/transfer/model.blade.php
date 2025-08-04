<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="paymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Add Transfer</h5>
                <button type="button" class="btn-close add_list_btn border-0" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('bank-transfer-store') }}" enctype="multipart/form-data">
                                        @csrf
                                        {{-- From Account --}}
                                        <div class="mt-2 col-md-6">
                                            <label class="form-label fw-bold">From Account *</label>
                                            <select class="select2 from_bank_id" name="from_bank_id" id="from_bank_id" required>
                                                <option selected value="">Select Account</option>
                                                @foreach ($all_accounts as $bank_account)
                                                    <option value="{{ $bank_account->id }}">
                                                        {{ $bank_account->bank_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="error"><b id="from_amount"></b></div>
                                            <input type="hidden" name="from_amount" class="from_amount">
                                            <div class="error">{{ ($errors->has('from_bank_id'))?$errors->first('from_bank_id'):''; }}</div>
                                        </div>

                                        {{-- To Account --}}
                                        <div class="mt-2 col-md-6">
                                            <label class="form-label fw-bold">To Account *</label>
                                            <select class="select2 to_bank_id" name="to_bank_id" id="to_bank_id" required>
                                                <option selected value="">Select Account</option>
                                            </select>
                                            <div class="error"><b id="to_amount"></b></div>
                                            <div class="error">{{ ($errors->has('to_bank_id'))?$errors->first('to_bank_id'):''; }}</div>
                                        </div>

                                        {{-- Date --}}
                                        <div class="mt-2 col-md-6">
                                            <label class="form-label font-weight-bold">Date</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date" required>
                                            <div class="error">{{ ($errors->has('date'))?$errors->first('date'):''; }}</div>
                                        </div>

                                        {{-- Transfer Amount --}}
                                        <div class="mt-2 col-md-6">
                                            <label for="amount" class="form-label fw-bold">Transfer Amount *</label>
                                            <input type="number" class="form-control" min="1" step="any"
                                                placeholder="Enter Transfer Amount" name="transfer_amount">
                                            <div class="error">{{ ($errors->has('transfer_amount'))?$errors->first('transfer_amount'):''; }}</div>
                                        </div>

                                        {{-- Details --}}
                                        <div class="mt-2 col-md-12">
                                            <label for="details" class="form-label fw-bold">Note</label>
                                            <textarea name="note" class="form-control" rows="2"></textarea>
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="mt-2 col-md-12">
                                            @if (check_permission('bank-transfer-store'))
                                                <button class="btn save_btn float-right" type="submit">Save</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
