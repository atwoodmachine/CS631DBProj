<?php
    require_once('database.php');
    $start = filter_input(INPUT_POST, "startDate");
    $end = filter_input(INPUT_POST, "endDate");

    #Stats 3
    $saleStat4 = 'SELECT PName, COUNT(DISTINCT CID) as users
    FROM transaction LEFT JOIN appears_in on transaction.CartID = appears_in.CartID
    LEFT JOIN product ON appears_in.ProductID = product.ProductID
    WHERE TDATE BETWEEN :startDate AND :endDate
    GROUP BY PName
    ORDER BY users DESC
    LIMIT 5';

    $statement = $db->prepare($saleStat4);
    $statement->bindValue(':startDate', $start);
    $statement->bindValue(':endDate', $end);
    $statement->execute();
    $stat4 = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <body>
    <table class="stat3Table">
                <tr>
                    <th>
                        Product
                    </th>
                    <th>
                        Number of Distinct User Purchases
                    </th>
                </tr>
            <?php foreach ($stat4 as $prod): ?>
                <tr>
                    <td><?php echo $prod['PName'];?></td>
                    <td><?php echo $prod['users'];?></td> 
                </tr>
            <?php endforeach ?>
    </body>
</html>