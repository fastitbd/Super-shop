@push('css')
    <style>

    </style>
@endpush
<div class="footerbar mt-3 d-none d-md-block">
    <footer class="footer">
        <p class="mb-0">© {{ date('Y') }} FastIT - All Rights Reserved.</p>
    </footer>
</div>

<footer class="d-block d-md-none">
    <div class="mobile_footer">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="footer_content d-flex">
                        <div class="footer_icon text-center">
                            <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'active' : '' }}">
                                <i class="fa-solid fa-house"></i>
                                <h5 class="footer_con">Dashboard</h5>
                            </a>
                        </div>
                        <div class="footer_icon text-center">
                            <a href="{{ route('invoice.create') }}"
                                class="{{ Route::is('invoice.create') ? 'active' : '' }}">
                                <i class="fa-solid fa-receipt"></i>
                                <h5 class="footer_con">POS</h5>
                            </a>
                        </div>
                        <div class="footer_icon text-center">
                            <a href="{{ route('invoice.index') }}"
                                class="{{ Route::is('invoice.index') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-invoice"></i>
                                <h5 class="footer_con">Invoice</h5>
                            </a>
                        </div>
                        <div class="footer_icon text-center">
                            <a href="{{ route('product.index') }}"
                                class="{{ Route::is('product.index') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck-ramp-box"></i>
                                <h5 class="footer_con">Product</h5>
                            </a>
                        </div>
                        <div class="footer_icon text-center">
                            <a class="menu-hamburger" href="javascript:void();">
                                <i class="fa-solid fa-border-all"></i>
                                <h5 class="footer_con">
                                    <div class="menubar">More</div>
                                </h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12">
                    <div class="footer_content" >
                        <ul>
                            <li>
                                <div class="footer_icon text-center">
                                    <a  href="{{ route('dashboard') }}"
                                        class="{{ Route::is('dashboard') ? 'active' : '' }}">
                                        <i class="fa-solid fa-house"></i>
                                        <h5 class="footer_con">Dashboard</h5>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="footer_icon text-center">
                                    <a href="{{ route('invoice.create') }}"
                                        class="{{ Route::is('invoice.create') ? 'active' : '' }}">
                                        <i class="fa-solid fa-receipt"></i>
                                        <h5 class="footer_con">POS</h5>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="footer_icon text-center">
                                    <a href="{{ route('invoice.index') }}"
                                        class="{{ Route::is('invoice.index') ? 'active' : '' }}">
                                        <i class="fa-solid fa-file-invoice"></i>
                                        <h5 class="footer_con">Invoice</h5>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="footer_icon text-center">
                                    <a href="{{ route('product.index') }}"
                                        class="{{ Route::is('product.index') ? 'active' : '' }}">
                                        <i class="fa-solid fa-truck-ramp-box"></i>
                                        <h5 class="footer_con">Product</h5>
                                    </a>
                                </div>
                            </li>

                            <li>
                                <div class="footer_icon text-center">
                                    <a class="menu-hamburger" href="javascript:void();">
                                        <i class="fa-solid fa-border-all"></i>
                                        <h5 class="footer_con">
                                            <div class="menubar">More</div></h5>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div> -->

        </div>
    </div>

</footer>