<?php $title = "Add Pharmacist"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/addPharmacist.inc.php')?>
<section class="container row mx-auto">
    <div class="col-lg-6">

        <h1 class="text-dark">Create New Pharmacist</h1>
        <form action="/admin/createPharmacist" method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="username">username</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="fullname">Full Name</label>
                <input class="form-control" type="text" name="fullname" id="fullname" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="email">Full Name</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="number">Number</label>
                <input class="form-control" type="text" name="number" id="number" required>
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