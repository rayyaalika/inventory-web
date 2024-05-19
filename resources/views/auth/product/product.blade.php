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
                    <h5 class="card-title fw-semibold mb-4">Inventory Product</h5>
                    <div class="d-sm-flex d-block align-items-center justify-content-end mb-1 font-button">
                        {{-- <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1"> Material Promo </a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Config Promo</a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Update bach Status</a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Sync to Googlesheet</a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Donwload Stock</a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Download</a>
                        </div>
                        <div class="mb-3 mb-sm-0">
                            <a href="#" class="btn btn-secondary m-1">Add Favorite</a>
                        </div> --}}
                        <div class="mb-3 mb-sm-0">
                            <a href="#addProductModal" class="btn btn-primary m-1" data-toggle="modal">
                                <i class="ti ti-plus nav-small-cap-icon fs-2"></i>
                                Add product
                              </a>
                        </div>
                    </div>
                    <table class="table table-hover font-button">
                      <thead>
                        <tr>
                          <th>
                            <span class="form-check">
                                <input class="form-check-input primary" type="checkbox" value="" id="selectAll">
                            </span>
                          </th>
                          <th scope="col">Code</th>
                          <th scope="col">Name</th>
                          <th scope="col">Category</th>
                          <th scope="col">Product Price</th>
                          <th scope="col">WH</th>
                          <th scope="col">IN</th>
                          <th scope="col">OUT</th>
                          <th scope="col">Real</th>
                          <th scope="col">Alert</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($stocks as $index => $item)
                        <tr>
                          <th>
                            <span class="form-check">
                                <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked">
                            </span>
                          </th>
                          <td>{{$item->product->product_barcode}}</td>
                          <td>{{$item->product->product_name}}</td>
                          @foreach ($categories as $category)
                            @if ($category->id_category == $item->product->id_category)
                              <td>{{$category->category_name}}</td> 
                            @endif
                          @endforeach
                          <td>{{$item->product->product_price}}</td>
                          <td>{{$item->wh_stock}}</td>
                          <td>{{$item->in_stock}}</td>
                          <td>{{$item->out_stock}}</td>
                          <td>{{$item->real_stock}}</td>
                          <td>{{$item->alert_stock}}</td>
                          <td>
                            <a href="#restockProductModal{{$item->id_product}}" class="restock" data-toggle="modal">
                                <i class="ti ti-archive nav-small-cap-icon fs-6" data-toggle="tooltip" title="Restock"></i>
                              </a>
                            <a href="#editProductModal{{$item->id_product}}" class="edit" data-toggle="modal">
                              <i class="ti ti-pencil nav-small-cap-icon fs-6" data-toggle="tooltip" title="Edit"></i>
                            </a>
                            <a href="#deleteProductModal{{$item->id_product}}" class="delete" data-toggle="modal">
                              <i class="ti ti-trash nav-small-cap-icon fs-6" data-toggle="tooltip" title="Delete"></i>
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>


                <!-- Restock Modal HTML -->
                @foreach ($stocks as $stock)
                  <div id="restockProductModal{{$stock->id_product}}" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <form class="m-3" action="{{ url('/product/restock/'. $stock->id_stock ) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-header">						
                            <h4 class="modal-title">Edit Stock {{$stock->product->product_name}} </h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            </button>
                          </div>
                          <div class="modal-body">	
                            <div class="row">			
                              <div class="col mb-3">
                                <label class="form-label">Stock WH</label>
                                <input name="wh_stock" type="number" class="form-control" value="{{$stock->wh_stock}}" aria-label="name">
                              </div>
                              <div class="col mb-3">
                                <label class="form-label">Alert Stock</label>
                                <input name="alert_stock" type="number" class="form-control" value="{{$stock->alert_stock}}" aria-label="name">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <button name="submit" type="submit" class="btn btn-primary" value="Update">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach

               <!-- Add Modal HTML -->
              <div id="addProductModal" class="modal fade">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                    <form class="m-3" action="{{ url('product/create') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                          <h4 class="modal-title">Add New Product</h4>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Supplier<span class="text-danger">*</span></label>
                                  <select name="id_supplier" id="id_supplier" class="form-select" required>
                                      <option value="" selected>- select -</option>
                                      @foreach ($supplier as $index => $item)
                                      <option value="{{ $item->id_supplier }}">{{ $item->supplier_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Category<span class="text-danger">*</span></label>
                                  <select name="id_category" id="id_category" class="form-select" required>
                                      <option value="" selected>- select -</option>
                                      @foreach ($categories as $index => $item)
                                      <option value="{{ $item->id_category }}">{{ $item->category_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Product Type</label>
                                  <select name="product_type" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="1">Food and Beverage</option>
                                      <option value="2">Fashion</option>
                                      <option value="3">Make Up</option>
                                      <option value="4">Groceries</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Sub Category<span class="text-danger">*</span></label>
                                  <select name="id_sub_category" id="id_sub_category" class="form-select" required>
                                      <option value="" selected>- select -</option>
                                      @foreach ($subCategory as $index => $item)
                                      <option value="{{ $item->id_sub_category }}">{{ $item->sub_category_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Brand</label>
                                  {{-- <select name="product_brand" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="KOBE">KOBE</option>
                                      <option value="UNIQLO">UNIQLO</option>
                                  </select> --}}
                                  <input name="product_brand" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label class="form-label">Color</label>
                                  {{-- <select name="product_color" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="RED">RED</option>
                                      <option value="YELLOW">YELLOW</option>
                                      <option value="GREEN">GREEN</option>
                                      <option value="BLACK">BLACK</option>
                                  </select> --}}
                                  <input name="product_color" type="text" class="form-control">
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Product Name<span class="text-danger">*</span></label>
                                  <input name="product_name" type="text" class="form-control" required>
                              </div>
                              <div class="col">
                                  <label class="form-label">Chinese Name (CH)</label>
                                  <input name="product_chinese_name" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label for="formFile" class="form-label">English Name (EN)</label>
                                  <input name="product_english_name" type="text" class="form-control">
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Product Code</label>
                                  <input name="product_code" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label class="form-label">Product Slug</label>
                                  <input name="product_slug" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label for="formFile" class="form-label">Barcode<span class="text-danger">*</span></label>
                                  <input name="product_barcode" type="text" class="form-control" required>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Product Cost<span class="text-danger">*</span></label>
                                  <input name="product_cost" type="text" class="form-control" required>
                              </div>
                              <div class="col">
                                  <label class="form-label">Product Price<span class="text-danger">*</span></label>
                                  <input name="product_price" type="text" class="form-control" required>
                              </div>
                              <div class="col">
                                  <label for="formFile" class="form-label">Alert Quantity</label>
                                  <input name="alert_quantity" type="text" class="form-control">
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Weight (kg)</label>
                                  <input name="product_weight" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label class="form-label">Length (cm)</label>
                                  <input name="product_length" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label for="formFile" class="form-label">Height (cm)</label>
                                  <input name="product_height" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label for="formFile" class="form-label">Width (cm)</label>
                                  <input name="product_width" type="text" class="form-control">
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Group Unit<span class="text-danger">*</span></label>
                                  <select name="group_unit" class="form-select" required>
                                      <option value="Pieces">Pieces</option>
                                      <option value="Box Pieces">Box Pieces</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Default Inventory Unit<span class="text-danger">*</span></label>
                                  <select name="default_inventory_unit" class="form-select" required>
                                      <option value="Pieces">Pieces</option>
                                      <option value="Box Pieces">Box Pieces</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Default Sales Unit<span class="text-danger">*</span></label>
                                  <select name="default_sale_unit" class="form-select" required>
                                      <option value="Pieces">Pieces</option>
                                      <option value="Box Pieces">Box Pieces</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Default Purchase Unit<span class="text-danger">*</span></label>
                                  <select name="default_purchase_unit" class="form-select" required>
                                      <option value="Pieces">Pieces</option>
                                      <option value="Box Pieces">Box Pieces</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Product Tax</label>
                                  <select name="product_tax" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="VAT">VAT</option>
                                      <option value="CT">CT</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Tax Method</label>
                                  <select name="tax_method" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="D">D</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Pre-order Type</label>
                                  <select name="pre_order_type" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="D">D</option>
                                  </select>
                              </div>
                              <div class="col">
                                  <label class="form-label">Branch Owner</label>
                                  <select name="branch_owner" class="form-select">
                                      <option value="" selected>- select -</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="D">D</option>
                                  </select>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label class="form-label">Link Product</label>
                                  <input name="link_product" type="text" class="form-control">
                              </div>
                              <div class="col">
                                  <label class="form-label">Link Video</label>
                                  <input name="link_video" type="text" class="form-control">
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col">
                                  <label for="formFile" class="form-label">Product Image</label>
                                  <input name="tumbnail_image" class="form-control" type="file" id="formFile">
                              </div>
                              <div class="col">
                                  <div class="mb-3">
                                      <label class="form-label">Product Details</label>
                                      <textarea name="product_details" class="form-control" placeholder="Leave a notes here"
                                          style="height: 100px"></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                              <input type="submit" class="btn btn-primary" value="Save">
                          </div>
                      </div>
                  </form>
                  
                  </div>
                </div>
              </div>

              <!-- Edit Modal HTML -->
              @foreach ($products as $stock)
              <div id="editProductModal{{$stock->id_product}}" class="modal fade">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <form class="m-3" action="{{ url('/product/edit/'. $stock->id_product) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              {{-- @method('PUT') --}}
                              <div class="modal-header">
                                  <h4 class="modal-title">Edit Product {{$stock->product_name}}</h4>
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Supplier<span class="text-danger">*</span></label>
                                          <select name="id_supplier" id="id_supplier" class="form-select" required>
                                              <option value="" selected>- select -</option>
                                              @foreach ($supplier as $item)
                                              <option value="{{ $item->id_supplier }}" {{ $stock->id_supplier == $item->id_supplier ? 'selected' : '' }}>{{ $item->supplier_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Category<span class="text-danger">*</span></label>
                                          <select name="id_category" id="id_category" class="form-select" required>
                                              <option value="" selected>- select -</option>
                                              @foreach ($categories as $item)
                                              <option value="{{ $item->id_category }}" {{ $stock->id_category == $item->id_category ? 'selected' : '' }}>{{ $item->category_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Product Type</label>
                                          <select name="product_type" class="form-select">
                                              <option value="" selected>- select -</option>
                                              <option value="1" {{ $stock->product_type == 1 ? 'selected' : '' }}>Food and Beverage</option>
                                              <option value="2" {{ $stock->product_type == 2 ? 'selected' : '' }}>Fashion</option>
                                              <option value="3" {{ $stock->product_type == 3 ? 'selected' : '' }}>Make Up</option>
                                              <option value="4" {{ $stock->product_type == 4 ? 'selected' : '' }}>Groceries</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Sub Category<span class="text-danger">*</span></label>
                                          <select name="id_sub_category" id="id_sub_category" class="form-select" required>
                                              <option value="" selected>- select -</option>
                                              @foreach ($subCategory as $item)
                                              <option value="{{ $item->id_sub_category }}" {{ $stock->id_sub_category == $item->id_sub_category ? 'selected' : '' }}>{{ $item->sub_category_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Brand</label>
                                          <input name="product_brand" type="text" class="form-control" value="{{ $stock->product_brand }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Color</label>
                                          <input name="product_color" type="text" class="form-control" value="{{ $stock->product_color }}">
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Product Name<span class="text-danger">*</span></label>
                                          <input name="product_name" type="text" class="form-control" value="{{ $stock->product_name }}" required>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Chinese Name (CH)</label>
                                          <input name="product_chinese_name" type="text" class="form-control" value="{{ $stock->product_chinese_name }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">English Name (EN)</label>
                                          <input name="product_english_name" type="text" class="form-control" value="{{ $stock->product_english_name }}">
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Product Code</label>
                                          <input name="product_code" type="text" class="form-control" value="{{ $stock->product_code }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Product Slug</label>
                                          <input name="product_slug" type="text" class="form-control" value="{{ $stock->product_slug }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Barcode<span class="text-danger">*</span></label>
                                          <input name="product_barcode" type="text" class="form-control" value="{{ $stock->product_barcode }}" required>
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Product Cost<span class="text-danger">*</span></label>
                                          <input name="product_cost" type="text" class="form-control" value="{{ $stock->product_cost }}" required>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Product Price<span class="text-danger">*</span></label>
                                          <input name="product_price" type="text" class="form-control" value="{{ $stock->product_price }}" required>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Alert Quantity</label>
                                          <input name="alert_quantity" type="text" class="form-control" value="{{ $stock->alert_quantity }}">
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Weight (kg)</label>
                                          <input name="product_weight" type="text" class="form-control" value="{{ $stock->product_weight }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Length (cm)</label>
                                          <input name="product_length" type="text" class="form-control" value="{{ $stock->product_length }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Height (cm)</label>
                                          <input name="product_height" type="text" class="form-control" value="{{ $stock->product_height }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Width (cm)</label>
                                          <input name="product_width" type="text" class="form-control" value="{{ $stock->product_width }}">
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Group Unit<span class="text-danger">*</span></label>
                                          <select name="group_unit" class="form-select" required>
                                              <option value="Pieces" {{ $stock->group_unit == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                              <option value="Box Pieces" {{ $stock->group_unit == 'Box Pieces' ? 'selected' : '' }}>Box Pieces</option>
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Default Inventory Unit<span class="text-danger">*</span></label>
                                          <select name="default_inventory_unit" class="form-select" required>
                                              <option value="Pieces" {{ $stock->default_inventory_unit == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                              <option value="Box Pieces" {{ $stock->default_inventory_unit == 'Box Pieces' ? 'selected' : '' }}>Box Pieces</option>
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Default Sales Unit<span class="text-danger">*</span></label>
                                          <select name="default_sale_unit" class="form-select" required>
                                              <option value="Pieces" {{ $stock->default_sale_unit == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                              <option value="Box Pieces" {{ $stock->default_sale_unit == 'Box Pieces' ? 'selected' : '' }}>Box Pieces</option>
                                          </select>
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Default Purchase Unit<span class="text-danger">*</span></label>
                                          <select name="default_purchase_unit" class="form-select" required>
                                              <option value="Pieces" {{ $stock->default_purchase_unit == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                              <option value="Box Pieces" {{ $stock->default_purchase_unit == 'Box Pieces' ? 'selected' : '' }}>Box Pieces</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Product Tax</label>
                                          <select name="product_tax" class="form-select">
                                              <option value="" selected>- select -</option>
                                              <option value="VAT" {{ $stock->product_tax == 'VAT' ? 'selected' : '' }}>VAT</option>
                                              <option value="CT" {{ $stock->product_tax == 'CT' ? 'selected' : '' }}>CT</option>
                                          </select>
                                      </div>
                                      <div class="col">
                                        <label class="form-label">Tax Method</label>
                                        <select name="tax_method" class="form-select">
                                            <option value="" {{ $stock->tax_method == '' ? 'selected' : '' }}>- select -</option>
                                            <option value="A" {{ $stock->tax_method == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ $stock->tax_method == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ $stock->tax_method == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $stock->tax_method == 'D' ? 'selected' : '' }}>D</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Pre-order Type</label>
                                        <select name="pre_order_type" class="form-select">
                                            <option value="" {{ $stock->pre_order_type == '' ? 'selected' : '' }}>- select -</option>
                                            <option value="A" {{ $stock->pre_order_type == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ $stock->pre_order_type == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ $stock->pre_order_type == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $stock->pre_order_type == 'D' ? 'selected' : '' }}>D</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Branch Owner</label>
                                        <select name="branch_owner" class="form-select">
                                            <option value="" {{ $stock->branch_owner == '' ? 'selected' : '' }}>- select -</option>
                                            <option value="A" {{ $stock->branch_owner == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ $stock->branch_owner == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ $stock->branch_owner == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $stock->branch_owner == 'D' ? 'selected' : '' }}>D</option>
                                        </select>
                                    </div> 
                                  </div>                                   
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Link Product</label>
                                          <input name="link_product" type="text" class="form-control" value="{{ $stock->link_product }}">
                                      </div>
                                      <div class="col">
                                          <label class="form-label">Link Video</label>
                                          <input name="link_video" type="text" class="form-control" value="{{ $stock->link_video }}">
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                      <div class="col">
                                          <label class="form-label">Product Image</label>
                                          <input name="tumbnail_image" class="form-control" type="file" id="formFile" value="{{ $stock->tumbnail_image }}">
                                      </div>
                                      <div class="col">
                                          <div class="mb-3">
                                              <label class="form-label">Product Details</label>
                                              <textarea name="product_details" class="form-control" placeholder="Leave a notes here" style="height: 100px">{{ $stock->product_details }}</textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                      <input type="submit" class="btn btn-primary" value="Save">
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              @endforeach


              <!-- Delete Modal HTML -->
              @foreach ($stocks as $stock)    
                <div id="deleteProductModal{{$stock->id_product}}" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form class="m-3" action="{{ url('product/delete/'.$stock->id_product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">						
                          <h4 class="modal-title">Delete Product {{$stock->product->product_name}} </h4>
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
              @endforeach


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