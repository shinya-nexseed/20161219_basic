<!-- /myfriends/show.php?area_id=1 -->

<?php
    // echo 'Hello show.php';
    // GET送信
    // URLの末尾に?が入り、それ以降にキー=値の形でデータを付けて次のページへ送信する手法
    // area_idというキーに都道府県のid (数字) をデータとして付ける
    // PHPでGETデータを取得するには下記
    // $_GET['キー']

    // echo '<br>';
    // echo $_GET['area_id'];
    // echo '<br>';

    // ページデータ取得用の$id変数を用意
    $id = $_GET['area_id'];  // 1などのidデータ

    // データベースから情報を取得
    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // 削除処理
    // もし削除リンクが押され、パラメータにaction=deleteが存在すれば処理
    if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
        // DELETE FROM `テーブル名` WHERE `カラム名` = 値
        $sql = 'DELETE FROM `friends` WHERE `friend_id` = ' . $_GET['friend_id'];
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    }


    $sql = 'SELECT * FROM `areas` WHERE `area_id`=' . $id;
    // echo $sql;
    // echo '<br>';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(); // object型

    $area_record = $stmt->fetch(PDO::FETCH_ASSOC); // array型
    // $record = array('area_id' => '1', 'area_name' => '北海道');

    // area_idが一致する友達データ全件取得
    $sql = 'SELECT * FROM `friends` WHERE `area_id`=' . $id;
    $stmt = $dbh->prepare($sql);
    $stmt->execute(); // object型
    $friends = array();
    while (1) {
        $friend_record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($friend_record == false) {
            break;
        }
        $friends[] = $friend_record;
    }
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/own.css">
</head>
<body>
  <a href="new.php">新規友達データを登録</a><br>
  <?php echo $area_record['area_name']; ?> の友達
  <br>
  <?php foreach($friends as $friend): ?>
    <?php echo $friend['friend_name']; ?>
    <span class="edit">[<a href="edit.php?friend_id=<?php echo $friend['friend_id']; ?>">編集</a>]</span>
    <span class="delete">[<a href="show.php?action=delete&friend_id=<?php echo $friend['friend_id']; ?>&area_id=<?php echo $area_record['area_id']; ?>">削除</a>]</span>
    <br>
  <?php endforeach; ?>
</body>
</html>







