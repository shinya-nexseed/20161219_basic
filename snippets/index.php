<?php
    $dsn = 'mysql:dbname=snippets;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM `categories`';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $categories = array();
    while (1) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            break;
        }
        $categories[] = $record;
    }

    $count = count($categories);
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <?php for ($i=0; $i < $count; $i++) : ?>
        <?php echo $categories[$i]['category_id']; ?> : <a href="show.php?category_id=<?php echo $categories[$i]['category_id']; ?>"><?php echo $categories[$i]['category_name']; ?></a>
        <br>
    <?php endfor; ?>
</body>
</html>











