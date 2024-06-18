<?php
session_start();

// ?idがセットされているか確認
if (!isset($_GET["id"])) {
    echo "IDが設定されていません。";
    exit();
}

$id = $_GET["id"]; //?id~**を受け取る

// エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

include("../funcs.php");
sschk();

$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_goal_co_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
    if (!$row) {
        echo "データが見つかりませんでした。";
        exit();
    }
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

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
        <form method="POST" action="update_co.php">
        <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
        <fieldset class="space-y-4">
                <legend class="text-xl font-bold">会社目標</legend><br>
                    <label>目標：<input type="text" name="goal_co" value="<?= h($row['goal_co']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md" >
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


</body>

</html>