<?php
include_once('./database.php');

$date = $_POST['date'];
$title = $_POST['title'];
$details = $_POST['details'];
$amount = $_POST['amount'];
$type = 1;

if ($title == "仕送り" or $title == "給与" or $title == "その他の収入"){
    $type = 0;
}

// INSERT文の作成
$sql = "INSERT INTO records(title, details, type, amount, date, created) VALUES(:title, :details, :type, :amount, :date, now())";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':details', $details, PDO::PARAM_STR);
$stmt->bindParam(':type', $type, PDO::PARAM_INT);
$stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);

$stmt->execute();

header('Location: ./index.php');
exit;