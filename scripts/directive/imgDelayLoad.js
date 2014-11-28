"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'directive/imgDelayLoad' };
  
  angular.module(mod.moduleName, [])

  .directive('imgDelayLoad', function(){
    return {
      restrict: 'E',
      scope: {
    	item: "=",
    	sizeRatio: "="
      },
      replace: true,
      template: '<img height="{{item.thumbHeight * sizeRatio}}" width="{{item.thumbWidth * sizeRatio}}"' +
      'ng-src="/photos/api/thumbs.php?name={{item.name | urlEscape}}&height={{item.thumbHeight * sizeRatio | hidpi | urlEscape}}&width={{item.thumbWidth * sizeRatio | hidpi | urlEscape}}" />'
    }
  });
  
  return mod;
});