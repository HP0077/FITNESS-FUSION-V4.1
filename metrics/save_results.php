<?php
/**
 * Save Health Metrics
 * 
 * POST handler — accepts measurements, computes derived values,
 * writes to both `metrics` and `weight_history` in a single transaction.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireAuth();

$userId   = sessionGet('user_id');
$userName = sessionGet('user_name', 'User');

// ── GET: Show the metrics input form ───────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Indian states and UTs for the dropdown
    $statesAndUTs = [
        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
        "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
        "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
        "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
        "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
        "Uttar Pradesh", "Uttarakhand", "West Bengal",
        "Andaman & Nicobar Islands", "Chandigarh", "Dadra & Nagar Haveli", "Daman & Diu",
        "Delhi", "Jammu & Kashmir", "Ladakh", "Lakshadweep", "Puducherry"
    ];
    $flashError = $_SESSION['flash_error'] ?? '';
    unset($_SESSION['flash_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Metrics — <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            display: flex; flex-direction: column; align-items: center;
            min-height: 100vh; padding: 0 15px 30px;
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

        .container {
            background: white; padding: 40px 35px; border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06); text-align: center;
            width: 100%; max-width: 600px;
        }
        h1 { color: #1b5e20; margin-bottom: 8px; font-size: 1.75rem; font-weight: 700; }
        .page-subtitle { font-size: 0.88rem; color: #999; margin-bottom: 25px; font-weight: 400; }
        .flash-error { background: #ffebee; color: #c62828; padding: 10px; border-radius: 12px; margin-bottom: 15px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { font-size: 1.05em; color: #333; font-weight: 500; }
        input, select {
            padding: 12px 16px; font-size: 1em; width: 100%; margin-top: 6px;
            border: 2px solid #e0e0e0; border-radius: 12px; box-sizing: border-box;
            font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s;
        }
        input:focus, select:focus { border-color: #43a047; }
        button[type="submit"] {
            background: #2e7d32; color: white; padding: 14px 45px; font-size: 1rem;
            border: none; border-radius: 35px; cursor: pointer; width: 100%;
            font-family: 'Poppins', sans-serif; font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        button[type="submit"]:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }
        .toggle-btn-group { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .toggle-btn {
            width: 48%; background: #e8f5e9; border: 2px solid transparent;
            padding: 12px; border-radius: 35px; cursor: pointer;
            font-size: 0.95em; font-family: 'Poppins', sans-serif;
            font-weight: 500; color: #555; transition: all 0.3s;
        }
        .toggle-btn.active {
            background: #2e7d32; color: white; border-color: #2e7d32;
            box-shadow: 0 4px 15px rgba(46,125,50,0.25);
        }

        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
            .container { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?= BASE_URL ?>/dashboard/dashboard.php" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
        <div class="nav-center">
            <a href="<?= BASE_URL ?>/dashboard/dashboard.php">Dashboard</a>
            <a href="<?= BASE_URL ?>/metrics/save_results.php" class="active">Metrics</a>
            <a href="<?= BASE_URL ?>/metrics/results.php">Health Report</a>
            <a href="<?= BASE_URL ?>/diet/plan.php">Diet Plan</a>
            <a href="<?= BASE_URL ?>/exercise/plan.php">Exercise</a>
        </div>
        <div class="nav-right">
            <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
            <a href="<?= BASE_URL ?>/logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h1>Update Your Metrics</h1>
        <p class="page-subtitle">Enter your latest measurements, <?= htmlspecialchars($userName) ?></p>
        <?php if ($flashError): ?>
            <div class="flash-error"><?= htmlspecialchars($flashError) ?></div>
        <?php endif; ?>
        <form action="<?= BASE_URL ?>/metrics/save_results.php" method="POST">
            <div class="form-group">
                <label for="height">Height</label>
                <div class="toggle-btn-group">
                    <button type="button" class="toggle-btn active" id="toggleCm">Cm</button>
                    <button type="button" class="toggle-btn" id="toggleFeet">Feet</button>
                </div>
                <input type="number" name="height" id="heightInput" placeholder="Enter height in cm" required step="any" />
                <input type="hidden" name="height_unit" id="heightUnit" value="cm" />
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <div class="toggle-btn-group">
                    <button type="button" class="toggle-btn active" id="toggleKg">Kg</button>
                    <button type="button" class="toggle-btn" id="togglePounds">Pounds</button>
                </div>
                <input type="number" name="weight" id="weightInput" placeholder="Enter weight in kg" required step="any" />
                <input type="hidden" name="weight_unit" id="weightUnit" value="kg" />
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" placeholder="Enter your age" required min="1" max="120" />
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="">Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <select name="state" id="state" required>
                    <option value="">Select your state</option>
                    <?php foreach ($statesAndUTs as $s): ?>
                        <option value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="diet_type">Diet Preference</label>
                <select name="diet_type" id="diet_type" required>
                    <option value="">Select Diet Preference</option>
                    <option value="veg">Vegetarian</option>
                    <option value="nonveg">Non-Vegetarian</option>
                </select>
            </div>
            <button type="submit">Save Metrics</button>
        </form>
    </div>
    <script>
        const toggleHeightBtns = [document.getElementById('toggleCm'), document.getElementById('toggleFeet')];
        const toggleWeightBtns = [document.getElementById('toggleKg'), document.getElementById('togglePounds')];
        toggleHeightBtns.forEach(btn => btn.addEventListener('click', () => {
            toggleHeightBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('heightInput').placeholder = btn.id === 'toggleCm' ? 'Enter height in cm' : 'Enter height in feet';
            document.getElementById('heightUnit').value = btn.id === 'toggleCm' ? 'cm' : 'ft';
        }));
        toggleWeightBtns.forEach(btn => btn.addEventListener('click', () => {
            toggleWeightBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('weightInput').placeholder = btn.id === 'toggleKg' ? 'Enter weight in kg' : 'Enter weight in pounds';
            document.getElementById('weightUnit').value = btn.id === 'toggleKg' ? 'kg' : 'lb';
        }));
    </script>
</body>
</html>
<?php
    exit();
}

// ── Collect & Sanitize Inputs ──────────────────────────────
$height     = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
$weight     = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$age        = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$gender     = trim($_POST['gender'] ?? '');
$state      = trim($_POST['state'] ?? '');
$dietType   = filter_input(INPUT_POST, 'diet_type');
$heightUnit = trim($_POST['height_unit'] ?? 'cm');
$weightUnit = trim($_POST['weight_unit'] ?? 'kg');

// ── Validate ───────────────────────────────────────────────
if ($height === false || $weight === false || $age === false
    || $height <= 0 || $weight <= 0 || $age <= 0
    || !in_array($gender, ['male', 'female', 'other'], true)
) {
    $_SESSION['flash_error'] = 'Please fill in all fields with valid values.';
    header('Location: ' . BASE_URL . '/dashboard/dashboard.php');
    exit();
}

// Validate diet type strictly
if (!in_array($dietType, ['veg', 'nonveg'], true)) {
    $_SESSION['flash_error'] = 'Invalid diet type selected.';
    header('Location: ' . BASE_URL . '/metrics/save_results.php');
    exit();
}

// ── Unit Conversion (to cm / kg) ───────────────────────────
if ($heightUnit === 'ft') {
    $height = $height * 30.48;
}
if ($weightUnit === 'lb') {
    $weight = $weight * 0.453592;
}

// ── Derived Calculations ───────────────────────────────────
$heightM = $height / 100;
$bmi     = round($weight / ($heightM * $heightM), 1);

if ($gender === 'male') {
    $bodyFat  = round((1.20 * $bmi) + (0.23 * $age) - 16.2, 1);
    $calories = round(88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age));
} else {
    $bodyFat  = round((1.20 * $bmi) + (0.23 * $age) - 5.4, 1);
    $calories = round(447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));
}

// ── Persist — Transaction across both tables ───────────────
$conn = getDB();

try {
    $conn->beginTransaction();

    // 1. Update user profile (including diet_type)
    $stmtUser = $conn->prepare(
        'UPDATE users
         SET age = :age, gender = :gender, state = :state, diet_type = :diet_type, updated_at = NOW()
         WHERE id = :user_id'
    );
    $stmtUser->execute([
        ':age'       => $age,
        ':gender'    => $gender,
        ':state'     => $state,
        ':diet_type' => $dietType,
        ':user_id'   => $userId,
    ]);

    // 2. Insert full health snapshot into metrics
    $stmtMetrics = $conn->prepare(
        'INSERT INTO metrics (user_id, height, weight, bmi, body_fat, calories)
         VALUES (:user_id, :height, :weight, :bmi, :body_fat, :calories)'
    );
    $stmtMetrics->execute([
        ':user_id'  => $userId,
        ':height'   => $height,
        ':weight'   => $weight,
        ':bmi'      => $bmi,
        ':body_fat' => $bodyFat,
        ':calories' => $calories,
    ]);

    // 3. Append to weight history for trend tracking
    $stmtWeight = $conn->prepare(
        'INSERT INTO weight_history (user_id, weight)
         VALUES (:user_id, :weight)'
    );
    $stmtWeight->execute([
        ':user_id' => $userId,
        ':weight'  => $weight,
    ]);

    $conn->commit();

    // Store state and diet preference in session for diet/exercise pages
    $_SESSION['state']     = $state;
    $_SESSION['diet_type'] = $dietType;

    header('Location: ' . BASE_URL . '/dashboard/dashboard.php');
    exit();

} catch (PDOException $e) {
    $conn->rollBack();
    error_log('[Fitness Fusion] save_results failed: ' . $e->getMessage());

    $_SESSION['flash_error'] = 'Failed to save your metrics. Please try again.';
    header('Location: ' . BASE_URL . '/dashboard/dashboard.php');
    exit();
}
