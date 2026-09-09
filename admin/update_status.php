<?php

session_start();

include '../includes/database.php';


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


$id = $_GET['id'];
$status = $_GET['status'];


$sql = "UPDATE appointments 
SET status=? 
WHERE appointment_id=?";


$stmt = mysqli_prepare($conn,$sql);


mysqli_stmt_bind_param(
    $stmt,
    "si",
    $status,
    $id
);


mysqli_stmt_execute($stmt);


header("Location: appointments.php");

exit;

?>