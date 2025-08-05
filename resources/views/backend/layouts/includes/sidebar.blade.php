<div class="leftbar">
    <div class="sidebar">
        <div class="logobar">
            <a href="{{ route('dashboard') }}" class="logo logo-large">
                <img src="{{ (!empty(get_setting('system_logo'))) ? url('public/uploads/logo/' . get_setting('system_logo')) : url('backend/images/fastLogo.jpeg') }}"
                    style="width: 150px; height: 50px;" alt="logo">
            </a>
            <a href="{{ route('dashboard') }}" class="logo logo-small">
                <img src="{{ (!empty(get_setting('system_icon'))) ? url('public/uploads/logo/' . get_setting('system_icon')) : url('backend/images/favicon.png') }}"
                    style="width: 32px; height: 32px;" alt="logo">
            </a>
        </div>

        <div class="navigationbar">
            <ul class="vertical-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <div class="menu-category menu-padding">
                    SALE & PURCHASE
                </div>

                <li>
                    <a href="{{ route('invoice.create') }}">
                        <i class="fa fa-cart-plus"></i>
                        <span>POS</span>
                    </a>
                </li>

                @if (main_menu_permission('invoice'))
                    <li>
                        @if (check_permission('invoice.index'))
                            <a href="{{ route('invoice.index') }}">
                                <i class="fa fa-shopping-bag"></i>
                                <span>Sale List</span>
                            </a>
                        @endif
                    </li>
                @endif

                @if (main_menu_permission('purchase'))
                    <li>
                        <a href="javaScript:void();">
                            <i class="fa fa-book"></i>
                            <span>Purchase</span>
                            <i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            @if (check_permission('purchase.create'))
                                <li>
                                    <a href="{{ route('purchase.create') }}">
                                        Add Purchase
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('purchase.index'))
                                <li>
                                    <a href="{{ route('purchase.index') }}">
                                        Purchase List
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-undo"></i>
                        <span>Return</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        @if (check_permission('return.sale'))
                            <li>
                                <a href="{{ route('return.sale') }}">
                                    Return Sale List
                                </a>
                            </li>
                        @endif
                        @if (check_permission('rtnPurchase.index'))
                            <li>
                                <a href="{{ route('rtnPurchase.index') }}">
                                    Return Purchase List
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href={{ route('damage.index') }}><i class="fa fa-trash" aria-hidden="true"></i>
                        <span>Damage</span>
                    </a>
                </li>
                @if (check_permission('report.stock'))
                    <li>
                        <a href="{{ route('report.stock') }}"><i class="fa fa-cube" aria-hidden="true"></i>
                            <span>Stock Report</span>
                        </a>
                    </li>
                @endif
                <div class="menu-category menu-padding">
                    Product Information
                </div>
                @if (check_permission('unit.index'))
                    <li>
                        <a href="{{ route('unit.index') }}">
                            <i class="fa fa-th-large"></i>
                            <span>Unit</span>
                        </a>
                    </li>
                @endif

                {{-- Products --}}
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-product-hunt"></i>
                        <span>Product</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        {{-- //create --}}
                        @if (check_permission('product.create'))
                            <li>
                                <a href="{{ route('product.create') }}">
                                    Add Product
                                </a>
                            </li>
                        @endif
                        {{-- //list --}}
                        @if (check_permission('product.index'))
                            <li>
                                <a href="{{ route('product.index') }}">
                                    Product List
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if (env('APP_SERVICE') == 'yes')
                    @if (main_menu_permission('service'))
                        <li>
                            <a href="javaScript:void();">
                                <i class="fa fa-book"></i>
                                <span>Service</span>
                                <i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                @if (check_permission('service.create'))
                                    <li>
                                        <a href="{{ route('service.create') }}">
                                            Add Service
                                        </a>
                                    </li>
                                @endif
                                @if (check_permission('service.index'))
                                    <li>
                                        <a href="{{ route('service.index') }}">
                                            Service List
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Category --}}
                @if (check_permission('category.index'))
                    <li>
                        <a href="{{ route('category.index') }}">
                            <i class="fa fa-outdent"></i>
                            <span>Category</span>
                        </a>
                    </li>
                @endif

                {{-- Sub Category --}}
                @if (check_permission('subCategory.index'))
                    <li>
                        <a href="{{ route('subCategory.index') }}">
                            <i class="fa fa-outdent"></i>
                            <span>Sub Category</span>
                        </a>
                    </li>
                @endif

                {{-- banner --}}
                @if (check_permission('banner.index'))
                    <li>
                        <a href="{{ route('banner.index') }}">
                            <i class="fa fa-outdent"></i>
                            <span>Banner</span>
                        </a>
                    </li>
                @endif

                {{-- Shop banner --}}
                @if (check_permission('shopBanner.index'))
                    <li>
                        <a href="{{ route('shopBanner.index') }}">
                            <i class="fa fa-outdent"></i>
                            <span>Shop Banner</span>
                        </a>
                    </li>
                @endif

                {{-- Brand --}}
                @if (check_permission('brand.index'))
                    <li>
                        <a href="{{ route('brand.index') }}">
                            <i class="fa fa-shield"></i>
                            <span>Brand</span>
                        </a>
                    </li>
                @endif
                @if(env('APP_SC') == 'yes')
                    {{-- color --}}
                    @if (check_permission('color.index'))
                        <li>
                            <a href="{{ route('color.index') }}">
                                <i class="fa fa-shield"></i>
                                <span>Color</span>
                            </a>
                        </li>
                    @endif
                    {{-- size --}}
                    @if (check_permission('size.index'))
                        <li>
                            <a href="{{ route('size.index') }}">
                                <i class="fa fa-shield"></i>
                                <span>Size</span>
                            </a>
                        </li>
                    @endif
                    {{-- size --}}
                    {{-- @if (check_permission('variation.index'))
                    <li>
                        <a href="{{ route('variation.index') }}">
                            <i class="fa fa-shield"></i>
                            <span>Variation</span>
                        </a>
                    </li>
                    @endif --}}
                @endif

                @if (env('APP_USED') == 'yes')
                    <div class="menu-category menu-padding">
                        Used Product Information
                    </div>
                    @if (main_menu_permission('usedProduct'))
                        {{-- Products --}}
                        <li>
                            <a href="javaScript:void();">
                                <i class="fa fa-product-hunt"></i>
                                <span>Product</span>
                                <i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                {{-- //create --}}
                                @if (check_permission('usedProduct.create'))
                                    <li>
                                        <a href="{{ route('usedProduct.create') }}">
                                            Add Product
                                        </a>
                                    </li>
                                @endif
                                {{-- //list --}}
                                @if (check_permission('usedProduct.index'))
                                    <li>
                                        <a href="{{ route('usedProduct.index') }}">
                                            Product List
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (main_menu_permission('usedPurchase'))
                        <li>
                            <a href="javaScript:void();">
                                <i class="fa fa-book"></i>
                                <span>Buy</span>
                                <i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                @if (check_permission('usedPurchase.create'))
                                    <li>
                                        <a href="{{ route('usedPurchase.create') }}">
                                            Add Buy
                                        </a>
                                    </li>
                                @endif
                                @if (check_permission('usedPurchase.index'))
                                    <li>
                                        <a href="{{ route('usedPurchase.index') }}">
                                            Buy List
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (main_menu_permission('used'))
                        <li>
                            <a href="javaScript:void();">
                                <i class="fa fa-book"></i>
                                <span>Used</span>
                                <i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                @if (check_permission('used.create'))
                                    <li>
                                        <a href="{{ route('used.create') }}">
                                            Add Used
                                        </a>
                                    </li>
                                @endif
                                @if (check_permission('used.index'))
                                    <li>
                                        <a href="{{ route('used.index') }}">
                                            Used List
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (check_permission('report.used-stock'))
                        <li>
                            <a href="{{ route('report.used-stock') }}"><i class="fa fa-cube" aria-hidden="true"></i>
                                <span>Used Stock Report</span>
                            </a>
                        </li>
                    @endif
                @endif
                <div class="menu-category menu-padding">
                    EXPENSE & PAYMENT
                </div>

                {{-- expense --}}
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-paper-plane"></i>
                        <span>Expense</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        @if (check_permission('expense.create'))
                            <li>
                                <a href="{{ route('expense.create') }}">
                                    Add Expense
                                </a>
                            </li>
                        @endif
                        @if (check_permission('expense.index'))
                            <li>
                                <a href="{{ route('expense.index') }}">
                                    Expense List
                                </a>
                            </li>
                        @endif
                        {{-- //create --}}
                        @if (check_permission('expense.category-index'))
                            <li>
                                <a href="{{ route('expense.category-index') }}">
                                    Expense Category
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                {{-- Payment --}}
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-money"></i>
                        <span>Payment</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        {{-- //create --}}
                        @if (check_permission('payment.pay-supplier'))
                            <li>
                                <a href="{{ route('payment.pay-supplier') }}">
                                    Pay Supplier
                                </a>
                            </li>
                        @endif
                        {{-- //list --}}
                        @if (check_permission('payment.pay-customer'))
                            <li>
                                <a href="{{ route('payment.pay-customer') }}">
                                    Pay Customer
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <div class="menu-category menu-padding">
                    Customer & Supplier
                </div>

                <li>
                    <a href="{{ route('supplier.index') }}">
                        <i class="fa fa-suitcase"></i>
                        <span>Supplier</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.index') }}" class="{{ request()->is('customer*') ? 'active' : '' }}">
                        <i class="fa fa-briefcase"></i>
                        <span>Customer</span>
                    </a>
                </li>

                <div class="menu-category menu-padding">
                    Account
                </div>

                @if (main_menu_permission('bank-account'))

                    <li>
                        <a href="javaScript:void();">
                            <i class="fa fa-university"></i>
                            <span>Account</span>
                            <i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            @if (check_permission('bank-account.index'))
                                <li>
                                    <a href="{{ url('bank-account') }}">
                                        Bank Account
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('deposit-create'))
                                <li>
                                    <a href="{{ url('deposit') }}">
                                        Deposit
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('bank-transfer-index'))
                                <li>
                                    <a href="{{ url('bank-transfer-index') }}">
                                        Transfer
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('withdraw'))
                                <li>
                                    <a href="{{ url('withdraw') }}">
                                        Withdraw
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('ownership'))
                                <li>
                                    <a href="{{ route('ownership.index') }}">
                                        OwnerShip
                                    </a>
                                </li>
                            @endif
                            @if (check_permission('transaction-history'))
                                <li>
                                    <a href="{{ url('transaction-history') }}">
                                        Transaction History </a>
                                </li>
                            @endif
                            @if (env('APP_MODE') == 'demo')
                                <li>
                                    <a href="#">
                                        Balance Sheet <span class="badge badge-danger">Coming</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Trial Balance <span class="badge badge-danger">Coming</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Cash Flow <span class="badge badge-danger">Coming</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                @endif

                <div class="menu-category menu-padding">
                    Promotion
                </div>
                <li>
                    <a href="{{ url('sms') }}">
                        Promotional Sms
                    </a>
                </li>

                <div class="menu-category menu-padding">
                    Report & Ledger
                </div>

                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-text"></i>
                        <span>Report</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                         @if (check_permission('report.daily.stock'))
                            <li>
                                <a href="{{ route('report.daily.stock') }}">
                                    Daily Stock Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.stock'))
                            <li>
                                <a href="{{ route('report.stock') }}">
                                    Stock Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.daily'))
                            <li>
                                <a href="{{ route('report.daily') }}">
                                    Daily Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.sale'))
                            <li>
                                <a href="{{ route('report.sale') }}">
                                    Sale Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.reports.top-selling'))
                            <li>
                                <a href="{{ route('report.reports.top-selling') }}">
                                    Top Sale Product
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.sale'))
                            <li>
                                <a href="{{ route('report.sale') }}">
                                    Product Wise Sale
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.purchase'))
                            <li>
                                <a href="{{ route('report.purchase') }}">
                                    Purchase Report
                                </a>
                            </li>
                        @endif

                        @if (check_permission('report.supplier-ledger'))
                            <li>
                                <a href="{{ route('report.supplier-ledger') }}">
                                    Supplier Ledger
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.customer-ledger'))
                            <li>
                                <a href="{{ route('report.customer-ledger') }}">
                                    Customer Ledger
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.reports.customers'))
                            <li>
                                <a href="{{ route('report.reports.customers') }}">
                                    Top Customer
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.profit-loss'))
                            <li>
                                <a href="{{ route('report.profit-loss') }}">
                                    Profit Loss Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.low.stock'))
                            <li>
                                <a href="{{ route('report.low.stock') }}">
                                    Low Stock Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.user.sell'))
                            <li>
                                <a href="{{ route('report.user.sell') }}">
                                    User Sell Report
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.customer-due'))
                            <li>
                                <a href="{{ route('report.customer-due') }}">
                                    Customer Due
                                </a>
                            </li>
                        @endif
                        @if (check_permission('report.supplier-due'))
                            <li>
                                <a href="{{ route('report.supplier-due') }}">
                                    Supplier Due
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <div class="menu-category menu-padding">
                    Setting & Customize
                </div>

                {{-- users --}}
                @if (main_menu_permission('user'))
                    <li>
                        <a href="javaScript:void();">
                            <i class="fa fa-users"></i>
                            <span>User Management</span>
                            <i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            @if (check_permission('user.create'))
                                <li>
                                    <a href="{{ route('user.create') }}">
                                        Add User
                                    </a>
                                </li>
                            @endif

                            @if (check_permission('user.index'))
                                <li>
                                    <a href="{{ route('user.index') }}">
                                        User List
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- @if (main_menu_permission('roles-permission')) --}}
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-check-square"></i>
                        <span>Role Management</span>
                        <i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        {{-- @if (check_permission('roles-permission.index')) --}}
                        <li>
                            <a href="{{ route('roles-permission.index') }}">
                                Role & Permission
                            </a>
                        </li>
                        {{-- @endif --}}
                    </ul>
                </li>
                {{-- @endif --}}

                @if (check_permission('setting.index'))
                    <li>
                        <a href="{{ route('setting.index') }}">
                            <i class="fa fa-cogs"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                        class="profile-icon">
                        <img src="{{ asset('backend') }}/images/svg-icon/logout.svg" class="img-fluid" alt="logout">
                        Logout
                    </a>
                </li>

                @if (check_permission('status.download.backup'))
                    <li>
                        <a href="{{ route('status.download.backup') }}">
                            <i class="fa fa-cloud-download"></i>
                            <span>Backup</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>