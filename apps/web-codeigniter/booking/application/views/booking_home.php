<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tennis Court Schedule Pick A Date</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <style>
      table {
        border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
  </style>
  <script>

  var dateToday = new Date(); 

  $(function() {    
   $('#date').removeClass('hasDatepicker');
   $('#date').datepicker({
       dateFormat: 'yy-mm-dd',
       minDate: dateToday,
       onSelect: function(dateText, inst) {
           $('#frmDate').submit();
       }
   });
  });
  </script>
</head>
<body>

<div> 
<?php if (isset($message)) {echo "$message<br>";} ?>
</div>


<?php
echo "Email: $session_email<br>";
?>

<div>
 <form id="frmDate" name="frmDate" action="home" method="post">
    <p>Pick Date: <input type="text" id="date" name="date"></p>
    <input type='submit' name='submit' value='ShowDateSlots' />
</form>
</div>

<div>
<table>
 <tr><td><?php if (isset($date)){ echo $date; } ?></td></tr>
 <tr>
 <td>Hour</td>
 <td>Reservee</td>
 <td>Comment</td>
 <td>Status</td>
 <td></td>
 </tr>
 <?php 
    if (!isset($date_slots)){
    }
    else{
        $jo = json_decode(trim($date_slots),TRUE);
        $array_data = $jo['viewBookingDateSlots']['data'];

        $array_status = array( 0 => 'Available', 1 => 'Taken', -1 => 'Closed');
        $ctr=0;
        foreach ($array_data as $slot ) {
            $ctr++;
            $hourly_slot = $slot['HourlySlot'];
            $hourly_display = $hour_label_map[$hourly_slot];
            $reservee_id = $slot['ReserveeId'];
            $reservee_comment = $slot['ReserveeComment'];
            $status =  $slot['Status'];
            $status_label = $array_status[$status];
            echo "<tr>";
            echo "<form id='$ctr' action='home' method='post'><input type='hidden' value='$date' name='date' id='date'><input type='hidden' value='$hourly_slot' name='hourly_slot' id='hourly_slot'><input type='hidden' value='$reservee_id' name='reservee_id' id='reservee_id'>";
            echo "<td>$hourly_display</td>";
            echo "<td>$reservee_id</td>";
            echo "<td>$reservee_comment</td>";
            echo "<td>$status_label</td>";
            if ($access_level == 2){
                if ( $status == -1 ){
                  // status is currently closed
                  echo "<td><input type='submit' name='submit' value='Open' /></td>";
                }
                elseif ( $status == 0 ){
                  echo "<td><input type='submit' name='submit' value='Close' /></td>";
                }
                elseif ( $status == 1 ){
                  echo "<td><input type='submit' name='submit' value='Cancel' /></td>";
                }
                else{
                  echo "<td></td>";
                }
            }
            else{
                if ( $status == 0 ){
                    echo "<td><input type='submit' name='submit' value='Book'/></td>";
                }
                else{
                    if ( $reservee_id == $session_email ){
                      echo "<td><input type='submit' name='submit' value='Cancel' /></td>";
                    }
                    else{
                      echo "<td></td>";  
                    }
                    
                }              
            }
            echo "</form>";
            echo "</tr>";
        }
    }
    
  ?>
  </table>
  </div>  
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