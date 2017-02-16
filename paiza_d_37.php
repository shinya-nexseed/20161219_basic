<?php
// 標準入力 (Standard Input) - STDIN
$input_lines1 = fgets(STDIN);
$input_lines2 = fgets(STDIN);

// 割り算
// 余りの計算
// 小数点を丸める

$data = $input_lines2 / $input_lines1;
echo ceil($data) . PHP_EOL;

$result1 = $input_lines2 % $input_lines1; // 余りがでる
if ($result1 == 0) {
    $result2 = floor($input_lines2 / $input_lines1);
    echo $result2;

} else {
    $result2 = floor($input_lines2 / $input_lines1);
    echo $result2 + 1;
}

?>
