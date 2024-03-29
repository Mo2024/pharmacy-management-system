<?php $title = "Order Details"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/profile/orderDetails.inc.php')?>

<div class="container mb-3" style="margin-top:30px;">
<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="bg-color border card border-color-form shadow">
            <div class="card-body">
            <h5 class="card-title text-center" style="font-size:45px;font-weight:bold;color:black;">Order Details</h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><h5>Order No: </h5><?php echo $row['oid'] ?></li>
                <li class="list-group-item"> <h5>Price: </h5><?php echo $row['totalPrice'] ?></li>
                <li class="list-group-item"><h5>Payment Method: </h5><?php echo $row['paymentMethod'] ?></li>
                <li class="list-group-item"><h5>Date of Order: </h5><?php echo $row['orderDate'] ?></li>
                <li class="list-group-item"><h5>Status: </h5><?php echo $row['status'] ?></li>
                <?php if($row['status'] == 'delivered'){ ?>
                    <li class="list-group-item"><h5>Date of Delivery:</h5><?php echo $row['dateDelivered'] ?></li>
                <?php }?>
             </ul>
             
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-3">
    <div class="col-xl-9">
        <div class="bg-color border card border-color-form shadow">
            <div class="card-body">
            <h5 class="card-title text-center" style="font-size:45px;font-weight:bold;color:black;">Products</h5>
            <ul class="list-group list-group-flush">
                <?php foreach($products as $product){ ?>
                    <li class="list-group-item"><h5><?php echo $product['name'] ?></h5>Quantity: <?php echo $product['qty'] ?></li>
                <?php } ?>
             </ul>
             
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/profile/orders.php">Return To Orders List</a>
        </div>
    </div>
</div>
</div>


<?php require('../partials/footer.inc.php')?>