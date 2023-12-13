<?php
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $cardNum = filter_input(INPUT_POST, "cardNum");
    $newCard = filter_input(INPUT_POST, "newCard");
    $shipping = filter_input(INPUT_POST, "shipName");
    
    $error_message = 'Error in field(s):<br>';
    if($email === FALSE){
        $error_message .= 'Email<br>';
    }
    if($cardNum == "Enter new card"){
        $cardNum = $newCard;
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

        #calc total cost
        $basketTotal = 0;
        foreach($items as $item) {
            $basketTotal += $item['PriceSold'] * $item['Quantity'];
            $cart = $item['CartID'];
        }

        $transaction = 'INSERT INTO transaction(CID, SAName, CardNumber, CartID, 
        TDATE, TotalAmount) 
        VALUES (:cust, :SName, :CardNum, :Cart, now(), :Total)';
        $statement3 = $db->prepare($transaction);
        $statement3->bindValue(':cust', $customer);
        $statement3->bindValue(':SName', $shipping);
        $statement3->bindValue(':CardNum', $cardNum);
        $statement3->bindValue(':Cart', $cart);
        $statement3->bindValue(':Total', $basketTotal);
        $statement3->execute();
        $statement3->closeCursor();
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <h1>Your order has been placed. Thank you.</h1>
    </body>
</html>