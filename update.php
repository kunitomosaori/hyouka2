<?php
//1. POSTデータ取得
$name         = $_POST["name"];
$goal         = $_POST["goal"];
$comment      = $_POST["comment"];
$comment_boss = $_POST["comment_boss"];
$evaluation   = $_POST["evaluation"];
$id           = $_POST["id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE gs_an_table SET name=:name, goal=:goal, comment=:comment, comment_boss=:comment_boss, evaluation=:evaluation WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',         $name,         PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':goal',         $goal,         PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment',      $comment,      PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment_boss', $comment_boss, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':evaluation',   $evaluation,   PDO::PARAM_INT);        //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',           $id,           PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select.php");
}
?>
