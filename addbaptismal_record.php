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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $date = $_POST['date_baptism'];
    $place = $_POST['place_baptism'];
    $father = $_POST['father_name'];
    $mother = $_POST['mother_name'];
    $godfather = $_POST['godfather'];
    $godmother = $_POST['godmother'];
    $priest = $_POST['priest_name'];

    $insert = $conn->prepare("INSERT INTO BaptismalRecords 
        (full_name, date_baptism, place_baptism, father_name, mother_name, godfather, godmother, priest_name) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("ssssssss", $name, $date, $place, $father, $mother, $godfather, $godmother, $priest);
    
    if ($insert->execute()) {
        $_SESSION['message'] = "Baptismal record added successfully!";
        header("Location: baptismal_records.php");
        exit();
    } else {
        $error = "Error adding record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - Add Baptismal Record</title>
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
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .header {
            font-size: 30px;
            margin-right: 10px;
            color: #d4af37;
        }
        .logo {
           width: 100px;
        }

        h1 {
            color: #8b6914;
            font-size: 24px;
            margin-top: 30px;
        }

        p {
            color: #555;
            line-height: 1.6;
        }
        
        .form-container {
            margin: 20px auto;
            background-color: #fffdf7;
            padding: 25px;
            border-left: 5px solid #d4af37;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-radius: 6px;
            max-width: 700px;
        }
        
        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #8b6914;
            font-size: 22px;
            border-bottom: 1px solid #f0e6cc;
            padding-bottom: 10px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .input-large {
            flex: 2;
        }
        
        .input-small {
            flex: 1;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #8b6914;
            font-weight: bold;
            font-size: 15px;
        }
        
        input, textarea {
            padding: 10px;
            width: calc(100% - 22px);
            border: 1px solid #e6d7ab;
            border-radius: 4px;
            font-family: 'Times New Roman', serif;
            font-size: 15px;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        button, .btn {
            background-color: #d4af37;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        button:hover, .btn:hover {
            background-color: #b8860b;
        }
        
        .btn-cancel {
            background-color: #f0f0f0;
            color: #555;
        }
        
        .btn-cancel:hover {
            background-color: #e0e0e0;
        }
        
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
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

        <a href="admin_dashboard.php">Dashboard</a>
        <a href="requests_page.php">Requests</a>
        <a href="records.php" class="active">Records</a>
        <a href="logout.php" class="logout">Log out</a>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="header">
            <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish - Add Baptismal Record
        </div>

        <div class="form-container">
            <h2>Add New Baptismal Record</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter full name" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group input-large">
                        <label for="place_baptism">Place of Baptism</label>
                        <input type="text" id="place_baptism" name="place_baptism" placeholder="Enter place of baptism" required>
                    </div>
                    <div class="form-group input-small">
                        <label for="date_baptism">Date of Baptism</label>
                        <input type="date" id="date_baptism" name="date_baptism" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group input-large">
                        <label for="father_name">Father's Name</label>
                        <input type="text" id="father_name" name="father_name" placeholder="Enter father's name">
                    </div>
                    <div class="form-group input-large">
                        <label for="mother_name">Mother's Name</label>
                        <input type="text" id="mother_name" name="mother_name" placeholder="Enter mother's name">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group input-large">
                        <label for="godfather">Godfather</label>
                        <input type="text" id="godfather" name="godfather" placeholder="Enter godfather's name">
                    </div>
                    <div class="form-group input-large">
                        <label for="godmother">Godmother</label>
                        <input type="text" id="godmother" name="godmother" placeholder="Enter godmother's name">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="priest_name">Priest</label>
                    <input type="text" id="priest_name" name="priest_name" placeholder="Enter priest's name">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn">Save Record</button>
                    <a href="baptismal_records.php" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>