<?php $title = "Add User"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/CreateUser.inc.php')?>
<section class="container row mx-auto">
    <div class="col-lg-6">

        <h1 class="text-dark">Create New User</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
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
                <label class="form-label text-dark" for="role">Role</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="pharmacist">Pharmacist</option>
                </select>
            </div>
            <div class="mb-3" id="branchesContainer" style="display: none;">
                <label class="form-label text-dark" for="branches">Branches</label>
                <select class="form-select" name="branches" id="branches" required>
                    <option value="">Select Branch</option>
                    <?php
                    if (!empty($branches)) {
                        foreach ($branches as $branch) {
                            echo '<option value="' . $branch['id'] . '">' . $branch['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add Item</button>
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
                <button name="submit" class="btn btn-success">Add Section</button>
            </div>
        </form>
    </div>
</section>

<script>
    const roleSelect = document.getElementById('role');
    const branchesContainer = document.getElementById('branchesContainer');

    roleSelect.addEventListener('change', function() {
        const selectedRole = this.value;

        if (selectedRole === 'pharmacist') {
            branchesContainer.style.display = 'block';
            // You can fetch and populate the branch options dynamically here
        } else {
            branchesContainer.style.display = 'none';
        }
    });
</script>
<?php require('../partials/footer.inc.php')?>