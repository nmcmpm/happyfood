<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['food']) && isset($_POST['address']) && isset($_POST['description']) && isset($_POST['owner'])) {
    if ($db->dbConnect()) {
        if ($db->createPost("postfood", $_POST['food'], $_POST['address'], $_POST['description'], $_POST['owner'])) {
            echo "Post Success";
        } else echo "Post Failed";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
