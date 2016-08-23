<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tennis Court Schedule Pick A Date</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script> 
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <?php echo link_tag('assets/css/login-style.css'); ?>
  <?php echo link_tag('assets/css/menu.css'); ?> 
  <?php echo link_tag('assets/css/text-input.css'); ?>  

    <script>
    var app = angular.module('myApp', []);
    app.controller('formCtrl', function($scope) {
        $scope.master = {email:"", password : "", firstname:"", lastname:""};
        $scope.reset = function() {
            $scope.user = angular.copy($scope.master);
        };
        $scope.reset();
    });
    </script>

</head>

<body>

<div>
<ul>
  <li><a href="about">About</a></li>
  <li><a href="login">Login</a></li>
</div>

<form id='register' action='register' method='post'>
<table class="table-fill">
 <thead>
 <tr>
 <th class="text-left"></th>
 <th class="text-left"></th>
 </tr>
 </thead>
 <tbody>
 <tr><td>Email</td><td><input type="text" ng-model="user.email" name="email"/></td></tr>
 <tr><td>Firstname</td><td><input type="text" ng-model="user.firstname" name="firstname" /></td></tr>
 <tr><td>Lastname</td><td><input type="text" ng-model="user.lastname" name="lastname"/></td></tr>
 <tr><td>Password</td><td><input type="password" ng-model="user.password" name="password"/></td></tr>
 <tr><td colspan="2"><input type='submit' name='Submit' value='Submit' /></td></tr>
 </tbody>
 </table>
</form>


</div>

<?php
    if ( isset($message) ){
        echo $message;
    }
?>

</body>
</html>