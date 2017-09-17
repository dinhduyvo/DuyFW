
angular.module('canthobox.main').controller('LoginController', function ($scope, $http) {
  $scope.successDisplay = "none";
  $scope.failDisplay = "none";
  $scope.failReason = "";
  $scope.loginData = {};

  this.login = function (myurl) {
    var formData = {
        'identity'              : $('input[id=identity]').val(),
        'password'    : $('input[id=password]').val()
    };
    $http({
      method: 'POST',
      url: myurl,
      data: $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function successCallback(response) {
        if(response.data == "1"){
          $( location ).attr("href", $( location ).attr("href"));
          $scope.successDisplay = "block";
          $scope.failDisplay = "none";
        }
        else{
          $scope.failDisplay = "block";
          $scope.failReason = response.data;
          $scope.successDisplay = "none";
        }
      }, function errorCallback(response) {
        alert("Cannot connect to server!");
      });
  };

  this.cancel = function () {
    $scope.email = "";
    $scope.password = "";
  };

});

// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.

angular.module('canthobox.main').controller('ModalInstanceCtrl', function ($uibModalInstance, $scope, $http) {
  $scope.email = "";
  $scope.password = "";
  $scope.successDisplay = "none";
  $scope.failDisplay = "none";
  $scope.failReason = "";
  var $ctrl = this;

});
