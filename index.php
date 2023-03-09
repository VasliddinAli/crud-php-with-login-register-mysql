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
        foreach($_SESSION as $user){
            if($user["email"] == "vasliddinali@gmail.com"){
                echo '<form method="post">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="product_name" required>
                </div>
                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="number" name="product_price" class="form-control" id="product_price" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Product color</label>
                    <input type="text" name="product_color" class="form-control" id="email" required>
                </div>
                <button type="submit" name="submit_product" class="btn btn-primary">Submit</button>
            </form>';
            }else{
                echo '<form method="post" class="d-flex gap-3 mt-3">
                    <input type="text" name="search_input" class="form-control" placeholder="Search..." required>
                    <button class="btn btn-danger" name="search">Search</button>
                </form>';
                
            }
        }


        $products = $conn->prepare("INSERT INTO products (product_name, product_price, product_color) VALUES (?, ?, ?)");
        $products->bind_param("sss", $product_name, $product_price, $product_color);

        
        // SEARCH
        if (isset($_POST['search'])){
            $search = $_POST['search_input'];
            $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
            $result = $conn->query($sql);
        }else{
            $query = 'SELECT * FROM products ORDER BY id DESC';
            $result = $conn->query($query);
        }


        ////////////////// ADD
        if (isset($_POST['submit_product'])) {
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_color = $_POST['product_color'];
            $products->execute();
            header("Refresh:0");
        }



        ///////// OPEN
        if ($result->num_rows > 0) {
            echo '<table border=1 class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Color</th>';
                    if($user["email"] == "vasliddinali@gmail.com"){
                        echo '<th scope="col">Update</th>
                        <th scope="col">Delete</th>';
                    }
                echo '</tr>
            </thead>';
            foreach ($result as $row) {
                echo '<tbody>
                    <tr>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['product_price'] . ' so`m</td>
                        <td>' . $row['product_color'] . '</td>';
                        if($user["email"] == "vasliddinali@gmail.com"){
                            echo '<td><a href="update.php?id='. $row['id'] .'" class="btn btn-success">Update</a></td>
                            <td><a href="delete.php?id='. $row['id'] .'" class="btn btn-danger">Delete</a></td>';
                        }
                    echo '</tr>
                    </tbody>';
                }
                echo '</table>';
            } else {
                echo "0 results";
            };
        ?>
    </div>


</body>

</html>