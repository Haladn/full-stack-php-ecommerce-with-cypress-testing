<?php

    include '../include/nav.php';
    require('../database/db_connect.php');

     // display message if there is any
     if(isset($_SESSION['message'])){
        ?>
            <div class="row justify-content-center mt-5">
                <div class=" col-sm-6 col-10">
                    <div id="signup_message" class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?='<p>'.$_SESSION['message'].'</p>'?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php
        unset($_SESSION['message']);
    }

    // processing the sign up form data
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['signup_btn'])){
            //initialize an error array
            $errors = array();

            //check values
            if(empty($_POST['username'])){
                $errors['username'] = 'Enter username';
            }else{
                $username = mysqli_real_escape_string($connect,trim($_POST['username']));
            }

            if(empty($_POST['email'])){
                $errors['email'] = 'Enter email address';
            }else{
                $email = mysqli_real_escape_string($connect,trim($_POST['email']));
            }

            if(empty($_POST['password'])){
                $errors['password'] = 'Enter password';
            }else{
                if($_POST['password'] !== $_POST['confirm_password']){
                    $errors['password'] = 'Password doesn\'t match';
                }else{
                    $password = mysqli_real_escape_string($connect,trim($_POST['password']));
                }
                
            }

            // checking errors array
            if(empty($errors)){

                // check if the username or email exist 
                $check_query = "SELECT * FROM customers WHERE username='$$username' OR email='$email'";
                $check_request = mysqli_query($connect,$check_query);
                if($check_request && mysqli_num_rows($check_request)==1){
                    $_SESSION['message'] = "A User account with that username/email already exist try login or use a different username/email to register.";
                }else{
                     // make querry
                    $query = "INSERT INTO customers(username,email,password,created_at) VALUES ('$username','$email','$password',NOW())";
                    $request = mysqli_query($connect,$query);
                    if($request){
                        // get customer id
                        $customer_id = mysqli_insert_id($connect);

                        // check if there is any item in session cart
                        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){

                            // create a customer cart
                            $cart_query = "INSERT INTO cart(customer_id) VALUES('$customer_id');";
                            $cart_requet = mysqli_query($connect,$cart_query);
                            if($cart_requet){

                                // get cart id
                                $cart_id = mysqli_insert_id($connect);

                                $session_cart = $_SESSION['cart'];
                                //looping through every item in session cart and pusht it to the database
                                foreach($session_cart as $product_id => $cart_item){

                                    // product_id = $product_id just to remember
                                    $quantity = $cart_item['in_cart_quantity'];
                                    $total_price = (float) $cart_item['price'] * $quantity;

                                    // creat a customer cart item
                                    $q = "INSERT INTO cart_items(cart_id,product_id,total_price,quantity) VALUES('$cart_id','$product_id','$total_price','$quantity');";
                                    $r = mysqli_query($connect,$q);
                                    if($r){
                                        // destroy cart session
                                        unset($_SESSION['cart']);
                                    }

                                }

                            }else{
                                echo "Failed to connect to database".mysqli_error($connect);
                            }

                        }
                        
                    }

                $_SESSION['message']="YOU signed up successfully";
                    header("Location: ./login.php");
                    mysqli_close($connect);
                    exit;
                }
               

            }else{
                ?>
                <!-- create a container to display errors -->
                <div class="row justify-content-center mt-5">
                    <div class="col-sm-6 col-10">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                    <?php
                foreach($errors as $key => $value){
                    echo '<li>'.$value.'</li>';
                }
                ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    </div>
                </div>
                <?php
            }
        }

    }
?>

<div class="row justify-content-center mt-5">
    <div class="col-sm-6 col-10 bg-light pt-2">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="signup_username" class="control-label">Username*</label>
            <input  name="username" type="text" class="form-control" id="signup_username" value="<?=isset($_POST['username'])? $_POST['username']:''?>" required>

            <label for="email" class="control-label">Email*</label>
            <input  name="email" type="email" class="form-control" id="signup_email" value="<?=isset($_POST['email'])?$_POST['email']:''?>" required>

            <label for="signup_password" class="control-label">Password*</label>
            <input name="password" type="password"  class="form-control" id="signup_password" value="<?=isset($_POST['password'])?$_POST['password']:''?>" required>

            <label for="signup_confirm_password" class="control-label">Confirm Password*</label>
            <input name="confirm_password" type="password" class="form-control" id="signup_confirm_password" value="<?=isset($_POST['password1'])?$_POST['password1']:''?>" required>

            <button type="submit" class="btn btn-md btn-dark mt-3" name="signup_btn">Sign up</button>
        </form>

        <p class="mt-3">*If already been registered <a href="<?= MAIN_DIRECTORY?>/user/login.php" >Login</a> here.</p>
    </div>
</div>




<?php
    include '../include/footer.php'
?>