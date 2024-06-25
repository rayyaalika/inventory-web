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

        .btn-purple {
            color: white;
            background-color: #6f42c1;
        }

        .btn-purple:hover {
            color: white;
            background-color: #573598;
            border-color: #573598;
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
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4">Edit Sales {{ $sales->sq_numbering }}</h5>
                            <hr>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-content" id="myTabContent">
                                    <form id="salesForm{{ $sales->id_sales }}" class="m-3"
                                        action="{{ url('sales/edit/' . $sales->id_sales) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <fieldset disabled>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label">Store<span
                                                            class="text-danger">*</span></label>
                                                    <select id="storeSelect" name="id_store" class="form-select"
                                                        required>
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
                                                        value="{{ $sales->transaction_date }}" type="date"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">SQ Numbering<span
                                                            class="text-danger">*</span></label>
                                                    <input id="sqNumbering" name="sq_numbering" type="text"
                                                        value="{{ $sales->sq_numbering }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Warehouse<span
                                                            class="text-danger">*</span></label>
                                                    <select id="warehouseSelect" name="warehouse" class="form-select"
                                                        required>
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
                                                    value="{{ $sales->socmed_username }}" class="form-control">
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
                                                    value="{{ $sales->customer_phone_number }}" class="form-control">
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
                                                    value="{{ $sales->customer_address }}" class="form-control">
                                            </div>
                                            <div class="col">
                                                <label for="formFile" class="form-label">Upload Address Picture</label>
                                                <input name="address_picture" class="form-control" type="file" id="formFile" onchange="previewImage(event)">
                                                <!-- Tambahkan input hidden untuk menyimpan path gambar alamat yang sudah ada -->
                                                <input type="hidden" name="existing_address_picture" value="{{ $sales->address_picture }}">
                                                <!-- Tampilkan gambar alamat jika sudah ada -->
                                                @if($sales->address_picture)
                                                    <img id="currentAddressPicture" src="{{ asset('storage/' . $sales->address_picture) }}" alt="Current Address Picture" style="max-width: 200px; margin-top: 10px;">
                                                @endif
                                                <!-- Tampilkan preview gambar yang diunggah -->
                                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Select Product</label>
                                                <select id="productSelect" class="form-select">
                                                    <option value="" selected>- select -</option>
                                                    @foreach ($product as $item)
                                                        <option value="{{ $item->id_product }}">
                                                            {{ $item->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Quantity</label>
                                                <input id="quantityInput" type="number" class="form-control"
                                                    min="1">
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <button type="button" id="addProductButton"
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
                                            <tbody id="salesProductsBody">
                                                <!-- Product items will be added dynamically here -->
                                            </tbody>
                                        </table>
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                                            <div class="m-1">
                                                <label class="form-label">Send Date</label>
                                                <input name="send_date" type="date" class="form-control"
                                                    value="{{ $sales->send_date }}">
                                            </div>
                                            <div class="me-5">
                                                <label class="form-label">Total Order</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span id="totalOrder"
                                                        class="badge bg-primary rounded-3 fw-semibold">$
                                                        {{ $sales->total_order }}</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-sm-flex d-block align-items-center justify-content-start mb-3">
                                            <div class="m-1">
                                                <label class="form-label">Notes</label>
                                                <textarea name="sales_note" class="form-control" placeholder="Leave a note here" style="height: 100px">{{ $sales->sales_note }}</textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <input type="hidden" id="salesProductData" name="salesproduct_data">
                                        <input type="hidden" name="qty_sales" value="{{ $sales->total_order }}">
                                        <input type="hidden" name="payment_receipt" value="">
                                        <input type="hidden" name="resi_number" value="">
                                        <div class="d-sm-flex d-block align-items-center justify-content-end mb-1">
                                            <a href="{{ url('/sales') }}" class="btn btn-default m-1">Back</a>
                                            <input id="submitButton" type="submit" class="btn btn-primary m-1"
                                                value="Update Sales">
                                        </div>
                                    </form>
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
       <script>
            $(document).ready(function() {
            // Event listener untuk mengunggah gambar alamat
            $('#address_picture').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#currentAddressPicture').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
       </script>
       <script>
            function previewImage(event) {
                var input = event.target;
                var reader = new FileReader();
                reader.onload = function(){
                    var preview = document.getElementById('imagePreview');
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        </script>

        <script>
            function previewImage(event, id) {
                var reader = new FileReader();
                reader.onload = function(){
                    var output = document.getElementById('imagePreview' + id);
                    output.src = reader.result;
                    output.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
        
        {{-- Get Data Edit --}}
        <script>
            $(document).ready(function() {
                var salesId = "{{ $sales->id_sales }}"; // Jika $sales sudah didefinisikan sebelumnya
                var salesProductData = []; // Array untuk menyimpan data produk penjualan

                // Fungsi untuk memperbarui total order
                function updateTotalOrder() {
                    var totalOrder = 0;
                    $('#salesProductsBody tr').each(function() {
                        totalOrder += parseFloat($(this).find('td:eq(4)').text());
                    });
                    $('#totalOrder').text('$' + totalOrder);
                    $('input[name="qty_sales"]').val(totalOrder);
                }

                // Mendapatkan data produk penjualan dari server
                $.ajax({
                    url: '/sales/get-sales-products/' + salesId,
                    type: 'GET',
                    success: function(response) {
                        var salesProducts = response.salesproduct;

                        $.each(salesProducts, function(index, salesProduct) {
                            var productData = {
                                'id_product': salesProduct.product.id_product,
                                'product_sku': salesProduct.product.product_barcode,
                                'product_name': salesProduct.product.product_name,
                                'salesproduct_price': salesProduct.salesproduct_price,
                                'quantity': salesProduct.quantity,
                                'sub_total': salesProduct.salesproduct_price * salesProduct
                                    .quantity
                            };

                            salesProductData.push(productData);

                            var salesProductsHtml = '<tr>';
                            salesProductsHtml += '<td>' + productData.product_sku + '</td>';
                            salesProductsHtml += '<td>' + productData.product_name + '</td>';
                            salesProductsHtml += '<td>' + productData.salesproduct_price + '</td>';
                            salesProductsHtml +=
                                '<td><input type="number" class="form-control quantity-input" value="' +
                                productData.quantity + '"></td>';
                            salesProductsHtml += '<td>' + productData.sub_total + '</td>';
                            salesProductsHtml +=
                                '<td><a href="#" class="btn btn-danger delete-btn"><i class="ti ti-trash nav-small-cap-icon fs-3"></i></a></td>';
                            salesProductsHtml += '</tr>';

                            $('#salesProductsBody').append(salesProductsHtml);
                        });

                        updateTotalOrder();

                        // Set nilai input tersembunyi dengan data produk penjualan
                        $('#salesProductData').val(JSON.stringify(salesProductData));
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

                // Add event listener for quantity input change
                $(document).on('change', '.quantity-input', function() {
                    var row = $(this).closest('tr');
                    var index = row.index();
                    var newQuantity = parseInt($(this).val());
                    var productData = salesProductData[index];

                    // Update salesProductData with new quantity
                    productData.quantity = newQuantity;
                    salesProductData[index] = productData;

                    // Update sub total
                    var subTotal = productData.salesproduct_price * newQuantity;
                    row.find('td:eq(4)').text(subTotal);

                    updateTotalOrder();

                    // Update hidden input value
                    $('#salesProductData').val(JSON.stringify(salesProductData));
                });

                // Mengatur event handler untuk tombol delete
                $(document).on('click', '.delete-btn', function() {
                    var index = $(this).closest('tr').index();
                    salesProductData.splice(index, 1); // Hapus elemen dari array
                    $(this).closest('tr').remove(); // Hapus baris dari tabel
                    updateTotalOrder();
                    $('#salesProductData').val(JSON.stringify(
                    salesProductData)); // Perbarui nilai input tersembunyi
                });

                // Event listener untuk mengunggah gambar alamat
                $('#address_picture').change(function() {
                    var formData = new FormData();
                    formData.append('address_picture', $(this)[0].files[0]);

                    // Lakukan permintaan Ajax untuk mengunggah gambar
                    $.ajax({
                        url: '/sales/edit_sales/' + salesId + '/upload-address-picture',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle success jika diperlukan
                            console.log('Address picture uploaded successfully');
                            // Perbarui tampilan gambar di UI jika diperlukan
                            $('#currentAddressPicture').attr('src', response.path);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
                
                // Event listener untuk menambah produk
                $('#addProductButton').click(function() {
                    var productId = $('#productSelect').val();
                    var quantity = $('#quantityInput').val();

                    // Lakukan validasi sederhana
                    if (!productId || quantity <= 0) {
                        alert('Please select a product and enter a valid quantity.');
                        return;
                    }

                    // Lakukan permintaan Ajax untuk mendapatkan detail produk
                    $.ajax({
                        url: '/sales/get-product-details/' + productId,
                        type: 'GET',
                        success: function(response) {
                            var product = response.product;
                            var subTotal = product.product_price * quantity;

                            // Tambahkan baris baru ke tabel produk
                            var newRow = '<tr>' +
                                '<td>' + product.product_barcode + '</td>' +
                                '<td>' + product.product_name + '</td>' +
                                '<td>' + product.product_price + '</td>' +
                                '<td><input type="number" class="form-control quantity-input" value="' +
                                quantity + '"></td>' +
                                '<td>' + subTotal + '</td>' +
                                '<td><a href="#" class="btn btn-danger delete-btn"><i class="ti ti-trash nav-small-cap-icon fs-3"></i></a></td>' +
                                '</tr>';

                            $('#salesProductsBody').append(newRow);

                            var newSalesProduct = {
                                'id_product': productId,
                                'product_sku': product.product_barcode,
                                'product_name': product.product_name,
                                'salesproduct_price': product.product_price,
                                'quantity': quantity,
                                'sub_total': subTotal
                            };
                            salesProductData.push(newSalesProduct);

                            updateTotalOrder();

                            // Set nilai input tersembunyi dengan data produk penjualan yang diperbarui
                            $('#salesProductData').val(JSON.stringify(salesProductData));
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>



</body>

</html>