"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'filter/urlEscape' };
  var urlEscape = angular.module(mod.moduleName, []);
  
  urlEscape.filter('urlEscape', function ($window) {
	    return $window.encodeURIComponent;
  });
  
  return mod;
});