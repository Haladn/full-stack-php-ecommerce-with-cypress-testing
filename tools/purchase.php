<?php
    session_start();
    require ('../database/db_connect.php');

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['customer_id']) && isset($_POST['purchase_btn'])){
       
        $customer_id=$_SESSION['customer_id'];
        
        //start transaction
        mysqli_begin_transaction($connect);
        try{

            //get cart items
            $cart_items_query = "SELECT * FROM cart_items WHERE customer_id='$customer_id'";
            $cart_items_request = mysqli_query($connect,$cart_items_query);
            if(!$cart_items_request){
                throw new Exception("Error selecting from order item: " . mysqli_error($connect));
            }
            $items = mysqli_fetch_all($cart_items_request,MYSQLI_ASSOC);
        


            //getting quantity and price from view_customer_total_items
            $totals_query="SELECT * FROM view_customer_total_items WHERE customer_id = '$customer_id'";
            $totals_request = mysqli_query($connect,$totals_query);
            if(!$totals_request){
                throw new Exception("Error selecting from view_customer_total_items: ".mysqli_query($connect,$totals_query));
            }

            $totals = mysqli_fetch_assoc($totals_request);
            $total_quantity = $totals['total_quantity'];
            $total_price = $totals['total_price'];


            //create a customer order
            $order_query = "INSERT INTO orders(customer_id,total_quantity,total_price)VALUES('$customer_id','$total_quantity','$total_price')";
            $order_request = mysqli_query($connect,$order_query);
            if(!$order_request){
                throw new Exception("Error inserting to orders: ".mysqli_error($connect));
            }

            //get order id
            $order_id = mysqli_insert_id($connect);

            //push move items from cart_items to order_items and update product quantity
            foreach($items as $item){
                
                $product_id = $item['product_id'];
                $item_total_price = $item['total_price'];
                $item_quantity = $item['quantity'];

                // pushing item to order_items and deleting it from customer cart_item

                $order_items_query = "INSERT INTO order_items(order_id,product_id,total_quantity,total_price,customer_id)VALUES('$order_id','$product_id','$item_quantity','$item_total_price','$customer_id')";
                $order_items_request = mysqli_query($connect,$order_items_query);
                if(!mysqli_query($connect,$order_items_query)){
                    throw new Exception("Error inserting to order_items: ".mysqli_error($connect));
                }

                //get product quantity and reduce quantity by number of item_quantity
                $product_query = "SELECT * FROM products WHERE id = '$product_id'";
                $product_request = mysqli_query($connect,$product_query);
                if(!mysqli_query($connect,$product_query)){
                    throw new Exception("Error selecting to products: ".mysqli_error($connect));
                }
                // assign new quantity then push it to the database 
                $product = mysqli_fetch_assoc($product_request);
                $product_quantity = $product['quantity'];
                $new_quantity = $product_quantity - $item_quantity;

                $update_query = "UPDATE products SET quantity = '$new_quantity' WHERE id = '$product_id'";
                $update_request = mysqli_query($connect,$update_query);
                if(!mysqli_query($connect,$update_query)){
                    throw new Exception("Error updating product\'s quantity: ".mysqli_error($connect));
                }

                // delete item from customer cart
                $delete_query = "DELETE FROM cart_items WHERE customer_id='$customer_id' AND product_id='$product_id'";
                $delete_request = mysqli_query($connect,$delete_query);
                if(!mysqli_query($connect,$delete_query)){
                    throw new Exception("Error deleting product from cart items: ".mysqli_error($connect));
                }
            }    

            // Commit transaction
            mysqli_commit($connect);

            // Redirect to customer order page
            header("Location: ../user/order.php");
            mysqli_close($connect);
            exit;
        }
        catch (Exception $e) {
            // Rollback transaction in case of error
            mysqli_rollback($connect);
            echo "Transaction failed: " . $e->getMessage();
        }

        
        
        
    }

?>