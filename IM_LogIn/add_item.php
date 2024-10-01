<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust accordingly
$password = ""; // Adjust accordingly
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['item_name'];
    $costPerItem = $_POST['cost_per_item'];
    $stockQuantity = $_POST['stock_quantity'];

    $query = "INSERT INTO items (item_name, cost_per_item, stock_quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdi", $itemName, $costPerItem, $stockQuantity);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="css/add.css">
    <form method="POST" action="add_item.php">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required><br>

        <label for="cost_per_item">Cost Per Item:</label>
        <input type="number" step="0.01" name="cost_per_item" required><br>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" name="stock_quantity" required><br>

        <input type="submit" value="Add Item">
    </form>
</body>
</html>
