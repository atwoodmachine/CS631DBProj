<?php 
    $custID = filter_input(INPUT_POST, "custID");
    $ship = filter_input(INPUT_POST, "SAName");
    
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
        $query = 'DELETE FROM Ship_Address
        WHERE CID = :cid AND SAName = :saname';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':cid', $custID);
        $statement->bindValue(':saname', $ship);
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
        <p>You have successfully removed a shipping address from your account.</p>
    </section>
   
  </body>
</html>