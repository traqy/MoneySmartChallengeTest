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
 <form id="frmDate" action="home/viewSlotsByDate" method="post">
    <p>Pick Date: <input type="text" id="date" name="date"></p>
    <input type='hidden' name='Submit' value='Show' />
</form>

<div>
<!-- <a href="home">Home</a> -->
<a href="<?php echo base_url('index.php/booking/home'); ?>">Home</a>
<a href="logout">Logout</a>
<?php if ($access_level == 2){ echo '<a href="../adminbooking/manage">Admin</a>';} ?>
</div>

</body>
</html>