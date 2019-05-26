<?php
    require('config.php');
    session_start();
    if (isset($_SESSION['adminLogin'])) {
        $id = $_SESSION['adminLogin'];
        $query = "SELECT * FROM `admins` WHERE `id`='$id'";
        $result = mysqli_query($connect,$query);
        $admin = mysqli_fetch_object($result);
    } else {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        
    </body>
</html>