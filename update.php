<?php
include_once('./database.php');

$date = $_POST['date'];
$title = $_POST['title'];
$details = $_POST['details'];
$amount = $_POST['amount'];
$id = $_POST['id'];
$type = 1;

if ($title == "仕送り" or $title == "給与" or $title == "その他の収入"){
    $type = 0;
}

$sql = "UPDATE records SET title = :title, details = :details, type = :type, amount = :amount, date = :date, updated = now() WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':details', $details, PDO::PARAM_STR);
$stmt->bindParam(':type', $type, PDO::PARAM_INT);
$stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();

header('Location: ./index.php');
exit;