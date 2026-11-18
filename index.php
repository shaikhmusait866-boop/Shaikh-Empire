<?php
/**
 * Shaikh Empire - Admin Dashboard & Lead Concierge
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Authentication Check
if (empty($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$pdo = getDB();
$message = '';
$messageType = '';

// Handle Status Update Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $enquiryId = (int)($_POST['enquiry_id'] ?? 0);
    $newStatus = trim($_POST['status'] ?? '');
    $validStatuses = ['New', 'Contacted', 'Site Visit Scheduled', 'Negotiation', 'Closed', 'Spam'];

    if ($enquiryId > 0 && in_array($newStatus, $validStatuses)) {
        $stmt = $pdo->prepare("UPDATE enquiries SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $newStatus, ':id' => $enquiryId]);
        $message = "Enquiry #{$enquiryId} status updated to '{$newStatus}'.";
        $messageType = 'success';
    }
}

// Handle Delete Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $enquiryId = (int)($_POST['enquiry_id'] ?? 0);
    if ($enquiryId > 0) {
        $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
        $stmt->execute([':id' => $enquiryId]);
        $message = "Enquiry #{$enquiryId} deleted permanently.";
        $messageType = 'success';
    }
}

// Fetch KPI Metrics
$totalEnquiries = $pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$todayEnquiries = $pdo->query("SELECT COUNT(*) FROM enquiries WHERE DATE(created_at) = CURDATE()")->fetchColumn();
$pendingLeads   = $pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New'")->fetchColumn();
$scheduledVisits= $pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Site Visit Scheduled'")->fetchColumn();
$pickupRequests = $pdo->query("SELECT COUNT(*) FROM enquiries WHERE chauffeured_pickup = 'Yes'")->fetchColumn();
$totalVisits    = $pdo->query("SELECT COUNT(*) FROM site_analytics")->fetchColumn();

// Fetch Recent Enquiries (Limit 15)
$stmt = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 15");
$recentEnquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Concierge Dashboard | Shaikh Empire</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👑</text></svg>">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/admin.css">
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
        <a href="index.php" class="active">
          <i class="fas fa-th-large"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="enquiries.php">
          <i class="fas fa-users-crown"></i> All Enquiries
        </a>
      </li>
      <li>
        <a href="analytics.php">
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
        <a href="../setup_database.php">
          <i class="fas fa-database"></i> Database Wizard
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

  <!-- Main Content View -->
  <main class="admin-main">
    <header class="top-navbar">
      <div class="page-headline">
        <h1>Imperial Enquiries Dashboard</h1>
        <p>Live Real-Time Lead Pipeline &amp; Customer Relationship Registry</p>
      </div>

      <div class="nav-right-actions">
        <a href="../api/export_csv.php" class="btn btn-secondary">
          <i class="fas fa-download"></i> Download CSV
        </a>
        <a href="../index.php" target="_blank" class="btn btn-primary-gold">
          <i class="fas fa-eye"></i> View Website
        </a>
      </div>
    </header>

    <div class="content-container">

      <?php if (!empty($message)): ?>
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px;">
          <i class="fas fa-check-circle"></i> <?= safeOutput($message) ?>
        </div>
      <?php endif; ?>

      <!-- Metric KPI Cards -->
      <div class="metrics-grid">
        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($totalEnquiries) ?></h3>
            <span>Total Enquiries</span>
          </div>
          <div class="metric-icon gold">
            <i class="fas fa-gem"></i>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($todayEnquiries) ?></h3>
            <span>Today's New Leads</span>
          </div>
          <div class="metric-icon blue">
            <i class="fas fa-bolt"></i>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($pendingLeads) ?></h3>
            <span>Pending Action (New)</span>
          </div>
          <div class="metric-icon amber">
            <i class="fas fa-hourglass-half"></i>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($scheduledVisits) ?></h3>
            <span>Site Visits Scheduled</span>
          </div>
          <div class="metric-icon purple">
            <i class="fas fa-calendar-check"></i>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($pickupRequests) ?></h3>
            <span>Chauffeured Pickups</span>
          </div>
          <div class="metric-icon gold">
            <i class="fas fa-car-side"></i>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-data">
            <h3><?= number_format($totalVisits) ?></h3>
            <span>Website Visitors</span>
          </div>
          <div class="metric-icon green">
            <i class="fas fa-globe"></i>
          </div>
        </div>
      </div>

      <!-- Recent Leads Table -->
      <div class="table-card">
        <div class="table-header-bar">
          <div class="table-title">
            <h3>Recent VIP Enquiries</h3>
            <span class="badge-count"><?= count($recentEnquiries) ?> Recent Leads</span>
          </div>

          <div class="table-controls">
            <a href="enquiries.php" class="btn btn-secondary">
              <i class="fas fa-list"></i> View All Enquiries &amp; Filter
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="luxury-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Client Name &amp; Contact</th>
                <th>Configuration</th>
                <th>Visit Date</th>
                <th>Chauffeured Pickup</th>
                <th>Status</th>
                <th>Submission Time</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recentEnquiries)): ?>
                <tr>
                  <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                    No customer enquiries found in the database yet.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recentEnquiries as $enquiry): ?>
                  <?php
                    $statusClass = 'status-new';
                    switch ($enquiry['status']) {
                      case 'Contacted': $statusClass = 'status-contacted'; break;
                      case 'Site Visit Scheduled': $statusClass = 'status-scheduled'; break;
                      case 'Negotiation': $statusClass = 'status-negotiation'; break;
                      case 'Closed': $statusClass = 'status-closed'; break;
                      case 'Spam': $statusClass = 'status-spam'; break;
                    }
                    $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry['phone']);
                    $waMsg = urlencode("Hello " . $enquiry['full_name'] . ", greetings from Shaikh Empire Concierge regarding your enquiry for " . $enquiry['configuration'] . ".");
                  ?>
                  <tr>
                    <td><strong>#<?= $enquiry['id'] ?></strong></td>
                    <td>
                      <span class="lead-name"><?= safeOutput($enquiry['full_name']) ?></span>
                      <div class="lead-meta">
                        <i class="fas fa-phone-alt" style="font-size: 10px;"></i> <?= safeOutput($enquiry['phone']) ?> &bull; 
                        <i class="fas fa-envelope" style="font-size: 10px;"></i> <?= safeOutput($enquiry['email']) ?>
                      </div>
                    </td>
                    <td>
                      <span style="font-weight: 600; color: var(--gold-light);"><?= safeOutput($enquiry['configuration']) ?></span>
                    </td>
                    <td>
                      <?= !empty($enquiry['visit_date']) ? date('d M, Y', strtotime($enquiry['visit_date'])) : '<span style="color: var(--text-muted);">Not chosen</span>' ?>
                    </td>
                    <td>
                      <?php if ($enquiry['chauffeured_pickup'] === 'Yes'): ?>
                        <span class="badge-pickup pickup-yes"><i class="fas fa-car"></i> Yes Requested</span>
                      <?php else: ?>
                        <span class="badge-pickup pickup-no">No</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <!-- Inline Quick Status Updater -->
                      <form method="POST" action="index.php" style="display: inline-block;">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="enquiry_id" value="<?= $enquiry['id'] ?>">
                        <select name="status" class="filter-select" onchange="this.form.submit()" style="font-size: 12px; padding: 4px 8px;">
                          <option value="New" <?= $enquiry['status'] === 'New' ? 'selected' : '' ?>>New</option>
                          <option value="Contacted" <?= $enquiry['status'] === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                          <option value="Site Visit Scheduled" <?= $enquiry['status'] === 'Site Visit Scheduled' ? 'selected' : '' ?>>Site Visit Scheduled</option>
                          <option value="Negotiation" <?= $enquiry['status'] === 'Negotiation' ? 'selected' : '' ?>>Negotiation</option>
                          <option value="Closed" <?= $enquiry['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                          <option value="Spam" <?= $enquiry['status'] === 'Spam' ? 'selected' : '' ?>>Spam</option>
                        </select>
                      </form>
                    </td>
                    <td style="color: var(--text-muted); font-size: 12px;">
                      <?= date('d M, h:i A', strtotime($enquiry['created_at'])) ?>
                    </td>
                    <td>
                      <div style="display: flex; gap: 6px;">
                        <!-- WhatsApp Action -->
                        <a href="https://wa.me/91<?= $cleanPhone ?>?text=<?= $waMsg ?>" target="_blank" class="btn-action btn-wa" title="Chat on WhatsApp">
                          <i class="fab fa-whatsapp"></i>
                        </a>

                        <!-- Call Action -->
                        <a href="tel:<?= $cleanPhone ?>" class="btn-action" title="Call Client">
                          <i class="fas fa-phone"></i>
                        </a>

                        <!-- View Modal -->
                        <button class="btn-action" onclick='viewLeadModal(<?= json_encode($enquiry) ?>)' title="View Full Details">
                          <i class="fas fa-eye"></i>
                        </button>

                        <!-- Delete Lead -->
                        <form method="POST" action="index.php" onsubmit="return confirm('Delete this enquiry #<?= $enquiry['id'] ?> permanently?');" style="display:inline;">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="enquiry_id" value="<?= $enquiry['id'] ?>">
                          <button type="submit" class="btn-action btn-del" title="Delete Enquiry">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </div>
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

  <!-- Enquiry View Modal -->
  <div class="modal-overlay" id="leadModal">
    <div class="modal-box">
      <div class="modal-head">
        <h3><i class="fas fa-file-invoice"></i> VIP Lead Dossier</h3>
        <button class="modal-close" onclick="closeLeadModal()">&times;</button>
      </div>
      <div class="modal-body" id="modalDetailsContent">
        <!-- Rendered Dynamically via JS -->
      </div>
    </div>
  </div>

  <script>
    function viewLeadModal(data) {
      const container = document.getElementById('modalDetailsContent');
      container.innerHTML = `
        <div class="detail-row">
          <div class="label">Enquiry ID</div>
          <div class="value"><strong>#${data.id}</strong></div>
        </div>
        <div class="detail-row">
          <div class="label">Client Full Name</div>
          <div class="value">${data.full_name}</div>
        </div>
        <div class="detail-row">
          <div class="label">Mobile Number</div>
          <div class="value"><a href="tel:${data.phone}" style="color: #d4af37;">${data.phone}</a></div>
        </div>
        <div class="detail-row">
          <div class="label">Email Address</div>
          <div class="value"><a href="mailto:${data.email}" style="color: #38bdf8;">${data.email}</a></div>
        </div>
        <div class="detail-row">
          <div class="label">Property Project</div>
          <div class="value">${data.property_name}</div>
        </div>
        <div class="detail-row">
          <div class="label">Configuration</div>
          <div class="value"><strong>${data.configuration}</strong></div>
        </div>
        <div class="detail-row">
          <div class="label">Preferred Visit Date</div>
          <div class="value">${data.visit_date || 'Not specified'}</div>
        </div>
        <div class="detail-row">
          <div class="label">Chauffeured Pickup</div>
          <div class="value">${data.chauffeured_pickup === 'Yes' ? '<span style="color: #d4af37; font-weight:700;"><i class="fas fa-car"></i> Yes, Pickup Requested</span>' : 'No'}</div>
        </div>
        <div class="detail-row">
          <div class="label">Lead Status</div>
          <div class="value"><strong>${data.status}</strong></div>
        </div>
        <div class="detail-row">
          <div class="label">Special Request / Message</div>
          <div class="value" style="white-space: pre-wrap; font-style: italic;">${data.special_request || 'None provided.'}</div>
        </div>
        <div class="detail-row">
          <div class="label">Visitor IP</div>
          <div class="value">${data.ip_address || 'Unknown'}</div>
        </div>
        <div class="detail-row">
          <div class="label">Received At</div>
          <div class="value">${data.created_at}</div>
        </div>
      `;
      document.getElementById('leadModal').classList.add('active');
    }

    function closeLeadModal() {
      document.getElementById('leadModal').classList.remove('active');
    }

    // Close modal on click outside
    document.getElementById('leadModal').addEventListener('click', function(e) {
      if (e.target === this) closeLeadModal();
    });
  </script>

</body>
</html>
