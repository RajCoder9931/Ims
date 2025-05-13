<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is passed in the URL
if (isset($_POST['invoice_id'])) {
    $invoice_id = intval($_POST['invoice_id']); // Get the invoice ID

    // Prepare and execute the delete query
    $sql = "DELETE FROM invoices WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Invoice deleted successfully.'); window.location.href = 'Sell_Report.php';</script>";
    } else {
        echo "<script>alert('Error deleting invoice: " . $stmt->error . "'); window.location.href = 'Sell_Report.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'Sell_Report.php';</script>";
}

$conn->close();
?>
