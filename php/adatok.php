<?php
session_start();
require_once 'connection.php';

$bevetelek_result = $conn->query("SELECT * FROM tranzakciok");
$bevetelek = [];
if($bevetelek_result->rowCount() > 0) {
    while ($row = $bevetelek_result->fetch(\PDO::FETCH_ASSOC)) {
        $bevetelek[] = $row;
    }
}

$kiadasok_result = $conn->query("SELECT * FROM tranzakciok");
$kiadasok = [];
if($kiadasok_result->rowCount() > 0) {
    while ($row = $kiadasok_result->fetch(\PDO::FETCH_ASSOC)) {
        $kiadasok[] = $row;
    }
}


echo nl2br(json_encode( ['egyenleg' => $_SESSION['egyenleg'], 'keret' => $_SESSION['keret'], 'bevetelek' => $bevetelek, 'kiadasok' => $kiadasok], JSON_UNESCAPED_UNICODE));

?>