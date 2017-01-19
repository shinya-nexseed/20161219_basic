<?php
    // $変数名 = 値;
    $name = 'shinya hirai';
    echo $name;
    echo '<br>';

    // $配列 = array(値1, 値2, 値3);
    //      Index     0,   1,   2
    // var_dump($配列);
    // echo $配列[Index];
    $members = array('Yo', 'Kiyo', 'Eriko', 'Hiroshi', 'Yukino', 'Mayu');
    var_dump($members);
    echo $members[2];
    echo '<br>';

    // $連想配列 = array(キー1 => 値1, キー2 => 値2, キー3 => 値3);
    //    キーは配列のIndexのかわり
    // var_dump($連想配列);
    // echo $連想配列[キー];
    $profile = array('name' => 'Yo', 'age' => '24', 'gender' => '男');
    var_dump($profile);
    echo $profile['gender'];





 ?>
