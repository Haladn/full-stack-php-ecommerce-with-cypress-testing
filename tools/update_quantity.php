
<?php
    session_start();
    require('../database/db_connect.php');
    if($_SERVER['REQUEST_METHOD']=="POST" ){

        if(isset($_SESSION['customer_id'])){

            if(isset($_POST['update_btn'])){
                echo 'update button';
                //get values from the form
                $item_quantity = mysqli_real_escape_string($connect,$_POST['item_quantity']);
                $item_id = mysqli_real_escape_string($connect,$_POST['item_id']) ;
                $item_price = mysqli_real_escape_string($connect,$_POST['item_price']);
                $total_price = (float) $item_price * $item_quantity;
    
                // query to update
                $q = "UPDATE cart_items SET quantity = '$item_quantity', total_price = '$total_price' WHERE id='$item_id';";
                $r = mysqli_query($connect,$q);
                if($r){
                    // redirect again to cart
                    header("Location: ../user/cart.php");
                    mysqli_close($connect);
                    exit;
                }
                echo "Failed to connect DATABASE.".mysqli_error($connect);
                
            }
    
    
            if(isset($_POST['delete_btn'])){
                echo 'delete button';
                //get values from the form
                $item_quantity = mysqli_real_escape_string($connect,$_POST['item_quantity']);
                $item_id = mysqli_real_escape_string($connect,$_POST['item_id']) ;
    
                // query to delete
                $q = "DELETE FROM cart_items WHERE id='$item_id';";
                $r = mysqli_query($connect,$q);
                if($r){
                    // redirect again to cart
                    header("Location: ../user/cart.php");
                    mysqli_close($connect);
                    exit;
                }
                echo "Failed to connect DATABASE.".mysqli_error($connect);
                
            }
        }

        // if customer not registered 
        else{
            $item_quantity = $_POST['item_quantity'];
            $item_id = $_POST['item_id'];
                
            // check to update quantity
            if(isset($_POST['update_btn']) && isset($_SESSION['cart'])){
                
                // update quantity
                $_SESSION['cart'][$item_id]['in_cart_quantity'] = $item_quantity;
            }
            // check to delete item
            else{
                // delete item from session cart
                unset($_SESSION['cart'][$item_id]);
            }

            // redirect to cart
            header("Location: ../user/cart.php");
            exit;
        }

        
    }

    
    // redirect usert that want to access the content through url input
      
    header("Location: ../home.php");
        

?>