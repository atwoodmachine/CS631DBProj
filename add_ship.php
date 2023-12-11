<?php 
    $cid = filter_input(INPUT_POST, "CID");
    $saname = filter_input(INPUT_POST, "shipname");
    $recipient = filter_input(INPUT_POST, "recip");
    $country = filter_input(INPUT_POST, "country");
    $state = filter_input(INPUT_POST, "state");
    $city = filter_input(INPUT_POST, "city");
    $zip = filter_input(INPUT_POST, "zip");
    $street = filter_input(INPUT_POST, "street");
    $streetNum = filter_input(INPUT_POST, "streetnum");


    require_once('database.php');
    $query = 'INSERT INTO Ship_Address
    (CID, SAName, RecipientName, Country, State, City, Zip, Street, SNumber)
    VALUES (:CID, :SAName, :RecipientName, :Country, :State, :City, :Zip, :Street, :SNumber)';
        
    $statement = $db->prepare($query);

    $statement->bindValue(':CID', $cid);
    $statement->bindValue(':SAName', $saname);
    $statement->bindValue(':RecipientName', $recipient);
    $statement->bindValue(':Country', $country);
    $statement->bindValue(':State', $state);
    $statement->bindValue(':City', $city);
    $statement->bindValue(':Zip', $zip);
    $statement->bindValue(':Street', $street);
    $statement->bindValue(':SNumber', $streetNum);

    $statement->execute();
    $statement->closeCursor();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta lang="en" />
  </head>

    <section id="center">
        <h2>Success!</h2>
        <p>Congratulations, you have successfully added a shipping address to your account.</p>
    </section>
   
  </body>
</html>