<?php
    // include required files
    include 'include/nav.php';
    require('database/db_connect.php');

    // check for search products
    if(isset($_POST['search_btn'])){
        $search = mysqli_real_escape_string($connect,trim($_POST['search']));
        $query = "SELECT * FROM products WHERE title LIKE '%$search%'";
        $request = mysqli_query($connect,$query);
        if(mysqli_num_rows($request) > 0){
            $products = mysqli_fetch_all($request,MYSQLI_ASSOC);
            ?>
            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-center">
                    <?php
                        foreach($products as $product){
                            ?>
                                <div class="card my-5 mx-5" style="width: 16rem;">
                                    <img src="<?=$product['image']?>" alt="Product Image" class="card-img-top img-fluid" style="height: 300px;">
                                    <div class="card-body bg-light">
                                    <div class="card-title h6" style="height: 90px;"><?=$product['title']?></div>
                                    <p class="mb-1 fw-bold text-<?=$product['quantity'] > 0? 'ordinary':'danger'?>"><?=$product['quantity'] > 0? 'in stock':'Out of stock'?></p>
                                    <p class="card-text h6 pb-2">Price: £<?=$product['price']?></p>
                                    <div class="input-group justify-content-center">
                                        <?php if($product['quantity'] >0){ ?>
                                        <div class="me-2">
                                        <form action="./tools/add_to_cart.php" method="POST">
                                                <input name="product_id" type="text" value="<?=$product['id']?>" hidden>
                                                <button name="add_to_cart" type="submit" class="btn btn-secondary">add to cart</button>
                                        </form>
                                        </div>
                                        <?php } ?>

                                        <div>
                                        <a href="view.php?id=<?=$product['id'];?>" class=" btn btn-info px-4">view</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        <?php


        }else{
            ?>
            <div class="container-fluid text-center mt-5">
                <div class="h4">No results for <?=$_POST['search']?>.</div>
                
                <div class="h4">Try checking your spelling or use more general terms</div>
            </div>
            <?php
        }
    }
    else {
    
    // if there isnt any check
    $query = "SELECT * FROM products";
    $request = mysqli_query($connect,$query);
    if(mysqli_num_rows($request) > 0){
        $products = mysqli_fetch_all($request,MYSQLI_ASSOC);
        ?>

            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-center">
                    <?php
                        foreach($products as $product){
                            ?>
                                <div class="card my-5 mx-5" style="width: 16rem;">
                                    <img src="<?=$product['image']?>" alt="Product Image" class="card-img-top" style="height: 300px;">
                                    <div class="card-body bg-light">
                                    <div class="card-title h6" style="height: 90px;"><?=$product['title']?></div>
                                    <p class="mb-1 fw-bold text-<?=$product['quantity'] > 0? 'ordinary':'danger'?>"><?=$product['quantity'] > 0? 'in stock':'Out of stock'?></p>
                                    <p class="card-text h6 pb-2">Price: £<?=$product['price']?></p>
                                    <div class="input-group justify-content-center">
                                        <?php if($product['quantity'] >0){ ?>
                                        <div class="me-2">
                                            <form action="./tools/add_to_cart.php" method="POST">
                                                <input name="product_id" type="text" value="<?=$product['id']?>" hidden>
                                                <button name="add_to_cart" type="submit" class="btn btn-secondary">add to cart</button>
                                            </form>
                                        </div>
                                        <?php } ?>

                                        <div>
                                        <a href="view.php?id=<?=$product['id'];?>" class=" btn btn-info px-4">view</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        <?php
    }
    }

?>






<?php
include "include/footer.php";

?>