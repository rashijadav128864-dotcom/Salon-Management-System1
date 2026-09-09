<?php
session_start();

include '../includes/database.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


// Get all appointments
$sql = "SELECT 
appointments.*,
users.full_name,
services.service_name

FROM appointments

JOIN users 
ON appointments.user_id = users.user_id

JOIN services
ON appointments.service_id = services.service_id

ORDER BY appointment_id DESC";


$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Appointments</title>

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


<h2 class="mb-4">
Customer Appointments
</h2>


<table class="table table-bordered bg-white">


<tr>

<th>ID</th>
<th>Customer</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>

</tr>


<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td>
<?php echo $row['appointment_id']; ?>
</td>


<td>
<?php echo $row['full_name']; ?>
</td>


<td>
<?php echo $row['service_name']; ?>
</td>


<td>
<?php echo $row['appointment_date']; ?>
</td>


<td>
<?php echo $row['appointment_time']; ?>
</td>


<td>

<span class="badge bg-warning">
<?php echo $row['status']; ?>
</span>

</td>


<td>

<a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Approved"
class="btn btn-success btn-sm">
Approve
</a>


<a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Completed"
class="btn btn-primary btn-sm">
Complete
</a>


<a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Cancelled"
class="btn btn-danger btn-sm">
Cancel
</a>

</td>


</tr>


<?php } ?>


</table>


</div>


</body>
</html>