<?php
    require_once('database.php');
    $cid = filter_input(INPUT_POST, "CID");
    $saname = filter_input(INPUT_POST, "saname");
    $new = filter_input(INPUT_POST, "newname");

    $update = 'UPDATE Ship_Address SET Street = :new 
    WHERE SAName = :saname AND 
    CID = :cid';
    $statement = $db->prepare($update);
    $statement->bindValue(':new', $new);
    $statement->bindValue(':saname', $saname);
    $statement->bindValue(':cid', $cid);
    $statement->execute();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>

  <div class = "nav">
        <a href="registration.php">Register</a>
        <a href="login.php">My account</a>
        <a href="view_cart.php">My basket</a>
        <a href="browse.php">Browse</a>
        <a href="analytics.php">Analytics</a>
    </div>

    <section id="center">
        <p>You have successfully updated your shipping address</p>
    </section>
   
  </body>
</html>