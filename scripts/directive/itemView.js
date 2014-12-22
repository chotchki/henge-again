"use strict";
define(['angular', 'ui-router', 'service/albumInfo'], function(angular){
  var mod = { moduleName: 'directive/itemView' };
  angular.module(mod.moduleName, ['service/albumInfo'])
	  
  .controller('itemViewController', ['$scope', '$stateParams', function($scope, $stateParams){
    $scope.item = $stateParams.item;
  }])

  .directive('itemView', function(){
    return {
      restrict: 'A',
      controller: 'itemViewController'
    };
  });
  return mod;
});