<?php
// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch invoice and items
    $invoice_id = $_GET['id'] ?? null;
    if ($invoice_id) {
        $stmt = $pdo->prepare("SELECT * FROM invoices WHERE id = :id");
        $stmt->execute(['id' => $invoice_id]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id = :invoice_id");
        $stmt->execute(['invoice_id' => $invoice_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Invoice not found.");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update invoice details
        $stmt = $pdo->prepare("
            UPDATE invoices 
            SET grn_number = :grn_number, 
                customer_name = :customer_name, 
                invoice_number = :invoice_number 
            WHERE id = :id
        ");
        $stmt->execute([
            'grn_number' => $_POST['grn_number'],
            'customer_name' => $_POST['customer_name'],
            'invoice_number' => $_POST['invoice_number'],
            'id' => $invoice_id,
        ]);

        // Update invoice items
        $total_amount = 0;
        foreach ($_POST['items'] as $item) {
            $stmt = $pdo->prepare("
                UPDATE invoice_items 
                SET 
                    item_code = :item_code, 
                    item_description = :item_description, 
                    uom = :uom, 
                    quantity = :quantity, 
                    unit_price = :unit_price, 
                    discount = :discount, 
                    gst = :gst, 
                    total_price = :total_price 
                WHERE id = :id
            ");
            $total_price = ($item['quantity'] * $item['unit_price']) - $item['discount'] + $item['gst'];
            $stmt->execute([
                'item_code' => $item['item_code'],
                'item_description' => $item['item_description'],
                'uom' => $item['uom'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'],
                'gst' => $item['gst'],
                'total_price' => $total_price,
                'id' => $item['id']
            ]);
            $total_amount += $total_price;
        }

        // Update total amount in invoices table
        $stmt = $pdo->prepare("UPDATE invoices SET total_amount = :total_amount WHERE id = :id");
        $stmt->execute(['total_amount' => $total_amount, 'id' => $invoice_id]);

        header("Location: Purchase_Report.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

/* Container for the form */
form {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading Styles */
h1, h2 {
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

h1 {
    font-size: 2rem;
}

h2 {
    font-size: 1.5rem;
    color: #555;
}

/* Label and Input Styles */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

input[type="text"], 
input[type="number"], 
button {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 12px;
    font-size: 1rem;
}

input[type="text"]:focus, 
input[type="number"]:focus {
    border-color: #007BFF;
    outline: none;
}

button {
    background-color: #007BFF;
    color: #fff;
    font-size: 1.1rem;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ccc;
}

th {
    background-color: #f1f1f1;
    color: #333;
}

td input {
    width: 100%;
    padding: 6px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

td input:disabled {
    background-color: #e9ecef;
    border-color: #ddd;
}

/* Responsive Styles */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    form {
        padding: 15px;
    }

    table {
        font-size: 0.9rem;
    }

    th, td {
        padding: 8px;
    }

    button {
        font-size: 1rem;
    }
}

    </style>
</head>
<body>
    <h1>Edit Invoice</h1>
    <form method="POST">
        <h2>Invoice Details</h2>
        <p>
            <label for="grn_number">GRN Number:</label>
            <input type="text" id="grn_number" name="grn_number" value="<?= htmlspecialchars($invoice['grn_number']) ?>">
        </p>
        <p>
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" value="<?= htmlspecialchars($invoice['customer_name']) ?>">
        </p>
        <p>
            <label for="invoice_number">Invoice Number:</label>
            <input type="text" id="invoice_number" name="invoice_number" value="<?= htmlspecialchars($invoice['invoice_number']) ?>">
        </p>

        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>UOM</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>GST</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <input type="text" name="items[<?= $item['id'] ?>][item_code]" value="<?= htmlspecialchars($item['item_code']) ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $item['id'] ?>][item_description]" value="<?= htmlspecialchars($item['item_description']) ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $item['id'] ?>][uom]" value="<?= htmlspecialchars($item['uom']) ?>">
                        </td>
                        <td>
                            <input type="number" name="items[<?= $item['id'] ?>][quantity]" value="<?= htmlspecialchars($item['quantity']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?= $item['id'] ?>][unit_price]" value="<?= htmlspecialchars($item['unit_price']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?= $item['id'] ?>][discount]" value="<?= htmlspecialchars($item['discount']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?= $item['id'] ?>][gst]" value="<?= htmlspecialchars($item['gst']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" value="<?= htmlspecialchars($item['total_price']) ?>" disabled>
                        </td>
                        <input type="hidden" name="items[<?= $item['id'] ?>][id]" value="<?= $item['id'] ?>">
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
