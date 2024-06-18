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

// if (!isset($_SESSION["name"])) {
//   redirect("login.php");
// }

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
$values = $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

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
  <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">

      <table class="table-auto  w-full">
      <thead>
        <tr>
        <th class="px-4 py-2">会社目標</th>
        <?php if ($_SESSION["kanri_flg"] == "1") { ?>
        <th class="px-4 py-2">変更</th>
        </tr>
        <?php } ?>
        </thead>
        <tbody>
        <?php foreach ($values as $v) { ?>
          <tr>
            <td class="border px-4 py-2"><?= $v["goal_co"] ?></td>
          <?php if ($_SESSION["kanri_flg"] == "1") { ?>
            <td class="border px-4 py-2">
              <a href="detail_co.php?id=<?= $v["id"] ?>" class="hover:text-orange-400">更新</a>
            </td>
            </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
      </table>

  </div>
  <!-- Main[End] -->
  </div>

  <script>
    const a = '<?php echo $json; ?>';
    console.log(JSON.parse(a));
  </script>
</body>

</html>
