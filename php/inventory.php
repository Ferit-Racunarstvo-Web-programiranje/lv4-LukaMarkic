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
    <title>Inventory</title>
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
    <div class="inventory-content">
        <div class="inventroy-content-top">
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
            <div class="add-product-btn">
                <a href="add_product.php">
                    Add new product
                </a>
            </div>
        </div>

        <?php
        if (isset($_POST["button-remove-from-inventory"])) {
            $id = $_POST["button-remove-from-inventory"];
            $sql = "DELETE FROM `items` WHERE `id`='$id'";
            $spoj->query($sql);

        }
        ?>
        <div class="inventry-items">
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



            function listItems($itmes)
            {
                foreach ($itmes as $redak) {
                    echo '<div class="inventory-item">
                        <img src="' . $redak["image_url"] . '" alt="' . $redak["name"] . '">
                        <div>
                            <h2>' . $redak["name"] . '</h2>
                            <p><span>Price:</span><span>' . $redak["price"] . ' €</span></p>
                            <form method="post">
                                <button class="remove-from-inventory-btn" name="button-remove-from-inventory" type="submit" value="' . $redak["id"] . '">Remove product</button>
                            </form>
                        </div>
                    </div>';
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
</body>

</html>