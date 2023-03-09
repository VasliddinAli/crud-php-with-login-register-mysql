<?php 
session_start();
if (!isset($_SESSION['user_info'])) {
    header('Location: register.php');
}
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Products</title>
</head>

<body>
    <div class="container mt-3 w-50">
    <a href="/projects/logout.php">Log Out</a>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $p_name = $row['product_name'];
        $p_price = $row['product_price'];
        $p_color = $row['product_color'];

            echo '<form method="post">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input value="'.$p_name.'" type="text" name="product_name" class="form-control" id="product_name" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input value="'.$p_price.'" type="number" name="product_price" class="form-control" id="product_price" required>
            </div>
            <div class="mb-3">
                <label for="product_color" class="form-label">Product color</label>
                <input value="'.$p_color.'" type="text" name="product_color" class="form-control" id="product_color" required>
            </div>
            <button type="submit" name="submit_product" class="btn btn-primary">Submit</button>
        </form>';

        
        if(isset($_POST['submit_product'])){
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_color = $_POST['product_color'];
            $sql_update = "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_color` = '$product_color' WHERE `products`.`id` = $id;";
            if ($conn->query($sql_update) == TRUE) {
                header("Location: index.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        ?>
    </div>


</body>

</html>