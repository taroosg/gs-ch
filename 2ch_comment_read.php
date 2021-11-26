<?php
$dbn = 'mysql:dbname=gsacf_l06_00;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'SELECT * FROM comment_table WHERE thread_id =:thread_id ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':thread_id', $_GET['id'], PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = '';
foreach ($result as $record) {
  $output .= "<li>
    <hr/>
    <p>{$record['created_at']}</p>
    <p>{$record['comment']}</p>
  </li>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="2ch_comment_create.php" method="post">
    <fieldset>
      <legend>コメント</legend>
      <div>
        comment: <input type="text" name="comment">
      </div>
      <div>
        <button>submit</button>
      </div>
      <input type="hidden" name="thread_id" value="<?= $_GET['id'] ?>">
    </fieldset>
  </form>
  <a href="2ch_thread_read.php">スレ一覧に戻る</a>
  <ul>
    <?= $output ?>
  </ul>

</body>

</html>