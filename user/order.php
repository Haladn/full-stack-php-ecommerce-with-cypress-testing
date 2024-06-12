<?php
    include '../include/nav.php';
    require('../database/db_connect.php');

    //get customer_id from session
    $customer_id = $_SESSION['customer_id'];
    // get ordered items from order_items 
    $query = "SELECT * FROM view_customer_order WHERE customer_id='$customer_id'";
    $request = mysqli_query($connect,$query);
    if(!$request){
        throw new Exception("Error selecting ordered items: ".mysqli_error($connect));
    }

    if(mysqli_num_rows($request) > 0){
        $items=mysqli_fetch_all($request,MYSQLI_ASSOC);

        ?>
        <div class="container-fluid ">
        <div class="h5  text-center mt-4">Your orders</div>
        
            <div class="row justify-content-center">
                <div class="col col-md-7 col-9 border rounded bg-light">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>quntity</th>
                                <th>price</th>
                                <th>status</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            <?php
                                foreach($items as $item){
                                    ?>
                                        <tr>
                                        <td><?=$item['title']?></td>
                                        <td><?=$item['total_quantity']?></td>
                                        <td>£<?=number_format($item['total_price'],2)?></td>
                                        <td><?=$item['status']?></td>
                                        <td><?=$item['ordered_at']?></td>
                                        </tr>   
                                
                                    <?php
                                }
                            ?>
                            </tbody>
                            
                        </table>
                    </div>   
                </div>
            </div>
        </div>

        <?php
    }else{
        ?>
            <div class="container-fluid text-center mt-5">
                <p class="fw-bold h5">There is no order.</p>
            </div>

        <?php
    }
    


?>





<?php

    include "../include/footer.php";
?>







