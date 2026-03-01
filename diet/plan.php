<?php
/**
 * Personalized Diet Plan Router
 * 
 * Fetches user's state and diet preference from the database,
 * then includes the appropriate legacy diet plan file
 * (vegetarian or non-vegetarian) filtered to the user's state.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireAuth();

$userId   = sessionGet('user_id');
$userName = sessionGet('user_name', 'User');
$conn     = getDB();

// ── Fetch user's state and diet preference ─────────────────
$stmt = $conn->prepare('SELECT state, diet_type FROM users WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch();

$state    = $user['state'] ?? null;
$dietType = $user['diet_type'] ?? 'veg';

// ── Guard: state must be set via metrics ───────────────────
if (empty($state)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan — <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            min-height: 100vh; display: flex; flex-direction: column;
            align-items: center; padding: 0 15px 30px;
        }
        .navbar {
            position: sticky; top: 0; z-index: 100;
            width: 100%; display: flex; justify-content: space-between; align-items: center;
            padding: 14px 40px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(14px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }
        .navbar .brand {
            font-size: 1.45rem; font-weight: 800; color: #2e7d32;
            text-decoration: none; letter-spacing: -0.5px;
            display: flex; align-items: center;
        }
        .navbar .brand img { height: 44px; width: auto; margin-right: 10px; }
        .navbar .brand span { color: #43a047; }
        .nav-center { display: flex; gap: 6px; align-items: center; }
        .nav-center a {
            text-decoration: none; font-weight: 500; font-size: 0.88rem;
            color: #666; padding: 8px 18px; border-radius: 30px;
            transition: all 0.25s;
        }
        .nav-center a:hover { color: #2e7d32; background: #e8f5e9; }
        .nav-center a.active {
            color: #fff; background: #2e7d32; font-weight: 600;
            box-shadow: 0 4px 12px rgba(46,125,50,0.25);
        }
        .nav-right { display: flex; align-items: center; gap: 16px; }
        .nav-right .greeting { font-size: 0.88rem; color: #777; font-weight: 400; }
        .nav-right .greeting strong { color: #333; font-weight: 600; }
        .nav-right a.logout-btn {
            background: transparent; color: #c62828; padding: 8px 22px;
            border: 2px solid #c62828; border-radius: 30px;
            text-decoration: none; font-weight: 600; font-size: 0.85rem;
            transition: all 0.3s;
        }
        .nav-right a.logout-btn:hover {
            background: #c62828; color: #fff; transform: translateY(-1px);
        }
        .message-box {
            background: #fff; border-radius: 16px; padding: 50px 35px;
            text-align: center; box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            max-width: 500px; width: 100%; margin-top: 80px;
        }
        .message-box .icon { font-size: 3rem; margin-bottom: 15px; }
        .message-box h2 { color: #e65100; margin-bottom: 12px; font-weight: 700; }
        .message-box p { color: #666; margin-bottom: 25px; line-height: 1.6; }
        .btn {
            display: inline-block; padding: 14px 38px; border-radius: 35px;
            text-decoration: none; font-weight: 600; transition: all 0.3s;
        }
        .btn-primary {
            background: #2e7d32; color: #fff;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        .btn-primary:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }
        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?= htmlspecialchars(BASE_URL) ?>/dashboard/dashboard.php" class="brand"><img src="<?= htmlspecialchars(ASSET_URL) ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
        <div class="nav-center">
            <a href="<?= htmlspecialchars(BASE_URL) ?>/dashboard/dashboard.php">Dashboard</a>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/metrics/save_results.php">Metrics</a>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/metrics/results.php">Health Report</a>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/diet/plan.php" class="active">Diet Plan</a>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/exercise/plan.php">Exercise</a>
        </div>
        <div class="nav-right">
            <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
    <div class="message-box">
        <div class="icon">📋</div>
        <h2>State Not Set</h2>
        <p>Please update your metrics and select your state to get a personalized diet plan.</p>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/metrics/save_results.php" class="btn btn-primary">Update Metrics</a>
    </div>
</body>
</html>
<?php
    exit();
}

// ── Set session state for the legacy diet files ────────────
$_SESSION['state'] = $state;

// ── Include the appropriate legacy diet plan file ──────────
// Legacy files read $_SESSION['state'] and render a full HTML page
// with state-specific diet plans for all three goals
// (Weight Loss, Weight Gain, Muscle Gain).
if ($dietType === 'nonveg') {
    include __DIR__ . '/../mixed_diet.php';
} else {
    include __DIR__ . '/../veg_diet.php';
}
