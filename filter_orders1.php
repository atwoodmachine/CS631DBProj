<?php
    require_once('database.php');
    $cid = filter_input(INPUT_POST, "custID");
    $start = filter_input(INPUT_POST, "startDate");
    $end = filter_input(INPUT_POST, "endDate");

    $t = 'SELECT * 
    FROM transaction
    WHERE CID = :cid AND TDATE BETWEEN :startDate AND :endDate';

    $statement = $db->prepare($t);
    $statement->bindValue(':cid', $cid);
    $statement->bindValue(':startDate', $start);
    $statement->bindValue(':endDate', $end);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <body>
    <h1>Your orders:</h1>
        <table class="orderTable">
                    <tr>
                        <th>
                            Order number
                        </th>
                        <th>
                            Total Cost
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Delivered
                        </th>
                    </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['CartID'];?></td>
                        <td><?php echo $order['TotalAmount'];?></td> 
                        <td><?php echo $order['TDATE'];?></td>
                        <td><?php 
                        if($order['TranTag']){
                            echo 'Yes';
                        }
                        else{
                            echo 'No';
                        }?></td>
                    </tr>
                <?php endforeach ?>
        </table>
    </body>
</html>