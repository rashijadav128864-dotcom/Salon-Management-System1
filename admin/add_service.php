<?php
session_start();

include '../includes/database.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


if(isset($_POST['add'])){

    $name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration_minutes'];
    $category = $_POST['category'];

    $sql = "INSERT INTO services 
    (service_name, description, price, duration_minutes, category, status)
    VALUES (?, ?, ?, ?, ?, 'active')";


    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssdis",
        $name,
        $description,
        $price,
        $duration,
        $category
    );


    mysqli_stmt_execute($stmt);


    header("Location: services.php");
    exit;

}

?>


<!DOCTYPE html>
<html>
<head>

<title>Add Service</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<div class="container mt-5">


<div class="card p-4 mx-auto" style="max-width:600px">


<h2 class="mb-4 text-center">
Add New Service
</h2>


<form method="POST">


<input type="text" 
name="service_name"
class="form-control mb-3"
placeholder="Service Name"
required>


<textarea 
name="description"
class="form-control mb-3"
placeholder="Description"
required></textarea>


<input type="number"
name="price"
class="form-control mb-3"
placeholder="Price"
required>


<input type="number"
name="duration_minutes"
class="form-control mb-3"
placeholder="Duration (minutes)"
required>


<input type="text"
name="category"
class="form-control mb-3"
placeholder="Category (Hair/Skin/Makeup)"
required>


<button name="add" class="btn btn-success w-100">
Add Service
</button>


</form>


</div>


</div>


</body>
</html>