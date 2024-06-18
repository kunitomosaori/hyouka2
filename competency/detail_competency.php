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
$stmt = $pdo->prepare("SELECT * FROM competency WHERE id=:id");
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

function isChecked($value, $current) {
    return $value == $current ? 'checked' : '';
}
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
        <form method="POST" action="update_competency.php">
        <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold">行動評価 更新</legend>
                    <label>理念浸透力：</label>
                    S<input type="radio" name="philosophy_integration" value="5" class="ml-1" <?= isChecked(5, $row['philosophy_integration']) ?>>
                    A<input type="radio" name="philosophy_integration" value="4" class="ml-1" <?= isChecked(4, $row['philosophy_integration']) ?>>
                    B<input type="radio" name="philosophy_integration" value="3" class="ml-1" <?= isChecked(3, $row['philosophy_integration']) ?>>
                    C<input type="radio" name="philosophy_integration" value="2" class="ml-1" <?= isChecked(2, $row['philosophy_integration']) ?>>
                    D<input type="radio" name="philosophy_integration" value="1" class="ml-1" <?= isChecked(1, $row['philosophy_integration']) ?>>
                    <br>

                    <label>目標達成力：</label>
                    S<input type="radio" name="goal_achievement" value="5" class="ml-1" <?= isChecked(5, $row['goal_achievement']) ?>>
                    A<input type="radio" name="goal_achievement" value="4" class="ml-1" <?= isChecked(4, $row['goal_achievement']) ?>>
                    B<input type="radio" name="goal_achievement" value="3" class="ml-1" <?= isChecked(3, $row['goal_achievement']) ?>>
                    C<input type="radio" name="goal_achievement" value="2" class="ml-1" <?= isChecked(2, $row['goal_achievement']) ?>>
                    D<input type="radio" name="goal_achievement" value="1" class="ml-1" <?= isChecked(1, $row['goal_achievement']) ?>>
                    <br>

                    <label>問題分析力・解決案提示力：</label>
                    S<input type="radio" name="problem_analysis_solution" value="5" class="ml-1" <?= isChecked(5, $row['problem_analysis_solution']) ?>>
                    A<input type="radio" name="problem_analysis_solution" value="4" class="ml-1" <?= isChecked(4, $row['problem_analysis_solution']) ?>>
                    B<input type="radio" name="problem_analysis_solution" value="3" class="ml-1" <?= isChecked(3, $row['problem_analysis_solution']) ?>>
                    C<input type="radio" name="problem_analysis_solution" value="2" class="ml-1" <?= isChecked(2, $row['problem_analysis_solution']) ?>>
                    D<input type="radio" name="problem_analysis_solution" value="1" class="ml-1" <?= isChecked(1, $row['problem_analysis_solution']) ?>>
                    <br>

                    <label>継続力：</label>
                    S<input type="radio" name="persistence" value="5" class="ml-1" <?= isChecked(5, $row['persistence']) ?>>
                    A<input type="radio" name="persistence" value="4" class="ml-1" <?= isChecked(4, $row['persistence']) ?>>
                    B<input type="radio" name="persistence" value="3" class="ml-1" <?= isChecked(3, $row['persistence']) ?>>
                    C<input type="radio" name="persistence" value="2" class="ml-1" <?= isChecked(2, $row['persistence']) ?>>
                    D<input type="radio" name="persistence" value="1" class="ml-1" <?= isChecked(1, $row['persistence']) ?>>
                    <br>

                    <label>クオリティ：</label>
                    S<input type="radio" name="quality" value="5" class="ml-1" <?= isChecked(5, $row['quality']) ?>>
                    A<input type="radio" name="quality" value="4" class="ml-1" <?= isChecked(4, $row['quality']) ?>>
                    B<input type="radio" name="quality" value="3" class="ml-1" <?= isChecked(3, $row['quality']) ?>>
                    C<input type="radio" name="quality" value="2" class="ml-1" <?= isChecked(2, $row['quality']) ?>>
                    D<input type="radio" name="quality" value="1" class="ml-1" <?= isChecked(1, $row['quality']) ?>>
                    <br>

                    <label>伝達力：</label>
                    S<input type="radio" name="communication" value="5" class="ml-1" <?= isChecked(5, $row['communication']) ?>>
                    A<input type="radio" name="communication" value="4" class="ml-1" <?= isChecked(4, $row['communication']) ?>>
                    B<input type="radio" name="communication" value="3" class="ml-1" <?= isChecked(3, $row['communication']) ?>>
                    C<input type="radio" name="communication" value="2" class="ml-1" <?= isChecked(2, $row['communication']) ?>>
                    D<input type="radio" name="communication" value="1" class="ml-1" <?= isChecked(1, $row['communication']) ?>>
                    <br>

                    <label>チームワーク：</label>
                    S<input type="radio" name="teamwork" value="5" class="ml-1" <?= isChecked(5, $row['teamwork']) ?>>
                    A<input type="radio" name="teamwork" value="4" class="ml-1" <?= isChecked(4, $row['teamwork']) ?>>
                    B<input type="radio" name="teamwork" value="3" class="ml-1" <?= isChecked(3, $row['teamwork']) ?>>
                    C<input type="radio" name="teamwork" value="2" class="ml-1" <?= isChecked(2, $row['teamwork']) ?>>
                    D<input type="radio" name="teamwork" value="1" class="ml-1" <?= isChecked(1, $row['teamwork']) ?>>
                    <br>

                    <label>ルール遵守：</label>
                    S<input type="radio" name="rule_compliance" value="5" class="ml-1" <?= isChecked(5, $row['rule_compliance']) ?>>
                    A<input type="radio" name="rule_compliance" value="4" class="ml-1" <?= isChecked(4, $row['rule_compliance']) ?>>
                    B<input type="radio" name="rule_compliance" value="3" class="ml-1" <?= isChecked(3, $row['rule_compliance']) ?>>
                    C<input type="radio" name="rule_compliance" value="2" class="ml-1" <?= isChecked(2, $row['rule_compliance']) ?>>
                    D<input type="radio" name="rule_compliance" value="1" class="ml-1" <?= isChecked(1, $row['rule_compliance']) ?>>
                    <br>

                    <label>主体的行動：</label>
                    S<input type="radio" name="proactive_action" value="5" class="ml-1" <?= isChecked(5, $row['proactive_action']) ?>>
                    A<input type="radio" name="proactive_action" value="4" class="ml-1" <?= isChecked(4, $row['proactive_action']) ?>>
                    B<input type="radio" name="proactive_action" value="3" class="ml-1" <?= isChecked(3, $row['proactive_action']) ?>>
                    C<input type="radio" name="proactive_action" value="2" class="ml-1" <?= isChecked(2, $row['proactive_action']) ?>>
                    D<input type="radio" name="proactive_action" value="1" class="ml-1" <?= isChecked(1, $row['proactive_action']) ?>>
                    <br>

                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


</body>

</html>