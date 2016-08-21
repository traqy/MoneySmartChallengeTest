<!DOCTYPE html>
<html lang="en">
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body>


<div>
<form id="frmDate" action="../logout">
<?php
echo "Email: $session_email";
?>
    <input type='submit' name='Logout' value='Logout' />
</form>
<br/>
</div>

<div> 
<?php if (isset($message)) {echo "$message<br>";} ?>
</div>

<div>
  <?php 
    if (isset($session_email)){
        $input_reservee_id = $session_email;
    }
    else{
        // This scenario will be prevented in the controller
        $input_reservee_id = '';   
    }
  ?>
  <form id='reserve' action='reserveSlot' method='post'
    accept-charset='UTF-8'>
    Reserve Tennis Court Hourly Slot:<br>
    Date: <input type="text" name="date" value="<?php echo "$date"; ?>" readonly><br>
    Hour Slot: <input type="text" name="hourly_slot" value="<?php echo "$hourly_slot"; ?>" readonly><br>
    <!-- Email/User: <input type="text" name="reservee_id" value="<?php echo "$reservee_id"; ?>" > For now this field is editable. Later to integrate login session UserId<br> -->

    Email/User: <input type="text" name="reservee_id" value="<?php echo "$input_reservee_id"; ?>" readonly><br>
    Comment: <input type="text"  name="reservee_comment"><br>
    <br><br>
    <input type='submit' name='Submit' value='Submit' />
  </form>
</div>
<div>
<a href="../home">Home</a>
<a href="../logout">Logout</a>
</div>

</body>
</html>