<?php

    // 各入力値を保持する変数を用意
    $nick_name = '';
    $email = '';
    $password = '';

    // フォームからデータがPOST送信されたとき
    if (!empty($_POST)) {
        var_dump($_POST);
        $nick_name = $_POST['nick_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // フォームのバリデーション
        $error = array();

        // ニックネームの入力チェック
        if ($_POST['nick_name'] == '') {
            $error['nick_name'] = 'blank';
        }

        // メールアドレスの入力チェック
        if ($_POST['email'] == '') {
            $error['email'] = 'blank';
        }

        // パスワードの入力チェック
        if ($_POST['password'] == '') {
            $error['password'] = 'blank';
        } elseif (strlen($_POST['password']) < 4) {
            $error['password'] = 'length';
        }

        // プロフィール画像の拡張子チェック
        $fileName = $_FILES['picture_path']['name'];
        // $_FILESは、fileタイプのinputタグが送信したデータを受け取るスーパーグローバル変数
        // 一つ目のキーにはinputタグのnameオプションの値をセットする。
        // 二つ目には予め定義されているキーをセットし情報を取得する。
        // 今回の場合、選択された画像の名前を取得したいので、二つ目のキーにはnameをセットした (PHPが予め決めているキー)

        // エラーがなかったとき
        if (empty($error)) {
            // 確認画面へ遷移
            header('Location: check.php');
            exit();
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
  <h1>会員情報登録</h1>
  <form method="POST" action="index.php" enctype="multipart/form-data">
    <!-- ファイルをアップロードするフォームにはenctype="multipart/form-data"が必須オプションとなる -->

    <!-- ニックネーム -->
    <div>
      <label>ニックネーム</label><br>
      <input type="text" name="nick_name" placeholder="例: 田中 太郎" value="<?php echo $nick_name; ?>">
      <?php if(isset($error['nick_name']) && $error['nick_name'] == 'blank'): ?>
        <p style="color: red;">ニックネームを入力してください</p>
      <?php endif; ?>
    </div>

    <!-- メールアドレス -->
    <div>
      <label>メールアドレス</label><br>
      <input type="email" name="email" placeholder="例: seed@next.com" value="<?php echo $email; ?>">
      <?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
        <p style="color: red;">メールアドレスを入力してください</p>
      <?php endif; ?>
    </div>

    <!-- パスワード -->
    <div>
      <label>パスワード</label><br>
      <input type="password" name="password" value="<?php echo $password; ?>">
      <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
        <p style="color: red;">パスワードを入力してください</p>
      <?php endif; ?>
      <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
        <p style="color: red;">パスワードは4文字以上で入力してください</p>
      <?php endif; ?>
    </div>

    <!-- プロフィール画像 -->
    <div>
      <label>プロフィール画像</label><br>
      <input type="file" name="picture_path">
    </div>

    <input type="submit" value="確認画面へ">
  </form>
</body>
</html>





