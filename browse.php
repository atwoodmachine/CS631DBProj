<?php
    require_once('database.php');
    #Query all products
    $queryProd = 'SELECT * FROM product';

    $statement1 = $db->prepare($queryProd);
    $statement1->execute();
    $products = $statement1->fetchAll();
    $statement1->closeCursor();
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
        <h2>Products</h2>
        <table class="customerBasket">
                <tr>
                    <th>
                        Product ID
                    </th>
                    <th>
                        Item
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Sale Price
                    </th>
                    <th>
                        Quantity in stock
                    </th>
                </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['ProductID'];?></td>
                    <td><?php echo $product['PName'];?></td> 
                    <td><?php echo $product['PPrice'];?></td>
                    <td><?php echo $product['PDescription'];?></td>
                    <td><?php echo $product['OfferPrice'];?></td>
                    <td><?php echo $product['PQuantity'];?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <h2>Use this form to add items to your cart</h2>
        <form method="post" action="add_to_cart.php" id="forms">
            <label for="CID">Enter your email:</label>
            <input id="email" type="text" name="email">

            <label for="Product">Enter product ID:</label>
            <input id="pid" type="text" name="pid">

            <label for="Quantity">Quantity:</label>
            <input id="quantity" type="text" name="quantity">

            <input id="submit" type="submit" />
        </form>
    </body>
</html>