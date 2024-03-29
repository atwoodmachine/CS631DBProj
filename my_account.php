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
        
        $customerID = $me['CID'];
        $cardsQuery = 'SELECT * FROM Credit_Card WHERE CID = :custID';
        $statement2 = $db->prepare($cardsQuery);
        $statement2->bindValue(':custID', $customerID);
        $statement2->execute();
        $cards = $statement2->fetchAll();
        $statement2->closeCursor();

        $addressQuery = 'SELECT * FROM Ship_Address WHERE CID = :customerID';
        $statement3 = $db->prepare($addressQuery);
        $statement3->bindValue(':customerID', $customerID);
        $statement3->execute();
        $addresses = $statement3->fetchAll();
        $statement3->closeCursor();

        #basic transaction info
        $transQuery = 'SELECT * FROM transaction WHERE CID = :cust';
        $statement4 = $db->prepare($transQuery);
        $statement4->bindValue(':cust', $customerID);
        $statement4->execute();
        $orders = $statement4->fetchAll();
        $statement4->closeCursor();
    }
?>

<!DOCTYPE html>
<html>

<body>
<div class = "nav">
        <a href="registration.php">Register</a>
        <a href="login.php">My account</a>
        <a href="view_cart.php">My basket</a>
        <a href="browse.php">Browse</a>
        <a href="analytics.php">Analytics</a>
    </div>
    Hello, <?php echo $me['FName'];?> <br>
    Your Customer ID (CID) is: <?php echo $me['CID'];?> <br>
    Your available credit is: $<?php echo $me['CreditLine'];?><br>
    Your email: <?php echo $me['Email'];?><br>
    Your phone number: <?php echo $me['Phone'];?><br>
    <h3>Use the fields below to update account details:</h3>
    <form method="post" action="acc_update.php" id="forms">
        <label for="oldEmail">Enter your original email (required for all updates):</label>
            <input id="Email" type="text" name="oldEmail">
        <label for="newEmail">Enter new email:</label>
            <input id="Email" type="text" name="newEmail">
        <label for="newPhone">Enter new phone number:</label>
            <input id="newPhone" type="text" name="newPhone">
            <input id="submit" type="submit"/>   
    </form>
    <h1>Your credit cards:</h1>
    <table class="customerCardTable">
                <tr>
                    <th>
                        Card Number
                    </th>
                    <th>
                        Name on card
                    </th>
                    <th>
                        Card Type
                    </th>
                    <th>
                        Billing Address
                    </th>
                    <th>
                        Expiration Date
                    </th>
                </tr>
            <?php foreach ($cards as $card): ?>
                <tr>
                    <td><?php echo $card['CardNumber'];?></td>
                    <td><?php echo $card['CardOwnerName'];?></td> 
                    <td><?php echo $card['CardType'];?></td>
                    <td><?php echo $card['BillingAddress'];?></td>
                    <td><?php echo $card['ExpDate'];?></td>
                </tr>
            <?php endforeach ?>
    </table>
    
    <h3>Use the fields below to update a card's billing address:</h3>
    <form method="post" action="update_cc.php" id="forms">
        <label for="CID">Enter your CID (provided at the top of the page):</label>
        <input id="CID" type="text" name="CID">
        
        <label for="ccnumber">Card number for card to be updated:</label>
        <input id="Card number" type="text" name="ccnumber">
              
        <label for="address">New Billing Address:</label>
        <input id="Address" type="text" name="address">

        <input id="submit" type="submit" />
    </form>

    <h1>Your shipping addresses:</h1>
    <table class="customerAddressTable">
                <tr>
                    <th>
                        Address Name
                    </th>
                    <th>
                        Recipient Name
                    </th>
                    <th>
                        Country
                    </th>
                    <th>
                        State
                    </th>
                    <th>
                        City
                    </th>
                    <th>
                        Zip Code
                    </th>
                    <th>
                        Street Number
                    </th>
                    <th>
                        Street Name
                    </th>
                </tr>
            <?php foreach ($addresses as $address): ?>
                <tr>
                    <td><?php echo $address['SAName'];?></td>
                    <td><?php echo $address['RecipientName'];?></td> 
                    <td><?php echo $address['Country'];?></td>
                    <td><?php echo $address['State'];?></td>
                    <td><?php echo $address['City'];?></td>
                    <td><?php echo $address['Zip'];?></td>
                    <td><?php echo $address['SNumber'];?></td>
                    <td><?php echo $address['Street'];?></td>
                </tr>
            <?php endforeach ?>
    </table>

    <h3>Use the fields below to update a shipping address:</h3>
    <form method="post" action="update_ship.php" id="forms">
        <label for="CID">Enter your CID (provided at the top of the page):</label>
        <input id="CID" type="text" name="CID">
        
        <label for="saname">Address name for address to be updated:</label>
        <input id="saname" type="text" name="saname">

        <label for="newname">New Street Name:</label>
        <input id="newname" type="text" name="newname">

        <input id="submit" type="submit" />
    </form>

    <h1>
    Use this form to add a new credit card to your account:
    </h1>
    <form method="post" action="add_cc.php" id="forms">
        <label for="CID">Enter your CID (provided at the top of the page):</label>
        <input id="CID" type="text" name="CID">
        
        <label for="ccnumber">Card number:</label>
        <input id="Card number" type="text" name="ccnumber">
              
        <label for="secnum">Security number:</label>
        <input id="Security number" type="text" name="secnum">

        <label for="cname">Name on card:</label>
        <input id="Owner name" type="text" name="cname">
                
        <label for="type">Card type:</label>
        <select name="type" id="Card Type">
            <option disabled selected value> -Select an option- </option>
            <option>Visa</option>
            <option>Mastercard</option>
            <option>American Express</option>
            <option>Discover</option>
        </select>

        <label for="address">Billing Address:</label>
        <input id="Address" type="text" name="address">

        <label for="expiration">Expiration date:</label>
        <input id="Expiration date" type="text" name="expiration" placeholder = "MM/YY">

        <input id="reset" type="reset" />
        <input id="submit" type="submit" />
    </form>

    <h1>
    Use this form to add a new shipping address to your account:
    </h1>
    <form method="post" action="add_ship.php" id="forms">
        <label for="CID">Enter your CID (provided at the top of the page):</label>
        <input id="CID" type="text" name="CID">
        
        <label for="shipname">Name of shipping address:</label>
        <input id="Address name" type="text" name="shipname">
              
        <label for="recip">Recipient Name:</label>
        <input id="Recipient Name" type="text" name="recip">

        <label for="country">Country:</label>
        <input id="country" type="text" name="country">
        
        <label for="state">State:</label>
        <input id="state" type="text" name="state" placeholder = "ex: NY">

        <label for="city">City:</label>
        <input id="city" type="text" name="city">

        <label for="zip">Zip code:</label>
        <input id="zip" type="text" name="zip" placeholder = "ex: 12345">

        <label for="street">Street Name:</label>
        <input id="street" type="text" name="street">
        
        <label for="streetnum">Street number:</label>
        <input id="streetnum" type="number" name="streetnum">

        <input id="reset" type="reset" />
        <input id="submit" type="submit" />
    </form>


    <h1>
    To delete a credit card, enter its card number below and submit:
    </h1>
    <form method="post" action="remove_cc.php" id="forms">
        <label for="cardNum">Card number:</label>
        <input id="Card number" type="text" name="cardNum">
        <input id="submit" type="submit" />
    </form>

    <h1>
    To delete a shipping address, enter its name and your CID below and submit:
    </h1>
    <form method="post" action="remove_ship.php" id="forms">
        <label for="custID">Enter your CID (provided at the top of the page):</label>
        <input id="custID" type="text" name="custID">

        <label for="SAName">Shipping Address Name:</label>
        <input id="SAName" type="text" name="SAName">

        <input id="submit" type="submit" />
    </form>

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

    <h2>Query orders based on certain criteria:</h2>
    <h3>Order date range:</h3>
    <form method="post" action="filter_orders1.php" id="forms">
        <label for="custID">Enter your CID (provided at the top of the page):</label>
        <input id="custID" type="text" name="custID">

        <label for="startDate">Start date (YYYY-MM-DD):</label>
        <input id="Start Date" type="text" name="startDate" placeholder = "ex:2023-12-01">

        <label for="endDate">End date (YYYY-MM-DD):</label>
        <input id="End Date" type="text" name="endDate" placeholder = "ex:2023-12-31">

        <input id="submit" type="submit" />
    </form>
    <h3>Product in transaction:</h3>
    <form method="post" action="filter_orders2.php" id="forms">
        <label for="custID">Enter your CID (provided at the top of the page):</label>
        <input id="custID" type="text" name="custID">

        <label for="prodName">Enter the name of the product:</label>
        <input id="pName" type="text" name="pName">

        <input id="submit" type="submit" />
    </form>
</body>

</html>