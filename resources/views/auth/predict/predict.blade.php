<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InventoryNest</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.589); /* Warna latar belakang overlay */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Pastikan overlay muncul di atas elemen lainnya */
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
                @if($role == 'Super Admin')
                    <a class="sidebar-link" href="{{ route('superadmin') }}" aria-expanded="false">
                @elseif($role == 'Store Admin')
                    <a class="sidebar-link" href="{{ route('storeadmin') }}" aria-expanded="false">
                @elseif($role == 'Supplier')
                    <a class="sidebar-link" href="{{ route('supplier') }}" aria-expanded="false">
                @elseif($role == 'Cutomer Service')
                    <a class="sidebar-link" href="{{ route('customerservice') }}" aria-expanded="false">
                @elseif($role == 'Sales Order')
                    <a class="sidebar-link" href="{{ route('salesorder') }}" aria-expanded="false">
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
            @if(Auth::check() && !in_array($userRole, ['Store Admin', 'Supplier', 'Cutomer Service', 'Sales Order']))
                @if(in_array($userRole, $allowedRoles))
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
              @if(Auth::check() && !in_array($userRole, ['Store Admin', 'Supplier', 'Cutomer Service', 'Sales Order']))
                  @if(in_array($userRole, $allowedRoles))                    
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
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="{{ url('/profile/' . Auth::user()->id_user) }}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="{{ url('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->

    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Product Prediction</h5>
                    </div>
                    @if(session('alert'))
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{ session('alert') }}
                          <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    <form action="{{ route('prediction.predict') }}" method="post" id="predictionForm">
                        @csrf
                        <label for="item_name">Select item to be predicted: </label>
                        <select class="form-select mb-3 mt-1" id="item_name" name="item_name" required>
                            <option value="" selected>--select item--</option>
                            @foreach($items as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <input class="btn btn-primary" type="submit" value="Predict">
                    </form>
                </div>
            </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                  <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                      <h5 class="card-title fw-semibold">Prediction Result</h5>
                    </div>
                  </div>                  
                    <form method="GET" action="{{ route('predictions') }}">
                      <label for="item_name">Select item to show prediction result: </label>
                      <select class="form-select" name="parameter" onchange="this.form.submit()">
                          <option value="" selected>-- select --</option>
                          @foreach ($selectitems as $index => $item)
                              <option value="{{ $item }}" {{ $selectedParameter == $item ? 'selected' : '' }}>{{ $item }}</option>
                          @endforeach
                      </select>
                      @if(!empty($selectedParameter))
                      <div class="table-responsive">
                        <table class="table font-button mt-3">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Value</th>
                            </tr>
                          </thead>
                              <tbody>
                                @forelse($predictionsData as $data)
                                      <tr>
                                          <td>{{ $data['date'] }}</td>
                                          <td>{{ $data['value'] }}</td>
                                      </tr>
                                @empty
                                      <tr>
                                        <td colspan="11" class="text-center">No prediction data available</td>
                                      </tr>
                                @endforelse
                              </tbody>
                          </table>
                      </div>
                      @endif
                   </form>
                  </div>
                </div>
            </div>
        </div>


    </div>
      {{-- @if(isset($predictions) && isset($dates))
        <div class="container-fluid mt-4">
          <div class="col-lg-12">
              <div class="card w-100">
                  <h2>Hasil Prediksi untuk {{ $item_name }}</h2>
                  <table class="table">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Prediksi Jumlah</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($dates as $index => $date)
                              <tr>
                                  <td>{{ $date->format('Y-m') }}</td>
                                  <td>{{ $predictions[$index][0] }}</td>
                              </tr>
                          @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
      @endif --}}
   
    
      
      </div>      
    </div>
  </div>

  <!-- Elemen overlay loading -->
  <div id="loadingOverlay" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
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
    document.getElementById('predictionForm').addEventListener('submit', function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    });
    </script>

  <!-- In your main layout blade file or head section -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  {{-- <script>
    // Ambil data dari PHP ke JavaScript
    var predictionsData = @json($predictionsData);

    // Persiapkan data untuk chart
    var chartData = {
        series: [{
            name: "Predictions",
            data: predictionsData.map(data => ({
                x: new Date(data.date),
                y: data.value
            }))
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'datetime',
            title: {
                text: 'Date'
            }
        },
        yaxis: {
            title: {
                text: 'Value'
            }
        }
    };

    // Inisialisasi grafik menggunakan ApexCharts
    var chart = new ApexCharts(document.querySelector("#chartpredict"), chartData);
    chart.render();
  </script> --}}
</body>

</html>