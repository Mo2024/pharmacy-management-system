</main>

<footer class="text-center text-lg-start text-white mt-auto" style="background-color: #3C486b">
  <div class="container p-4 pb-0">
    <section>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase"><?php echo $_ENV['brandName'] ?> Pharmacy</h5>
        </div>

        <div class="d-flex justify-content-center">
          <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase" style="font-size:15px;font-weight:bold;">Terms And Conditions</h5>
            <ul class="list-unstyled mb-0">
              <li>
                <a href="/pharmacy-management-system/terms.php" class="text-white">Terms and Conditions</a>
              </li>
            </ul>
            <br>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    <p>&copy; 2023 <?php echo $_ENV['brandName'] ?> Pharmacy. All rights reserved.</p>
    <a class="text-white" href="/pharmacy-management-system/mainpage.php"><?php echo $_ENV['brandName'] ?> Pharmacy</a>
  </div>
</footer>

<?php
ob_end_flush();
?>