<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ims";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $purchase as an empty array to avoid undefined variable issues
$purchase = [];

if (isset($_GET['grn_no']) && !empty($_GET['grn_no'])) {
    $grn_no = $conn->real_escape_string($_GET['grn_no']); // Sanitize input
    $sql = "SELECT * FROM purchase WHERE grn_no=$grn_no";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $purchase = $result->fetch_assoc();
    } else {
        die("Record not found");
    }
} else {
    $conn->error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grn_no = $_POST['grn_no'];
    $company_name = $_POST['company_name'];
    $grn_no = $_POST['grn_no'];
    $invoice_no = $_POST['invoice_no'];
    $bill_no = $_POST['bill_no'];
    $bill_date = $_POST['bill_date'];
    $gst = $_POST['gst'];

    $sql = "UPDATE purchase SET 
            company_name='$company_name', 
            grn_no='$grn_no', 
            invoice_no='$invoice_no', 
            bill_no='$bill_no', 
            bill_date='$bill_date', 
            gst='$gst' 
            WHERE id=$grn_no";

    if ($conn->query($sql) === TRUE) {
        header("Location: purchase_data.php?message=Record updated successfully");
        exit(); // Stop further script execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Purchase</title>
</head>
<body>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($purchase['grn_no'
] ?? ''); ?>">
        
        <label>Company Name:</label>
        <input type="text" name="company_name" value="<?php echo htmlspecialchars($purchase['company_name'] ?? ''); ?>"><br>

        <label>GRN No:</label>
        <input type="text" name="grn_no" value="<?php echo htmlspecialchars($purchase['grn_no'] ?? ''); ?>"><br>

        <label>Invoice No:</label>
        <input type="text" name="invoice_no" value="<?php echo htmlspecialchars($purchase['invoice_no'] ?? ''); ?>"><br>

        <label>Bill No:</label>
        <input type="text" name="bill_no" value="<?php echo htmlspecialchars($purchase['bill_no'] ?? ''); ?>"><br>

        <label>Bill Date:</label>
        <input type="date" name="bill_date" value="<?php echo htmlspecialchars($purchase['bill_date'] ?? ''); ?>"><br>

        <label>GST:</label>
        <input type="text" name="gst" value="<?php echo htmlspecialchars($purchase['gst'] ?? ''); ?>"><br>

        <button type="submit">Save</button>
    </form>
</body>
</html>
