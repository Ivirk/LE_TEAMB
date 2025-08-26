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

$status = $_GET['status'] ?? 'Rejected';
?> 
<!DOCTYPE html> 
<html> 
<head>     
    <title>Rejected Certificates</title>     
    <style>
        body { font-family: 'Times New Roman', serif; margin: 0; display: flex; height: 100vh; background-color: #f9f9f9; }
        .sidebar { width: 240px; background: linear-gradient(to bottom, #d4af37, #b8860b); padding: 20px; text-align: center; height: 100vh; position: fixed; }
        .sidebar img { width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px; border: 3px solid white; background-color: white; }
        .sidebar .username { font-size: 18px; font-weight: bold; color: white; margin: 5px 0; }
        .sidebar .email { font-size: 14px; color: #fff8dc; margin-bottom: 20px; }
        .sidebar a { display: block; margin: 8px 0; padding: 10px; background-color: rgba(255, 255, 255, 0.2); color: white; text-decoration: none; border-radius: 4px; }
        .sidebar a:hover { background-color: rgba(255, 255, 255, 0.3); transform: translateY(-2px); }
        .sidebar a.active { background-color: white; color: #8b6914; font-weight: bold; }
        .logout { position: absolute; bottom: 20px; left: 20px; background-color: rgba(0,0,0,0.1) !important; }
        .main { flex: 1; padding: 30px; margin-left: 280px; background-color: white; }
        .header { font-size: 22px; font-weight: bold; text-align: center; color: #8b6914; border-bottom: 1px solid #d4af37; margin-bottom: 20px; padding: 15px 0; }
        .card { background-color: #fffdf7; padding: 20px; border-left: 5px solid #dc2626; margin-bottom: 15px; border-radius: 6px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); }
        .card h3 { color: #dc2626; font-size: 18px; margin: 0; }
        .card p { color: #555; margin: 8px 0; }
    </style>
</head> 
<body>  
<div class="sidebar">     
    <a href="admin_profile.php"><img src="images/profile.jpeg" alt="Profile"></a>
    <div class="username"><?= htmlspecialchars($_SESSION["username"]); ?></div>
    <div class="email"><?= htmlspecialchars($admin["email"]); ?></div>
    <a href="admin_dashboard.php">Menu</a>     
    <a href="requests_page.php">Requests</a>     
    <a href="approved_list.php">Approved</a>     
    <a href="rejected_list.php" class="active">Rejected</a>     
    <a href="records.php">Records</a>     
    <a href="logout.php" class="logout">Log out</a> 
</div>  

<div class="main">     
    <div class="header">Rejected Certificates</div>     
    <?php     
    $sql = "SELECT * FROM CertificateRequests WHERE status = 'Rejected' ORDER BY date_requested DESC";     
    $result = mysqli_query($conn, $sql);     
    if (mysqli_num_rows($result) > 0) {         
        while ($row = mysqli_fetch_assoc($result)) {             
            echo "<div class='card'>                     
                    <h3>{$row['owner_name']} ({$row['type']})</h3>                     
                    <p><strong>Reason:</strong> {$row['reason']}</p>                     
                    <p><strong>Status:</strong> {$row['status']}</p>                     
                    <p><strong>Date Requested:</strong> {$row['date_requested']}</p>                   
                  </div>";         
        }     
    } else {         
        echo "<p>No rejected certificates found.</p>";     
    }     
    ?> 
</div>  
</body> 
</html>
