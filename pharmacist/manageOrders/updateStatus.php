<?php $title = "Update Status"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageOrders/updateStatus.inc.php')?>

<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Update Status</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">

        <div class="mb-3" id="StatusContainer">
                <label class="form-label text-dark" for="status">Order Status</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="">Select Order</option>
                    <?php if($row['status'] == "pending") { ?>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    <?php } else if($row['status'] == "processing") { ?>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    <?php } else if($row['status'] == "shipped") { ?>
                        <option value="delivered">Delivered</option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <a class="text-decoration-none btn btn-warning" href="/pharmacy-management-system/pharmacist/manageOrders/ordersList.php">Return</a>
                <button name="submit" value="<?php echo $row['oid'] ?>" class="btn btn-success">Save Info</button>
            </div>
        </form>
    </div>
</section>


<?php require('../../partials/footer.inc.php')?>