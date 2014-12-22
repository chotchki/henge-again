"use strict";
define(['angular', 'ui-router', 'service/itemInfo'], function(angular){
  var mod = { moduleName: 'directive/singleItemView' };
  angular.module(mod.moduleName, ['ui.router', 'service/itemInfo'])
	  
  .controller('singleItemViewController', ['$scope', '$stateParams', 'ItemInfo', function($scope, $stateParams, ItemInfo){
    $scope.item = [];
    
    $scope.loading = true;
    
    ItemInfo.get({item: $stateParams.item}, function(item){
      var s = $scope;
      s.item = item;
      s.loading = false;
	});
  }])

  .directive('singleItemView', function(){
    return {
      restrict: 'A',
      controller: 'singleItemViewController',
      replace: true
    };
  });
  return mod;
});