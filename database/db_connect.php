<?php

$connect = mysqli_connect("127.0.0.1","root","","mktime");
if(!$connect){
    die("Can't connect to the DATABASE: ".mysqli_connect_error());
}

?>