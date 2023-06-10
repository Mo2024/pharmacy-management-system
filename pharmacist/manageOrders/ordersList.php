<?php $title = "Manage Orders"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageOrders/ordersList.inc.php')?>
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
          <th>Date</th>
          <th>Details</th>
          <th>Update Status</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr>
            <td><?php echo $row['oid']; ?></td>
            <td><?php echo $row['orderDate'];?></td>
            <td><a href="/pharmacy-management-system/pharmacist/manageOrders/orderDetails.php?orderId=<?php echo $row['oid'] ?>" type="button" class="btn btn-sm btn-primary">Details</a></td>
            <td><a type="button" href="/pharmacy-management-system/pharmacist/manageOrders/updateStatus.php?orderId=<?php echo $row['oid'] ?>" class="btn btn-sm btn-outline-secondary <?php echo $row['status'] == 'delivered' ? 'disabled' : '' ?> ">Update Order</a></td>
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
<?php require('../../partials/footer.inc.php')?>