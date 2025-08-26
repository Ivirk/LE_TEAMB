<?php
session_start();
include 'shjpdb.php';

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: admin_dashboard.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    header("Location: user_loginpage.php");
    exit();
}

// Handle search
$search = $_GET['search'] ?? '';
$searchTerm = "%$search%";

$parishioner_id = $_SESSION['parishioner_id'];

$stmt = $conn->prepare("SELECT * FROM CertificateRequests WHERE parishioner_id = ? AND owner_name LIKE ? ORDER BY date_requested DESC");
$stmt->bind_param("is", $parishioner_id, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - Track Certificates</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f9f9f9;
        }

        .sidebar {
            width: 240px;
            background-color: #d4af37;
            background-image: linear-gradient(to bottom, #d4af37, #b8860b);
            padding: 20px;
            text-align: center;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
        }

        .sidebar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid white;
            background-color: white;
        }

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

        .sidebar a {
            display: block;
            margin: 8px 0;
            padding: 10px;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .sidebar a.active {
            background-color: white;
            color: #8b6914;
            font-weight: bold;
        }

        .logout {
            position: absolute;
            bottom: 60px;
            left: 20px;
            background-color: rgba(0,0,0,0.1) !important;
        }

        .logout:hover {
            background-color: rgba(0,0,0,0.2) !important;
        }

        .main {
            flex: 1;
            padding: 30px;
            margin-left: 280px;
            background-color: white;
            overflow-y: auto;
        }

        .header {
            padding: 15px 0;
            font-weight: bold;
            font-size: 30px;
            color: #d4af37;
            border-bottom: 1px solid #d4af37;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 100px;
            margin-right: 15px;
        }

        .top-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            min-width: 300px;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #d4af37;
            border-radius: 4px;
            font-family: 'Times New Roman', serif;
        }

        .submit-btn {
            background-color: #d4af37;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .submit-btn:hover {
            background-color: #b8860b;
        }

        .record {
            background-color: #fffdf7;
            margin-bottom: 18px;
            padding: 22px;
            border-left: 5px solid #d4af37;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 6px;
            transition: transform 0.3s;
        }

        .record:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.14);
        }

        .record h4 {
            margin: 0 0 12px 0;
            color: #8b6914;
            font-size: 20px;
            padding-bottom: 6px;
            border-bottom: 1px dotted #e6d7ab;
        }

        .record p {
            margin: 7px 0;
            color: #555;
            line-height: 1.5;
            font-size: 16px;
        }

        .records-section {
            margin-top: 20px;
        }

        .records-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #e6d7ab;
            padding-bottom: 8px;
        }

        .records-title {
            color: #8b6914;
            margin: 0;
            font-size: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="default-avatar.png" alt="Profile">
        <div class="username"><?= htmlspecialchars($_SESSION['username']) ?></div>
        <div class="email">user@gmail.com</div>

        <a href="user_dashboard.php">Menu</a>
        <a href="request_certificate.php">Request</a>
        <a href="track_certificate.php" class="active">Track</a>
        <a href="userlogout.php" class="logout">Log out</a>
    </div>  

    <!-- Main content -->
    <div class="main">
        <div class="header">
            <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish - Track Certificates
        </div>

        <div class="top-container">
            <form method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Search by name..." value="<?= htmlspecialchars($search) ?>">
                <input type="submit" value="Search" class="submit-btn">
            </form>
        </div>

        <div class="records-section">
            <div class="records-header">
                <h3 class="records-title">Certificate Requests</h3>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="record">
                        <h4><?= htmlspecialchars($row['owner_name']) ?> – <?= htmlspecialchars($row['date_requested']) ?></h4>
                        <p>Type: <?= htmlspecialchars($row['type']) ?></p>
                        <p>Reason: <?= htmlspecialchars($row['reason']) ?></p>
                        <p>Status: <?= htmlspecialchars($row['status']) ?></p>

                        <?php
                        // Show Baptismal or Confirmation ID if approved and exists
                        if ($row['status'] === 'Approved') {
                            $request_id = $row['request_id'];
                            
                            if ($row['type'] === 'Baptismal') {
                                $stmt_bap = $conn->prepare("SELECT baptismal_id FROM BaptismalCertificate WHERE request_id = ?");
                                $stmt_bap->bind_param("i", $request_id);
                                $stmt_bap->execute();
                                $res_bap = $stmt_bap->get_result();
                                if ($bap = $res_bap->fetch_assoc()) {
                                    echo "<p><strong>Baptismal ID:</strong> " . htmlspecialchars($bap['baptismal_id']) . "</p>";
                                }
                            } elseif ($row['type'] === 'Confirmation') {
                                $stmt_conf = $conn->prepare("SELECT confirmation_id FROM ConfirmationCertificate WHERE request_id = ?");
                                $stmt_conf->bind_param("i", $request_id);
                                $stmt_conf->execute();
                                $res_conf = $stmt_conf->get_result();
                                if ($conf = $res_conf->fetch_assoc()) {
                                    echo "<p><strong>Confirmation ID:</strong> " . htmlspecialchars($conf['confirmation_id']) . "</p>";
                                }
                            }
                        }
                        ?>

                        <?php if ($row['status'] === 'Approved'): ?>
                            <a href="generate_cert.php?request_id=<?= urlencode($row['request_id']) ?>" class="submit-btn" style="margin-top: 10px;">Download Certificate</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No certificate requests found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
