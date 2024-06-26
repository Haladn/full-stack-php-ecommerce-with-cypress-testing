<?php
session_start();
require ('../database/db_connect.php');
include "../config.php";
// function to handle redirection
function redirect($connect){
    $url = $_SERVER['HTTP_REFERER'];

    header("Location: $url");
    mysqli_close($connect);
    exit;
    return;
}

echo 'request method == POST';
if($_SERVER['REQUEST_METHOD'] =='POST' && isset($_POST['add_to_cart'])){

    // identify product quantity
    //check if the post is from view page to get product quantity
    if(isset($_POST['view_product_quantity'])){
        $quantity = $_POST['view_product_quantity'];
    }else{$quantity = 1;}
    
    $product_id = mysqli_real_escape_string($connect,$_POST['product_id']);

    $query = "SELECT * FROM products WHERE id='$product_id'";
    $request = mysqli_query($connect,$query);
    if(mysqli_num_rows($request)==1){
        $product = mysqli_fetch_array($request,MYSQLI_ASSOC);

        //checking if customer is registered and take action accordingly
        if(isset($_SESSION['username'])){
            //create a customer's cart
            $customer_id = $_SESSION['customer_id'];

            // check if customer has a cart or not
            $customer_cart_query = "SELECT * FROM cart WHERE customer_id = '$customer_id';";
            $customer_cart_request = mysqli_query($connect,$customer_cart_query);
            if($customer_cart_request && mysqli_num_rows($customer_cart_request) == 1){

                //getting customrs cart id
                $cart = mysqli_fetch_array($customer_cart_request,MYSQLI_ASSOC);
                $cart_id = $cart['id'];

                // check if cart_item available 
                $cart_item_query = "SELECT * FROM cart_items WHERE cart_id='$cart_id' AND product_id ='$product_id' ;";
                $cart_item_request = mysqli_query($connect,$cart_item_query);
                if($cart_item_request && mysqli_num_rows($cart_item_request)==1){

                    // when cart_item available then update its quantity and total price
                    $cart_item = mysqli_fetch_array($cart_item_request,MYSQLI_ASSOC);
                    $new_quantity = $cart_item['quantity'] + $quantity;
                    $total_price = $new_quantity * (float) $product['price'];

                    // update quantity in the database
                    $q="UPDATE cart_items SET quantity = '$new_quantity',total_price = '$total_price' WHERE cart_id = '$cart_id' AND product_id='$product_id';";
                    $r = mysqli_query($connect,$q);
                    if($r){
                        // add message to the session
                        $_SESSION['cart_message'] = 'Added to the cart';
                    }else{
                        mysqli_errno($connect);
                    }
                    
                }else{
                    // create a new cart_item
                    $total_price = $quantity * (float) $product['price'];

                    //get title and id
                    $title = $product['title'];
                    $product_id = $product['id'];

                    $q = "INSERT INTO cart_items(cart_id,product_id,quantity, total_price,customer_id,title) VALUES ('$cart_id','$product_id','$quantity','$total_price',' $customer_id','$title');";
                    $r = mysqli_query($connect,$q);
                    
                    // add message
                    $_SESSION['cart_message'] = 'Added to the cart';

                    if(!$r){
                        echo "DATABASE connection failed.". mysqli_error($connect);
                    }

                }


            }else{
                // customer has no cart
                // create a customer cart
                $q = "INSERT INTO cart(customer_id) VALUES ('$customer_id');";
                $r = mysqli_query($connect,$q);
                if($r){
                    
                    // get cart id
                    $cart_id = mysqli_insert_id($connect);
                    echo 'cart_id: '.$cart_id;
                    // create a new cart_item
                    $total_price = $quantity * (float) $product['price'];
                   
                    //get title and id
                    $title = $product['title'];
                    $product_id = $product['id'];
                    
                    $q = "INSERT INTO cart_items(cart_id,product_id,quantity, total_price,customer_id,title) VALUES ('$cart_id','$product_id','$quantity','$total_price',' $customer_id','$title');";
                    
                    echo 'insert inso cart items';
                    $request = mysqli_query($connect,$query);
                    if($request){
                        // add message
                        $_SESSION['cart_message'] = 'Added to the cart';
                    }else{
                        echo "DATABASE connection failed.". mysqli_error($connect);
                    }
                    
                }   
                else{
                    echo "DATABASE connection failed.". mysqli_error($connect);
                }
                

            }
            // redirect to the main page
            redirect($connect);
        }

        
        //customer not registered then add item to the session 
        else{
            // check for cart session
            if(!isset($_SESSION['cart'])){
                $_SESSION['cart']=[];
            }

            //add item to cart session if not added
            if(!isset($_SESSION['cart'][$product['id']])){
                $_SESSION['cart'][$product['id']] =[
                    'title'=>$product['title'],
                    'price'=> $product['price'],
                    'in_cart_quantity'=>$quantity,
                    'in_stock_quantity' =>$product['quantity'],
                    'image' => $product['image']
                ];
                
                // add message
                $_SESSION['cart_message'] = 'Added to the cart';
            }
            // increment the quantity if alredy added
            else{
            $_SESSION['cart'][$product['id']]['in_cart_quantity'] += $quantity;

            // add message
            $_SESSION['cart_message'] = 'Added to the cart';
            
            }

            //redirect to the page
                redirect($connect);

        }
        


        
    }
}


// redirect usert that want to access the content through url input
    
header("Location: ../home.php");

?>