<?php
    require_once('database.php');
    $start = filter_input(INPUT_POST, "startDate");
    $end = filter_input(INPUT_POST, "endDate");

    #Stats 6
    $saleStat6 = 'SELECT PType, AVG(PriceSold) as avg
    FROM appears_in 
    LEFT JOIN product ON appears_in.ProductID = product.ProductID 
    LEFT JOIN transaction on appears_in.CartID = transaction.CartID 
    Where TDATE between :startDate AND :endDate
    GROUP BY PType';

    $statement = $db->prepare($saleStat6);
    $statement->bindValue(':startDate', $start);
    $statement->bindValue(':endDate', $end);
    $statement->execute();
    $stat6 = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<div class = "nav">
        <a href="registration.php">Register</a>
        <a href="login.php">My account</a>
        <a href="view_cart.php">My basket</a>
        <a href="browse.php">Browse</a>
        <a href="analytics.php">Analytics</a>
    </div>
    <body>
    <table class="stat6Table">
                <tr>
                    <th>
                        Product Type
                    </th>
                    <th>
                        Average price sold
                    </th>
                </tr>
            <?php foreach ($stat6 as $prod): ?>
                <tr>
                    <td><?php echo $prod['PType'];?></td>
                    <td><?php echo $prod['avg'];?></td> 
                </tr>
            <?php endforeach ?>
    </body>
</html>