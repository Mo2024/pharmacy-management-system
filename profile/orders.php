<?php $title = "My Orders"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/profile/orders.inc.php')?>
<style>
thead
{
    background-color: #3C486B;
    color: white;
}
</style>
<div class="mt-4 container">
  <div class="table-responsive">
    <table class="table table-bordered border border-dark text-center">

      <thead>
        <tr >
          <th  scope="col" colspan="4">Orders List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Order No</th>
          <th>Status</th>
          <th>Details</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr>
            <td class="col-4"><?php echo $row['oid']; ?></td>
            <td><?php echo $row['status'];?></td>
            <td><a href="/pharmacy-management-system/profile/orderDetails.php?orderId=<?php echo $row['oid'] ?>" type="button" class="btn btn-sm btn-primary">Details</a></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>
<?php require('../partials/footer.inc.php')?>