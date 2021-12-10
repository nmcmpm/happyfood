<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['newPassword'])) {
    if ($db->dbConnect()) {
        if ($db->change("users", $_POST['username'], $_POST['password'], $_POST['newPassword'])) {
            echo "Changed Success";
        } else echo "Change Failed";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>