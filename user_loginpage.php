<?php
session_start();

if (isset($_SESSION["username"])) {
    header("Location: user_dashboard.php");
    exit();
}

$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "shjp";

// Connect function
function connectToMySql($dbname, $servername = "localhost", $username = "root", $password = "") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $conn = connectToMySql($dbname, $servername, $usernameDB, $passwordDB);

    // Select user using plain text match
    $stmt = $conn->prepare("SELECT * FROM parishioners WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();

        // Set session and redirect
        $_SESSION["username"] = $user["username"];
        $_SESSION["parishioner_id"] = $user["parishioner_id"];
        $_SESSION["role"] = "user";
        setcookie("username", $user["username"], time() + (86400 * 30), "/");

        header("Location: user_dashboard.php"); // Make sure this file exists
        exit();
    } else {
        $error = "Account does not exist.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sacred Heart of Jesus Parish - User Login</title>
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
    padding: 20px;
}

.home-button {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #d4af37;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(184, 134, 11, 0.3);
    cursor: pointer;
}

.home-button:hover {
    background-color: #b8860b;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(184, 134, 11, 0.4);
}

form { 
    background: rgba(255, 255, 255, 0.95); 
    padding: 30px 20px; 
    border-radius: 8px; 
    box-shadow: 0 0 20px rgba(184, 134, 11, 0.3); 
    width: 100%; 
    max-width: 340px; 
    text-align: center; 
    border: 1px solid #d4af37;
}

.logo {
    width: 80px;
    margin-bottom: 15px;
}

.parish-title {
    font-size: 22px;
    color: #8b6914;
    margin-bottom: 5px;
    font-weight: bold;
}

.system-title {
    font-size: 16px;
    color: #666666;
    margin-bottom: 25px;
    border-bottom: 1px solid #d4af37;
    padding-bottom: 15px;
}

input { 
    padding: 12px; 
    margin: 10px 0; 
    width: 100%; 
    border-radius: 4px; 
    border: 1px solid #d4af37; 
    font-size: 16px;
    background-color: #fffdf7;
    box-sizing: border-box;
}

input:focus {
    outline: none;
    border: 1px solid #8b6914;
    box-shadow: 0 0 5px rgba(184, 134, 11, 0.3);
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

#donthaveaccount {
    color: #666666;
    margin-top: 15px;
    font-size: 14px;
}

#donthaveaccount a {
    color: #d4af37;
    text-decoration: none;
    font-weight: bold;
}

#donthaveaccount a:hover {
    color: #b8860b;
    text-decoration: underline;
}

/* Fully mobile-friendly adjustments */
@media (max-width: 480px) {
    body {
        padding: 10px;
        background-attachment: scroll;
    }

    .home-button {
        top: 10px;
        left: 10px;
        padding: 8px 15px;
        font-size: 12px;
    }

    form {
        padding: 25px 15px;
        width: 100%;
        max-width: 90vw;
    }

    .parish-title {
        font-size: 20px;
    }

    .system-title {
        font-size: 15px;
    }

    input, button {
        font-size: 15px;
        padding: 10px;
    }
}

    </style>
</head>
<body>
    <a href="index.php" class="home-button">Home</a>
    
    <form method="post">
        <img src="images/logo2.png" alt="Logo" class="logo">
        <div class="parish-title">Sacred Heart of Jesus Parish</div>
        <div class="system-title">User Login</div>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
        <div id="donthaveaccount">
            <label>Don't have an account?</label>
            <a href="user_registrationpage.php">Sign Up</a>
        </div>
    </form>
</body>
</html>