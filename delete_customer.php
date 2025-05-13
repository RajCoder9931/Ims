<?php
$conn = new mysqli('localhost', 'root', '', 'ims');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "DELETE FROM customers WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: table_basic.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;

    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
