<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tennis Court Schedule Pick A Date</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
      table {
        border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
  </style>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
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

<?php
echo "Email: $session_email";
?>

<!-- <div>
<form id="frmDate" action="../logout">
    <input type='submit' name='Logout' value='Logout' />
</form>
</div>
 -->

<?php if (isset($message)) {echo "$message";} ?>
<div>
<form id="frmDate" action="viewSlotsByDate" method="post">
    <p>Date: <input type="text" id="date" name="date"></p>
    <input type='hidden' name='Submit' value='Show' />
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
        foreach ($array_data as $slot ) {
            $hourly_slot = $slot['HourlySlot'];
            $hourly_display = $hour_label_map[$hourly_slot];
            $reservee_id = $slot['ReserveeId'];
            $reservee_comment = $slot['ReserveeComment'];
            $status =  $slot['Status'];
            $status_label = $array_status[$status];
            echo "<tr>";
            echo "<form action='reserveForm' method='post'><input type='hidden' value='$date' name='date' id='date'><input type='hidden' value='$hourly_slot' name='hourly_slot' id='hourly_slot'><input type='hidden' value='$reservee_id' name='reservee_id' id='reservee_id'>";
            echo "<td>$hourly_display</td>";
            echo "<td>$reservee_id</td>";
            echo "<td>$reservee_comment</td>";
            echo "<td>$status_label</td>";
            if ($status == 0 ){
                echo "<td><input type='submit' name='Reserve' value='Reserve' /></td>";
            }
            else{            
                echo "<td></td>";   
            }
            echo "</form>";
            echo "</tr>";
        }
    }
    
  ?>

  </table>
  </div>

<div>
<a href="../home">Home</a>
<a href="../logout">Logout</a>
<?php if ($access_level == 2){ anchor('Admin/manage','Admin');} ?>
</div>

</body>
</html>