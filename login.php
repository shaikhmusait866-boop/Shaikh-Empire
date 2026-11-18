<?php
/**
 * Shaikh Empire - Admin Login Portal
 */

session_start();
require_once __DIR__ . '/../config/db.php';

if (!empty($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        try {
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :user LIMIT 1");
            $stmt->execute([':user' => $username]);
            $admin = $stmt->fetch();

            if ($admin) {
                // Verify against hash or self-heal default admin
                $isValid = password_verify($password, $admin['password_hash']) 
                           || ($username === 'admin' && $password === 'Admin@123');

                if ($isValid) {
                    // Update hash and last login
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare("UPDATE admins SET password_hash = :hash, last_login = NOW() WHERE id = :id");
                    $updateStmt->execute([':hash' => $newHash, ':id' => $admin['id']]);

                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id']        = $admin['id'];
                    $_SESSION['admin_username']  = $admin['username'];
                    $_SESSION['admin_name']      = $admin['name'];
                    $_SESSION['admin_role']      = $admin['role'];

                    header("Location: index.php");
                    exit;
                } else {
                    $error = 'Invalid credentials. Please verify your username and password.';
                }
            } else {
                // If admin account doesn't exist yet, auto-create it if matching default
                if ($username === 'admin' && $password === 'Admin@123') {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $insertStmt = $pdo->prepare("INSERT INTO admins (username, password_hash, name, role) VALUES ('admin', :hash, 'Shaikh Empire Concierge Admin', 'super_admin')");
                    $insertStmt->execute([':hash' => $newHash]);

                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id']        = $pdo->lastInsertId();
                    $_SESSION['admin_username']  = 'admin';
                    $_SESSION['admin_name']      = 'Shaikh Empire Concierge Admin';
                    $_SESSION['admin_role']      = 'super_admin';

                    header("Location: index.php");
                    exit;
                } else {
                    $error = 'Invalid credentials. Please verify your username and password.';
                }
            }
        } catch (Exception $e) {
            $error = 'Database connection error: ' . $e->getMessage() . '. Make sure MySQL is running in XAMPP.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Concierge Login | Shaikh Empire</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👑</text></svg>">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    :root {
      --gold-primary: #d4af37;
      --gold-light: #f5e6b3;
      --bg-deep: #080a0f;
      --bg-card: rgba(18, 23, 34, 0.9);
      --border-gold: rgba(212, 175, 55, 0.3);
      --text-primary: #f8fafc;
      --text-muted: #94a3b8;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: radial-gradient(circle at 50% 20%, #151b29 0%, #080a0f 100%);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .login-container {
      max-width: 440px;
      width: 100%;
      background: var(--bg-card);
      border: 1px solid var(--border-gold);
      border-radius: 18px;
      padding: 42px 36px;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 35px rgba(212, 175, 55, 0.1);
      backdrop-filter: blur(12px);
      text-align: center;
    }
    .brand-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #d4af37, #997a15);
      border-radius: 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #000;
      font-size: 26px;
      margin-bottom: 16px;
      box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
    }
    .brand-title {
      font-family: 'Cinzel', serif;
      font-size: 22px;
      letter-spacing: 2.5px;
      color: var(--gold-light);
      margin-bottom: 6px;
    }
    .brand-subtitle {
      font-size: 12.5px;
      color: var(--text-muted);
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 30px;
    }
    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-muted);
      margin-bottom: 8px;
    }
    .input-wrapper {
      position: relative;
    }
    .input-wrapper i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gold-primary);
      font-size: 14px;
    }
    .form-control {
      width: 100%;
      padding: 13px 14px 13px 40px;
      background: rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(212, 175, 55, 0.2);
      border-radius: 10px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: all 0.25s;
    }
    .form-control:focus {
      border-color: var(--gold-primary);
      box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
      background: rgba(0, 0, 0, 0.6);
    }
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #d4af37, #b28a1a);
      color: #000;
      border: none;
      border-radius: 10px;
      font-size: 14.5px;
      font-weight: 700;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      box-shadow: 0 4px 18px rgba(212, 175, 55, 0.3);
    }
    .btn-login:hover {
      background: linear-gradient(135deg, #f5e6b3, #d4af37);
      transform: translateY(-2px);
    }
    .error-alert {
      background: rgba(244, 63, 94, 0.15);
      border: 1px solid rgba(244, 63, 94, 0.3);
      color: #fda4af;
      padding: 12px 16px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 20px;
      text-align: left;
    }
    .hint-box {
      margin-top: 25px;
      padding: 12px;
      background: rgba(255, 255, 255, 0.03);
      border-radius: 8px;
      font-size: 12px;
      color: var(--text-muted);
    }
    .hint-box code {
      color: var(--gold-light);
      background: rgba(0, 0, 0, 0.4);
      padding: 2px 6px;
      border-radius: 4px;
    }
    .back-link {
      display: inline-block;
      margin-top: 18px;
      color: var(--text-muted);
      font-size: 13px;
      text-decoration: none;
      transition: color 0.2s;
    }
    .back-link:hover {
      color: var(--gold-primary);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="brand-icon">
      <i class="fas fa-crown"></i>
    </div>
    <h1 class="brand-title">SHAIKH EMPIRE</h1>
    <div class="brand-subtitle">VIP Admin &amp; CRM Concierge</div>

    <?php if (!empty($error)): ?>
      <div class="error-alert">
        <i class="fas fa-exclamation-triangle"></i> <?= safeOutput($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Username</label>
        <div class="input-wrapper">
          <i class="fas fa-user-shield"></i>
          <input type="text" id="username" name="username" class="form-control" placeholder="Enter admin username" required autofocus value="<?= safeOutput($_POST['username'] ?? '') ?>">
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock"></i>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter secure password" required>
        </div>
      </div>

      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> Access Concierge Portal
      </button>
    </form>

    <div class="hint-box">
      Default Access: <code>admin</code> / <code>Admin@123</code>
    </div>

    <a href="../index.php" class="back-link">
      <i class="fas fa-arrow-left"></i> Return to Shaikh Empire Website
    </a>
  </div>

</body>
</html>
