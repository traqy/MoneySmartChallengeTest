<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tennis Court Schedule Pick A Date</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <?php echo link_tag('assets/css/booking-webapp-table.css'); ?>
  <?php echo link_tag('assets/css/menu.css'); ?>
  
  <script>
  var dateToday = new Date(); 
  $(function() {    
    $('#date').removeClass('hasDatepicker');
    $('#date').datepicker({
           dateFormat: 'yy-mm-dd',
           minDate: dateToday,
           onSelect: function(dateText, inst) {
              $('#frmDate').submit();
           },
    });
  });
  </script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>

<body>

<div>
<form id="frmDate" name="frmDate" action="home/test" method="post">
<ul>
  <li><a href="<?php echo base_url('index.php/booking/home'); ?>">Home</a></li>
  <li><a href="<?php echo base_url('index.php/booking/logout');?>">Logout</a></li>
  <?php if ($access_level == 2){ $url=base_url('index.php/adminbooking/manage'); echo "<li><a href='$url'>Admin Page</a></li>"; } ?>
  <li><a href="#<?php echo "$session_email"; ?>"><?php echo "Account: $session_email"; ?></a></li>
  </form>
</div>

<div> 
<?php if (isset($message)) {echo "$message<br>";} ?>
</div>

  <?php 
    if (isset($session_email)){
        $input_reservee_id = $session_email;
    }
    else{
        // This scenario will be prevented in the controller
        $input_reservee_id = '';   
    }
  ?>



<div class="table-title">
    <form id='reserve' action='home' method='post'
      accept-charset='UTF-8'>
   <table>
   <thead>
   <tr><th colspan="2">Reserve Tennis Court Hourly Slot:</th></tr>
   <tr>
   <th class="text-left">Fields</th>
   <th class="text-left">Input</th>
   </tr>
   </thead>
    <tbody>
    <tr><td>Date:</td><td><input type="text" name="date" value="<?php echo "$date"; ?>" readonly></td></tr>
    <tr><td>Hour Slot:</td><td><input type="text" name="hourly_slot" value="<?php echo "$hourly_slot"; ?>" readonly></td></tr>
    <tr><td>Email/User:</td><td><input type="text" name="reservee_id" value="<?php echo "$input_reservee_id"; ?>" readonly></td></tr>
    <tr><td>Comment:</td><td><input type="text"  name="reservee_comment"></td></tr>
    <tr><td></td><td><input type='submit' name='submit' value='Update' /></td></tr>
    </tbody>
    </thead>
    </table>
    </form>
</div>

</body>
</html>