<?php $title = "Products List"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageCategories/categoriesList.inc.php')?>
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
          <th  scope="col" colspan="2">Categories List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Name</th>
          <th>Delete Category</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr id="<?php echo $row['cid'] ?>">
            <td><?php echo $row['name']; ?></td>
            <td><button value="<?php echo $row['cid'] ?>" onclick="handleDelete(this.value)" type="button" class="btn btn-sm btn-danger">Delete Category</button></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-primary ms-auto" href="/pharmacy-management-system/pharmacist/manageCategories/addCategory.php">Add Category</a>
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>

<script src="/pharmacy-management-system/public/js/categoriesList.js"></script>

<?php require('../../partials/footer.inc.php')?>