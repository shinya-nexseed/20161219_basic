<?php
    $id = $_GET['snippet_id'];

    $dsn = 'mysql:dbname=snippets;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM `snippets` WHERE `snippet_id`=' . $id;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $snippet = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/own.css">
</head>
<body>
  【スニペット名】<br>
  <?php echo $snippet['snippet_name']; ?>
  <span class="edit">[<a href="edit.php?snippet_id=<?php echo $snippet['snippet_id']; ?>">編集</a>]</span>
  <span class="delete">[<a href="show.php?action=delete&snippet_id=<?php echo $snippet['snippet_id']; ?>">削除</a>]</span>
  <br>
  <br>

  【スニペット】
<div id="editor" style="height: 300px; width: 400px;">&lt;?php
<?php echo $snippet['content']; ?>

?&gt;
</div>

  <br>

  【コメント】
  <div>
    <?php echo $snippet['comment']; ?>
  </div>

  <br>

  【作成日】
  <div>
    <?php echo $snippet['created']; ?>
  </div>

  <script type="text/javascript" src="src/ace.js"></script>
  <script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.setFontSize(14);
    editor.setReadOnly(true);
    editor.getSession().setMode("ace/mode/php");
    editor.getSession().setUseWrapMode(true);
    editor.getSession().setTabSize(2);
  </script>
</body>
</html>
