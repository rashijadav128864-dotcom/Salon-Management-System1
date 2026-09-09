<?php

session_start();

include '../includes/database.php';


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


// Fetch users
$sql = "SELECT * FROM users ORDER BY user_id DESC";

$result = mysqli_query($conn,$sql);


// Delete User
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $delete = "DELETE FROM users WHERE user_id=?";

    $stmt = mysqli_prepare($conn,$delete);

    mysqli_stmt_bind_param($stmt,"i",$id);

    mysqli_stmt_execute($stmt);


    header("Location: users.php");
    exit;
}

?>


<!DOCTYPE html>
<html>
<head>

<title>Manage Users</title>

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
Registered Users
</h2>



<table class="table table-bordered bg-white">


<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Action</th>

</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>

<td>
<?php echo $row['user_id']; ?>
</td>


<td>
<?php echo $row['full_name']; ?>
</td>


<td>
<?php echo $row['email']; ?>
</td>


<td>
<?php echo $row['phone']; ?>
</td>


<td>
<?php echo $row['address']; ?>
</td>


<td>

<a href="users.php?delete=<?php echo $row['user_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this user?')">

Delete

</a>

</td>


</tr>


<?php } ?>


</table>


</div>


</body>
</html>