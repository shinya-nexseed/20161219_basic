<?php
    // ①パラメータから編集したい友達データのidを取得
    // ②idを元にDBから友達データ一件を取得
    // ③編集画面をHTMLで作成
    // ④入力欄に取得したデータを表示
    // ⑤更新ボタンが押された時、編集されたデータを元にDBのデータをUPDATE
    // ⑥友達が登録されている都道府県のshowページへ遷移

    $id = $_GET['friend_id'];
    echo '友達のid = ' . $id;
    echo '<br>';

    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // 更新ボタンが押された時のみ発動する処理
    if (!empty($_POST)) {
        // $_POSTが空ではない = $_POSTがある = submitボタンが押された
        // $sql = 'UPDATE `テーブル名` SET `カラム名1`=値1, `カラム名2`=値2';
        $sql = 'UPDATE `friends` SET `friend_name`=?, `area_id`=?, `gender`=?, `age`=? WHERE `friend_id`=' . $id;
        $data = array($_POST['name'], $_POST['area_id'], $_POST['gender'], $_POST['age']);

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $area_id = $_POST['area_id'];
        // show.phpへ遷移するプログラム
        // URLにある最後のスラッシュから後を指定したパスで書き換える
        header('Location: show.php?area_id=' . $area_id);
        // exit()が読み込まれると、そこでプログラムの処理を停止する
        // exit('エラーコード : 00101');
        exit();
    }

    // Create : 作成 : INSERT
    // Read   : 取得 : SELECT
    // Update : 更新 : UPDATE
    // Delete : 削除 : DELETE
    $sql = 'SELECT * FROM `friends` WHERE `friend_id`=' . $id;
    // WHERE句 → 条件指定
    echo $sql;
    echo '<br>';

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $record['friend_name'];
    echo '<br>';
    echo $record['area_id'];
    echo '<br>';
    echo $record['gender'];
    echo '<br>';
    echo $record['age'];
    echo '<br>';


    $sql = 'SELECT * FROM `areas`';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // object型→array型へ変換 (表示に使用する配列データにする)
    $areas = array(); // 空の配列を定義

    while (1) {
        $area_record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($area_record == false) {
            break;
        }
        $areas[] = $area_record;
    }



 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="utf-8">
   <title></title>
 </head>
 <body>
   <h1><?php echo $record['friend_name']; ?>さんの情報を編集</h1>
   <form method="POST" action="edit.php?friend_id=<?php echo $record['friend_id']; ?>">
   <!-- actionは空だと自分自身をさす -->
     名前<br>
     <input type="text" name="name" placeholder="例: 山田 太郎" value="<?php echo $record['friend_name']; ?>">
     <br>

     性別<br>
     <select name="gender">
        <option value="0">性別を選択</option>
        <?php if($record['gender'] == 1): ?>
          <option value="1" selected>男</option>
          <option value="2">女</option>
        <?php elseif($record['gender'] == 2): ?>
          <option value="1">男</option>
          <option value="2" selected>女</option>
        <?php endif; ?>
     </select>
     <br>

     出身地<br>
     <select name="area_id">
       <option value="0">出身地を選択</option>
       <?php foreach($areas as $area) : ?>
        <?php if($area['area_id'] == $record['area_id']): ?>
          <option value="<?php echo $area['area_id']; ?>" selected><?php echo $area['area_name']; ?></option>
        <?php else: ?>
          <option value="<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></option>
        <?php endif; ?>
       <?php endforeach; ?>
     </select>
     <br>

     年齢<br>
     <select name="age">
       <?php for($i=0; $i<100; $i++) : ?>
        <?php if($i == $record['age']): ?>
          <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
        <?php else: ?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endif; ?>
       <?php endfor; ?>
     </select>
     <br>

     <input type="submit" value="更新">
   </form>
 </body>
 </html>




