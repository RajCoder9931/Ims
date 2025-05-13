<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'salesinvoicedb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Edit Request
if (isset($_POST['update'])) {
    $loan_id = $_POST['loan_id'];
    $principal_amount = $_POST['principal_amount'];
    $down_payment = $_POST['down_payment'];
    $interest_rate = $_POST['interest_rate'];
    $emi_months = $_POST['emi_months'];
    $loan_total_amount = $_POST['loan_total_amount'];
    $loan_interest = $_POST['loan_interest'];
    $grand_total = $_POST['grand_total'];
    $amount_to_be_paid = $_POST['amount_to_be_paid'];
    $customer_name = $_POST['customer_name'];
    $invoice_id = $_POST['invoice_id'];

    // Update loandetails table
    $sql = "UPDATE loandetails SET 
                principal_amount='$principal_amount', 
                down_payment='$down_payment', 
                interest_rate='$interest_rate', 
                emi_months='$emi_months', 
                loan_total_amount='$loan_total_amount', 
                loan_interest='$loan_interest', 
                grand_total='$grand_total', 
                amount_to_be_paid='$amount_to_be_paid' 
            WHERE loan_id='$loan_id'";

    if ($conn->query($sql) === TRUE) {
        // Update invoices table for customer_name
        $sql = "UPDATE invoices SET customer_name='$customer_name' WHERE invoice_id='$invoice_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to hide the form
            exit();
        } else {
            echo "Error updating customer name: " . $conn->error;
        }
    } else {
        echo "Error updating loan details: " . $conn->error;
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $loan_id = $_GET['delete'];
    $sql = "DELETE FROM loandetails WHERE loan_id='$loan_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch Data to Display
$sql = "SELECT loandetails.loan_id, loandetails.principal_amount, loandetails.down_payment, loandetails.interest_rate, loandetails.emi_months, loandetails.loan_total_amount, loandetails.loan_interest, loandetails.grand_total, loandetails.amount_to_be_paid, loandetails.invoice_id, invoices.customer_name 
        FROM loandetails 
        JOIN invoices ON loandetails.invoice_id = invoices.invoice_id";
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
    <style>
        .form-container {
            max-width: 550px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            width: calc(50% - 10px);
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .form-group {
                width: 100%;
            }
        }
    </style>
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
                <h1 class="page-title">Loan Data</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                </ol>
                
<?php
// Display Edit Form if Edit button is clicked
if (isset($_GET['edit'])) {
    $loan_id = $_GET['edit'];
    $sql = "SELECT loandetails.*, invoices.customer_name FROM loandetails JOIN invoices ON loandetails.invoice_id = invoices.invoice_id WHERE loandetails.loan_id='$loan_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<div class="form-container">
    <h2>Edit Loan Details</h2>
    <form method="post" action="">
        <input type="hidden" name="loan_id" value="<?php echo $row['loan_id']; ?>">
        <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id']; ?>">

        <div class="row">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" value="<?php echo $row['customer_name']; ?>">
            </div>

            <div class="form-group">
                <label for="principal_amount">Principal Amount</label>
                <input type="text" name="principal_amount" value="<?php echo $row['principal_amount']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="down_payment">Down Payment</label>
                <input type="text" name="down_payment" value="<?php echo $row['down_payment']; ?>">
            </div>

            <div class="form-group">
                <label for="interest_rate">Interest Rate</label>
                <input type="text" name="interest_rate" value="<?php echo $row['interest_rate']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="emi_months">EMI Months</label>
                <input type="text" name="emi_months" value="<?php echo $row['emi_months']; ?>">
            </div>

            <div class="form-group">
                <label for="loan_total_amount">Loan Total Amount</label>
                <input type="text" name="loan_total_amount" value="<?php echo $row['loan_total_amount']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="loan_interest">Loan Interest</label>
                <input type="text" name="loan_interest" value="<?php echo $row['loan_interest']; ?>">
            </div>

            <div class="form-group">
                <label for="grand_total">Grand Total</label>
                <input type="text" name="grand_total" value="<?php echo $row['grand_total']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="amount_to_be_paid">Amount to be Paid</label>
                <input type="text" name="amount_to_be_paid" value="<?php echo $row['amount_to_be_paid']; ?>">
            </div>
        </div>

        <input type="submit" name="update" value="Update">
    </form>
</div>

<?php
}
?>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Loan List</div>
                    </div>
                    <div class="ibox-body">
                    <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%" border="1">
    <tr>
        <th>Loan ID</th>
        <th>Customer Name</th>
        <th>Principal Amount</th>
        <th>Down Payment</th>
        <th>EMI Months</th>
        <th>Loan Total Amount</th>
        <th>Loan Interest</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['loan_id']; ?></td>
        <td><?php echo $row['customer_name']; ?></td>
        <td><?php echo $row['principal_amount']; ?></td>
        <td><?php echo $row['down_payment']; ?></td>
        <td><?php echo $row['emi_months']; ?></td>
        <td><?php echo $row['loan_total_amount']; ?></td>
        <td><?php echo $row['loan_interest']; ?></td>
        <td><a href="?edit=<?php echo $row['loan_id']; ?> "class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i></a></td>
        <td><a href="?delete=<?php echo $row['loan_id']; ?>"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a></td>
    </tr>
    <?php } ?>
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
<script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>
