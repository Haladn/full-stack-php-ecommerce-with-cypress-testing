<?php

    require( "../include/nav.php");

    // get address id from url
    
    ?>

        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col col-md-5 col-9">
                <div class="h6 mb-3">Address Detail</div>
                    <form action="../tools/add_address.php" method="POST">
                        <label for="firstname">First Name*</label>
                        <input id="firstname" name="firstname" type="text" class="form-control" value="<?=isset($_POST['username']) ? $_POST['username']:''?>" required>

                        <label for="lastname">Last Name*</label>
                        <input id="lastname" name="lastname" type="text" class="form-control" value="<?=isset($_POST["last_name"]) ? $_POST["last_name"]:'' ?>" required>

                        <label for="country">Country*</label>
                        <input id="country" name="country" type="text" class="form-control" value="<?=isset($_POST["country"]) ? $_POST["country"]:'' ?>" required>

                        <label for="phone">Phone*</label>
                        <input id="phone" name="phone" type="tel" class="form-control" value="<?=isset($_POST["phone"]) ? $_POST["phone"]:'' ?>" required>
                        
                        <label for="street">Street*</label>
                        <input id="street" name="street" type="text" class="form-control" value="<?=isset($_POST["street"]) ? $_POST["street"]:''?>" required>
                        
                        <label for="city">City*</label>
                        <input id="city" name="city" type="text" class="form-control" value="<?=isset($_POST["city"]) ? $_POST["city"]:'' ?>" required>
                        
                        <label for="postcode">Postcode*</label>
                        <input id="postcode" name="postcode" type="text" class="form-control" value="<?=isset($_POST["postcode"]) ? $_POST["postcode"]:'' ?>" required>
                        
                        <button name="add_address_btn" type="submit" class="btn btn-md btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>




<?php
    include "../include/footer.php"

?>