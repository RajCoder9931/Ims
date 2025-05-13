<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Handle edit action
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $uom_name = $_POST['uom_name'];
    $uom_type = $_POST['uom_type'];

    $stmt = $conn->prepare("UPDATE uoms SET uom_name = ?, uom_type = ? WHERE id = ?");
    $stmt->bind_param("ssi", $uom_name, $uom_type, $id);

    if ($stmt->execute()) {
        echo "<script>alert('UOM updated successfully'); window.location.href='Uom data.php';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch data from database
$result = $conn->query("SELECT * FROM uoms");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit UOM</title>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>
<body>
    <h2>Edit UOM</h2>
    <form method="POST" class="mb-4">
                <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
                <div class="mb-3">
                    <label for="uom_name" class="form-label">UOM Name</label>
                    <input type="text" name="uom_name" id="uom_name" class="form-control" value="<?php echo $edit_row['uom_name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="uom_type" class="form-label">UOM Type</label>
                    <input type="text" name="uom_type" id="uom_type" class="form-control" value="<?php echo $edit_row['uom_type']; ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="Uom data.php" class="btn btn-secondary">Cancel</a>
            </form>
        
</body>
</html>
