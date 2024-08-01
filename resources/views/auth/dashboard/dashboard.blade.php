<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InventoryNest</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
      .font-button {
          font-size: 8pt;
      }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">


        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        @php
                            $role = Auth::user()->role;
                        @endphp

                        <li class="sidebar-item">
                            @if ($role == 'Super Admin')
                                <a class="sidebar-link" href="{{ route('superadmin') }}" aria-expanded="false">
                                @elseif($role == 'Store Admin')
                                    <a class="sidebar-link" href="{{ route('storeadmin') }}" aria-expanded="false">
                                    @elseif($role == 'Supplier')
                                        <a class="sidebar-link" href="{{ route('supplier') }}" aria-expanded="false">
                                        @elseif($role == 'Cutomer Service')
                                            <a class="sidebar-link" href="{{ route('customerservice') }}"
                                                aria-expanded="false">
                                            @elseif($role == 'Sales Order')
                                                <a class="sidebar-link" href="{{ route('salesorder') }}"
                                                    aria-expanded="false">
                            @endif
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Menu</span>
                        </li>
                        @php
                            $allowedRoles = ['Super Admin'];
                            $userRole = Auth::check() ? Auth::user()->role : null;
                        @endphp
                        @if (Auth::check() && !in_array($userRole, ['Store Admin', 'Supplier', 'Cutomer Service', 'Sales Order']))
                            @if (in_array($userRole, $allowedRoles))
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ url('/user') }}" aria-expanded="false">
                                        <span>
                                            <i class="ti ti-user"></i>
                                        </span>
                                        <span class="hide-menu">User</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li>
                            @php
                                $allowedRoles = ['Super Admin'];
                                $userRole = Auth::check() ? Auth::user()->role : null;
                            @endphp
                            @if (Auth::check() && !in_array($userRole, ['Store Admin', 'Supplier', 'Cutomer Service', 'Sales Order']))
                                @if (in_array($userRole, $allowedRoles))
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('/prediction') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-graph"></i>
                                </span>
                                <span class="hide-menu">Prediction</span>
                            </a>
                        </li>
                        @endif
                        @endif
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('/product') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-package"></i>
                                </span>
                                <span class="hide-menu">Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('/sales') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="hide-menu">Sales</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('/shipping') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-truck"></i>
                                </span>
                                <span class="hide-menu">Shipping</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                          </a>
                        </li>
                        {{-- <li class="nav-item">
                          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                          </a>
                        </li> --}}
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold fs-3">{{ Auth::user()->name }}</h5>
                            </div>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="{{ url('/profile/' . Auth::user()->id_user) }}"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="{{ url('logout') }}"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->

            <!--  Row 1 -->
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row alig n-items-start">
                                            <div class="col-4">
                                                <div class="d-flex justify-content-end">
                                                    <div
                                                        class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-wallet fs-6"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <h5 class="card-title mb-2 fw-semibold">Total Sales</h5>
                                                {{-- <p class="mb-2">Per Month</p> --}}
                                                <h4 class="fw-semibold mb-1">${{ $totalSalesAmount }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row alig n-items-start">
                                            <div class="col-4">
                                                <div class="d-flex justify-content-end">
                                                    <div
                                                        class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-shopping-cart fs-6"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <h5 class="card-title fw-semibold">Total Order</h5>
                                                {{-- <p class="mb-2">Per Month</p> --}}
                                                <h4 class="fw-semibold mb-1">{{ $totalSales }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row alig n-items-start">
                                            <div class="col-4">
                                                <div class="d-flex justify-content-end">
                                                    <div
                                                        class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-truck fs-6"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <h5 class="card-title mb-2 fw-semibold">Total Shipping</h5>
                                                {{-- <p class="mb-2">Per Month</p> --}}
                                                <h4 class="fw-semibold mb-1">{{ $totalCollectedDeliveries }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  Row 2 -->
                <div class="comtainer-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                        <div class="mb-3 mb-sm-0">
                                            <h5 class="card-title fw-semibold">Sales Amount</h5>
                                        </div>
                                    </div>
                                    <div id="chartamount"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                        <div class="mb-3 mb-sm-0">
                                            <h5 class="card-title fw-semibold">Sales Overview</h5>
                                        </div>
                                    </div>
                                    <div id="chartsales"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  Row 3 -->
                <div class="comtainer-fluid">
                    <div class="col-lg-12 d-flex align-items-strech">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Prediction</h5>
                                    </div>
                                </div>
                                <form class="mb-3" method="GET" action="{{ url('/home') }}">
                                    <select class="form-select" name="parameter" onchange="this.form.submit()">
                                        <option value="" selected>-- select --</option>
                                        @foreach ($selectitems as $index => $item)
                                            <option value="{{ $item }}"
                                                {{ $selectedParameter == $item ? 'selected' : '' }}>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @if (!empty($selectedParameter))
                                    <div class="d-flex flex-row">
                                        <div id="chartpred" style="flex: 4;"></div>
                                        <div class="table responsive ms-3" style="flex: 1; max-height: 400px; overflow-y: auto;">
                                            <table class="table table-bordered font-button">
                                                <thead>
                                                    <tr class="pt-1 pb-1 ps-0 pe-0">
                                                        <th class="pt-1 pb-2 ps-2 pe-0">Date</th>
                                                        <th class="pt-1 pb-2 ps-2 pe-0">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($predictionsData as $data)
                                                        <tr class="pt-1 pb-1 ps-0 pe-0">
                                                            <td class="pt-1 pb-1 ps-2 pe-0">{{ $data['date'] }}</td>
                                                            <td class="pt-1 pb-1 ps-2 pe-0">{{ $data['value'] }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-center">No prediction data available</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if (empty($predictionsData))
                                        <p class="mt-3 text-center">No prediction data available for {{ $selectedParameter }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <!--  Row 4 -->
      <div class="comtainer-fluid">
        <div class="col-lg-12 d-flex align-items-strech">
          <div class="card w-100">
            <div class="card-body">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">Product Sales Forecast Deatils</h5>
                </div>
                <div class="mb-3 mb-sm-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Forecast</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>January 2024</td>
                        <td>POTABEE</td>
                        <td>230</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div> --}}

            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>

    <script>
        // Data totalSalesAmount per bulan
        const salesData = @json($totalSalesAmountPerMonth);

        var options = {
            series: [{
                name: 'Total Sales Amount',
                data: salesData
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            // title: {
            //     text: 'Sales Overview per Month',
            //     align: 'left'
            // },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // an alternation
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartamount"), options);
        chart.render();
    </script>
    <script>
        // Data totalSalesAmount dan totalCollectedDeliveries per bulan
        const totalSalesPerMonth = @json($totalSalesPerMonth);
        const totalCollectedDeliveriesPerMonth = @json($totalCollectedDeliveriesPerMonth);

        var options = {
            series: [{
                name: 'Total Sales',
                data: totalSalesPerMonth
            }, {
                name: 'Total Collected Deliveries',
                data: totalCollectedDeliveriesPerMonth
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            // yaxis: {
            //     title: {
            //         text: 'Amount'
            //     }
            // },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " Sales";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartsales"), options);
        chart.render();
    </script>
    <script>
        // Ambil data dari PHP ke JavaScript
        var predictionsData = @json($predictionsData ?? []);

        // Persiapkan data untuk chart
        var chartData = {
            series: [{
                name: "{{ $selectedParameter }}",
                data: predictionsData.length ? predictionsData.map(data => ({
                    x: new Date(data.date),
                    y: data.value
                })) : []
            }],
            chart: {
                height: 350,
                type: 'area',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            markers: {
              size: 5,
              hover: {
                size: 9
              }
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'MMM' // Format tampilan bulan (Jan, Feb, Mar, ...)
                }
                // title: {
                //     text: 'Date'
                // }
            },
            yaxis: {
                // title: {
                //     text: 'Value'
                // }
            }
        };

        // Inisialisasi grafik menggunakan ApexCharts
        var chart = new ApexCharts(document.querySelector("#chartpred"), chartData);
        chart.render();
    </script>

</body>

</html>
