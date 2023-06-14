<?php 
    $query = 
    "SELECT category.cid, category.name as cname, products.*
    FROM category
    INNER JOIN products ON category.cid = products.cid
    WHERE products.isDeleted = 0";
    $statement = $db->prepare($query);
    $statement->execute();
    $categoryRows = $statement->fetchAll(PDO::FETCH_ASSOC);
