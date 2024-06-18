<?php
//エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//1. POSTデータ取得
$goal_co = $_POST["goal_co"];


//2. DB接続します
include("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_goal_co_table(goal_co)VALUES(:goal_co)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':goal_co', $goal_co, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index_co.php");
}
?>
