<?php

require('./db_connect.php');

$url='https://fakestoreapi.com/products';
$request = file_get_contents($url);
$data = json_decode($request,true);
// echo $data[0];
// print_r($data)
foreach($data as $item){
    foreach($item as $property){
        echo "-".$property . '<br>';
        
    }
    // print_r($item);
    // echo $item['id'].'<br>';
    // echo $item['title'].'<br>';
    // echo $item['price'].'<br>';
    // echo $item['description'].'<br>';
    // echo $item['category'].'<br>';
    // echo $item['image'].'<br>';
    // echo '<br>';
    echo "-------------------------------------------".'<br>';
}

?>