<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // requsting array
    $orderedItems = file_get_contents('php://input');
    
    //json to array decode manpara
    $orderedItemsArray = json_decode($orderedItems, true);
    
    //total pric cal 
    $totalPrice = 0;
    foreach ($orderedItemsArray as $item) {
        $totalPrice += $item['price'];
    }
    
//    random number call manpara
    $orderNumber = generateOrderNumber();
    
   
    $pdo = new PDO('mysql:host=localhost;dbname=food_orders', 'root', '');

    $stmt = $pdo->prepare('INSERT INTO orders (order_number, item_name, price, total_price) VALUES (:order_number, :item_name, :price, :total_price)');
   
    foreach ($orderedItemsArray as $item) {
        $stmt->execute(['order_number' => $orderNumber, 'item_name' => $item['name'], 'price' => $item['price'], 'total_price' => $totalPrice]);
    }
    
    echo $orderNumber;
} else {
    http_response_code(405);
    echo 'Error: Only POST requests are allowed.';
}

function generateOrderNumber() {
    return mt_rand(10000000, 99999999);
}
?>
