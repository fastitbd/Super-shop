@extends('backend.layouts.master')
@section('section-title', 'Role Management')
@section('page-title', 'Add Role & Permission')
@section('action-button')
    <a href="{{ route('roles-permission.index') }}" class="btn add_list_btn">
        <i class="mr-2 feather icon-list"></i>
        Role & Permission List
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('roles-permission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3"></div>
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom01" class="form-label font-weight-bold">
                                    Role Name *
                                </label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Enter Role Name" name="name" required>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="card" style="border: 1px solid #000ce2;">
                            <div class="card-header" style="background: #000ce2;color:white">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title text-white">Permission</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <!-- Master Select All checkbox -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll" onclick="toggleAllCheckboxes(this)">
                                        <label class="custom-control-label font-weight-bold" for="selectAll">Select All</label>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($routeList as $key => $value)
                                        <div class="col-md-3">
                                            <div class="card card_top" style="border: 1px solid #000ce2;">
                                                <div class="card-header" style="background: #000ce2;color:white;border-radius:25px;">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input text-white group-checkbox" 
                                                            type="checkbox" id="{{ $key }}"
                                                            onclick="toggleGroupCheckboxes('{{ $key }}', this)">
                                                        <label class="custom-control-label font-weight-bold text-white" for="{{ $key }}">
                                                            {{ str_replace('-', ' ', str_replace('_', ' ', ucfirst($key))) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($routeList[$key] as $item => $value)
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input {{ $key }} individual-checkbox" 
                                                                type="checkbox" id="{{ $key }}{{ $item }}"
                                                                name="permission[{{ $key }}][]" value="{{ $item }}">
                                                            <label class="custom-control-label font-weight-bold" for="{{ $key }}{{ $item }}">
                                                                {{ str_replace('-', ' ', str_replace('_', ' ', ucfirst($item))) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer mt-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn save_btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    // Master "Select All"
    function toggleAllCheckboxes(masterCheckbox) {
        const isChecked = masterCheckbox.checked;
        document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.checked = isChecked;
        });
    }

    // Group-level select
    function toggleGroupCheckboxes(groupClass, checkbox) {
        const checkboxes = document.querySelectorAll(`.${groupClass}`);
        checkboxes.forEach((cb) => {
            cb.checked = checkbox.checked;
        });
    }
</script>
