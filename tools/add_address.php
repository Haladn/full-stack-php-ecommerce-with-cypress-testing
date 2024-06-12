<?php
    session_start();
     require('../database/db_connect.php');

     echo "add ADDRESS";

    // handle requsts from cart checkout and check user address
    if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_POST['total_checkout_btn'])){
        // check user login
        if(isset($_SESSION['customer_id'])){
            // get customer id
            $customer_id = $_SESSION['customer_id'];

            // check user address
            $q="SELECT * FROM address WHERE customer_id='$customer_id'";
            $r=mysqli_query($connect,$q);
            if($r && mysqli_num_rows($r) > 0){
                
                // redirect to checkout 
                $_SESSION['checkout_in_process'] = true;
                header("Location: ../user/checkout.php");
                mysqli_close($connect);
                exit;

            }
            else if($r && mysqli_num_rows($r) == 0){
                // redirect to address 
                echo 'database request is good but mysqli_num bor rows is 0';
                $_SESSION['checkout_in_process'] = true;
                header("Location: ../user/address.php");
                mysqli_close($connect);
                exit;
            }
            else{
                echo "faild to connect to database:".mysqli_error($connect);
            }

        }
        // redirect user to login page
        else{

            $_SESSION['message'] = "Please login to make order!";
            header(("Location: ../user/login.php"));
            exit;
        }
    }    

    // handle form data
    // check user login
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add_address_btn'])){
        // get customer id
        $customer_id = $_SESSION['customer_id'];
        ECHO 'EVERYTHING IS OK';
        if(isset($_SESSION['customer_id'])){

        
            $errors = array();

            // check posted data
            if(empty($_POST['firstname'])){
                $errors['firstname']='Enter firstname';
            }
            $firstname = mysqli_real_escape_string($connect,trim($_POST['firstname']));

            if(empty($_POST['lastname'])){
                $errors['lastname']='Enter lastname';
            }
            $lastname = mysqli_real_escape_string($connect,trim($_POST['lastname']));

            if(empty($_POST['country'])){
                $errors['country']='Enter country';
            }
            $country = mysqli_real_escape_string($connect,trim($_POST['country']));

            if(empty($_POST['phone'])){
                $errors['phone']='Enter phone';
            }
            $phone = mysqli_real_escape_string($connect,trim($_POST['phone']));

            if(empty($_POST['street'])){
                $errors['street']='Enter street';
            }
            $street = mysqli_real_escape_string($connect,trim($_POST['street']));

            if(empty($_POST['city'])){
                $errors['city']='Enter city';
            }
            $city = mysqli_real_escape_string($connect,trim($_POST['city']));

            if(empty($_POST['postcode'])){
                $errors['postcode']='Enter postcode';
            }
            $postcode = mysqli_real_escape_string($connect,trim($_POST['postcode']));

            // errors array
            if(empty($errors)){

                // format the address
                $formatted_address = ucfirst($street).",".ucfirst($city).",".strtoupper($postcode);
                $q = "INSERT INTO address(customer_id,first_name,last_name,country,phone,street,city,postcode,default_address,formatted_address)
                VALUES('$customer_id','$firstname','$lastname','$country','$phone','$street','$city','$postcode',1,'$formatted_address')";
                
                $r=mysqli_query($connect,$q);
                if($r){

                    // check that refered from checkout
                    if(isset($_SESSION['checkout_in_process']) && $_SESSION['checkout_in_process']){
                        
                        header("Location: ../user/checkout.php");
                        mysqli_close($connect);
                        unset($_SESSION['checkout_in_process']);
                        exit;

                    }else{
                        // redirect to customer profile
                        header("Location: ../user/profile.php");
                        mysqli_close($connect);
                        exit;
                    }

                    
                }
                
                echo "faild to connect to database:".mysqli_error($connect);
                
            }
            //display errors
            else{
                
                    ?>
                        <div class="row justify-content-center mt-5">
                            <div class=" col-sm-6 col-10">
                                <div id="signup_message" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?php
                                    foreach($errors as $key->$value){
                                        
                                        echo '<p>'.$value.'</p>';
                                        
                                    }
                                    ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    <?php
                
            }


            
        }

        //  else{
        //      //if user not loged in redirect it to login page
        //      $_SESSION['message']="Please, Login to add your address!";
        //      header("Location: ../user/login.php");
        //  }
    }

?>