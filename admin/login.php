<?php
session_start();
include '../includes/database.php';

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if($admin && password_verify($password,$admin['password'])){

        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['full_name'];

        header("Location: dashboard.php");
        exit;

    }else{
        $error = "Invalid Email or Password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card mx-auto p-4" style="max-width:400px">

<h2 class="text-center">Admin Login</h2>

<?php if($error){ ?>
<div class="alert alert-danger">
<?= $error ?>
</div>
<?php } ?>

<form method="POST">

<input type="email" name="email" class="form-control mb-3" placeholder="Email">

<input type="password" name="password" class="form-control mb-3" placeholder="Password">

<button name="login" class="btn btn-dark w-100">
Login
</button>

</form>

</div>

</div>

</body>
</html>