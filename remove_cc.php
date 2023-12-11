<?php 

    $cardNum = filter_input(INPUT_POST, "cardNum");


    $error_message = 'Error in field(s):<br>';

    if($cardNum === FALSE){
        $error_message .= 'Card number<br>';
    }
    
    //run query or show error
    
    if($error_message != 'Error in field(s):<br>'){
        include('error.php');
        exit();
    }
    else{
        require_once('database.php');
        $query = 'DELETE FROM Credit_Card
        WHERE CardNumber = :cnum';
        
        $statement = $db->prepare($query);

        $statement->bindValue(':cnum', $cardNum);

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

    <section id="center">
        <h2>Success!</h2>
        <p>You have successfully removed a credit card from your account.</p>
    </section>
   
  </body>
</html>