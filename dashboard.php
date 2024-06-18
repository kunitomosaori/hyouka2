<?php
// エラー表示
ini_set("display_errors", 1);
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

// データ登録SQL作成（gs_an_table）
$pdo = db_conn();

// gs_an_tableのデータ取得
$sql_an = "SELECT * FROM gs_an_table";
$stmt_an = $pdo->prepare($sql_an);
$status_an = $stmt_an->execute();

// データ表示（gs_an_table）
$values_an = "";
if ($status_an == false) {
  sql_error($stmt_an);
}

// 全データ取得（gs_an_table）
$values_an =  $stmt_an->fetchAll(PDO::FETCH_ASSOC);
$json_an = json_encode($values_an, JSON_UNESCAPED_UNICODE);

// データ登録SQL作成（gs_goal_co_table）
$sql_co = "SELECT * FROM gs_goal_co_table";
$stmt_co = $pdo->prepare($sql_co);
$status_co = $stmt_co->execute();

// データ表示（gs_goal_co_table）
$values_co = "";
if ($status_co == false) {
  sql_error($stmt_co);
}

// 全データ取得（gs_goal_co_table）
$values_co = $stmt_co->fetchAll(PDO::FETCH_ASSOC);
$json_co = json_encode($values_co, JSON_UNESCAPED_UNICODE);

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
$values_user_info = "";
if ($status_user_info == false) {
  sql_error($stmt_user_info);
}
$values_user_info = $stmt_user_info->fetchAll(PDO::FETCH_ASSOC);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }

    .content-wrapper {
      margin-left: 25%;
      padding: 10px;
    }

    .chart-container {
      width: 80%;
      margin: auto;
    }
  </style>
</head>

<body id="main">

<?php include('html/sidemenu.html'); ?>
<?php include('html/header.html'); ?>
<div class="content-wrapper">

    <!-- Main[Start] -->
    <div>
      <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
        <div class="flex space-x-6">
          <?php if ($_SESSION["kanri_flg"] == "1") { ?>
            <a href="index.php" class="hover:text-orange-600 bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
              <img src="./img/hand.png" alt="人事評価シート登録">
              <span>人事評価シート登録</span>
            </a>
            <a href="select.php" class="hover:text-orange-600 bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
              <img src="./img/document.png" alt="人事評価シート一覧">
              <span>人事評価シート一覧</span>
            </a>
            <a href="user.php" class="hover:text-orange-600 bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
              <img src="./img/human.png" alt="ユーザー登録">
              <span>ユーザー登録</span>
            </a>
          <?php } else { ?>
            <a href="index.php" class="hover:text-orange-600 bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
              <img src="./img/hand.png" alt="人事評価シート登録">
              <span>人事評価シート登録</span>
            </a>
            <a href="select.php" class="hover:text-orange-600 bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
              <img src="./img/document.png" alt="人事評価シート一覧">
              <span>人事評価シート一覧</span>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- ユーザー情報テーブル [Start] -->
    <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">所属</th>
            <th class="px-4 py-2">等級</th>
            <th class="px-4 py-2">役職</th>
            <th class="px-4 py-2">氏名</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($values_user_info as $user) { ?>
            <tr>
              <td class="border px-4 py-2"><?= h($user['department_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="border px-4 py-2"><?= h($user['grade_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="border px-4 py-2"><?= h($user['position_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="border px-4 py-2"><?= h($user['name'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- ユーザー情報テーブル [End] -->

    <!-- 会社目標テーブル [Start] -->
    <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">会社目標</th>
            <?php if ($_SESSION["kanri_flg"] == "1") { ?>
              <th class="px-4 py-2">変更</th>
          </tr>
        <?php } ?>
        </thead>
        <tbody>
          <?php foreach ($values_co as $v) { ?>
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
    <!-- 会社目標テーブル [End] -->
    <!-- 行動評価グラフ [Start] -->
    <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
      <div class="chart-container">
        <canvas id="behaviorChart"></canvas>
      </div>
    </div>
    <!-- 行動評価グラフ [End] -->

  </div>
  <!-- Main[End] -->



  <script>
    $(document).ready(function() {
      axios.get('select_competency.php')
        .then(function(response) {
          const data = response.data;
          // データを基にグラフを描画
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
            data[0].philosophy_integration,
            data[0].goal_achievement,
            data[0].problem_analysis_solution,
            data[0].persistence,
            data[0].quality,
            data[0].communication,
            data[0].teamwork,
            data[0].rule_compliance,
            data[0].proactive_action
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
            document.getElementById('behaviorChart'),
            config
          );
        })
        .catch(function(error) {
          console.log('Error: ' + error);
        });
    });


    const a = '<?php echo $json_an; ?>';
    console.log(JSON.parse(a));
  </script>
</body>

</html>