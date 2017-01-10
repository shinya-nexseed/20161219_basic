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

 ?>







