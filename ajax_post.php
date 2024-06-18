<?php
//ajax_post.php
session_start();
include("funcs.php");
$pdo = db_conn();

// POSTリクエストからユーザーIDを取得
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

if (!$user_id) {
    echo json_encode(["error" => "No user_id provided"]);
    exit;
}

// データ取得SQL作成
$sql = "SELECT * FROM competency WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  sql_error($stmt);
}

// データ取得
$values = $stmt->fetch(PDO::FETCH_ASSOC);

// JSON形式でデータを返す
echo json_encode($values, JSON_UNESCAPED_UNICODE);
?>
