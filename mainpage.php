<?php
  $title = "Pharmacy Website";
  require('partials/boilerplate.inc.php');
?>

<!-- Main content -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-8 border rounded p-4">
      <h2 class="text-primary">Welcome to Our Vibrant Pharmacy</h2>
      <p>
        We are not just a pharmacy; we are your healthcare partners. Our vibrant pharmacy is dedicated to providing
        top-notch healthcare solutions to our community. Our mission is to ensure the well-being of our customers by
        offering a wide range of high-quality medications and healthcare products.
      </p>
      <p>
        At our pharmacy, we prioritize customer satisfaction and health. Our team of experienced pharmacists is
        committed to providing personalized care and expert advice. Whether you have questions about medications,
        need health-related information, or are looking for wellness products, we are here to help.
      </p>
      <p>
        Our pharmacy management system ensures seamless operations and efficient service. With multiple stores across
        the region, we strive to make healthcare accessible to all. Explore our website to discover our services,
        locate the nearest store, and stay updated on the latest health news and promotions.
      </p>
    </div>
    <div class="col-md-4">
      <!-- Pharmacy Management System Card -->
      <div class="card bg-info text-dark">
        <div class="card-body">
          <h5 class="card-title">Pharmacy Management System</h5>
          <p class="card-text">
            Our state-of-the-art pharmacy management system ensures accurate inventory management,
            quick prescription processing, and secure customer data handling.
          </p>
        </div>
      </div>

      <!-- Our Stores Card -->
      <div class="card mt-3 bg-success text-dark">
        <div class="card-body">
          <h5 class="card-title">Our Stores</h5>
          <p class="card-text">
            Visit any of our conveniently located stores to experience friendly service and a wide
            selection of healthcare products. Our stores are designed to create a welcoming environment
            for all our customers.
          </p>
        </div>
      </div>

      <!-- Additional Info Card -->
      <div class="card mt-3 bg-warning text-dark">
        <div class="card-body">
          <h5 class="card-title">Additional Information</h5>
          <p class="card-text">
            Explore our website to learn more about our services, health tips, and meet our dedicated
            team of pharmacists and healthcare professionals.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- New Row with Opening Hours Table -->
  <div class="row mt-5">
    <div class="col-md-12">
      <h3 class="mb-3">Opening Hours</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Day</th>
            <th>Opening Time</th>
            <th>Closing Time</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Monday</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
          </tr>
          <tr>
            <td>Tuesday</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
          </tr>
          <tr>
            <td>Wednesday</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
          </tr>
          <tr>
            <td>Thursday</td>
            <td>9:00 AM</td>
            <td>7:00 PM</td>
          </tr>
          <tr>
            <td>Friday</td>
            <td>9:00 AM</td>
            <td>8:00 PM</td>
          </tr>
          <tr>
            <td>Saturday</td>
            <td>10:00 AM</td>
            <td>6:00 PM</td>
          </tr>
          <tr>
            <td>Sunday</td>
            <td>Closed</td>
            <td>Closed</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require('partials/footer.inc.php') ?>
