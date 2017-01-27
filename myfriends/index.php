<?php
    // echo 'Hello myfriends!';

    // CRUD処理のR - データの取得・表示

    // 1. データベースへ接続
    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // 2. SQL実行 (データの取得)
    $sql = 'SELECT * FROM `areas`'; // ただの変数定義
    $stmt = $dbh->prepare($sql); // 変数として用意したsql文をセット
    $stmt->execute(); // ファイヤー!! (実行)
    // ↑この$stmtがareasテーブルのデータをすべて持っている

    // SELECT カラム名 FROM テーブル名
    // * (アスタリスク) は「全カラム」のデータを取得する意味になる
    // * ワイルドカード
    // 例) 「*.php」で拡張子が.phpのファイルすべて

    // 条件付きSELECT文
    // SELECT カラム名 FROM テーブル名 WHERE 条件
    // 取得するデータを指定したい場合に用いる構文
    // WHERE `カラム名`=値
    // 条件の値部分に%を含めると、あいまい検索機能になる
    // = を LIKEにかえる


    // CRUDとSQL文
    // データ操作の4原則
    // Create : INSERT : 作成
    // Read   : SELECT : 取得
    // Update : UPDATE : 更新
    // Delete : DELETE : 削除

    // 3. 取得データの加工
    // echo '<pre>';
    // var_dump($stmt);
    // echo '</pre>';
    // // object型 → array型
    // $record = $stmt->fetch(PDO::FETCH_ASSOC);
    // // $record = array('area_id' => '1', 'area_name' => '北海道');
    // echo '<pre>';
    // var_dump($record);
    // echo '</pre>';

    // // 4. 表示
    // echo $record['area_id'];
    // echo ' : ';
    // echo $record['area_name'];

    // 47都道府県分繰り返し処理
    $areas = array(); // 空の配列作成
    while (1) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            break; // 読み込まれるとこれを含む制御文は強制終了する
        }
        // 表示用の配列を作成し、一時的にデータを保存する
        $areas[] = $record;
    }

    // echo '<pre>';
    // var_dump($areas);
    // echo '</pre>';

    // echo $areas[0]['area_name'];
    // echo $areas[1]['area_name'];
    // echo $areas[46]['area_name'];

    // $areas = array('Yo', 'Hiroshi');
    // $areas = array($record1, $record2);
    // $record1 = array('area_id' => '1', 'area_name' => '北海道');
    // $record2 = array('area_id' => '2', 'area_name' => '青森県');


    // echo $record['area_id'];
    // echo ' : ';
    // echo $record['area_name'];
    // echo '<br>';

    $count = count($areas);
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <?php for ($i=0; $i < $count; $i++) : ?>
        <!-- 繰り返し表示したいHTML書き放題 -->
        <?php echo $areas[$i]['area_id']; ?> : <a href="show.php?area_id=<?php echo $areas[$i]['area_id']; ?>"><?php echo $areas[$i]['area_name']; ?></a>
        <br>
    <?php endfor; ?>

    <?php
        // for ($i=0; $i < $count; $i++) {
        //     echo $areas[$i]['area_name'];
        //     echo '<br>';
        // }
     ?>

</body>
</html>











