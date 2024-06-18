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
$sql = "SELECT c.*, u.name 
FROM competency c 
LEFT JOIN gs_user_table u ON c.user_id = u.id";
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

echo $json; // JSONデータを出力

// 数値評価を文字評価に変換する関数
function convertToGrade($score) {
  switch ($score) {
      case 5:
          return 'S';
      case 4:
          return 'A';
      case 3:
          return 'B';
      case 2:
          return 'C';
      case 1:
          return 'D';
      default:
          return 'N/A';
  }
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .content-wrapper {
      margin-left: 25%; /* Adjust according to sidebar width */
      margin-top: 80px; /* Adjust according to header height */
      padding: 10px;
      transition: margin-left 0.3s;
    }
    .chart-container {
      width: 80%;
      margin: auto;
    }
  </style>
</head>

<body id="main">

<?php include('../html/sidemenu.html'); ?>
<?php include('../html/header.html'); ?>
<div class="content-wrapper">

  <!-- Main[Start] -->
  <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">

      <table class="table-auto w-full">
      <thead>
        <tr>
          <th class="px-4 py-2">名前</th>
          <th class="px-4 py-2">理念浸透力</th>
          <th class="px-4 py-2">目標達成力</th>
          <th class="px-4 py-2">問題分析力・解決案提示力</th>
          <th class="px-4 py-2">継続力</th>
          <th class="px-4 py-2">クオリティ</th>
          <th class="px-4 py-2">伝達力</th>
          <th class="px-4 py-2">チームワーク</th>
          <th class="px-4 py-2">ルール遵守</th>
          <th class="px-4 py-2">主体的行動</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($values as $v) { ?>
          <tr>
          <td class="border px-4 py-2"><a href="detail_competency.php?id=<?= $v["id"] ?>" class="hover:text-orange-400"><?= $v["name"] ?></a></td>
          <td class="border px-4 py-2"><?= convertToGrade($v["philosophy_integration"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["goal_achievement"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["problem_analysis_solution"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["persistence"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["quality"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["communication"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["teamwork"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["rule_compliance"]) ?></td>
            <td class="border px-4 py-2"><?= convertToGrade($v["proactive_action"]) ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>

  </div>
  <!-- Main[End] -->

  <!-- レーダーチャート表示 -->
  <div class="chart-container">
    <canvas id="radarChart"></canvas>
  </div>

  <script>
const data = JSON.parse('<?php echo $json; ?>');

    // 最初のデータを使用してレーダーチャートを作成
    const firstEntry = data[0];

    const labels = [
      "理念浸透力",
      "目標達成力",
      "問題分析力・解決案提示力",
      "継続力",
      "クオリティ",
      "伝達力",
      "チームワーク",
      "ルール遵守",
      "主体的行動"
    ];

    const scores = [
      firstEntry.philosophy_integration,
      firstEntry.goal_achievement,
      firstEntry.problem_analysis_solution,
      firstEntry.persistence,
      firstEntry.quality,
      firstEntry.communication,
      firstEntry.teamwork,
      firstEntry.rule_compliance,
      firstEntry.proactive_action
    ];

    const dataForChart = {
      labels: labels,
      datasets: [{
        label: '行動評価',
        data: scores,
        fill: true,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgb(54, 162, 235)',
        pointBackgroundColor: 'rgb(54, 162, 235)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(54, 162, 235)'
      }]
    };

    const config = {
      type: 'radar',
      data: dataForChart,
      options: {
        elements: {
          line: {
            borderWidth: 3
          }
        },
        scales: {
          r: {
            angleLines: {
              display: false
            },
            suggestedMin: 0,
            suggestedMax: 5,
            ticks: {
              stepSize: 1,
              callback: function(value, index, values) {
                const grades = ['0','D', 'C', 'B', 'A', 'S'];
                return grades[value];
              }
            }
          }
        }
      },
    };

    const radarChart = new Chart(
      document.getElementById('radarChart'),
      config
    );
  </script>
</body>

</html>
