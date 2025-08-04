@props([
    'title' => '',
    'sizeClass' => '',
    'submitBtnClass' => '',
])
    <div class="modal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="Delete" style="border-radius: 25px;"
        aria-hidden="true">
        <div class="modal-dialog {{ $sizeClass }}" role="document">
            <div class="px-4 modal-content" style="border-radius: 25px">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                </div>
                <div class="modal-body" style="border-radius: 25px">
                    <div class="col-md-12">
                        <div class="row">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="padding: 3px 20px; background: #f04438;color:white; border-radius:25px" class="btn" data-dismiss="modal">Cancel</button> 
                    <button type="submit" style="padding: 3px 20px; background: #12b76a;color:white; border-radius:25px;margin-right: 5px" class="btn {{$submitBtnClass}} save">Save</button>
                </div>
            </div>
        </div>
    </div>
