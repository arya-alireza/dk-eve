<?php
    session_start();
    if (isset($_SESSION['adminLogin'])) {
        header("Location: index.php");
    }
    if (isset($_POST['email']) && isset($_POST['password'])) {
        require('config.php');
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = "SELECT * FROM `admins` WHERE `email`='$email'";
        $result = mysqli_query($connect, $query);
        if ($result->num_rows == 1) {
            $admin = mysqli_fetch_object($result);
            if (password_verify($password, $admin->password)) {
                $_SESSION['adminLogin'] = $admin->id;
                header("Location: index.php");
            } else {
                $error = "رمز عبور شما اشتباه است!";
            }
        } else {
            $error = "ایمیل شما اشتباه است!";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-5">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (isset($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">رمز عبور</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    ورود
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>