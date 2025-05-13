<?php
// Database connection details
$host = 'localhost';
$dbname = 'test'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Initialize PDO for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the last GRN number from the database
    $stmt = $pdo->query("SELECT grn_number FROM invoices ORDER BY id DESC LIMIT 1");
    $lastGRN = $stmt->fetchColumn();

    // If there is a last GRN number, increment it
    if ($lastGRN) {
        // Extract the numeric part of the last GRN number
        $grnNumberSuffix = (int) substr($lastGRN, 3);
        $newGRNNumber = "GRN" . str_pad($grnNumberSuffix + 1, 3, "0", STR_PAD_LEFT);
    } else {
        // If no GRN exists, start from GRN001
        $newGRNNumber = "GRN001";
    }

    // Process the form when it is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $grnNumber = $newGRNNumber; // Use the newly generated GRN number
        $date = $_POST['date'];
        $customerName = $_POST['customerName'];
        $invoiceNumber = $_POST['invoice_number'];
        $invoiceDate = $_POST['invoice_date'];
        $challanNumber = $_POST['challan_number'];
        $challanDate = $_POST['challan_date'];
        $subtotal = $_POST['subtotal'];
        $totalDiscount = $_POST['totalDiscount'];
        $totalGST = $_POST['totalGST'];
        $totalAmount = $_POST['totalAmount'];

        // Insert the invoice data into the invoices table
        $stmt = $pdo->prepare("INSERT INTO invoices (grn_number, date, customer_name, invoice_number, invoice_date, challan_number, challan_date, subtotal, total_discount, total_gst, total_amount) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$grnNumber, $date, $customerName, $invoiceNumber, $invoiceDate, $challanNumber, $challanDate, $subtotal, $totalDiscount, $totalGST, $totalAmount]);

        // Get the last inserted invoice ID (this will be used to link the invoice items)
        $invoiceId = $pdo->lastInsertId();

        // Loop through each item and insert into the invoice_items table
        if (!empty($_POST['itemCode'])) {
            foreach ($_POST['itemCode'] as $index => $itemCode) {
                // Get item details from the form
                $itemDescription = $_POST['itemDescription'][$index];
                $uom = $_POST['uom'][$index];
                $quantity = $_POST['quantity'][$index];
                $unitPrice = $_POST['unitPrice'][$index];
                $discount = $_POST['discount'][$index];
                $gst = $_POST['gst'][$index];

                // Calculate total price for the item
                $priceAfterDiscount = ($quantity * $unitPrice) - $discount;
                $gstAmount = ($priceAfterDiscount * $gst) / 100;
                $totalPrice = $priceAfterDiscount + $gstAmount;

                // Insert item data into the invoice_items table
                $stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, item_code, item_description, uom, quantity, unit_price, discount, gst, total_price) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$invoiceId, $itemCode, $itemDescription, $uom, $quantity, $unitPrice, $discount, $gst, $totalPrice]);
            }
        }

        // Redirect or show success message
        echo "Invoice has been successfully submitted!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
        .add-row-btn {
            cursor: pointer;
            color: green;
            font-size: 20px;
            border: none;
            background-color: transparent;
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
                <h1 class="page-title">Purchase Bill</h1>
                
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
            <td><label for="grnNumber">GRN Number</label></td>
            <td><input type="text" id="grnNumber" name="grnNumber" value="<?php echo $newGRNNumber; ?>" readonly></td>
            <td><label for="date">Date</label></td>
            <td><input type="date" name="date" id="date"></td>
        </tr>
        <tr>
            <td colspan="4"><label for="customerName">Customer Name</label></td>
        </tr>
        <tr>
            <td colspan="4"><input type="text" name="customerName" id="customerName" required><br></td>
        </tr>
        <tr>
            <td><label for="InvoiceNumber">Invoice Number</label></td>
            <td><input type="number" name="invoice_number" id="InvoiceNumber" placeholder="Enter Invoice Number"></td>
            <td><label for="Invoice-Date">Invoice Date</label></td>
            <td><input type="date" name="invoice_date" id="Invoice-Date"></td>
        </tr>
        <tr>
            <td><label for="Challan-Number">Challan Number</label></td>
            <td><input type="text" name="challan_number" id="Challan-Number" placeholder="Enter Challan Number"></td>
            <td><label for="Challan-Date">Challan Date</label></td>
            <td><input type="date" name="challan_date" id="Challan-Date"></td>
        </tr>
    </table>

    <!-- Item List -->
    <table id="itemTable">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>UOM</th>
                <th>Received Qty</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>GST (%)</th>
                <th>Total</th>
                <th>Add Row</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="itemCode[]" class="itemCode" placeholder="Item Code"></td>
                <td><input type="text" name="itemDescription[]" class="itemDescription" placeholder="Item Description"></td>
                <td><input type="text" name="uom[]" class="uom" placeholder="UOM"></td>
                <td><input type="number" name="quantity[]" class="quantity" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="unitPrice[]" class="unitPrice" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="discount[]" class="discount" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="gst[]" class="gst" value="0" onchange="updateTotal()"></td>
                <td><input type="text" class="totalPrice" value="0" readonly></td>
                <td><button type="button" class="add-row-btn" onclick="addRow()">+</button></td>
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
            <td class="total"><strong>Total Amount</strong></td>
            <td class="total"><input type="text" id="totalAmount" value="0.00" readonly></td>
        </tr>
    </table>

    <!-- Hidden Inputs for Totals -->
    <input type="hidden" name="subtotal" id="subtotalHidden">
    <input type="hidden" name="totalDiscount" id="totalDiscountHidden">
    <input type="hidden" name="totalGST" id="totalGSTHidden">
    <input type="hidden" name="totalAmount" id="totalAmountHidden">

    <button type="submit">Submit Invoice</button>
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
        // Function to update totals for items
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

        // Function to add a new row in the item table
        function addRow() {
            const table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
                <td><input type="text" name="itemCode[]" class="itemCode" placeholder="Item Code"></td>
                <td><input type="text" name="itemDescription[]" class="itemDescription" placeholder="Item Description"></td>
                <td><input type="text" name="uom[]" class="uom" placeholder="UOM"></td>
                <td><input type="number" name="quantity[]" class="quantity" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="unitPrice[]" class="unitPrice" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="discount[]" class="discount" value="0" onchange="updateTotal()"></td>
                <td><input type="number" name="gst[]" class="gst" value="0" onchange="updateTotal()"></td>
                <td><input type="text" class="totalPrice" value="0" readonly></td>
                <td><button type="button" class="add-row-btn" onclick="addRow()">+</button></td>
            `;
        }
    </script>
</body>

</html>