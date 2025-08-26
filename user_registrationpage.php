<?php
session_start();
include 'shjpdb.php';

if (isset($_SESSION["username"])) {
    header("Location: user_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $dob = $_POST["dob"];
    $address = trim($_POST["address"]);
    $contact_number = trim($_POST["contact_number"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $insert = "INSERT INTO parishioners (full_name, dob, address, contact_number, email, username, password, date_registered)
               VALUES ('$full_name', '$dob', '$address', '$contact_number', '$email', '$username', '$password', CURDATE())";
    mysqli_query($conn, $insert);

    header("Location: user_loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - User Registration</title>
    <style>
        body { 
            font-family: 'Times New Roman', serif; 
            background-color: #f9f9f9; 
            background-image: url('church_bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        
        form { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 20px 35px; 
            border-radius: 8px; 
            box-shadow: 0 0 20px rgba(184, 134, 11, 0.3); 
            width: 320px; 
            text-align: center; 
            border: 1px solid #d4af37;
        }
        
        .logo {
            width: 100px;
            margin-bottom: 15px;
        }
        
        .parish-title {
            font-size: 24px;
            color: #8b6914;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .system-title {
            font-size: 18px;
            color: #666666;
            margin-bottom: 15px;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 15px;
        }
        
        input { 
            padding: 8px; 
            margin: 3px 0; 
            width: 100%; 
            border-radius: 4px; 
            border: 1px solid #d4af37; 
            font-size: 14px;
            box-sizing: border-box;
            background-color: #fffdf7;
        }
        
        input:focus {
            outline: none;
            border: 1px solid #8b6914;
            box-shadow: 0 0 5px rgba(184, 134, 11, 0.3);
        }

        #birthdate {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }

        #birthdate label {
            width: 41%;
            margin-top: 12px;
            color: #666666;
        }
        
        button {
            padding: 12px;
            margin-top: 15px;
            width: 100%; 
            border-radius: 4px;
            border: none;
            background-color: #d4af37;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        button:hover {
            background-color: #b8860b;
        }
        
        p.error { 
            color: #8b0000; 
            font-size: 14px;
            margin: 10px 0;
            padding: 8px;
            background-color: #fff8f8;
            border-radius: 4px;
        }

        #haveanaccount {
            color: #666666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="post">
        <img src="images/logo2.png" alt="Logo" class="logo">
        <div class="parish-title">Sacred Heart of Jesus Parish</div>
        <div class="system-title">User Registration</div>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="full_name" placeholder="Full Name" required maxlength="100">
        <div id="birthdate">
            <label>Date of Birth:</label>
            <input type="date" name="dob" placeholder="Date of Birth" required>
        </div>
        <input type="text" name="address" placeholder="Address" required maxlength="255">
        <input type="text" name="contact_number" placeholder="Contact Number" required maxlength="20">
        <input type="email" name="email" placeholder="Email" required maxlength="100">
        <input type="text" name="username" placeholder="Username" required maxlength="50">
        <input type="password" name="password" placeholder="Password" required maxlength="255">
        <button type="submit">Register</button>
        <div id="haveanaccount">
            <label>Already have an account?</label>
            <a href="user_loginpage.php">Log In</a>
        </div>
    </form>
</body>
</html>