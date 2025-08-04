@extends('backend.layouts.master')
@section('section-title', 'Setting')
@section('page-title', 'Setting Update')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card m-b-30 card_style">
                <h4 style="text-align: center; font-weight:bold; margin-top:15px;font-size:30px;">Company Details</h4>
                <hr>
                <div class="card-body">
                    <div class="">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('setting.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mt-2 col-md-12">
                                <div class="row">
                                    {{-- Site Icon --}}
                                    <div class="controls col-md-3">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-cloud-upload"></i> System
                                                    Icon</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" class="default" name="system_icon" accept="image/*"
                                                    class="upload" onchange="readURLIcon(this);">
                                            </span>
                                            <span class="fileupload-preview" style="margin-left:5px;"></span>
                                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload"
                                                style="float: none; margin-left:5px;"></a>
                                        </div>
                                    </div>
                                    <div class="controls col-md-3">
                                        <img id="image_icon" class="img-thumbnail"
                                            src="{{ !empty(get_setting('system_icon')) ? url('public/uploads/logo/' . get_setting('system_icon')) : url('backend/images/no_images.png') }}"
                                            style="width: 100px; height: 50px;" />
                                    </div>
                                    {{-- System Logo --}}
                                    <div class="controls col-md-3">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-cloud-upload"></i> System
                                                    Logo</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" class="default" name="system_logo" accept="image/*"
                                                    class="upload" onchange="readURLLogo(this);">
                                            </span>
                                            <span class="fileupload-preview" style="margin-left:5px;"></span>
                                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload"
                                                style="float: none; margin-left:5px;"></a>
                                        </div>
                                    </div>
                                    <div class="controls col-md-3">
                                        <img id="image_logo" class="img-thumbnail"
                                            src="{{ !empty(get_setting('system_logo')) ? url('public/uploads/logo/' . get_setting('system_logo')) : url('backend/images/no_images.png') }}"
                                            style="width: 125px; height: 60px;" />
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label fw-bold">Company Name</label>
                                <input type="hidden" name="types[]" value="com_name">
                                <input class="form-control" type="text" name="com_name"
                                    value="{{ get_setting('com_name') }}" placeholder="Name">
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label fw-bold">Company Email</label>
                                <input type="hidden" name="types[]" value="com_email">
                                <input class="form-control" type="text" name="com_email"
                                    value="{{ get_setting('com_email') }}" placeholder="Email">
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label fw-bold">Company Phone</label>
                                <input type="hidden" name="types[]" value="com_phone">
                                <input class="form-control" type="text" name="com_phone"
                                    value="{{ get_setting('com_phone') }}" placeholder="Phone">
                            </div>
                            <div class="mt-2 col-md-3 ">
                                <label class="form-label fw-bold">Currency</label>
                                <input type="hidden" name="types[]" value="com_currency">
                                <input class="form-control" type="text" name="com_currency"
                                    value="{{ get_setting('com_currency') }}" placeholder="Currency">
                            </div>
                            <div class="mt-3 col-md-2 offset-md-10">
                                <input  type="hidden" name="types[]" value="com_vat">
                                <input type="checkbox" name="com_vat" value="1"
                                {{ get_setting('com_vat') == 1 ? 'checked' : '' }} class="form-check-input me-2">
                                
                                <label class="form-label fw-bold m-0">Including VAT</label>
                            </div>
                            <div class="mt-2 col-md-12">
                                <label class="form-label fw-bold">Company Address</label>
                                <input type="hidden" name="types[]" value="com_address">
                                <textarea name="com_address" class="form-control" rows="2" placeholder="Address">{{ get_setting('com_address') }}</textarea>  
                            </div>
                            <div class="mt-4 col-md-12">
                                <div class="form-group pull-right">
                                    <button class="btn save_btn" type="submit"><i class="fa fa-cloud-upload">
                                            Upload</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card m-b-30 card_style card_top">
                <h4 style="text-align: center; font-weight:bold; margin-top:15px;font-size:30px">Other Setting</h4>
                <hr>
                <div class="card-body">
                    <div class="border rounded">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('setting.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mt-2 col-md-4">
                                <label class="form-label fw-bold">Barcode Type</label>
                                <input type="hidden" name="types[]" value="pro_barcode">
                                <select class="select2" name="pro_barcode">
                                    <option value="a4" {{ get_setting('pro_barcode') == 'a4' ? 'selected' : '' }}>A4
                                    </option>
                                    <option value="single" {{ get_setting('pro_barcode') == 'single' ? 'selected' : '' }}>
                                        Single</option>
                                </select>
                            </div>
                            <div class="mt-2 col-md-4">
                                <label class="form-label fw-bold">Invoice Logo Type</label>
                                <input type="hidden" name="types[]" value="inv_logo">
                                <select class="select2" name="inv_logo">
                                    <option value="name" {{ get_setting('inv_logo') == 'name' ? 'selected' : '' }}>Name
                                    </option>
                                    <option value="logo" {{ get_setting('inv_logo') == 'logo' ? 'selected' : '' }}>Logo
                                    </option>
                                    <option value="both" {{ get_setting('inv_logo') == 'both' ? 'selected' : '' }}>Both
                                    </option>
                                </select>
                            </div>
                            <div class="mt-2 col-md-4">
                                <label class="form-label fw-bold">Invoice Design</label>
                                <input type="hidden" name="types[]" value="inv_design">
                                <select class="select2" name="inv_design">
                                    <option value="a4" {{ get_setting('inv_design') == 'a4' ? 'selected' : '' }}>A4
                                    </option>
                                    <option value="a5" {{ (get_setting('inv_design') == 'a5')?"selected":""; }}>A5</option>
                                {{-- <option value="a4-3" {{ (get_setting('inv_design') == 'a4-3')?"selected":""; }}>A4 - 3</option> --}}
                                    <option value="pos" {{ get_setting('inv_design') == 'pos' ? 'selected' : '' }}>Pos
                                        Printer</option>
                                    {{-- <option value="pos-2" {{ (get_setting('inv_design') == 'pos-2')?"selected":""; }}>Pos Printer - 2</option>
                                <option value="pos-3" {{ (get_setting('inv_design') == 'pos-3')?"selected":""; }}>Pos Printer - 3</option> --}}
                                </select>
                            </div>
                            <div class="mt-4 col-md-12">
                                <div class="form-group pull-right">
                                    <button class="btn save_btn" type="submit"><i class="fa fa-cloud-upload">
                                            Upload</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function readURLIcon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_icon')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_logo')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(60);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
