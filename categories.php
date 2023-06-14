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

                            if (file_exists($filepath . ".jpg")) { ?>
                                <a href="/pharmacy-management-system/products/product.php?productId=<?php echo $product['pid'] ?>" class="text-reset text-decoration-none">
                                    <img src="<?php echo $filepath ?>.jpg" class="w-100 h-50" />
                                </a>
                            <?php } else if (file_exists($filepath . ".png")) { ?>
                                <a href="/pharmacy-management-system/products/product.php?productId=<?php echo $product['pid'] ?>" class="text-reset text-decoration-none">
                                    <img src="<?php echo $filepath ?>.png" class="w-100 h-50" />
                                </a>
                            <?php } else if (file_exists($filepath . ".jpeg")) { ?>
                                <a href="/pharmacy-management-system/products/product.php?productId=<?php echo $product['pid'] ?>" class="text-reset text-decoration-none">
                                    <img src="<?php echo $filepath ?>'.jpeg" class="w-100 h-50" />
                                </a>
                            <?php } else{ ?>
                                <a href="/pharmacy-management-system/products/product.php?productId=<?php echo $product['pid'] ?>" class="text-reset text-decoration-none">
                                    <img src="public/imgs/no.png" class="w-100 h-50" />
                                </a>
                            <?php }?>
                    </div>
                    <div class="card-body">
                        <a href="/pharmacy-management-system/products/product.php?productId=<?php echo $product['pid'] ?>" class="text-reset text-decoration-none">
                            <h5 class="card-title mb-3"><?php echo $product['name'] ?></h5>
                        </a>
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
                        <button value="<?php echo $product['pid'] ?>" onclick="handleCart(this.value, <?php echo $product['price'] ?>)" class="text-decoration-none btn btn-sm btn-primary ms-auto">Add to cart</button>
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