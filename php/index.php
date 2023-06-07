<?php
session_start();
include "db_conn.php";

?>
<?php
include('cart_manipulation.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Web Market</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
</head>

<body>
    <div class="welome-image-container">
        <div class="title-container">
            <h1>Web Market</h1>
        </div>
        <div class="right-side-container">
            <div class="admin-button">
                <a href="dashboard.php"> Continue as administratot
                </a>
            </div>
            <?php
            if (!empty($_SESSION["shopping_cart"])) {
                $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                ?>
                <div class="cart-div"><a href="cart.php"><img id="cart-image" src="../images/cart-icon.png" /> Cart
                        <?php echo '<span class="cart-badge">' . $cart_count . '</span>'; ?>
                    </a></div>
                <?php
                echo '<form method="post">
                <button class="cart-button" type="submit" name="remove-cart-items">
                    Empty the cart
                </button>
                </form>';
            }
            ?>

        </div>
    </div>
    <div class="select-sort-container">
        <form method="POST">
            <label for="sort">Sort:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="def" disabled="disabled" selected> select an option </option>
                <option value="price-low">from lowest price</option>
                <option value="price-high">from highest price</option>
                <option value="name-asc">by name in ascending oreder</option>
                <option value="name-dsc">by name in descending order</option>
            </select>
        </form>
    </div>
    <?php
    echo $status;
    ?>


    <div class="items-grid">
        <?php
        $sql = "SELECT * FROM items";
        $rezultat = $spoj->query($sql);
        $itmes = array();

        if ($rezultat->num_rows > 0) {
            // Ispisivanje svakog retka kao redak u tablici
            while ($redak = $rezultat->fetch_assoc()) {

                array_push($itmes, $redak);
            }
        } else {
            echo "<p>Nema dostupnih artikala</p>";
        }
        $spoj->close();


        function listItems($itmes)
        {
            foreach ($itmes as $redak) {
                echo '<div class="item">
                <img src="' . $redak["image_url"] . '" alt="' . $redak["name"] . '">
                <h2>' . $redak["name"] . '</h2>
                <p>' . $redak["price"] . ' €</p>
                <form method="post" id="purchase-form">
                    <div>
                        <label for="amount">Amount</label>
                        <input class="amount-input" name="amount" type="number" value="1" min="1"/>
                    </div>
                    <button class="add-to-cart-btn" name="button-code" type="submit" value="' . $redak["id"] . '">Add to cart</button>
                </form>';
                echo '</div>';
            }
        }

        ?>


        <?php



        if (!empty($_POST['sort'])) {
            // this block is only executed if values are received
        
            switch ($_POST['sort']) {
                case 'def':
                    listItems($itmes);
                    break;
                case 'price-low':

                    array_multisort(
                        array_column($itmes, 'price'),
                        SORT_ASC,
                        SORT_NUMERIC,
                        array_keys($itmes),
                        SORT_NUMERIC,
                        SORT_ASC,
                        $itmes
                    );
                    listItems($itmes);
                    break;

                case 'price-high':
                    array_multisort(
                        array_column($itmes, 'price'),
                        SORT_DESC,
                        SORT_NUMERIC,
                        array_keys($itmes),
                        SORT_NUMERIC,
                        SORT_ASC,
                        $itmes
                    );
                    listItems($itmes);
                    break;

                case 'name-asc':
                    array_multisort(
                        array_column($itmes, 'name'),
                        SORT_ASC,
                        SORT_STRING,
                        array_keys($itmes),
                        SORT_NUMERIC,
                        SORT_ASC,
                        $itmes
                    );
                    listItems($itmes);
                    break;

                case 'name-dsc':
                    array_multisort(
                        array_column($itmes, 'name'),
                        SORT_DESC,
                        SORT_STRING,
                        array_keys($itmes),
                        SORT_NUMERIC,
                        SORT_ASC,
                        $itmes
                    );
                    listItems($itmes);
                    break;

                default:
                    echo 'ERROR';
            }

            die();
        } else {
            listItems($itmes);
        }

        ?>

    </div>
    </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>