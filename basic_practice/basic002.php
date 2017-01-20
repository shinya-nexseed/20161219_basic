<?php
    $langs = array('PHP', 'MySQL', 'HTML', 'CSS', 'JavaScript', 'Java', 'C', 'Ruby', 'C#', 'C++');
    var_dump($langs);
    echo '<br>';
    echo $langs[0];
    echo '<br>';
    echo $langs[1];
    echo '<br>';
    echo $langs[2];
    echo '<br>';
    echo $langs[3];
    echo '<br>';
    echo $langs[4];
    echo '<br>';
    echo $langs[5];
    echo '<br>';
    echo $langs[6];
    echo '<br>';
    echo $langs[7];
    echo '<br>';


    // count()関数を使用
    $count = count($langs);
    echo $count;
    echo '<br>';


    $devs = array('Web' => 'PHP', 'iOS' => 'Swift', 'Android' => 'Java', 'OS' => 'C');
    var_dump($devs);
    echo $devs['Web'];
    echo '<br>';
    echo $devs['iOS'];
    echo '<br>';
    echo $devs['Android'];
    echo '<br>';
    echo $devs['OS'];
    echo '<br>';


    // - for文①
    //    - 10回繰り返すfor文を作成し、Hello worldと10回画面に出力 (毎回改行が入るように)
    //    - 出力結果が'1回目 : Hello world'となるように変更 (1の部分は繰り上がっていく)

    // for文では、$i変数が初期値から1ずつ大きく (もしくは小さく) なる値として存在するので、これを上手く利用する
    for ($i=0; $i < 10; $i++) {
        // echo $i + 1;
        $num = $i + 1;
        //
        // echo '<br>';
        echo $num . '回目 : Hello world';
        echo '<br>';
    }
    // for(初期化式; 条件式; 変化式)

    // - for文②
    //    - $langs配列の中身を繰り返しですべて出力
    //    - ヒント1 : 配列の要素数を繰り返しの上限にする
    //    - ヒント2 : 表示する際の$langs[]の中には1つずつ繰り上がる数字が入った変数を

    // ①配列データを定義
    // ②カウントしたデータを定義
    // ③カウントデータを上限にfor文作成
    for ($i=0; $i < $count; $i++) {
        // echo $i;
        // echo '<br>';
        echo '<pre>';
        echo $langs[$i]; // ← ★★★重要★★★
        echo '</pre>';
        // 配列の要素ひとつを取り出すための構文$配列[Index]のIndex部分には数字データであれば変数を入れてもよい
        // echo '<br>';
    }



 ?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<pre>
あいうえお
かきくけこ
さし
すせそ
        たち
    つてと
</pre>

</body>
</html>




