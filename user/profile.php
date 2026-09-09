<?php

session_start();

include '../includes/database.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];


// Update profile
if(isset($_POST['update'])){

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $sql = "UPDATE users 
            SET full_name=?, phone=?, address=?
            WHERE user_id=?";


    $stmt = mysqli_prepare($conn,$sql);


    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $full_name,
        $phone,
        $address,
        $user_id
    );


    mysqli_stmt_execute($stmt);


    $_SESSION['full_name'] = $full_name;

    header("Location: profile.php");
    exit;

}


// Fetch user data

$sql = "SELECT * FROM users WHERE user_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);


?>


<!DOCTYPE html>
<html>
<head>

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<nav class="navbar navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="dashboard.php">
Bloom & Gold
</a>

<a href="dashboard.php" class="btn btn-light">
Dashboard
</a>

</div>

</nav>



<div class="container mt-5">


<div class="card p-4 mx-auto" style="max-width:500px">


<h2 class="text-center mb-4">
My Profile
</h2>



<form method="POST">


<label class="form-label">
Full Name
</label>

<input type="text"
name="full_name"
class="form-control mb-3"
value="<?php echo $user['full_name']; ?>"
required>



<label class="form-label">
Email
</label>

<input type="email"
class="form-control mb-3"
value="<?php echo $user['email']; ?>"
readonly>



<label class="form-label">
Phone
</label>

<input type="text"
name="phone"
class="form-control mb-3"
value="<?php echo $user['phone']; ?>"
required>



<label class="form-label">
Address
</label>

<textarea 
name="address"
class="form-control mb-3"
required><?php echo $user['address']; ?></textarea>



<button name="update" class="btn btn-dark w-100">
Update Profile
</button>


</form>


</div>


</div>


</body>
</html>