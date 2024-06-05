<?php
    include '../include/nav.php';

    // get registered customer's cart items
    if(isset($_SESSION['customer_id'])){
        // get customer id from session
        $customer_id = $_SESSION['customer_id'];

        //get customer's items in cart from a typical view in the database
        $q ="SELECT * FROM view_customer_cart WHERE customer_id = '$customer_id';";
        $r = mysqli_query($connect,$q);
        if($r && mysqli_num_rows($r) > 0){
            $items = mysqli_fetch_all($r,MYSQLI_ASSOC);
            // getting and display total price and total quantity that assigned values in nav.php.
            ?>
                <div class="container-fluid text-center mt-5 ">
                    <div class="col col-10 col-md-4 bg-light mx-auto p-3 rounded border border-dark">
                        <div class="h6">Total Products: <?=$total_quantity?></div>
                        <div class="h6">Total Price: £<?=number_format($total_price,2)?></div>

                        <form action="../tools/checkout.php" method="POST">
                            <input name="total_quantity" type="text" value="<?=$total_quantity?>" hidden>
                            <input name="total_price" type="text" value="<?=$total_price?>" hidden>
                            <button type="submit" name="total_checkout_btn" class="btn btn-md btn-success mt-2">Checkout</button>
                        </form>
                    </div>
                </div>

            <?php
                // looping through items and display them
                foreach($items as $product){
                    ?>
                        <div class="container-fluid">
                            <div class="card my-5 p-2 bg-light mx-auto " style="max-width:700px;"> 
                                <div class="row g-3">  

                                     <img class="img-fluid " style="max-height: 200px;max-width: 200px;"  src="<?=$product['image']?>" alt="<?=$product['title']?>">

                                    <div class="col-md-8">
                                        <div class="d-flex flex-column justify-content-between align-items-stretch h-100">
                                            <div class="card-title fw-bold"><?=$product['title']?></div>
                                            
                                            <div class="card-title fw-bold">
                                                Price: £<?= number_format($product['price'], 2) ?>
                                            </div>
                                            <div>
                                                <form action="../tools/update_quantity.php" method="POST">
                                                    <input style="width:45px;" name="item_quantity" type="number" min="1" max="<?=$product['product_quantity']?>" value="<?=$product['in_cart_quantity']?>">
                                                    <input name="item_id" type="text"  value="<?=$product['cart_item_id']?>" hidden>
                                                    <input name="item_price" type="text" value="<?=$product['price']?>" hidden>
        
                                                    <button type="submit" name="update_btn" class="btn btn-sm btn-warning mb-1">update</button>
                                                    <button type="submit" name="delete_btn" class="btn btn-sm btn-danger mb-1">delete</button>
                                                    <a class="btn btn-sm btn-info mb-1" href="../view.php?id=<?=$product['product_id']?>">view</a>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    <?php
                }
        }
        else{
            ?>
                <!-- if customer cart is empty -->
                <div class="container-fluid text-center mt-5">
                    <div class="h4">There is no Item in your Cart.</div>
                </div>

            <?php
        }
    }
    // if user not regestered get items from session cart
    else{

        // items available in session cart
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            $items = $_SESSION['cart'];

            // getting and display total price and total quantity that assigned values in nav.php.
            ?>
                 <div class="container-fluid text-center mt-5">
                    <div class="col col-10 col-md-4 bg-light mx-auto p-3 rounded border border-dark">
                        <div class="h6">Total Products: <?=$total_quantity?></div>
                        <div class="h6">Total Price: £<?=number_format($total_price,2)?></div>

                        <form action="../tools/checkout.php" method="POST">
                            <input name="total_quantity" type="text" value="<?=$total_quantity?>" hidden>
                            <input name="total_price" type="text" value="<?=$total_price?>" hidden>
                            <button type="submit" name="total_checkout_btn" class="btn btn-md btn-success mt-2">Checkout</button>
                        </form>
                    </div>
                </div>

            <?php

            // looping through items
            foreach($items as $product_id => $product_detail){

                ?>
                    <div class="container-fluid">
                        <div class="card my-5 p-2 bg-light mx-auto" style="max-width:700px;">
                            <div class="row g-3">  
                                    <img class="img-fluid " style="max-height: 200px;max-width: 200px;"  src="<?=$product_detail['image']?>" alt="<?=$product_detail['title']?>">
                                <div class="col-md-8">
                                    <div class="d-flex flex-column justify-content-between align-items-stretch h-100">
                                        <div class="card-title fw-bold"><?=$product_detail['title']?></div>
                                        
                                        <div class="card-title fw-bold">
                                            Price: £<?= number_format($product_detail['price'], 2) ?>
                                        </div>
                                        <div>
                                            <form action="../tools/update_quantity.php" method="POST">
                                                <input style="width:45px;" name="item_quantity" type="number" min="1" max="<?=$product_detail['in_stock_quantity']?>" value="<?=$product_detail['in_cart_quantity']?>">
                                                <input name="item_id" type="text"  value="<?=$product_id?>" hidden>
                                                <input name="item_price" type="text" value="<?=$product_detail['price']?>" hidden>
    
                                                <button type="submit" name="update_btn" class="btn btn-sm btn-warning mb-1">update</button>
                                                <button type="submit" name="delete_btn" class="btn btn-sm btn-danger mb-1">delete</button>
                                                <a class="btn btn-sm btn-info mb-1" href="../view.php?id=<?=$product_id?>">view</a>
                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>

                <?php
                
            }
            
        }
        // if session cart is empty
        else{
            ?>
                <!--  if customer cart is empty -->
                <div class="container-fluid text-center mt-5">
                    <div class="h4">There is no Item in your Cart.</div>
                </div>

            <?php
        }
    }


?>













<?php
    include '../include/footer.php';
?>