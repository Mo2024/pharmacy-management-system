<?php $title = "Add Branch"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/pharmacist/editPatient.inc.php')?>

<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Edit Patient</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label text-dark" for="number">Number</label>
                <input placeholder="Number" class="form-control" type="text" name="number" id="number" value="<?php echo $row['number']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="building">Building</label>
                <input placeholder="Building" class="form-control" type="text" name="building" id="building" value="<?php echo $row['building']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="road">Road</label>
                <input placeholder="Road" class="form-control" type="text" name="road" id="road" value="<?php echo $row['road']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="block">Block</label>
                <input placeholder="Block" class="form-control" type="text" name="block" id="block" value="<?php echo $row['block']; ?>" required>
            </div>

            <div class="mb-3">
                <a class="text-decoration-none btn btn-warning" href="/pharmacy-management-system/pharmacist/managePatients.php">Return</a>
                <button name="submit" value="<?php echo $_GET['patientId'] ?>" class="btn btn-success">Save Info</button>
            </div>
        </form>
    </div>
</section>


<?php require('../partials/footer.inc.php')?>