<?php $title = "Add User"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/CreateUser.inc.php')?>
<section class="container row mx-auto">
    <div class="col-lg-12">

        <h1 class="text-dark">Create New User</h1>
        <form method="POST" class="validated-form" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-dark" for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username" required value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="fullname">Full Name</label>
                <input class="form-control" type="text" name="fullname" id="fullname" required value="<?php echo isset($_GET['fullname']) ? htmlspecialchars($_GET['fullname']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" required value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="number">Number</label>
                <input class="form-control" type="text" name="number" id="number" required value="<?php echo isset($_GET['number']) ? htmlspecialchars($_GET['number']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="building">Building</label>
                <input class="form-control" type="text" name="building" id="building" required value="<?php echo isset($_GET['building']) ? htmlspecialchars($_GET['building']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="road">Road</label>
                <input class="form-control" type="text" name="road" id="road" required value="<?php echo isset($_GET['road']) ? htmlspecialchars($_GET['road']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-dark" for="block">Block</label>
                <input class="form-control" type="text" name="block" id="block" required value="<?php echo isset($_GET['block']) ? htmlspecialchars($_GET['block']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label text-dark" for="role">Role</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="patient" <?php echo isset($_GET['role']) && $_GET['role'] == 'patient' ? 'selected' : ''; ?>>Patient</option>
                    <option value="admin" <?php echo isset($_GET['role']) && $_GET['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="pharmacist" <?php echo isset($_GET['role']) && $_GET['role'] == 'pharmacist' ? 'selected' : ''; ?>>Pharmacist</option>
                </select>
            </div>
            <div class="mb-3" id="branchesContainer" <?php echo isset($_GET['branches']) ? 'style="display: block;"' : ''; ?>>
                <label class="form-label text-dark" for="branches">Branches</label>
                <select class="form-select" name="branches" id="branches" required>
                    <option value="">Select Branch</option>
                    <?php
                    if (!empty($branches)) {
                        foreach ($branches as $branch) {
                            $selected = isset($_GET['branches']) && $_GET['branches'] == $branch['bid'] ? 'selected' : '';
                            echo '<option value="' . $branch['bid'] . '" ' . $selected . '>' . $branch['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <button name="submit" class="btn btn-success">Add User</button>
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