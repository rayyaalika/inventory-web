<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InventoryNest</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
              <li class="sidebar-item">
                  <a class="sidebar-link" href="{{ url('/prediction') }}" aria-expanded="false">
                    <span>
                      <i class="ti ti-graph"></i>
                    </span>
                    <span class="hide-menu">Prediction</span>
                  </a>
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
            <div class="card">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Profile</h5>
                    <form class="m-5" action="{{ url('profile/edit/' . $user->id_user ) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ $user->name }}" aria-label="name">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" value="{{ $user->email }}" aria-label="email">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" aria-label="password" value="">
                      </div>
                      <div class="mt-4 d-flex justify-content-end">
                        <button name="submit" type="submit" class="btn btn-primary">update</button>
                      </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>