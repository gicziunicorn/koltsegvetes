<?php
session_start();
require_once "connection.php";

if (!$_SESSION['user_exists']) {
    $fnev = trim($_POST['nev']);
    $pass = trim($_POST['pass']);
    try {
        $sql = "INSERT INTO adatok (nev, jelszo, egyenleg, keret) VALUES ( ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fnev, password_hash($pass, PASSWORD_DEFAULT), 0, 0]);
        $_SESSION['user_exists'] = true;
        $_SESSION['msg'] = "Felhasználó sikeresen létrehozva!";
        $_SESSION['nev'] = $fnev;
    } catch(PDOException $e) {
        $_SESSION['msg'] = "hiba: " . $e->getMessage();
    }
    header("Location: ../public/index.php");
    exit();
}
else {
    $pass = trim($_POST['pass']);
    $result = $conn->prepare("SELECT * FROM adatok WHERE nev = ?");
    $result->execute([$_SESSION['nev']]);
    $result = $result->fetch();
    $hash = $result['jelszo'];
    if (password_verify($pass, $hash)) {
        $_SESSION['msg'] = "Sikeres bejelentkezés!";
        $stmt = $conn->prepare("SELECT egyenleg, keret FROM adatok WHERE nev = ?");
        $stmt->execute([$_SESSION['nev']]);
        $result = $stmt->fetch();
        $_SESSION['egyenleg'] = $result['egyenleg'];
        $_SESSION['keret'] = $result['keret'];
        header("Location: ../public/index.php");
        exit();
    }
    else {
        $_SESSION['msg'] = "A jelszó nem egyezik!";
        header("Location: ../public/index.php");
        exit();
    }
}