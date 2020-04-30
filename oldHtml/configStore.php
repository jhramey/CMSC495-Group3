<?php
    define('DB_SERVER', 'db');
    define('DB_FNAME', 'root');
    define('DB_TYPE', 'type');
    define('DB_COLOR', 'color');
    define('DB_COST', 'cost');
    define('DB_QUAN', 'quan');
    define('DB_PIC', 'pic');
    define('DB_NAME', 'ConsumerWebsite');
    

    $link = mysqli_connect(DB_SERVER, DB_FNAME, DB_TYPE, DB_COLOR, DB_COST, DB_QUAN, DB_PIC, DB_NAME);

    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>