<!-- /myfriends/show.php?area_id=1 -->

<?php
    echo 'Hello show.php';
    // GET送信
    // URLの末尾に?が入り、それ以降にキー=値の形でデータを付けて次のページへ送信する手法
    // area_idというキーに都道府県のid (数字) をデータとして付ける
    // PHPでGETデータを取得するには下記
    // $_GET['キー']
    echo '<br>';
    echo $_GET['area_id'];
    echo '<br>';

    // ページデータ取得用の$id変数を用意
    $id = $_GET['area_id'];

    // データベースから情報を取得
    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM `areas` WHERE `area_id`=' . $id;
    echo $sql;
    echo '<br>';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(); // object型

    $record = $stmt->fetch(PDO::FETCH_ASSOC); // array型
    // $record = array('area_id' => '1', 'area_name' => '北海道');

 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php echo $record['area_name']; ?> の友達
</body>
</html>






