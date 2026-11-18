<?php
/**
 * Shaikh Empire - One-Click Database Installer & Setup Wizard
 * Accessible via Browser: http://localhost/shaikh-empire/setup_database.php
 * Or via Terminal CLI: php setup_database.php
 * Smart Auto-Port Detection: Automatically supports both standard 3306 and alternative 3307 ports!
 */

require_once __DIR__ . '/config/db.php';

$isCli = (php_sapi_name() === 'cli');
$messages = [];
$success = false;

try {
    if (!extension_loaded('pdo_mysql')) {
        throw new Exception("PHP PDO MySQL extension is not installed or enabled in php.ini.");
    }
    $messages[] = ["status" => "ok", "text" => "PHP PDO MySQL extension is enabled."];

    // Detect active MySQL port (3306 or 3307)
    $activePort = null;
    $rootPdo = null;
    $ports = [3306, 3307];

    foreach ($ports as $port) {
        try {
            $testPdo = new PDO(
                "mysql:host=" . DB_HOST . ";port=" . $port . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 2]
            );
            $activePort = $port;
            $rootPdo = $testPdo;
            break;
        } catch (Exception $pe) {
            // Try next port
        }
    }

    if (!$rootPdo) {
        throw new Exception("Cannot connect to MySQL on Port 3306 or Port 3307. Please ensure MySQL is started in XAMPP.");
    }

    $messages[] = ["status" => "ok", "text" => "Connected to MySQL server on " . DB_HOST . ":{$activePort} as user '" . DB_USER . "'."];

    // Create Database
    $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $messages[] = ["status" => "ok", "text" => "Database '" . DB_NAME . "' created or already exists."];

    // Connect to database using getDB()
    $pdo = getDB();
    $messages[] = ["status" => "ok", "text" => "Successfully connected to database '" . DB_NAME . "' on port {$activePort}."];

    // Execute schema
    $schemaFile = __DIR__ . '/sql/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found at: " . $schemaFile);
    }
    $sqlContent = file_get_contents($schemaFile);
    $pdo->exec($sqlContent);
    $messages[] = ["status" => "ok", "text" => "Database schema executed successfully (Tables: `enquiries`, `admins`, `site_analytics`)."];

    // Default admin
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = 'admin' LIMIT 1");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $defaultPassword = 'Admin@123';
        $hashed = password_hash($defaultPassword, PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO admins (username, password_hash, name, email, role) VALUES ('admin', :pass, 'Shaikh Empire Concierge Admin', 'admin@shaikhempire.com', 'super_admin')");
        $insertAdmin->execute([':pass' => $hashed]);
        $messages[] = ["status" => "ok", "text" => "Default admin user created: Username 'admin' | Password 'Admin@123'."];
    } else {
        $messages[] = ["status" => "ok", "text" => "Admin account verified."];
    }

    // Check count
    $countStmt = $pdo->query("SELECT COUNT(*) AS total FROM enquiries");
    $totalEnquiries = $countStmt->fetch()['total'];
    $messages[] = ["status" => "ok", "text" => "Total {$totalEnquiries} enquiries currently in database."];

    $success = true;
} catch (Exception $e) {
    $messages[] = ["status" => "error", "text" => "Error: " . $e->getMessage()];
    $success = false;
}

if ($isCli) {
    echo "==========================================\n";
    echo " SHAIKH EMPIRE - DATABASE SETUP WIZARD   \n";
    echo "==========================================\n";
    foreach ($messages as $msg) {
        $prefix = ($msg['status'] === 'ok') ? '[SUCCESS]' : '[ERROR]';
        echo "{$prefix} {$msg['text']}\n";
    }
    if ($success) {
        echo "\nSetup completed successfully!\n";
        echo "Admin Portal: http://localhost/shaikh-empire/admin/\n";
        echo "Username: admin | Password: Admin@123\n";
        echo "Website: http://localhost/shaikh-empire/\n";
    }
    exit($success ? 0 : 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup Wizard | Shaikh Empire</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --gold: #d4af37;
            --gold-light: #f3e5ab;
            --bg-dark: #0a0c10;
            --bg-card: #131722;
            --border-gold: rgba(212, 175, 55, 0.3);
            --text-light: #f5f5f7;
            --text-muted: #9ba1b0;
            --success: #10b981;
            --error: #ef4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1a202c 0%, #0a0c10 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .setup-card {
            background: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: 16px;
            max-width: 650px;
            width: 100%;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 40px rgba(212, 175, 55, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header .icon {
            font-size: 40px;
            color: var(--gold);
            margin-bottom: 12px;
        }
        .header h1 {
            font-family: 'Cinzel', serif;
            font-size: 24px;
            letter-spacing: 2px;
            color: var(--gold-light);
            margin-bottom: 6px;
        }
        .header p {
            color: var(--text-muted);
            font-size: 14px;
        }
        .steps-list {
            list-style: none;
            margin-bottom: 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            padding: 16px 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }
        .step-item:last-child { border-bottom: none; }
        .step-item .icon-ok { color: var(--success); font-size: 16px; margin-top: 2px; }
        .step-item .icon-error { color: var(--error); font-size: 16px; margin-top: 2px; }
        .admin-creds-box {
            background: rgba(212, 175, 55, 0.08);
            border: 1px dashed var(--gold);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 30px;
        }
        .admin-creds-box h3 {
            color: var(--gold);
            font-size: 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-creds-box p {
            font-size: 13.5px;
            color: var(--text-light);
            margin: 4px 0;
        }
        .btn-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }
        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #aa8012 100%);
            color: #000;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #f3e5ab 0%, #d4af37 100%);
            transform: translateY(-2px);
        }
        .btn-outline {
            background: transparent;
            color: var(--text-light);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="setup-card">
        <div class="header">
            <div class="icon"><i class="fas fa-crown"></i></div>
            <h1>SHAIKH EMPIRE</h1>
            <p>Automated Database &amp; Environment Setup Wizard</p>
        </div>

        <ul class="steps-list">
            <?php foreach ($messages as $msg): ?>
                <li class="step-item">
                    <?php if ($msg['status'] === 'ok'): ?>
                        <i class="fas fa-check-circle icon-ok"></i>
                    <?php else: ?>
                        <i class="fas fa-times-circle icon-error"></i>
                    <?php endif; ?>
                    <span><?= safeOutput($msg['text']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($success): ?>
            <div class="admin-creds-box">
                <h3><i class="fas fa-key"></i> Default Admin Credentials</h3>
                <p><strong>Username:</strong> <code>admin</code></p>
                <p><strong>Password:</strong> <code>Admin@123</code></p>
                <p style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">You can change your password anytime inside the Admin Dashboard.</p>
            </div>

            <div class="btn-group">
                <a href="index.php" class="btn btn-gold">
                    <i class="fas fa-globe"></i> View Website
                </a>
                <a href="admin/login.php" class="btn btn-outline">
                    <i class="fas fa-tachometer-alt"></i> Open Admin Panel
                </a>
            </div>
        <?php else: ?>
            <div style="text-align: center; margin-top: 20px;">
                <p style="color: var(--error); margin-bottom: 15px;">Please verify that MySQL is started in XAMPP Control Panel and try again.</p>
                <a href="setup_database.php" class="btn btn-gold"><i class="fas fa-redo"></i> Retry Setup</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
