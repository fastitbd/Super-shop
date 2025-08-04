@extends('backend.layouts.master')
@section('section-title', 'Role & Permission')
@section('page-title', 'Role & Permission Update')
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
                    <form class="needs-validation" action="{{ route('roles-permission.update', $role->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3"></div>
                            <div class="mb-3 col-md-6">
                                <label for="validationCustom01" class="form-label font-weight-bold">
                                    Role Name
                                </label>
                                <input type="text" class="form-control" id="validationCustom01"
                                    placeholder="Enter Role Name" name="name" required value="{{ $role->name }}">
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="card" style="border: 1px solid #000ce2;">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title text-white">Permission</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                            <!-- Master Select All -->
                                    <div class="mb-2">
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
                                                            <input class="custom-control-input group-checkbox" 
                                                                type="checkbox" id="{{ $key }}"
                                                                onclick="toggleGroupCheckboxes('{{ $key }}', this)">
                                                            <label class="custom-control-label font-weight-bold text-white" for="{{ $key }}">
                                                                {{ str_replace('-', ' ', str_replace('_', ' ', ucfirst($key))) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($routeList[$key] as $item => $checked)
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input {{ $key }} individual-checkbox"
                                                                    type="checkbox"
                                                                    id="{{ $key }}{{ $item }}"
                                                                    name="permission[{{ $key }}][]"
                                                                    value="{{ $item }}"
                                                                    {{ $checked == 1 ? 'checked' : '' }}>
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

    // Group-level checkbox
    function toggleGroupCheckboxes(groupClass, checkbox) {
        document.querySelectorAll(`.${groupClass}`).forEach(cb => cb.checked = checkbox.checked);
        updateMasterCheckbox(); // update master checkbox
    }

    // On page load, auto-select group checkboxes based on child items
    function updateGroupCheckboxes() {
        document.querySelectorAll('.group-checkbox').forEach(groupCb => {
            const group = groupCb.id;
            const children = document.querySelectorAll(`.${group}`);
            const allChecked = [...children].every(cb => cb.checked);
            groupCb.checked = allChecked;
        });
    }

    // Update master "Select All" checkbox
    function updateMasterCheckbox() {
        const groupCheckboxes = document.querySelectorAll('.group-checkbox');
        const allGroupsChecked = [...groupCheckboxes].every(cb => cb.checked);
        document.getElementById('selectAll').checked = allGroupsChecked;
    }

    // On individual checkbox change, update parent group and master checkbox
    document.querySelectorAll('.individual-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            updateGroupCheckboxes();
            updateMasterCheckbox();
        });
    });

    // On page load
    window.addEventListener('DOMContentLoaded', function () {
        updateGroupCheckboxes();
        updateMasterCheckbox();
    });
</script>
