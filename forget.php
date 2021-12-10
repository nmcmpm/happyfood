<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['username']) && isset($_POST['email'])) {
    if ($db->dbConnect()) {
        if ($db->forget("user", $_POST['username'], $_POST['email'])) {
            echo "Forget Success";
        } else echo "Username or Email wrong";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
