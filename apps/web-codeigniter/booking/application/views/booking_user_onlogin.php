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
  <?php echo link_tag('assets/css/booking-webapp-table.css'); ?>
  <?php echo link_tag('assets/css/menu.css'); ?>  
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>

<body>
<div>
<form id="frmDate" name="frmDate" action="home/test" method="post">
<ul>
  <li><a href="#About">About</a></li>
  <li><a href="signup">Sign Up</a></li>
  </form>
</div>

<?php
    if ( isset($message) ){
        echo $message;
    }
?>
<div ng-app="myApp" ng-controller="formCtrl">
  <form id='login' action='login' method='post'
    accept-charset='UTF-8'>
    Email: <input type="text" ng-model="user.email" name="email"><br>
    Password: <input type="password" ng-model="user.password" name="password"><br>
    <input type='submit' name='Submit' value='Login' />
  </form>
</div>

<script>
var app = angular.module('myApp', []);
app.controller('formCtrl', function($scope) {
    $scope.master = {email:"", password : ""};
    $scope.reset = function() {
        $scope.user = angular.copy($scope.master);
    };
    $scope.reset();
});
</script>
</body>
</html>