<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InventoryNest</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.css" />
  
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
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                  <h5 class="card-title fw-semibold">User Account</h5>
                </div>
                <div>
                  <a href="#addUserModal " class="btn btn-primary m-1" data-toggle="modal">
                    <i class="ti ti-plus nav-small-cap-icon fs-4"></i>
                    Add New
                  </a>
                </div>
                
                {{-- <div class="mb-3">
                  <label class="form-label">Role<span class="text-danger">*</span></label>
                  <select class="selectpicker" data-show-subtext="true" data-live-search="true">
                    <option>John Smith</option>
                    <option>Alex Johnson</option>
                    <option>Kevin Warren</option>
                    <option>Super Mario</option>
                    <option>Allen Martinez</option>
                    <option>Marvin Liberty</option>
                  </select>
                </div> --}}
              </div>

                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Group</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <th scope="row">{{ $user->id_user }}</th>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role }}</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-primary rounded-3 fw-semibold">Staff</span>
                        </div>
                      </td>
                      <td>
                        <a href="#editUserModal" class="edit" data-toggle="modal">
                          <i class="ti ti-pencil nav-small-cap-icon fs-6" data-toggle="tooltip" title="Edit"></i>
                        </a>
                        <a href="#deleteUserModal" class="delete" data-toggle="modal">
                          <i class="ti ti-trash nav-small-cap-icon fs-6" data-toggle="tooltip" title="Delete"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach  
                  </tbody>
                </table>
            </div>
          </div>
          
          <!-- Add Modal HTML -->
          <div id="addUserModal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form class="m-3" action="{{ url('user/create') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">						
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    </button>
                  </div>
                  <div class="modal-body">					
                    <div class="mb-3">
                      <label class="form-label">Name<span class="text-danger">*</span></label>
                      <input name="name" type="text" class="form-control" value="{{ old('name') }}" aria-label="name" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Email<span class="text-danger">*</span></label>
                      <input name="email" type="email" class="form-control" value="{{ old('email') }}" aria-label="email" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Role<span class="text-danger">*</span></label>
                      <select name="role" class="form-select" aria-label="role" required>
                        <option value="1">Super Admin</option>
                        <option value="2">Store Admin</option>
                        <option value="3">Customer Service</option>
                        <option value="4">Sales Order</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password<span class="text-danger">*</span></label>
                      <input name="password" type="password" class="form-control" aria-label="password" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button name="submit" type="submit" class="btn btn-primary" value="Add">Add</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Edit Modal HTML -->
          <div id="editUserModal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form class="m-3" action="{{ url('user/edit/' . $user->id_user ) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">						
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    </button>
                  </div>
                  <div class="modal-body">					
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input name="name" type="text" class="form-control" value="{{ $user->name }}" aria-label="name">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input name="email" type="email" class="form-control" value="{{ $user->email }}" aria-label="email">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Role</label>
                      <select name="role" class="form-select" aria-label="role">
                        <option value="1" {{ $user->role === '1' ? 'selected' : '' }}>Super Admin</option>
                        <option value="2" {{ $user->role === '2' ? 'selected' : '' }}>Store Admin</option>
                        <option value="3" {{ $user->role === '3' ? 'selected' : '' }}>Customer Service</option>
                        <option value="4" {{ $user->role === '4' ? 'selected' : '' }}>Sales Order</option>
                      </select>
                    </div>
                    {{-- <div class="mb-3">
                      <label class="form-label">Old Password<span class="text-danger">*</span></label>
                      <input name="old_password" type="password" class="form-control"
                                    aria-label="old_password" value="">
                    </div> --}}
                    <div class="mb-3">
                      <label class="form-label">New Password</label>
                      <input name="password" type="password" class="form-control" aria-label="password" value="">
                    </div>
                    {{-- <div class="mb-3">
                      <label for="exampleInputPassword2" class="form-label">Password Confirmation<span class="text-danger">*</span></label>
                      <input name="password_confirm" type="password" class="form-control" id="exampleInputPassword2" required>
                    </div>				 --}}
                  </div>
                  <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button name="submit" type="submit" class="btn btn-primary" value="Update">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Delete Modal HTML -->
          <div id="deleteUserModal" class="modal fade" >
            <div class="modal-dialog">
              <div class="modal-content">
                <form class="m-3" action="{{ url('user/delete/'.$user->id_user) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('DELETE')
                  <div class="modal-header">						
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.js"></script>

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
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
    <script>
      $(document).ready(function(){
        $('#myTab a').on('click', function (e) {
          e.preventDefault()
          $(this).tab('show')
        })
      });
    </script>
</body>

</html>