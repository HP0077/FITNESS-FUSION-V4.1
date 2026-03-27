🚀 FITNESS FUSION
Health & wellbeing web app for fitness tracking and wellness guidance.

🧠 Overview
Fitness Fusion is a PHP/MySQL web app that lets users sign up, log in, record health metrics, and view history in a responsive UI. It simplifies fitness tracking with streamlined forms and clear dashboards.

Problem: Manual/fragmented tracking of personal fitness data.
Interesting: Lightweight, environment-driven config; clean, mobile-friendly flows.
✨ Features
Unified, CSRF-protected signup/login with flash feedback.
Metrics capture (height, weight, BMI, body fat, calories) and history views.
Responsive UI with optimized asset loading.
Env-based config for DB and asset host (works locally or with S3/CDN).
🏗️ System Architecture / Workflow
User → Browser (HTML/CSS/JS) → PHP backend (forms + validation) → MySQL (store/retrieve metrics & users) → Rendered pages/dashboards

🛠️ Tech Stack
🔹 Backend
PHP 8.x
🔹 Frontend
HTML, CSS, JavaScript
🔹 Database
MySQL
🔹 AI / ML
Not applicable (no ML in this project)
🤖 AI / ML Details
Not applicable for this project.
📸 Screenshots
Dashboard
!Dashboard

Feature Example
!Feature

🚀 Installation & Setup
Prerequisites
XAMPP/WAMP (PHP 8.x, MySQL)
Git
Steps
Clone repo

git clone <repo-link> FITNESS-FUSION-v4cd FITNESS-FUSION-v4
Configure environment
Set DB credentials in config.php (DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS).
Optional: set S3_ASSET_URL (else assets load locally).
Create database and import schema

# from project rootmysql -u root -p -e "CREATE DATABASE fitness_fusion_v4 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"mysql -u root -p fitness_fusion_v4 < database/schema.sql
Run locally
Place the project in your web root (e.g., FITNESS-FUSION-v4).
Start Apache and MySQL in XAMPP.
Open: http://localhost/FITNESS-FUSION-v4/login.php (or via your configured virtual host/port).
Test
Sign up, log in, add metrics; verify data appears in MySQ
