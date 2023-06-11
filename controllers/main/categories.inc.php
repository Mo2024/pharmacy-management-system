<?php 

    if(isset($_GET['category']) && $_GET['category'] !== ""){
        $cid  = $_GET['category'];
        $query = "SELECT * FROM products WHERE cid = ? AND isDeleted = 0";
        $statement = $db->prepare($query);
        $statement->execute([$cid]);
        $categoryRows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT name FROM category WHERE cid = ?";
        $statement = $db->prepare($query);
        $statement->execute([$cid]);
        $catName = $statement->fetch();
    }else{
        $_SESSION['error'] = "Choose a valid category";
        header("Location: /pharmacy-management-system/mainpage.php");
    }

?>