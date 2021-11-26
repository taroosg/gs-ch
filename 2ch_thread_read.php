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

$sql = 'SELECT * FROM thread_table LEFT OUTER JOIN (SELECT thread_id, COUNT(*) AS count FROM comment_table GROUP BY thread_id) AS count_table ON thread_table.id = count_table.thread_id ORDER BY updated_at DESC;';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = '';
foreach ($result as $record) {
  $output .= "<li><a href=./2ch_comment_read.php?id={$record['id']}>{$record['name']}({$record['count']})</li>";
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
  <form action="2ch_thread_create.php" method="post">
    <fieldset>
      <legend>スレ建て</legend>
      <div>
        スレッド名: <input type="text" name="name">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

  <ul>
    <?= $output ?>
  </ul>

</body>

</html>