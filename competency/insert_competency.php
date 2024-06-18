<?php
//エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//1. POSTデータ取得
$philosophy_integration    = $_POST["philosophy_integration"];
$goal_achievement          = $_POST["goal_achievement"];
$problem_analysis_solution = $_POST["problem_analysis_solution"];
$persistence               = $_POST["persistence"];
$quality                   = $_POST["quality"];
$communication             = $_POST["communication"];
$teamwork                  = $_POST["teamwork"];
$rule_compliance           = $_POST["rule_compliance"];
$proactive_action          = $_POST["proactive_action"];

//2. DB接続します
include("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO competency(
    philosophy_integration,goal_achievement,problem_analysis_solution,persistence,quality,communication,teamwork,rule_compliance,proactive_action
  )VALUES(
    :philosophy_integration, :goal_achievement, :problem_analysis_solution, :persistence, :quality, :communication, :teamwork, :rule_compliance, :proactive_action
  )";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':philosophy_integration',    $philosophy_integration,    PDO::PARAM_INT);
$stmt->bindValue(':goal_achievement',          $goal_achievement,          PDO::PARAM_INT);
$stmt->bindValue(':problem_analysis_solution', $problem_analysis_solution, PDO::PARAM_INT);
$stmt->bindValue(':persistence',               $persistence,               PDO::PARAM_INT);
$stmt->bindValue(':quality',                   $quality,                   PDO::PARAM_INT);
$stmt->bindValue(':communication',             $communication,             PDO::PARAM_INT);
$stmt->bindValue(':teamwork',                  $teamwork,                  PDO::PARAM_INT);
$stmt->bindValue(':rule_compliance',           $rule_compliance,           PDO::PARAM_INT);
$stmt->bindValue(':proactive_action',          $proactive_action,          PDO::PARAM_INT);

$status = $stmt->execute(); //実行


//４．データ登録処理後
if ($status == false) {
  sql_error($stmt);
} else {
  redirect("index_competency.php");
}
