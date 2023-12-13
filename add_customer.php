<!--
Seniz Ozdemir
12-9-2022
IT202-001
Semester Project Phase 3
-->

<?php
    $fName = filter_input(INPUT_POST, "fName");
    $lName = filter_input(INPUT_POST, "lName");
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, "address");
    $phone = filter_input(INPUT_POST, "phone");

    //validation
    $error_message = 'Error in field(s):<br>';

    if($fName === FALSE){
        $error_message .= 'First Name<br>';
    }
    if($lName === FALSE){
        $error_message .= 'Last Name<br>';
    }
    if($email === FALSE){
        $error_message .= 'Email<br>';
    }
    if($address === FALSE){
        $error_message .= 'Address<br>';
    }
    if($phone === FALSE){
        $error_message .= 'Phone<br>';
    }

    //run query or show error
    
    if($error_message != 'Error in field(s):<br>'){
        include('error.php');
        exit();
    }
    else{
        require_once('database.php');

        $query = 'INSERT INTO Customer
        (FName, LName, Email, Address, phone) 
        VALUES (:fName, :lName, :email, :address, :phone)';
        
        $statement = $db->prepare($query);

        $statement->bindValue(':fName', $fName);
        $statement->bindValue(':lName', $lName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':address', $address);
        $statement->bindValue(':phone', $phone);

        $statement->execute();
        $statement->closeCursor();
    }
?>

<!--success-->
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
        <p>Congratulations, you have been registered!</p>
        <p>Thank you!</p>
       
    </section>
   
  </body>

</html>