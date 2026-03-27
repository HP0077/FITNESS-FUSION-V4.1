<?php
/**
 * Centralized Database Connection (Singleton)
 * 
 * Returns a single shared PDO instance across the entire request lifecycle.
 * Uses constants from config.php — never hardcodes credentials.
 */

// Prevent direct access
if (basename($_SERVER['PHP_SELF']) === 'db.php') {
    http_response_code(403);
    exit('Direct access not allowed.');
}

// Load config if not already loaded
require_once __DIR__ . '/config.php';

/**
 * Returns a singleton PDO connection.
 * 
 * Usage in any file:
 *   require_once __DIR__ . '/../includes/db.php';
 *   $conn = getDB();
 *   $stmt = $conn->prepare("SELECT ...");
 *
 * @return PDO
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Throw on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Return assoc arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                    // Real prepared statements
        PDO::ATTR_PERSISTENT         => false,                    // No persistent conns on shared hosting / free tier
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        $dsnContext = sprintf('host=%s;port=%s;db=%s', DB_HOST, DB_PORT, DB_NAME);

        // Log with context
        error_log('[Fitness Fusion] DB connection failed (' . $dsnContext . '): ' . $e->getMessage());

        // In development, show the reason to speed up debugging
        if (APP_ENV === 'development') {
            http_response_code(503);
            exit('DB connection failed (' . $dsnContext . '): ' . htmlspecialchars($e->getMessage()));
        }

        // Production-safe message
        http_response_code(503);
        exit('Service temporarily unavailable. Please try again later.');
    }
}
