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
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'create') {
            if (isset($_POST['title']) && isset($_POST['price'])) {
                $title = $_POST['title'];
                $price = $_POST['price'];
                $color = $_POST['color'];
                $desc = $_POST['desc'];
                $brand = $_POST['brand'];
                $img = $_FILES['img'];
                $imgName = $img['name'];
                move_uploaded_file($img['tmp_name'], "../uploads/".$img['name']);
                $qInsert = "INSERT INTO `products`(`title`,`price`,`color`,`brand`,`desc`,`img`)
                VALUES('$title','$price','$color','$brand','$desc','$imgName')";
                $rInsert = mysqli_query($connect,$qInsert);
                if ($rInsert == 1) {
                    echo "محصول با موفقیت افزوده شد!";
                }
            }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Create Product</title>
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-5">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">نام محصول</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">قیمت محصول</label>
                                    <input type="number" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="img">تصویر محصول</label>
                                    <input type="file" name="img" id="img" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">رنگ</label>
                                    <input type="text" name="color" id="color" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="brand">برند</label>
                                    <input type="text" name="brand" id="brand" class="form-control" required >
                                </div>
                                <div class="form-group">
                                    <label for="desc">توضیحات</label>
                                    <textarea name="desc" id="desc" class="form-control" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    ذخیره
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
        } elseif ($_GET['mode'] == 'list') {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Products List</title>
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تصویر</th>
                                <th>نام</th>
                                <th>قیمت</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $qProduct = "SELECT * FROM `products`";
                                $rProduct = mysqli_query($connect, $qProduct);
                                $i = 1;
                                while ($product = mysqli_fetch_object($rProduct)) {
                                    echo "<tr>
                                        <td>$i</td>
                                        <td>
                                        <img src='../uploads/$product->img' width='40' />
                                        </td>
                                        <td>$product->title</td>
                                        <td>$product->price</td>
                                        <td><a href='products.php?mode=edit&id=$product->id'>ویرایش</a><a href='products.php?mode=delete&id=$product->id'>حذف</a></td>
                                    </tr>";
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
        } elseif ($_GET['mode'] == 'edit') {
            if (isset($_GET['id'])) {
                $pid = $_GET['id'];
                $qProductShow = "SELECT * FROM `products` WHERE `id`='$pid'";
                $rProductShow = mysqli_query($connect, $qProductShow);
                if ($rProductShow->num_rows == 1) {
                    $productShow = mysqli_fetch_object($rProductShow);
                    if (isset($_POST['title'])) {
                        $title = $_POST['title'];
                        $price = $_POST['price'];
                        $color = $_POST['color'];
                        $desc = $_POST['desc'];
                        $brand = $_POST['brand'];
                        $img = $_FILES['img'];
                        if ($img['error'] != 4) {
                            $imgName = $img['name'];
                            move_uploaded_file($img['tmp_name'], "../uploads/".$img['name']);
                        } else {
                            $imgName = $productShow->img;
                        }
                        $qUpdate = "UPDATE `products` SET `title`='$title',`price`='$price',`color`='$color',`desc`='$desc',`brand`='$brand',`img`='$imgName' WHERE `id`='$pid'";
                        $rUpdate = mysqli_query($connect, $qUpdate);
                        if ($rUpdate == 1) {
                            header("Location: products.php?mode=list");
                        }
                    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Product</title>
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-5">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">نام محصول</label>
                                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $productShow->title; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">قیمت محصول</label>
                                    <input type="number" name="price" id="price" class="form-control" value="<?php echo $productShow->price; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="img">تصویر محصول</label>
                                    <input type="file" name="img" id="img" class="form-control">
                                    <img src="../uploads/<?php echo $productShow->img; ?>" alt="" class="img-fluid">
                                </div>
                                <div class="form-group">
                                    <label for="color">رنگ</label>
                                    <input type="text" name="color" id="color" class="form-control" value="<?php echo $productShow->color; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="brand">برند</label>
                                    <input type="text" name="brand" id="brand" class="form-control" value="<?php echo $productShow->brand; ?>" required >
                                </div>
                                <div class="form-group">
                                    <label for="desc">توضیحات</label>
                                    <textarea name="desc" id="desc" class="form-control" required><?php echo $productShow->desc; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    ذخیره
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
                } else {
                    header("Location: products.php?mode=list");
                }
            } else {
                header("Location: products.php?mode=list");
            }
        } elseif ($_GET['mode'] == 'delete') {
            if (isset($_GET['id'])) {
                $pid = $_GET['id'];
                $qProductShow = "SELECT * FROM `products` WHERE `id`='$pid'";
                $rProductShow = mysqli_query($connect, $qProductShow);
                if ($rProductShow == 1) {
                    $qDelete = "DELETE FROM `products` WHERE `id`='$pid'";
                    $rDelete = mysqli_query($connect, $qDelete);
                    if ($rDelete == 1) {
                        header("Location: products.php?mode=list");
                    }
                }
            }
        }
    }
?>