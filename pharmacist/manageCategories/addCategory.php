<?php $title = "Add Category"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageCategories/addCategory.inc.php')?>
<?php 
$name = isset($_GET['name']) ? $_GET['name'] : '';
?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Create New Category</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Name</label>
                <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Category</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>