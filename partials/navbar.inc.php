<header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#F9D949;">
      <div class="container-fluid">
        <a class="navbar-brand" href="/pharmacy-management-system/mainpage.php">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link h4 " aria-current="page" href="/pharmacy-management-system/mainpage.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <?php foreach($categoryRows as $category) { ?>
                    <li><a class="dropdown-item" href="/pharmacy-management-system/categories.php?category=<?php echo $category['cid'] ?>"><?php echo $category['name'] ?></a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php if(isset($_SESSION['userId']) && isset($_SESSION['role']) && $_SESSION['role'] == "admin"){ ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/addUser.php">Add User</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/addBranch.php">Add Branch</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/generateReports.php">Generate Reports</a></li>
                </ul>
              </li>
              <?php } ?>
             <?php if(isset($_SESSION['userId']) && isset($_SESSION['role']) && $_SESSION['role'] == "pharmacist"){ ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pharmacist</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/managePatients/patientsList.php">Manage Patients</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/manageProducts/productsList.php">Manage Products</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/manageOrders/OrdersList.php">Manage Orders</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/manageSuppliers/suppliersList.php">Manage Suppliers</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/manageStocks/stocksList.php">Manage Stock</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/manageCategories/categoriesList.php">Manage Category</a></li>
                </ul>
              </li>
              <?php }?>

          </ul>
          <div class="navbar-nav ms-auto d-flex">
            <?php if(!isset($_SESSION['userId']) && !isset($_SESSION['username'])){ ?>
          <a href="/pharmacy-management-system/auth/signup.php" class="nav-link h4">Sign Up</a>
          <a href="/pharmacy-management-system/auth/signin.php" class="nav-link h4">Log In</a>
          <?php }else{ ?>
          <a href="/pharmacy-management-system/cart.php" class="nav-link h4">Cart</a>
          <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profile</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <li><a class="dropdown-item" href="/pharmacy-management-system/profile/profile.php">Profile</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/profile/orders.php">Orders</a></li>
                </ul>
              </li>
          <a href="/pharmacy-management-system/controllers/auth/logout.inc.php" class="nav-link h4">Sign out</a>
          <?php }?>

    </div>
        </div>
      </div>
    </nav>
    </header>
    