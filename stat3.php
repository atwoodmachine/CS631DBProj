<?php
    require_once('database.php');
    $start = filter_input(INPUT_POST, "startDate");
    $end = filter_input(INPUT_POST, "endDate");

    #Stats 3
    $saleStat3 = 'SELECT PName, SUM(Quantity) as sold
    FROM transaction LEFT JOIN appears_in on transaction.CartID = appears_in.CartID
    LEFT JOIN product ON appears_in.ProductID = product.ProductID
    WHERE TDATE BETWEEN :startDate AND :endDate
    GROUP BY PName
    ORDER BY SUM(Quantity) DESC
    LIMIT 5';

    $statement = $db->prepare($saleStat3);
    $statement->bindValue(':startDate', $start);
    $statement->bindValue(':endDate', $end);
    $statement->execute();
    $stat3 = $statement->fetchAll();
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
                        Units sold
                    </th>
                </tr>
            <?php foreach ($stat3 as $prod): ?>
                <tr>
                    <td><?php echo $prod['PName'];?></td>
                    <td><?php echo $prod['sold'];?></td> 
                </tr>
            <?php endforeach ?>
    </body>
</html>