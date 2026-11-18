<?php
/**
 * Shaikh Empire - Analytics & Visitor Intelligence
 */

session_start();
require_once __DIR__ . '/../config/db.php';

if (empty($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$pdo = getDB();

// 1. Total Enquiries and Traffic
$totalEnquiries = $pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$totalVisits    = $pdo->query("SELECT COUNT(*) FROM site_analytics")->fetchColumn();

// 2. Configuration Popularity Breakdown
$configStmt = $pdo->query("
    SELECT configuration, COUNT(*) as count 
    FROM enquiries 
    GROUP BY configuration 
    ORDER BY count DESC
");
$configStats = $configStmt->fetchAll();

// 3. Status Breakdown
$statusStmt = $pdo->query("
    SELECT status, COUNT(*) as count 
    FROM enquiries 
    GROUP BY status 
    ORDER BY count DESC
");
$statusStats = $statusStmt->fetchAll();

// 4. Recent Visitors Log
$visitorStmt = $pdo->query("
    SELECT * FROM site_analytics 
    ORDER BY id DESC 
    LIMIT 25
");
$recentVisitors = $visitorStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analytics &amp; Visitor Intelligence | Shaikh Empire</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👑</text></svg>">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/admin.css">
  <style>
    .analytics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 24px;
      margin-bottom: 30px;
    }
    .stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 24px;
    }
    .stat-card h3 {
      font-size: 16px;
      color: var(--gold-light);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .stat-bar-item {
      margin-bottom: 14px;
    }
    .stat-bar-header {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      margin-bottom: 6px;
    }
    .progress-track {
      background: rgba(255, 255, 255, 0.06);
      height: 8px;
      border-radius: 4px;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--gold-primary), var(--gold-light));
      border-radius: 4px;
    }
  </style>
</head>
<body>

  <!-- Left Sidebar -->
  <aside class="admin-sidebar">
    <div class="sidebar-header">
      <div class="brand-crest">
        <i class="fas fa-crown"></i>
      </div>
      <div class="brand-title">
        <h2>SHAIKH EMPIRE</h2>
        <span>Luxury Concierge CRM</span>
      </div>
    </div>

    <ul class="sidebar-menu">
      <div class="menu-label">Navigation</div>
      <li>
        <a href="index.php">
          <i class="fas fa-th-large"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="enquiries.php">
          <i class="fas fa-users-crown"></i> All Enquiries
        </a>
      </li>
      <li>
        <a href="analytics.php" class="active">
          <i class="fas fa-chart-line"></i> Visitor Analytics
        </a>
      </li>
      <div class="menu-label">Quick Links</div>
      <li>
        <a href="../api/export_csv.php" target="_blank">
          <i class="fas fa-file-excel"></i> Export to CSV
        </a>
      </li>
      <li>
        <a href="../index.php" target="_blank">
          <i class="fas fa-external-link-alt"></i> Live Website
        </a>
      </li>
    </ul>

    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="user-info">
          <h4><?= safeOutput($_SESSION['admin_name'] ?? 'Admin') ?></h4>
          <span><?= safeOutput($_SESSION['admin_role'] ?? 'Concierge') ?></span>
        </div>
        <a href="logout.php" class="btn-logout" title="Sign Out">
          <i class="fas fa-power-off"></i>
        </a>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="admin-main">
    <header class="top-navbar">
      <div class="page-headline">
        <h1>Audience &amp; Traffic Intelligence</h1>
        <p>Real-time analytics and demand breakdown for Shaikh Empire</p>
      </div>

      <div class="nav-right-actions">
        <a href="index.php" class="btn btn-primary-gold">
          <i class="fas fa-th-large"></i> Back to Dashboard
        </a>
      </div>
    </header>

    <div class="content-container">

      <!-- Visual Breakdown Grid -->
      <div class="analytics-grid">
        <!-- Configuration Demand -->
        <div class="stat-card">
          <h3><i class="fas fa-home"></i> Most Demanded Residences</h3>
          <?php foreach ($configStats as $cs): ?>
            <?php $percent = $totalEnquiries > 0 ? round(($cs['count'] / $totalEnquiries) * 100) : 0; ?>
            <div class="stat-bar-item">
              <div class="stat-bar-header">
                <span><?= safeOutput($cs['configuration']) ?></span>
                <strong><?= $cs['count'] ?> leads (<?= $percent ?>%)</strong>
              </div>
              <div class="progress-track">
                <div class="progress-fill" style="width: <?= $percent ?>%;"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pipeline Conversion Status -->
        <div class="stat-card">
          <h3><i class="fas fa-filter"></i> Lead Pipeline Status</h3>
          <?php foreach ($statusStats as $ss): ?>
            <?php $percent = $totalEnquiries > 0 ? round(($ss['count'] / $totalEnquiries) * 100) : 0; ?>
            <div class="stat-bar-item">
              <div class="stat-bar-header">
                <span><?= safeOutput($ss['status']) ?></span>
                <strong><?= $ss['count'] ?> (<?= $percent ?>%)</strong>
              </div>
              <div class="progress-track">
                <div class="progress-fill" style="width: <?= $percent ?>%; background: linear-gradient(90deg, #38bdf8, #818cf8);"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Live Visitor Audit Log -->
      <div class="table-card">
        <div class="table-header-bar">
          <div class="table-title">
            <h3><i class="fas fa-satellite-dish" style="color: var(--accent-green);"></i> Real-Time Visitor Audit Log</h3>
            <span class="badge-count">Last 25 Visitors</span>
          </div>
        </div>

        <div class="table-responsive">
          <table class="luxury-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Visitor IP</th>
                <th>Target URL</th>
                <th>Referrer Source</th>
                <th>Browser / User Agent</th>
                <th>Visit Timestamp</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recentVisitors)): ?>
                <tr>
                  <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                    No visitor logs recorded yet.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recentVisitors as $v): ?>
                  <tr>
                    <td>#<?= $v['id'] ?></td>
                    <td><code style="color: var(--gold-light);"><?= safeOutput($v['ip_address']) ?></code></td>
                    <td><?= safeOutput($v['page_url']) ?></td>
                    <td><?= safeOutput($v['referrer']) ?></td>
                    <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 11.5px; color: var(--text-muted);">
                      <?= safeOutput($v['user_agent']) ?>
                    </td>
                    <td style="font-size: 12px; color: var(--text-muted);">
                      <?= date('d M, Y h:i:s A', strtotime($v['visited_at'])) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>

</body>
</html>
