<?php
    // データベース接続
    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // データ取得 (SQL実行)
    $sql = 'SELECT * FROM `areas`';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // object型→array型へ変換 (表示に使用する配列データにする)
    $areas = array(); // 空の配列を定義

    while (1) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            break;
        }
        $areas[] = $record;
    }

    // 友達データの登録処理
    // もし登録ボタンが押されたら if(!empty($_POST)) {}
        // $_POSTが使用可能に (これをvar_dumpしてみる)
        // $_POSTを使ってINSERT文を作り実行

    // empty()関数
    // ()の中に指定した変数もしくは配列などの中身が空っぽかどうかを判定する
    // 空っぽだったらtrueを返す
    // 例) $hoge = '';
    echo '毎回実行される処理A';
    var_dump($_POST);
    if (!empty($_POST)) {
        // POST送信されたときのみ処理される
        echo 'POST送信されたときのみ実行される処理B';
        // CRUD処理のCreate : INSERT文を実行してDBに登録する処理
        var_dump($_POST);
        echo $_POST['name']; // DBのカラム名と一致してなくてもよい
        echo '<br>';
        echo $_POST['gender'];
        echo '<br>';
        echo $_POST['area_id'];
        echo '<br>';
        echo $_POST['age'];
        echo '<br>';

        // INSERT文作成
        // 構文 : INSERT INTO `テーブル名` (`カラム1`, `カラム2`, `カラム3`) VALUES (値1, 値2, 値3);

        // INSERT INTO `friends` (`friend_name`, `area_id`, `gender`, `age`, `created`) VALUES ("ほげ", 1, 1, 26, 2017/01/25)
        $sql = 'INSERT INTO `friends` (`friend_name`, `area_id`, `gender`, `age`, `created`) VALUES (?, ?, ?, ?, NOW())';
        // ?に入れるための配列を用意
        $data = array($_POST['name'], $_POST['area_id'], $_POST['gender'], $_POST['age']);

        // 実行 (登録)
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // header()は指定したURLへ遷移する処理
        header('Location: index.php');
    }

    // formタグmethod="POST" → $_POSTを生成する
    // 各入力タグのnameに指定された文字列をキーに、
    // ユーザーがフォーム画面で入力した内容を値に、
    // 連想配列の形式で生成される



 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <h1>友達の登録</h1>
  <form method="POST" action="new.php">
  <!-- actionは空だと自分自身をさす -->
    名前<br>
    <input type="text" name="name" placeholder="例: 山田 太郎">
    <br>

    性別<br>
    <select name="gender">
      <option value="0">性別を選択</option>
      <option value="1">男</option>
      <option value="2">女</option>
    </select>
    <br>

    出身地<br>
    <select name="area_id">
      <option value="0">出身地を選択</option>
      <?php foreach($areas as $area) : ?>
        <option value="<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></option>

      <?php endforeach; ?>
    </select>
    <br>

    年齢<br>
    <select name="age">
      <?php for($i=0; $i<100; $i++) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php endfor; ?>
    </select>
    <br>

    <input type="submit" value="登録">
  </form>
</body>
</html>




