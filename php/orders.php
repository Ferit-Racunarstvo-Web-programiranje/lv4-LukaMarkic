<?php
include("db_conn.php");
?>

<?php
if (isset($_POST['delete-order'])) {
    $order_id = $_POST['delete-order'];
    $sqlOrders = "DELETE FROM `orders` WHERE `id`='$order_id '";
    $sqlOrderItem = "DELETE FROM `order_item` WHERE `order_id`='$order_id '";
    $spoj->query($sqlOrders);
    $spoj->query($sqlOrderItem);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dashboard.css">
    <title>Orders</title>
</head>

<body>
    <nav class="nav-dashboard">
        <a href="dashboard.php">
            <h1>Taken Orders</h1>
        </a>

        <div class="dashboard-menu">
            <a href="index.php">Home</a>
            <a href="inventory.php">Inventory</a>
            <a href="orders.php">Orders</a>
            <form method="post">
                <button type="sumbit" name="log-out">Log out</button>
            </form>
        </div>
    </nav>
    <div class="order-content">
        <?php
        $sqlOrder = "SELECT * FROM orders";
        $rezultatOrder = $spoj->query($sqlOrder);

        if ($rezultatOrder->num_rows > 0) {

            while ($redak = $rezultatOrder->fetch_assoc()) {
                $order_id = $redak["id"];
                $sqlOrderItem = "SELECT * FROM `order_item` WHERE `order_id`='$order_id'";
                $rezultatOrderItem = $spoj->query($sqlOrderItem);

                echo '<div class="order">
                <div class="order-first-section">
                    <h2>Order No. <span>' . $order_id . '</span></h2>
                    <form method="post">
                        <button  class="remove-order-btn" type="sumbit" name="delete-order" value="' . $order_id . '">Delete order</button>
                    </form>
                </div>
                <div>
                    <div class="name-surname-order">
                        <p>Name: <span>' . $redak["name"] . '</span></h3>
                        <p>Surname: <span>' . $redak["surname"] . '</span></h3>
                    </div>
                    <div class="address-order">
                        <p>Home address: <span>' . $redak["address"] . '</span></p>
                        <p>Emial address: <a href="mailto:' . $redak["email"] . '">' . $redak["email"] . '</a></p>
                    </div>
                    <div>
                        <h3 id="order-title">Ordered items</h3>
                        <div class="orderd-itmes-container">';
                while ($redakItem = $rezultatOrderItem->fetch_assoc()) {
                    echo '<div class="orderd-item">
                                            <h3>' . $redakItem["item_name"] . '</h3>
                                            <p> Price: ' . $redakItem["item_price"] . ' €</p>
                                            <p> Amount: ' . $redakItem["item_quantity"] . '</p
                                            <p>Total: ' . $redakItem["item_price"] * $redakItem["item_quantity"] . ' € </p>
                                        </div>';
                }

                echo '</div>
                    </div>
                </div>
            </div>';

            }
        } else {
            echo '<p id="orders-message">There are no any orders!</p>';
        }
        $spoj->close();
        ?>
    </div>

</body>

</html>