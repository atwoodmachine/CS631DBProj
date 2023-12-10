

<?php
    require_once('database.php');
    #Stats 1: Credit cards and amount charged per card
    $saleStat1 = 'SELECT CardNumber, SUM(TotalAmount) as Charged
                  FROM transaction GROUP BY CardNumber';

    $statement1 = $db->prepare($saleStat1);
    $statement1->execute();
    $cardStats = $statement1->fetchAll();
    $statement1->closeCursor();
?>

<!DOCTYPE html>
<html>
<table class="creditCardTable">
                <tr>
                    <th>
                        Card Number
                    </th>
                    <th>
                        Total Charged
                    </th>
                </tr>
<!--Stats 1: Credit cards and amount charged per card-->
            <?php foreach ($cardStats as $card): ?>
                <tr>
                    <td><?php echo $card['CardNumber'];?></td>
                    <td><?php echo $card['Charged'];?></td> 
                </tr>
            <?php endforeach ?>

            </table>
</html>