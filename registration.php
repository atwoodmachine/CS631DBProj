<!DOCTYPE html>
<html>

<body>
    <form method="post" action="add_customer.php" id="forms">
        <label for="fname">First Name:</label>
                    <input id="First name" type="text" name="fName" 
                    minlength="1" maxlength="255">
              
                    <label for="lname">Last Name:</label>
                    <input id="Surname" type="text" name="lName" 
                    minlength="1" maxlength="255">
                
                    <label for="email">Email:</label>
                    <input id="Email" type="email" name="email" 
                    maxlength="255">

                    <label for="address">Address:</label>
                    <input id="Address" type="text" name="address" 
                    minlength="1" maxlength="255">

                    <label for="phone">Phone Number:</label>
                    <input id="Phone" type="text" name="phone">
                    
                    <input id="reset" type="reset" />
                    <input id="submit" type="submit" />
    </form>

</body>

</html>