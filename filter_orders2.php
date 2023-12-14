<?php
    require_once('database.php');
    $cid = filter_input(INPUT_POST, "custID");
    $pname = filter_input(INPUT_POST, "pName");

    $t = 'SELECT * 
    FROM appears_in LEFT JOIN product ON appears_in.ProductID = product.ProductID
    LEFT JOIN transaction on appears_in.CartID = transaction.CartID 
    WHERE CID = :cid AND PName = :pname;';

    $statement = $db->prepare($t);
    $statement->bindValue(':cid', $cid);
    $statement->bindValue(':pname', $pname);
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