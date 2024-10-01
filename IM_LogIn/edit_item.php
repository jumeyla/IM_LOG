<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];

    $query = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $costPerItem = $_POST['cost_per_item'];
    $stockQuantity = $_POST['stock_quantity'];

    // Update the item data
    $query = "UPDATE items SET item_name = ?, cost_per_item = ?, stock_quantity = ? WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdii", $itemName, $costPerItem, $stockQuantity, $itemId);

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
    <title>Edit Item</title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="css/add.css">

    <form method="POST" action="edit_item.php">
        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">

        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" value="<?php echo $item['item_name']; ?>" required><br>

        <label for="cost_per_item">Cost Per Item:</label>
        <input type="number" step="0.01" name="cost_per_item" value="<?php echo $item['cost_per_item']; ?>" required><br>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" name="stock_quantity" value="<?php echo $item['stock_quantity']; ?>" required><br>

        <input type="submit" value="Update Item">
    </form>
</body>
</html>
