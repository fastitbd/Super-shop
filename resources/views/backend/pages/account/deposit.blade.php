@extends('backend.layouts.master')
@section('section-title', 'Account')
@section('page-title', 'Deposit')

@if (check_permission('account.transaction-history'))
    @section('action-button')
        <a href="{{ url('transaction-history') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-list"></i>
            Transaction History
        </a>
    @endsection
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card_style">
                <div class="card-body">
                    <div class="">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('deposit-store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- Date --}}
                            <div class="mt-2 col-md-6">
                                <label class="form-label font-weight-bold">Date</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date"
                                    required>
                                <div class="error">{{ $errors->has('date') ? $errors->first('date') : '' }}</div>
                            </div>

                            {{-- Account name --}}
                            <div class="mt-2 col-md-6">
                                <label class="form-label fw-bold">Bank Account *</label>
                                <select class="select2" name="bank_id" required>
                                    <option selected value="">Select Bank Account</option>
                                    @foreach ($bank_accounts as $bank_account)
                                        <option value="{{ $bank_account->id }}">
                                            {{ $bank_account->bank_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="error">{{ $errors->has('bank_id') ? $errors->first('bank_id') : '' }}</div>
                            </div>

                            {{-- Owner Name --}}
                            <div class="mt-2 col-md-6">
                                <label for="amount" class="form-label fw-bold">Owner *</label>
                                <select class="select2 " name="owner_id" required>
                                    <option selected value="">Select Owner</option>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">
                                            {{ $owner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="error">{{ $errors->has('owner_id') ? $errors->first('owner_id') : '' }}</div>
                            </div>
                            {{-- Deposit Amount --}}
                            <div class="mt-2 col-md-6">
                                <label for="amount" class="form-label fw-bold">Deposit Amount *</label>
                                <input type="number" class="form-control" min="1" step="any"
                                    placeholder="Enter Deposit Amount" name="deposit_amount" required>
                                <div class="error">
                                    {{ $errors->has('deposit_amount') ? $errors->first('deposit_amount') : '' }}</div>
                            </div>

                            {{-- Details --}}
                            <div class="mt-2 col-md-12">
                                <label for="details" class="form-label fw-bold">Note</label>
                                <textarea name="note" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="mt-2 col-md-12 text-center">
                                @if (check_permission('deposit-store'))
                                    <button class="btn save_btn" type="submit">Save</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
