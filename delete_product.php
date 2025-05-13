<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ims"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

$conn->close();
header("Location: product_data.php"); // Redirect back to the product page
exit;
?>
