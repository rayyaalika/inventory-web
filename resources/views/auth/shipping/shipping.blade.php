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
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
              <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Shipping Order</h5>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">ALL</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Waiting</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">HLIFE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">FAMILY MART</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false">HCT</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab6-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="false">7-11</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab7-tab" data-toggle="tab" href="#tab7" role="tab" aria-controls="tab7" aria-selected="false">POST</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab8-tab" data-toggle="tab" href="#tab8" role="tab" aria-controls="tab8" aria-selected="false">SHOPEE SHOP</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab9-tab" data-toggle="tab" href="#tab9" role="tab" aria-controls="tab9" aria-selected="false">OFFLINE</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab10-tab" data-toggle="tab" href="#tab10" role="tab" aria-controls="tab10" aria-selected="false">Send</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($salesData as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                <li><a class="dropdown-item"
                                                        href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                        Sales</a></li>
                                                <li><a class="dropdown-item" href=""
                                                        data-toggle="modal"
                                                        data-target="#paymentSalesModal{{ $sales->id_sales }}">
                                                        Resi & Payment</a></li>
                                                <li><a class="dropdown-item text-danger"
                                                        href="" data-toggle="modal"
                                                        data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete
                                                        Sales</a>
                                                </li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                        <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                            @csrf
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="btn-group-a">
                                            @php
                                                $statusClass = '';
                                                switch ($sales->sales_status) {
                                                    case 'Pending Address':
                                                        $statusClass = 'btn-warning';
                                                        break;
                                                    case 'Pending Shipment':
                                                        $statusClass = 'btn-danger';
                                                        break;
                                                    case 'Waiting List':
                                                        $statusClass = 'btn-success';
                                                        break;
                                                    case 'Ready to Approved':
                                                        $statusClass = 'btn-info';
                                                        break;
                                                    case 'Collected':
                                                        $statusClass = 'btn-primary';
                                                        break;
                                                    case 'Completed':
                                                        $statusClass = 'btn-dark';
                                                        break;
                                                    default:
                                                        $statusClass = '';
                                                        break;
                                                }
                                            @endphp                                      
                                            <button id="dropdown-toggle{{$sales->id_sales}}" type="button" class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{$sales->sales_status}}
                                            </button>                                    
                                            <ul class="dropdown-menu">
                                                <li><button class="dropdown-item" type="button" value="Pending Address" onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button></li>
                                                <li><button class="dropdown-item" type="button" value="Pending Shipment" onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button></li>
                                                <li><button class="dropdown-item" type="button" value="Waiting List" onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                <li><button class="dropdown-item" type="button" value="Ready to Approved" onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button></li>
                                                <li><button class="dropdown-item" type="button" value="Collected" onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                <li><button class="dropdown-item" type="button" value="Completed" onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                            </ul>
                                            </div>
                                            <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status" value="{{$sales->sales_status}}">
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' || $sales->sales_status == 'Waiting List')
                                            <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                            @else
                                            <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                            @endif
                                        </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-end">
                                {{ $salesData->links('vendor.pagination.bootstrap-5')}}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($tab1Sales as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($hlife as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($familymart as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($hct as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($d711 as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab7-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($post as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="tab8-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($shopee as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab9" role="tabpanel" aria-labelledby="tab9-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($offline as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab10" role="tabpanel" aria-labelledby="tab10-tab">
                            <div class="table-responsive">
                                <table class="table font-button mt-3">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>SQ Numbering</th>
                                        <th>Socmed</th>
                                        <th>Customer Name</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Delivery Method</th>
                                        <th>No Resi</th>
                                        <th>Status</th>
                                        <th>Aproved</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($tab2Sales as $sales)
                                    <tr>
                                        <td>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit
                                                            Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal"
                                                            data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal"
                                                            data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div> --}}
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots nav-small-cap-icon fs-5" data-toggle="tooltip" title="Actions"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ url('/sales/' . $sales->id_sales) }}">Edit Sales</a></li>
                                                    <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#paymentSalesModal{{ $sales->id_sales }}">Resi & Payment</a></li>
                                                    <li><a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#deleteSalesModal{{ $sales->id_sales }}">Delete Sales</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $sales->transaction_date }}</td>
                                        <td>{{ $sales->sq_numbering }}</td>
                                        <td>{{ $sales->socmed_type }}</td>
                                        <td>{{ $sales->customer_name }}</td>
                                        <td>{{ $sales->sales_note }}</td>
                                        <td>{{ $sales->total_order }}</td>
                                        <td>{{ $sales->delivery_company }}</td>
                                        <td>{{ $sales->resi_number }}</td>
                                        <td>
                                            <form action="{{ url('/shipping/sales-status-update/'.$sales->id_sales) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="btn-group-a">
                                                        @php
                                                        $statusClass = '';
                                                        switch ($sales->sales_status) {
                                                            case 'Pending Address':
                                                                $statusClass = 'btn-warning';
                                                                break;
                                                            case 'Pending Shipment':
                                                                $statusClass = 'btn-danger';
                                                                break;
                                                            case 'Waiting List':
                                                                $statusClass = 'btn-success';
                                                                break;
                                                            case 'Ready to Approved':
                                                                $statusClass = 'btn-info';
                                                                break;
                                                            case 'Collected':
                                                                $statusClass = 'btn-primary';
                                                                break;
                                                            case 'Completed':
                                                                $statusClass = 'btn-dark';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                                break;
                                                        }
                                                        @endphp
                                                        <button id="dropdown-toggle{{$sales->id_sales}}" type="button"
                                                            class="btn dropdown-toggle {{$statusClass}}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{$sales->sales_status}}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" value="Pending Address"
                                                                    onclick="selectStatus('1', {{$sales->id_sales}})">Pending Address</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Pending Shipment"
                                                                    onclick="selectStatus('2', {{$sales->id_sales}})">Pending Shipment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Waiting List"
                                                                    onclick="selectStatus('3', {{$sales->id_sales}})">Waiting List</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Ready to Approved"
                                                                    onclick="selectStatus('4', {{$sales->id_sales}})">Ready to Approved</button>
                                                            </li>
                                                            <li><button class="dropdown-item" type="button" value="Collected"
                                                                    onclick="selectStatus('5', {{$sales->id_sales}})">Collected</button></li>
                                                            <li><button class="dropdown-item" type="button" value="Completed"
                                                                    onclick="selectStatus('6', {{$sales->id_sales}})">Completed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="salesStatusInput_{{$sales->id_sales}}" name="sales_status"
                                                        value="{{$sales->sales_status}}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($sales->sales_status == 'Pending Address' || $sales->sales_status == 'Pending Shipment' ||
                                                $sales->sales_status == 'Waiting List')
                                                <span class="badge bg-primary rounded-3 fw-semibold">Draft</span>
                                                @else
                                                <span class="badge bg-success rounded-3 fw-semibold">Shipping</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No shipping data available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

      <!-- Payment Modal HTML -->
      @foreach ($salesData as $sales)
          <div id="paymentSalesModal{{ $sales->id_sales }}" class="modal fade">
              <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                      <form id="salesForm{{ $sales->id_sales }}" class="m-3"
                          action="{{ url('sales/payment/' . $sales->id_sales) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-header">
                              <h4 class="modal-title">Resi & Payment {{ $sales->customer_name }}</h4>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">	
                              <div class="row">			
                                <div class="col mb-3">
                                  <label class="form-label">Resi Number</label>
                                  <input name="resi_number" type="number" class="form-control" value="{{$sales->resi_number}}" aria-label="name">
                                </div>
                                <div class="col mb-3">
                                  <label for="formFile" class="form-label">Proof of Payment</label>
                                  <input name="payment_receipt" class="form-control" type="file" id="formFile{{ $sales->id_sales }}" onchange="previewImage(event, {{ $sales->id_sales }})">
                                  <input type="hidden" name="existing_payment_receipt" value="{{ $sales->payment_receipt }}">
                                  @if($sales->payment_receipt)
                                      <img id="imagePreview{{ $sales->id_sales }}" src="{{ asset('storage/' . $sales->payment_receipt) }}" alt="Payment Receipt" style="max-width: 200px;">
                                  @else
                                      <img id="imagePreview{{ $sales->id_sales }}" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                  @endif
                                </div>
                              </div>
                          </div>
                            <div class="modal-footer">
                              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                              <button name="submit" id="submitButton{{ $sales->id_sales }}" type="submit" class="btn btn-primary" value="Update">Update</button>
                            </div>
                      </form>
                  </div>
              </div>
          </div>
      @endforeach

      <!-- Edit Modal HTML -->
      {{-- @foreach ($salesData as $sales)
          <div id="editSalesModal{{ $sales->id_sales }}" class="modal fade">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                      <form id="salesForm{{ $sales->id_sales }}" class="m-3"
                          action="{{ url('sales/edit/' . $sales->id_sales) }}" method="POST"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="modal-header">
                              <h4 class="modal-title">Edit Sales {{ $sales->customer_name }}</h4>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <fieldset disabled>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Store<span
                                                  class="text-danger">*</span></label>
                                          <select id="storeSelect" name="id_store"
                                              class="form-select" required>
                                              <option value="" selected>- select -</option>
                                              @foreach ($store as $item)
                                                  <option value="{{ $item->id_store }}"
                                                      {{ $sales->id_store == $item->id_store ? 'selected' : '' }}>
                                                      {{ $item->store_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Transaction Date<span
                                                  class="text-danger">*</span></label>
                                          <input id="transactionDate" name="transaction_date"
                                              value="{{ $sales->transaction_date }}"
                                              type="date" class="form-control" required>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">SQ Numbering<span
                                                  class="text-danger">*</span></label>
                                          <input id="sqNumbering" name="sq_numbering"
                                              type="text" value="{{ $sales->sq_numbering }}"
                                              class="form-control" required>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Warehouse<span
                                                  class="text-danger">*</span></label>
                                          <select id="warehouseSelect" name="warehouse"
                                              class="form-select" required>
                                              <option value="WH 1"
                                                  {{ $sales->warehouse == 'WH 1' ? 'selected' : '' }}>
                                                  WH 1</option>
                                              <option value="WH 2"
                                                  {{ $sales->warehouse == 'WH 2' ? 'selected' : '' }}>
                                                  WH 2</option>
                                              <option value="WH 3"
                                                  {{ $sales->warehouse == 'WH 3' ? 'selected' : '' }}>
                                                  WH 3</option>
                                              <option value="WH 4"
                                                  {{ $sales->warehouse == 'WH 4' ? 'selected' : '' }}>
                                                  WH 4</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="form-label">Staff<span
                                                  class="text-danger">*</span></label>
                                          <input id="staffInput" name="staff_name" type="text"
                                              value="{{ $sales->staff_name }}" class="form-control"
                                              required>
                                      </div>
                                      <div class="col d-flex justify-content-end">
                                      </div>
                                  </div>
                              </fieldset>
                              <hr>
                              <div class="row mb-3">
                                  <div class="col">
                                      <label class="form-label">Socmed Type</label>
                                      <select name="socmed_type" class="form-select">
                                          <option value=""
                                              {{ $sales->socmed_type == '' ? 'selected' : '' }}>-
                                              select -</option>
                                          <option value="Line"
                                              {{ $sales->socmed_type == 'Line' ? 'selected' : '' }}>
                                              Line</option>
                                          <option value="Instagram"
                                              {{ $sales->socmed_type == 'Instagram' ? 'selected' : '' }}>
                                              Instagram</option>
                                          <option value="WhatsApp"
                                              {{ $sales->socmed_type == 'WhatsApp' ? 'selected' : '' }}>
                                              WhatsApp</option>
                                          <option value="Telegram"
                                              {{ $sales->socmed_type == 'Telegram' ? 'selected' : '' }}>
                                              Telegram</option>
                                      </select>
                                  </div>
                                  <div class="col">
                                      <label class="form-label">Socmed username</label>
                                      <input name="socmed_username" type="text"
                                          value="{{ $sales->socmed_username }}"
                                          class="form-control">
                                  </div>
                                  <div class="col">
                                      <label class="form-label">Delivery Method</label>
                                      <select name="delivery_company" class="form-select">
                                          <option value=""
                                              {{ $sales->delivery_company == '' ? 'selected' : '' }}>
                                              - select -</option>
                                          <option value="1"
                                              {{ $sales->delivery_company == 1 ? 'selected' : '' }}>
                                              HLIFE</option>
                                          <option value="2"
                                              {{ $sales->delivery_company == 2 ? 'selected' : '' }}>
                                              FAMILY MART</option>
                                          <option value="3"
                                              {{ $sales->delivery_company == 3 ? 'selected' : '' }}>
                                              HCT</option>
                                          <option value="4"
                                              {{ $sales->delivery_company == 4 ? 'selected' : '' }}>
                                              7-11</option>
                                          <option value="5"
                                              {{ $sales->delivery_company == 5 ? 'selected' : '' }}>
                                              POST</option>
                                          <option value="6"
                                              {{ $sales->delivery_company == 6 ? 'selected' : '' }}>
                                              SHOPEE SHOP</option>
                                      </select>
                                  </div>
                                  <div class="col">
                                      <label class="form-label">Phone Number</label>
                                      <input name="customer_phone_number" type="text"
                                          value="{{ $sales->customer_phone_number }}"
                                          class="form-control">
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <div class="col">
                                      <label class="form-label">Customer Name<span
                                              class="text-danger">*</span></label>
                                      <input name="customer_name" type="text"
                                          value="{{ $sales->customer_name }}" class="form-control"
                                          required>
                                  </div>
                                  <div class="col">
                                      <label class="form-label">Customer Address</label>
                                      <input name="customer_address" type="text"
                                          value="{{ $sales->customer_address }}"
                                          class="form-control">
                                  </div>
                                  <div class="col">
                                      <label for="formFile" class="form-label">Upload Address Picture</label>
                                      <input name="address_picture" class="form-control" type="file" id="formFile" onchange="previewImage(event)">
                                      <!-- Tambahkan input hidden untuk menyimpan path gambar alamat yang sudah ada -->
                                      <input type="hidden" name="existing_address_picture" value="{{ $sales->address_picture }}">
                                      <!-- Tampilkan gambar alamat jika sudah ada -->
                                      @if($sales->address_picture)
                                          <img src="{{ asset('storage/' . $sales->address_picture) }}" alt="Address Picture" style="max-width: 200px;">
                                      @endif
                                      <!-- Tampilkan preview gambar yang diunggah -->
                                      <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                  </div>
                              </div>
                              <hr>
                              <div class="row mb-3">
                                  <div class="col">
                                      <label class="form-label">Select Product</label>
                                      <select id="productSelect{{ $sales->id_sales }}"
                                          class="form-select">
                                          <option value="" selected>- select -</option>
                                          @foreach ($product as $item)
                                              <option value="{{ $item->id_product }}">
                                                  {{ $item->product_name }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col">
                                      <label class="form-label">Quantity</label>
                                      <input id="quantityInput{{ $sales->id_sales }}"
                                          type="number" class="form-control" min="1">
                                  </div>
                                  <div class="col d-flex justify-content-end">
                                      <button type="button"
                                          id="addProductButton{{ $sales->id_sales }}"
                                          class="btn btn-info m-4">Add</button>
                                  </div>
                              </div>
                              <table id="productTable{{ $sales->id_sales }}"
                                  class="table font-button mb-3">
                                  <thead>
                                      <tr>
                                          <th>Product SKU</th>
                                          <th>Product Name</th>
                                          <th>Sales Price</th>
                                          <th>Quantity</th>
                                          <th>Sub Total</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <!-- Product items will be added dynamically here -->
                                      @foreach ($sales->salesproduct as $salesproduct)
                                          <tr>
                                              <th>{{$salesproduct->product->product_barcode}}</th>
                                              <th>{{$salesproduct->product->product_name}}</th>
                                              <th>{{$salesproduct->salesproduct_price}}</th>
                                              <th>{{$salesproduct->quantity}}</th>
                                              <th>{{$salesproduct->salesproduct_price . $sales->quantity}}</th>
                                              <th>del</th>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                              <div
                                  class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                                  <div class="m-1">
                                      <label class="form-label">Send Date</label>
                                      <input name="send_date" type="date" class="form-control"
                                          value="{{ $sales->send_date }}">
                                  </div>
                                  <div class="me-5">
                                      <label class="form-label">Total Order</label>
                                      <div id="totalOrder{{ $sales->id_sales }}"
                                          class="d-flex align-items-center gap-2">
                                          <span class="badge bg-primary rounded-3 fw-semibold">$
                                              {{ $sales->total_order }}</span>
                                      </div>
                                  </div>
                              </div>
                              <div
                                  class="d-sm-flex d-block align-items-center justify-content-start mb-3">
                                  <div class="m-1">
                                      <label class="form-label">Notes</label>
                                      <textarea name="sales_note" class="form-control" placeholder="Leave a note here" style="height: 100px">{{ $sales->sales_note }}</textarea>
                                  </div>
                              </div>
                              <hr>
                              <div
                                  class="modal-footer d-sm-flex d-block align-items-center justify-content-end mb-1">
                                  <input type="button" class="btn btn-default m-1"
                                      data-dismiss="modal" value="Cancel">
                                  <input type="hidden" id="salesProductData{{ $sales->id_sales }}"
                                      name="salesproduct_data">
                                  <input type="hidden" name="qty_sales" value="0">
                                  <input type="hidden" name="payment_receipt" value="">
                                  <input type="hidden" name="resi_number" value="">
                                  <input id="submitButton{{ $sales->id_sales }}" type="button"
                                      class="btn btn-primary m-1" value="Update Sales">
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      @endforeach --}}

      <!-- Delete Modal HTML -->
      @foreach ($salesData as $sales)
          <div id="deleteSalesModal{{ $sales->id_sales }}" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <form class="m-3" action="{{ url('sales/delete/' . $sales->id_sales) }}"
                          method="POST" enctype="multipart/form-data">
                          @csrf
                          @method('DELETE')
                          <div class="modal-header">
                              <h4 class="modal-title">Delete Sales {{ $sales->customer_name }} </h4>
                              <button type="button" class="btn-close" data-dismiss="modal"
                                  aria-label="Close">
                              </button>
                          </div>
                          <div class="modal-body">
                              <p>Are you sure you want to delete {{ $sales->sq_numbering }} records?
                              </p>
                              <p class="text-warning"><small>This action cannot be undone.</small>
                              </p>
                          </div>
                          <div class="modal-footer">
                              <input type="button" class="btn btn-default" data-dismiss="modal"
                                  value="Cancel">
                              <input type="submit" class="btn btn-danger" value="Delete">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      @endforeach


    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>

  <!-- Tambahkan JavaScript Bootstrap dan jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}

  <script>
      function previewImage(event) {
          var input = event.target;
          var reader = new FileReader();

          reader.onload = function() {
              var dataURL = reader.result;
              var imagePreview = document.getElementById('imagePreview');
              imagePreview.src = dataURL;
              imagePreview.style.display = 'block';
          };

          if (input.files && input.files[0]) {
              reader.readAsDataURL(input.files[0]);
          }
      }
  </script>

  <script>
    $(document).ready(function() {
        var products = [];

        $('#addProductButton').click(function() {
            var productId = $('#productSelect').val();
            var productName = $('#productSelect option:selected').text();
            var quantity = $('#quantityInput').val();

            if (productId && quantity) {
                $.ajax({
                    url: '/sales/get-product-price/' + productId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        var productPrice = response.price;
                        var productBarcode = response.barcode;
                        var product = {
                            salesproduct_id: productId,
                            salesproduct_name: productName,
                            salesproduct_price: productPrice,
                            product_barcode: productBarcode,
                            quantity: parseInt(quantity)
                        };
                        products.push(product);
                        updateProductTable();
                        updateProductsInput();
                        updateTotalOrder();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching product price:', error);
                    }
                });
            }
        });

        function updateProductTable() {
            $('#productTable tbody').empty();

            for (var i = 0; i < products.length; i++) {
                var subtotal = products[i].salesproduct_price * products[i].quantity;

                var row = '<tr data-index="' + i + '">' +
                    '<td>' + products[i].product_barcode + '</td>' +
                    '<td>' + products[i].salesproduct_name + '</td>' +
                    '<td>' + products[i].salesproduct_price + '</td>' +
                    '<td>' + products[i].quantity + '</td>' +
                    '<td>' + subtotal.toFixed(2) + '</td>' +
                    '<td><button class="btn btn-danger remove-product"><i class="ti ti-trash nav-small-cap-icon fs-3"></i></button></td>' +
                    '</tr>';

                $('#productTable tbody').append(row);
            }

            // Attach event handler for remove buttons
            $('.remove-product').click(function() {
                var rowIndex = parseInt($(this).closest('tr').data('index'));
                products.splice(rowIndex, 1);
                updateProductTable();
                updateProductsInput();
                updateTotalOrder();
            });
        }

        function updateProductsInput() {
            var salesproductData = products.map(function(product) {
                return {
                    salesproduct_id: product.salesproduct_id,
                    salesproduct_name: product.salesproduct_name,
                    salesproduct_price: parseFloat(product.salesproduct_price),
                    quantity: product.quantity
                };
            });
            $('#salesProductData').val(JSON.stringify(salesproductData));

            var totalQuantity = products.reduce(function(sum, product) {
                return sum + product.quantity;
            }, 0);
            $('input[name="qty_sales"]').val(totalQuantity);
        }

        function calculateTotalOrder() {
            return products.reduce(function(total, product) {
                return total + (product.salesproduct_price * product.quantity);
            }, 0);
        }

        function updateTotalOrder() {
            var totalOrder = calculateTotalOrder();
            $('#totalOrder .badge').text('$' + totalOrder.toFixed(2));
        }

        $('#submitButton').click(function() {
            var storeSelect = $('#storeSelect').val();
            var transactionDate = $('#transactionDate').val();
            var sqNumbering = $('#sqNumbering').val();
            var warehouseSelect = $('#warehouseSelect').val();
            var staffInput = $('#staffInput').val();
            var customerName = $('input[name="customer_name"]').val();

            if (!(storeSelect && transactionDate && sqNumbering && warehouseSelect && staffInput &&
                    customerName)) {
                alert('Please fill out all required fields before applying.');
                return;
            }

            if (products.length === 0) {
                alert('Please add at least one product before submitting.');
                return;
            }

            $('#salesForm').submit();
        });
    });
  </script>

    <script>
    function selectStatus(status, id) {
        fetch(`/shipping/sales-status-update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                sales_status: status
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update sales status');
            }
            const dropdownToggle = document.querySelector(`#dropdown-toggle${id}`); // Menggunakan ID unik untuk elemen dropdown
            dropdownToggle.classList.remove(
                'btn-warning',
                'btn-danger', // Hapus kelas Bootstrap lainnya jika ada
                'btn-success', // Hapus kelas Bootstrap lainnya jika ada
                'btn-info', // Hapus kelas Bootstrap lainnya jika ada
                'btn-primary' // Hapus kelas Bootstrap lainnya jika ada
            );
            switch (status) {
                case '1':
                    dropdownToggle.textContent = 'Pending Address';
                    dropdownToggle.classList.add('btn-warning');
                    break;
                case '2':
                    dropdownToggle.textContent = 'Pending Shipment';
                    dropdownToggle.classList.add('btn-danger'); // Ganti dengan kelas warna yang sesuai
                    break;
                case '3':
                    dropdownToggle.textContent = 'Waiting List';
                    dropdownToggle.classList.add('btn-success'); // Ganti dengan kelas warna yang sesuai
                    break;
                case '4':
                    dropdownToggle.textContent = 'Ready to Approved';
                    dropdownToggle.classList.add('btn-info'); // Ganti dengan kelas warna yang sesuai
                    break;
                case '5':
                    dropdownToggle.textContent = 'Collected';
                    dropdownToggle.classList.add('btn-primary'); // Ganti dengan kelas warna yang sesuai
                    break;
                case '6':
                    dropdownToggle.textContent = 'Completed';
                    dropdownToggle.classList.add('btn-dark'); // Ganti dengan kelas warna yang sesuai
                    break;
                default:
                    break;
            }
            
            window.location.reload();
        })
        .catch(error => {
            console.error('Error updating sales status:', error);
        });
    }
    </script>


  <!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function(){
    $('#myTab a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
  });
</script>
<script>
  $(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    // Select/Deselect checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
      if(this.checked){
        checkbox.each(function(){
          this.checked = true;                        
        });
      } else{
        checkbox.each(function(){
          this.checked = false;                        
        });
      } 
    });
    checkbox.click(function(){
      if(!this.checked){
        $("#selectAll").prop("checked", false);
      }
    });
  });
  </script>
</body>

</html>