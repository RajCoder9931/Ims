<?php
// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ims", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle delete request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        // Delete associated items from invoice_items table
        $stmt = $pdo->prepare("DELETE FROM invoice_items WHERE invoice_id = :invoice_id");
        $stmt->execute(['invoice_id' => $delete_id]);

        // Delete invoice from invoices table
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = :id");
        $stmt->execute(['id' => $delete_id]);

        header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
        exit;
    }

    // Fetch all invoices
    $stmt = $pdo->query("SELECT * FROM invoices");
    $invoices = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
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
                                <a href="loan data.php">Loan Report </a>
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

                <h1 class="page-title">Purchase Data</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                </ol>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Purchase  List</div>
                        <button class="btn btn-success" onclick="downloadExcel()">Download</button>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>GRN No</th>
                                <th>Customer Name</th>
                                <th>Invoice No</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
            <?php if (!empty($invoices)): ?>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><?= htmlspecialchars($invoice['grn_number']) ?></td>
                        <td><?= htmlspecialchars($invoice['customer_name']) ?></td>
                        <td><?= htmlspecialchars($invoice['invoice_number']) ?></td>
                        <td><?= htmlspecialchars($invoice['total_amount']) ?></td>
                        <td>
                            <a style="text-decoration: none;" class='btn btn-primary btn-sm' href="edit_invoice.php?id=<?= htmlspecialchars($invoice['id']) ?>"><i class="fas fa-edit"></i></a>
                            <form class="delete-form" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($invoice['id']) ?>">
                                <button class="delete-btn" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="no-data">No invoices found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
            
                  </table>
                  
                    </div>
                    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Purchase</h5>
                        <button type="button" class="close" onclick="closeModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Invoice No.</label>
                            <input type="text" id="invoice_no" name="invoice_no" class="form-control" required>
                        </div>
                        <!-- <div class="form-group">
                            <label>Bill No.</label>
                            <input type="text" id="bill_no" name="bill_no" class="form-control" required>
                        </div> -->
                        <div class="form-group">
                            <label>Bill Date</label>
                            <input type="date" id="bill_date" name="bill_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>GST</label>
                            <input type="text" id="gst" name="gst" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function editPurchase(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('company_name').value = data.company_name;
            document.getElementById('invoice_no').value = data.invoice_no;
            document.getElementById('bill_date').value = data.bill_date;
            document.getElementById('gst').value = data.gst;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-dialog {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
                </div>
                
            </div>
            
        </div>
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
        $(function() {
            $('#example-table').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        })

        
        
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
<script type="text/javascript">
        function editpurchase(){
            window.location.href="edit_purchase.php";

        }
        function deletepurchase(){
            window.location.href="delete_purchase.php";
        }
    </script>
</body>

</html>
<script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>
