<?php
    include './nav.php';
    require('./db_connect.php');


    $query = "SELECT * FROM products";
    $request = mysqli_query($connect,$query);
    if(mysqli_num_rows($request) > 0){
        $products = mysqli_fetch_array($request);
        ?>

            <div class="container-fluid">
                <div class="d-flex ">
                    <?php
                        foreach($products as $product){
                            ?>
                            <div>
                            <div class="card" style="width: 16rem;">
                                <img src="" alt="" class="card-img-top">
                                <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">price</p>
                            <a href="" class="btn btn-primary">detail</a>
                            </div>
                            </div>
                            <?php
                        }
                    ?>

                    

                    </div>
                </div>
            </div>


        <?php
    }
?>






<?php
include "footer.php";

?>