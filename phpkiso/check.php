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
    $nickname = htmlspecialchars($_POST['nickname']);
    $email = htmlspecialchars($_POST['email']);
    $content = htmlspecialchars($_POST['content']);

    // バリデーション (入力チェック)
    $nickname_result = ''; // 変数の初期化
    if ($nickname == '') {
        // $nicknameが空だった場合の処理
        $nickname_result = 'ニックネームが入力されていません。';
    } else {
        // 正しく入力された場合の処理
        $nickname_result = 'ようこそ' . $nickname . '様';
    }

    $email_result = ''; // 変数の初期化
    if ($email == '') {
        // $emailが空だった場合の処理
        $email_result = 'メールアドレスが入力されていません。';
    } else {
        // 正しく入力された場合の処理
        $email_result = 'メールアドレス : ' . $email;
    }

    $content_result = ''; // 変数の初期化
    if ($content == '') {
        // $contentが空だった場合の処理
        $content_result = 'お問い合わせ内容が入力されていません。';
    } else {
        // 正しく入力された場合の処理
        $content_result = 'お問い合わせ内容 : ' . $content;
    }


 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>入力内容確認</title>
  <meta charset="utf-8">
</head>
<body>
  <h1>入力内容確認</h1>
  <?php echo $nickname_result; ?>
  <br>
  <?php echo $email_result; ?>
  <br>
  <?php echo $content_result; ?>
  <br>
  <form method="POST" action="thanks.php">
    <input type="hidden" name="nickname" value="<?php echo $nickname ?>">
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="hidden" name="content" value="<?php echo $content ?>">
    <a href="index.html" onclick="history.back()">戻る</a>
    <?php if ($nickname != '' && $email != '' && $content != ''): ?>
      <input type="submit" value="OK">
    <?php endif; ?>

    <?php
        // if (条件) {
        //     echo '<input type="submit" value="OK">';
        // }
     ?>

  </form>
</body>
</html>









