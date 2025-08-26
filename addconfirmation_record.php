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

// Handle insert
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $date = $_POST['date_confirmation'];
    $place = $_POST['place_confirmation'];
    $father = $_POST['father_name'];
    $mother = $_POST['mother_name'];
    $sponsors = $_POST['sponsors'];
    $priest = $_POST['priest_name'];

    $insert = "INSERT INTO ConfirmationRecords (full_name, date_confirmation, place_confirmation, father_name, mother_name, sponsors, priest_name)
               VALUES ('$name', '$date', '$place', '$father', '$mother', '$sponsors', '$priest')";
    mysqli_query($conn, $insert);
    header("Location: confirmation_records.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - Add Confirmation Record</title>
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

        .form-container {
            background-color: #fffdf7;
            padding: 30px;
            border-left: 5px solid #d4af37;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-radius: 6px;
            max-width: 700px;
            margin: 20px auto;
        }
        
        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #8b6914;
            font-size: 24px;
            border-bottom: 2px solid #f0e6cc;
            padding-bottom: 12px;
            text-align: center;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .input-large {
            flex: 2;
        }
        
        .input-small {
            flex: 1;
        }
        
        input, textarea {
            padding: 10px;
            width: calc(100% - 22px);
            margin: 8px 0;
            border: 1px solid #e6d7ab;
            border-radius: 4px;
            font-family: 'Times New Roman', serif;
            font-size: 16px;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        }
        
        .submit-btn {
            background-color: #d4af37;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
            width: auto;
            font-size: 16px;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: #b8860b;
        }
        
        .buttons-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .cancel-btn {
            background-color: #f0f0f0;
            color: #555;
            border: 1px solid #ddd;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
        }
        
        .cancel-btn:hover {
            background-color: #e0e0e0;
        }
        
        .form-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dotted #e6d7ab;
        }
        
        .form-section h3 {
            color: #8b6914;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-size: 15px;
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
            <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish - Add New Record
        </div>

        <div class="form-container">
            <h2>Add New Confirmation Record</h2>
            
            <form method="POST">
                <div class="form-section">
                    <h3>Confirmand Information</h3>
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Full Name" required class="input-large">
                    
                    <div class="form-row">
                        <div class="input-large">
                            <label for="date_confirmation">Date of Confirmation:</label>
                            <input type="date" id="date_confirmation" name="date_confirmation" required class="input-small">
                        </div>
                        <div class="input-large">
                            <label for="place_confirmation">Place of Confirmation:</label>
                            <input type="text" id="place_confirmation" name="place_confirmation" placeholder="Place of Confirmation" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Family Information</h3>
                    <div class="form-row">
                        <div class="input-large">
                            <label for="father_name">Father's Name:</label>
                            <input type="text" id="father_name" name="father_name" placeholder="Father's Name">
                        </div>
                        <div class="input-large">
                            <label for="mother_name">Mother's Name:</label>
                            <input type="text" id="mother_name" name="mother_name" placeholder="Mother's Name">
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Sacrament Details</h3>
                    <label for="sponsors">Sponsors:</label>
                    <input type="text" id="sponsors" name="sponsors" placeholder="Sponsors">
                    
                    <label for="priest_name">Priest:</label>
                    <input type="text" id="priest_name" name="priest_name" placeholder="Priest">
                </div>
                
                <div class="buttons-container">
                    <a href="confirmation_records.php" class="cancel-btn">Cancel</a>
                    <input type="submit" value="Save Record" class="submit-btn">
                </div>
            </form>
        </div>
    </div>

</body>
</html>