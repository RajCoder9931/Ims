<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SalesInvoiceDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all invoices and their items
$sql = "SELECT i.invoice_id, i.invoice_number, i.date, i.customer_name, i.mobile_no, i.email, i.city, i.state, i.payment_mode, i.total_amount, 
        ii.item_description, ii.uom, ii.quantity, ii.unit_price, ii.discount, ii.gst_percent, ii.total_price
        FROM Invoices i
        LEFT JOIN InvoiceItems ii ON i.invoice_id = ii.invoice_id";

$result = $conn->query($sql);

// Fetch invoices and items into an associative array
$invoices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invoices[$row['invoice_id']][] = $row;
    }
} else {
    echo "No invoices found.";
}

// Check if the form has been submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_invoice'])) {
        // Delete invoice and associated items
        $invoiceId = $_POST['invoice_id'];

        // Delete items associated with the invoice first
        $deleteItemsSql = "DELETE FROM InvoiceItems WHERE invoice_id = '$invoiceId'";
        if ($conn->query($deleteItemsSql) === TRUE) {
            // Now delete the invoice
            $deleteInvoiceSql = "DELETE FROM Invoices WHERE invoice_id = '$invoiceId'";
            if ($conn->query($deleteInvoiceSql) === TRUE) {
                echo "Invoice deleted successfully!";
                header("Location: data.php");
            } else {
                echo "Error deleting invoice: " . $conn->error;
            }
        } else {
            echo "Error deleting items: " . $conn->error;
        }
    } else {
        // Edit Invoice logic
        // Get the invoice ID and new invoice number
        $invoiceId = $_POST['invoice_id'];
        $invoiceNumber = $_POST['invoiceNumber'];  // New invoice number

        // Retrieve customer data
        $customerName = $_POST['customerName'];
        $mobileNo = $_POST['mobileNo'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $invoiceDate = $_POST['invoiceDate'];  // New invoice date

        // Update invoice table
        $updateInvoiceSql = "UPDATE Invoices 
                             SET invoice_number = '$invoiceNumber', customer_name = '$customerName', mobile_no = '$mobileNo', email = '$email', city = '$city', state = '$state', date = '$invoiceDate'
                             WHERE invoice_id = '$invoiceId'";

        if ($conn->query($updateInvoiceSql) === TRUE) {
            // Update items
            $itemDescriptions = $_POST['itemDescription'];
            $uoms = $_POST['uom'];
            $quantities = $_POST['quantity'];
            $unitPrices = $_POST['unitPrice'];
            $discounts = $_POST['discount'];
            $gstPercents = $_POST['gst'];
            $totalPrices = $_POST['totalPrice'];

            // Delete existing items and insert updated ones
            $deleteItemsSql = "DELETE FROM InvoiceItems WHERE invoice_id = '$invoiceId'";
            $conn->query($deleteItemsSql);

            foreach ($itemDescriptions as $key => $description) {
                $uom = $uoms[$key];
                $quantity = $quantities[$key];
                $unitPrice = $unitPrices[$key];
                $discount = $discounts[$key];
                $gstPercent = $gstPercents[$key];
                $totalPrice = $totalPrices[$key];

                $insertItemSql = "INSERT INTO InvoiceItems (invoice_id, item_description, uom, quantity, unit_price, discount, gst_percent, total_price)
                                  VALUES ('$invoiceId', '$description', '$uom', '$quantity', '$unitPrice', '$discount', '$gstPercent', '$totalPrice')";
                $conn->query($insertItemSql);
            }

            echo "Invoice updated successfully!";
            header("Location: data.php");
        } else {
            echo "Error updating invoice: " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        // Function to open the modal and apply blur to the background
function editInvoice(invoiceId) {
    document.getElementById('editModal').style.display = 'flex'; // Show the modal
    document.body.classList.add('active'); // Apply blur effect to background
    document.getElementById('invoice_id').value = invoiceId; // Set the invoiceId in the form
}

// Function to close the modal and remove the blur effect
function closeModal() {
    document.getElementById('editModal').style.display = 'none'; // Hide the modal
    document.body.classList.remove('active'); // Remove blur effect from background
}

    </script>
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
    <style>
        /* Modal Background */
#editModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* Ensure it's above other content */
}

/* Background blur effect */
#editModal.active + .page-wrapper {
    filter: blur(5px); /* Apply blur to background */
}

/* Modal Container */
#editModal > form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 70%;
    max-width: 800px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1060; /* Ensure it's above the background */
}

/* Page wrapper to apply blur effect */
.page-wrapper {
    transition: filter 0.3s ease;
}

/* Table Styling for Items */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    z-index: 1; /* Ensure table is below the modal */
}

table th, table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

table td input {
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
}

    </style>
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
            <div id="editModal">
<form id="editForm" method="POST">
    <input type="hidden" name="invoice_id" id="invoice_id">

    <!-- Editable Invoice Number and Invoice Date in Two Columns -->
    <div class="form-row">
        <div class="form-group">
            <label for="invoiceNumber">Invoice Number</label>
            <input type="text" name="invoiceNumber" id="invoiceNumber" required>
        </div>
        <div class="form-group">
            <label for="invoiceDate">Invoice Date</label>
            <input type="date" name="invoiceDate" id="invoiceDate" required>
        </div>
    </div>

    <!-- Customer Details (Two Columns) -->
    <div class="form-row">
        <div class="form-group">
            <label for="customerName">Customer Name</label>
            <input type="text" name="customerName" id="customerName" required>
        </div>
        <div class="form-group">
            <label for="mobileNo">Mobile Number</label>
            <input type="text" name="mobileNo" id="mobileNo" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" name="state" id="state" required>
        </div>
    </div>

    <!-- Item List -->
    <h3>Items</h3>
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
        <tbody id="itemsBody"></tbody>
    </table>

    <button type="submit">Save Changes</button>
</form>

<style>
    /* General form styling */
    #editForm {
        font-family: Arial, sans-serif;
        width: 85%;
        margin: 0 auto;
    }
    
    /* Create two-column layout for form fields */
    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .form-group {
        width: 48%; /* Make each form group take up half of the row */
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Table Styling for Items */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    table td input {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    /* Submit Button Styling */
    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        width: 100%;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

</div>

            <div class="page-heading">
                <h1 class="page-title">Purchase Data</h1>
                <!-- <form method="post">
        
        <div class="form-group2">
            <label for="start_date">Start Date:</label>
            <input style="padding:10px;" type="date" id="start_date" name="start_date">

            <label for="end_date">End Date:</label>
            <input style="padding:10px;" type="date" id="end_date" name="end_date">
            <button style="padding:10px;" onclick="refersh(window.location.href='Sell_Report.php')" type="sub">Apply Filters</button>

        </div>

    </form> -->
            </div>        
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Purchase List</div>
                    </div>
                    <div class="ibox-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoices as $invoiceId => $items): ?>
                                    <tr>
                                        <td><?php echo $items[0]['invoice_number']; ?></td>
                                        <td><?php echo $items[0]['customer_name']; ?></td>
                                        <td><?php echo $items[0]['date']; ?></td>
                                        <td><?php echo $items[0]['total_amount']; ?></td>
                                        <td>
                                            <button class='btn btn-primary btn-sm' class="edit-btn" onclick="editInvoice(<?php echo $invoiceId; ?>)"><i class="fas fa-edit"></i></button>
                                            <!-- Add Delete Button -->
                                            <form action="data.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="invoice_id" value="<?php echo $invoiceId; ?>">
                                                <button style="background-color:rgb(233, 34, 20);
                                    color: white;
                                    padding: 5px 10px;
                                    width:2.5rem;
                                    
                                    cursor: pointer;
                                    border: none;"  type="submit" name="delete_invoice"  onclick="return confirm('Are you sure you want to delete this invoice?')"><i class="fa-solid fa-trash"></i></button>
                                            </form>
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
    <script>
// Function to open the modal and pre-fill the form
function editInvoice(invoiceId) {
    const invoiceData = <?php echo json_encode($invoices); ?>;
    const invoice = invoiceData[invoiceId];

    // Populate the form fields with invoice data
    document.getElementById('invoice_id').value = invoiceId;
    document.getElementById('invoiceNumber').value = invoice[0].invoice_number;
    document.getElementById('invoiceDate').value = invoice[0].date;  // Populate the date field
    document.getElementById('customerName').value = invoice[0].customer_name;
    document.getElementById('mobileNo').value = invoice[0].mobile_no;
    document.getElementById('email').value = invoice[0].email;
    document.getElementById('city').value = invoice[0].city;
    document.getElementById('state').value = invoice[0].state;

    // Populate items table
    const itemsBody = document.getElementById('itemsBody');
    itemsBody.innerHTML = '';
    invoice.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="itemDescription[]" value="${item.item_description}" required></td>
            <td><input type="text" name="uom[]" value="${item.uom}" required></td>
            <td><input type="number" name="quantity[]" value="${item.quantity}" required oninput="calculateTotal(${index})"></td>
            <td><input type="number" name="unitPrice[]" value="${item.unit_price}" required oninput="calculateTotal(${index})"></td>
            <td><input type="number" name="discount[]" value="${item.discount}" required oninput="calculateTotal(${index})"></td>
            <td><input type="number" name="gst[]" value="${item.gst_percent}" required oninput="calculateTotal(${index})"></td>
            <td><input type="text" name="totalPrice[]" value="${item.total_price}" readonly></td>
        `;
        itemsBody.appendChild(row);
    });

    // Show the modal
    document.getElementById('editModal').style.display = 'block';
}

// Function to calculate the total price for each item
function calculateTotal(index) {
    const quantity = parseFloat(document.getElementsByName('quantity[]')[index].value) || 0;
    const unitPrice = parseFloat(document.getElementsByName('unitPrice[]')[index].value) || 0;
    const discount = parseFloat(document.getElementsByName('discount[]')[index].value) || 0;
    const gstPercent = parseFloat(document.getElementsByName('gst[]')[index].value) || 0;

    const priceBeforeDiscount = quantity * unitPrice;
    const priceAfterDiscount = priceBeforeDiscount * (1 - discount / 100);
    const finalPrice = priceAfterDiscount * (1 + gstPercent / 100);

    document.getElementsByName('totalPrice[]')[index].value = finalPrice.toFixed(2);
}
</script>
</body>

</html>
<script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>
