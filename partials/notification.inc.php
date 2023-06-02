<?php if(isset($_SESSION['success'])){?>
    <div class="container mt-5 ">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; ?>
        </div>
    </div>
    <?php unset($_SESSION['success']) ?>
<?php } else if(isset($_SESSION['error'])){?>
    <div id="notificationPartial" class="container mt-5">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
        </div>
    </div>
    <?php unset($_SESSION['error']) ?>
<?php } ?>