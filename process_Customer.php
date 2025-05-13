<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "ims";

// Establish a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $address = $conn->real_escape_string($_POST['branch']);
    $aadhar = $conn->real_escape_string($_POST['aadhar']);
    $gender = $conn->real_escape_string($_POST['gender']);

    // SQL query to insert data
    $sql = "INSERT INTO customers (customer_name, email, contact, address, aadhar, gender) 
            VALUES ('$customer_name', '$email', '$contact', '$address', '$aadhar', '$gender')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Customer created successfully.";
        // Redirect to a success page (optional)
        header("Location: form_basic.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
