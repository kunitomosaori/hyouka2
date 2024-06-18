<?php
//ajax_get.php
session_start();
include("funcs.php");
$pdo = db_conn();

// POSTリクエストからユーザーIDを取得
$id = isset($_GET['id']) ? $_GET['id'] : null;

var_dump($_GET['id']);

if (!$id) {
    echo json_encode(["error" => "できてない！"]);
    exit;
}

// データ取得SQL作成
$sql = "SELECT * FROM competency WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  sql_error($stmt);
}

// データ取得
$values = $stmt->fetch(PDO::FETCH_ASSOC);

// JSON形式でデータを返す
echo json_encode($values, JSON_UNESCAPED_UNICODE);
?>
