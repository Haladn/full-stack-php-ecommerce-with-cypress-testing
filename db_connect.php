<?php

$connect = mysqli_connect("localhost","root","","mktime");
if(!$connect){
    die("Can't connect to the DATABASE: ".mysqli_connect_error());
}else{
    echo "DATABASE connected successfully";
}

?>