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
<div class = "nav">
        <a href="registration.php">Register</a>
        <a href="login.php">My account</a>
        <a href="view_cart.php">My basket</a>
        <a href="browse.php">Browse</a>
        <a href="analytics.php">Analytics</a>
    </div>
    <!--Stats 1: Credit cards and amount charged per card-->
    <h2>Stat 1: Total Amount Charged Per Credit Card</h2>
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
    <h2>Stat 2: Top 10 Best Customers</h2>
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

    <!-- Stats 3: requires user input -->
    <h2>
    Stat 3: Compute the top 5 most frequently sold products for a given time period:
    </h2>
    <form method="post" action="stat3.php" id="forms">
        <label for="startDate">Start date (YYYY-MM-DD):</label>
        <input id="Start Date" type="text" name="startDate" placeholder = "ex:2023-12-01">

        <label for="endDate">End date (YYYY-MM-DD):</label>
        <input id="End Date" type="text" name="endDate" placeholder = "ex:2023-12-31">

        <input id="submit" type="submit" />
    </form>

    <!-- Stats 4: requires user input -->
    <h2>
    Stat 4: Compute the top 5 products sold to the highest number of distinct customers in a given time period:
    </h2>
    <form method="post" action="stat4.php" id="forms">
        <label for="startDate">Start date (YYYY-MM-DD):</label>
        <input id="Start Date" type="text" name="startDate" placeholder = "ex:2023-12-01">

        <label for="endDate">End date (YYYY-MM-DD):</label>
        <input id="End Date" type="text" name="endDate" placeholder = "ex:2023-12-31">

        <input id="submit" type="submit" />
    </form>

    <!-- Stats 5: requires user input -->
    <h2>
    Stat 5: Compute the maximum basket total amount for each credit card for a given time period:
    </h2>
    <form method="post" action="stat5.php" id="forms">
        <label for="startDate">Start date (YYYY-MM-DD):</label>
        <input id="Start Date" type="text" name="startDate" placeholder = "ex:2023-12-01">

        <label for="endDate">End date (YYYY-MM-DD):</label>
        <input id="End Date" type="text" name="endDate" placeholder = "ex:2023-12-31">

        <input id="submit" type="submit" />
    </form>
    
    <!-- Stats 6: requires user input -->
    <h2>
    Stat 6: Compute the average selling product price for each product type for a given time period:
    </h2>
    <form method="post" action="stat6.php" id="forms">
        <label for="startDate">Start date (YYYY-MM-DD):</label>
        <input id="Start Date" type="text" name="startDate" placeholder = "ex:2023-12-01">

        <label for="endDate">End date (YYYY-MM-DD):</label>
        <input id="End Date" type="text" name="endDate" placeholder = "ex:2023-12-31">

        <input id="submit" type="submit" />
    </form>
</html>