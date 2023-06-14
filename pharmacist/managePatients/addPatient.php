<?php $title = "Add Patient"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/managePatients/addPatient.inc.php')?>
<?php 
$username = isset($_GET['username']) ? $_GET['username'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$fName = isset($_GET['fName']) ? $_GET['fName'] : '';
$number = isset($_GET['number']) ? $_GET['number'] : '';
$block = isset($_GET['block']) ? $_GET['block'] : '';
$road = isset($_GET['road']) ? $_GET['road'] : '';
$building = isset($_GET['number']) ? $_GET['building'] : '';
?>
<section class="container row mx-auto">
    <div class="col-lg-12">
        <h1 class="text-dark">Create New Patient</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="username">Username</label>
                <input placeholder="Username" class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="email">Email</label>
                <input placeholder="Email" class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="fName">Full Name</label>
                <input placeholder="Full Name" class="form-control" type="text" name="fName" id="fName" value="<?php echo $fName; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="number">Number</label>
                <input placeholder="Number" class="form-control" type="text" name="number" id="number" value="<?php echo $number; ?>" required>
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

            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Patient</button>
            </div>
        </form>
    </div>
</section>
<?php require('../../partials/footer.inc.php')?>