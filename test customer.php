<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'salesinvoicedb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Edit Request
if (isset($_POST['update'])) {
    $loan_id = $_POST['loan_id'];
    $principal_amount = $_POST['principal_amount'];
    $down_payment = $_POST['down_payment'];
    $interest_rate = $_POST['interest_rate'];
    $emi_months = $_POST['emi_months'];
    $loan_total_amount = $_POST['loan_total_amount'];
    $loan_interest = $_POST['loan_interest'];
    $grand_total = $_POST['grand_total'];
    $amount_to_be_paid = $_POST['amount_to_be_paid'];
    $customer_name = $_POST['customer_name'];
    $invoice_id = $_POST['invoice_id'];

    // Update loandetails table
    $sql = "UPDATE loandetails SET 
                principal_amount='$principal_amount', 
                down_payment='$down_payment', 
                interest_rate='$interest_rate', 
                emi_months='$emi_months', 
                loan_total_amount='$loan_total_amount', 
                loan_interest='$loan_interest', 
                grand_total='$grand_total', 
                amount_to_be_paid='$amount_to_be_paid' 
            WHERE loan_id='$loan_id'";

    if ($conn->query($sql) === TRUE) {
        // Update invoices table for customer_name
        $sql = "UPDATE invoices SET customer_name='$customer_name' WHERE invoice_id='$invoice_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to hide the form
            exit();
        } else {
            echo "Error updating customer name: " . $conn->error;
        }
    } else {
        echo "Error updating loan details: " . $conn->error;
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $loan_id = $_GET['delete'];
    $sql = "DELETE FROM loandetails WHERE loan_id='$loan_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch Data to Display
$sql = "SELECT loandetails.loan_id, loandetails.principal_amount, loandetails.down_payment, loandetails.interest_rate, loandetails.emi_months, loandetails.loan_total_amount, loandetails.loan_interest, loandetails.grand_total, loandetails.amount_to_be_paid, loandetails.invoice_id, invoices.customer_name 
        FROM loandetails 
        JOIN invoices ON loandetails.invoice_id = invoices.invoice_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loan Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 550px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            width: calc(50% - 10px);
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .form-group {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?php
// Display Edit Form if Edit button is clicked
if (isset($_GET['edit'])) {
    $loan_id = $_GET['edit'];
    $sql = "SELECT loandetails.*, invoices.customer_name FROM loandetails JOIN invoices ON loandetails.invoice_id = invoices.invoice_id WHERE loandetails.loan_id='$loan_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<div class="form-container">
    <h2>Edit Loan Details</h2>
    <form method="post" action="">
        <input type="hidden" name="loan_id" value="<?php echo $row['loan_id']; ?>">
        <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id']; ?>">

        <div class="row">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" value="<?php echo $row['customer_name']; ?>">
            </div>

            <div class="form-group">
                <label for="principal_amount">Principal Amount</label>
                <input type="text" name="principal_amount" value="<?php echo $row['principal_amount']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="down_payment">Down Payment</label>
                <input type="text" name="down_payment" value="<?php echo $row['down_payment']; ?>">
            </div>

            <div class="form-group">
                <label for="interest_rate">Interest Rate</label>
                <input type="text" name="interest_rate" value="<?php echo $row['interest_rate']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="emi_months">EMI Months</label>
                <input type="text" name="emi_months" value="<?php echo $row['emi_months']; ?>">
            </div>

            <div class="form-group">
                <label for="loan_total_amount">Loan Total Amount</label>
                <input type="text" name="loan_total_amount" value="<?php echo $row['loan_total_amount']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="loan_interest">Loan Interest</label>
                <input type="text" name="loan_interest" value="<?php echo $row['loan_interest']; ?>">
            </div>

            <div class="form-group">
                <label for="grand_total">Grand Total</label>
                <input type="text" name="grand_total" value="<?php echo $row['grand_total']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="amount_to_be_paid">Amount to be Paid</label>
                <input type="text" name="amount_to_be_paid" value="<?php echo $row['amount_to_be_paid']; ?>">
            </div>
        </div>

        <input type="submit" name="update" value="Update">
    </form>
</div>

<?php
}
?>

<table border="1">
    <tr>
        <th>Loan ID</th>
        <th>Customer Name</th>
        <th>Principal Amount</th>
        <th>Down Payment</th>
        <th>Interest Rate</th>
        <th>EMI Months</th>
        <th>Loan Total Amount</th>
        <th>Loan Interest</th>
        <th>Grand Total</th>
        <th>Amount to be Paid</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['loan_id']; ?></td>
        <td><?php echo $row['customer_name']; ?></td>
        <td><?php echo $row['principal_amount']; ?></td>
        <td><?php echo $row['down_payment']; ?></td>
        <td><?php echo $row['interest_rate']; ?></td>
        <td><?php echo $row['emi_months']; ?></td>
        <td><?php echo $row['loan_total_amount']; ?></td>
        <td><?php echo $row['loan_interest']; ?></td>
        <td><?php echo $row['grand_total']; ?></td>
        <td><?php echo $row['amount_to_be_paid']; ?></td>
        <td><a href="?edit=<?php echo $row['loan_id']; ?>">Edit</a></td>
        <td><a href="?delete=<?php echo $row['loan_id']; ?>">Delete</a></td>
    </tr>
    <?php } ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
