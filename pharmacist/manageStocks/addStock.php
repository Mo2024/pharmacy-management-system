<?php $title = "Add Stock"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageStocks/addStock.inc.php')?>
<?php 
$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
$qty = isset($_GET['qty']) ? $_GET['qty'] : '';

?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Add New Stock</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3" id="productsContainer">
                <label class="form-label text-dark" for="pid">Products</label>
                <select class="form-select" name="pid" id="pid" required>
                    <option value="">Select Product</option>
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            $selected = isset($_GET['pid']) && $_GET['pid'] == $product['pid'] ? 'selected' : '';
                            echo '<option value="' . $product['pid'] . '" ' . $selected . '>' . $product['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-dark" for="qty">Quantity</label>
                <input placeholder="Quantity" class="form-control" type="number" name="qty" id="qty" value="<?php echo $qty; ?>" required>
            </div>



            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Supplier</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>