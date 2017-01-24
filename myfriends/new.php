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
    名前<br>
    <input type="text" name="friend_name" placeholder="例: 山田 太郎">
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
        <option value="1"><?php echo $area['area_name']; ?></option>

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




