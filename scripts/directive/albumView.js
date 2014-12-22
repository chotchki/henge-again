"use strict";
define(['angular', 'ui-router', 'directive/imgDelayLoad'], function(angular){
  var mod = { moduleName: 'directive/albumView' };
  
  angular.module(mod.moduleName, ['ui.router', 'directive/imgDelayLoad'])

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
      templateUrl: 'scripts/directive/views/albumView.html'
    };
  });
  
  return mod;
});
