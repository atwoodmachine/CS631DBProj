<?php
    require_once('database.php');
    $cid = filter_input(INPUT_POST, "CID");
    $cnum = filter_input(INPUT_POST, "ccnumber");
    $new = filter_input(INPUT_POST, "address");

    $update = 'UPDATE Credit_Card SET BillingAddress = :new 
    WHERE CardNumber = :num AND 
    CID = :cid';
    $statement = $db->prepare($update);
    $statement->bindValue(':new', $new);
    $statement->bindValue(':num', $cnum);
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
        <p>You have successfully updated your billing address</p>
    </section>
   
  </body>
</html>