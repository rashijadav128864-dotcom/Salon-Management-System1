<?php
session_start();

include '../includes/database.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


// Delete Service
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $sql = "DELETE FROM services WHERE service_id=?";
    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);

    header("Location: services.php");
    exit;
}


// Fetch Services
$result = mysqli_query($conn,"SELECT * FROM services");

?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Services</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">


<nav class="navbar navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand" href="dashboard.php">
Admin Panel
</a>

<a href="dashboard.php" class="btn btn-light">
Dashboard
</a>

</div>
</nav>



<div class="container mt-5">


<div class="d-flex justify-content-between mb-3">

<h2>Manage Services</h2>

<a href="add_service.php" class="btn btn-success">
+ Add Service
</a>

</div>



<table class="table table-bordered bg-white">

<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Duration</th>
<th>Action</th>
</tr>


<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<?php echo $row['service_id']; ?>
</td>

<td>
<?php echo $row['service_name']; ?>
</td>

<td>
<?php echo $row['description']; ?>
</td>

<td>
₹<?php echo $row['price']; ?>
</td>

<td>
<?php echo $row['duration_minutes']; ?> min
</td>

<td>

<a href="services.php?delete=<?php echo $row['service_id']; ?>" 
class="btn btn-danger btn-sm">
Delete
</a>

</td>

</tr>

<?php } ?>


</table>


</div>

</body>
</html>