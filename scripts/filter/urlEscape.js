"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'filter/urlEscape' };
  
  angular.module(mod.moduleName, [])
  
  .filter('urlEscape', function ($window) {
	    return $window.encodeURIComponent;
  });
  
  return mod;
});