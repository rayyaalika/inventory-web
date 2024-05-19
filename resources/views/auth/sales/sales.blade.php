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
    .btn-purple{
      color: white;
      background-color: #6f42c1;
    }
    .btn-purple:hover {
        color: white;
        background-color: #573598;
        border-color:#573598; 
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
                    <h5 class="card-title fw-semibold mb-4">Sales Quotation</h5>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Unfinished</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Confirmed</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Offline</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Mobile</a>
                          </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            <div class="d-sm-flex d-block align-items-center justify-content-end mb-1 mt-10 font-button">
                                <div class="mb-3 mb-sm-0">
                                    <a href="#addSalesModal" class="btn btn-primary m-3" data-toggle="modal">
                                        <i class="ti ti-plus nav-small-cap-icon fs-3"></i>
                                        Add New
                                      </a>
                                </div>
                            </div>
                          <table class="table font-button">
                            <thead>
                              <tr>
                                <th>Action</th>
                                <th>
                                    <span class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="selectAll">
                                    </span>
                                </th>
                                <th>Date</th>
                                <th>SQ Numbering</th>
                                <th>Socmed Type</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Company Delivery</th>
                                <th>Total</th>
                                <th>Notes</th>
                                <th>No Resi</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                    <a href="#editSalesModal" class="edit" data-toggle="modal">
                                        <i class="ti ti-pencil nav-small-cap-icon fs-3" data-toggle="tooltip" title="Edit"></i>
                                      </a>
                                      <a href="#deleteSalesModal" class="delete" data-toggle="modal">
                                        <i class="ti ti-trash nav-small-cap-icon fs-3" data-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked">
                                    </span>
                                </td>
                                <td>May 3, 2024</td>
                                <td>AB2435647</td>
                                <td>Shopee</td>
                                <td>Jeno Lee</td>
                                <td>6282337655902</td>
                                <td>Hanam-dong, UN Vilage</td>
                                <td>POST</td>
                                <td>136</td>
                                <td>None</td>
                                <td>ABD123456</td>
                                <td>
                                  <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary rounded-3 fw-semibold">Pre-order</span>
                                  </div>
                                </td>
                              </tr>
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

                <!-- Add Modal HTML -->
                <div id="addSalesModal" class="modal fade">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <form class="m-3">
                        <div class="modal-header">						
                          <h4 class="modal-title">Add New Sales Quotation</h4>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                          </button>
                        </div>
                        <div class="modal-body">		
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Store</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Transaction Date</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">SQ Numbering</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Warehouse</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <label class="form-label">Staff</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col d-flex justify-content-end">
                              <button type="button" class="btn btn-success m-4">Apply</button>
                            </div>
                          </div>
                          <hr>	
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Socmed Type</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Socmed username</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Delivery Method</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Phone Number</label>
                              <input type="text" class="form-control" required>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Customer Name</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Customer Address</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label for="formFile" class="form-label">Upload file</label>
                              <input class="form-control" type="file" id="formFile">
                            </div>
                          </div>
                          <hr>
                          <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Select Product</label>
                                <select class="form-select" required>
                                  <option value="1">Super Admin</option>
                                  <option value="2">Store Admin</option>
                                  <option value="3">Customer Service</option>
                                  <option value="4">Sales Order</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-info m-4">Add</button>
                            </div>
                          </div>
                          <table class="table font-button mb-3">
                            <thead>
                              <tr>
                                <th>Product SKU</th>
                                <th>Product Name</th>
                                <th>Sales Price</th>
                                <th>Quantity</th>
                                <th>Change Price</th>
                                <th>Qty Resi</th>
                                <th>Sub Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>May 3, 2024</td>
                                <td>AB2435647</td>
                                <td>Shopee</td>
                                <td>Jeno Lee</td>
                                <td>None</td>
                                <td>136</td>
                                <td>136</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                            <div class="m-1">
                              <label class="form-label">Send Date</label>
                              <input type="date" class="form-control" required>
                            </div>
                            <div class="m-1">
                              <label class="form-label">Total Order</label>
                              <input type="text" class="form-control" required>
                            </div>
                          </div>
                          <div class="d-sm-flex d-block align-items-center justify-content-start mb-3">
                            <div class="m-1">
                              <label class="form-label">Notes</label>
                              <textarea class="form-control" placeholder="Leave a notes here" style="height: 100px"></textarea>
                            </div>
                          </div>
                          <hr>
                        <div class="modal-footer d-sm-flex d-block align-items-center justify-content-between mb-1">
                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                          <input type="submit" class="btn btn-purple" value="Copy to Clipboard">
                          <input type="submit" class="btn btn-success" value="Confirm SO">
                          <input type="submit" class="btn btn-primary" value="Add Sales Quotation">
                        </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Edit Modal HTML -->
                <div id="editSalesModal" class="modal fade">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <form class="m-3">
                        <div class="modal-header">						
                          <h4 class="modal-title">Edit Sales Quotation</h4>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                          </button>
                        </div>
                        <div class="modal-body">		
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Store</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Transaction Date</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">SQ Numbering</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Warehouse</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <label class="form-label">Staff</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col d-flex justify-content-end">
                              <button type="button" class="btn btn-success m-4">Update</button>
                            </div>
                          </div>
                          <hr>	
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Socmed Type</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Socmed username</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Delivery Method</label>
                              <select class="form-select" required>
                                <option value="1">Super Admin</option>
                                <option value="2">Store Admin</option>
                                <option value="3">Customer Service</option>
                                <option value="4">Sales Order</option>
                              </select>
                            </div>
                            <div class="col">
                              <label class="form-label">Phone Number</label>
                              <input type="text" class="form-control" required>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col">
                              <label class="form-label">Customer Name</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label class="form-label">Customer Address</label>
                              <input type="text" class="form-control" required>
                            </div>
                            <div class="col">
                              <label for="formFile" class="form-label">Upload file</label>
                              <input class="form-control" type="file" id="formFile">
                            </div>
                          </div>
                          <hr>
                          <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Select Product</label>
                                <select class="form-select" required>
                                  <option value="1">Super Admin</option>
                                  <option value="2">Store Admin</option>
                                  <option value="3">Customer Service</option>
                                  <option value="4">Sales Order</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-success m-4">Update</button>
                            </div>
                          </div>
                          <table class="table font-button mb-3">
                            <thead>
                              <tr>
                                <th>Product SKU</th>
                                <th>Product Name</th>
                                <th>Sales Price</th>
                                <th>Quantity</th>
                                <th>Change Price</th>
                                <th>Qty Resi</th>
                                <th>Sub Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>May 3, 2024</td>
                                <td>AB2435647</td>
                                <td>Shopee</td>
                                <td>Jeno Lee</td>
                                <td>None</td>
                                <td>136</td>
                                <td>136</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                            <div class="m-1">
                              <label class="form-label">Send Date</label>
                              <input type="date" class="form-control" required>
                            </div>
                            <div class="m-1">
                              <label class="form-label">Total Order</label>
                              <input type="text" class="form-control" required>
                            </div>
                          </div>
                          <div class="d-sm-flex d-block align-items-center justify-content-start mb-3">
                            <div class="m-1">
                              <label class="form-label">Notes</label>
                              <textarea class="form-control" placeholder="Leave a notes here" style="height: 100px"></textarea>
                            </div>
                          </div>
                          <hr>
                        <div class="modal-footer d-sm-flex d-block align-items-center justify-content-between mb-1">
                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                          <input type="submit" class="btn btn-purple" value="Copy to Clipboard">
                          <input type="submit" class="btn btn-success" value="Confirm SO">
                          <input type="submit" class="btn btn-primary" value="Update Sales">
                        </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Delete Modal HTML -->
                <div id="deleteSalesModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form class="m-3">
                        <div class="modal-header">						
                          <h4 class="modal-title">Delete Sales Quotation</h4>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                          </button>
                        </div>
                        <div class="modal-body">					
                          <p>Are you sure you want to delete these Records?</p>
                          <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                          <input type="submit" class="btn btn-danger" value="Delete">
                        </div>
                      </form>
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
  
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- <script>
      $(document).ready(function(){
        $('#myTab a').on('click', function (e) {
          e.preventDefault()
          $(this).tab('show')
        })
      });
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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