<?php
    require_once('database.php');
    $oldEmail = filter_input(INPUT_POST, "oldEmail");
    $newEmail = filter_input(INPUT_POST, "newEmail");
    $phone = filter_input(INPUT_POST, "newPhone");

    if($newEmail !== ''){
        $updateEmail = 'UPDATE customer SET Email = :new WHERE Email = :old';
        $statement = $db->prepare($updateEmail);
        $statement->bindValue(':new', $newEmail);
        $statement->bindValue(':old', $oldEmail);
        $statement->execute();
        $statement->closeCursor();
    }
    if($phone !== ''){
        $updatePhone = 'UPDATE customer SET Phone = :phone WHERE Email = :old';
        $statement2 = $db->prepare($updatePhone);
        $statement2->bindValue(':phone', $phone);
        $statement2->bindValue(':old', $oldEmail);
        $statement2->execute();
        $statement2->closeCursor();
    }
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
        <p>Congratulations, you have successfully updated your account!</p>
    </section>
   
  </body>
</html>