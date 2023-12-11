<?php 
    include('my_account.php');
    $cardNum = filter_input(INPUT_POST, "ccnumber");
    $sec = filter_input(INPUT_POST, "secnum");
    $ctype = filter_input(INPUT_POST, "type");
    $billing = filter_input(INPUT_POST, "address");
    $expiry = filter_input(INPUT_POST, "expiration");


    $error_message = 'Error in field(s):<br>';

    if($cardNum === FALSE){
        $error_message .= 'Card number<br>';
    }
    if($sec === FALSE){
        $error_message .= 'Security code<br>';
    }
    if($ctype === FALSE){
        $error_message .= 'Type<br>';
    }
    if($billing === FALSE){
        $error_message .= 'Billing Address<br>';
    }
    if($expiry === FALSE){
        $error_message .= 'Expiration<br>';
    }

    //run query or show error
    
    if($error_message != 'Error in field(s):<br>'){
        include('error.php');
        exit();
    }
    else{
        require_once('database.php');

        $query = 'INSERT INTO Credit_Card
        (CID, CardNumber, SecNumber, CardOwnerName, CardType, BillingAddress, ExpDate) 
        VALUES (:CID, :CardNumber, :SecNumber, :CardOwnerName, :CardType, 
        :BillingAddress, :ExpDate)';
        
        $statement = $db->prepare($query);

        $statement->bindValue(':CID', $);
        $statement->bindValue(':CardNumber', $);
        $statement->bindValue(':SecNumber', $);
        $statement->bindValue(':CardOwnerName', $);
        $statement->bindValue(':CardType', $);
        $statement->bindValue(':BillingAddress', $);
        $statement->bindValue(':ExpDate', $);

        $statement->execute();
        $statement->closeCursor();
    }

?>