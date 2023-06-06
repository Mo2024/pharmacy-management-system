<?php $title = "Add User"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/addUser.inc.php')?>
<section class="container row mx-auto">
    <div class="col-lg-6">

        <h1 class="text-dark">Create New User</h1>
        <form action="/admin/createUser" method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="username">username</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="fullname">Full Name</label>
                <input class="form-control" type="text" name="fullname" id="fullname" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="number">Number</label>
                <input class="form-control" type="text" name="number" id="number" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="building">Building</label>
                <input class="form-control" type="text" name="building" id="building" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="road">Road</label>
                <input class="form-control" type="text" name="road" id="road" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="block">Block</label>
                <input class="form-control" type="text" name="block" id="block" required>
            </div>

           
            <div class="mb-3">
                <button class="btn btn-success">Add Item</button>
            </div>
        </form>
    </div>
    <div class="col-lg-6">
        <h1 class="text-dark">New menu section</h1>
        <form action="/admin/menu" method="POST" class="validated-form" novalidate>
            <div class="mb-3">
                <label class="form-label text-dark" for="name">Title</label>
                <input class="form-control" type="text" name="menu[name]" id="name" required>
            </div>

            <div class="mb-3">
                <button class="btn btn-success">Add Section</button>
            </div>
        </form>
    </div>
</section>
<?php require('../partials/footer.inc.php')?>