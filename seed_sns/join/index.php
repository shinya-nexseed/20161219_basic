<?php
    // $_SESSIONを使用可能にするための関数
    session_start();
    require('../dbconnect.php');

    // SESSIONとは、サーバー内に用意された簡易データベースのようなもの
    // Key Value Store (KVS) の形式で、データを保存しておける
    // ブラウザとサーバーの接続が切れるまでそのデータを保存し続ける
    // 一度保存したデータは、存在する限りどのファイル上でも使用が可能


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
        if (!empty($fileName)) {
            $ext = substr($fileName, -3);
            // substrは指定した文字列から指定した箇所から後の文字のみ取得する
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
                $error['picture_path'] = 'type';
            }
        }

        // メール重複チェック (DBとの比較)
        if (empty($error)) {
            $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email`=?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record['cnt'] > 0) {
                // メール重複
                $error['email'] = 'duplicate';
            }
        }

        // エラーがなかったとき
        if (empty($error)) {
            // 画像をサーバー (CentOS) へアップロードする
            $picture_path = date('YmdHis') . $_FILES['picture_path']['name'];
            move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $picture_path);
            // move_uploaded_fileはブラウザからサーバーへファイルデータをアップロードするためのPHPの関数 (機能)
            // ()の中には、一つ目にファイルデータを、二つ目に保存先と保存する際のファイル名を指定する

            // Unixコマンドでフォルダの権限を変更する
            // chown ユーザー:グループ パス
            // chown apache:apache member_picture


            // セッションに値を保存する (check.phpにPOST送信データを引き継ぐ)
            $_SESSION['join'] = $_POST;
            $_SESSION['join']['picture_path'] = $picture_path;
            // $_SESSION['join'] = array('nick_name' => 'hoge',
            //                           'email' => 'hoge@gmail.com',
            //                           'password' => 'hogehoge',
            //                           'picture_path' => '201702031010shinya.jpg');

            // 確認画面へ遷移
            header('Location: check.php');
            exit();
        }
    }

    // 書き直し処理
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
        $nick_name = $_SESSION['join']['nick_name'];
        $email = $_SESSION['join']['email'];
        $error['rewrite'] = 'rewrite';
    }
    // $_REQUESTスーパーグローバル変数
    // $_GET、$_POST、$_COOKIEの情報を含むスーパーグローバル変数
    // $_REQUEST == $_GET
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

      <?php if(isset($error['email']) && $error['email'] == 'duplicate'): ?>
        <p style="color: red;">指定したメールアドレスは既に登録されています</p>
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
      <?php if(isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
        <p style="color: red;">プロフィール画像の拡張子は「jpg」「png」「gif」のデータを指定してください</p>
      <?php endif; ?>
      <?php if(!empty($error)): ?>
        <p style="color: red;">画像を再度指定してください</p>
      <?php endif; ?>
    </div>

    <input type="submit" value="確認画面へ">
  </form>
</body>
</html>





