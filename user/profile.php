<?php
    require ('../include/nav.php');
    

    // get user detail
    $customer_id = $_SESSION['customer_id'];
    $user_query = "SELECT * FROM customers WHERE id='$customer_id'";
    $user_request = mysqli_query($connect,$user_query);
    if(!$user_request){
        throw new Exception('Eroor selecting customer details: '.mysqli_error($connect));
    }

    $user = mysqli_fetch_assoc($user_request);
    
    // get user address
    $address_query = "SELECT * FROM address WHERE customer_id='$customer_id'";
    $address_request = mysqli_query($connect,$address_query);
    if(!$address_request){
        throw new Exception("Error selecting customer address: ".mysqli_error($connect));
    }
    
    // if(mysqli_num_rows($address_request)>0){
        $address = mysqli_fetch_array($address_request);
        ?>
            <div class="container-fluid mt-5">
                <div class="row justify-content-center">
                    <div class="h6 text-center fw-bold">User Profile</div>
                    <div class="col col-md-5 col-9 bg-light border rounded p-3">
                        <div class="fw-bold">Your Detail</div>
                        <ul>
                            <li>Username: <span ><?=$user['username']?></span></li>
                            <li>Email: <span ><?=$user['email']?></span></li>
                        </ul>
                        <hr>

                        <div>
                            <div class="fw-bold">Your orders</div>
                            <ul>
                                <li><a href="../user/order.php" class="btn btn-link">Go to your orders</a></li>
                            </ul>
                        </div>
                        <hr>
                        <div class="fw-bold">Your Address</div>
                        <ul>
                            <li>
                                <?=isset($address['formatted_address'])? $address['formatted_address'] : 'No address to show.'?>
                                <span class="ms-5">
                                    <?=isset($address['id'])? '':'<a href="./address.php?" class="btn btn-sm btn-info px-3">add</a>'?>
                                    <?=isset($address['id'])?'<a href="./update_address.php?id='.$address['id'].'" class="btn btn-sm btn-warning">update</a>' : ''?>
                                </span>
                            </li>
                        </ul>
                        
                    </div>

                </div>
            </div>







<?php
    include '../include/footer.php';

?>