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
  <form id='login' action='login' method='post'
    accept-charset='UTF-8'>
    Email: <input type="text" ng-model="user.email" name="email"><br>
    Password: <input type="password" ng-model="user.password" name="password"><br>
    <br><br>
    <input type='submit' name='Submit' value='Login' />
  </form>
  <button ng-click="reset()">RESET</button>
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