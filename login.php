<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

// Already logged in? Skip straight to dashboard.
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/dashboard/dashboard.php');
    exit();
}

// Ensure session is active for CSRF + flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Flash messages from previous request
$loginError   = $_SESSION['login_error']   ?? '';
$loginSuccess = $_SESSION['login_success'] ?? '';
unset($_SESSION['login_error'], $_SESSION['login_success']);

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken   = $_SESSION['csrf_token'];
$lastAction  = $_SESSION['last_action'] ?? '';
unset($_SESSION['last_action']);

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $_SESSION['last_action'] = $action;

    // CSRF check
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $postedToken)) {
        $loginError = 'Security check failed. Please try again.';
    } else {
        $conn = getDB();

        if ($action === 'signin') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                $loginError = 'Please fill in both email and password.';
            } else {
                $stmt = $conn->prepare('SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1');
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    loginUser((int) $user['id'], $user['name'], $user['email']);

                    $redirect = $_SESSION['redirect_after_login'] ?? BASE_URL . '/dashboard/dashboard.php';
                    unset($_SESSION['redirect_after_login']);

                    header('Location: ' . $redirect);
                    exit();
                } else {
                    $loginError = 'Invalid email or password.';
                }
            }

        } elseif ($action === 'signup') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($name === '' || $email === '' || $password === '') {
                $loginError = 'Please fill in all fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $loginError = 'Please enter a valid email address.';
            } elseif (strlen($password) < 8) {
                $loginError = 'Password must be at least 8 characters.';
            } else {
                $stmt = $conn->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
                $stmt->execute([':email' => $email]);

                if ($stmt->fetch()) {
                    $loginError = 'This email is already registered. Please log in.';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
                    $stmt->execute([
                        ':name'     => $name,
                        ':email'    => $email,
                        ':password' => $hashedPassword,
                    ]);

                    if ($stmt->rowCount() === 1) {
                        $loginSuccess = 'Account created successfully. Please log in.';
                    } else {
                        $loginError = 'Registration failed. Please try again.';
                    }
                }
            }
        } else {
            $loginError = 'Unknown action requested.';
        }
    }

    // Update flash for POST → GET
    $_SESSION['login_error']   = $loginError;
    $_SESSION['login_success'] = $loginSuccess;

    header('Location: ' . BASE_URL . '/login.php');
    exit();
}

// Render login/register UI (GET request)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Fusion — Login &amp; Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            min-height: 100vh; color: #333;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            position: fixed; top: 0; width: 100%; z-index: 200;
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 40px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        }
        .navbar .brand {
            font-size: 1.5rem; font-weight: 800; color: #2e7d32;
            text-decoration: none; letter-spacing: -0.5px;
            display: flex; align-items: center;
        }
        .navbar .brand img { height: 44px; width: auto; margin-right: 10px; }
        .navbar .brand span { color: #43a047; }
        .navbar .nav-links { display: flex; gap: 20px; align-items: center; }
        .navbar .nav-links a {
            text-decoration: none; color: #555; font-weight: 500;
            font-size: 0.92rem; transition: color 0.3s;
        }
        .navbar .nav-links a:hover { color: #2e7d32; }
        .navbar .nav-links .btn-back {
            background: #2e7d32; color: #fff; padding: 10px 28px;
            border-radius: 35px; font-weight: 600; transition: all 0.3s;
        }
        .navbar .nav-links .btn-back:hover {
            background: #1b5e20; color: #fff; transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,125,50,0.3);
        }

        /* ── Card Container ──────────────────────────── */
        .container {
            background: #fff; border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
            position: relative; overflow: hidden;
            width: 900px; max-width: 95%;
            min-height: 540px; display: flex;
            margin-top: 90px;
        }

        .form-container {
            background: #fff; padding: 50px;
            width: 50%;
            transition: all 0.6s ease-in-out;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            text-align: center;
        }

        .sign-in-container { left: 0; z-index: 2; }
        .sign-up-container {
            position: absolute; left: 0; width: 50%;
            opacity: 0; z-index: 1;
            transition: all 0.6s ease-in-out;
        }
        .container.right-panel-active .sign-up-container {
            transform: translateX(100%); opacity: 1; z-index: 5;
        }
        .container.right-panel-active .sign-in-container {
            transform: translateX(100%); z-index: 1;
        }

        /* ── Form Elements ───────────────────────────── */
        .form-container h1 {
            font-size: 2rem; font-weight: 700;
            color: #1b5e20; margin-bottom: 22px;
        }
        .form-container input {
            background: #e8f5e9; border: 2px solid transparent;
            padding: 13px 18px; margin: 7px 0; width: 100%;
            border-radius: 12px; font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            outline: none; transition: border 0.3s;
        }
        .form-container input:focus { border-color: #43a047; }

        .form-container button[type="submit"] {
            display: inline-block; margin-top: 15px;
            padding: 13px 45px; border-radius: 35px;
            border: none; background: #2e7d32; color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        .form-container button[type="submit"]:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }
        .form-container button[type="submit"]:active { transform: scale(0.97); }

        .error { color: #c62828; margin-top: 8px; font-size: 0.85rem; }
        .success { color: #2e7d32; margin-bottom: 10px; font-weight: 600; }

        /* ── Overlay Panel ───────────────────────────── */
        .overlay-container {
            position: absolute; top: 0; left: 50%;
            width: 50%; height: 100%;
            overflow: hidden; z-index: 100;
            transition: transform 0.6s ease-in-out;
        }
        .overlay {
            background: linear-gradient(135deg, #1b5e20, #2e7d32, #43a047);
            color: #fff; position: absolute; left: -100%;
            height: 100%; width: 200%;
            transform: translateX(0); transition: transform 0.6s ease-in-out;
        }
        .overlay-panel {
            position: absolute; display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            text-align: center; padding: 0 40px;
            height: 100%; width: 50%;
            transition: transform 0.6s ease-in-out;
        }
        .overlay-panel h1 {
            font-size: 1.8rem; font-weight: 700;
            color: #fff; margin-bottom: 12px;
        }
        .overlay-panel p {
            font-size: 0.92rem; color: rgba(255,255,255,0.85);
            line-height: 1.6; margin-bottom: 25px;
        }
        .overlay-panel button.ghost {
            background: transparent; border: 2px solid #fff;
            border-radius: 35px; padding: 11px 38px;
            color: #fff; font-family: 'Poppins', sans-serif;
            font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
        }
        .overlay-panel button.ghost:hover {
            background: #fff; color: #2e7d32;
            transform: translateY(-2px);
        }

        .overlay-right { right: 0; transform: translateX(0); }
        .overlay-left  { transform: translateX(-20%); }

        .container.right-panel-active .overlay-container { transform: translateX(-100%); }
        .container.right-panel-active .overlay { transform: translateX(50%); }
        .container.right-panel-active .overlay-left  { transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }

        /* ── Responsive ─────────────────────────────── */
        @media (max-width: 768px) {
            .navbar { padding: 14px 20px; }
            .navbar .nav-links a:not(.btn-back) { display: none; }
            .container {
                flex-direction: column; width: 92%;
                min-height: auto; margin-top: 80px;
            }
            .form-container { width: 100%; padding: 35px 25px; }
            .overlay-container { display: none; }
            .sign-up-container {
                position: relative; opacity: 1; width: 100%;
                border-top: 1px solid #e0e0e0;
            }
            .container.right-panel-active .sign-up-container {
                transform: none;
            }
            .container.right-panel-active .sign-in-container {
                transform: none;
            }
        }
    </style>
</head>
<body>

<!-- ── Navbar ──────────────────────────────────────────── -->
<nav class="navbar">
    <a href="<?= BASE_URL ?>/index.php" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
    <div class="nav-links">
        <a href="<?= BASE_URL ?>/index.php">&larr; Home</a>
        <a href="<?= BASE_URL ?>/index.php" class="btn-back">Back to Home</a>
    </div>
</nav>

<div class="container" id="container">
    <!-- Sign In -->
    <div class="form-container sign-in-container">
        <?php if ($loginSuccess): ?>
            <div class="success"><?= htmlspecialchars($loginSuccess) ?></div>
        <?php endif; ?>
        <?php if ($loginError && $lastAction !== 'signup'): ?>
            <div class="error"><?= htmlspecialchars($loginError) ?></div>
        <?php endif; ?>
        <form id="signInForm" action="<?= BASE_URL ?>/login.php" method="POST">
            <h1>Welcome Back</h1>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <span class="error" id="signinError"></span>
            <button type="submit" name="action" value="signin">Login</button>
        </form>
    </div>

    <!-- Sign Up -->
    <div class="form-container sign-up-container">
        <?php if ($loginError && $lastAction === 'signup'): ?>
            <div class="error"><?= htmlspecialchars($loginError) ?></div>
        <?php endif; ?>
        <form id="signUpForm" action="<?= BASE_URL ?>/login.php" method="POST">
            <h1>Create Account</h1>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />
            <input type="text" name="name" placeholder="Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <span class="error" id="signupError"></span>
            <button type="submit" name="action" value="signup">Register</button>
        </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>Already have an account? Sign in to access your personalized health plans.</p>
                <button class="ghost" id="signIn">Login</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Start your health journey today. Create an account to get personalized plans.</p>
                <button class="ghost" id="signUp">Register</button>
            </div>
        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    if (signUpButton) {
        signUpButton.addEventListener('click', () => container.classList.add('right-panel-active'));
    }
    if (signInButton) {
        signInButton.addEventListener('click', () => container.classList.remove('right-panel-active'));
    }

    document.getElementById('signInForm').addEventListener('submit', function(e) {
        const email = e.target.email.value;
        const password = e.target.password.value;
        const errorElem = document.getElementById('signinError');
        if (!email || !password) { errorElem.textContent = 'All fields are required!'; e.preventDefault(); }
        else { errorElem.textContent = ''; }
    });

    document.getElementById('signUpForm').addEventListener('submit', function(e) {
        const name = e.target.name.value;
        const email = e.target.email.value;
        const password = e.target.password.value;
        const errorElem = document.getElementById('signupError');
        if (!name || !email || !password) { errorElem.textContent = 'All fields are required!'; e.preventDefault(); }
        else { errorElem.textContent = ''; }
    });

    // If last action was signup and had an error, show signup panel
    <?php if (($loginError && $lastAction === 'signup') || (!$loginError && $lastAction === 'signup')): ?>
        container.classList.add('right-panel-active');
    <?php endif; ?>
</script>
</body>
</html>