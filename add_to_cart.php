<?php
    require_once('database.php');
    require_once('browse.php');
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $add = filter_input(INPUT_POST, "pid");
    $quantity = filter_input(INPUT_POST, "quantity");

    $query = 'SELECT * FROM Customer WHERE Email = :mail';
    $statement = $db->prepare($query);
    $statement->bindValue(':mail', $email);
    $statement->execute();
    $me = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    $customer = $me['CID'];
    $status = $me['Status'];

    #query what product is wanted
    $details = 'SELECT * FROM product WHERE ProductID = :prodNum';
    $prod = $db->prepare($details);
    $prod->bindValue(':prodNum', $add);
    $prod->execute();
    $product = $prod->fetch(PDO::FETCH_ASSOC);
    $prod->closeCursor();
    

    #assign price depending on customer status
    $price = $product['PPrice'];
    if($product['OnOffer'] == '1' && ($status == 'gold' || $status == 'platinum')){
        $price = $product['OfferPrice'];
    }
    
    #query basket to see if there's an existing one
    $cartQuery = 'SELECT CartID FROM basket 
    WHERE CID = :buyer AND CartID NOT IN (SELECT CartID FROM transaction)';
    $stat = $db->prepare($cartQuery);
    $stat->bindValue(':buyer', $customer);
    $stat->execute();
    $cart = $stat->fetch(PDO::FETCH_ASSOC);
    $stat->closeCursor();

    #if there is no basket, create one
    if($cart['CartID'] === NULL){
        $newCart = 'INSERT INTO basket (CartID) VALUES (:cid)';
        $stat2 = $db->prepare($newCart);
        $stat2->bindValue(':cid', $customer);
        $stat2->execute();
        $stat2->closeCursor();

        $query = 'SELECT CartID FROM basket 
        WHERE CID = :buyer AND CartID NOT IN (SELECT CartID FROM transaction)';
        $stat3 = $db->prepare($query);
        $stat3->bindValue(':buyer', $customer);
        $stat3->execute();
        $cart = $stat3->fetch(PDO::FETCH_ASSOC);
        $stat3->closeCursor();
    }
    $cartNum = $cart['CartID'];

    #insert into appears_in
    $insertion = 'INSERT INTO appears_in (ProductID, CartID, Quantity, PriceSold) 
    VALUES (:added, :basket, :amount, :soldFor)';
    $insQuery = $db->prepare($insertion);
    $insQuery->bindValue(':added', $add);
    $insQuery->bindValue(':basket', $cartNum);
    $insQuery->bindValue(':amount', $quantity);
    $insQuery->bindValue(':soldFor', $price);
    $insQuery->execute();
    $insQuery->closeCursor();

    #update product to reduce in stock quantity
    
?>

<!DOCTYPE html>
<html>
    <body>
    Product successfully added to your basket.
    </body>
</html>
