<?php
require_once 'includes/database.php';

$sql = "SELECT * FROM services WHERE status='Active' ORDER BY service_id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Bloom & Gold Salon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background: #fff7f5;
        }

        .services-header {
            padding: 120px 0 50px;
            text-align: center;
        }

        .service-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .service-card:hover {
            transform: translateY(-8px);
        }

        .service-card h3 {
            color: #b88a44;
            font-family: serif;
        }

        .price {
            color: #c0524f;
            font-weight: bold;
            font-size: 18px;
        }

        .duration {
            color: #777;
        }

        .btn-book {
            background: #b88a44;
            color: white;
            border-radius: 30px;
            padding: 10px 25px;
            text-decoration: none;
        }

        .btn-book:hover {
            background: #c0524f;
            color: white;
        }
    </style>

</head>

<body>


<nav class="navbar navbar-expand-lg fixed-top bg-white">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            Bloom<span style="color:#b88a44;">&</span>Gold
        </a>

        <div>
            <a href="index.php" class="nav-link d-inline">Home</a>
            <a href="user/login.php" class="nav-link d-inline">Login</a>
        </div>

    </div>
</nav>


<section class="services-header">

    <div class="container">

        <h1>Our Signature Services</h1>

        <p>
            Beauty treatments crafted with care and luxury.
        </p>

    </div>

</section>



<section class="container pb-5">

<div class="row g-4">


<?php while($row = mysqli_fetch_assoc($result)) { ?>

    <div class="col-md-4">

        <div class="service-card">

            <h3>
                <?php echo $row['service_name']; ?>
            </h3>


            <p>
                <?php echo $row['description']; ?>
            </p>


            <p class="price">
                ₹<?php echo $row['price']; ?>
            </p>


            <p class="duration">
                Duration:
                <?php echo $row['duration_minutes']; ?> minutes
            </p>


            <a href="user/book_appointment.php" class="btn-book">
                Book Now
            </a>

        </div>

    </div>


<?php } ?>


</div>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>