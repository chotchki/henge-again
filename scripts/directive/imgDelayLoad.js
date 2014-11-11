"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'directive/imgDelayLoad' };
  
  angular.module(mod.moduleName, [])

  .directive('imgDelayLoad', function(){
    return {
      restrict: 'E',
      scope: {
    	item: "="  
      },
      replace: true,
      template: '<img height="{{item.thumbHeight}}" width="{{item.thumbWidth}}"' +
      'ng-src="/photos/thumbs.php?name={{item.name | urlEscape}}&height={{item.thumbHeight | hidpi | urlEscape}}&width={{item.thumbWidth | hidpi | urlEscape}}" />'
    }
  });
  
  return mod;
});