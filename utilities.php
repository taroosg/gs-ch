<?php
include('env.php');

function connect_to_db()
{
  $dbn = dbn();
  $user = user();
  $pwd = pwd();

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
