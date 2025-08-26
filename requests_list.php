<?php
session_start();
include 'shjpdb.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    session_unset();
    session_destroy();
    header("Location: admin_loginpage.php");
    exit();
}
$username = $_SESSION["username"];
$sql = "SELECT name, email FROM Administrator WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle approve/decline action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $update = "UPDATE CertificateRequests SET status = 'Approved', date_approved = CURDATE() WHERE request_id = $request_id";
        mysqli_query($conn, $update);
        header("Location: requests_page.php");
    } elseif ($action === 'decline') {
        $update = "UPDATE CertificateRequests SET status = 'Rejected' WHERE request_id = $request_id";
        mysqli_query($conn, $update);
        header("Location: rejected_list.php");
    }
    exit();
}

$status = 'Pending';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - Pending Certificate Requests</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 0; display: flex; height: 100vh; background-color: #f9f9f9; }
        .sidebar { width: 240px; background: linear-gradient(to bottom, #d4af37, #b8860b); padding: 20px; text-align: center; height: 100vh; position: fixed; }
        .sidebar img { width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px; border: 3px solid white; background-color: white; }
        .sidebar h3, .sidebar p { color: white; }
        .sidebar a { display: block; margin: 8px 0; padding: 10px; color: white; text-decoration: none; border-radius: 4px; background-color: rgba(255, 255, 255, 0.2); }
        .sidebar a:hover { background-color: rgba(255, 255, 255, 0.3); transform: translateY(-2px); }
        .sidebar a.active { background-color: white; color: #8b6914; font-weight: bold; }
         .sidebar .username {
            margin: 5px 0;
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .sidebar .email {
            font-size: 14px;
            color: #fff8dc;
            margin-bottom: 20px;
        }
         .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: rgba(0,0,0,0.1) !important;
        }
        .main { flex: 1; padding: 30px; margin-left: 280px; background-color: white; }
        .header { display: flex; align-items: center; font-weight: bold; font-size: 22px; color: #8b6914; border-bottom: 1px solid #d4af37; margin-bottom: 20px; }
        .logo { height: 30px; margin-right: 10px; }
        .card { background-color: #fffdf7; padding: 20px; border-left: 5px solid #1e40af; margin-bottom: 15px; border-radius: 6px; }
        .card h3 { color: #1e40af; margin: 0; font-size: 18px; }
        .card p { color: #555; margin: 8px 0; }
        .submit-btn { padding: 8px 14px; border: none; border-radius: 4px; color: white; font-weight: bold; cursor: pointer; font-size: 14px; }
        .submit-btn.approve { background-color: #15803d; margin-right: 10px; }
        .submit-btn.decline { background-color: #dc2626; }
    </style>
</head>
<body>
<div class="sidebar">
    <a href="admin_profile.php">
    <img src="images/profile.jpeg" alt="Profile"></a>
    <div class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></div>
    <div class="email"><?php echo htmlspecialchars($admin["email"]); ?></div>
    <a href="admin_dashboard.php">Menu</a>
    <a href="requests_page.php" class="active">Requests</a>
    <a href="approved_list.php">Approved</a>
    <a href="rejected_list.php">Rejected</a>
    <a href="records.php">Records</a>
    <a href="logout.php" class="logout">Log out</a>
</div>

<div class="main">
    <div class="header">
        <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish
    </div>
    <h2><?= $status ?> Certificate Requests</h2>
    <?php
    $sql = "SELECT * FROM CertificateRequests WHERE status = 'Pending' ORDER BY date_requested DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card'>
                    <h3>{$row['owner_name']} ({$row['type']})</h3>
                    <p><strong>Reason:</strong> {$row['reason']}</p>
                    <p><strong>Status:</strong> {$row['status']}</p>
                    <p><strong>Date Requested:</strong> {$row['date_requested']}</p>
                    <form method='post'>
                        <input type='hidden' name='request_id' value='{$row['request_id']}'>
                        <button type='submit' name='action' value='approve' class='submit-btn approve'>Approve</button>
                        <button type='submit' name='action' value='decline' class='submit-btn decline'>Decline</button>
                    </form>
                  </div>";
        }
    } else {
        echo "<p>No pending certificate requests found.</p>";
    }
    ?>
</div>
</body>
</html>
