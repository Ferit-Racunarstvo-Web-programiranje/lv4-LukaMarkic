<?php
session_start();
include("db_conn.php");
include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dashboard.css">
    <title>Add product</title>
</head>

<body>
    <nav class="nav-dashboard">
        <a href="dashboard.php">
            <h1>Admin Dashboard</h1>
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
    <div class="add-product-contianer">
        <div class="div-divider" id="div-divder-one">Product info</div>
        <div class="add-product-form-section">
            <form method="POST">

                <div class="first-row">
                    <div id="first-row-one">
                        <label for="product-name-input">Name</label>
                        <input id="product-name-input" name="product-name-input" type="text" placeholder="Apple" />
                    </div>

                    <div id="first-row-two">
                        <label for="product-price">Price</label>
                        <input id="product-price" type="number" name="product-price" value="1" min="0" step="0.01" />
                    </div>
                </div>

                <label for="image-url">URL of cover image</label>
                <input type="text" id="image-url" name="image-url" placeholder="https://folder/product_image.png" />
                <div class="checkout-navigation-buttons">
                    <button class="cart-button" type="submit" name="add-product-button">Add product</button>
                </div>
            </form>

        </div>

    </div>


</body>

</html>

<?php


if (isset($_POST["add-product-button"])) {
    if ($_POST["product-name-input"] != "" && $_POST["product-price"] != "" && $_POST["image-url"] != "") {
        $id = 1;
        $name = $_POST["product-name-input"];
        $price = floatval($_POST["product-price"]);
        $image_url = $_POST["image-url"];
        $result = $spoj->query(
            "SELECT `id` FROM `items`"
        );
        $itmes = array();

        $sql = "INSERT INTO `items`(`id`, `name`, `price`, `image_url`) VALUES (?,?,?,?)";
        $stmt = $spoj->prepare($sql);


        if ($result->num_rows > 0) {

            while ($redak = $result->fetch_assoc()) {
                array_push($itmes, $redak["id"]);
            }

            // Ispisivanje koji je index slobodan
            for ($i = 1; $i <= count($itmes) + 2; $i++) {
                if (in_array($i, $itmes) == false) {
                    $id = $i;
                    $stmt->bind_param("isds", $id, $name, $price, $image_url);
                    $stmt->execute();
                    echo '<div class="message-add-product"> Items has been added to inventory! <a href="inventory.php">See Inventory</a></div>';
                    break;
                }
            }

        } else {
            $stmt->bind_param("isds", $id, $name, $price, $image_url);
            $stmt->execute();
        }
    }
}

?>