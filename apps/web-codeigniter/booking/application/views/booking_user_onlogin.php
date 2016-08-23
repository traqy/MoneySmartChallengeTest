<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <?php echo link_tag('assets/css/booking-webapp-table.css'); ?>
  <?php echo link_tag('assets/css/menu.css'); ?>

</head>

<body>
<div>
<form id="frmDate" name="frmDate" action="home/test" method="post">
<ul>
  <li><a href="about">About</a></li>
  <li><a href="signup">Sign Up</a></li>
  </form>
</div>

<div>
<?php
    if ( isset($message) ){
        echo $message;
    }
?>
</div>

<div>
  <form id='loginForm' action='login' method='post' accept-charset='UTF-8'>
        <label>Email</label>
        <input type="text"  name="email"/>
        <label>Password:</label>
        <input id="password" type="password" name="password"/>
        <input id="submit" type='submit' name='Submit' value='Login' />
  </form>
</div>

</body>
</html>