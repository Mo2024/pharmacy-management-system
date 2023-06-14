<?php $title = "Profile"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/profile/profile.inc.php')?>
<div class="container w-50 my-3">
      <ul class="nav nav-underline">
        <li class="nav-item text-decoration-underline text-primary">
          <a class="nav-link" aria-current="page" href="profile.php">My Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="updatePassword.php">Change Password</a>
        </li>
      </ul>

      <div class="container bg-color border card border-color-form shadow p-3 justify-content-center">
        <form class="validated-form" method="POST" novalidate>
            <div class="row">
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="fullname">Full Name</label>
                    <input class="form-control" placeholder="Full Name" type="text" name="fullname" id="fullname" value="<?php if($redirect) echo $fullname?>" >
                </div>
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="InputFullName">Username</label>
                    <input class="form-control" placeholder="Username" type="text" name="username" id="username" value="<?php if($redirect) echo $username?>" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" placeholder="Email" type="email" name="email" id="email" value="<?php if($redirect) echo $email?>" required>
                </div>
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="number">Number</label>
                    <input class="form-control" placeholder="Number" type="number" name="number" id="number" value="<?php if($redirect) echo $number?>" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="building">Building</label>
                    <input class="form-control" placeholder="Building" type="building" name="building" id="building" value="<?php if($redirect) echo $building?>" required>
                </div>
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="road">Road</label>
                    <input class="form-control" placeholder="Road" type="road" name="road" id="road" value="<?php if($redirect) echo $road?>" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-6">
                    <label class="form-label" for="block">Block</label>
                    <input class="form-control" placeholder="Block" type="block" name="block" id="block" value="<?php if($redirect) echo $block?>" required>
                </div>
            </div>
            <a href="/pharmacy-management-system/mainpage.php" class="btn btn-secondary mb-2 ms-auto">Cancel</a>
            <button name="submit" type="submit" class="btn btn-primary mb-2 ms-auto">Save Changes</button>
            
        </form>
      </div>
</div>
<?php require('../partials/footer.inc.php')?>