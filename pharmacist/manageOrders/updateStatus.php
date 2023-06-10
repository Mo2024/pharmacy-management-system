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
                    <option value="pending" <?php echo $row['status'] == "pending" ? 'selected' :''?>>Pending</option>
                    <option value="processing" <?php echo $row['status'] == "processing" ? 'selected' :''?>>Processing</option>
                    <option value="shipped" <?php echo $row['status'] == "shipped" ? 'selected' :''?>>Shipped</option>
                    <option value="delivered" <?php echo $row['status'] == "delivered" ? 'selected' :''?>>Delivered</option>
                </select>
            </div>

            <div class="mb-3">
                <a class="text-decoration-none btn btn-warning" href="/pharmacy-management-system/pharmacist/manageOrders/ordersList.php">Return</a>
                <button name="submit" value="<?php echo $_GET['orderId'] ?>" class="btn btn-success">Save Info</button>
            </div>
        </form>
    </div>
</section>


<?php require('../../partials/footer.inc.php')?>