"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'filter/hidpi' };
  var hidpi = angular.module(mod.moduleName, []);
  
  hidpi.filter('hidpi', function () {
	    if(window.devicePixelRatio > 1){
	    	return function(input){
	    		return input * 2;
	    	}
	    } else {
	    	return function(input){
	    		return input;
	    	}
	    }
  });
  
  return mod;
});