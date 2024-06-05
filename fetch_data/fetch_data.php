<?php

require('../fetch_data/fetch_data.php');


$url='https://fakestoreapi.com/products';
$request = file_get_contents($url);
$data = json_decode($request,true);
// echo $data[0];
// print_r($data)
foreach($data as $item){
    // foreach($item as $property){
    //     echo "-".$property . '<br>';
        
    // }

    $title = mysqli_real_escape_string($connect,$item['title']);
    $price = mysqli_real_escape_string($connect,$item['price']);
    $description = mysqli_real_escape_string($connect,$item['description']);
    $category = mysqli_real_escape_string($connect,$item['category']);
    $image = mysqli_real_escape_string($connect,$item['image']);
    $quantity = 10;

    // making qurey to the database
    $query = "INSERT INTO products(title,price,description,image,category,quantity) VALUES('$title','$price','$description','$image','$category','$quantity')";
    $request = mysqli_query($connect,$query);
    if($request){
        echo "item added successfully";
    }
    //print_r($item);
    echo $item['id'].'<br>';
    echo $item['title'].'<br>';
    echo $item['price'].'<br>';
    echo $item['description'].'<br>';
    echo $item['category'].'<br>';
    echo $item['image'].'<br>';
    echo $item['quantity'].'<br>';
    echo '<br>';
    echo "-------------------------------------------".'<br>';
}

?>