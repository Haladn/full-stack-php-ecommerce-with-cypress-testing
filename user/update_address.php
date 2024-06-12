<?php

    require( "../include/nav.php");

    // get address id from url
    $id = $_GET['id'];

    // get customer id
    $customer_id = $_SESSION['customer_id'];

    // handle update form
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update_address_btn'])){

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
                $q = "UPDATE address SET
                    first_name = '$firstname' ,
                    last_name = '$lastname' ,
                    country = '$country',
                    phone = '$phone',
                    street = '$street',
                    city = '$city',
                    postcode='$postcode',
                    default_address = 1 ,
                    formatted_address = '$formatted_address' 
                    WHERE id='$id'";
                
                $r=mysqli_query($connect,$q);
                if($r){
                    
                
                    // redirect to customer profile
                    //header("Location: ./profile.php");
                    echo'<script type="text/javascript">window.location.href="profile.php"</script>';
                    mysqli_close($connect);
                    exit;
                }
                else{
                    throw new Exception("Error updating customer address: ".mysqli_error($connect));
                }
                
                
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
    }


    // page content

        $address_query = "SELECT * FROM address WHERE customer_id='$customer_id'";
        $address_request = mysqli_query($connect,$address_query);
        if(!$address_request){
            throw new Exception("Error selecting customer address: ".mysqli_error($connect));
        }
        
        // if(mysqli_num_rows($address_request) > 0){
            $address = mysqli_fetch_assoc($address_request); 
            ?>

            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col col-md-5 col-9">
                    <div class="h6 mb-3">Address Detail</div>
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                            <label for="firstname">First Name*</label>
                            <input id="firstname" name="firstname" type="text" class="form-control" value="<?=isset($address['first_name'])? $address['first_name'] : (isset($_POST["username"]) ? $_POST["username"]:'')?>" required>

                            <label for="lastname">Last Name*</label>
                            <input id="lastname" name="lastname" type="text" class="form-control" value="<?=isset($address['last_name'])? $address['last_name'] :(isset($_POST["last_name"]) ? $_POST["last_name"]:'') ?>" required>

                            <label for="country">Country*</label>
                            <input id="country" name="country" type="text" class="form-control" value="<?=isset($address['country'])? $address['country'] :(isset($_POST["country"]) ? $_POST["country"]:'') ?>" required>

                            <label for="phone">Phone*</label>
                            <input id="phone" name="phone" type="tel" class="form-control" value="<?=isset($address['phone'])? $address['phone'] :(isset($_POST["phone"]) ? $_POST["phone"]:'') ?>" required>
                            
                            <label for="street">Street*</label>
                            <input id="street" name="street" type="text" class="form-control" value="<?=isset($address['street'])? $address['street'] :(isset($_POST["street"]) ? $_POST["street"]:'') ?>" required>
                            
                            <label for="city">City*</label>
                            <input id="city" name="city" type="text" class="form-control" value="<?=isset($address['city'])? $address['city'] :(isset($_POST["city"]) ? $_POST["city"]:'') ?>" required>
                            
                            <label for="postcode">Postcode*</label>
                            <input id="postcode" name="postcode" type="text" class="form-control" value="<?=isset($address['postcode'])? $address['postcode'] :(isset($_POST["postcode"]) ? $_POST["postcode"]:'') ?>" required>
                            
                            <button name="update_address_btn" type="submit" class="btn btn-md btn-warning mt-2">update</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php
  
?>

    






<?php
    include "../include/footer.php"

?>