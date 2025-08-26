<?php
session_start();
include 'shjpdb.php';

if ($_SESSION["role"] === "admin") {
    header("Location: admin_dashboard.php");
    exit();
}
if (!isset($_SESSION['username'])) {
    header("Location: user_loginpage.php");
    exit();
}

// Handle insert
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parishioner_id = $_SESSION["parishioner_id"];
    $type = $_POST["type"];
    $name = $_POST["owner_name"];
    $father = $_POST["father_name"];
    $mother = $_POST["mother_name"];
    $reason = $_POST["reason"];

    $insert = "INSERT INTO CertificateRequests (parishioner_id, type, owner_name, father_name, mother_name, reason, date_requested, status)
                VALUES ('$parishioner_id', '$type', '$name', '$father', '$mother', '$reason', CURDATE(), 'Pending')";
    mysqli_query($conn, $insert);
    header("Location: track_certificate.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            padding: 10px 20px;
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
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .cancel-btn {
            background-color: #f0f0f0;
            color: #555;
            border: 1px solid #ddd;
            margin-top: 10px;
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

        .radio-row {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        .radio-row input {
            margin-left: 30px;
        }

        .radio-row label {
            margin-top: 7px;
        }

        @media (max-width: 768px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .main {
        margin-left: 0;
        padding: 20px;
    }

    .form-row {
        flex-direction: column;
    }

    .radio-row {
        flex-direction: column;
        gap: 5px;
    }

    .button-group {
        flex-direction: column;
        gap: 10px;
    }

    .submit-btn, .cancel-btn {
        width: 100%;
        text-align: center;
    }
}
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="default-avatar.png" alt="Profile">
        <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
        <div class="email">user@gmail.com</div>

        <a href="user_dashboard.php">Dashboard</a>
        <a href="request_certificate.php" class="active">Request</a>
        <a href="track_certificate.php">Track</a>
        <a href="userlogout.php" class="logout">Log out</a>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="header">
            <img src="images/logo2.png" alt="Logo" class="logo"> Sacred Heart of Jesus Parish - Request Certificate
        </div>

        <div class="form-container">
            <h2>Request Certificate</h2>
            
            <form method="POST">
                <div class="form-section">
                    <h3>Type of Certificate:</h3>
                    <div class="form-row">
                        <div class="radio-row">
                            <input type="radio" id="baptismal" name="type" value="Baptismal" required>
                            <label for="baptismal">Baptismal</label>
                        <div class="radio-row">
                            <input type="radio" id="confirmation" name="type" value="Confirmation" required>
                            <label for="confirmation">Confirmation</label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Family Information</h3>

                    <label for="owner_name">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name" placeholder="Owner Name" required maxlength="100" class="input-large">

                    <div class="form-row">
                        <div class="input-large">
                            <label for="father_name">Father's Name:</label>
                            <input type="text" id="father_name" name="father_name" placeholder="Father's Name" required maxlength="100" class="input-small">
                        </div>
                        <div class="input-large">
                            <label for="mother_name">Mother's Name:</label>
                            <input type="text" id="mother_name" name="mother_name" placeholder="Mother's Name" required maxlength="100" class="input-small">
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Details</h3>
                    <label for="reason">Reason for Request:</label>
                    <input type="text" id="reason" name="reason" placeholder="Reason for Request" required maxlength="255" class="input-large">
                </div>
                
                <div class="button-group">
                    <input type="submit" value="Request Certificate" class="submit-btn">
                    <a href="user_dashboard.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>