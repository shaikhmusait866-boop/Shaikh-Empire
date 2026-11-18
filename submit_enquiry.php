<?php
/**
 * Shaikh Empire - Enquiry Submission API Handler
 * Securely processes customer leads, stores in MySQL, and routes directly to WhatsApp: +91 8104129866
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/db.php';

$rawInput = file_get_contents('php://input');
$data = [];
if (!empty($rawInput)) {
    $jsonDecoded = json_decode($rawInput, true);
    if (is_array($jsonDecoded)) {
        $data = $jsonDecoded;
    }
}
if (empty($data)) {
    $data = $_POST;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
    exit;
}

// 1. Anti-Spam Honeypot Check
if (!empty($data['website_hp'])) {
    echo json_encode([
        'success' => true,
        'message' => 'Your enquiry has been received.'
    ]);
    exit;
}

// 2. Extract and Sanitize Inputs
$fullName         = trim($data['full_name'] ?? '');
$phone            = trim($data['phone'] ?? '');
$email            = trim($data['email'] ?? '');
$propertyName     = trim($data['property_name'] ?? 'Shaikh Empire');
$configuration    = trim($data['configuration'] ?? '');
$visitDate        = trim($data['visit_date'] ?? '');
$chauffeuredPickup= trim($data['chauffeured_pickup'] ?? 'No');
$specialRequest   = trim($data['special_request'] ?? '');

$errors = [];

// 3. Validation Rules
if (empty($fullName) || mb_strlen($fullName) < 3) {
    $errors[] = 'Please provide your full legal name (minimum 3 characters).';
}

$cleanPhone = preg_replace('/[^0-9]/', '', $phone);
if (empty($cleanPhone) || strlen($cleanPhone) < 10 || strlen($cleanPhone) > 15) {
    $errors[] = 'Please provide a valid 10-digit mobile number.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

$validConfigs = [
    '2 BHK Royal Suite',
    '3 BHK Imperial Suite',
    '4 BHK Emperor Penthouse',
    '5 BHK Presidential Sky Villa',
    'Palatial Duplex Penthouse',
    'General Enquiry'
];
if (empty($configuration)) {
    $configuration = '2 BHK Royal Suite';
}

$chauffeuredPickup = (strcasecmp($chauffeuredPickup, 'Yes') === 0 || $chauffeuredPickup === '1') ? 'Yes' : 'No';

$formattedVisitDate = null;
if (!empty($visitDate)) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $visitDate);
    if ($dateObj && $dateObj->format('Y-m-d') === $visitDate) {
        $today = new DateTime('today');
        if ($dateObj >= $today) {
            $formattedVisitDate = $visitDate;
        } else {
            $errors[] = 'Preferred visit date cannot be in the past.';
        }
    } else {
        $errors[] = 'Please select a valid visit date format (YYYY-MM-DD).';
    }
}

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors),
        'errors'  => $errors
    ]);
    exit;
}

// 4. Client Metadata
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipAddress = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
}
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// 5. Store in MySQL Database using Prepared Statement (Non-blocking for WhatsApp)
$enquiryId = null;
$dbSaved = false;

try {
    $pdo = getDB();
    if ($pdo) {
        $stmt = $pdo->prepare("
            INSERT INTO enquiries (
                full_name,
                phone,
                email,
                property_name,
                configuration,
                visit_date,
                chauffeured_pickup,
                special_request,
                status,
                ip_address,
                user_agent,
                created_at
            ) VALUES (
                :full_name,
                :phone,
                :email,
                :property_name,
                :configuration,
                :visit_date,
                :chauffeured_pickup,
                :special_request,
                'New',
                :ip_address,
                :user_agent,
                NOW()
            )
        ");

        $stmt->execute([
            ':full_name'          => $fullName,
            ':phone'              => $phone,
            ':email'              => $email,
            ':property_name'      => $propertyName,
            ':configuration'      => $configuration,
            ':visit_date'         => $formattedVisitDate,
            ':chauffeured_pickup' => $chauffeuredPickup,
            ':special_request'    => $specialRequest,
            ':ip_address'         => $ipAddress,
            ':user_agent'         => mb_substr($userAgent, 0, 500)
        ]);

        $enquiryId = $pdo->lastInsertId();
        $dbSaved = true;
    }
} catch (Throwable $e) {
    error_log("Database notice (proceeding with WhatsApp): " . $e->getMessage());
    $dbSaved = false;
}

// 6. Direct WhatsApp Routing to Owner (+91 8104129866)
$ownerWhatsApp = '918104129866';

$visitDateDisplay = !empty($formattedVisitDate) ? $formattedVisitDate : 'Not specified';
$specialRequestDisplay = !empty($specialRequest) ? $specialRequest : 'None provided';

$waMessageLines = [
    "👑 *NEW VIP ENQUIRY - SHAIKH EMPIRE*",
    "━━━━━━━━━━━━━━━━━━━━",
    "👤 *Full Name:* " . $fullName,
    "📞 *Mobile Number:* " . $phone,
    "✉️ *Email Address:* " . $email,
    "🏛️ *Property Selection:* " . $propertyName,
    "🏡 *Preferred Configuration:* " . $configuration,
    "📅 *Preferred Visit Date:* " . $visitDateDisplay,
    "🚗 *Chauffeured Pickup:* " . $chauffeuredPickup,
    "💬 *Special Request / Message:* " . $specialRequestDisplay,
    "━━━━━━━━━━━━━━━━━━━━",
    "✨ *Sent from Shaikh Empire Website*"
];

if (!empty($enquiryId)) {
    array_splice($waMessageLines, 2, 0, ["📋 *Lead Ref ID:* #" . $enquiryId]);
}

$waText = urlencode(implode("\n", $waMessageLines));
$waLink = "https://wa.me/{$ownerWhatsApp}?text={$waText}";

echo json_encode([
    'success'      => true,
    'message'      => 'Thank you, ' . htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') . '! Your VIP enquiry is being sent directly to WhatsApp (+91 81041 29866)...',
    'enquiry_id'   => $enquiryId,
    'whatsapp_url' => $waLink,
    'db_saved'     => $dbSaved
]);
