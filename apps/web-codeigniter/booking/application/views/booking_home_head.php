<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tennis Court Schedule Pick A Date</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>

  $(function() {
   $('#date').removeClass('hasDatepicker');
   $('#date').datepicker({
       dateFormat: 'yy-mm-dd',
       onSelect: function(dateText, inst) {
           $(this).parent('frmDate').submit();
       }
   });
});
  </script>
</head>