<?php
// Database connection settings
$servername = "127.0.0.1"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "ims"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate the next invoice number
function getNextInvoiceNumber($conn) {
    // Get the last invoice number from the database
    $sql = "SELECT invoice_number FROM saleinvoices ORDER BY invoice_number DESC LIMIT 1";
    $result = $conn->query($sql);

    // If there are results, extract the number and increment it
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastInvoiceNumber = $row['invoice_number'];

        // Extract the numeric part of the last invoice number (assuming 'INV' prefix)
        $numericPart = substr($lastInvoiceNumber, 3);
        $newInvoiceNumber = 'INV' . str_pad((int)$numericPart + 1, 4, '0', STR_PAD_LEFT);
    } else {
        // If no invoices exist, start with the default 'INV0001'
        $newInvoiceNumber = 'INV0001';
    }

    return $newInvoiceNumber;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve values from the form
    $invoiceNumber = getNextInvoiceNumber($conn); // Get the next invoice number
    $date = $_POST['date'] ?? '';
    $customerName = $_POST['customerName'] ?? '';
    $mobileNo = $_POST['mobileNo'] ?? '';
    $email = $_POST['email'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $paymentMode = $_POST['paymentMode'] ?? '';
    $subtotal = $_POST['subtotal'] ?? '';
    $totalDiscount = $_POST['total_discount'] ?? '';
    $totalGST = $_POST['total_gst'] ?? '';
    $totalAmount = $_POST['total_amount'] ?? '';

    // Insert invoice data into the Invoices table
    $sql = "INSERT INTO saleinvoices (invoice_number, date, customer_name, mobile_no, email, city, state, payment_mode, total_amount, subtotal, total_discount, total_gst)
            VALUES ('$invoiceNumber', '$date', '$customerName', '$mobileNo', '$email', '$city', '$state', '$paymentMode', '$totalAmount', '$subtotal', '$totalDiscount', '$totalGST')";

    if ($conn->query($sql) === TRUE) {
        // Get the inserted invoice ID
        $invoiceId = $conn->insert_id;

        // If the payment mode is 'loan', insert loan details
        if ($paymentMode == 'loan') {
            $principalAmount = $_POST['principalAmount'] ?? 0;
            $downPayment = $_POST['downPayment'] ?? 0;
            $interestRate = $_POST['interestRate'] ?? 0;
            $emiMonths = $_POST['emiMonths'] ?? 0;
            $loanTotalAmount = $_POST['loanTotalAmount'] ?? 0;
            $loanInterest = $_POST['loanInterest'] ?? 0;
            $grandTotal = $_POST['grandTotal'] ?? 0;
            $amountToBePaid = $_POST['amountToBePaid'] ?? 0;

            // Insert loan details into the LoanDetails table
            $loanSql = "INSERT INTO LoanDetails (invoice_id, principal_amount, down_payment, interest_rate, emi_months, loan_total_amount, loan_interest, grand_total, amount_to_be_paid)
                        VALUES ('$invoiceId', '$principalAmount', '$downPayment', '$interestRate', '$emiMonths', '$loanTotalAmount', '$loanInterest', '$grandTotal', '$amountToBePaid')";
            $conn->query($loanSql);
        }

        // Insert items into the InvoiceItems table
        if (isset($_POST['itemDescription'])) {
            $itemDescriptions = $_POST['itemDescription'];
            $uoms = $_POST['uom'];
            $quantities = $_POST['quantity'];
            $unitPrices = $_POST['unitPrice'];
            $discounts = $_POST['discount'];
            $gstPercents = $_POST['gst'];
            $totalPrices = $_POST['totalPrice'];

            foreach ($itemDescriptions as $key => $description) {
                $uom = $uoms[$key] ?? '';
                $quantity = $quantities[$key] ?? 0;
                $unitPrice = $unitPrices[$key] ?? 0;
                $discount = $discounts[$key] ?? 0;
                $gstPercent = $gstPercents[$key] ?? 0;
                $totalPrice = $totalPrices[$key] ?? 0;

                // Insert item data into the InvoiceItems table
                $itemSql = "INSERT INTO saleinvoiceitems (invoice_id, item_description, uom, quantity, unit_price, discount, gst_percent, total_price)
                            VALUES ('$invoiceId', '$description', '$uom', '$quantity', '$unitPrice', '$discount', '$gstPercent', '$totalPrice')";
                $conn->query($itemSql);
            }
        }

        // Redirect or display success message
        echo "Invoice and items inserted successfully!";
        header("Location: Sell_Report.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admincast bootstrap 4 &amp; angular 5 admin template, Шаблон админки | Form Validation</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        .total {
            font-weight: bold;
        }
        .loan-details {
            display: none;
            margin-top: 10px;
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
                            <a class="dropdown-item" href="login.php"><i class="fa fa-power-off"></i>Logout</a>
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
                                <a href="sell.php">Sell Bill</a>
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
                                <a href="Sell_Report.php">Sell Report </a>
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
                <h1 class="page-title">Sale Bill</h1>
                
            </div>
            <div class="page-content fade-in-up">
               
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Bill Form</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                    <form action="" method="post">
        <!-- Invoice Info -->
        <table>
            <tr>
                <td><label for="invoiceNumber">Invoice Number</label></td>
                <td><input type="text" id="invoice_number" name="invoice_number" value="<?php echo getNextInvoiceNumber($conn); ?>" readonly></td>                <td><label for="date">Date</label></td>
                <td><input type="date" name="date" id="date"></td>
            </tr>
            <tr>
                <td colspan="4"><label for="customerName">Customer Name</label></td>
            </tr>
            <tr>
                <td colspan="4"><input type="text" name="customerName" id="customerName" required><br></td>
            </tr>
            <tr>
                <td><label for="mobileNo">Mobile Number</label></td>
                <td><input type="text" name="mobileNo" id="mobileNo" placeholder="Enter Mobile Number" ></td>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" id="email" placeholder="Enter Email"></td>
            </tr>
            <tr>
                <td><label for="city">City</label></td>
                <td><input type="text" name="city" id="city" placeholder="Enter City"></td>
                <td><label for="state">State</label></td>
                <td><input type="text" name="state" id="state" placeholder="Enter State"></td>
            </tr>
        </table>

        <!-- Payment Mode Section -->
        <div>
            <label for="paymentMode">Payment Mode</label>
            <select id="paymentMode" name="paymentMode" onchange="toggleLoanForm()">
                <option value="cash">Cash</option>
                <option value="loan">Loan</option>
                <option value="gpay">GPay</option>
            </select>
        </div>

        <!-- Loan Details Form (initially hidden) -->
        <div id="loanDetails" class="loan-details">
            <h3>Loan Details</h3>
            <table>
                <tr>
                    <td><label for="principalAmount">Principal Amount</label></td>
                    <td><input type="number" name="principalAmount" id="principalAmount" placeholder="Enter Principal Amount" oninput="updateLoanDetails()"></td>
                </tr>
                <tr>
                    <td><label for="downPayment">Down Payment</label></td>
                    <td><input type="number" name="downPayment" id="downPayment" placeholder="Enter Down Payment" oninput="updateLoanDetails()"></td>
                </tr>
                <tr>
                    <td><label for="interest">Interest Rate (%)</label></td>
                    <td><input type="number" name="interest" id="interest" placeholder="Enter Interest Rate" oninput="updateLoanDetails()"></td>
                </tr>
                <tr>
                    <td><label for="emiMonths">No of EMI Months</label></td>
                    <td><input type="number" name="emiMonths" id="emiMonths" placeholder="Enter EMI Months" oninput="updateLoanDetails()"></td>
                </tr>
                <tr>
                    <td><label for="loanTotalAmount">Total Amount (Principal - Down Payment)</label></td>
                    <td><input type="text" name="loanTotalAmount" id="loanTotalAmount" readonly></td>
                </tr>
                <tr>
                    <td><label for="loanInterest">Calculated Interest</label></td>
                    <td><input type="text" name="loanInterest" id="loanInterest" readonly></td>
                </tr>
                <tr>
                    <td><label for="grandTotal">Grand Total (Principal + Interest)</label></td>
                    <td><input type="text" name="grandTotal" id="grandTotal" readonly></td>
                </tr>
            </table>
        </div>

        <!-- Item List -->
        <table id="itemTable">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>UOM</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>GST (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="itemDescription" name="itemDescription[]" placeholder="Item Description"></td>
                    <td><input type="text" class="uom" name="uom[]" placeholder="UOM"></td>
                    <td><input type="number" class="quantity" name="quantity[]" value="0" onchange="updateTotal()" onkeydown="addRowOnEnter(event)"></td>
                    <td><input type="number" class="unitPrice" name="unitPrice[]" value="0" onchange="updateTotal()" onkeydown="addRowOnEnter(event)"></td>
                    <td><input type="number" class="discount" name="discount[]" value="0" onchange="updateTotal()" onkeydown="addRowOnEnter(event)"></td>
                    <td><input type="number" class="gst" name="gst[]" value="0" onchange="updateTotal()" onkeydown="addRowOnEnter(event)"></td>
                    <td><input type="text" class="totalPrice" name="totalPrice[]" value="0" readonly></td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <table>
            <tr>
                <td><strong>Subtotal</strong></td>
                <td><input type="text" id="subtotal" value="0.00" readonly></td>
            </tr>
            <tr>
                <td><strong>Total Discount</strong></td>
                <td><input type="text" id="totalDiscount" value="0.00" readonly></td>
            </tr>
            <tr>
                <td><strong>Total GST</strong></td>
                <td><input type="text" id="totalGST" value="0.00" readonly></td>
            </tr>
            <tr>
                <td><strong>Total Amount</strong></td>
                <td><input type="text" id="totalAmount" value="0.00" readonly></td>
            </tr>
        </table>

        <!-- Hidden fields for form submission -->
        <input type="hidden" id="subtotalHidden" name="subtotal" value="0">
        <input type="hidden" id="totalDiscountHidden" name="total_discount" value="0">
        <input type="hidden" id="totalGSTHidden" name="total_gst" value="0">
        <input type="hidden" id="totalAmountHidden" name="total_amount" value="0">

        <!-- Submit Button -->
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
  Submit Invoice
</button>




    </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    <!-- BEGIN THEME CONFIG PANEL-->
    <div class="theme-config">
        <div class="theme-config-toggle"><i class="fa fa-cog theme-config-show"></i><i class="ti-close theme-config-close"></i></div>
        <div class="theme-config-box">
            <div class="text-center font-18 m-b-20">SETTINGS</div>
            <div class="font-strong">LAYOUT OPTIONS</div>
            <div class="check-list m-b-20 m-t-10">
                <label class="ui-checkbox ui-checkbox-gray">
                    <input id="_fixedNavbar" type="checkbox" checked>
                    <span class="input-span"></span>Fixed navbar</label>
                <label class="ui-checkbox ui-checkbox-gray">
                    <input id="_fixedlayout" type="checkbox">
                    <span class="input-span"></span>Fixed layout</label>
                <label class="ui-checkbox ui-checkbox-gray">
                    <input class="js-sidebar-toggler" type="checkbox">
                    <span class="input-span"></span>Collapse sidebar</label>
            </div>
            <div class="font-strong">LAYOUT STYLE</div>
            <div class="m-t-10">
                <label class="ui-radio ui-radio-gray m-r-10">
                    <input type="radio" name="layout-style" value="" checked="">
                    <span class="input-span"></span>Fluid</label>
                <label class="ui-radio ui-radio-gray">
                    <input type="radio" name="layout-style" value="1">
                    <span class="input-span"></span>Boxed</label>
            </div>
            <div class="m-t-10 m-b-10 font-strong">THEME COLORS</div>
            <div class="d-flex m-b-20">
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Default">
                    <label>
                        <input type="radio" name="setting-theme" value="default" checked="">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-white"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue">
                    <label>
                        <input type="radio" name="setting-theme" value="blue">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-blue"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green">
                    <label>
                        <input type="radio" name="setting-theme" value="green">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-green"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple">
                    <label>
                        <input type="radio" name="setting-theme" value="purple">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-purple"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange">
                    <label>
                        <input type="radio" name="setting-theme" value="orange">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-orange"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink">
                    <label>
                        <input type="radio" name="setting-theme" value="pink">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-pink"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
            </div>
            <div class="d-flex">
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="White">
                    <label>
                        <input type="radio" name="setting-theme" value="white">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue light">
                    <label>
                        <input type="radio" name="setting-theme" value="blue-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-blue"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green light">
                    <label>
                        <input type="radio" name="setting-theme" value="green-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-green"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple light">
                    <label>
                        <input type="radio" name="setting-theme" value="purple-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-purple"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange light">
                    <label>
                        <input type="radio" name="setting-theme" value="orange-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-orange"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink light">
                    <label>
                        <input type="radio" name="setting-theme" value="pink-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-pink"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
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
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script>
        // Update the totals based on items and quantities
        function updateTotal() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalGST = 0;
            const rows = document.querySelectorAll('#itemTable tbody tr');
            rows.forEach(row => {
                let quantity = parseFloat(row.querySelector('.quantity').value);
                let unitPrice = parseFloat(row.querySelector('.unitPrice').value);
                let discount = parseFloat(row.querySelector('.discount').value);
                let gstPercent = parseFloat(row.querySelector('.gst').value);

                // Ensure valid numbers (avoid NaN)
                if (isNaN(quantity)) quantity = 0;
                if (isNaN(unitPrice)) unitPrice = 0;
                if (isNaN(discount)) discount = 0;
                if (isNaN(gstPercent)) gstPercent = 0;

                // Calculate discount and price after discount
                const priceAfterDiscount = (quantity * unitPrice) - discount;

                // Calculate GST for the row
                const gstAmount = (priceAfterDiscount * gstPercent) / 100;

                // Calculate total price for the row (price after discount + GST)
                const totalPrice = priceAfterDiscount + gstAmount;

                // Update the total price field for the row
                row.querySelector('.totalPrice').value = totalPrice.toFixed(2);

                // Update the grand totals
                subtotal += priceAfterDiscount;
                totalDiscount += discount;
                totalGST += gstAmount;
            });

            // Update summary fields
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('totalDiscount').value = totalDiscount.toFixed(2);
            document.getElementById('totalGST').value = totalGST.toFixed(2);
            const totalAmount = subtotal + totalGST - totalDiscount;
            document.getElementById('totalAmount').value = totalAmount.toFixed(2);

            // Set hidden values for form submission
            document.getElementById('subtotalHidden').value = subtotal.toFixed(2);
            document.getElementById('totalDiscountHidden').value = totalDiscount.toFixed(2);
            document.getElementById('totalGSTHidden').value = totalGST.toFixed(2);
            document.getElementById('totalAmountHidden').value = totalAmount.toFixed(2);
        }

        // Add a new row to the table when Enter is pressed
        function addRowOnEnter(event) {
            if (event.key === "Enter") {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="text" class="itemDescription" name="itemDescription[]" placeholder="Item Description"></td>
                    <td><input type="text" class="uom" name="uom[]" placeholder="UOM"></td>
                    <td><input type="number" class="quantity" name="quantity[]" value="0" onchange="updateTotal()"></td>
                    <td><input type="number" class="unitPrice" name="unitPrice[]" value="0" onchange="updateTotal()"></td>
                    <td><input type="number" class="discount" name="discount[]" value="0" onchange="updateTotal()"></td>
                    <td><input type="number" class="gst" name="gst[]" value="0" onchange="updateTotal()"></td>
                    <td><input type="text" class="totalPrice" name="totalPrice[]" value="0" readonly></td>
                `;
                document.querySelector('#itemTable tbody').appendChild(newRow);
            }
        }

        // Toggle the loan details form visibility based on payment mode
        function toggleLoanForm() {
            const paymentMode = document.getElementById('paymentMode').value;
            const loanDetails = document.getElementById('loanDetails');
            if (paymentMode === 'loan') {
                loanDetails.style.display = 'block';
            } else {
                loanDetails.style.display = 'none';
            }
        }

        // Update loan details based on inputs
        function updateLoanDetails() {
            const principalAmount = parseFloat(document.getElementById('principalAmount').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const interestRate = parseFloat(document.getElementById('interest').value) || 0;
            const emiMonths = parseFloat(document.getElementById('emiMonths').value) || 0;

            // Calculate loan total and interest
            const loanTotalAmount = principalAmount - downPayment;
            const loanInterest = (loanTotalAmount * interestRate) / 100;
            const grandTotal = loanTotalAmount + loanInterest;

            // Set the loan details in the form
            document.getElementById('loanTotalAmount').value = loanTotalAmount.toFixed(2);
            document.getElementById('loanInterest').value = loanInterest.toFixed(2);
            document.getElementById('grandTotal').value = grandTotal.toFixed(2);
        }
    </script>
</body>

</html>