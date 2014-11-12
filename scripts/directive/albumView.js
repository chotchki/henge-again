"use strict";
define(['angular', 'directive/imgDelayLoad'], function(angular){
  var mod = { moduleName: 'directive/albumView' };
  
  angular.module(mod.moduleName, ['directive/imgDelayLoad'])

  .controller('albumViewController', ['$scope', function($scope){
  }])
  
  .directive('albumView', function(){
    return {
      restrict: 'E',
      scope: {
        album: "=",
        sizeRatio: "="  
      },
      controller: 'albumViewController',
      templateUrl: 'views/albumView.html'
    };
  });
  
  return mod;
});
