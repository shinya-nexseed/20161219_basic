<?php
    $input_lines = fgets(STDIN);
    // var_dump($input_lines);
    // var_dump($input_lines[0]);
    // var_dump(intval($input_lines[0]));
    $tmp = explode(' ', $input_lines);
    var_dump($tmp);

    if (21 % $input_lines == 0) {
        echo $input_lines;
    } else {
        echo 21 % $input_lines;
    }

    $n = 21 % $input_lines;
    if ($n == 0) {
        echo $input_lines;
    } else {
        echo $n;
    }

    $data = range('A', 'Z');
    for ($i=0; $i < count($data); $i++) {
        echo $data[$i];
    }

    $data = range('A', 'Z');
    $n = count($data);
    for ($i=0; $i < $n; $i++) {
        echo $data[$i];
    }


?>











