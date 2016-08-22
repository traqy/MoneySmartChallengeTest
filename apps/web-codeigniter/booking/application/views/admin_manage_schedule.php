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
    $('#datefrom').removeClass('hasDatepicker');
    $('#datefrom').datepicker({
         dateFormat: 'yy-mm-dd',
         minDate: dateToday
    });
  });
  $(function() {    
    $('#dateto').removeClass('hasDatepicker');
    $('#dateto').datepicker({
         dateFormat: 'yy-mm-dd',
         minDate: dateToday
    });
  });
  </script>
</head>
<body>

<?php
echo "Email: $session_email";
?>

<div>
<form id="frmDate" action="generate" method="post">
    <p>Date From: <input type="text" id="datefrom" name="datefrom"></p>
    <p>Date To: <input type="text" id="dateto" name="dateto"></p>
    <input type='Submit' name='publish' value='Publish Schedule' />
</form>
</div>

<div>
 <table>
 <tr>
 <td>Date</td>
 <td>Publish Status</td>
 <td>Message</td>
 </tr>
</div>
<?php 
if (isset($dates)) { 
  foreach ($dates as $item){
    $date = $item['date'];
    $status = $item['status'];
    $message = $item['message'];
    echo "<tr><td>$date</td><td>$status</td><td>$message</td></tr>";
  }
}
?>

<div>
<a href="<?php echo base_url('index.php/booking/home'); ?>">Home</a>
<a href="logout">Logout</a>
 </div>

</body>
</html>