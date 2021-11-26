<?php

if (
  !isset($_POST['name']) || $_POST['name'] === ''
) {
  echo '<p>Param Error...</p>';
  echo '<a href="2ch_thread_read.php">back</a>';
  exit();
}

if (
  $_POST['password'] !== 'gsacf1111'
) {
  echo '<p>Invalid Password...</p>';
  echo '<a href="2ch_thread_read.php">back</a>';
  exit();
}

$name = $_POST['name'];

include('utilities.php');

$pdo = connect_to_db();

$sql = 'INSERT INTO thread_table  VALUES (NULL, :name, now(), now())';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':name', $name, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:2ch_thread_read.php');
exit();
