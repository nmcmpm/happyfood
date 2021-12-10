<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    public function createPost($table, $food, $address, $description, $owner)
    {
        $food = $this->prepareData($food);
        $address = $this->prepareData($address);
        $description = $this->prepareData($description);
        $username = $this->prepareData($owner);
        $this->sql =
            "INSERT INTO " . $table . " (food, address, description, owner) VALUES ('" . $food . "','" . $address . "','" . $description . "','" . $owner . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && $password == $dbpassword) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function forget($table, $username, $email)
    {
        $username = $this->prepareData($username);
        $email = $this->prepareData($email);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && $dbemail == $email) {
                $to_email = $email;
                $subject = 'Password';
                $message = $dbpassword;
                $headers = 'From: hoangducquang.htn2001@gmail.com';
                if(mail($to_email, $subject, $message, $headers) == true)
                {
                    $forget = true;
                } else $forget = false;
            } else $forget = false;
        } else $forget = false;

        return $forget;
    }


    function change($table, $username, $password, $newPassword)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $newPassword = $this->prepareData($newPassword);
        // $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && $password == $dbpassword) {
                // $this->sql = "UPDATE users SET password = 'hello' WHERE username = 'son'";
                $this->sql = "UPDATE " .$table . " SET password = '" .$newPassword. "' WHERE username = '" .$username. "'";
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
                $change = true;
            } else $change = false;
        } else $change = false;
        return $change;
    }

    function signUp($table, $fullname, $email, $username, $password)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        // $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, username, password, email) VALUES ('" . $fullname . "','" . $username . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }



}

?>
