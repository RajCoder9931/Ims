<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ims"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $gst_no = $_POST['gst_no'];

    $sql = "UPDATE products SET product_name='$product_name', quantity='$quantity', price='$price', discount='$discount', gst_no='$gst_no' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully.";
        header("Location: product_data.php"); // Redirect back to the product page
        exit;
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "No product found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <form method="post" action="edit_product.php" class="border p-4 rounded shadow">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" class="form-control" id="discount" name="discount" step="0.01" value="<?php echo htmlspecialchars($product['discount']); ?>">
            </div>
            
            <div class="form-group">
                <label for="gst_no">GST No:</label>
                <input type="text" class="form-control" id="gst_no" name="gst_no" value="<?php echo htmlspecialchars($product['gst_no']); ?>" required>
            </div>
            
            <div class="text-center" style="display:flex; justify-content:baseline; gap:10px; ">
                <button style="width:140px; padding:10px; "  type="submit" class="btn btn-primary btn-block">Update Product</button>
                <a href="product_data.php" style="width:140px; padding:10px;" class="btn btn-secondary btn-block">Cancel</a>
            </div>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
