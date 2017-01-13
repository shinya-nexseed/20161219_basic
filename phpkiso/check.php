<!-- phpプログラムを書く -->
<?php
    // POST送信されたデータを受け取るための$_POSTについて
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    // スーパーグローバル変数
    // PHPが予め用意しているある条件を満たすと使用可能となる変数
    // 必ず連想配列の形式で作成される
    // 名前が$_で始まり、大文字で記述された変数はすべてこの変数
    // $_POST = array(入力タグのname => 入力された値)

    // $_POST = array('nickname' => 'shinya', 'email' => 'shirai@nexseed.net', 'content' => 'ほげほげ');
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $content = $_POST['content'];
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>入力内容確認</title>
  <meta charset="utf-8">
</head>
<body>
  <h1>入力内容確認</h1>
  <?php echo 'ようこそ' . $nickname . '様'; ?>
  <br>
  <?php echo 'メールアドレス : ' . $email; ?>
  <br>
  <?php echo 'お問合わせ内容 : ' . $content; ?>
  <br>
  <form method="POST" action="thanks.php">
    <input type="hidden" name="nickname" value="<?php echo $nickname ?>">
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="hidden" name="content" value="<?php echo $content ?>">
    <input type="submit" value="OK">
  </form>
</body>
</html>









