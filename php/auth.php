<?php
include('db_conn.php');

$login_status = "";

if (isset($_POST['login-button'])) {
    if ((isset($_POST['admin_username']) == false || $_POST['admin_username'] == "") || (isset($_POST['admin_password']) == false || $_POST['admin_password'] == "")) {
        $login_status = "Fill the inpouts!";
    } else {
        $username = $_POST['admin_username'];
        $password = $_POST['admin_password'];
        $result = $spoj->query(
            "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'"
        );


        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];
            $name = $row['name'];
            $id = $row['id'];

            $user = array(
                'id' => $id,
                'username' => $username,
                'name' => $name
            );

            $_SESSION["user"] = $user;
            $login_status = "";
            #
        } else {
            $login_status = "Faild to log in!";
        }
    }
}


if (isset($_POST["log-out"])) {
    unset($_SESSION["user"]);
    header("Location: dashboard.php");
}

?>