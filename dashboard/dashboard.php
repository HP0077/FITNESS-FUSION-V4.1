<?php
/**
 * Dashboard — Central Hub
 * 
 * Displays latest health metrics and weight trend for the logged-in user.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireAuth();

$userId   = sessionGet('user_id');
$userName = sessionGet('user_name', 'User');
$conn     = getDB();

// ── Fetch Latest Metrics ───────────────────────────────────
$stmtMetrics = $conn->prepare(
    'SELECT height, weight, bmi, body_fat, calories, created_at
     FROM metrics
     WHERE user_id = :user_id
     ORDER BY created_at DESC
     LIMIT 1'
);
$stmtMetrics->execute([':user_id' => $userId]);
$metrics = $stmtMetrics->fetch();

// ── Fetch Weight History (last 10 entries, oldest first for chart) ──
$stmtWeight = $conn->prepare(
    'SELECT weight, recorded_at
     FROM weight_history
     WHERE user_id = :user_id
     ORDER BY recorded_at DESC
     LIMIT 10'
);
$stmtWeight->execute([':user_id' => $userId]);
$weightHistory = array_reverse($stmtWeight->fetchAll()); // chronological order
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            min-height: 100vh;
            color: #333;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 40px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(14px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
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
        .nav-right .greeting {
            font-size: 0.88rem; color: #777; font-weight: 400;
        }
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

        /* ── Layout ──────────────────────────────────── */
        .dashboard { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .welcome { font-size: 1.75rem; font-weight: 700; margin-bottom: 8px; color: #1b5e20; }
        .welcome-sub { font-size: 0.88rem; color: #999; margin-bottom: 25px; font-weight: 400; }

        /* ── Metric Cards ────────────────────────────── */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 25px 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .card .label { font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .card .value { font-size: 2rem; font-weight: 700; color: #2e7d32; }
        .card .unit  { font-size: 0.8rem; color: #999; }

        /* ── Empty State ─────────────────────────────── */
        .empty-state {
            background: #fff;
            border-radius: 16px;
            padding: 50px 30px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            margin-bottom: 35px;
        }
        .empty-state h2 { color: #666; font-weight: 600; margin-bottom: 10px; }
        .empty-state p { color: #999; margin-bottom: 20px; }
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

        /* ── Weight History Table ─────────────────────── */
        .section-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; color: #333; }
        .weight-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }
        .weight-table th {
            background: #2e7d32; color: #fff; text-align: left;
            padding: 14px 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .weight-table td { padding: 12px 20px; border-bottom: 1px solid #f0f0f0; font-size: 0.95rem; }
        .weight-table tr:last-child td { border-bottom: none; }
        .weight-table tr:hover td { background: #e8f5e9; }

        /* ── Quick Links ─────────────────────────────── */
        .quick-links-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 18px; margin-top: 35px; color: #333; }
        .quick-links {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px; margin-bottom: 40px;
        }
        .quick-links a {
            background: #fff; padding: 24px 22px; border-radius: 16px;
            text-decoration: none; color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s; border: 2px solid transparent;
            display: flex; align-items: center; gap: 16px;
        }
        .quick-links a:hover {
            border-color: #2e7d32; transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(46,125,50,0.12);
        }
        .quick-links a .ql-icon {
            font-size: 1.8rem; width: 50px; height: 50px;
            background: #e8f5e9; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .quick-links a .ql-text { display: flex; flex-direction: column; }
        .quick-links a .ql-label {
            font-weight: 700; font-size: 0.95rem; color: #1b5e20;
        }
        .quick-links a .ql-desc {
            font-size: 0.78rem; color: #999; margin-top: 2px; font-weight: 400;
        }

        /* ── Updated At ──────────────────────────────── */
        .updated-at { font-size: 0.8rem; color: #aaa; margin-bottom: 25px; }

        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
            .dashboard { padding: 0 15px; }
        }
    </style>
</head>
<body>

<!-- ── Navbar ─────────────────────────────────────────────── -->
<nav class="navbar">
    <a href="<?= BASE_URL ?>/dashboard/dashboard.php" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
    <div class="nav-center">
        <a href="<?= BASE_URL ?>/dashboard/dashboard.php" class="active">Dashboard</a>
        <a href="<?= BASE_URL ?>/metrics/save_results.php">Metrics</a>
        <a href="<?= BASE_URL ?>/metrics/results.php">Health Report</a>
        <a href="<?= BASE_URL ?>/diet/plan.php">Diet Plan</a>
        <a href="<?= BASE_URL ?>/exercise/plan.php">Exercise</a>
    </div>
    <div class="nav-right">
        <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
        <a href="<?= BASE_URL ?>/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="dashboard">
    <h1 class="welcome">Your Dashboard</h1>
    <p class="welcome-sub">Track your health journey at a glance</p>

    <?php if ($metrics): ?>
        <!-- ── Metric Cards ──────────────────────────── -->
        <p class="updated-at">
            Last updated: <?= htmlspecialchars(date('M j, Y \a\t g:i A', strtotime($metrics['created_at']))) ?>
        </p>

        <div class="cards">
            <div class="card">
                <div class="label">BMI</div>
                <div class="value"><?= number_format((float) $metrics['bmi'], 1) ?></div>
                <div class="unit">kg/m²</div>
            </div>
            <div class="card">
                <div class="label">Weight</div>
                <div class="value"><?= number_format((float) $metrics['weight'], 1) ?></div>
                <div class="unit">kg</div>
            </div>
            <div class="card">
                <div class="label">Height</div>
                <div class="value"><?= number_format((float) $metrics['height'], 1) ?></div>
                <div class="unit">cm</div>
            </div>
            <div class="card">
                <div class="label">Body Fat</div>
                <div class="value"><?= $metrics['body_fat'] !== null ? number_format((float) $metrics['body_fat'], 1) : '—' ?></div>
                <div class="unit">%</div>
            </div>
            <div class="card">
                <div class="label">Calories (BMR)</div>
                <div class="value"><?= $metrics['calories'] !== null ? number_format((int) $metrics['calories']) : '—' ?></div>
                <div class="unit">kcal/day</div>
            </div>
        </div>

    <?php else: ?>
        <!-- ── Empty State ───────────────────────────── -->
        <div class="empty-state">
            <h2>No metrics recorded yet</h2>
            <p>Enter your height, weight, and age to see your health dashboard.</p>
            <a href="<?= BASE_URL ?>/metrics/save_results.php" class="cta">Add Your Metrics</a>
        </div>
    <?php endif; ?>

    <!-- ── Weight History ────────────────────────────── -->
    <?php if (!empty($weightHistory)): ?>
        <h2 class="section-title">Weight History</h2>
        <table class="weight-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Weight</th>
                    <th>Recorded</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($weightHistory as $i => $entry): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= number_format((float) $entry['weight'], 1) ?> kg</td>
                        <td><?= htmlspecialchars(date('M j, Y', strtotime($entry['recorded_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- ── Quick Navigation ──────────────────────────── -->
    <h2 class="quick-links-title">Quick Navigation</h2>
    <div class="quick-links">
        <a href="<?= BASE_URL ?>/metrics/save_results.php">
            <div class="ql-icon">📝</div>
            <div class="ql-text">
                <span class="ql-label">Update Metrics</span>
                <span class="ql-desc">Height, weight, age &amp; preferences</span>
            </div>
        </a>
        <a href="<?= BASE_URL ?>/metrics/results.php">
            <div class="ql-icon">📊</div>
            <div class="ql-text">
                <span class="ql-label">Health Report</span>
                <span class="ql-desc">BMI, body fat &amp; composition</span>
            </div>
        </a>
        <a href="<?= BASE_URL ?>/diet/plan.php">
            <div class="ql-icon">🥗</div>
            <div class="ql-text">
                <span class="ql-label">Diet Plan</span>
                <span class="ql-desc">State-wise nutrition guide</span>
            </div>
        </a>
        <a href="<?= BASE_URL ?>/exercise/plan.php">
            <div class="ql-icon">🏋️</div>
            <div class="ql-text">
                <span class="ql-label">Exercise Plan</span>
                <span class="ql-desc">Age-based workout routines</span>
            </div>
        </a>
    </div>
</div>

</body>
</html>
