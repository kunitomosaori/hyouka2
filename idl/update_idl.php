<?php
//1. POSTデータ取得
$goal_idl = $_POST["goal_idl"];
$id       = $_POST["id"];

//2. DB接続します
include("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE gs_goal_idl_table SET goal_idl=:goal_idl WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':goal_idl', $goal_idl, PDO::PARAM_STR); 
$stmt->bindValue(':id', $id, PDO::PARAM_INT); // ここでidをバインド
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select_idl.php");
}
?>
