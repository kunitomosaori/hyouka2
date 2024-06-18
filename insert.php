<?php
//エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//1. POSTデータ取得
$name         = $_SESSION["name"]; // セッションから名前を取得
$goal         = $_POST["goal"];
$comment      = $_POST["comment"];
$comment_boss = $_POST["comment_boss"];
$evaluation   = $_POST["evaluation"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_an_table(name,goal,comment,comment_boss,evaluation,indate)VALUES(:name,:goal,:comment,:comment_boss,:evaluation,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',         $name,         PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':goal',         $goal,         PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment',      $comment,      PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment_boss', $comment_boss, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':evaluation',   $evaluation,   PDO::PARAM_INT);        //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}
?>
