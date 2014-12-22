"use strict";
define(['angular', 'ui-router'], function(angular){
  var mod = { moduleName: 'directive/imgDelayLoad' };
  
  angular.module(mod.moduleName, ['ui.router'])

  .directive('imgDelayLoad', function(){
    return {
      restrict: 'E',
      scope: {
    	item: "=",
    	sizeRatio: "="
      },
      replace: true,
      templateUrl: "scripts/directive/views/imgDelayLoad.html"
    }
  });
  
  return mod;
});