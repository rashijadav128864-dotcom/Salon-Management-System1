<?php
// =====================================================================
// USER LOGIN PAGE
// Same pattern as register.php: handle PHP logic first (top of file),
// then display the HTML form (bottom of file).
// =====================================================================

// session_start() MUST be the very first thing that runs (before any
// HTML output) because it sends a cookie header to the browser.
// This lets us store data (like who is logged in) that persists
// as the user moves between pages.
session_start();

// Pull in the $conn variable (our mysqli database connection)
require_once '../includes/database.php';

// -----------------------------------------------------------------
// Variables for error messages and re-filling the email field
// if login fails (we never re-fill the password, for security).
// -----------------------------------------------------------------
$errors = [];
$email = "";

// -----------------------------------------------------------------
// Check if we arrived here right after a successful registration.
// register.php redirects to: login.php?registered=success
// We look for that in the URL using $_GET.
// -----------------------------------------------------------------
$show_registered_message = isset($_GET['registered']) && $_GET['registered'] === 'success';

// -----------------------------------------------------------------
// Only process login when the form is submitted (POST request).
// -----------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // STEP 1: Collect and clean submitted data
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // STEP 2: Basic validation before touching the database
    if ($email === '') {
        $errors[] = "Email is required.";
    }
    if ($password === '') {
        $errors[] = "Password is required.";
    }

    // STEP 3: Look up the user by email using a PREPARED STATEMENT
    // The "?" placeholder keeps $email as pure data, never as part
    // of the SQL command - this is what prevents SQL Injection.
    if (empty($errors)) {
        $sql = "SELECT user_id, full_name, email, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email); // "s" = string parameter
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        // STEP 4: Verify the user exists AND the password matches
        // password_verify() compares the plain-text password the user
        // just typed against the hashed password stored in the database.
        // It handles all the hashing comparison internally - we never
        // decrypt the stored password (hashes cannot be reversed).
        if ($user && password_verify($password, $user['password'])) {

            // Login success! Regenerate the session ID for security -
            // this prevents "session fixation" attacks.
            session_regenerate_id(true);

            // STEP 5: Store session variables exactly as required.
            // These will be available on every page after this,
            // as long as session_start() is called first on that page.
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email']     = $user['email'];

            // Redirect to the user dashboard and stop the script
            header("Location: dashboard.php");
            exit;

        } else {
            // Generic message on purpose - we don't reveal whether the
            // email exists or the password was wrong. This is a security
            // best practice that avoids helping attackers guess accounts.
            $errors[] = "Invalid Email or Password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bloom &amp; Gold Salon</title>

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts to match the rest of the site -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Our site-wide stylesheet (reuses the same color variables/theme) -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Page-specific styles - identical to register.php so both auth pages match -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            background: linear-gradient(160deg, var(--blush) 0%, #f3d9d4 100%);
        }
        .auth-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.8rem;
            max-width: 460px;
            width: 100%;
            box-shadow: 0 25px 60px rgba(43, 35, 32, 0.12);
        }
        .auth-brand {
            text-align: center;
            margin-bottom: 0.4rem;
        }
        .auth-subtitle {
            text-align: center;
            color: var(--charcoal-soft);
            font-size: 0.92rem;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 500;
            color: var(--charcoal);
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            border: 1px solid #e6d9d6;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(201, 162, 75, 0.2);
        }
        .btn-auth-submit {
            background-color: var(--gold);
            color: var(--white);
            border-radius: 40px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-auth-submit:hover {
            background-color: var(--rose-deep);
            color: var(--white);
        }
        .auth-switch {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        .auth-switch a {
            color: var(--rose-deep);
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <!-- Brand heading, links back to homepage -->
        <div class="auth-brand">
            <a href="../index.php" class="brand-mark" style="font-size:1.6rem;">
                Bloom<span class="brand-amp">&amp;</span>Gold
            </a>
        </div>
        <p class="auth-subtitle">Welcome back. Login to manage your appointments.</p>

        <?php if ($show_registered_message): ?>
            <!-- Bootstrap success alert: shown only right after registration -->
            <div class="alert alert-success">
                Registration successful. Please login.
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <!-- Bootstrap danger alert: shown when login fails -->
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form submits back to itself (login.php) using POST -->
        <form method="POST" action="" novalidate>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>" placeholder="you@example.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-auth-submit mt-2">Login</button>
        </form>

        <p class="auth-switch">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>

    <!-- Bootstrap 5 JS Bundle via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
