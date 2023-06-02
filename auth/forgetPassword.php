<?php $title = "Forget Password"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/auth/forgetPassword.inc.php')?>

<div class="mb-3 container d-flex justify-content-center align-items-center mt-5">
<div class="row">
    <div class="col-xl-12">
        <div class="bg-color border card border-color-form shadow p-3">
            <div class="card-body ">
                <h5 class="card-title text-center" style="font-size:35px;font-weight:bold;color:black;">Forget Password</h5>
                <form class="validated-form" method="POST" novalidate>
                    <?php if(!isset($_SESSION['display'])){ ?>
                        <div class="mb-3">
                            <label class="form-label" for="uid">Email</label>
                            <input placeholder="Enter Your Email" class="form-control" type="text" name="uid" id="uid" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Send Verification Code</button>
                    <?php }else if(isset($_SESSION['display']) && $_SESSION['display'] == 'pCode'){ ?>
                        <div class="mb-3">
                            <label class="form-label" for="pcode">Verification Code</label>
                            <input class="form-control" placeholder="Verification Code" type="text" name="pcode" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Verify Code</button>
                    <?php } else if(isset($_SESSION['display']) && $_SESSION['display'] == 'pwd'){ ?>
                        <div class="mb-3">
                            <label class="form-label" for="password">New Password</label>
                            <input class="form-control" placeholder="Enter Your New Password" type="password" name="password1"  id="pass1"  required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Confirm New Password</label>
                            <input class="form-control" placeholder="Enter Your New Password" type="password" name="password2"  id="pass2"  required>
                            <input class="form-check-input" type="checkbox" onclick="dPassword()">
                            <label class="form-check-label" for="flexCheckChecked">
                                Show Password
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Change Password</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function dPassword() {
  var x = document.getElementById("pass1");
  var y = document.getElementById("pass2");
  if (x.type === "password" && y.type === "password") {
    x.type = "text";
    y.type = "text";
  } else {
    x.type = "password";
    y.type = "password";
  }
}
</script>

<?php require('../partials/footer.inc.php')?>