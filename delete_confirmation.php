<?php
session_start();
include 'shjpdb.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    session_unset();
    session_destroy();
    header("Location: admin_loginpage.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM ConfirmationRecords WHERE confirmationrecord_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: records.php");
exit();
