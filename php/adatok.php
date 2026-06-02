<?php
session_start();
require_once 'connection.php';

$transactions_result = $conn->query("SELECT * FROM tranzakciok");
$transactions = [];
if($transactions_result->rowCount() > 0) {
    while ($row = $transactions_result->fetch(\PDO::FETCH_ASSOC)) {
        $transactions[] = $row;
    }
}


echo nl2br(json_encode( ['egyenleg' => $_SESSION['egyenleg'], 'keret' => $_SESSION['keret'], 'transactions' => $transactions], JSON_UNESCAPED_UNICODE));

?>