<?php

if (
  !isset($_POST['name']) || $_POST['name'] === ''
) {
  echo '<p>Param Error...</p>';
  echo '<a href="2ch_thread_read.php">back</a>';
  exit();
}

if (
  $_POST['name'] !== 'password'
) {
  echo '<p>Invalid Password...</p>';
  echo '<a href="2ch_thread_read.php">back</a>';
  exit();
}

$name = $_POST['name'];

$dbn = 'mysql:dbname=gsacf_l06_00;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

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
