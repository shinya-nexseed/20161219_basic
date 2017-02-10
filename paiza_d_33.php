<?php
    // 自分の得意な言語で
    // Let's チャレンジ！！
    $input_lines = fgets(STDIN);
    // 日本語でストーリーを組み立てる

    // Shinya Hiraiという標準入力がある

    // 苗字と名前で文字データを分ける
    $data = explode(' ', $input_lines);
      // $data[0]と$data[1]にそれぞれ苗字と名前が入る

    // 各データの1文字目を取得する
    $fisrt_ini = substr($data[0],0,1);
    $last_ini = substr($data[1],0,1);

    // .と合わせて文字を作る
    $result = $fisrt_ini . '.' . $last_ini . PHP_EOL;

    // S.Hを出力する
    echo $result;

    // ヒント1
      // 文字の分割
      // explode()
    // ヒント2
      // 文字の1文字目のみ取得 (指定した文字を取得)
      // substr()
    // echo $fisrt_ini;
?>
