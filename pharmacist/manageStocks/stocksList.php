<?php $title = "Stocks List"; require('../../partials/boilerplate.inc.php')?>
<?php require('../../controllers/pharmacist/manageStocks/stocksList.inc.php')?>
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
          <th  scope="col" colspan="4">Stocks List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Delete Stock</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr id="<?php echo $row['pid'].'#'.$row['bid'] ?>">
            <td><?php echo $row['name']; ?></td>
            <td class="w-25">                    
              <div class="input-group">
                <span class="input-group-btn">
                <button type="button" class="btn btn-outline-secondary" onclick="decreaseValue('<?php echo $row['pid'].'%'.$row['bid'] ?>')">-</button>
                </span>
                <input id="<?php echo $row['pid'].'%'.$row['bid'] ?>" type="number" class="form-control text-center"  value="<?php echo $row['qty'];?>" min="0">
                <span class="input-group-btn">
                <button type="button" class="btn btn-outline-secondary" onclick="increaseValue('<?php echo $row['pid'].'%'.$row['bid'] ?>')">+</button>
                </span>
              </div>
            </td>

            <td><button value="<?php echo $row['pid'].'#'.$row['bid'] ?>" onclick="handleDelete(this.value)" type="button" class="btn btn-sm btn-danger">Delete Stock</button></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-primary ms-auto" href="/pharmacy-management-system/pharmacist/manageStocks/addStock.php">Add Stock</a>
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>

<script src="/pharmacy-management-system/public/js/stocksList.js"></script>

<?php require('../../partials/footer.inc.php')?>