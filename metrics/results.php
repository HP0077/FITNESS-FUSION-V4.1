<?php
/**
 * Detailed Health Report
 * 
 * Reads pre-computed values from the metrics table — no recalculation.
 * Derives BMI category and secondary estimates on the read side only.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireAuth();

$userId   = sessionGet('user_id');
$userName = sessionGet('user_name', 'User');
$conn     = getDB();

// ── Fetch latest metrics snapshot ──────────────────────────
$stmt = $conn->prepare(
    'SELECT height, weight, bmi, body_fat, calories, created_at
     FROM metrics
     WHERE user_id = :user_id
     ORDER BY created_at DESC
     LIMIT 1'
);
$stmt->execute([':user_id' => $userId]);
$m = $stmt->fetch();

// ── Fetch user profile for secondary estimates ─────────────
$stmtUser = $conn->prepare('SELECT age, gender FROM users WHERE id = :id LIMIT 1');
$stmtUser->execute([':id' => $userId]);
$user = $stmtUser->fetch();

// ── BMI Category (derived from stored BMI) ─────────────────
$bmiCategory = '—';
$bmiColor    = '#999';
if ($m) {
    $bmi = (float) $m['bmi'];
    if ($bmi < 18.5) {
        $bmiCategory = 'Underweight';  $bmiColor = '#87CEEB';
    } elseif ($bmi <= 24.9) {
        $bmiCategory = 'Normal';       $bmiColor = '#32CD32';
    } elseif ($bmi <= 29.9) {
        $bmiCategory = 'Overweight';   $bmiColor = '#FFD700';
    } elseif ($bmi <= 34.9) {
        $bmiCategory = 'Obese';        $bmiColor = '#FF8C00';
    } else {
        $bmiCategory = 'Extremely Obese'; $bmiColor = '#FF4500';
    }

    // Secondary estimates (cheap math, no DB write needed)
    $weight          = (float) $m['weight'];
    $height          = (float) $m['height'];
    $bodyFat         = (float) $m['body_fat'];
    $calories        = (int) $m['calories'];
    $fatFreeWeight   = round($weight * (1 - $bodyFat / 100), 1);
    $visceralFat     = round(max(1, $bodyFat * 0.10), 1);
    $muscleMass      = round(100 - $bodyFat, 1);
    $gender          = $user['gender'] ?? 'male';
    $bodyWater       = round($weight * ($gender === 'male' ? 0.60 : 0.55), 1);
    $proteinIntake   = round($weight * 1.5, 0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Report — <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center;
            padding: 0 15px 30px;
            color: #333;
        }

        /* ── Navbar ──────────────────────────────────── */
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

        /* ── Card ────────────────────────────────────── */
        .report-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 35px;
            width: 100%; max-width: 800px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }
        .report-card h1 {
            color: #1b5e20; font-size: 1.75rem; font-weight: 700; margin-bottom: 8px;
        }
        .report-card .subtitle {
            font-size: 0.88rem; color: #999; margin-bottom: 25px;
        }

        /* ── Table ───────────────────────────────────── */
        .metrics-table { width: 100%; border-collapse: collapse; }
        .metrics-table th {
            background: #2e7d32; color: #fff; text-align: left;
            padding: 13px 18px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .metrics-table td {
            padding: 13px 18px; border-bottom: 1px solid #f0f0f0; font-size: 0.95rem;
        }
        .metrics-table tr:hover td { background: #e8f5e9; }
        .metrics-table tr:last-child td { border-bottom: none; }
        .bmi-badge {
            display: inline-block; padding: 3px 12px; border-radius: 12px;
            font-size: 0.8rem; font-weight: 600; color: #fff; margin-left: 8px;
        }

        /* ── Empty State ─────────────────────────────── */
        .empty-state {
            text-align: center; padding: 60px 20px;
        }
        .empty-state h2 { color: #666; margin-bottom: 10px; }
        .empty-state p  { color: #999; margin-bottom: 20px; }
        .empty-state a.cta {
            display: inline-block; background: #2e7d32; color: #fff;
            padding: 14px 38px; border-radius: 35px; text-decoration: none;
            font-weight: 600; transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        .empty-state a.cta:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }

        /* ── Action Buttons ──────────────────────────── */
        .actions {
            display: flex; gap: 15px; margin-top: 30px; flex-wrap: wrap;
        }
        .actions a {
            padding: 14px 32px; border-radius: 35px; text-decoration: none;
            font-weight: 600; font-size: 0.9rem; transition: all 0.3s;
        }
        .btn-primary {
            background: #2e7d32; color: #fff;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        .btn-primary:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }
        .btn-outline {
            background: #fff; color: #2e7d32; border: 2px solid #2e7d32;
        }
        .btn-outline:hover {
            background: #2e7d32; color: #fff; transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
            .report-card { padding: 25px 18px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="<?= BASE_URL ?>/dashboard/dashboard.php" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
    <div class="nav-center">
        <a href="<?= BASE_URL ?>/dashboard/dashboard.php">Dashboard</a>
        <a href="<?= BASE_URL ?>/metrics/save_results.php">Metrics</a>
        <a href="<?= BASE_URL ?>/metrics/results.php" class="active">Health Report</a>
        <a href="<?= BASE_URL ?>/diet/plan.php">Diet Plan</a>
        <a href="<?= BASE_URL ?>/exercise/plan.php">Exercise</a>
    </div>
    <div class="nav-right">
        <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
        <a href="<?= BASE_URL ?>/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="report-card">
    <h1>Detailed Health Report</h1>

    <?php if ($m): ?>
        <p class="subtitle">
            Recorded <?= htmlspecialchars(date('M j, Y \a\t g:i A', strtotime($m['created_at']))) ?>
        </p>

        <table class="metrics-table">
            <thead>
                <tr><th>Metric</th><th>Value</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Height</td>
                    <td><?= htmlspecialchars(number_format($height, 1)) ?> cm</td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td><?= htmlspecialchars(number_format($weight, 1)) ?> kg</td>
                </tr>
                <tr>
                    <td>BMI</td>
                    <td>
                        <?= htmlspecialchars(number_format($bmi, 1)) ?>
                        <span class="bmi-badge" style="background:<?= $bmiColor ?>">
                            <?= htmlspecialchars($bmiCategory) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Body Fat</td>
                    <td><?= htmlspecialchars(number_format($bodyFat, 1)) ?>%</td>
                </tr>
                <tr>
                    <td>Fat-Free Weight</td>
                    <td><?= htmlspecialchars(number_format($fatFreeWeight, 1)) ?> kg</td>
                </tr>
                <tr>
                    <td>Visceral Fat</td>
                    <td><?= htmlspecialchars(number_format($visceralFat, 1)) ?>%</td>
                </tr>
                <tr>
                    <td>Muscle Mass</td>
                    <td><?= htmlspecialchars(number_format($muscleMass, 1)) ?>%</td>
                </tr>
                <tr>
                    <td>Body Water</td>
                    <td><?= htmlspecialchars(number_format($bodyWater, 1)) ?> L</td>
                </tr>
                <tr>
                    <td>Protein Intake</td>
                    <td><?= htmlspecialchars(number_format($proteinIntake)) ?> g/day</td>
                </tr>
                <tr>
                    <td>BMR (Calories)</td>
                    <td><?= htmlspecialchars(number_format($calories)) ?> kcal/day</td>
                </tr>
            </tbody>
        </table>

        <div class="actions">
            <a href="<?= BASE_URL ?>/diet/plan.php" class="btn-primary">View Diet Plans</a>
            <a href="<?= BASE_URL ?>/exercise/plan.php" class="btn-outline">Exercise Plans</a>
        </div>

    <?php else: ?>
        <div class="empty-state">
            <h2>No metrics recorded yet</h2>
            <p>Enter your measurements to generate your full health report.</p>
            <a href="<?= BASE_URL ?>/metrics/save_results.php" class="cta">Add Metrics</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
