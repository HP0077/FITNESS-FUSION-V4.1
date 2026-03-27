<?php
/**
 * Application Configuration
 * 
 * Detects environment automatically based on server hostname.
 * Local dev  → localhost defaults (XAMPP/WAMP)
 * Production → reads from environment variables set on EC2
 */

// Prevent direct access
if (basename($_SERVER['PHP_SELF']) === 'config.php') {
    http_response_code(403);
    exit('Direct access not allowed.');
}

// ── Environment Detection ──────────────────────────────────
$isProduction = isset($_SERVER['SERVER_NAME']) 
    && $_SERVER['SERVER_NAME'] !== 'localhost' 
    && $_SERVER['SERVER_NAME'] !== '127.0.0.1';

// ── Database Configuration ─────────────────────────────────
if ($isProduction) {
    // Production (AWS EC2) — pull from environment variables
    // Default port 3306 is typical for RDS; override via env when needed.
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    define('DB_PORT', getenv('DB_PORT') ?: '3306');
    define('DB_NAME', getenv('DB_NAME') ?: 'fitness_fusion_v4');
    define('DB_USER', getenv('DB_USER') ?: 'ff_admin');
    define('DB_PASS', getenv('DB_PASS') ?: '');
} else {
    // Local development (XAMPP / WAMP)
    // Use 127.0.0.1 to force TCP and honor the non-default port (avoids named-pipe lookups on Windows).
    define('DB_HOST', '127.0.0.1');
    define('DB_PORT', '3307');
    define('DB_NAME', 'fitness_fusion_v4');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}

// ── Application URL ────────────────────────────────────────
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// HTTP_HOST already includes non-standard ports (e.g. localhost:8080)
$httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Compute project root reliably: this file is always at <root>/includes/config.php
// so the project root on disk is one directory up from __DIR__.
$projectRoot = dirname(__DIR__);                        // e.g. C:/xampp/htdocs/FITNESS-FUSION
$docRoot     = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/'); // e.g. C:/xampp/htdocs
$projectRoot = str_replace('\\', '/', $projectRoot);

// Web-accessible base path = project root minus document root
$basePath = str_replace($docRoot, '', $projectRoot);    // e.g. /FITNESS-FUSION

define('BASE_URL', $protocol . '://' . $httpHost . $basePath);

// ── Application Constants ──────────────────────────────────
define('APP_NAME', 'Fitness Fusion');
define('APP_ENV', $isProduction ? 'production' : 'development');

// ── Static Assets (S3 in production, local in dev) ─────────
// In production, static assets (logo, images) are served from an S3 bucket
// for scalability, CDN caching, and to demonstrate Storage as a Service.
// Locally, assets load from the project folder as usual.
if ($isProduction) {
    define('ASSET_URL', getenv('S3_ASSET_URL') ?: BASE_URL);
} else {
    define('ASSET_URL', BASE_URL);
}

// ── Error Reporting ────────────────────────────────────────
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../logs/error.log');
}

// ── Session Configuration ──────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');   // JS can't read session cookie
    ini_set('session.use_strict_mode', '1');   // Reject uninitialized session IDs
    ini_set('session.cookie_samesite', 'Lax'); // CSRF baseline protection

    if ($isProduction) {
        ini_set('session.cookie_secure', '1'); // HTTPS-only cookies in prod
    }
}
