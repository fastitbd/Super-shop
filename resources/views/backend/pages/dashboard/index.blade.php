@extends('backend.layouts.master')
@section('page-title', 'Dashboard')
@push('css')
    <style>
        .order-card {
            color: #fff;
        }

        .bg-c-blue {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg, #FFB64D, #ffcb80);
        }

        .bg-c-pink {
            background: linear-gradient(45deg, #FF5370, #ff869a);
        }


        .card {
            border-radius: 25px;
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 25px;
        }

        .order-card i {
            font-size: 26px;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }
    </style>
@endpush

@section('content')
    @php

        $total_invoice = App\Models\Invoice::sum('total_amount');
        $total_return = App\Models\ReturnTbl::sum('total_return');
        $total_purchase = App\Models\Purchase::sum('total_amount');
        $return_purchase = App\Models\ReturnPurchase::sum('total_return');

    @endphp
    <div class=" ms-3  d-none d-md-block" style="margin-left:20px;margin-top:90px;margin-bottom: 50px;">
        <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10 filter_design">
                    <ul class="nav justify-content-end" id="filterNav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-filter="Today">Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-filter="Yesterday">Yesterday</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-filter="This-week">This Week</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-filter="This-month">This Month</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-filter="This-year">This Year</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>

        <div class="row mt-3">
            <div class="col-md-4 col-xl-3">
                <div class="card order-card before_work_height" style="background: #fcfcfd">
                    <div class="card-block">

                        <h6 class="text-left" style="font-size: 18px"><span class="filterName"></span> Sale</h6>
                        <h4 class="text-left" id="saleAmount" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($data['sale'], 0) }} </span>
                        </h4>
                    </div>
                </div>
            </div>
            @if (check_permission('dashboard.dashboard'))
                <div class="col-md-4 col-xl-3">
                    <div class="card order-card before_work_height2" style="background: #fcfcfd">
                        <div class="card-block">
                            <h6 class="text-left" style="font-size: 18px"><span class="filterName"></span> Purchase</h6>
                            <h4 class="text-left" id="purchaseAmount" style="font-size: 23px">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($data['purchase'], 0) }} </span>
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-4 col-xl-3">
                <div class="card order-card before_work_height3" style="background: #fcfcfd">
                    <div class="card-block">
                        <h6 class="text-left" style="font-size: 18px"><span class="filterName"></span> Expense</h6>
                        <h4 class="text-left" id="expenseAmount" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($data['expense'], 2) }} </span>
                        </h4>
                    </div>
                </div>
            </div>
            @if (check_permission('dashboard.dashboard'))
                <div class="col-md-4 col-xl-3">
                    <div class="card order-card before_work_height4 " style="background: #fcfcfd">
                        <div class="card-block">
                            <h6 class="text-left" style="font-size: 18px"><span class="filterName"></span> Profit</h6>
                            <h4 class="text-left" id="profitAmount" style="font-size: 23px">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($data['profit'], 2) }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            {{-- 1st col --}}
            <div class="col-md-4 col-xl-4">
                <div class="card order-card" style="background: #fcfcfd">
                    @if (check_permission('dashboard.dashboard'))
                        <div class="card-block">
                            <h6 class="text-left" style="font-size: 18px">Total Purchase Due</h6>
                            <h4 class="text-left" style="font-size: 23px">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_pur_due, 0) }} </span>
                            </h4>
                        </div>
                    @endif
                    @if (check_permission('dashboard.dashboard'))
                        <p class="before_work"></p>
                        <div class="card-block d-none d-md-block">
                            <h6 class="text-left" style="font-size: 18px">Total Purchase Amount</h6>
                            <h4 class="text-left" style="font-size: 23px">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_pur_amount, 0) }} </span>
                            </h4>
                        </div>
                    @endif
                    {{-- mobile view --}}
                    <!-- <div class="card-block d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Total Sales Due</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                                {{ number_format($total_sale_due, 0) }} </span>
                                        </h4>
                                    </div> -->
                    <p class="before_work_orange"></p>
                    <div class="card-block d-none d-md-block">
                        <h6 class="text-left" style="font-size: 18px">Total Product</h6>
                        <h4 class="text-left" style="font-size: 23px"><span>
                                {{ number_format($total_product, 0) }} </span>
                        </h4>
                    </div>
                    {{-- mobile view --}}
                    <!-- <div class="card-block d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Total Return Amount</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                                {{ number_format($total_return_amount, 0) }} </span>
                                        </h4>
                                    </div> -->
                </div>
            </div>
            {{-- 2nd col --}}
            <div class="col-md-4 col-xl-4">
                <div class="card order-card" style="background: #fcfcfd">
                    <div class="card-block d-none d-md-block">
                        <h6 class="text-left" style="font-size: 18px">Total Sales Due</h6>
                        <h4 class="text-left" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($total_sale_due, 0) }} </span>
                        </h4>
                    </div>
                    {{-- mobile view --}}
                    <!-- <div class="card-block  d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Total Purchase Amount</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                                {{ number_format($total_pur_amount, 0) }} </span>
                                        </h4>
                                    </div> -->
                    <p class="before_work2"></p>
                    <div class="card-block ">
                        <h6 class="text-left" style="font-size: 18px">Total Sales Amount</h6>
                        <h4 class="text-left" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($total_sale, 0) }} </span>
                        </h4>
                    </div>
                    {{-- mobile view --}}
                    <!-- <div class="card-block  d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Available Stock Amount</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                        </h4>
                                    </div> -->
                    <p class="before_work_green"></p>
                    <div class="card-block d-none d-md-block">
                        <h6 class="text-left" style="font-size: 18px">Total Customer </h6>
                        <h4 class="text-left" style="font-size: 23px"><span>
                                {{ number_format($total_customer, 0) }} </span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="card order-card" style="background: #fcfcfd;border-radius:20px">
                    <div class="card-block d-none d-md-block">
                        <h6 class="text-left" style="font-size: 18px">Total Return Amount</h6>
                        <h4 class="text-left" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($total_return_amount, 0) }} </span>
                        </h4>
                    </div>
                    {{-- mobile view --}}
                    <!-- <div class="card-block  d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Total Product</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>
                                                {{ number_format($total_product, 0) }} </span>
                                        </h4>
                                    </div> -->
                    <p class="before_work3"></p>
                    <div class="card-block d-none d-md-block">
                        <h6 class="text-left" style="font-size: 18px">Available Stock Amount</h6>
                        <h4 class="text-left" style="font-size: 23px">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($totalPrice, 0) }} </span>
                        </h4>
                    </div>
                    {{-- mobile view --}}
                    <!-- <div class="card-block  d-block d-md-none">
                                        <h6 class="text-left" style="font-size: 18px">Total Customer</h6>
                                        <h4 class="text-left" style="font-size: 23px"><span>
                                                {{ number_format($total_customer, 0) }} </span>
                                        </h4>
                                    </div> -->
                    <p class="before_work_last"></p>
                    <div class="card-block">
                        <h6 class="text-left" style="font-size: 18px">Total Invoice </h6>
                        <h4 class="text-left" style="font-size: 23px"><span>
                                {{ number_format($total_invoice_count, 0) }} </span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- mobile view --}}

    <section class="d-block d-md-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="overview text-start">
                        <h5>Dashboard</h5>
                    </div>
                </div>
                <div class="col-6">
                    <div class="overview_btn text-end">
                        <div class="btn-group text-end">
                            <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10 filter_design">
                                        <div class="form-group form_group text-end">
                                            <select name="filter" id="filterSelect"
                                                class="form-select w-auto d-inline-block">
                                                <option value="Today">Today</option>
                                                <option value="Yesterday">Yesterday</option>
                                                <option value="This-week">This Week</option>
                                                <option value="This-month">This Month</option>
                                                <option value="This-year">This Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4" style="padding: 0px 5px;">
                    <div class="today_item">
                        <h6>Today Sale</h6>
                        <h5 class="sale" id="saleAmount">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($data['sale'], 0) }} </span>
                        </h5>

                    </div>
                </div>
                <div class="col-4" style="padding: 0px 5px;">
                    <div class="today_item">
                        <h6>Today Purchase</h6>
                        <h5 class="purchase" id="purchaseAmount">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($data['purchase'], 0) }}</span>
                        </h5>
                    </div>
                </div>
                <div class="col-4" style="padding: 0px 5px;">
                    <div class="today_item">
                        <h6>Today Expense</h6>
                        <h5 class="expense" id="expenseAmount">
                            <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                {{ number_format($data['expense'], 2) }} </span>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="today_profit d-flex">
                        <div class="today_dtls d-flex">
                            <div class="dtls_icon">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div class="dtls_hding">
                                <h5>Today Profit</h5>
                            </div>
                        </div>
                        <div class="today_amount">
                            <h5 id="profitAmount">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($data['profit'], 2) }}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="Purchase_item">
                        <div class="Purchase_item_dtls">
                            <h6>Total Purchase Due</h6>
                            <h5 class="item_due">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_pur_due, 0) }} </span>
                            </h5>
                        </div>
                        <div class="Purchase_item_dtls">
                            <h6>Total Expense</h6>
                            <h5 class="item_amount">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_expenses, 0) }} </span>
                            </h5>
                        </div>
                        <div class="Purchase_item_dtls">
                            <h6>Total Purchase Amount</h6>
                            <h5 class="ttl_due">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_pur_amount, 0) }} </span></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="Purchase_sale">
                        <div class="Purchase_item_dtls">
                            <h6>Total Sale Due</h6>
                            <h5 class="Sale_due">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_sale_due, 0) }} </span>
                            </h5>
                        </div>
                        <div class="Purchase_item_dtls">
                            <h6>Total Sale Amount</h6>
                            <h5 class="Sale_amount">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($total_sale, 0) }} </span>
                            </h5>
                        </div>
                        <div class="Purchase_item_dtls">
                            <h6>Total Available Stock</h6>
                            <h5 class="Sale_total">
                                <span>{{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                    {{ number_format($totalPrice, 0) }} </span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection
@push('js')
    <script>
        document.getElementById('filterSelect').addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#filterSelect').change(function () {
                $('#filterForm').submit();
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Handle filter link clicks
            $('#filterNav .nav-link').click(function (e) {
                e.preventDefault(); // Prevent default anchor behavior

                // Remove 'active' class from all links
                $('#filterNav .nav-link').removeClass('active');

                // Add 'active' class to the clicked link
                $(this).addClass('active');

                // Get the selected filter from data-filter attribute
                let selectedFilter = $(this).data('filter');
                console.log('Selected Filter:', selectedFilter);

                // Update the filter name dynamically in the UI
                $('.filterName').text(selectedFilter.charAt(0).toUpperCase() + selectedFilter.slice(1));

                // Perform an AJAX request to apply the filter
                $.ajax({
                    url: "{{ route('your.filter.route') }}", // Replace with your route
                    type: "GET",
                    data: {
                        filter: selectedFilter
                    },
                    success: function (response) {
                        // Handle the response (update the UI dynamically if needed)
                        // console.log('Filter applied:', response);
                        $('#saleAmount').text('৳ ' + response.sale.toLocaleString());
                        $('#purchaseAmount').text('৳ ' + response.purchase.toLocaleString());
                        $('#expenseAmount').text('৳ ' + response.expense.toLocaleString());
                        $('#profitAmount').text('৳ ' + response.profit.toLocaleString());
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });
        });
    </script>
@endpush