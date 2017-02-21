<?php
// 標準入力される数が可変
$input_lines = trim(fgets(STDIN));
$s = str_replace(array("\r\n","\r","\n"), '', $input_lines);

$result = 'Hello ';
for ($i=0; $i < $s; $i++) {
    $input_lines_name = trim(fgets(STDIN));
    $n = str_replace(array("\r\n","\r","\n"), '', $input_lines_name);
    // 自己代入も使えるかも？

    if ($i == 0) {
        $result = $result . $n;
    } else {
        $result = $result . ',' . $n;
    }
    $tmp = $s - 1;
    if ($i == $tmp) {
        $result = $result . '.';
    }
}
echo $result . PHP_EOL;
?>


<?php
    // $hoge = 'kiyo\n \r \r\n';
    // $s = array('\n', '\r', '\r\n');
    // $fuga = str_replace($s, '', $hoge);
    // kiyo
 ?>









