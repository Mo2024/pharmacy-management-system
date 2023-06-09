<?php $title = "Products List"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageProducts/ProductsList.inc.php')?>
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
          <th  scope="col" colspan="4">Products List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Name</th>
          <th>Price</th>
          <th>Edit Product Info</th>
          <th>Delete Product</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr id="<?php echo $row['pid'] ?>">
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price'];?></td>
            <td><a type="button" href="/pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=<?php echo $row['pid'] ?>" class="btn btn-sm btn-outline-secondary">Edit Product</a></td>
            <td><button value="<?php echo $row['pid'] ?>" onclick="handleDelete(this.value)" type="button" class="btn btn-sm btn-danger">Delete Product</button></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-primary ms-auto" href="/pharmacy-management-system/pharmacist/manageProducts/addProduct.php">Add Product</a>
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>

<script src="/pharmacy-management-system/public/js/productsList.js"></script>

<?php require('../../partials/footer.inc.php')?>