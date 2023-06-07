<?php

include('db_conn.php'); //povezivanje s bazom
$status = "";
$show_modal = false;
if (isset($_POST['button-code']) && $_POST['button-code'] != "") {
    $code = $_POST['button-code'];
    $amount = $_POST['amount'];
    if ($amount == "") {
        $amount = 1;
    }
    $result = $spoj->query(
        "SELECT * FROM `items` WHERE `id`='$code'"
    );
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $id = $row['id'];
    $price = $row['price'];
    $image_url = $row['image_url'];


    $cartArray = array(
        $id => array(
            'name' => $name,
            'id' => $id,
            'price' => $price,
            'quantity' => intval($amount),
            'image_url' => $image_url
        )
    );


    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;

        $status = "<div class='box'>Product is added to your cart!</div>";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "<div class='box' style='color:red;'>
	Product is already added to your cart!</div>";
        } else {
            $_SESSION["shopping_cart"] = array_replace(
                $_SESSION["shopping_cart"],
                $cartArray
            );
            $status = "<div class='box'>Product is added to your cart!</div>";
        }

    }

}



if (isset($_POST['remove-cart-items'])) {
    unset($_SESSION["shopping_cart"]);
    $status = "<div class='box'>All items are removed from cart!</div>";
}

if (isset($_POST["amount"])) {
    $amount = intval($_POST["amount"]);
    if (isset($_POST["amount-id"])) {
        $id = $_POST["amount-id"];
        $_SESSION["shopping_cart"][$id]["quantity"] = $amount;
    }

}

if (isset($_POST["button-remove"])) {
    $code = $_POST["button-remove"];
    unset($_SESSION["shopping_cart"][$code]);
}

?>