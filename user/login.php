<?php
    include '../include/nav.php';
    include '../tools/validate.php';
    require "../database/db_connect.php";

    // display a successfull message for after new user registration
    if(isset($_SESSION['message'])){
        ?>
            <div class="row justify-content-center mt-5">
                <div class=" col-sm-6 col-10 text-center">
                    <div id="success_message" class="alert alert-warning alert-dismissible fade show fw-bold" role="alert">
                        <?='<p>'.$_SESSION['message'].'</p>'?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php
        unset($_SESSION['message']);
    }

    // handling the form data
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['login'])){
            list ($check,$data) = validate($connect,$email=$_POST['email'],$password=$_POST['password']);
            if($check){
                $_SESSION['customer_id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['login_time'] = time();
                
                //redirect to home page
                //header("Location: ../home.php")  // we can't use header beacause it gives error that we already
                                                   // sent header in nav.php  then we used javascript location to redirect

                echo'<script type="text/javascript">window.location.href="../home.php"</script>';
                mysqli_close($connect);
                exit;
            }
            // display errors message
            else{
                ?>
                <div class="row justify-content-center mt-5">
                    <div class=" col-sm-6 col-10">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                <?php
                foreach($data as $message){
                    echo '<li>'.$message.'</li>';
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
    <div class=" col-sm-6 col-10 bg-light pt-3">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <label for="email" class="form-label">Email*</label>
        <input type="text" class="form-control" id="email" name="email">
        
        <label for="password" class="form-label">Password*</label>
        <input type="password" class="form-control" id="password" name="password">
        <button type="submit" name="login" class="btn btn-md btn-dark mt-2">Login</button>
    </form>
    <p class="mt-3">*If not registered yet! <a href="<?= MAIN_DIRECTORY?>/user/signup.php" >Sign up</a> here.</p>
    </div>
</div>

















<?php
    include '../include/footer.php'
?>