<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sacred Heart Of Jesus Parish Information System</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Times New Roman', serif;
      background-color: #f9f9f9;
      background-image: url('church_bg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background: linear-gradient(135deg, #8b6914, #d4af37);
      color: white;
      padding: 20px 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      flex-wrap: wrap;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .logo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: 2px solid white;
    }

    .navbar h1 {
      font-size: 24px;
      font-weight: bold;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .nav-links {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 10px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 25px;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .nav-links a:hover {
      background-color: rgba(255, 255, 255, 0.2);
      border: 2px solid white;
      transform: translateY(-2px);
    }

    .main-content {
      flex: 1;
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px 40px 20px;
    }

    .welcome-section {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 5px 25px rgba(184, 134, 11, 0.3);
      text-align: center;
      margin-bottom: 30px;
      border: 1px solid #d4af37;
    }

    .welcome-section h2 {
      color: #8b6914;
      font-size: 32px;
      margin-bottom: 20px;
    }

    .footer {
      background: linear-gradient(135deg, #8b6914, #d4af37);
      color: white;
      text-align: center;
      padding: 30px 20px;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer p {
      font-size: 16px;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
      .nav-container {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }

      .logo-section {
        justify-content: center;
      }

      .navbar h1 {
        font-size: 20px;
      }

      .nav-links {
        gap: 10px;
      }

      .nav-links a {
        padding: 8px 16px;
        font-size: 14px;
      }

      .welcome-section {
        padding: 25px;
      }

      .welcome-section h2 {
        font-size: 24px;
      }

      .footer {
        padding: 20px 15px;
      }

      .footer p {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <!-- NAVIGATION -->
  <div class="navbar">
    <div class="nav-container">
      <div class="logo-section">
        <img src="images/logo2.png" alt="Sacred Heart Logo" class="logo" />
        <h1>Sacred Heart Of Jesus Parish</h1>
      </div>
      <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="user_loginpage.php">User Login</a>
        <a href="admin_loginpage.php">Admin Login</a>
      </div>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main-content">
    <div class="welcome-section">
      <h2>Welcome to Team B's Parish Information System</h2>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <div class="footer-content">
      <p>&copy; <?php echo date('Y'); ?> Sacred Heart of Jesus Parish Information System. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
