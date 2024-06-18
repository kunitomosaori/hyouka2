<?php
session_start();
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
//include "../../includes/funcs.php";
include "funcs.php";
sschk();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
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

<?php include('html/sidemenu.html'); ?>
<?php include('html/header.html'); ?>
<div class="content-wrapper">


    <!-- Main[Start] -->
    <form method="post" action="user_insert.php">
    <div class="container mx-auto bg-sky-50 p-6 rounded-lg text-center flex justify-center">
    <fieldset class="space-y-4">
          <legend class="text-xl font-bold">ユーザー登録</legend>
          <label>名前：<input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
          <label>Login ID：<input type="text" name="lid" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
          <label>Login PW：<input type="text" name="lpw" class="mt-1 block w-full border-gray-300 rounded-md"></label><br>
          <label>管理FLG：
            一般<input type="radio" name="kanri_flg" value="0" class="ml-1">　
            管理者<input type="radio" name="kanri_flg" value="1" class="ml-1">
          </label>
          <br>
          <!-- <label>退会FLG：<input type="text" name="life_flg"></label><br> -->
          <input type="submit" value="送信" class="bg-orange-400 hover:bg-orange-300 px-5 py-2 rounded-md" >
        </fieldset>
      </div>
    </form>
    <!-- Main[End] -->


</body>

</html>