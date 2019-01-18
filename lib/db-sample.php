<?php

$host = "YOUR-HOST";
$user = "YOUR-USER";
$pass = "YOUR-PASSWORD";
$dbname = "YOUR-DBNAME";

$link = mysqli_connect($host,$user,$pass,$dbname);

if($link){
    echo "konek";
}
else {
    echo "gagal";
}

?>