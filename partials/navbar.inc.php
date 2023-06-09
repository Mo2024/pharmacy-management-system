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
            <?php
              if(isset($_SESSION['userId']) && isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
                echo'
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/addUser.php">Add User</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/addBranch.php">Add Branch</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/generateReports.php">Generate Reports</a></li>
                </ul>
              </li>
                ';
              }
              if(isset($_SESSION['userId']) && isset($_SESSION['role']) && $_SESSION['role'] == "pharmacist"){
                echo'
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Pharmacist
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                  <li><a class="dropdown-item" href="/pharmacy-management-system/pharmacist/managePatients/managePatients.php">Manage Patients</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/addBranch.php">Add Branch</a></li>
                  <li><a class="dropdown-item" href="/pharmacy-management-system/admin/generateReports.php">Generate Reports</a></li>
                </ul>
              </li>
                ';
              }
            ?>

          </ul>
          <div class="navbar-nav ms-auto d-flex">
    <?php
      if(!isset($_SESSION['userId']) && !isset($_SESSION['username'])){
        echo'
        <a href="/pharmacy-management-system/auth/signup.php" class="nav-link h4">Sign Up</a>
        <a href="/pharmacy-management-system/auth/signin.php" class="nav-link h4">Log In</a>
        ';
      }else{
        echo '
        <a href="/pharmacy-management-system/profile/profile.php" class="nav-link h4">Profile</a>
        <a href="/pharmacy-management-system/controllers/auth/logout.inc.php" class="nav-link h4">Sign out</a>
        ';
      }
    ?>
    </div>
        </div>
      </div>
    </nav>
    </header>
    