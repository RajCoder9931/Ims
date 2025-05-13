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

    $sql = "DELETE FROM purchase WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: Purchase_Reort.php?message=Record deleted successfully");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
$conn->close();
?>
