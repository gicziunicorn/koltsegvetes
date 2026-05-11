<?php
session_start();
require_once "./php/connection.php";

$stmt = $conn->query("SELECT nev FROM adatok;");

$_SESSION['user_exists'] = ($stmt->rowCount() > 0);
if ($_SESSION['user_exists']) {
    $_SESSION['nev'] = $stmt->fetchColumn();
}
header("Location: ./public/");
exit;
?>