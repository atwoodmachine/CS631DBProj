

<?php
    require_once('database.php');
    #Stats 1: Credit cards and amount charged per card
    $saleStat1 = 'SELECT CardNumber, SUM(TotalAmount) as Charged
                  FROM transaction GROUP BY CardNumber';

    $statement1 = $db->prepare($saleStat1);
    $statement1->execute();
    $cardStats = $statement1->fetchAll();
    $statement1->closeCursor();

    #Stats 2: 10 best customers (money spent descending)
    $saleStat2 = 'SELECT customer.CID, Fname, Lname, SUM(TotalAmount) as Spent
                  FROM customer INNER JOIN transaction ON customer.CID = transaction.CID
                  GROUP BY CID
                  ORDER BY Spent DESC
                  LIMIT 10';
    $statement2 = $db->prepare($saleStat2);
    $statement2->execute();
    $topTen = $statement2->fetchAll();
    $statement2->closeCursor();
?>

<!DOCTYPE html>
<html>
    <!--Stats 1: Credit cards and amount charged per card-->
    <table class="creditCardTable">
                <tr>
                    <th>
                        Card Number
                    </th>
                    <th>
                        Total Charged
                    </th>
                </tr>
            <?php foreach ($cardStats as $card): ?>
                <tr>
                    <td><?php echo $card['CardNumber'];?></td>
                    <td><?php echo $card['Charged'];?></td> 
                </tr>
            <?php endforeach ?>
    </table>

    <!--Stats 2: Top ten customers-->
    <table class="topTenTable">
                <tr>
                    <th>
                        Customer ID
                    </th>
                    <th>
                        First Name
                    </th>
                    <th>
                        Last Name
                    </th>
                    <th>
                        Total Spent
                    </th>
                </tr>
            <?php foreach ($topTen as $cust): ?>
                <tr>
                    <td><?php echo $cust['CID'];?></td>
                    <td><?php echo $cust['Fname'];?></td> 
                    <td><?php echo $cust['Lname'];?></td>
                    <td><?php echo $cust['Spent'];?></td>
                </tr>
            <?php endforeach ?>
    </table>
</html>