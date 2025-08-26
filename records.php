<?php 
session_start(); 
include 'shjpdb.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    session_unset();
    session_destroy();
    header("Location: admin_loginpage.php");
    exit();
}
// Get admin info
$username = $_SESSION["username"];
$sql = "SELECT name, email FROM Administrator WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?> 
<!DOCTYPE html> 
<html> 
<head>     
    <title>Sacred Heart of Jesus Parish - Records</title>     
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
            margin-left: 280px;
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
            margin-bottom: 40px;
        }

        .record-types {
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
            padding: 35px 25px;
            color: #8b6914;
            border-radius: 8px;
            background-color: #fffdf7;
            border: 1px solid #d4af37;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .icon {
            font-size: 42px;
            margin-bottom: 15px;
            color: #d4af37;
        }

        .label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .view-link {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background-color: #8b6914;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .view-link:hover {
            background-color: #d4af37;
            transform: scale(1.05);
        }
        
    </style>
</head> 
<body>  

<!-- Sidebar -->
<div class="sidebar">
    <a href="admin_profile.php">
        <img src="images/profile.jpeg" alt="Profile">
    </a>
    <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    <div class="email"><?php echo htmlspecialchars($admin['email']); ?></div>
    
    <a href="admin_dashboard.php">Menu</a>
    <a href="requests_page.php">Requests</a>
    <a href="records.php" class="active">Records</a>
    <a href="logout.php" class="logout">Log out</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="header">
        <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish
    </div>
    
    <h1>Manage Parish Records</h1>
    
    <div class="record-types">
        <div class="box">
            <div class="icon">📜</div>
            <div class="label">Baptismal Records</div>
            <a href="baptismal_records.php" class="view-link">View</a>
        </div>

        <div class="box">
            <div class="icon">✝️</div>
            <div class="label">Confirmation Records</div>
            <a href="confirmation_records.php" class="view-link">View</a>
        </div>
    </div>
</div>

</body> 
</html>