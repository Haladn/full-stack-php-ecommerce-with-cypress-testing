<?php

$connect = mysqli_connect("localhost","root","","mktime");
if(!$connect){
    die("can't connect to the DATABASE");
}else{
    echo "DATABASE connected successfully";
}

?>