<?php
    include '../include/nav.php';

    // get loged in customer's cart items
    $items=[];
    if(isset($_SESSION['customer_id'])){
        // get customer id from session
        $customer_id = $_SESSION['customer_id'];

        //get customer's items in cart from a typical view in the database
        $q ="SELECT * FROM view_customer_items WHERE customer_id = '$customer_id';";
        $r = mysqli_query($connect,$q);
        if($r && mysqli_num_rows($r) > 0){
            $items = mysqli_fetch_all($r,MYSQLI_ASSOC);
            

        }
    }
    // if user not regestered grt items from session cart
    else{
        if(isset($_SESSION['cart'])){
            $items = $_SESSION['cart'];
            
        }
    }


    // display queried items 

    if($items){
        foreach($items as $product){
            
            ?>
                <div class="container-fluid">
                    <div class="card my-5 p-2 bg-light mx-auto" style="max-width:700px;">
                        <div class="row g-3">
                            
                                <img class="img-fluid " style="max-height: 200px;max-width: 200px;"  src="<?=$product['image']?>" alt="<?=$product['title']?>">
                            

                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="card-title fw-bold"><?=$product['title']?></div>
            
                                    <form class="" action="">
                                        <input class="" type="number" min="1" max="<?=$product['product_quantity']?>" value="<?=$product['in_cart_quantity']?>">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info">update</button>
                                            <button class="btn btn-sm btn-danger">delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 

            <?php
        }
    }else{
        // display a messagefor an empty cart

    }

?>













<?php
    include '../include/footer.php';
?>