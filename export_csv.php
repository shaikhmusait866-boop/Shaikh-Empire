<?php
/**
 * Shaikh Empire - Export Enquiries to CSV / Excel
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Authentication check: Must be logged in as admin
if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    die("Access denied. Please login to the Admin Dashboard to export enquiries.");
}

try {
    $pdo = getDB();

    $statusFilter = $_GET['status'] ?? '';
    $search = $_GET['search'] ?? '';

    $query = "SELECT * FROM enquiries WHERE 1=1";
    $params = [];

    if (!empty($statusFilter)) {
        $query .= " AND status = :status";
        $params[':status'] = $statusFilter;
    }

    if (!empty($search)) {
        $query .= " AND (full_name LIKE :search OR phone LIKE :search OR email LIKE :search)";
        $params[':search'] = "%{$search}%";
    }

    $query .= " ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    // Prepare CSV headers
    $filename = 'shaikh_empire_enquiries_' . date('Y-m-d_His') . '.csv';
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output stream
    $output = fopen('php://output', 'w');

    // UTF-8 BOM for Microsoft Excel proper Hindi / Unicode rendering
    fputs($output, "\xEF\xBB\xBF");

    // CSV Header row
    fputcsv($output, [
        'Enquiry ID',
        'Submission Date & Time',
        'Full Name',
        'Mobile Number',
        'Email Address',
        'Property Name',
        'Preferred Configuration',
        'Preferred Visit Date',
        'Chauffeured Pickup',
        'Lead Status',
        'Special Request / Message',
        'Visitor IP'
    ]);

    // Data rows
    foreach ($rows as $r) {
        fputcsv($output, [
            $r['id'],
            $r['created_at'],
            $r['full_name'],
            $r['phone'],
            $r['email'],
            $r['property_name'],
            $r['configuration'],
            $r['visit_date'] ?? 'Not specified',
            $r['chauffeured_pickup'],
            $r['status'],
            $r['special_request'] ?? '',
            $r['ip_address'] ?? ''
        ]);
    }

    fclose($output);
    exit;

} catch (Exception $e) {
    die("Export Error: " . $e->getMessage());
}
