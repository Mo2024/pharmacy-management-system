<?php $title = "Edit Product"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageProducts/editProduct.inc.php')?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">editProduct Product</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Name</label>
                <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="price">Price</label>
                <input placeholder="Price" class="form-control" type="number" name="price" id="price" value="<?php echo $row['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="type">Type</label>
                <input placeholder="Type" class="form-control" type="text" name="type" id="type" value="<?php echo $row['type']; ?>" required>
            </div>

            <div class="mb-3" id="suppliersContainer" <?php echo isset($_GET['suppliers']) ? 'style="display: block;"' : ''; ?>>
                <label class="form-label text-dark" for="suppliers">Suppliers</label>
                <select class="form-select" name="suppliers" id="suppliers" required>
                    <option value="">Select Supplier</option>
                    <?php
                    if (!empty($suppliers)) {
                        foreach ($suppliers as $supplier) {
                            $selected = $row['sid'] == $supplier['sid'] ? 'selected' : '';
                            echo '<option value="' . $supplier['sid'] . '" ' . $selected . '>' . $supplier['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <?php
                    $filename = $row['pid'];
                    $filepath = '../../public/products/' . $filename;

                    if (file_exists($filepath.".jpg")||file_exists($filepath.".png"||file_exists($filepath.".jpeg"))) {
                        echo '<label class="form-label">Replace Current Image</label>';
                    } else {
                        echo '<label class="form-label">Upload Image</label>';
                    }
                ?>
                <label for="image" class="form-label"></label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <div class="mb-3">
                <button name="submit" value="<?php echo $row['pid'] ?>" class="btn btn-success">Save Info</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>