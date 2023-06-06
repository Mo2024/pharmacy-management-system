<?php $title = "Add Branch"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/addBranch.inc.php')?>
<?php 
$name = isset($_GET['name']) ? $_GET['name'] : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';
$building = isset($_GET['building']) ? $_GET['building'] : '';
$road = isset($_GET['road']) ? $_GET['road'] : '';
$block = isset($_GET['block']) ? $_GET['block'] : '';
?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Create New Branch</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="area">Area</label>
                <input class="form-control" type="text" name="area" id="area" value="<?php echo $area; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="building">Building</label>
                <input class="form-control" type="text" name="building" id="building" value="<?php echo $building; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="road">Road</label>
                <input class="form-control" type="text" name="road" id="road" value="<?php echo $road; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="block">Block</label>
                <input class="form-control" type="text" name="block" id="block" value="<?php echo $block; ?>" required>
            </div>

            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Branch</button>
            </div>
        </form>
    </div>
</section>
<?php require('../partials/footer.inc.php')?>