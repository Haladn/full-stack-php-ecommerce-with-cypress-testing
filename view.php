<?php
    include 'include/nav.php';
    require('database/db_connect.php');

    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id='$product_id'";
    $request = mysqli_query($connect,$query);
    if(@mysqli_num_rows($request) == 1){
        $product = mysqli_fetch_array($request,MYSQLI_ASSOC);
        ?>
        <div class="row justify-content-center mt-5" style="height: 18rem;">
            <div class="col col-md-4 col-lg-3 col-sm-5 col-8 bg-light rounded">
                <div class="card me-auto ms-auto " >
                    <img src="<?=$product['image']?>" alt="Product Image" class="card-img-top img-fluid img-thumbnail"  style="height: 400px;">
                    
                </div>
            </div>

            <div class="col col-md-4 col-lg-3 col-sm-5 col-8 bg-light rounded">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div class="card-body">
                        <p class="card-title h5 mb-4"><?=$product['title']?></p>
                        <p class="card-subtitle h6">Description:</p>
                        <p class="card-text"><?=$product['description']?></p>
                        <p class="fw-bold mt-3">Price: £<?=$product['price']?></p>
                        <p class="mb-1 fw-bold text-<?=$product['quantity'] > 0? 'ordinary':'danger'?>"><?=$product['quantity'] > 0? 'in stock':'Out of stock'?></p>
                        <form action="./tools/add_to_cart.php" method="POST">
                            <input name="view_product_quantity" class="form-cotrol"  type="number" min="0" max="<?=$product['quantity']?>" value="<?=$product['quantity'] > 0?'1':'0'?>">
                            <input name="product_id" type="text" value="<?=$product['id']?>" hidden>
                            <?php if($product['quantity'] >0)
                                { 
                                    ?>
                                <div class="input-group  mt-3 justify-content-center">
                                    <div class="me-2">
                                        <a href="<?=$_SERVER['HTTP_REFERER']?>" class="px-3 btn btn-danger">Back</a>
                                    </div>
                                    <div>
                                    <button  name="add_to_cart" type="submit" class=" btn btn-md btn-secondary">Add to cart</button>
                                    </div>
                                </div>
                        
                            <?php
                                }
                                ?>
                        </form>

                    </div>
                    
                 </div>
            </div>
        </div>

        <?php
    }

?>




















<?php
    include 'include/footer.php';
?>