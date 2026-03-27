<?php
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Fusion — Your Personalized Health Companion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            position: fixed; top: 0; width: 100%; z-index: 100;
            display: flex; justify-content: space-between; align-items: center;
            padding: 18px 40px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            transition: padding 0.3s;
        }
        .navbar.scrolled { padding: 12px 40px; }
        .navbar .brand {
            font-size: 1.5rem; font-weight: 800; color: #2e7d32;
            text-decoration: none; letter-spacing: -0.5px;
            display: flex; align-items: center;
        }
        .navbar .brand img { height: 44px; width: auto; margin-right: 10px; }
        .navbar .brand span { color: #43a047; }
        .nav-links { display: flex; gap: 30px; align-items: center; }
        .nav-links a {
            text-decoration: none; color: #555; font-weight: 500;
            font-size: 0.92rem; transition: color 0.3s;
        }
        .nav-links a:hover { color: #2e7d32; }
        .nav-links .btn-login {
            background: #43a047; color: #fff; padding: 10px 28px;
            border-radius: 30px; font-weight: 600; transition: all 0.3s;
        }
        .nav-links .btn-login:hover {
            background: #2e7d32; color: #fff; transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,125,50,0.3);
        }

        /* ── Hero Section ────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            padding: 120px 40px 80px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -50%; right: -20%;
            width: 800px; height: 800px; border-radius: 50%;
            background: rgba(255,255,255,0.15);
        }
        .hero::after {
            content: ''; position: absolute; bottom: -30%; left: -10%;
            width: 600px; height: 600px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .hero-content {
            max-width: 650px; text-align: center; position: relative; z-index: 2;
            animation: fadeUp 1s ease-out;
        }
        .hero-content .badge {
            display: inline-block; background: rgba(255,255,255,0.7);
            padding: 6px 20px; border-radius: 30px; font-size: 0.82rem;
            color: #2e7d32; font-weight: 600; margin-bottom: 20px;
            backdrop-filter: blur(5px);
        }
        .hero-content h1 {
            font-size: 3.5rem; font-weight: 800; color: #1b5e20;
            line-height: 1.15; margin-bottom: 20px;
        }
        .hero-content h1 span { color: #43a047; }
        .hero-content p {
            font-size: 1.15rem; color: #4a7c50; line-height: 1.7;
            margin-bottom: 35px; font-weight: 300;
        }
        .hero-buttons { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-block; padding: 14px 38px; border-radius: 35px;
            text-decoration: none; font-weight: 600; font-size: 1rem;
            transition: all 0.3s; cursor: pointer; border: none;
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
            background: transparent; color: #2e7d32;
            border: 2px solid #2e7d32;
        }
        .btn-outline:hover {
            background: #2e7d32; color: #fff; transform: translateY(-3px);
        }

        /* ── Stats Strip ─────────────────────────────── */
        .stats {
            background: #fff; padding: 50px 40px;
            display: flex; justify-content: center; gap: 60px; flex-wrap: wrap;
            box-shadow: 0 4px 30px rgba(0,0,0,0.04);
        }
        .stat { text-align: center; }
        .stat .number {
            font-size: 2.5rem; font-weight: 800; color: #2e7d32;
        }
        .stat .label {
            font-size: 0.85rem; color: #888; text-transform: uppercase;
            letter-spacing: 1px; margin-top: 5px;
        }

        /* ── About Section ───────────────────────────── */
        .about {
            padding: 100px 40px;
            background: linear-gradient(180deg, #fafafa, #fff);
        }
        .section-header {
            text-align: center; max-width: 650px; margin: 0 auto 60px;
        }
        .section-header .tag {
            font-size: 0.8rem; font-weight: 700; color: #43a047;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px;
        }
        .section-header h2 {
            font-size: 2.4rem; font-weight: 700; color: #222; margin-bottom: 15px;
        }
        .section-header p { font-size: 1.05rem; color: #777; line-height: 1.7; }

        .about-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px; max-width: 1000px; margin: 0 auto;
        }
        .about-card {
            background: #fff; border-radius: 16px; padding: 35px 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }
        .about-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .about-card .icon {
            font-size: 2.8rem; margin-bottom: 18px;
            display: inline-block;
        }
        .about-card h3 {
            font-size: 1.15rem; color: #333; margin-bottom: 10px; font-weight: 600;
        }
        .about-card p { font-size: 0.9rem; color: #777; line-height: 1.65; }

        /* ── Features Section ────────────────────────── */
        .features {
            padding: 100px 40px;
            background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        }
        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px; max-width: 1100px; margin: 0 auto;
        }
        .feature-card {
            background: #fff; border-radius: 14px; padding: 30px 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 4px; height: 100%; background: #43a047;
            transform: scaleY(0); transition: transform 0.3s;
            transform-origin: top;
        }
        .feature-card:hover::before { transform: scaleY(1); }
        .feature-card:hover { transform: translateY(-5px); }
        .feature-card .f-icon {
            font-size: 2rem; margin-bottom: 15px; display: block;
        }
        .feature-card h3 {
            font-size: 1.05rem; color: #333; margin-bottom: 8px; font-weight: 600;
        }
        .feature-card p { font-size: 0.85rem; color: #888; line-height: 1.6; }

        /* ── How It Works ────────────────────────────── */
        .how-it-works {
            padding: 100px 40px; background: #fff;
        }
        .steps {
            display: flex; justify-content: center; gap: 40px;
            flex-wrap: wrap; max-width: 1000px; margin: 0 auto;
        }
        .step {
            text-align: center; max-width: 250px; position: relative;
        }
        .step .step-num {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, #43a047, #2e7d32);
            color: #fff; font-size: 1.5rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px; box-shadow: 0 6px 20px rgba(46,125,50,0.3);
        }
        .step h3 { font-size: 1.05rem; color: #333; margin-bottom: 8px; }
        .step p { font-size: 0.85rem; color: #888; line-height: 1.6; }

        /* ── CTA Section ─────────────────────────────── */
        .cta-section {
            padding: 100px 40px;
            background: linear-gradient(135deg, #1b5e20, #2e7d32, #43a047);
            text-align: center; color: #fff;
        }
        .cta-section h2 {
            font-size: 2.5rem; font-weight: 700; margin-bottom: 15px;
        }
        .cta-section p {
            font-size: 1.1rem; color: rgba(255,255,255,0.8);
            margin-bottom: 35px; max-width: 550px; margin-left: auto; margin-right: auto;
        }
        .cta-section .btn-white {
            background: #fff; color: #2e7d32; padding: 16px 45px;
            border-radius: 35px; font-weight: 700; font-size: 1.05rem;
            text-decoration: none; display: inline-block; transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .cta-section .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        }

        /* ── Footer ──────────────────────────────────── */
        .footer {
            background: #1a1a1a; color: #999; text-align: center;
            padding: 30px 20px; font-size: 0.82rem;
        }
        .footer a { color: #81c784; text-decoration: none; }
        .footer a:hover { color: #a5d6a7; }

        /* ── Animations ──────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            opacity: 0; transform: translateY(25px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* ── Responsive ──────────────────────────────── */
        @media (max-width: 768px) {
            .navbar { padding: 14px 20px; }
            .nav-links { gap: 15px; }
            .nav-links a:not(.btn-login) { display: none; }
            .hero { padding: 100px 20px 60px; }
            .hero-content h1 { font-size: 2.2rem; }
            .hero-content p { font-size: 1rem; }
            .stats { gap: 30px; padding: 35px 20px; }
            .stat .number { font-size: 1.8rem; }
            .section-header h2 { font-size: 1.8rem; }
            .steps { gap: 25px; }
            .cta-section h2 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<!-- ── Navbar ──────────────────────────────────────────── -->
<nav class="navbar" id="navbar">
    <a href="#" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
    <div class="nav-links">
        <a href="#about">About</a>
        <a href="#features">Features</a>
        <a href="#how-it-works">How It Works</a>
        <a href="<?= BASE_URL ?>/login.php" class="btn-login">Get Started</a>
    </div>
</nav>

<!-- ── Hero ────────────────────────────────────────────── -->
<section class="hero" id="hero">
    <div class="hero-content">
        <span class="badge">India's State-Wise Health Platform</span>
        <h1>Your Body. <span>Your State.</span> Your Plan.</h1>
        <p>
            Fitness Fusion delivers personalized diet and exercise plans
            tailored to your age, body metrics, and Indian state —
            powered by region-specific nutrition science.
        </p>
        <div class="hero-buttons">
            <a href="<?= BASE_URL ?>/login.php" class="btn btn-primary">Start Free &rarr;</a>
            <a href="#about" class="btn btn-outline">Learn More</a>
        </div>
    </div>
</section>

<!-- ── Stats ───────────────────────────────────────────── -->
<section class="stats">
    <div class="stat">
        <div class="number">37</div>
        <div class="label">States &amp; UTs Covered</div>
    </div>
    <div class="stat">
        <div class="number">3</div>
        <div class="label">Age-Based Exercise Groups</div>
    </div>
    <div class="stat">
        <div class="number">111</div>
        <div class="label">State-Wise Diet Plans</div>
    </div>
    <div class="stat">
        <div class="number">100%</div>
        <div class="label">Free &amp; Personalized</div>
    </div>
</section>

<!-- ── About ───────────────────────────────────────────── -->
<section class="about" id="about">
    <div class="section-header fade-in">
        <p class="tag">Why Fitness Fusion?</p>
        <h2>Health Plans That Understand India</h2>
        <p>
            Generic fitness apps ignore regional diets and local food culture.
            Fitness Fusion was built to bridge that gap — combining Indian
            nutritional science with modern health tracking.
        </p>
    </div>
    <div class="about-grid">
        <div class="about-card fade-in">
            <div class="icon">🍛</div>
            <h3>Region-Specific Nutrition</h3>
            <p>
                Diet plans built around the food culture of your state —
                from Rajasthani bajra rotis to Kerala's coconut-based meals.
                Eat what's local, eat what works.
            </p>
        </div>
        <div class="about-card fade-in">
            <div class="icon">🏋️</div>
            <h3>Age-Appropriate Fitness</h3>
            <p>
                Exercise routines designed for three life stages: Young Adults (15–25),
                Adults (26–50), and Seniors (51–75) — with proper intensity scaling.
            </p>
        </div>
        <div class="about-card fade-in">
            <div class="icon">📊</div>
            <h3>Real Health Metrics</h3>
            <p>
                Track BMI, body fat percentage, BMR, and weight history over time.
                All computed from your real measurements — no guesswork.
            </p>
        </div>
    </div>
</section>

<!-- ── Features ────────────────────────────────────────── -->
<section class="features" id="features">
    <div class="section-header fade-in">
        <p class="tag">What You Get</p>
        <h2>Everything in One Platform</h2>
        <p>No subscriptions. No ads. Just science-backed health personalization.</p>
    </div>
    <div class="features-grid">
        <div class="feature-card fade-in">
            <span class="f-icon">🥗</span>
            <h3>Veg &amp; Non-Veg Diet Plans</h3>
            <p>Choose your preference. Get state-specific meal recommendations for Weight Loss, Weight Gain, and Muscle Gain.</p>
        </div>
        <div class="feature-card fade-in">
            <span class="f-icon">🏃</span>
            <h3>Personalized Exercise Cards</h3>
            <p>Structured routines with sets, reps, frequency, and trainer notes — adapted for your age group.</p>
        </div>
        <div class="feature-card fade-in">
            <span class="f-icon">⚖️</span>
            <h3>BMI &amp; Body Composition</h3>
            <p>Automatic BMI calculation, body fat estimation, and BMR computation based on your height, weight, age, and gender.</p>
        </div>
        <div class="feature-card fade-in">
            <span class="f-icon">📈</span>
            <h3>Weight History Tracking</h3>
            <p>Your weight is logged every time you update metrics. Track your progress on the dashboard over time.</p>
        </div>
        <div class="feature-card fade-in">
            <span class="f-icon">🗺️</span>
            <h3>37 Indian States &amp; UTs</h3>
            <p>From Andhra Pradesh to West Bengal, from Ladakh to Lakshadweep — every region has a tailored plan.</p>
        </div>
        <div class="feature-card fade-in">
            <span class="f-icon">🔒</span>
            <h3>Privacy-First Auth</h3>
            <p>Passwords hashed with bcrypt, secure session handling, and HTTPS-only cookies in production.</p>
        </div>
    </div>
</section>

<!-- ── How It Works ───────────────────────────────────── -->
<section class="how-it-works" id="how-it-works">
    <div class="section-header fade-in">
        <p class="tag">Just 4 Steps</p>
        <h2>From Signup to Your Plan</h2>
        <p>Personalized results in minutes.</p>
    </div>
    <div class="steps">
        <div class="step fade-in">
            <div class="step-num">1</div>
            <h3>Create Your Account</h3>
            <p>Secure login with bcrypt-hashed passwords.</p>
        </div>
        <div class="step fade-in">
            <div class="step-num">2</div>
            <h3>Add Your Metrics</h3>
            <p>Enter height, weight, age, gender, and state.</p>
        </div>
        <div class="step fade-in">
            <div class="step-num">3</div>
            <h3>See Your Dashboard</h3>
            <p>Track BMI, body fat, and weight history instantly.</p>
        </div>
        <div class="step fade-in">
            <div class="step-num">4</div>
            <h3>Get Diet &amp; Exercise</h3>
            <p>State-wise diet and age-based workouts tailored to you.</p>
        </div>
    </div>
</section>

<!-- ── CTA ─────────────────────────────────────────────-->
<section class="cta-section">
    <h2>Ready for Your Plan?</h2>
    <p>Join thousands choosing region-aware nutrition and age-aware workouts.</p>
    <a href="<?= BASE_URL ?>/login.php" class="btn-white">Get Started</a>
</section>

<!-- ── Footer ─────────────────────────────────────────── -->
<footer class="footer">
    <p>Built for India's diverse health journeys. Hosted securely on AWS.</p>
</footer>

<script>
    // Simple scroll effect for navbar padding
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });

    // Reveal animations
    const observers = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observers.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.fade-in').forEach(el => observers.observe(el));
</script>
</body>
</html>
