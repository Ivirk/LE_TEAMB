<?php
session_start();
require 'shjpdb.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    session_unset();
    session_destroy();
    header("Location: admin_loginpage.php");
    exit();
}
// View admin info
$username = $_SESSION["username"];
$sql = "SELECT name, username, email, contact_number FROM Administrator WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .profile-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background-color: white;
            border: 2px solid #d4af37;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #8b6914;
            margin-bottom: 20px;
        }

        .profile-info {
            font-size: 18px;
            line-height: 1.8;
        }

        .label {
            font-weight: bold;
            color: #b8860b;
            display: inline-block;
            width: 150px;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #8b6914;
            text-decoration: none;
            font-weight: bold;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Administrator Profile</h2>
    <div class="profile-info">
        <div><span class="label">Name:</span> <?php echo htmlspecialchars($admin["name"]); ?></div>
        <div><span class="label">Username:</span> <?php echo htmlspecialchars($admin["username"]); ?></div>
        <div><span class="label">Email:</span> <?php echo htmlspecialchars($admin["email"]); ?></div>
        <div><span class="label">Contact Number:</span> <?php echo htmlspecialchars($admin["contact_number"]); ?></div>
    </div>
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
