    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="Dashboard.css" />
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .group-divider {
            background-color: lightgray;
           
        }

        #logout_text {
            font-weight: 600;
        }

        #logout_container:hover {
            color: #c82333;
            font-weight: 600;
        }

        #logout_container {
            margin-top: 450px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-..(hash)..">

</head>

<body>
    <div class="container">
        <aside>
            <ul>
                <li><a href="#" class="logo">
                        <img src="img/logo.png" alt="">
                        <span class="aside-item"><span class="special-span"></span>RUCHIRA</span>
                    </a></li>
                <li><a href="A.php" class="aside-link" data-target="home">
                        <i class="fas fa-home"></i>
                        <span class="aside-item">Home</span>
                    </a></li>
                <li><a href="#" class="aside-link">
                        <i class="fas fa-user"></i>
                        <span class="aside-item">Order Details</span>
                    </a></li>

                <li><a href="admin.php" class="aside-link" data-target="home" id="logout_container" onclick="return confirmLogout()">
                        <i class="fas fa-sharp fa-solid fa-right-from-bracket"></i>
                        <span class=" aside-item" id="logout_text">Logout</span>
                    </a></li>

            </ul>
        </aside>



        <section class="main">
            <nav style="height: 70px; background-color:#fff; width: 100%; padding-left:30px; padding: 20px;">
                <h1>ADMIN HOME SECTION</h1>
                <!-- <i class="fas fa-user-cog"></i> -->
            </nav>
           



                <?php

                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "food_orders";
                $conn = new mysqli($servername, $username, $password, $database);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                function removeItem($item_id)
                {
                    global $conn;
                    $sql = "DELETE FROM orders WHERE id = $item_id";
                    if ($conn->query($sql) === TRUE) {
                        echo "Item removed successfully";
                    } else {
                        echo "Error removing item: " . $conn->error;
                    }
                }
                $sql = "SELECT * FROM orders ORDER BY order_number ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    // echo "<th>ID</th>";
                    echo "<th>Order Number</th>";
                    echo "<th>Item Name</th>";
                    echo "<th>Price</th>";
                    echo "<th>Total Price</th>";
                    echo "<th>Created At</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $current_order_number = null;
                    $rowspan = 0; 
                    while ($row = $result->fetch_assoc()) {
                        if ($row['order_number'] !== $current_order_number) {
                            if ($current_order_number !== null) {
                                echo "<td class='group-divider'></td>";
                                echo "<td class='group-divider'></td>";
                                echo "<td class='group-divider'></td>";
                                echo "<td class='group-divider'></td>";
                                echo "<td class='group-divider'></td>";
                                echo "<td class='group-divider'></td>"; 
                                echo "<td></td>";
                                echo "</tr>";
                            }
                            echo "<tr>";
                            // echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['order_number'] . "</td>";
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['total_price'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td><button class='remove-btn' data-item-id='" . $row['id'] . "'>Remove</button></td>";
                            echo "</tr>";
                            $current_order_number = $row['order_number'];
                            $rowspan = 1; 
                        } else {
                            echo "<tr>";
                            // echo "<td></td>"; 
                            echo "<td></td>"; 
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td></td>";
                            echo "<td></td>"; 
                            echo "<td><button class='remove-btn' data-item-id='" . $row['id'] . "'>Remove</button></td>";
                            echo "</tr>";
                            $rowspan++;
                        }
                    }
                    if ($current_order_number !== null) {
                        echo "<td class='group-divider'></td>"; 
                        echo "<td rowspan='$rowspan'></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No orders found";
                }
                $conn->close();
                ?>
        </section>
    </div>
    <script>
        // remove button code
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                // confirmation
                if (confirm("Are you sure you want to remove this item?")) {
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            location.reload();
                        }
                    };
                    xhr.open("GET", "remove_item.php?item_id=" + itemId, true);
                    xhr.send();
                }
            });
        });
    </script>

</body>

</html>