<?php
require_once "connection.php";


$fnev = $_POST['nev'];
$pass = $_POST['pass'];

$stmt = $conn->prepare("SELECT nev, jelszo FROM adatok WHERE nev = ?;");
$stmt->execute([$fnev]);


if ($stmt->rowCount() > 0) {
    echo "A felhasználó már létezik";
    $result = $stmt->fetch();
    $hash = $result['jelszo'];
    if (password_verify($pass, $hash)) {
        echo "<br>OK";
    }
    else { echo "<br>NOT !!! OK"; }
} else {
    try {
        echo "A felhasználó nem lát";
        $sql = "INSERT INTO adatok (`id`, `egyenleg`, `nev`, `jelszo`, `keret`) VALUES (NULL, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([0, $fnev, password_hash($pass, PASSWORD_DEFAULT), 0]);
        echo "Siker";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
