<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventory"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $itemId = $_GET['delete'];
    $deleteQuery = "DELETE FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    header("Location: dashboard.php"); // Redirect back to the dashboard after deletion
    exit();
}

$query = "SELECT item_id, item_name, cost_per_item, stock_quantity, total_value FROM items";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dash.css">
</head>
<body>
    <h1>INVENTORY DASHBOARD</h1>
    <a href="add_item.php" class="btn">Add New Item</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Cost Per Item</th>
                <th>Stock Quantity</th>
                <th>Total Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['item_id'] . "</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                    echo "<td>$" . number_format($row['cost_per_item'], 2) . "</td>";
                    echo "<td>" . $row['stock_quantity'] . "</td>";
                    echo "<td>$" . number_format($row['total_value'], 2) . "</td>";
                    echo "<td>
                            <a href='edit_item.php?item_id=" . $row['item_id'] . "' class='btn-edit'>Edit</a>
                            <a href='dashboard.php?delete=" . $row['item_id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No items found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
