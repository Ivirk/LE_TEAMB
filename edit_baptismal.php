<?php
session_start();
include 'shjpdb.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    session_unset();
    session_destroy();
    header("Location: admin_loginpage.php");
    exit();
}

// Fetch admin details
$username = $_SESSION["username"];
$sql_admin = "SELECT name, email FROM Administrator WHERE username = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $username);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();
$admin = $result_admin->fetch_assoc();

$id = $_GET['id'];
$sql = "SELECT * FROM BaptismalRecords WHERE baptismalrecord_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $date_baptism = $_POST['date_baptism'];
    $place_baptism = $_POST['place_baptism'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $godfather = $_POST['godfather'];
    $godmother = $_POST['godmother'];
    $priest_name = $_POST['priest_name'];

    $update = $conn->prepare("UPDATE BaptismalRecords SET full_name=?, date_baptism=?, place_baptism=?, father_name=?, mother_name=?, godfather=?, godmother=?, priest_name=? WHERE baptismalrecord_id=?");
    $update->bind_param("ssssssssi", $full_name, $date_baptism, $place_baptism, $father_name, $mother_name, $godfather, $godmother, $priest_name, $id);
    
    if ($update->execute()) {
        $success_message = "Update successful!";
        // Refresh the record data to show updated values
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - Edit Baptismal Record</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .sidebar {
            width: 240px;
            background-color: #d4af37;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid white;
            background-color: white;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .sidebar .username {
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .sidebar .email {
            color: white;
            font-size: 14px;
            text-align: center;
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

        .main {
            margin-left: 280px;
            padding: 30px;
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            color: #8b6914;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 15px;
            margin-bottom: 30px;
            width: 100%;
            text-align: left;
        }

        .logo {
            width: 100px;
            vertical-align: middle;
            margin-right: 10px;
        }

        h2 {
            color: #8b6914;
            font-size: 24px;
            margin-bottom: 20px;
            width: 100%;
            text-align: left;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
            text-align: center;
            font-weight: bold;
        }

        .form-container {
            background-color: #fffdf7;
            padding: 30px;
            border-left: 5px solid #d4af37;
            border-radius: 6px;
            width: 100%;
            max-width: 600px;
        }

        .form-container h3 {
            color: #8b6914;
            font-size: 20px;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-container p {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-style: italic;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d4af37;
            border-radius: 4px;
            font-size: 16px;
            font-family: 'Times New Roman', serif;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        input[type="text"]:focus, input[type="date"]:focus {
            border-color: #b8860b;
            outline: none;
        }

        input[type="text"]::placeholder {
            color: #999;
            font-style: italic;
        }

        .form-actions {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .submit-btn {
            background-color: #d4af37;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
        }

        .submit-btn:hover {
            background-color: #b8860b;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .cancel-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

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

    <div class="main">
        <div class="header">
            <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish - Edit Baptismal Record
        </div>

        <h2>Edit Baptismal Record</h2>
        
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="form-container">
            <h3>Baptismal Record Details</h3>
            <p>Update the information below to modify this baptismal record</p>
            
            <input type="text" id="full_name" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($record['full_name']) ?>" required>
            <input type="date" id="date_baptism" name="date_baptism" value="<?= $record['date_baptism'] ?>" required>
            <input type="text" id="place_baptism" name="place_baptism" placeholder="Place of Baptism" value="<?= htmlspecialchars($record['place_baptism']) ?>" required>
            <input type="text" id="father_name" name="father_name" placeholder="Father's Name" value="<?= htmlspecialchars($record['father_name']) ?>" required>
            <input type="text" id="mother_name" name="mother_name" placeholder="Mother's Name" value="<?= htmlspecialchars($record['mother_name']) ?>" required>
            <input type="text" id="godfather" name="godfather" placeholder="Godfather" value="<?= htmlspecialchars($record['godfather']) ?>" required>
            <input type="text" id="godmother" name="godmother" placeholder="Godmother" value="<?= htmlspecialchars($record['godmother']) ?>" required>
            <input type="text" id="priest_name" name="priest_name" placeholder="Priest Name" value="<?= htmlspecialchars($record['priest_name']) ?>" required>

            <div class="form-actions">
                <input type="submit" value="Update Record" class="submit-btn">
                <a href="baptismal_records.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>