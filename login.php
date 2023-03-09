<?php 
session_start();
if (isset($_SESSION['user_info'])) {
    header('Location: index.php');
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
    <title>Register</title>
</head>
<body>

    <div class="container mt-3 w-50">
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="users_email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="users_password" class="form-control" id="password" required>
            </div>
            <button type="submit" name="submit_user" class="btn btn-primary">Submit</button>
            <p>I haven't user already yet <a href="/projects/register.php">Register page</a></p>
        </form>
        

        <?php
        $query = 'SELECT users_email, users_password FROM users';
        $result = $conn->query($query);
        
        
        if(isset($_POST['submit_user']) && $result->num_rows > 0){
            foreach ($result as $res) {
                $users_email = $_POST['users_email'];
                $users_password = $_POST['users_password'];
                if ($users_email == $res['users_email'] && $users_password == $res['users_password']) {
                    $_SESSION['user_info'] = ['name' => $users_name, 'email' => $users_email, 'password' => $users_password];
                    header("Location: index.php");
                } else {
                    echo "Email or password is error. Please try again";
                }
            }
        }
    ?>
    
    </div>

</body>
</html>