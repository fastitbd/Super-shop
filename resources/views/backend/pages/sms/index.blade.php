@extends('backend.layouts.master')
@section('section-title', 'Promotion')
@section('page-title', 'Promotional Sms')
@section('action-button')
    <span style="font-size: 18px; font-weight:800; color:black;">{{ $balance }}</span>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form class="needs-validation" action="{{ url('sms') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            {{-- Select Customer --}}
                            <div class="mb-3 col-md-7">
                                
                                <label for="validationCustom07" class="form-label font-weight-bold">
                                    Select Customer *
                                </label>
                                <select class="select2" id="validationCustom07" name="customer_name[]" multiple required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customer as $item)
                                    <option value="{{ $item->id}}">{{$item->name}} ({{ $item->phone }})</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Address --}}
                            <div class="mb-3 col-md-7">
                                <label for="validationCustom08" class="form-label font-weight-bold">
                                    Sms Body *
                                </label>
                                <textarea class="form-control" id="validationCustom08" rows="5" placeholder="Write Your Promotional Message" name="message" required></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="mt-4 form-group text-right d-flex justify-content-start">
                            <button class="mr-2 btn save_btn" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
