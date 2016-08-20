<!DOCTYPE html>
<html lang="en">
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body>
<?php
    if ( isset($message) ){
        echo $message;
    }
?>
<div ng-app="myApp" ng-controller="formCtrl">
  <form id='register' action='register' method='post'
    accept-charset='UTF-8'>
    SIGN UP FORM:<br>
    Email: <input type="text" ng-model="user.email" name="email"><br>
    Password: <input type="password" ng-model="user.password" name="password"><br>
    First Name: <input type="text" ng-model="user.firstname" name="firstname"><br>
    Last Name: <input type="text" ng-model="user.lastname" name="lastname"><br>
    <br><br>
    <input type='submit' name='Submit' value='Submit' />
  </form>
  <button ng-click="reset()">RESET</button>
</div>

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

</body>
</html>