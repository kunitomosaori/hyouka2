<?php
// エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("../funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

//２．データ登録SQL作成
$pdo = db_conn();
$sql = "SELECT * FROM competency";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if ($status == false) {
    sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>にぎわいHR</title>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }

        .content-wrapper {
        margin-left: 25%; /* Adjust according to sidebar width */
        margin-top: 80px; /* Adjust according to header height */
        padding: 10px;
        transition: margin-left 0.3s;
    }
    </style>
</head>

<body>

<?php include('../html/sidemenu.html'); ?>
<?php include('../html/header.html'); ?>
<div class="content-wrapper">

        <!-- Main[Start] -->
        <form method="POST" action="insert_competency.php">
        <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold">行動評価登録</legend><br>

                    <label>理念浸透力：</label>
                    S<input type="radio" name="philosophy_integration" value="5" class="ml-1">
                    A<input type="radio" name="philosophy_integration" value="4" class="ml-1">
                    B<input type="radio" name="philosophy_integration" value="3" class="ml-1">
                    C<input type="radio" name="philosophy_integration" value="2" class="ml-1">
                    D<input type="radio" name="philosophy_integration" value="1" class="ml-1">
                    <br>

                    <label>目標達成力：</label>
                    S<input type="radio" name="goal_achievement" value="5" class="ml-1">
                    A<input type="radio" name="goal_achievement" value="4" class="ml-1">
                    B<input type="radio" name="goal_achievement" value="3" class="ml-1">
                    C<input type="radio" name="goal_achievement" value="2" class="ml-1">
                    D<input type="radio" name="goal_achievement" value="1" class="ml-1">
                    <br>

                    <label>問題分析力・解決案提示力：</label>
                    S<input type="radio" name="problem_analysis_solution" value="5" class="ml-1">
                    A<input type="radio" name="problem_analysis_solution" value="4" class="ml-1">
                    B<input type="radio" name="problem_analysis_solution" value="3" class="ml-1">
                    C<input type="radio" name="problem_analysis_solution" value="2" class="ml-1">
                    D<input type="radio" name="problem_analysis_solution" value="1" class="ml-1">
                    <br>

                    <label>継続力：</label>
                    S<input type="radio" name="persistence" value="5" class="ml-1">
                    A<input type="radio" name="persistence" value="4" class="ml-1">
                    B<input type="radio" name="persistence" value="3" class="ml-1">
                    C<input type="radio" name="persistence" value="2" class="ml-1">
                    D<input type="radio" name="persistence" value="1" class="ml-1">
                    <br>

                    <label>クオリティ：</label>
                    S<input type="radio" name="quality" value="5" class="ml-1">
                    A<input type="radio" name="quality" value="4" class="ml-1">
                    B<input type="radio" name="quality" value="3" class="ml-1">
                    C<input type="radio" name="quality" value="2" class="ml-1">
                    D<input type="radio" name="quality" value="1" class="ml-1">
                    <br>

                    <label>伝達力：</label>
                    S<input type="radio" name="communication" value="5" class="ml-1">
                    A<input type="radio" name="communication" value="4" class="ml-1">
                    B<input type="radio" name="communication" value="3" class="ml-1">
                    C<input type="radio" name="communication" value="2" class="ml-1">
                    D<input type="radio" name="communication" value="1" class="ml-1">
                    <br>

                    <label>チームワーク：</label>
                    S<input type="radio" name="teamwork" value="5" class="ml-1">
                    A<input type="radio" name="teamwork" value="4" class="ml-1">
                    B<input type="radio" name="teamwork" value="3" class="ml-1">
                    C<input type="radio" name="teamwork" value="2" class="ml-1">
                    D<input type="radio" name="teamwork" value="1" class="ml-1">
                    <br>

                    <label>ルール遵守：</label>
                    S<input type="radio" name="rule_compliance" value="5" class="ml-1">
                    A<input type="radio" name="rule_compliance" value="4" class="ml-1">
                    B<input type="radio" name="rule_compliance" value="3" class="ml-1">
                    C<input type="radio" name="rule_compliance" value="2" class="ml-1">
                    D<input type="radio" name="rule_compliance" value="1" class="ml-1">
                    <br>

                    <label>主体的行動：</label>
                    S<input type="radio" name="proactive_action" value="5" class="ml-1">
                    A<input type="radio" name="proactive_action" value="4" class="ml-1">
                    B<input type="radio" name="proactive_action" value="3" class="ml-1">
                    C<input type="radio" name="proactive_action" value="2" class="ml-1">
                    D<input type="radio" name="proactive_action" value="1" class="ml-1">
                    <br>

                    <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


</body>

</html>