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
    }
?>

<!DOCTYPE html>
<html>

<body>
    <h1>
    Use this form to add a new credit card:
    </h1>
    <form method="post" action="add_cc.php" id="forms">
        <label for="ccnumber">Card number:</label>
        <input id="Card number" type="text" name="ccnumber">
              
        <label for="secnum">Security number:</label>
        <input id="Security number" type="text" name="secnum">
                
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

</body>

</html>