<?php
// Database connection
$servername = "127.0.0.1";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "ims"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    // Update query
    $sql = "UPDATE customers SET customer_name=?, email=?, contact=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $customer_name, $email, $contact, $gender, $id);

    if ($stmt->execute()) {
        echo "Customer updated successfully.";
        header("Location: table_basic.php"); // Redirect back to the customer list page
        exit;
    } else {
        echo "Error updating customer: " . $stmt->error;
    }
}

// Check if an ID is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch customer data
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "Customer not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Customer</h2>
        <form action="edit_customer.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">

            <div class="form-group">
                <label for="customer_name">Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $customer['customer_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $customer['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" value="<?php echo $customer['contact']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="Male" <?php echo ($customer['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($customer['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="table_basic.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="./assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
