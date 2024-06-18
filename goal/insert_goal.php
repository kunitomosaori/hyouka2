<?php
//エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//1. POSTデータ取得
$idl_goal        = $_POST["idl_goal"]; // セッションから名前を取得
$target_budget   = $_POST["target_budget"];
$profit_budget   = $_POST["profit_budget"];
$improvement     = $_POST["improvement"];
$schedule        = $_POST["schedule"];
$comment         = $_POST["comment"];
$evaluation      = $_POST["evaluation"];

//2. DB接続します
include("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_goal_table(idl_goal,target_budget,profit_budget,improvement,schedule,comment,evaluation)VALUES(:idl_goal,:target_budget,:profit_budget,:improvement,:schedule,:comment,:evaluation)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':idl_goal',      $idl_goal,      PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':target_budget', $target_budget, PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':profit_budget', $profit_budget, PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':improvement',   $improvement,   PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':schedule',      $schedule,      PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment',       $comment,       PDO::PARAM_STR); // Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':evaluation',    $evaluation,    PDO::PARAM_INT); // Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index_goal.php");
}
?>
