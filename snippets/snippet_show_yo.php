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
	// echo $sql;

	$record = $stmt->fetch(PDO::FETCH_ASSOC);
	// echo $record['snippet_name'];
	// echo '<br>';
	// echo $record['category_id'];
	// echo '<br>';
	// echo $record['content'];
	// echo '<br>';
	// echo $record['comment'];

	$sql = 'SELECT * FROM `categories`';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$category_record = $stmt->fetch(PDO::FETCH_ASSOC);


	echo '<br>';
 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="utf-8">
 	<title></title>
 </head>
 <body>
	言語の種類<br>
 	<?php echo $category_record['category_name'];?>
 	<?php echo '<br>'; ?>

 	構文名<br>
 	<?php echo $record['snippet_name']; ?>
 	<?php echo '<br>'; ?>

 	構文<br>
 	<?php echo $record['content']; ?>
 	<?php echo '<br>'; ?>

 	コメント<br>
 	<?php echo $record['comment']; ?>
 	<?php echo '<br>'; ?>

	作成日<br>
 	<?php echo $record['created']; ?>
 	<?php echo '<br>'; ?>

<pre id="editor" style="height: 300px; width: 400px;">
ほげほげ
</pre>


	<script src="src/ace.js" type="text/javascript"></script>
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
