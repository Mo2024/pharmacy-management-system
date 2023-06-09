<?php $title = "Add Branch"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageSuppliers/addSupplier.inc.php')?>
<?php 
$name = isset($_GET['name']) ? $_GET['name'] : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';
$block = isset($_GET['block']) ? $_GET['block'] : '';
$road = isset($_GET['road']) ? $_GET['road'] : '';
$building = isset($_GET['building']) ? $_GET['building'] : '';
?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Create New Supplier</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Name</label>
                <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="area">Area</label>
                <input placeholder="Area" class="form-control" type="text" name="area" id="area" value="<?php echo $area; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="building">Building</label>
                <input placeholder="Building" class="form-control" type="text" name="building" id="building" value="<?php echo $building; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="road">Road</label>
                <input placeholder="Road" class="form-control" type="text" name="road" id="road" value="<?php echo $road; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="block">Block</label>
                <input placeholder="Block" class="form-control" type="text" name="block" id="block" value="<?php echo $block; ?>" required>
            </div>

            <div class="mb-3" id="branchesContainer" <?php echo isset($_GET['branches']) ? 'style="display: block;"' : ''; ?>>
                <label class="form-label text-dark" for="branches">Branches</label>
                <select class="form-select" name="branches" id="branches" required>
                    <option value="">Select Branch</option>
                    <?php
                    if (!empty($branches)) {
                        foreach ($branches as $branch) {
                            $selected = isset($_GET['branches']) && $_GET['branches'] == $branch['bid'] ? 'selected' : '';
                            echo '<option value="' . $branch['bid'] . '" ' . $selected . '>' . $branch['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Supplier</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>