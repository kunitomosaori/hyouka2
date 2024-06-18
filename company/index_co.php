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
$sql = "SELECT * FROM gs_goal_co_table";
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
        <form method="POST" action="insert_co.php">
            <div class="jumbotron bg-sky-50 p-6 rounded-lg">
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold">会社目標</legend><br>
                    <label>目標：<input type="text" name="goal_co" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md" >
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


</body>

</html>