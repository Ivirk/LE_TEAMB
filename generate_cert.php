<?php
session_start();
include 'shjpdb.php';

if (!isset($_SESSION['username'])) header("Location: user_loginpage.php");
if (!isset($_GET['request_id'])) die("Error: No certificate request found.");

$request_id = (int)$_GET['request_id'];
$user_id = $_SESSION['parishioner_id'];

// Get certificate request
$stmt = $conn->prepare("SELECT * FROM CertificateRequests WHERE request_id=? AND parishioner_id=? AND status='Approved'");
$stmt->bind_param("ii", $request_id, $user_id);
$stmt->execute();
$cert = $stmt->get_result()->fetch_assoc();
if (!$cert) die("Error: Certificate not found or not approved.");

// Get record from Baptismal or Confirmation table
function getRecord($conn, $table, $name) {
    foreach (["full_name = ?", "UPPER(full_name) = UPPER(?)"] as $clause) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE $clause");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        if ($r = $stmt->get_result()->fetch_assoc()) return $r;
    }
    return [];
}

$record = $cert['type'] === 'Baptismal' 
    ? getRecord($conn, 'BaptismalRecords', $cert['owner_name']) 
    : getRecord($conn, 'ConfirmationRecords', $cert['owner_name']);
if (!$record) die("Error: No {$cert['type']} record found.");

// Generate certificate number if missing
if (empty($cert['certificate_number'])) {
    $cert['certificate_number'] = "SHJP-" . date('Y') . "-" . str_pad($request_id, 6, "0", STR_PAD_LEFT);
    $stmt = $conn->prepare("UPDATE CertificateRequests SET certificate_number=? WHERE request_id=?");
    $stmt->bind_param("si", $cert['certificate_number'], $request_id);
    $stmt->execute();
}

// Set up details
$type = ucfirst($cert['type']);
$name = htmlspecialchars($cert['owner_name']);
$today = date("F j, Y");
$father = htmlspecialchars($record['father_name'] ?? $cert['father_name'] ?? 'Not specified');
$mother = htmlspecialchars($record['mother_name'] ?? $cert['mother_name'] ?? 'Not specified');
$purpose = htmlspecialchars($cert['reason']);

if ($cert['type'] === 'Baptismal') {
    $date = date("F j, Y", strtotime($record['date_baptism'] ?? '')) ?: 'Date on file';
    $place = htmlspecialchars($record['place_baptism'] ?? 'Sacred Heart of Jesus Parish');
    $officiant = htmlspecialchars($record['priest_name'] ?? 'Parish Priest');
    $godfather = htmlspecialchars($record['godfather'] ?? 'Not specified');
    $godmother = htmlspecialchars($record['godmother'] ?? 'Not specified');
    $sponsorRow = "
        <div class='detail-row'><span class='label'>Godfather:</span><span class='value'>$godfather</span></div>
        <div class='detail-row'><span class='label'>Godmother:</span><span class='value'>$godmother</span></div>";
} else {
    $date = date("F j, Y", strtotime($record['date_confirmation'] ?? '')) ?: 'Date on file';
    $place = htmlspecialchars($record['place_confirmation'] ?? 'Sacred Heart of Jesus Parish');
    $officiant = htmlspecialchars($record['priest_name'] ?? 'Parish Priest');
    $sponsors = htmlspecialchars($record['sponsors'] ?? 'Not specified');
    $sponsorRow = "
        <div class='detail-row'><span class='label'>Sponsors:</span><span class='value'>$sponsors</span></div>";
}

$certText = "This is to certify that <strong>$name</strong> was " . 
    strtolower($type) . " in this Parish on $date according to the rites of the Roman Catholic Church.";

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Certificate of $type</title>
    <style>
        body { font-family: "Times New Roman", serif; background: #f5f5f5; padding: 20px; margin: 0; }
        .certificate { width: 800px; margin: auto; background: #fff; padding: 60px; border: 10px solid #d4af37; box-shadow: 0 10px 30px rgba(0,0,0,0.1); position: relative; }
        .decorative-border { position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; border: 2px solid #f0f0f0; pointer-events: none; }
        .header, .footer, .cert-title, .recipient, .cert-text, .given-text { text-align: center; }
        .parish-name { font-size: 26px; color: #8b6914; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .parish-address { font-size: 14px; color: #666; }
        .cert-title { font-size: 32px; color: #8b6914; margin: 30px 0; text-transform: uppercase; font-weight: bold; letter-spacing: 2px; }
        .recipient { font-size: 28px; color: #8b6914; margin: 30px 0; font-weight: bold; text-transform: uppercase; border-bottom: 3px solid #d4af37; padding-bottom: 10px; }
        .cert-text { font-size: 16px; margin: 30px 0; line-height: 1.8; color: #333; }
        .details { margin: 40px 0; font-size: 14px; background: #fafafa; padding: 25px; border-radius: 5px; border-left: 4px solid #d4af37; }
        .detail-row { margin: 12px 0; display: flex; align-items: flex-start; }
        .label { font-weight: bold; color: #8b6914; width: 140px; flex-shrink: 0; }
        .value { flex: 1; color: #333; }
        .given-text { margin: 30px 0; font-style: italic; color: #666; font-size: 15px; }
        .footer { margin-top: 50px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature-line { border-bottom: 2px solid #333; width: 200px; height: 40px; margin: 0 auto 10px; }
        .cert-number { text-align: center; margin-top: 30px; font-size: 12px; color: #999; border-top: 1px solid #eee; padding-top: 15px; }
        @media print { body { background: white; padding: 0; } .certificate { box-shadow: none; } }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="decorative-border"></div>
        <div class="header">
            <div class="parish-name">Sacred Heart of Jesus Parish</div>
            <div class="parish-address">Barrio Obrero, Davao City<br>Tel: (082) 227-0397</div>
        </div>
        <div class="cert-title">Certificate of $type</div>
        <div class="recipient">$name</div>
        <div class="cert-text">$certText</div>
        <div class="details">
            <div class="detail-row"><span class="label">Father's Name:</span><span class="value">$father</span></div>
            <div class="detail-row"><span class="label">Mother's Name:</span><span class="value">$mother</span></div>
            $sponsorRow
            <div class="detail-row"><span class="label">Date of $type:</span><span class="value">$date</span></div>
            <div class="detail-row"><span class="label">Place:</span><span class="value">$place</span></div>
            <div class="detail-row"><span class="label">Officiant:</span><span class="value">$officiant</span></div>
            <div class="detail-row"><span class="label">Purpose:</span><span class="value">$purpose</span></div>
        </div>
        <div class="given-text">Given this $today at Sacred Heart of Jesus Parish, Davao City</div>
        <div class="footer">
            <div><strong>Date Issued:</strong><br>$today</div>
            <div>
                <div class="signature-line"></div>
                <strong>Msgr. Paul A. Cuison</strong><br>Parish Priest
            </div>
        </div>
        <div class="cert-number">Certificate No: {$cert['certificate_number']}</div>
    </div>
</body>
</html>
HTML;

if (isset($_GET['download'])) {
    $filename = "Certificate_{$cert['type']}_" . preg_replace('/\W+/', '_', $cert['owner_name']) . '_' . date('Y-m-d') . '.html';
    header("Content-Type: text/html; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo $html;
    exit;
}

echo "<div style='text-align:center; padding:20px; background:#f5f5f5;'>
        <h2>Certificate Preview</h2>
        <p style='color:#666;'>Review before downloading</p>
        <a href='?request_id=$request_id&download=1' 
           style='background:#d4af37; color:white; padding:12px 25px; text-decoration:none; border-radius:5px; font-weight:bold; box-shadow:0 2px 5px rgba(0,0,0,0.2);'>
           📄 Download Certificate
        </a>
      </div>";
echo $html;
?>
