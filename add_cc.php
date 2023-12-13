<?php 
    $cid = filter_input(INPUT_POST, "CID");
    $cardNum = filter_input(INPUT_POST, "ccnumber");
    $sec = filter_input(INPUT_POST, "secnum");
    $owner = filter_input(INPUT_POST, "cname");
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

        $statement->bindValue(':CID', $cid);
        $statement->bindValue(':CardNumber', $cardNum);
        $statement->bindValue(':SecNumber', $sec);
        $statement->bindValue(':CardOwnerName', $owner);
        $statement->bindValue(':CardType', $ctype);
        $statement->bindValue(':BillingAddress', $billing);
        $statement->bindValue(':ExpDate', $expiry);

        $statement->execute();
        $statement->closeCursor();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta lang="en" />
  </head>
  <div class = "nav">
        <a href="registration.php">Register</a>
        <a href="login.php">My account</a>
        <a href="view_cart.php">My basket</a>
        <a href="browse.php">Browse</a>
        <a href="analytics.php">Analytics</a>
    </div>

    <section id="center">
        <h2>Success!</h2>
        <p>Congratulations, you have successfully added a credit card to your account!</p>
    </section>
   
  </body>
</html>