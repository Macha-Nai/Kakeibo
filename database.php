<?php

  $dsn = "mysql:dbname=kakei;host=localhost;charset=utf8";
  $username = "kakei";
  $passoword = "kakei";

try {

  $pdo = new PDO($dsn, $username, $passoword,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );

} catch (PDOException $e) {

    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());

}