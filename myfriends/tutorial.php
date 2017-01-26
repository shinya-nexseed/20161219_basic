<?php
    // 変数 (配列) の定義の順番
    $record = array('area_id' => '1', 'area_name' => '北海道');

    $record = 'ほげ';
    echo $record;
    echo '<br>';

    echo $record['area_name'];
    echo '<br>';


    // データベースと配列と繰り返し
    $dsn = 'mysql:dbname=myfriends;host=localhost';
    $user = 'root';
    $password = 'mysql';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM `friends` WHERE `area_id`=' . 1;
    $stmt = $dbh->prepare($sql);
    $stmt->execute(); // object型
    // $friends = array();
    // while (1) {
    //     $friend_record = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if ($friend_record == false) {
    //         break;
    //     }
    //     $friends[] = $friend_record;
    // }

    var_dump($stmt); // object型 → array型 (配列) に変換が必要

    // キーと値のセットで連想配列形式で定義した友達データが必要
    $friend1 = array('friend_id' => '1',
                    'friend_name' => 'ほげ',
                    'area_id' => '1',
                    'gender' => '1',
                    'age' => '26'
                    );

    $friend2 = array('friend_id' => '2',
                    'friend_name' => '平井真哉',
                    'area_id' => '1',
                    'gender' => '1',
                    'age' => '26'
                    );

    $friend3 = array('friend_id' => '3',
                    'friend_name' => '山田 太郎',
                    'area_id' => '1',
                    'gender' => '1',
                    'age' => '17'
                    );

    echo $friend1['friend_name'];
    echo '<br>';
    echo $friend2['gender'];
    echo '<br>';

    // 関連性のあるデータをひとまとめにして管理する特性を持つのが配列
    // その特性を活かして友達データをひとまとめにして管理
    $friends = array($friend1, $friend2, $friend3); // 多次元配列
    var_dump($friends);
    echo $friends[1]['friend_name'];
    echo '<br>';
    echo $friends[2]['age'];

    // 繰り返し処理と多次元配列の組み合わせ
    $count = count($friends);
    for ($i=0; $i < $count; $i++) {
        // 初回繰り返し時$iは0です
        // 2回目は$iが1です
        echo $friends[$i]['friend_name'];
    }

    echo '<br>';

    // 配列の繰り返しに特化したforeach文を使用
    foreach ($friends as $friend) {
        // $friend = $friends[0];
        // $friendはfor文の$friends[$i]と同じ
        echo $friend['friend_name'];
    }


    // DBから今の流れを見ていく ($stmtを使う)
    // $stmtにはDBのfriendsテーブルにあるarea_idが1の友達データ (連想配列) がすべて入った多次元配列のobject
    // $stmt = $friends
    // objectをarrayにするにはfetchする必要がある
    // $friend1 = $stmt->fetch(PDO::FETCH_ASSOC);
    // $friend2 = $stmt->fetch(PDO::FETCH_ASSOC);
    // $friend3 = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo $friend1['friend_name'];
    // echo '<br>';
    // echo $friend2['friend_name'];
    // echo '<br>';
    // echo $friend3['friend_name'];
    // echo '<br>';

    echo '<br>';
    echo '<br>';

    // while文の中で定義された$friend1をwhile文の外でも使用できるように空の配列を用意して保持してあげる
    $friends = array();

    while (1) {
        // 繰り返し文の中で定義された変数や配列は、その繰り返し文の中でしか効力を発揮しない
        // $friend1はwhile文の中でしか使えない
        $friend1 = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($friend1 == false) {
            break;
        }

        // 空の配列$friendsの上から順に$friendを入れていく
        // 配列に順にデータを入れる場合、配列[] = 値の形式で入れる

        // $friends = $friend1; // ダメな例
        $friends[] = $friend1;

    }

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <!-- 友達データを繰り返し表示したい -->
  <?php
      echo $friends[0]['friend_name'];
      echo '<br>';
      echo $friends[2]['friend_name'];
      echo '<br>';
      echo $friends[3]['friend_name'];
      echo '<br>';

      // 宿題
      // 上記複数回同じコードを書いてしまっているので、for文を使って繰り返し表示の形になおす
      // 同じくforeach文の形にもなおす
   ?>
</body>
</html>






