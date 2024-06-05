<?php
    function validate($link,$email='',$password=''){

        $errors = array();

        //check email and password
        if(empty($email)){
            $errors['email'] = 'enter your email address';
        }else{
            $e= mysqli_real_escape_string($link,$email);
        }

        if(empty($password)){
            $errors['password']='enter your password';
        }else{
            $pwd = mysqli_real_escape_string($link,$password);
        }

        if(empty($errors)){
            $q ="SELECT id,username FROM customers WHERE email='$e'AND password='$pwd'";

            $r = mysqli_query($link,$q);
            if(@mysqli_num_rows($r)==1){
                $row = mysqli_fetch_array($r,MYSQLI_ASSOC);
                return array(true,$row);
            }
            else{
                $errors['notFound'] = 'Email address and Password not found';
            }
        }

        return array(false,$errors) ;


    }

?>