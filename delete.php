<?php

include_once('./database.php');

$id = $_GET['id'];

$sql = 'DELETE FROM records WHERE id = :id';

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();

header('Location: ./index.php');
exit;