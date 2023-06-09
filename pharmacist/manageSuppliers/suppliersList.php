<?php $title = "Suppliers List"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageSuppliers/SuppliersList.inc.php')?>
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
          <th  scope="col" colspan="4">Suppliers List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Name</th>
          <th>Date Added</th>
          <th>Edit Supplier Info</th>
          <th>Delete Supplier</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr id="<?php echo $row['sid'] ?>">
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['dateAdded'];?></td>
            <td><a type="button" href="/pharmacy-management-system/pharmacist/manageSuppliers/editSupplier.php?supplierId=<?php echo $row['sid'] ?>" class="btn btn-sm btn-outline-secondary">Edit Supplier</a></td>
            <td><button value="<?php echo $row['sid'] ?>" onclick="handleDelete(this.value)" type="button" class="btn btn-sm btn-danger">Delete Supplier</button></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-primary ms-auto" href="/pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php">Add Supplier</a>
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>

<script src="/pharmacy-management-system/public/js/manageSuppliers.js"></script>

<?php require('../../partials/footer.inc.php')?>