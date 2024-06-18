<?php
// エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

// 0. SESSION開始
session_start();

// 1. 関数群の読み込み
include("funcs.php");

// LOGINチェック
sschk();

// データベース接続
$pdo = db_conn();

// gs_an_tableのデータ取得
$sql_an = "SELECT philosophy_integration, goal_achievement, problem_analysis_solution, persistence, quality, communication, teamwork, rule_compliance, proactive_action FROM gs_an_table";
$stmt_an = $pdo->prepare($sql_an);
$status_an = $stmt_an->execute();

if ($status_an == false) {
  sql_error($stmt_an);
}

$values_an = $stmt_an->fetchAll(PDO::FETCH_ASSOC);

// gs_goal_co_tableのデータ取得
$sql_co = "SELECT * FROM gs_goal_co_table";
$stmt_co = $pdo->prepare($sql_co);
$status_co = $stmt_co->execute();

if ($status_co == false) {
  sql_error($stmt_co);
}

$values_co = $stmt_co->fetchAll(PDO::FETCH_ASSOC);

// user_Infoのデータ取得
$sql_user_info = "
    SELECT 
        ui.user_id, 
        d.department_name, 
        g.grade_name, 
        p.position_name, 
        u.name 
    FROM user_info ui
    JOIN department d ON ui.department_id = d.id
    JOIN grade g ON ui.grade_id = g.id
    JOIN position p ON ui.position_id = p.id
    JOIN gs_user_table u ON ui.user_id = u.id
";
$stmt_user_info = $pdo->prepare($sql_user_info);
$status_user_info = $stmt_user_info->execute();

if ($status_user_info == false) {
  sql_error($stmt_user_info);
}

$values_user_info = $stmt_user_info->fetchAll(PDO::FETCH_ASSOC);

// JSON形式でデータを返す
header('Content-Type: application/json');
echo json_encode([
    'an_table' => $values_an,
    'goal_co_table' => $values_co,
    'user_info' => $values_user_info
], JSON_UNESCAPED_UNICODE);
?>
