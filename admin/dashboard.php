<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$admin_name = $_SESSION['admin_name'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
<div class="container">
<span class="navbar-brand">
Salon Admin Panel
</span>

<a href="logout.php" class="btn btn-danger">
Logout
</a>

</div>
</nav>


<div class="container mt-5">

<h2>
Welcome, <?php echo $admin_name; ?> 👋
</h2>

<div class="row mt-4">


<div class="col-md-4">
<div class="card p-4 text-center">
<h4>Manage Services</h4>
<a href="services.php" class="btn btn-dark">
Open
</a>
</div>
</div>


<div class="col-md-4">
<div class="card p-4 text-center">
<h4>Manage Appointments</h4>
<a href="appointments.php" class="btn btn-dark">
Open
</a>
</div>
</div>


<div class="col-md-4">
<div class="card p-4 text-center">
<h4>Manage Users</h4>
<a href="users.php" class="btn btn-dark">
Open
</a>
</div>
</div>


</div>

</div>

</body>
</html>