<?php
session_start();

require_once '../includes/database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $notes = $_POST['notes'];

   $sql = "INSERT INTO appointments 
(user_id, service_id, appointment_date, appointment_time, notes)
VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iisss",
    $_SESSION['user_id'],
    $service_id,
    $appointment_date,
    $appointment_time,
    $notes
);
    if(mysqli_stmt_execute($stmt)) {

        echo "
        <script>
        alert('Appointment booked successfully!');
        window.location='dashboard.php';
        </script>
        ";

    } else {

        echo "
        <script>
        alert('Something went wrong!');
        </script>
        ";

    }

}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM services WHERE status='Active'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Book Appointment | Bloom & Gold Salon</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<div class="container mt-5">

<h1 class="text-center mb-4">
Book Your Appointment
</h1>


<form method="POST">


<div class="mb-3">

<label class="form-label">
Select Service
</label>

<select class="form-control" name="service_id">

<?php while($service = mysqli_fetch_assoc($result)) { ?>

<option value="<?php echo $service['service_id']; ?>">

<?php echo $service['service_name']; ?>

</option>

<?php } ?>

</select>

</div>


<div class="mb-3">

<label class="form-label">
Appointment Date
</label>

<input type="date" name="appointment_date" class="form-control">

</div>



<div class="mb-3">

<label class="form-label">
Appointment Time
</label>

<input type="time" name="appointment_time" class="form-control">

</div>



<div class="mb-3">

<label class="form-label">
Notes
</label>

<textarea name="notes" class="form-control"></textarea>

</div>



<button class="btn btn-success">
Book Appointment
</button>


</form>


</div>


</body>

</html>