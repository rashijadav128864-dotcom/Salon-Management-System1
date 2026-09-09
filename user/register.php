<?php
// =====================================================================
// USER REGISTRATION PAGE
// This file does two jobs:
//   1. PHP LOGIC (top of file)  -> validates the form and saves the user
//   2. HTML OUTPUT (bottom)     -> displays the Bootstrap form
// This is a common beginner-friendly pattern: handle the data FIRST,
// then decide what to show, so we never send HTML before a redirect.
// =====================================================================

// Pull in the $conn variable (our mysqli database connection)
require_once '../includes/database.php';

// -----------------------------------------------------------------
// These variables will hold error messages and old form input.
// We start them empty. If validation fails, we fill them in below
// so the page can display errors AND keep the user's typed data
// (so they don't have to retype everything).
// -----------------------------------------------------------------
$errors = [];
$full_name = "";
$email = "";
$phone = "";
$address = "";

// -----------------------------------------------------------------
// Only run this logic when the form has been SUBMITTED (POST request).
// On a normal page visit (GET request), we skip straight to showing
// the empty form.
// -----------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ---------------------------------------------------------
    // STEP 1: Collect and clean the submitted data
    // ---------------------------------------------------------
    // trim() removes accidental extra spaces from the start/end.
    // htmlspecialchars() converts characters like < > & into safe
    // HTML entities, which helps prevent XSS (cross-site scripting)
    // when we later display these values back on the page.
    // ---------------------------------------------------------
    $full_name        = trim($_POST['full_name'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $phone             = trim($_POST['phone'] ?? '');
    $address           = trim($_POST['address'] ?? '');
    $password          = $_POST['password'] ?? '';
    $confirm_password  = $_POST['confirm_password'] ?? '';

    // ---------------------------------------------------------
    // STEP 2: Validate required fields
    // ---------------------------------------------------------
    if ($full_name === '') {
        $errors[] = "Full Name is required.";
    }

    if ($email === '') {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // filter_var with FILTER_VALIDATE_EMAIL checks the email
        // actually looks like a real email address (name@domain.com)
        $errors[] = "Please enter a valid email address.";
    }

    if ($phone === '') {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        // preg_match checks the phone is exactly 10 digits (numbers only)
        $errors[] = "Phone number must be exactly 10 digits.";
    }

    if ($address === '') {
        $errors[] = "Address is required.";
    }

    if ($password === '') {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($confirm_password === '') {
        $errors[] = "Please confirm your password.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    // ---------------------------------------------------------
    // STEP 3: Check if the email is already registered
    // ---------------------------------------------------------
    // We only run this DATABASE check if no errors exist yet above -
    // no point checking the database if basic validation already failed.
    //
    // We use a PREPARED STATEMENT here (the ? placeholder) instead of
    // putting $email directly into the SQL string. This is the main
    // defense against SQL Injection: the database treats $email as
    // pure data, never as part of the SQL command itself.
    // ---------------------------------------------------------
    if (empty($errors)) {
        $checkSql = "SELECT user_id FROM users WHERE email = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $email); // "s" = the parameter is a string
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $errors[] = "This email is already registered. Please login instead.";
        }
        mysqli_stmt_close($checkStmt);
    }

    // ---------------------------------------------------------
    // STEP 4: If everything is valid, save the user
    // ---------------------------------------------------------
    if (empty($errors)) {

        // password_hash() converts the plain password into a secure,
        // one-way scrambled string using the bcrypt algorithm.
        // We NEVER store the real password in the database.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepared INSERT statement - again using ? placeholders
        // instead of directly inserting user input into the SQL string.
        $insertSql = "INSERT INTO users (full_name, email, phone, address, password) 
                      VALUES (?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertSql);

        // "sssss" means all 5 values being bound are strings (s = string)
        mysqli_stmt_bind_param(
            $insertStmt,
            "sssss",
            $full_name,
            $email,
            $phone,
            $address,
            $hashed_password
        );

        if (mysqli_stmt_execute($insertStmt)) {
            // Registration succeeded! Redirect to the login page.
            // header("Location: ...") sends the browser to a new page.
            // exit; stops the rest of this script from running after redirecting.
            mysqli_stmt_close($insertStmt);
            header("Location: login.php?registered=success");
            exit;
        } else {
            $errors[] = "Something went wrong while creating your account. Please try again.";
        }
    }
}
// If we reach here, either it's a GET request (fresh page load)
// or POST validation failed - so we continue down and show the HTML form.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Bloom &amp; Gold Salon</title>

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts to match the rest of the site -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Our site-wide stylesheet (reuses the same color variables/theme) -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Page-specific styles just for this auth form -->
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
            max-width: 560px;
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
        <p class="auth-subtitle">Create your account to book appointments &amp; manage your visits.</p>

        <?php if (!empty($errors)): ?>
            <!-- Bootstrap danger alert: lists every validation error found above -->
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- 
            The form submits back to itself (register.php) using POST.
            action="" left empty means "submit to the same page".
        -->
        <form method="POST" action="" novalidate>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                       value="<?php echo htmlspecialchars($full_name); ?>" placeholder="e.g. Riya Patel">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>" placeholder="you@example.com">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                       value="<?php echo htmlspecialchars($phone); ?>" placeholder="10-digit mobile number">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2"
                          placeholder="House no, street, city"><?php echo htmlspecialchars($address); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="At least 6 characters">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                           placeholder="Re-enter password">
                </div>
            </div>

            <button type="submit" class="btn btn-auth-submit mt-2">Create Account</button>
        </form>

        <p class="auth-switch">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>

    <!-- Bootstrap 5 JS Bundle via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
