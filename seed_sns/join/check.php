<?php
    session_start(); // セッション使用の条件

    var_dump($_SESSION['join']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  【ニックネーム】<br>
  <?php echo $_SESSION['join']['nick_name']; ?>
  <br>

  【メールアドレス】<br>
  <?php echo $_SESSION['join']['email']; ?>
  <br>

  【パスワード】<br>
  ●●●●●●●●
  <br>

  【プロフィール画像】<br>
  <img src="../member_picture/<?php echo $_SESSION['join']['picture_path']; ?>" width="100">
  <br>
</body>
</html>






