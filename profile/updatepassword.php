<?php $title = "Update Password"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/profile/updatePassword.inc.php')?>
<div class="container w-50 my-3">
      <ul class="nav nav-underline">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="profile.php">My Profile</a>
        </li>
        <li class="nav-item text-decoration-underline text-primary">
          <a class="nav-link" href="updatePassword.php">Change Password</a>
        </li>
      </ul>

      <div class="container bg-color border card border-color-form shadow p-3 justify-content-center">
        <form class="validated-form" method="POST" novalidate>
            <div class="row">
                <div class="mb-1 col-sm-12">
                    <label class="form-label" for="oldpwd">Old Password</label>
                    <input class="form-control" placeholder="Old Password" type="password" name="oldpwd" id="oldpwd"  >
                    <a href="/pharmacy-management-system/auth/forgetPassword.php">Forget Password?</a>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-12">
                    <label class="form-label" for="newpwd1">New Password</label>
                    <input class="form-control" placeholder="New Password" type="password" name="newpwd1" id="newpwd1"  >
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-12">
                    <label class="form-label" for="newpwd2">Confirm New Password</label>
                    <input class="form-control" placeholder="Confirm New Password" type="password" name="newpwd2" id="newpwd2"  >
                    <input class="form-check-input"type="checkbox" onclick="dPassword()">
                    <label class="form-check-label" for="flexCheckChecked">
                        Show Password
                    </label>
                </div>
            </div>
            <a href="/pharmacy-management-system/mainpage.php" class="btn btn-secondary mb-2">Cancel</a>
            <button name="submit" type="submit" class="btn btn-primary mb-2">Save Changes</button>
        </form>
      </div>
</div>

<script>
function dPassword() {
  var x = document.getElementById("oldpwd");
  var y = document.getElementById("newpwd1");
  var z = document.getElementById("newpwd2");
  if (x.type === "password" && y.type === "password" && z.type === "password") {
    x.type = "text";
    y.type = "text";
    z.type = "text";
  } else {
    x.type = "password";
    y.type = "password";
    z.type = "password";
  }
}
</script>
<?php require('../partials/footer.inc.php')?>