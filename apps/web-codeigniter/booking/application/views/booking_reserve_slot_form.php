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
  <form id='reserve' action='home' method='post'
    accept-charset='UTF-8'>
    Reserve Tennis Court Hourly Slot:<br>
    Date: <input type="text" name="date" value="<?php echo "$date"; ?>" readonly><br>
    Hour Slot: <input type="text" name="hourly_slot" value="<?php echo "$hourly_slot"; ?>" readonly><br>
    <!-- Email/User: <input type="text" name="reservee_id" value="<?php echo "$reservee_id"; ?>" > For now this field is editable. Later to integrate login session UserId<br> -->

    Email/User: <input type="text" name="reservee_id" value="<?php echo "$input_reservee_id"; ?>" readonly><br>
    Comment: <input type="text"  name="reservee_comment"><br>
    <br><br>
    <input type='submit' name='submit' value='Update' />
  </form>
</div>

<div>
<!-- <a href="home">Home</a> -->
<a href="<?php echo base_url('index.php/booking/home'); ?>">Home</a>
<a href="<?php echo base_url('index.php/booking/logout'); ?>">Logout</a>
<?php if ($access_level == 2){
  $url=base_url('index.php/adminbooking/manage');
  echo "<a href='$url'>Admin Page</a>";
}?>
</div>

</body>
</html>