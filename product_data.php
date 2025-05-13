<?php
// Assuming you have a connection to the database
$servername = "127.0.0.1";
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "ims";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$sql = "SELECT id, product_name, uom, quantity, hns_code, discount, gst_no, preferred_vendor, price, daily FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all rows and create an array
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = [];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admincast bootstrap 4 &amp; angular 5 admin template, Шаблон админки | DataTables</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="./assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="index.html">
                    <span class="brand">Admin
                        <span class="brand-tip">Master</span>
                    </span>
                    <span class="brand-mini">AM</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>
                        <form class="navbar-search" action="javascript:;">
                            <div class="rel">
                                <span class="search-icon"><i class="ti-search"></i></span>
                                <input class="form-control" placeholder="Search here...">
                            </div>
                        </form>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
               <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="./assets/img/admin-avatar.png" />
                            <span></span>Admin<i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            
                            <a class="dropdown-item" href="login.html"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="./assets/img/admin-avatar.png" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">Ravi Raj</div><small>Administrator</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="index.php"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Bills</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="invoice.php">Purchase Bill</a>
                            </li>
                            
                            <li>
                                <a href="sell.php">Sale Bill</a>
                            </li>
                           
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Accounts</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="form_basic.php">Day Book</a>
                            </li>
                            <li>
                                <a href="form_advanced.php">Payment</a>                           </li>
                            <li>
                                <a class="active" href="product.php">Receipt</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-table"></i>
                            <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="table_basic.php">Customer Data</a>
                            </li>
                            <li>
                                <a href="datatables.php">Employee Data</a>
                            </li>
                            <li>
                                <a href="product_data.php">Product Data</a>
                            </li>
                            <li>
                                <a class="active" href="Uom data.php">Uom Data</a>
                            </li>
                            <li>
                                <a href="Sell_Report.php">Sale Report </a>
                            </li>
                            <li>
                                <a href="Purchase_Report.php">Purchase Report</a>
                            </li>
                            
                        </ul>
                    </li>
                
                    
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Pages</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="Emp_dasboard.php">Employee Dashboard</a>
                            </li>
                            
                            <li>
                                <a href="login.php">Login</a>
                            </li>
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Master Creation</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="form_basic.php">Customer Creation</a>
                            </li>
                            <li>
                                <a href="form_validation.php">Employee Creation</a>
                            </li>
                            <li>
                                <a class="active" href="product.php">Product Creation</a>
                            </li>
                            <li>
                                <a class="active" href="uom.php">Uom Creation</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Product Data</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                </ol>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Product List</div>
                    </div>
                    <button class="btn btn-success" onclick="downloadExcel()">Download</button>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>GST No</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                        <td data-label="Product ID"><?php echo htmlspecialchars($product['id']); ?></td>
                        <td data-label="Product Name"><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td data-label="Quantity"><?php echo htmlspecialchars($product['quantity']); ?></td>
                        <td data-label="Price"><?php echo htmlspecialchars($product['price']); ?></td>
                        <td data-label="Discount"><?php echo htmlspecialchars($product['discount']); ?></td>
                        <td data-label="GST No"><?php echo htmlspecialchars($product['gst_no']); ?></td>
                        <td>
                            <button class='btn btn-primary btn-sm' onclick="window.location.href='edit_product.php?id=<?php echo $product['id']; ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class='btn btn-danger btn-sm' onclick="deleteproduct(<?php echo $product['id']; ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            
                  </table>
                  
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
   
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        

        function deleteproduct(id) {
            if (confirm('Are you sure you want to delete this customer?')) {
                window.location.href = `delete_product.php?id=${id}`;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    // Function to export table to Excel
    function downloadExcel() {
        var table = document.querySelector("table");
        var wb = XLSX.utils.table_to_book(table, { sheet: "Customers" });
        XLSX.writeFile(wb, "Customer_List.xlsx");
    }
</script>
     <script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>

</body>

</html>