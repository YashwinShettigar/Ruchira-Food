<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "food_orders";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    $sql = "DELETE FROM orders WHERE id = $item_id";
    if ($conn->query($sql) === TRUE) {
        echo "Item removed successfully";
    } else {
        echo "Error removing item: " . $conn->error;
    }
} else {
    echo "Item ID not provided";
}
$conn->close();
?>
