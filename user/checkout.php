<?php
    require('../include/nav.php');

    if(isset($_SESSION['checkout_in_process']) && $_SESSION['checkout_in_process'] && $_SESSION['customer_id']){

        //get customer_id from session
        $customer_id = $_SESSION['customer_id'];

        // get customer address
        $query_address ="SELECT formatted_address FROM address WHERE customer_id='$customer_id' AND default_address=1";
        $request_address = mysqli_query($connect,$query_address);
        if(!$request_address){
            echo "faild to connect to the database:".mysqli_error($connect);
            exit;
        }

        $address = mysqli_fetch_array($request_address,MYSQLI_ASSOC);

        //get totals from view_customer_total_items
        $total_query = "SELECT * FROM view_customer_total_items WHERE customer_id='$customer_id'";
        $total_request = mysqli_query($connect,$total_query);
        if(!$total_request){
            echo "faild to connect to the database:".mysqli_error($connect);
            exit;
        }

        $totals = mysqli_fetch_assoc($total_request);

        // get detail of order_items
        $query_items = "SELECT * FROM cart_items WHERE customer_id = '$customer_id'";
        $request_items = mysqli_query($connect,$query_items);
        if(!$request_items){
            echo "faild to connect to the database:".mysqli_error($connect);
        }
        $items=mysqli_fetch_all($request_items,MYSQLI_ASSOC);

        ?>

            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col col-md-5 col-9 border rounded">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>shipping address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$address['formatted_address']?></td>
                                    </tr>
                                </tbody>
                            </table>
                                <div class="fw-bold ms-2 mt-4">order items</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>quntity</td>
                                        <td>price</td>

                                    </tr>
                                </thead>
                                <tbody>
    
                                        <?php
                                            foreach($items as $item){
                                                ?>
                                                <tr>
                                                    <td><?=$item['title']?></td>
                                                    <td><?=$item['quantity']?></td>
                                                    <td>£<?=number_format($item['total_price'],2)?></td>
                                                </tr>   
                                            
                                                <?php
                                            }
                                        ?>

                                </tbody>
                            </table>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>totals</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                            <td>total price</td>
                                            <td>£<?=$totals['total_price']?></td>
                                    </tr>
                                    <tr>
                                            <td>total quantity</td>
                                            <td><?=$totals['total_quantity']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
                <div class="row row-cols-1 justify-content-center text-center mt-2">

                    <form action="../tools/purchase.php" method="POST">
                        <button name="purchase_btn" type="submit" class="btn btn-md btn-primary ps-5 pe-5">
                            Purchase
                        </button>
                    </form>

                </div>
            </div>
        

        <?php
    }

?>



<!-- <div id="paypal-button-container"></div> -->



   
<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({

        style: {
            color:  'blue',
            shape:  'pill',
            label:  'pay',
            height: 40
        },
        
        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return fetch('/demo/checkout/api/paypal/order/create/', {
                method: 'post'
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                return orderData.id;
            });
        },

        // Call your server to finalize the transaction
        onApprove: function(data, actions) {
            return fetch('/demo/checkout/api/paypal/order/' + data.orderID + '/capture/', {
                method: 'post'
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                // Three cases to handle:
                //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                //   (2) Other non-recoverable errors -> Show a failure message
                //   (3) Successful transaction -> Show confirmation or thank you

                // This example reads a v2/checkout/orders capture response, propagated from the server
                // You could use a different API or structure for your 'orderData'
                var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart(); // Recoverable state, per:
                    // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                }

                if (errorDetail) {
                    var msg = 'Sorry, your transaction could not be processed.';
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                    if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                    return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                }

                // Successful capture! For demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                // Replace the above to show a success message within this page, e.g.
                // const element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
            });
        }

    }).render('#paypal-button-container');
</script>









<?php
    include '../include/footer.php';
?>