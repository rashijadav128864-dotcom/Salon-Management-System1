<?php

session_start();

include '../includes/database.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];


// Fetch completed/paid appointments as payment history
$sql = "SELECT 
appointments.appointment_id,
services.service_name,
services.price,
appointments.appointment_date,
appointments.appointment_time,
appointments.status

FROM appointments

JOIN services
ON appointments.service_id = services.service_id

WHERE appointments.user_id = ?

ORDER BY appointment_id DESC";


$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);


?>


<!DOCTYPE html>
<html>
<head>

<title>Payment History</title>

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


<h2 class="mb-4">
Payment History
</h2>



<table class="table table-bordered bg-white">


<tr>

<th>Payment ID</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Amount</th>
<th>Status</th>

</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td>
#<?php echo $row['appointment_id']; ?>
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
₹<?php echo $row['price']; ?>
</td>


<td>

<?php

if($row['status']=="Completed"){

    echo '<span class="badge bg-success">Paid</span>';

}
elseif($row['status']=="Cancelled"){

    echo '<span class="badge bg-danger">Cancelled</span>';

}
else{

    echo '<span class="badge bg-warning">Pending</span>';

}

?>

</td>


</tr>


<?php } ?>


</table>


</div>


</body>
</html>