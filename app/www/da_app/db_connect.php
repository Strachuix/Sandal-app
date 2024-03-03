<?php
require_once(__DIR__.'/env.db.php');

if(mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB)){
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);
}else{
    echo "Error connecting to database";
}

$GLOBALS["connect"] = $connect;

mysqli_select_db($connect, DB_DB);

?>