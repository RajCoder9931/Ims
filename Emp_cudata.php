

<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "ims"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from customers table
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

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
                    <span class="brand">Employee
                        <span class="brand-tip">Master</span>
                    </span>
                    <span class="brand-mini">EM</span>
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
                            <span></span>Employee<i class="fa fa-angle-down m-l-5"></i></a>
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
                        <div class="font-strong">Employee</div><small> Dashboard</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="Emp_dasboard.php"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Bills</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="Emp_invoice.php">Purchase Bill</a>
                            </li>
                            
                            <li>
                                <a href="Emp_sellbill.php">Sell Bill</a>
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
                                <a href="Emp_cudata.php">Customer Data</a>
                            </li>
                            <li>
                                <a href="Emp_prodata.php">Product Data</a>
                            </li>
                            <li>
                                <a href="Emp_uom.php">Uom Data</a>
                            </li>
                            <li>
                                <a href="Emp_sellreport.php">Sale Bill Report</a>
                            </li>
                            <li>
                                <a href="Emp_loandata.php">Loan Report </a>
                            </li>
                            <li>
                                <a href="Emp_purchasereport.php">Purchase Bill Report</a>
                            </li>
                            
                            
                        </ul>
                    </li>
                
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Master Creation</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="Emp_customer.php">Customer Creation</a>
                            </li>
                           
                            <li>
                                <a class="active" href="Emp_product.php">Product Creation</a>
                            </li>
                            <li>
                                <a class="active" href="Emp_uomform.php">UOM Creation</a>
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
                <h1 class="page-title">Customer Data</h1>
                
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Data Table</div>
                    </div>
                    <div class="ibox-body">
                    <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                                                
                                                <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>" . $row["id"] . "</td>
                                                <td>" . $row["customer_name"] . "</td>
                                                <td>" . $row["email"] . "</td>
                                                <td>" . $row["contact"] . "</td>
                                                <td>" . $row["gender"] . "</td>
                                                <td>
                                                        <button class='btn btn-primary btn-sm' onclick=\"editCustomer({$row['id']})\"><i class='fas fa-edit'></i></button>
                                                        <button class='btn btn-danger btn-sm' onclick=\"deleteCustomer({$row['id']})\"><i class='fa-solid fa-trash'></i></button>
                                                    </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No customers found</td></tr>";
                                }
                                ?>
                            </tbody> 
                    </div>
                </div>
               
            </div>
            <!-- END PAGE CONTENT-->
            
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
    <script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>
<script>
    function editCustomer(id) {
            window.location.href = `edit_customer.php?id=${id}`;
        }

        function deleteCustomer(id) {
            if (confirm('Are you sure you want to delete this customer?')) {
                window.location.href = `delete_customer.php?id=${id}`;
            }
        }
</script>
</body>

</html>