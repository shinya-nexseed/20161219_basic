<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$dsn = 'mysql:dbname=seed_sns;host=localhost';
$user = 'root';
$password = 'mysql';

// 例外処理
try{
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_);

    // print('<br>');

    // if ($dbh == null){
    //     print('接続に失敗しました。<br>');
    // }else{
    //     print('接続に成功しました。<br>');
    // }
}catch (PDOException $e){
    print('データベース接続時エラー:'.$e->getMessage());
    die();
}

try{
  $sql = 'SELECT * FROM `members`';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
}catch (PDOException $e) {
  print('SQL実行時エラー:'.$e->getMessage());
  die();
}

$dbh = null;

?>

</body>
</html>
