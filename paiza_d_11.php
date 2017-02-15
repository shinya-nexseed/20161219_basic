<?php
$input_lines = fgets(STDIN); // 標準入力、改行含まれてます！
// $input_lines = "A PHP_EOL";
$input_lines = substr($input_lines,0,1);

// A ~ Zの配列
// $alphabet_lists = array('A', 'B', 'C');
$alphabet_lists = range('A', 'Z');
$c = count($alphabet_lists); // 26

// for文で繰り返し
for ($i=0; $i < $c; $i++) {
    // if文で比較
    if ($input_lines == $alphabet_lists[$i]) {
        // 一致すればecho
        $result = $i + 1;
        echo $result . PHP_EOL;
    }
}

// $input_lines = substr(fgets(STDIN), 0,1);
// $alphabet_lists = range('A', 'Z');
// for ($i=0; $i < count($alphabet_lists); $i++) {
//     if ($input_lines == $alphabet_lists[$i]) {
//         echo $i + 1 . PHP_EOL;
//     }
// }
?>
