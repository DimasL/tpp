<?php
return array(
    'host'    => '127.0.0.1',
    'port'    => 9312,
    'timeout' => 30,
    'indexes' => array(
        'category' => array ( 'table' => 'categories', 'column' => 'id' ),
        'product' => array ( 'table' => 'products', 'column' => 'id' ),
    )
);