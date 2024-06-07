<?php
// set session endpoin for cypress test request
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $_SESSION['cart']=$_POST['cart'];
    $_SESSION['cart_message'] = $_POST['cart_message'];

    // set header return success status t success
    header('Content-Type: application/json;charset=utf-8');
    echo json_encode(['status' => 'success']);
    exit;
}




?>