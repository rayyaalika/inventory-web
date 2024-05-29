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
                <li class="sidebar-item">
                  <a class="sidebar-link" href="{{ url('/superadmin') }}" aria-expanded="false">
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
                <li class="sidebar-item">
                  <a class="sidebar-link" href="{{ url('/user') }}" aria-expanded="false">
                    <span>
                      <i class="ti ti-user"></i>
                    </span>
                    <span class="hide-menu">User</span>
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
                    <span class="hide-menu">sales</span>
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
                          <table class="table font-button mt-5">
                            <thead>
                              <tr>
                                <th>Action</th>
                                {{-- <th>
                                    <span class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="selectAll">
                                    </span>
                                </th> --}}
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
                              @foreach ($sales as $sales)
                              <tr>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="ti ti-list nav-small-cap-icon fs-3" data-toggle="tooltip" title="Actions"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#editSalesModal{{$sales->id_sales}}">Edit Sales</a></li>
                                      <li><a class="dropdown-item" href="#addPaymentModal{{$sales->id_sales}}">Add Payment</a></li>
                                      <li><a class="dropdown-item text-danger" href="#deleteSalesModal{{$sales->id_sales}}">Delete Sales</a></li>
                                    </ul>
                                  </div>
                                    {{-- <a href="#" class="edit" >
                                        <i class="ti ti-pencil nav-small-cap-icon fs-3" data-toggle="tooltip" title="Edit"></i>
                                      </a>
                                      <a href="#" class="delete" data-bs-toggle="modal">
                                        <i class="ti ti-trash nav-small-cap-icon fs-3" data-toggle="tooltip" title="Delete"></i>
                                    </a> --}}
                                </td>
                                {{-- <td>
                                    <span class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked">
                                    </span>
                                </td> --}}
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
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>456 Avenue, Town</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Mike Johnson</td>
                                <td>mike@example.com</td>
                                <td>789 Road, Village</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Nama</th>
                                  <th>Email</th>
                                  <th>Alamat</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Mike Johnson</td>
                                  <td>mike@example.com</td>
                                  <td>789 Road, Village</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                    </div>
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

  {{-- <script>
    document.getElementById('applyButton').addEventListener('click', function() {
      var storeSelect = document.getElementById('storeSelect').value;
      var transactionDate = document.getElementById('transactionDate').value;
      var sqNumbering = document.getElementById('sqNumbering').value;
      var warehouseSelect = document.getElementById('warehouseSelect').value;
      var staffInput = document.getElementById('staffInput').value;
      
      if (storeSelect && transactionDate && sqNumbering && warehouseSelect && staffInput) {
        document.getElementById('salesFieldset').disabled = false;
      } else {
        alert('Please fill out all required fields before applying.');
      }
    });
  </script> --}}


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