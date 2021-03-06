<?php
    // この中にPHPプログラムを書く
    // echo 'Hello world!!!';

    // 変数
    // 変数名 = 値;
    $name = 'Shinya';
    echo $name;
    // echoはブラウザ上にデータを表示する命令文
    echo '<br>';
    $result = 6 * 12.5;
    echo $result . '<br>';

    // 文字列の連結
    // 文字列A . 文字列B
    echo 'Shinya' . 'Hirai' . '<br>';
    $full_name = 'Shinya' . 'Hirai';
    echo $full_name;
    $greeting = $full_name . 'です。よろしく！' . '<br>';
    echo $greeting . '<br>';
    // 変数は上書きされます。 ⇔ 定数 (変えられない箱) もある
    $greeting = 'こんにちは';
    echo $greeting . '<br>';

    $num = 10 + 5;
    $num = $num + 5;


    // 制御文
    //// if文 - 条件分岐

    // if (条件式) {
    //     条件式が正しかったときに実行される処理
    // }

    // 条件式は必ずtrueかfalseに分類される
    if (0) {
        echo '<br>';
        echo '実行!';
    }

    // 論理値 : true ⇔ false (真偽値)
    // true  → 真 (1)
    // false → 偽 (0)

    if (1 != 1) {
        echo '<br>';
        echo '条件がtrueを返したので実行!';
    }

    $num1 = 22;
    $num2 = 24;
    if ($num1 < $num2) {
        echo '<br>';
        echo $num2 . 'は' . $num1 . 'より大きいです';
    } else {
        echo '<br>';
        echo $num2 . 'は' . $num1 . 'より小さいです';
    }

    // else文
    // if (条件式) {
    //     trueの時の処理
    // } else {
    //     falseの時の処理
    // }

    // elseif文
    // if (条件式A) {
    //     条件式Aがtrueの時の処理
    // } elseif (条件式B) {
    //     条件式Aはfalseであるが、条件式Bがtrueの時の処理
    // } else {
    //     falseの時の処理
    // }

    echo '<br>';
    $score = 100; // のび太くんのテストの点数
    if ($score == 100) {
        echo 'よーく頑張ったよのび太くん！！！';
    } elseif ($score > 60) {
        echo 'どうしたんだいのび太くん！';
    } elseif ($score == 0) {
        echo 'またママに怒られるよ';
    } else {
        echo 'のび太くんが0点以外をとった！';
    }

    // if文を使ってサイコロプログラムを作る
    echo '<br>';
    $number = 10; // 1 ~ 6の数字が入る
    if ($number == 1) {
        echo 'サイコロの目は1です';
    } elseif ($number == 2) {
        echo 'サイコロの目は2です';
    } elseif ($number == 3) {
        echo 'サイコロの目は3です';
    } elseif ($number == 4) {
        echo 'サイコロの目は4です';
    } elseif ($number == 5) {
        echo 'サイコロの目は5です';
    } elseif ($number == 6) {
        echo 'サイコロの目は6です';
    } else {
        echo 'サイコロの目の規定外です';
    }

    // switch文
    echo '<br>';
    switch ($number) {
        case 1:
            echo 'サイコロの目は1です (switch)';
            break;

        case 2:
            echo 'サイコロの目は2です (switch)';
            break;

        case 3:
            echo 'サイコロの目は3です (switch)';
            break;

        case 4:
            echo 'サイコロの目は4です (switch)';
            break;

        case 5:
            echo 'サイコロの目は5です (switch)';
            break;

        case 6:
            echo 'サイコロの目は6です (switch)';
            break;

        default:
            echo 'サイコロの目の規定外です (switch)';
            break;
    }

    // 繰り返し文

    // while文
    echo '<br>';
    echo '<br>';
    echo '<br>';
    $num = 1;
    while ($num <= 6) {
        echo 'サイコロの目は' . $num . 'です';
        echo '<br>';
        // $num = $num + 1; // 自己代入
        $num++;
    }

    // for文
    echo '<br>';
    echo '<br>';
    for ($i=1; $i <= 6; $i++) {
        echo 'サイコロの目は' . $i . 'です';
        echo '<br>';
    }

    // 配列
    // $配列名 = array(値1, 値2, 値3 ...);
    $members = array('Yo', 'Kiyo', 'Yusuke', 'Yukino', 'kazu');
    //                 0       1         2         3
    // 0から始まるIndexという数字が各データにふられる

    // $配列名[Index]で各データを呼び出す
    echo $members[0];
    echo '<br>';
    echo $members[1];
    echo '<br>';
    echo $members[2];
    echo '<br>';
    echo $members[3];
    echo '<br>';

    // echo $members; // エラーになる(echoは1データしか扱えない)
    echo '<pre>';
    var_dump($members);
    echo '</pre>';

    $hoge = 'ほげ';
    echo '<br>';
    var_dump($hoge);

    echo '<br>';
    // 配列と繰り返し
    echo count($members); // count関数 (配列のデータ数を数える機能)
    $i = 0; // 初期化
    $count = count($members); // 繰り返しの上限(配列数)
    echo 'すべての友達 : ' . $count;
    echo '<br>';
    while ($i < $count) {
        $num = $i+1;
        echo 'Member' . $num . ' : ' . $members[$i];
        echo '<br>';
        $i++;
    }

    // 連想配列
    // $連想配列 = array(キー1 => 値1, キー2 => 値2 ...);
    $langs = array('Web' => 'PHP', 'iOS' => 'Swift', 'Android' => 'Java');

    // $連想配列[キー];で呼び出し
    echo $langs['Web'];
    echo '<br>';
    echo $langs['iOS'];
    echo '<br>';
    echo $langs['Android'];
    echo '<br>';

    // 多次元配列
    //// 配列の中にまた配列がデータとして入っている
    $friend1 = array('name' => 'Kiyo', 'age' => '22');
    $friend2 = array('name' => 'Yusuke', 'age' => '22');
    $friend3 = array('name' => 'Yukino', 'age' => '23');

    $friends = array($friend1, $friend2, $friend3);

    echo '<br>';
    echo $friends[0]['name'];
    echo '<br>';
    echo $friends[0]['age'];
    //   $配列[Index][key];

    echo '<br>';
    echo '<br>';
    // PHP総復習

    // 変数
    // データ型
    // 配列
    // 連想配列
    // if文
    // while文
    // for文


    // 変数
    // 値を入れる箱のイメージ
    // $変数名 = 値;

    // データ型
    // データ型によって処理の仕方が変わってくる
    // 文字 String
    // 整数 Int
    // 浮動小数点 Float
    // 論理 Boolean
    // 配列 Array

    // 配列
    // 複数のデータを保持することができるタンスのイメージ
    // 同じようなデータを管理する場合は配列で一緒に管理
    // 例 : フルーツ、言語、友達リスト
    // 定義 : $配列名 = array(値1, 値2, 値3);
    // 実行 : $配列名[Index]
    // Indexとは、配列データの上から順に付けられた0から始まる数字

    // 連想配列
    // 基本的には配列と同じですが、Indexの代わりに文字列でKeyを与え、keyとvalueのセットで管理する
    // 定義 : $連想配列名 = array(キー1 => 値1, キー2 => 値2, キー3 => 値3);
    // 実行 : $連想配列名[キー]

    // if文
    // 条件が真偽のどちらかで処理を分岐させるプログラム
    // 論理値 → 真 true (1) : 偽 false (0)
    // if (条件式A) {
    //     条件式Aが真のときの処理
    // } elseif (条件式B) {
    //     条件式Aが偽で条件式Bが真のときの処理
    // } else {
    //     すべての条件が偽のときの処理
    // }

    // while文
    // 条件が一致する間、同じ処理を繰り返すためのプログラム
    // 条件に使用している変数などが永遠にfalseを返さないと無限ループに陥るので注意
    // while (条件式) {
    //     繰り返し処理
    // }

    // for文
    // while文と同じ繰り返し処理をするためのプログラム
    // ()の中に初期化式、条件式、変化式と繰り返しに必要な式をすべて入れる必要があり、これにより無限ループを起こすことがない
    // for (初期化式; 条件式; 変化式) {
    //     繰り返し処理
    // }

 ?>







