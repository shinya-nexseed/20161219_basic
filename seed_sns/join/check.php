<?php
    session_start(); // セッション使用の条件
    // データベース接続ファイルを読み込み
    require('../dbconnect.php');
    // require()は指定したファイルの内容を読み込む

    // $_SESSION = array();
    // unset($_SESSION['join']);
    // session_destroy();

    // もしセッションがなかったらindex.phpへ遷移
    if (!isset($_SESSION['join'])) {
        header('Location: index.php');
        exit();
    }

    var_dump($_SESSION['join']);

    // 登録ボタンが押されたとき (POST送信されたとき)
    if (!empty($_POST)) {
        // データベースのmembersテーブルに情報を登録
        echo 'POST送信されました。' . '<br>';

        try{
            // Create : INSERT
            $sql = 'INSERT INTO `members`
            (`nick_name`, `email` `password`, `picture_path`, `created`) VALUES
            ("Shinya", "shinya@gmail.com", "hogehoge", "shinya.jpg", NOW())';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        }catch(PDOException $e){
            echo 'SQL実行時エラー: '. $e->getMessage();
            exit;
        }

    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  【ニックネーム】<br>
  <?php echo htmlspecialchars($_SESSION['join']['nick_name']); ?>
  <br>

  【メールアドレス】<br>
  <?php echo htmlspecialchars($_SESSION['join']['email']); ?>
  <br>

  【パスワード】<br>
  ●●●●●●●●
  <br>

  【プロフィール画像】<br>
  <img src="../member_picture/<?php echo htmlspecialchars($_SESSION['join']['picture_path']); ?>" width="100">
  <br>

  <!-- 登録ボタン -->
  <form method="POST" action="check.php">
    <input type="hidden" name="hoge" value="fuga">
    <input type="submit" value="会員登録">
    <!--
      $_POST = array();
     -->
  </form>
</body>
</html>













