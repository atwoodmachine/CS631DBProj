<?php
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    
    $error_message = 'Error in field(s):<br>';
    if($email === FALSE){
        $error_message .= 'Email<br>';
    }

    if($error_message != 'Error in field(s):<br>'){
        include('error.php');
        exit();
    }
    else{
        require_once('database.php');
        $query = 'SELECT * FROM Customer WHERE Email = :mail';
        $statement = $db->prepare($query);
        $statement->bindValue(':mail', $email);
        $statement->execute();
        $me = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        $customer = $me['CID'];
        
        #all items in basket
        $query2 = 'SELECT *
        FROM appears_in LEFT JOIN basket ON appears_in.CartID = basket.CartID
        LEFT JOIN product ON appears_in.ProductID = product.ProductID
        WHERE CID = :customer AND appears_in.CartID NOT IN (SELECT CartID
                                            FROM transaction)';
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':customer', $customer);
        $statement2->execute();
        $items = $statement2->fetchAll();
        $statement2->closeCursor();

        $cardsQuery = 'SELECT * FROM Credit_Card WHERE CID = :custID';
        $statement2 = $db->prepare($cardsQuery);
        $statement2->bindValue(':custID', $customer);
        $statement2->execute();
        $cards = $statement2->fetchAll();
        $statement2->closeCursor();

        $addressQuery = 'SELECT * FROM Ship_Address WHERE CID = :customerID';
        $statement3 = $db->prepare($addressQuery);
        $statement3->bindValue(':customerID', $customer);
        $statement3->execute();
        $addresses = $statement3->fetchAll();
        $statement3->closeCursor();

        $basketTotal = 0;
        foreach($items as $item) {
            $basketTotal += $item['PriceSold'] * $item['Quantity'];
        }
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <h2>Your basket:</h2>
        <table class="customerBasket">
                <tr>
                    <th>
                        Item
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Quantity
                    </th>
                </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['PName'];?></td>
                    <td><?php echo $item['PriceSold'];?></td> 
                    <td><?php echo $item['Quantity'];?></td>
                </tr>
            <?php endforeach ?>
    </table>
    Total: <?php echo $basketTotal;?>
    <h2>Fill out the following form to complete your transaction:</h2>
    <form method="post" action="transaction.php" id="forms">
        
        <label for="CID">Enter your email:</label>
        <input id="email" type="text" name="email">

        <label for="ship">Shipping Address:</label>
        <select name="shipName" id="Shipping address">
            <option disabled selected value> -Select an option- </option>
            <?php foreach ($addresses as $address) : ?>
                    <option value="<?php echo $address['SAName'];?>">
                        <?php echo $address['SAName']; ?>
                    </option>
                <?php endforeach; ?>
        </select>
                
        <label for="cardNum">Credit Card:</label>
        <select name="cardNum" id="Card Num">
            <option disabled selected value> -Select an option- </option>
            <?php foreach ($cards as $card) : ?>
                    <option value="<?php echo $card['CardNumber']; ?>">
                        <?php echo $card['CardNumber']; ?>
                    </option>
                <?php endforeach; ?>
            <option>Enter new card<option>
        </select>

        <label for="newCard">If you selected "Enter new card", enter the new card number:</label>
        <input id="Unstored card" type="text" name="newCard">

        <input id="reset" type="reset" />
        <input id="submit" type="submit" />
    </form>
    </body>
</html>