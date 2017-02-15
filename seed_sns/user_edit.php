<?php
session_start();
require('dbconnect.php');
// $_SESSION['id'] → ログインしているユーザーのid

// ログインしているユーザーのデータをmembersテーブルから取得
$sql = 'SELECT * FROM `members` WHERE `member_id` = ?';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// 更新ボタンが押されたらUPDATE処理
if (!empty($_POST)) {
    // 全項目のバリデーション

    // 画像だけは新規で登録しなくてもおっけー
    $fileName = $_FILES['picture_path']['name'];
    if ($fileName == '') {
        $sql = 'UPDATE `members` SET `nick_name`=?, `email`=?, `password`=? WHERE `member_id`=?';
        $data = array($_POST['nick_name'], $_POST['email'], $_POST['password'], $_SESSION['id']);
    } else {
        $sql = 'UPDATE `members` SET `nick_name`=?, `email`=?, `password`=?, `picture_path`=? WHERE `member_id`=?';

        // $picture_pathの定義とサーバーへのアップロード

        $data = array($_POST['nick_name'], $_POST['email'], $_POST['password'], $picture_path, $_SESSION['id']);
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // header('Location: index.php');
    // exit();
}

// 工夫 : まずはnick_nameだけ更新できないか？
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <!-- ユーザーデータ更新用のformタグ用意 -->
  <?php if($member = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
  <form method="POST" action="user_edit.php" enctype="mutipart/form-data">
    <!-- nick_name編集input -->
    <input type="text" name="nick_name" value="<?php echo htmlspecialchars($member['nick_name']); ?>"><br>
    <!-- email編集 -->
    <input type="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>"><br>
    <!-- password編集 -->
    <input type="password" name="password" value=""><br>
    <!-- プロフィール画像 -->
    <img src="member_picture/<?php echo htmlspecialchars($member['picture_path']); ?>" width="200"><br>
    <input type="file" name="picture_path"><br>
    <!-- 更新ボタン -->
    <input type="submit" value="更新"><br>
  </form>
  <?php endif; ?>
</body>
</html>
