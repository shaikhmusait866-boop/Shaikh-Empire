<?php
/**
 * Shaikh Empire - Real-Time Visitor Analytics Tracker
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getDB();

    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddress = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $pageUrl = $_GET['page'] ?? $_SERVER['REQUEST_URI'] ?? '/';
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $stmt = $pdo->prepare("
        INSERT INTO site_analytics (ip_address, user_agent, page_url, referrer, visited_at)
        VALUES (:ip, :agent, :page, :ref, NOW())
    ");
    $stmt->execute([
        ':ip'    => $ipAddress,
        ':agent' => mb_substr($userAgent, 0, 500),
        ':page'  => mb_substr($pageUrl, 0, 255),
        ':ref'   => mb_substr($referrer, 0, 255)
    ]);

    echo json_encode(['tracked' => true]);
} catch (Exception $e) {
    echo json_encode(['tracked' => false, 'error' => $e->getMessage()]);
}
