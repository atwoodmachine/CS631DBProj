<?php
    require_once('database.php');
    $start = filter_input(INPUT_POST, "startDate");
    $end = filter_input(INPUT_POST, "endDate");

    #Stats 5
    $saleStat5 = 'SELECT CardNumber, TotalAmount 
    FROM `transaction`
    WHERE TDATE BETWEEN :startDate and :endDate AND 
    TotalAmount = (SELECT max(TotalAmount) 
    FROM transaction t where t.CardNumber = transaction.CardNumber)
    order by TotalAmount DESC';

    $statement = $db->prepare($saleStat5);
    $statement->bindValue(':startDate', $start);
    $statement->bindValue(':endDate', $end);
    $statement->execute();
    $stat5 = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <body>
    <table class="stat5Table">
                <tr>
                    <th>
                        Card Number
                    </th>
                    <th>
                        Maximum Basket Amount
                    </th>
                </tr>
            <?php foreach ($stat5 as $card): ?>
                <tr>
                    <td><?php echo $card['CardNumber'];?></td>
                    <td><?php echo $card['TotalAmount'];?></td> 
                </tr>
            <?php endforeach ?>
    </body>
</html>