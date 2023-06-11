<?php $title = "Add Branch"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageProducts/addProduct.inc.php')?>
<?php 
$name = isset($_GET['name']) ? $_GET['name'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Create New Product</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Name</label>
                <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="price">Price</label>
                <input placeholder="Price" class="form-control" type="number" name="price" id="price" value="<?php echo $price; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="type">Type</label>
                <input placeholder="Type" class="form-control" type="text" name="type" id="type" value="<?php echo $type; ?>" required>
            </div>

            <div class="mb-3" id="categoryContainer">
                <label class="form-label text-dark" for="cid">Suppliers</label>
                <select class="form-select" name="cid" id="cid" required>
                    <option value="">Select Category</option>
                    <?php
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $selected = isset($_GET['cid']) && $_GET['cid'] == $category['cid'] ? 'selected' : '';
                            echo '<option value="' . $category['cid'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3" id="suppliersContainer">
                <label class="form-label text-dark" for="suppliers">Suppliers</label>
                <select class="form-select" name="suppliers" id="suppliers" required>
                    <option value="">Select Supplier</option>
                    <?php
                    if (!empty($suppliers)) {
                        foreach ($suppliers as $supplier) {
                            $selected = isset($_GET['suppliers']) && $_GET['suppliers'] == $supplier['sid'] ? 'selected' : '';
                            echo '<option value="' . $supplier['sid'] . '" ' . $selected . '>' . $supplier['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <label for="image" class="form-label"></label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Product</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>