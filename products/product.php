<?php $title = "Product"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/products/products.inc.php')?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-12">
            <div class="text-center">
            <?php                 
            $filepath = __DIR__ . '/../public/products/' . $product['pid'];
            $filepathPrint = '/pharmacy-management-system/public/products/' . $product['pid'];

            if (file_exists($filepath . ".jpg")) { ?>
                <img src="<?php echo $filepathPrint ?>.jpg" class="w-100 h-50" />
            <?php } else if (file_exists($filepath . ".png")) { ?>
                <img src="<?php echo $filepathPrint ?>.png" class="w-100 h-50" />
            <?php } else if (file_exists($filepath . ".jpeg")) { ?>
                <img src="<?php echo $filepathPrint ?>.jpeg" class="w-100 h-50" />
            <?php } else { ?>
                <img src="/pharmacy-management-system/public/imgs/no.png" class="w-100 h-50" />
            <?php } ?>

            </div>
            <div class="text-center mt-3">
                <h5><?php echo $product['name'] ?></h5>
                <?php 
                $sql = "SELECT SUM(qty) AS total_quantity FROM products_in_branch WHERE pid = :pid";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':pid', $product['pid']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $totalQuantity = $result['total_quantity'];
                ?>
                <h6>$<?php echo $product['price'] ?></h6>
                <h6>Type: <?php echo $product['type'] ?></h6>
                <?php if ($totalQuantity > 0) {  ?>
                    <button value="<?php echo $product['pid'] ?>" onclick="handleCart(this.value, <?php echo $product['price'] ?>)" class="btn btn-primary">Add to cart</button>
                <?php } else { ?>
                    <button disabled class="btn btn-outline-secondary">Out of Stock</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="/pharmacy-management-system/public/js/addToCart.js"></script>


<?php require('../partials/footer.inc.php')?>