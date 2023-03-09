<?php 
session_start();
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
    <title>Register</title>
</head>
<body>

    <div class="container mt-3 w-50">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Your name</label>
                <input type="name" name="users_name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="users_email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="users_password" class="form-control" id="password" required>
            </div>
            <button type="submit" name="submit_user" class="btn btn-primary">Submit</button>
            <p>I have user already <a href="/projects/login.php">Login page</a></p>
        </form>

        <?php
        $users = $conn->prepare("INSERT INTO users (users_name, users_email, users_password) VALUE(?, ?, ?)");
        $users->bind_param("sss", $users_name, $users_email, $users_password);

        if(isset($_POST['submit_user'])){
            $users_email = $_POST['users_email'];
            $query = "SELECT * FROM users WHERE `users_email` = '". $users_email ."' LIMIT 1";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "This user is already use. <a href='/projects/login.php'>Go to login page</a>";
            } else {
                $users->execute();
                echo "New records created successfully";
                // header("Refresh:0");
            }
        }
    ?>

    </div>

</body>
</html>
