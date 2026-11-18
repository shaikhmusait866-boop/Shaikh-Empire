<?php
/**
 * Shaikh Empire - All Enquiries & Lead Registry
 */

session_start();
require_once __DIR__ . '/../config/db.php';

if (empty($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$pdo = getDB();
$message = '';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $enquiryId = (int)($_POST['enquiry_id'] ?? 0);
    $newStatus = trim($_POST['status'] ?? '');
    $validStatuses = ['New', 'Contacted', 'Site Visit Scheduled', 'Negotiation', 'Closed', 'Spam'];

    if ($enquiryId > 0 && in_array($newStatus, $validStatuses)) {
        $stmt = $pdo->prepare("UPDATE enquiries SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $newStatus, ':id' => $enquiryId]);
        $message = "Enquiry #{$enquiryId} status updated to '{$newStatus}'.";
    }
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $enquiryId = (int)($_POST['enquiry_id'] ?? 0);
    if ($enquiryId > 0) {
        $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
        $stmt->execute([':id' => $enquiryId]);
        $message = "Enquiry #{$enquiryId} deleted permanently.";
    }
}

// Search & Filter Parameters
$search        = trim($_GET['search'] ?? '');
$statusFilter  = trim($_GET['status'] ?? '');
$configFilter  = trim($_GET['config'] ?? '');
$pickupFilter  = trim($_GET['pickup'] ?? '');

$page   = max(1, (int)($_GET['page'] ?? 1));
$limit  = 20;
$offset = ($page - 1) * $limit;

// Build Query
$where = ["1=1"];
$params = [];

if (!empty($search)) {
    $where[] = "(full_name LIKE :search OR phone LIKE :search OR email LIKE :search OR special_request LIKE :search)";
    $params[':search'] = "%{$search}%";
}
if (!empty($statusFilter)) {
    $where[] = "status = :status";
    $params[':status'] = $statusFilter;
}
if (!empty($configFilter)) {
    $where[] = "configuration = :config";
    $params[':config'] = $configFilter;
}
if (!empty($pickupFilter)) {
    $where[] = "chauffeured_pickup = :pickup";
    $params[':pickup'] = $pickupFilter;
}

$whereSql = implode(" AND ", $where);

// Total count for pagination
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM enquiries WHERE {$whereSql}");
$countStmt->execute($params);
$totalRows = (int)$countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// Fetch paginated enquiries
$querySql = "SELECT * FROM enquiries WHERE {$whereSql} ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}";
$stmt = $pdo->prepare($querySql);
$stmt->execute($params);
$enquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIP Enquiry Registry | Shaikh Empire</title>
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
        <a href="index.php">
          <i class="fas fa-th-large"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="enquiries.php" class="active">
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
        <a href="../api/export_csv.php?<?= http_build_query($_GET) ?>" target="_blank">
          <i class="fas fa-file-excel"></i> Export Filtered CSV
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

  <!-- Main Content Area -->
  <main class="admin-main">
    <header class="top-navbar">
      <div class="page-headline">
        <h1>Master VIP Enquiries Directory</h1>
        <p>Total <?= number_format($totalRows) ?> Leads Registered in Shaikh Empire Database</p>
      </div>

      <div class="nav-right-actions">
        <a href="../api/export_csv.php?<?= http_build_query($_GET) ?>" class="btn btn-secondary">
          <i class="fas fa-file-csv"></i> Export CSV
        </a>
        <a href="index.php" class="btn btn-primary-gold">
          <i class="fas fa-th-large"></i> Back to Dashboard
        </a>
      </div>
    </header>

    <div class="content-container">

      <?php if (!empty($message)): ?>
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px;">
          <i class="fas fa-check-circle"></i> <?= safeOutput($message) ?>
        </div>
      <?php endif; ?>

      <!-- Filter Controls -->
      <div class="table-card" style="padding: 20px; margin-bottom: 24px;">
        <form method="GET" action="enquiries.php" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center;">
          <div class="search-box" style="flex: 1; min-width: 250px;">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Search by name, phone, email..." value="<?= safeOutput($search) ?>" style="width: 100%;">
          </div>

          <select name="status" class="filter-select">
            <option value="">All Statuses</option>
            <option value="New" <?= $statusFilter === 'New' ? 'selected' : '' ?>>New</option>
            <option value="Contacted" <?= $statusFilter === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="Site Visit Scheduled" <?= $statusFilter === 'Site Visit Scheduled' ? 'selected' : '' ?>>Site Visit Scheduled</option>
            <option value="Negotiation" <?= $statusFilter === 'Negotiation' ? 'selected' : '' ?>>Negotiation</option>
            <option value="Closed" <?= $statusFilter === 'Closed' ? 'selected' : '' ?>>Closed</option>
            <option value="Spam" <?= $statusFilter === 'Spam' ? 'selected' : '' ?>>Spam</option>
          </select>

          <select name="config" class="filter-select">
            <option value="">All Configurations</option>
            <option value="2 BHK Royal Suite" <?= $configFilter === '2 BHK Royal Suite' ? 'selected' : '' ?>>2 BHK Royal Suite</option>
            <option value="3 BHK Imperial Suite" <?= $configFilter === '3 BHK Imperial Suite' ? 'selected' : '' ?>>3 BHK Imperial Suite</option>
            <option value="4 BHK Emperor Penthouse" <?= $configFilter === '4 BHK Emperor Penthouse' ? 'selected' : '' ?>>4 BHK Emperor Penthouse</option>
            <option value="5 BHK Presidential Sky Villa" <?= $configFilter === '5 BHK Presidential Sky Villa' ? 'selected' : '' ?>>5 BHK Presidential Sky Villa</option>
          </select>

          <select name="pickup" class="filter-select">
            <option value="">Chauffeured Pickup</option>
            <option value="Yes" <?= $pickupFilter === 'Yes' ? 'selected' : '' ?>>Yes, Requested</option>
            <option value="No" <?= $pickupFilter === 'No' ? 'selected' : '' ?>>No</option>
          </select>

          <button type="submit" class="btn btn-primary-gold">
            <i class="fas fa-filter"></i> Apply Filters
          </button>
          
          <?php if (!empty($search) || !empty($statusFilter) || !empty($configFilter) || !empty($pickupFilter)): ?>
            <a href="enquiries.php" class="btn btn-secondary">
              <i class="fas fa-times"></i> Reset
            </a>
          <?php endif; ?>
        </form>
      </div>

      <!-- Enquiries Table -->
      <div class="table-card">
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
              <?php if (empty($enquiries)): ?>
                <tr>
                  <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-search" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                    No enquiries match the specified filters.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($enquiries as $enquiry): ?>
                  <?php
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
                      <?= !empty($enquiry['visit_date']) ? date('d M, Y', strtotime($enquiry['visit_date'])) : '<span style="color: var(--text-muted);">Not specified</span>' ?>
                    </td>
                    <td>
                      <?php if ($enquiry['chauffeured_pickup'] === 'Yes'): ?>
                        <span class="badge-pickup pickup-yes"><i class="fas fa-car"></i> Yes Requested</span>
                      <?php else: ?>
                        <span class="badge-pickup pickup-no">No</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <form method="POST" action="enquiries.php?<?= http_build_query($_GET) ?>" style="display: inline-block;">
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
                      <?= date('d M, Y h:i A', strtotime($enquiry['created_at'])) ?>
                    </td>
                    <td>
                      <div style="display: flex; gap: 6px;">
                        <a href="https://wa.me/91<?= $cleanPhone ?>?text=<?= $waMsg ?>" target="_blank" class="btn-action btn-wa" title="Chat on WhatsApp">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="tel:<?= $cleanPhone ?>" class="btn-action" title="Call Client">
                          <i class="fas fa-phone"></i>
                        </a>
                        <button class="btn-action" onclick='viewLeadModal(<?= json_encode($enquiry) ?>)' title="View Full Details">
                          <i class="fas fa-eye"></i>
                        </button>
                        <form method="POST" action="enquiries.php?<?= http_build_query($_GET) ?>" onsubmit="return confirm('Delete this enquiry #<?= $enquiry['id'] ?> permanently?');" style="display:inline;">
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

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
          <div style="padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-subtle);">
            <div style="font-size: 13px; color: var(--text-muted);">
              Showing Page <?= $page ?> of <?= $totalPages ?> (Total <?= $totalRows ?> leads)
            </div>
            <div style="display: flex; gap: 8px;">
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php
                  $q = $_GET;
                  $q['page'] = $i;
                ?>
                <a href="enquiries.php?<?= http_build_query($q) ?>" class="btn <?= $i === $page ? 'btn-primary-gold' : 'btn-secondary' ?>" style="padding: 6px 12px; font-size: 12px;">
                  <?= $i ?>
                </a>
              <?php endfor; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </main>

  <!-- Lead Dossier Modal -->
  <div class="modal-overlay" id="leadModal">
    <div class="modal-box">
      <div class="modal-head">
        <h3><i class="fas fa-file-invoice"></i> VIP Lead Dossier</h3>
        <button class="modal-close" onclick="closeLeadModal()">&times;</button>
      </div>
      <div class="modal-body" id="modalDetailsContent"></div>
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

    document.getElementById('leadModal').addEventListener('click', function(e) {
      if (e.target === this) closeLeadModal();
    });
  </script>

</body>
</html>
