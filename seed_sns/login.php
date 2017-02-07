<?php
session_start(); // セッション
require('dbconnect.php'); // データベース

$email = '';

// ログインボタンが押されたとき
if (!empty($_POST)) {
    $email = $_POST['email'];

    if ($_POST['email'] != '' && $_POST['password'] != '') {
        // ログイン処理
        $sql = 'SELECT * FROM `members` WHERE `email`=? AND `password`=?';

        $data = array($_POST['email'], sha1($_POST['password']));

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // データが一件取得できた → ログイン成功
        // データが０件取得できた → ログイン失敗
        if ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // ログイン成功
            $_SESSION['id'] = $record['member_id'];
            $_SESSION['time'] = time();
            header('Location: index.php');
            exit();
        } else {
            // ログイン失敗
            $error['login'] = 'failed';
        }

    } else {
        // エラー処理
        $error['login'] = 'blank';
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
  <h1>ログイン画面</h1>
  <form method="POST" action="login.php">
    <div>
      <label>メールアドレス</label><br>
      <input type="email" name="email" value="<?php echo $email; ?>">
      <?php if(isset($error['login']) && $error['login'] == 'blank'): ?>
        <p style="color: red;">メールアドレスとパスワードをご記入ください</p>
      <?php endif; ?>

      <?php if(isset($error['login']) && $error['login'] == 'failed'): ?>
        <p style="color: red;">ログインに失敗しました</p>
      <?php endif; ?>
    </div>

    <div>
      <label>パスワード</label><br>
      <input type="password" name="password">
    </div>

    <input type="submit" value="ログイン">
  </form>
</body>
</html>
