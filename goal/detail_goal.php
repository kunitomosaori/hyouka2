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
$stmt = $pdo->prepare("SELECT * FROM gs_goal_table WHERE id=:id");
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>にぎわいHR</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

<body id="main">

<?php include('../html/sidemenu.html'); ?>
<?php include('../html/header.html'); ?>
<div class="content-wrapper">


        <!-- Main[Start] -->
        <form method="POST" action="update_goal.php">
            <div class="jumbotron bg-sky-50 p-6 rounded-lg">
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold">人事評価シート 更新</legend>
                    <label>個人目標：<input type="text" name="idl_goal" value="<?= h($row['idl_goal']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <label>目標予算：<input type="text" name="target_budget" value="<?= h($row['target_budget']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <label>粗利益予算：<input type="text" name="profit_budget" value="<?= h($row['profit_budget']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <label>改善目標：<input type="text" name="improvement" value="<?= h($row['improvement']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <label>スケジュール：<input type="text" name="schedule" value="<?= h($row['schedule']) ?>" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
                    <label>コメント：<textarea name="comment" rows="4" cols="40" class="mt-1 block w-full border-gray-300 rounded-md"><?= h($row['comment']) ?></textarea></label><br>
                    <label>評価：
                        <input type="radio" name="evaluation" value="0" <?= $row['evaluation'] == '0' ? 'checked' : '' ?> class="ml-1"> S
                        <input type="radio" name="evaluation" value="1" <?= $row['evaluation'] == '1' ? 'checked' : '' ?> class="ml-1"> A
                        <input type="radio" name="evaluation" value="2" <?= $row['evaluation'] == '2' ? 'checked' : '' ?> class="ml-1"> B
                        <input type="radio" name="evaluation" value="3" <?= $row['evaluation'] == '3' ? 'checked' : '' ?> class="ml-1"> C
                    </label><br>
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


</body>

</html>