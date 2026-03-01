<?php
/**
 * Personalized Exercise Plan Router
 * 
 * Fetches the user's age from the database, determines their age group,
 * and renders tailored exercise routines for Weight Loss, Weight Gain,
 * and Muscle Gain goals.
 *
 * Age Groups:
 *   Group 1 — 15–25 (Young Adult)
 *   Group 2 — 26–50 (Adult)
 *   Group 3 — 51–75 (Senior)
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireAuth();

$userId   = sessionGet('user_id');
$userName = sessionGet('user_name', 'User');
$conn     = getDB();

// ── Fetch user age ─────────────────────────────────────────
$stmt = $conn->prepare('SELECT age FROM users WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch();

$age = $user['age'] ?? null;

// ── Guard: age must be set via metrics ─────────────────────
if (empty($age)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Plan — <?= htmlspecialchars(APP_NAME) ?></title>
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
            <a href="<?= htmlspecialchars(BASE_URL) ?>/diet/plan.php">Diet Plan</a>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/exercise/plan.php" class="active">Exercise</a>
        </div>
        <div class="nav-right">
            <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
    <div class="message-box">
        <div class="icon">🏃</div>
        <h2>Age Not Set</h2>
        <p>Please update your metrics and enter your age to get a personalized exercise plan.</p>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/metrics/save_results.php" class="btn btn-primary">Update Metrics</a>
    </div>
</body>
</html>
<?php
    exit();
}

// ── Determine age group ────────────────────────────────────
$age = (int) $age;
if ($age >= 15 && $age <= 25) {
    $ageGroup  = 'group1';
    $groupName = 'Young Adult (15–25)';
} elseif ($age >= 26 && $age <= 50) {
    $ageGroup  = 'group2';
    $groupName = 'Adult (26–50)';
} elseif ($age >= 51 && $age <= 75) {
    $ageGroup  = 'group3';
    $groupName = 'Senior (51–75)';
} else {
    // Fallback for ages outside defined ranges
    if ($age < 15) {
        $ageGroup  = 'group1';
        $groupName = 'Young Adult (15–25)';
    } else {
        $ageGroup  = 'group3';
        $groupName = 'Senior (51–75)';
    }
}

// ── Exercise Plan Data by Age Group ────────────────────────
$exercisePlans = [
    'group1' => [
        [
            'name'      => 'Weight Loss',
            'goal'      => 'High-intensity fat burning for young adults',
            'icon'      => '🔥',
            'color'     => '#e65100',
            'frequency' => '5–6 days/week — 40 to 50 minutes per session',
            'exercises' => [
                ['name' => 'Burpees',              'sets' => '4 sets', 'reps' => '12–15 reps',    'frequency' => '5×/week', 'notes' => 'Full range of motion, explosive jump at top'],
                ['name' => 'Mountain Climbers',     'sets' => '4 sets', 'reps' => '40 seconds',    'frequency' => '5×/week', 'notes' => 'Keep core tight, fast pace'],
                ['name' => 'Jump Squats',           'sets' => '4 sets', 'reps' => '15 reps',       'frequency' => '5×/week', 'notes' => 'Land softly, immediate rebound'],
                ['name' => 'High Knees',            'sets' => '3 sets', 'reps' => '45 seconds',    'frequency' => '5×/week', 'notes' => 'Drive knees to chest height'],
                ['name' => 'Box Jumps / Step-ups',  'sets' => '3 sets', 'reps' => '12 reps',       'frequency' => '4×/week', 'notes' => 'Use sturdy surface, step down to protect knees'],
                ['name' => 'Plank Hold',            'sets' => '3 sets', 'reps' => '60 seconds',    'frequency' => '5×/week', 'notes' => 'Maintain straight line from head to heels'],
            ],
            'notes' => 'Keep rest between sets to 15–25 seconds. Aim for heart rate 140–170 BPM. Young adults can handle HIIT circuits — group exercises into 2-minute rounds with 30s rest.',
        ],
        [
            'name'      => 'Weight Gain',
            'goal'      => 'Build overall mass through compound bodyweight movements',
            'icon'      => '💪',
            'color'     => '#c2185b',
            'frequency' => '4–5 days/week — 45 to 55 minutes per session',
            'exercises' => [
                ['name' => 'Push-ups (Wide Grip)',    'sets' => '4 sets', 'reps' => '15–20 reps',   'frequency' => '4×/week', 'notes' => 'Slow eccentric (3 seconds down)'],
                ['name' => 'Pull-ups / Chin-ups',     'sets' => '4 sets', 'reps' => '8–12 reps',    'frequency' => '4×/week', 'notes' => 'Use resistance band for assistance if needed'],
                ['name' => 'Bodyweight Squats',        'sets' => '4 sets', 'reps' => '20 reps',      'frequency' => '4×/week', 'notes' => 'Add backpack with books for resistance'],
                ['name' => 'Dips (Chair-assisted)',    'sets' => '4 sets', 'reps' => '12–15 reps',   'frequency' => '4×/week', 'notes' => 'Go below 90° for full stretch'],
                ['name' => 'Lunges (Weighted)',        'sets' => '3 sets', 'reps' => '12 per leg',   'frequency' => '3×/week', 'notes' => 'Hold water bottles or backpack for weight'],
                ['name' => 'Plank to Push-up',         'sets' => '3 sets', 'reps' => '12 reps',      'frequency' => '4×/week', 'notes' => 'Alternate leading arm each set'],
            ],
            'notes' => 'Rest 60–90 seconds between sets. Focus on slow, controlled reps to maximize time under tension. Eat a calorie surplus — 300–500 kcal above BMR. Consume protein shake within 1 hour of finishing.',
        ],
        [
            'name'      => 'Muscle Gain',
            'goal'      => 'Hypertrophy through progressive overload for young physiques',
            'icon'      => '🏋️',
            'color'     => '#00695c',
            'frequency' => '5–6 days/week — 50 to 65 minutes per session',
            'exercises' => [
                ['name' => 'Diamond Push-ups',           'sets' => '4 sets', 'reps' => '12–15 reps',    'frequency' => '5×/week', 'notes' => 'Targets triceps and inner chest'],
                ['name' => 'Bulgarian Split Squats',     'sets' => '4 sets', 'reps' => '10 per leg',    'frequency' => '4×/week', 'notes' => 'Elevate rear foot on chair/bench'],
                ['name' => 'Pull-ups / Inverted Rows',   'sets' => '4 sets', 'reps' => '10–12 reps',    'frequency' => '5×/week', 'notes' => 'Squeeze at top for 2 seconds'],
                ['name' => 'Pike Push-ups',              'sets' => '4 sets', 'reps' => '10–12 reps',    'frequency' => '4×/week', 'notes' => 'Progress toward handstand push-ups'],
                ['name' => 'Single-leg Glute Bridge',    'sets' => '3 sets', 'reps' => '15 per leg',    'frequency' => '4×/week', 'notes' => 'Squeeze glutes at top for 3 seconds'],
                ['name' => 'Superman Holds',             'sets' => '3 sets', 'reps' => '30 seconds',    'frequency' => '5×/week', 'notes' => 'Lift arms and legs simultaneously'],
                ['name' => 'Hanging Leg Raises',         'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '4×/week', 'notes' => 'Control the negative, avoid swinging'],
            ],
            'notes' => 'Split into Push/Pull/Legs if training 6 days. Increase reps or add resistance (backpack with books) every 2 weeks. Rest 60–90 seconds between sets. Protein intake: 1.6–2.0g per kg of bodyweight.',
        ],
    ],

    'group2' => [
        [
            'name'      => 'Weight Loss',
            'goal'      => 'Sustainable fat burning with joint-friendly movements',
            'icon'      => '🔥',
            'color'     => '#e65100',
            'frequency' => '4–5 days/week — 35 to 45 minutes per session',
            'exercises' => [
                ['name' => 'Brisk Walking / Light Jog', 'sets' => '1 set',  'reps' => '20 minutes',    'frequency' => '5×/week', 'notes' => 'Warm up for 5 min, then maintain moderate intensity'],
                ['name' => 'Jumping Jacks',              'sets' => '3 sets', 'reps' => '30 seconds',    'frequency' => '4×/week', 'notes' => 'Low-impact version: step out instead of jump'],
                ['name' => 'Bodyweight Squats',           'sets' => '3 sets', 'reps' => '15 reps',       'frequency' => '4×/week', 'notes' => 'Keep knees aligned with toes'],
                ['name' => 'Mountain Climbers (Slow)',    'sets' => '3 sets', 'reps' => '30 seconds',    'frequency' => '4×/week', 'notes' => 'Controlled pace to protect lower back'],
                ['name' => 'Plank Hold',                  'sets' => '3 sets', 'reps' => '45 seconds',    'frequency' => '4×/week', 'notes' => 'Modified on knees if needed initially'],
                ['name' => 'Step-ups',                    'sets' => '3 sets', 'reps' => '12 per leg',    'frequency' => '3×/week', 'notes' => 'Use stairs or sturdy step (30–40 cm)'],
            ],
            'notes' => 'Rest 30–45 seconds between sets. Target heart rate 120–150 BPM. Warm up thoroughly to protect joints. Combine with dietary calorie deficit for best results.',
        ],
        [
            'name'      => 'Weight Gain',
            'goal'      => 'Build mass with controlled compound movements',
            'icon'      => '💪',
            'color'     => '#c2185b',
            'frequency' => '4 days/week — 40 to 50 minutes per session',
            'exercises' => [
                ['name' => 'Push-ups (Standard)',       'sets' => '4 sets', 'reps' => '12–15 reps',   'frequency' => '4×/week', 'notes' => '3-second eccentric phase'],
                ['name' => 'Bodyweight Squats',          'sets' => '4 sets', 'reps' => '15 reps',      'frequency' => '4×/week', 'notes' => 'Full depth, pause at bottom for 1 second'],
                ['name' => 'Glute Bridges',              'sets' => '3 sets', 'reps' => '15 reps',      'frequency' => '3×/week', 'notes' => 'Hold at top for 2 seconds'],
                ['name' => 'Pike Push-ups',              'sets' => '3 sets', 'reps' => '10–12 reps',   'frequency' => '3×/week', 'notes' => 'Targets shoulders, progress to decline'],
                ['name' => 'Lunges',                     'sets' => '3 sets', 'reps' => '12 per leg',   'frequency' => '3×/week', 'notes' => 'Maintain upright torso throughout'],
                ['name' => 'Plank',                      'sets' => '3 sets', 'reps' => '60 seconds',   'frequency' => '4×/week', 'notes' => 'Engage core, don\'t let hips sag'],
            ],
            'notes' => 'Rest 60–90 seconds between sets. Focus on slow, controlled reps. Eat within 1 hour of finishing. Calorie surplus of 250–400 kcal above BMR recommended.',
        ],
        [
            'name'      => 'Muscle Gain',
            'goal'      => 'Hypertrophy with progressive overload for maintained joints',
            'icon'      => '🏋️',
            'color'     => '#00695c',
            'frequency' => '4–5 days/week — 45 to 55 minutes per session',
            'exercises' => [
                ['name' => 'Diamond Push-ups',           'sets' => '4 sets', 'reps' => '10–12 reps',    'frequency' => '4×/week', 'notes' => 'Modify on knees if shoulder discomfort'],
                ['name' => 'Bulgarian Split Squats',     'sets' => '4 sets', 'reps' => '10 per leg',    'frequency' => '3×/week', 'notes' => 'Use chair/couch for rear foot'],
                ['name' => 'Inverted Rows (Table)',      'sets' => '4 sets', 'reps' => '10–12 reps',    'frequency' => '4×/week', 'notes' => 'Lie under sturdy table, pull chest up'],
                ['name' => 'Dips (Chair-assisted)',      'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Don\'t go too deep — protect shoulders'],
                ['name' => 'Single-leg Glute Bridge',    'sets' => '3 sets', 'reps' => '12 per leg',    'frequency' => '3×/week', 'notes' => 'Squeeze glutes at top for 3 seconds'],
                ['name' => 'Superman Holds',             'sets' => '3 sets', 'reps' => '25 seconds',    'frequency' => '4×/week', 'notes' => 'Strengthens lower back, hold steady'],
            ],
            'notes' => 'Progress every 2 weeks by adding reps or resistance. Split into Upper/Lower if training 5 days. Rest 60–90 seconds between sets. Protein: 1.4–1.8g per kg bodyweight.',
        ],
    ],

    'group3' => [
        [
            'name'      => 'Weight Loss',
            'goal'      => 'Gentle fat burning with low-impact movements for joint safety',
            'icon'      => '🔥',
            'color'     => '#e65100',
            'frequency' => '3–4 days/week — 25 to 35 minutes per session',
            'exercises' => [
                ['name' => 'Brisk Walking',              'sets' => '1 set',  'reps' => '20–25 minutes', 'frequency' => '4×/week', 'notes' => 'Flat surface preferred, supportive footwear'],
                ['name' => 'Seated Marching',            'sets' => '3 sets', 'reps' => '30 seconds',    'frequency' => '3×/week', 'notes' => 'Sit on chair, lift knees alternately'],
                ['name' => 'Wall Push-ups',              'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Arm\'s length from wall, controlled pace'],
                ['name' => 'Chair Squats',               'sets' => '3 sets', 'reps' => '10 reps',       'frequency' => '3×/week', 'notes' => 'Lower until lightly touching chair, then stand'],
                ['name' => 'Standing Calf Raises',       'sets' => '3 sets', 'reps' => '12 reps',       'frequency' => '3×/week', 'notes' => 'Hold chair for balance if needed'],
                ['name' => 'Seated Leg Extensions',      'sets' => '3 sets', 'reps' => '10 per leg',    'frequency' => '3×/week', 'notes' => 'Straighten one leg at a time from seated position'],
            ],
            'notes' => 'Rest 45–60 seconds between sets. Focus on breathing — exhale on effort, inhale on return. Stop immediately if you feel dizzy or short of breath. Consult a doctor before starting any new routine.',
        ],
        [
            'name'      => 'Weight Gain',
            'goal'      => 'Build healthy mass with safe, low-impact resistance training',
            'icon'      => '💪',
            'color'     => '#c2185b',
            'frequency' => '3 days/week — 30 to 40 minutes per session',
            'exercises' => [
                ['name' => 'Wall Push-ups',              'sets' => '3 sets', 'reps' => '12–15 reps',    'frequency' => '3×/week', 'notes' => 'Progress to incline push-ups over weeks'],
                ['name' => 'Chair-assisted Squats',      'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Use chair arms for stability'],
                ['name' => 'Seated Bicep Curls',         'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Use water bottles (500ml–1L) as weights'],
                ['name' => 'Standing Side Leg Raises',   'sets' => '3 sets', 'reps' => '10 per leg',    'frequency' => '3×/week', 'notes' => 'Hold chair for balance, slow and controlled'],
                ['name' => 'Seated Shoulder Press',      'sets' => '3 sets', 'reps' => '10 reps',       'frequency' => '3×/week', 'notes' => 'Use light weights or water bottles'],
                ['name' => 'Gentle Glute Bridges',       'sets' => '3 sets', 'reps' => '10 reps',       'frequency' => '3×/week', 'notes' => 'Lift hips slowly, squeeze at top'],
            ],
            'notes' => 'Rest 60–90 seconds between sets. Focus on calorie-dense nutritious foods — nuts, dairy, ghee, whole grains. Eat small frequent meals (5–6 per day). Stay hydrated.',
        ],
        [
            'name'      => 'Muscle Gain',
            'goal'      => 'Maintain and build lean muscle with safe progressive resistance',
            'icon'      => '🏋️',
            'color'     => '#00695c',
            'frequency' => '3–4 days/week — 30 to 40 minutes per session',
            'exercises' => [
                ['name' => 'Incline Push-ups (Counter)', 'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Use kitchen counter or sturdy table'],
                ['name' => 'Chair Squats (Slow)',        'sets' => '3 sets', 'reps' => '10 reps',       'frequency' => '3×/week', 'notes' => '3-second descent, pause at bottom'],
                ['name' => 'Resistance Band Rows',       'sets' => '3 sets', 'reps' => '10–12 reps',    'frequency' => '3×/week', 'notes' => 'Loop band around sturdy post, pull to chest'],
                ['name' => 'Standing Calf Raises',       'sets' => '3 sets', 'reps' => '15 reps',       'frequency' => '3×/week', 'notes' => 'Hold at top for 2 seconds'],
                ['name' => 'Seated Overhead Press',      'sets' => '3 sets', 'reps' => '10 reps',       'frequency' => '3×/week', 'notes' => 'Use light dumbbells or filled water bottles'],
                ['name' => 'Gentle Superman',            'sets' => '3 sets', 'reps' => '15 seconds',    'frequency' => '3×/week', 'notes' => 'Lift arms and legs just 2–3 inches off ground'],
            ],
            'notes' => 'Progress very gradually — add 1–2 reps per week. Never push through joint pain. Protein intake: 1.2–1.5g per kg bodyweight. Consider consulting a physiotherapist for personalized modifications.',
        ],
    ],
];

// ── General tips by age group ──────────────────────────────
$generalTips = [
    'group1' => [
        'Warm up for 5 minutes — dynamic stretches and light jogging.',
        'Cool down with 5 minutes of static stretching to prevent soreness.',
        'Stay hydrated — drink 500ml water 30 minutes before training.',
        'Track your workouts in a notebook or app to monitor progress.',
        'Get 7–8 hours of sleep. Growth hormone peaks during deep sleep.',
        'Consider creatine supplementation for muscle gain (consult a professional first).',
    ],
    'group2' => [
        'Warm up for 5–7 minutes — brisk walk and dynamic stretches.',
        'Cool down thoroughly — tight muscles recover slower after 30.',
        'Stay hydrated — drink water before, during, and after exercise.',
        'Listen to your body — sharp pain means stop immediately.',
        'Rest days are essential — at least 2 per week for recovery.',
        'Get 7–8 hours of sleep. Recovery quality matters more with age.',
    ],
    'group3' => [
        'Warm up for 8–10 minutes with gentle walking and arm circles.',
        'Always cool down — slow walking and gentle stretches for 5–10 min.',
        'Keep water nearby at all times during exercise.',
        'Never hold your breath during exercises — breathe steadily.',
        'If you have any medical conditions, consult your doctor before starting.',
        'Exercise with a partner or keep your phone nearby for safety.',
        'Focus on functional fitness — movements that help daily activities.',
    ],
];

// Get current group plans and tips
$currentPlans = $exercisePlans[$ageGroup];
$currentTips  = $generalTips[$ageGroup];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Plan — <?= htmlspecialchars(APP_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            min-height: 100vh;
            padding: 0 15px 30px;
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
            margin: 0 -15px 25px;
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
            max-width: 960px; margin: 0 auto;
            background: #fff; border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }
        .container h1 { color: #1b5e20; font-size: 1.75rem; font-weight: 700; margin-bottom: 8px; }
        .container .subtitle { color: #999; font-size: 0.88rem; margin-bottom: 10px; }
        .age-badge {
            display: inline-block; background: #e8f5e9; color: #2e7d32;
            padding: 5px 18px; border-radius: 35px; font-size: 0.85rem;
            font-weight: 600; margin-bottom: 30px;
        }

        /* ── Plan Card ───────────────────────────────── */
        .plan-card {
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 25px;
            transition: transform 0.2s;
        }
        .plan-card:hover { transform: translateX(4px); }
        .plan-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 6px; flex-wrap: wrap; gap: 6px;
        }
        .plan-header h2 { font-size: 1.25rem; font-weight: 700; }
        .plan-header .freq {
            font-size: 0.78rem; font-weight: 600; padding: 3px 12px;
            border-radius: 10px; background: rgba(255,255,255,0.7);
        }
        .plan-goal { font-size: 0.85rem; color: #666; margin-bottom: 14px; }

        /* ── Exercise Grid ───────────────────────────── */
        .exercise-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
            margin-top: 12px;
        }
        .exercise-card {
            background: rgba(255,255,255,0.85);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .exercise-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .exercise-card h3 {
            font-size: 0.95rem; margin-bottom: 10px; color: #333; font-weight: 600;
        }
        .exercise-card .detail {
            display: flex; justify-content: space-between;
            font-size: 0.82rem; color: #666; margin: 4px 0;
        }
        .exercise-card .detail .label { font-weight: 600; color: #555; }
        .exercise-card .note {
            font-size: 0.78rem; color: #888; font-style: italic;
            margin-top: 8px; padding-top: 8px; border-top: 1px dashed #e0e0e0;
        }

        .plan-note {
            margin-top: 14px; font-size: 0.82rem; color: #777;
            font-style: italic; border-top: 1px solid rgba(0,0,0,0.06);
            padding-top: 10px;
        }

        /* ── Tips ────────────────────────────────────── */
        .tips {
            background: #e8f5e9; border-radius: 16px;
            padding: 25px; margin-top: 30px;
        }
        .tips h2 { color: #2e7d32; font-size: 1.1rem; margin-bottom: 12px; font-weight: 700; }
        .tips li { margin: 6px 0; font-size: 0.9rem; color: #555; line-height: 1.6; }

        /* ── Bottom Links ────────────────────────────── */
        .bottom-links {
            display: flex; justify-content: center; gap: 15px;
            flex-wrap: wrap; margin-top: 30px;
        }
        .bottom-links a {
            padding: 14px 30px; border-radius: 35px; text-decoration: none;
            font-weight: 600; font-size: 0.88rem; transition: all 0.3s;
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

        @media (max-width: 600px) {
            .navbar { padding: 12px 16px; margin: 0 -15px 20px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
            .container { padding: 25px 18px; }
            .container h1 { font-size: 1.5rem; }
            .plan-header { flex-direction: column; align-items: flex-start; }
            .exercise-grid { grid-template-columns: 1fr; }
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
        <a href="<?= htmlspecialchars(BASE_URL) ?>/diet/plan.php">Diet Plan</a>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/exercise/plan.php" class="active">Exercise</a>
    </div>
    <div class="nav-right">
        <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="container">
    <h1>🏃 Personalized Exercise Plan</h1>
    <p class="subtitle">Tailored for your age, <?= htmlspecialchars($userName) ?>.</p>
    <span class="age-badge">Age: <?= (int) $age ?> — <?= htmlspecialchars($groupName) ?></span>

    <?php foreach ($currentPlans as $plan): ?>
        <div class="plan-card" style="background: <?= htmlspecialchars($plan['color']) ?>12; border-left: 5px solid <?= htmlspecialchars($plan['color']) ?>;">
            <div class="plan-header">
                <h2 style="color: <?= htmlspecialchars($plan['color']) ?>;">
                    <?= htmlspecialchars($plan['icon'] . ' ' . $plan['name']) ?>
                </h2>
                <span class="freq" style="color: <?= htmlspecialchars($plan['color']) ?>;">
                    <?= htmlspecialchars($plan['frequency']) ?>
                </span>
            </div>
            <p class="plan-goal"><?= htmlspecialchars($plan['goal']) ?></p>

            <div class="exercise-grid">
                <?php foreach ($plan['exercises'] as $ex): ?>
                    <div class="exercise-card">
                        <h3><?= htmlspecialchars($ex['name']) ?></h3>
                        <div class="detail">
                            <span class="label">Sets</span>
                            <span><?= htmlspecialchars($ex['sets']) ?></span>
                        </div>
                        <div class="detail">
                            <span class="label">Reps</span>
                            <span><?= htmlspecialchars($ex['reps']) ?></span>
                        </div>
                        <div class="detail">
                            <span class="label">Frequency</span>
                            <span><?= htmlspecialchars($ex['frequency']) ?></span>
                        </div>
                        <p class="note"><?= htmlspecialchars($ex['notes']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <p class="plan-note"><?= htmlspecialchars($plan['notes']) ?></p>
        </div>
    <?php endforeach; ?>

    <div class="tips">
        <h2>💡 Training Tips for <?= htmlspecialchars($groupName) ?></h2>
        <ul>
            <?php foreach ($currentTips as $tip): ?>
                <li><?= htmlspecialchars($tip) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="bottom-links">
        <a href="<?= htmlspecialchars(BASE_URL) ?>/diet/plan.php" class="btn-primary">View Diet Plans</a>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/metrics/save_results.php" class="btn-outline">Update Metrics</a>
    </div>
</div>

</body>
</html>
