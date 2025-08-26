<?php 
include 'shjpdb.php'; 
session_start();

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

$status = $_GET['status'] ?? 'Approved';
?> 
<!DOCTYPE html> 
<html> 
<head>     
    <title>Approved Certificates</title>     
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
            bottom: 20px;
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
        }

        .header {
            padding: 15px 0;
            font-weight: bold;
            font-size: 22px;
            color: #8b6914;
            border-bottom: 1px solid #d4af37;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            background-color: #fffdf7;
            margin-bottom: 15px;
            padding: 20px;
            border-left: 5px solid #15803d;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-radius: 6px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin: 0;
            color: #15803d;
            font-size: 18px;
        }

        .card p {
            margin: 8px 0;
            color: #555;
            line-height: 1.4;
        }
        
        .card p strong {
            color: #8b6914;
        }
       
    </style> 
</head> 
<body>  

<!-- Sidebar --> 
<div class="sidebar">     
    <a href="admin_profile.php">
    <img src="images/profile.jpeg" alt="Profile"></a>
    <div class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></div>
    <div class="email"><?php echo htmlspecialchars($admin["email"]); ?></div>
    <a href="admin_dashboard.php">Menu</a>     
    <a href="requests_page.php" class="<?= $status === 'Request' ? 'active' : '' ?>">Requests</a>     
    <a href="approved_list.php" class="<?= $status === 'Approved' ? 'active' : '' ?>">Approved</a>     
    <a href="rejected_list.php" class="<?= $status === 'Denied' ? 'active' : '' ?>">Rejected</a>     
    <a href="records.php">Records</a>     
    <a href="logout.php" class="logout">Log out</a> 
</div>  

<!-- Main content --> 
<div class="main">     
    <div class="header">         
        Approved Certificates     
    </div>          
    <?php     
    $sql = "SELECT * FROM CertificateRequests WHERE status = 'Approved' ORDER BY date_requested DESC";     
    $result = mysqli_query($conn, $sql);     
    if (mysqli_num_rows($result) > 0) {         
        while ($row = mysqli_fetch_assoc($result)) {             

            $baptismal_id = '';
            $confirmation_id = '';
            $request_id = $row['request_id']; // ensure we have the ID

            // Fetch related certificate ID based on type
            if ($row['type'] === 'Baptismal') {
                $query = $conn->prepare("SELECT baptismal_id FROM BaptismalCertificate WHERE request_id = ?");
                $query->bind_param("i", $request_id);
                $query->execute();
                $res = $query->get_result();
                if ($baptismal = $res->fetch_assoc()) {
                    $baptismal_id = $baptismal['baptismal_id'];
                }
            } elseif ($row['type'] === 'Confirmation') {
                $query = $conn->prepare("SELECT confirmation_id FROM ConfirmationCertificate WHERE request_id = ?");
                $query->bind_param("i", $request_id);
                $query->execute();
                $res = $query->get_result();
                if ($confirmation = $res->fetch_assoc()) {
                    $confirmation_id = $confirmation['confirmation_id'];
                }
            }

            echo "<div class='card'>                     
                    <h3>{$row['owner_name']} ({$row['type']})</h3>                     
                    <p><strong>Reason:</strong> {$row['reason']}</p>                     
                    <p><strong>Status:</strong> {$row['status']}</p>                     
                    <p><strong>Date Requested:</strong> {$row['date_requested']}</p>";

            if ($baptismal_id) {
                echo "<p><strong>Baptismal ID:</strong> $baptismal_id</p>";
            }

            if ($confirmation_id) {
                echo "<p><strong>Confirmation ID:</strong> $confirmation_id</p>";
            }

            echo "</div>";         
        }     
    } else {         
        echo "<p>No approved certificates found.</p>";     
    }     
    ?> 
</div>  

</body> 
</html>
