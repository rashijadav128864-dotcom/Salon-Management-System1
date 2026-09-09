<?php
// =====================================================================
// USER DASHBOARD PAGE
// This is a PROTECTED page - only logged-in users should see it.
// No database connection yet (as requested) - we only use session data.
// =====================================================================

// session_start() must run before anything else, so PHP can read
// the session data that was saved when the user logged in.
session_start();

// -----------------------------------------------------------------
// THE GATEKEEPER CHECK
// -----------------------------------------------------------------
// isset() checks if $_SESSION['user_id'] exists. It will only exist
// if the user successfully logged in via login.php, which is the
// only place that sets it.
//
// If it's NOT set, this means someone typed this URL directly
// without logging in - so we immediately redirect them to the
// login page and stop the script with exit.
// -----------------------------------------------------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// -----------------------------------------------------------------
// Grab the logged-in user's details from the session (set in login.php)
// so we can display them on the page.
// -----------------------------------------------------------------
$full_name = $_SESSION['full_name'];
$email = $_SESSION['email'];

// date("l, F j, Y") formats today's date like: "Thursday, August 6, 2026"
// l = full weekday name, F = full month name, j = day, Y = full year
$current_date = date("l, F j, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | Bloom &amp; Gold Salon</title>

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts, matching the rest of the site -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Site-wide stylesheet (reuses the same color variables/theme) -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Page-specific styles for the dashboard layout -->
    <style>
        body {
            background: linear-gradient(180deg, var(--blush) 0%, #f9e8e5 100%);
            min-height: 100vh;
        }
        .dash-topbar {
            background-color: var(--white);
            padding: 1.1rem 0;
            box-shadow: 0 4px 18px rgba(43, 35, 32, 0.06);
        }
        .dash-topbar .brand-mark {
            font-size: 1.4rem;
        }
        .dash-user-chip {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .dash-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--rose);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.05rem;
        }
        .dash-welcome {
            padding: 3rem 0 1rem 0;
        }
        .dash-welcome .eyebrow {
            margin-bottom: 0.3rem;
        }
        .dash-welcome h1 {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            margin-bottom: 0.4rem;
        }
        .dash-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.6rem;
            color: var(--charcoal-soft);
            font-size: 0.92rem;
            margin-top: 0.8rem;
        }
        .dash-meta span i {
            color: var(--gold);
            margin-right: 0.4rem;
        }
        .dash-cards {
            padding: 2rem 0 5rem 0;
        }
        .dash-card {
            background: var(--white);
            border-radius: 18px;
            padding: 2.2rem 1.8rem;
            height: 100%;
            text-decoration: none;
            display: block;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            border: 1px solid transparent;
        }
        .dash-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(43, 35, 32, 0.1);
            border-color: var(--gold-light);
        }
        .dash-card-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: var(--blush);
            color: var(--rose-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .dash-card:hover .dash-card-icon {
            background: var(--gold);
            color: var(--white);
        }
        .dash-card h3 {
            font-size: 1.15rem;
            margin-bottom: 0.4rem;
        }
        .dash-card p {
            font-size: 0.88rem;
            color: var(--charcoal-soft);
            margin-bottom: 0;
        }
        .dash-card.logout-card {
            background: var(--charcoal);
        }
        .dash-card.logout-card h3,
        .dash-card.logout-card p {
            color: var(--white);
        }
        .dash-card.logout-card .dash-card-icon {
            background: rgba(255,255,255,0.1);
            color: #e8a5a5;
        }
        .dash-card.logout-card:hover .dash-card-icon {
            background: #c0524f;
            color: var(--white);
        }
    </style>
</head>
<body>

    <!-- =====================================================
         TOP BAR
         Simple bar for a logged-in area, matching site branding.
    ====================================================== -->
    <div class="dash-topbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="../index.php" class="brand-mark">
                Bloom<span class="brand-amp">&amp;</span>Gold
            </a>
            <div class="dash-user-chip">
                <div class="dash-user-avatar">
                    <?php
                    // Show the first letter of the user's name inside the avatar circle
                    echo strtoupper(substr($full_name, 0, 1));
                    ?>
                </div>
                <span class="d-none d-sm-inline" style="font-size:0.9rem; color: var(--charcoal);">
                    <?php echo htmlspecialchars($full_name); ?>
                </span>
            </div>
        </div>
    </div>

    <!-- =====================================================
         WELCOME SECTION
    ====================================================== -->
    <section class="dash-welcome">
        <div class="container">
            <p class="eyebrow">Your Dashboard</p>
            <h1>Welcome, <?php echo htmlspecialchars($full_name); ?> 👋</h1>

            <div class="dash-meta">
                <span><i class="bi bi-envelope"></i><?php echo htmlspecialchars($email); ?></span>
                <span><i class="bi bi-calendar3"></i><?php echo htmlspecialchars($current_date); ?></span>
            </div>
        </div>
    </section>

    <!-- =====================================================
         DASHBOARD CARDS
    ====================================================== -->
    <section class="dash-cards">
        <div class="container">
            <div class="row g-4">

                <div class="col-sm-6 col-lg-4">
                    <a href="book_appointment.php" class="dash-card">
                        <div class="dash-card-icon"><i class="bi bi-calendar-plus"></i></div>
                        <h3>Book Appointment</h3>
                        <p>Reserve a slot with your favorite stylist.</p>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <a href="appointment_history.php" class="dash-card">
                        <div class="dash-card-icon"><i class="bi bi-clock-history"></i></div>
                        <h3>My Appointments</h3>
                        <p>View upcoming and past bookings.</p>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <a href="payment_history.php" class="dash-card">
                        <div class="dash-card-icon"><i class="bi bi-receipt"></i></div>
                        <h3>Payment History</h3>
                        <p>Check your past payments and invoices.</p>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <a href="profile.php" class="dash-card">
                        <div class="dash-card-icon"><i class="bi bi-person-gear"></i></div>
                        <h3>Edit Profile</h3>
                        <p>Update your personal information.</p>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <a href="logout.php" class="dash-card logout-card">
                        <div class="dash-card-icon"><i class="bi bi-box-arrow-right"></i></div>
                        <h3>Logout</h3>
                        <p>Sign out of your account safely.</p>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS Bundle via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
