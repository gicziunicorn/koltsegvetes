<?php
session_start();
require_once "connection.php";


$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

if ($data === null) {
    echo "error: no data";
    exit;
}

$keret = $data['keret'] ?? null;

if (!$keret) {
    echo "error: missing vars";
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE adatok SET keret = ? WHERE nev = ?");
    $stmt->execute([$keret, $_SESSION['nev']]);
    $_SESSION["keret"] = $keret;
}
catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}


echo "ok";
?>