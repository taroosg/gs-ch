<?php

if (
  !isset($_POST['comment']) || $_POST['comment'] === ''
) {
  exit('paramError');
}

$comment = $_POST['comment'];
$thread_id = $_POST['thread_id'];

$dbn = 'mysql:dbname=gsacf_l06_00;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'INSERT INTO comment_table VALUES (NULL, :thread_id, :comment, now(), now())';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'UPDATE thread_table SET updated_at=now() WHERE id=:thread_id';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:2ch_comment_read.php?id={$thread_id}");
exit();
