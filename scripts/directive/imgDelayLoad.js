"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'directive/imgDelayLoad' };
  var albumLoader = angular.module(mod.moduleName, []);

  albumLoader.directive('imgDelayLoad', function(){
    return {
      restrict: 'E',
      scope: {
    	item: "="  
      },
      replace: true,
      template: '<img height="{{item.thumbHeight}}" width="{{item.thumbWidth}}"' +
      'ng-src="/photos/thumbs.php?name={{item.name | urlEscape}}&height={{item.thumbHeight | urlEscape}}&width={{item.thumbWidth | urlEscape}}" />'
    }
  });
  
  return mod;
});