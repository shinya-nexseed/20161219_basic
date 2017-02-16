<?php
    $id = $_GET['category_id'];

    $dsn = 'mysql:dbname=snippets;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM `categories` WHERE `category_id`=' . $id;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $category_record = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `snippets` WHERE `category_id`=' . $id;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $snippets = array();
    while (1) {
        $snippet_record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($snippet_record == false) {
            break;
        }
        $snippets[] = $snippet_record;
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
  <a href="new.php">新規スニペットデータを登録</a><br>
  <?php echo $category_record['category_name']; ?> のスニペット
  <br>
  <?php foreach($snippets as $snippet): ?>
    <span class="show"><a href="snippet_show.php?snippet_id=<?php echo $snippet['snippet_id']; ?>"><?php echo $snippet['snippet_name']; ?></a></span>
    <span class="edit">[<a href="edit.php?snippet_id=<?php echo $snippet['snippet_id']; ?>">編集</a>]</span>
    <span class="delete">[<a href="show.php?action=delete&snippet_id=<?php echo $snippet['snippet_id']; ?>&category_id=<?php echo $category_record['category_id']; ?>">削除</a>]</span>
    <br>
  <?php endforeach; ?>

</body>
</html>







