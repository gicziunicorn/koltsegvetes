<?php
session_start();
require_once "connection.php";


$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

if ($data === null) {
    echo "error: no data";
    exit;
}

$osszeg   = $data['osszeg'] ?? null;
$idopont  = $data['idopont'] ?? null;
$category = $data['category'] ?? null;
$note     = $data['note'] ?? null;

if (!$osszeg || !$idopont || !$category || !$note) {
    echo "error: missing vars";
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO tranzakciok (id, osszeg, idopont, kategoria, note) VALUES (NULL, ?, ?, ?, ?)");
    $stmt->execute([$osszeg, $idopont, $category, $note]);
    $stmt = $conn->prepare("UPDATE adatok SET egyenleg = egyenleg + ?");
    $stmt->execute([$osszeg]);
}
catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}


echo "ok";
?>