<?php
// Start session and connect to the database
session_start();
include 'shjpdb.php'; // Assumes this file contains your $conn = mysqli_connect(...);

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
// Fetch counts
$requestCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM CertificateRequests WHERE status = 'Pending'"))['c'];
$approvedCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM CertificateRequests WHERE status = 'Approved'"))['c'];
$deniedCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM CertificateRequests WHERE status = 'Denied'"))['c'];
$rejectedCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM CertificateRequests WHERE status = 'Rejected'"))['c'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacred Heart of Jesus Parish - Admin Dashboard</title>
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

        .sidebar h3 {
            margin: 5px 0;
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .sidebar p {
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

        /* Active menu item */
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
            background-color: white;
        }

        .header {
            padding: 15px 0;
            font-weight: bold;
            font-size: 22px;
            color: #8b6914;
            border-bottom: 1px solid #d4af37;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }
        
        .header .logo {
            height: 30px;
            width: auto;
            margin-right: 10px;
        }

        h1 {
            color: #8b6914;
            font-size: 24px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .dashboard {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 20px;
        }

        .box {
            flex: 1;
            min-width: 180px;
            max-width: 250px;
            text-align: center;
            padding: 25px 15px;
            color: #8b6914;
            border-radius: 8px;
            background-color: #fffdf7;
            border: 1px solid #d4af37;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .box:hover {
            transform: translateY(-5px);
        }

        .count {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .label {
            font-size: 18px;
            margin-top: 5px;
            letter-spacing: 0.5px;
        }

        .view-link {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background:#fffdf7;
            color:  #8b6914;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .view-link:hover {
            background: #d4af37;
            transform: scale(1.05);
        }

        /* Responsive layout adjustments */
@media (max-width: 768px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100% !important;
        text-align: center;
    }

    .sidebar a {
        display: block;
        margin: 10px 0;
        font-size: 16px;
    }

    .main-content {
        padding: 10px;
        width: 100% !important;
    }

    .card, table {
        width: 100% !important;
        overflow-x: auto;
    }

    table {
        display: block;
    }

    th, td {
        white-space: nowrap;
    }
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
    <a href="requests_page.php" class="active">Requests</a>
    <a href="records.php">Records</a>
    <a href="logout.php" class="logout">Log out</a>
</div>

<!-- Main Dashboard Content -->
<div class="main">
    <div class="header">
        <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish
    </div>
    
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    
    <div class="dashboard">
        <div class="box">
            <div class="count"><?= $requestCount ?></div>
            <div class="label">Requests</div>
            <a href="requests_list.php?status=Pending" class="view-link">View</a>
        </div>

        <div class="box">
            <div class="count"><?= $approvedCount ?></div>
            <div class="label">Approved</div>
            <a href="approved_list.php?status=Approved" class="view-link">View</a>
        </div>

        <div class="box">
            <div class="count"><?= $rejectedCount ?></div>
            <div class="label">Rejected</div>
            <a href="rejected_list.php?status=Rejected" class="view-link">View</a>
        </div>
    </div>
</div>

</body>
</html>