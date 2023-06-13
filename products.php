<?php $title = "Category"; require('partials/boilerplate.inc.php')?>
<?php require('controllers/main/products.inc.php')?>

<?php 
$categoryCurrent = ''; 
foreach ($categoryRows as $category) { 
    if($category['cid'] !== $categoryCurrent){
        $categoryCurrent = $category['cid'];

        // Get products for current category
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
                        <a href="" class="text-reset text-decoration-none">
                            <h5 class="card-title mb-3"><?php echo $product['name'] ?></h5>
                        </a>
                        <h6 class="mb-3">$<?php echo $product['price'] ?></h6>
                        <button value="<?php echo $product['pid'] ?>" onclick="handleCart(this.value, <?php echo $product['price'] ?>)" class="text-decoration-none btn btn-sm btn-primary ms-auto">Add to cart</button>
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

<script src="/pharmacy-management-system/public/js/categoriesPage.js"></script>
<?php require('partials/footer.inc.php')?>