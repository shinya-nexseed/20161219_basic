<?php
    $input_lines = fgets(STDIN);
    $result = '';
    for ($i=0; $i < $input_lines; $i++) {
        // *を回数分つなげた文字を作る
        $result = $result . '*';
    }
    echo $result . PHP_EOL;
    // echo 'Hello';

    // 標準入力 STDIN (Standard input)
    // ターミナル上で入力される値のこと

    // 標準出力 STDOUT (Standard output)
    // ターミナル上で出力される値のこと


    $hoge = 'A';
    $hoge ='B';
    echo $hoge;

    $resut = '*';
    $resut = $result . '*';
    echo $result;

    $result = '';

    $result = $result . '*';
    echo $result;
    echo '<br>';
    $result = $result . '*';
    echo $result;
    echo '<br>';
    $result = $result . '*';
    echo $result;
    echo '<br>';
    $result = $result . '*';
    echo $result;
    echo '<br>';
    $result = $result . '*';
    echo $result;
    echo '<br>';
    $result = $result . '*';
    echo $result;
    echo '<br>';
?>
