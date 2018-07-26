<?php 

    $t1   = time();
    $date = date('m/d/Y H:i:s');
    $t2   = time();

    $json = json_encode(array(
        'T1'   => $t1,
        'date' => $date,
        'T2'   => $t2
    ), JSON_UNESCAPED_SLASHES);

    echo $json;

 ?>