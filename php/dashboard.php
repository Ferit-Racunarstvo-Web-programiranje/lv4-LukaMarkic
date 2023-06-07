<?php
session_start();
include('auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <title>Dashboard</title>
</head>

<body>
    <?php
    if (isset($_SESSION["user"])) {
        ?>
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
        <div class="content">
            <div class="welcome-wrapper">
                <h1 class="welcome-message">Welcome <span>
                        <?php echo $_SESSION["user"]["name"]; ?>
                    </span></h1>
                <div class="shorcut">
                    <div>
                        <a href="inventory.php">
                            <h2>See products</h2>
                            <img src="../images/see-products.png" alt="see_product_placeholder">
                        </a>
                    </div>
                    <div>
                        <a href="add_product.php">
                            <h2>Add product</h2>
                            <img src="../images/add-product.png" alt="add_product_placeholder">
                        </a>
                    </div>
                    <div>
                        <a href="orders.php">
                            <h2>See orders</h2>
                            <img src="../images/see-orders.png" alt="see_orders_placeholder">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="nav-cart">
            <h1>Admin Dashboard Login</h1>
            <div><a href="index.php">Return to home page</a></div>
        </div>
        <div class="sigin-wrapper">
            <div class="sigin-container">
                <h2>Admin Log In</h2>
                <form method="post">
                    <label for="username">Username</label>
                    <input type="text" name="admin_username" placeholder="admin@admin.com" />
                    <label for="">Password</label>
                    <input type="password" name="admin_password" />
                    <div>
                        <p style="color:red;">
                            <?php echo $login_status ?>
                        </p>
                        <button class="login-button" type="submit" name="login-button">Log in</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    ?>

</body>

</html>