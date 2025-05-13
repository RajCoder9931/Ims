<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = ''; // Replace with your database password
$dbname = 'ims';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data and sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $aadhar = $conn->real_escape_string($_POST['aadhar']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $address = $conn->real_escape_string($_POST['address']);

    // Insert data into the database
    $sql = "INSERT INTO employees (name, email, contact, dob,  aadhar, gender, father_name, address) 
            VALUES ('$name', '$email', '$contact', '$dob',  '$aadhar', '$gender', '$father_name', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "Employee created successfully!";
        header("Location: form_validation.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
