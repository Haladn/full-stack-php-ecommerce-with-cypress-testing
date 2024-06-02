<?php

    include '../include/nav.php';
    require('../database/db_connect.php');


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

                $query = "INSERT INTO customers(userName,email,password,created_at) VALUES ('$username','$email','$password',NOW())";
                $request = mysqli_query($connect,$query);
                if($request){
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
            <input name="username" type="text" class="form-control" id="signup_username" value="<?=isset($_POST['username'])? $_POST['username']:''?>" required>

            <label for="email" class="control-label">Email*</label>
            <input name="email" type="email" class="form-control" id="signup_email" value="<?=isset($_POST['email'])?$_POST['email']:''?>" required>

            <label for="signup_password" class="control-label">Password*</label>
            <input name="password" type="password" class="form-control" id="signup_password" value="<?=isset($_POST['password'])?$_POST['password']:''?>" required>

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