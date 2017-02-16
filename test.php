<?php
$input_lines = fgets(STDIN);
$input_lines = substr($input_lines, 0,1);

// A ~ Zの配列を用意
$alphabet_lists = range('A', 'Z');
$c = count($alphabet_lists);

// for文で繰り返し
for ($i=0; $i < $c; $i++) {
    // if文で一致すればecho
    if ($input_lines == $alphabet_lists[$i]) {
        echo $i + 1 . PHP_EOL;
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
