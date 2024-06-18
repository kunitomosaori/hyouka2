<?php
//1. POSTデータ取得
$goal_co  = $_POST["goal_co"];
$id       = $_POST["id"];

//2. DB接続します
include("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE gs_goal_co_table SET goal_co=:goal_co WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':goal_co', $goal_co, PDO::PARAM_STR); 
$stmt->bindValue(':id', $id, PDO::PARAM_INT); // ここでidをバインド
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select_co.php");
}
?>
