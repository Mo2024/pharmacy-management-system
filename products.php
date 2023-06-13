<?php $title = "Category"; require('partials/boilerplate.inc.php')?>
<?php require('controllers/main/products.inc.php')?>
<style>
  #suggestionList {
    border: 1px solid #ccc;
    border-radius: 3px;
    /* padding: 10px; */
    display: none;
    
  }

  .suggestion-item {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
    background-color: #f2f2f2;
    transition: background-color 0.3s ease;
  }

  .suggestion-item:hover,
  .suggestion-item.hovered {
    background-color: #dcdcdc;
  }
</style>

<div class="container w-50 mb-4">
  <div class="d-flex mt-3">
    <input id="searchQuery" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button id="searchButton" class="btn btn-outline-success" type="button">Search</button>
  </div>
  <div id="suggestionList"></div>
  <p id="noResultsMessage" style="display: none;">No quizzes found</p>
</div>

<?php 
$categoryCurrent = ''; 
foreach ($categoryRows as $category) { 
    if($category['cid'] !== $categoryCurrent){
        $categoryCurrent = $category['cid'];

        $query = "SELECT * FROM products WHERE cid = ? AND isDeleted = 0";
        $statement = $db->prepare($query);
        $statement->execute([$category['cid']]);
        $productRows = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
  <div class="text-center container">
    <h4 class="mb-5"><strong><?php echo $category['name'] ?></strong></h4>

    <div class="row">
        <?php foreach ($productRows as $product) { ?>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card">
                    <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                        <?php                 
                            $filepath = 'public/products/' . $product['pid'];

                            if (file_exists($filepath . ".jpg")) {
                                echo '<img src="'.$filepath.'.jpg" class="w-100 h-50" />';
                            } else if (file_exists($filepath . ".png")) {
                                echo '<img src="'.$filepath.'.png" class="w-100 h-50" />';
                            } else if (file_exists($filepath . ".jpeg")) {
                                echo '<img src="'.$filepath.'.jpeg" class="w-100 h-50" />';
                            } else {
                                echo '<img src="public/imgs/no.png" class="w-100 h-50" />';
                            }
                        ?>
                    </div>
                    <div class="card-body">
                        <p href="" class="text-reset text-decoration-none">
                            <h5 class="card-title mb-3"><?php echo $product['name'] ?></h5>
                        </p>
                        <?php 

                        $sql = "SELECT SUM(qty) AS total_quantity FROM products_in_branch WHERE pid = :pid";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':pid', $product['pid']);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        $totalQuantity = $result['total_quantity'];
                        ?>
                        <h6 class="mb-3">$<?php echo $product['price'] ?></h6>
                        <?php if($totalQuantity > 0) {  ?>
                        <button value="<?php echo $product['pid'] ?>" onclick="handleCart(this.value, <?php echo $product['price'] ?>, <?php echo $totalQuantity ?>)" class="text-decoration-none btn btn-sm btn-primary ms-auto">Add to cart</button>
                        <?php } else { ?>
                            <button disabled class="text-decoration-none btn btn-sm btn-outline-secondary ms-auto">Out of Stock</button>
                            
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<?php 
    }
}
?>

<script src="/pharmacy-management-system/public/js/searchQuery.js"></script>
<script src="/pharmacy-management-system/public/js/addToCart.js"></script>

<?php require('partials/footer.inc.php')?>