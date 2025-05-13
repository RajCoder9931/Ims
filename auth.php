<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check the form action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === "signup") {
        // Signup Logic
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user_type = $_POST['user_type'] ?? '';

        if ($username && $email && $password && $user_type) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href = 'Login.php';</script>";
            } else {
                echo "<script>alert('Error during registration: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Please fill all fields.'); window.history.back();</script>";
        }
    } elseif ($action === "login") {
        // Login Logic
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email && $password) {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = $user['user_type'];

                    if ($user['user_type'] == 'admin') {
                        header("Location: index.php");
                    } elseif ($user['user_type'] == 'employee') {
                        header("Location: Emp_dasboard.php");
                    } else {
                        header("Location: user_dashboard.php");
                    }
                    exit();
                } else {
                    echo "<script>alert('Invalid password.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('No user found with this email.'); window.history.back();</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Please enter email and password.'); window.history.back();</script>";
        }
    }
}

$conn->close();
?>