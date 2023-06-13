<?php $title = "Category"; require('partials/boilerplate.inc.php')?>
<?php require('controllers/main/categories.inc.php')?>

<section>
  <div class="text-center container">
    <h4 class="mb-5"><strong><?php echo $catName['name'] ?></strong></h4>

    <div class="row">
        <?php foreach ($categoryRows as $product) { ?>
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
                            } else{
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

<script src="/pharmacy-management-system/public/js/addToCart.js"></script>
<?php require('partials/footer.inc.php')?>