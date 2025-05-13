<?php
// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ims";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID is passed and fetch employee details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "No employee found with the given ID.";
        exit();
    }
} else {
    echo "Invalid request. No ID provided.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $aadhar = $_POST['aadhar'];

    $update_sql = "UPDATE employees SET name = '$name', email = '$email', contact = '$contact', aadhar = '$aadhar' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Employee details updated successfully.'); window.location.href='datatables.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Employee</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $employee['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $employee['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo $employee['contact']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aadhar">Aadhar</label>
                <input type="text" id="aadhar" name="aadhar" class="form-control" value="<?php echo $employee['aadhar']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="datatables.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>
