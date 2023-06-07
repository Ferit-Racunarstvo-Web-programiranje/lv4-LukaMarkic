<?php
session_start();
include('cart_manipulation.php')
    ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Web Market</title>
    <link rel="stylesheet" type="text/css" href="../styles/cart-style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/form-details.css" />
</head>

<body>
    <div class="nav-cart">
        <h1>Web Market's Cart</h1>
        <div><a href="index.php">Return to home page</a></div>
    </div>
    <div class="cart-section">
        <div class="div-divider" id="div-divder-one">Cart itmes</div>
        <div class="cart-itmes-section">
            <div class="cart-itmes">
                <?php
                $total_of_all_items = 0;
                if (!empty($_SESSION["shopping_cart"])) {
                    foreach ($_SESSION["shopping_cart"] as $redak) {
                        $total_of_all_items += $redak["price"] * $redak["quantity"];
                        echo '<div class="shoping-cart-item">
                                <img src="' . $redak["image_url"] . '" alt="' . $redak["name"] . '">
                                <h2>' . $redak["name"] . '</h2>
                                <p> Price: ' . $redak["price"] . ' €</p>
                                <form method="post" id="purchase-form">
                                    <div>
                                        <label for="amount">Amount</label>
                                        <input type="number" name="amount-id" value="' . $redak["id"] . '" style="display:none"/>
                                        <input class="amount-input" name="amount" type="number" value="' . $redak["quantity"] . '" min="1" onchange="this.form.submit()"/>
                                    </div>
                                </form>
                                <p>Total: <span id="total-cart-item">' . $redak["price"] * $redak["quantity"] . '</span> €</p>
                                <form method="post">
                                    <button class="remove-from-cart-btn" name="button-remove" type="submit" value="' . $redak["id"] . '">Remove</button>
                                </form>
                            </div>';
                    }
                } else {
                    echo "Cart is empty!";
                }

                ?>

            </div>
            <div class="cart-items-options">
                <div id="total-price-section">Total: <span id=total-price><?php
                echo $total_of_all_items;
                ?></span> €</div>
                <div>
                    <?php
                    echo '<form method="post">
                        <button class="rm-button" type="submit" name="remove-cart-items">
                            Empty the cart
                        </button>
                        </form>';
                    ?>
                </div>
            </div>
        </div>
        <div class="div-divider">Contact info</div>
        <div class="purchase-form-section">
            <form method="POST">
                <div id="name-surname-input-container">
                    <div>
                        <label for="first-name-input">Ime</label>
                        <input id="first-name-input" name="first-name-input" type="text" placeholder="Ivan"
                            oninput="SetInputBorderColor(this)" />
                    </div>
                    <div>
                        <label for="last-name-input">Prezime</label>
                        <input id="last-name-input" name="last-name-input" type="text" placeholder="Ivić"
                            oninput="SetInputBorderColor(this)" />
                    </div>
                </div>
                <label for="home-address">Adresa stanovanja</label>
                <input type="text" id="home-address" name="home-address" placeholder="Vukovarska bb, Osijek"
                    oninput="SetInputBorderColor(this)" />
                <label for="email-address">Email adresa</label>
                <input type="email" id="email-address" name="email-address" placeholder="ivan.ivic@gmail.com"
                    oninput="SetInputBorderColor(this)" />
                <button typle="submit" id="click-post" name="send-order" style="display:none">Order</button>
            </form>
            <div class="checkout-navigation-buttons">
                <button class="cart-button" onclick="checkFormInputs()">Order</button>
            </div>
        </div>
    </div>
    <script src="../script/checkout.js"></script>
</body>

</html>

<?php
include('db_conn.php');

function AddItemsToOrder($spoj, $order_id)
{
    $sql = "INSERT INTO `order_item`(`order_id`, `item_id`, `item_name`, `item_price`, `item_quantity`) VALUES (?,?,?,?,?)";
    $stmt = $spoj->prepare($sql);

    foreach ($_SESSION["shopping_cart"] as $redak) {
        $stmt->bind_param("iisdi", $order_id, $redak["id"], $redak["name"], $redak["price"], $redak["quantity"]);
        $stmt->execute();
    }

}
if (isset($_POST["send-order"])) {
    if (!empty($_SESSION["shopping_cart"])) {
        $id = 1;
        $name = $_POST["first-name-input"];
        $surname = $_POST["last-name-input"];
        $address = $_POST["home-address"];
        $email = $_POST["email-address"];
        $result = $spoj->query(
            "SELECT `id` FROM `orders`"
        );
        $itmes = array();

        $sql = "INSERT INTO `orders`(`id`, `name`, `surname`, `address`, `email`) VALUES (?,?,?,?,?)";
        $stmt = $spoj->prepare($sql);


        if ($result->num_rows > 0) {

            while ($redak = $result->fetch_assoc()) {
                array_push($itmes, $redak["id"]);
            }

            // Ispisivanje koji je index slobodan
            for ($i = 1; $i <= count($itmes) + 2; $i++) {
                if (in_array($i, $itmes) == false) {
                    $id = $i;
                    $stmt->bind_param("issss", $id, $name, $surname, $address, $email);
                    $stmt->execute();
                    AddItemsToOrder($spoj, $id);
                    unset($_SESSION["shopping_cart"]);
                    header("Location: ./order_confirmation.php");
                    break;
                }
            }

        } else {
            $stmt->bind_param("issss", $id, $name, $surname, $address, $email);
            $stmt->execute();
            AddItemsToOrder($spoj, $id);
            unset($_SESSION["shopping_cart"]);
            header("Location: ./order_confirmation.php");
        }
    }
}
?>