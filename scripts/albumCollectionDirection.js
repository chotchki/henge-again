"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'albumCollectionDirective' };
  var albumCollectionDirective = angular.module(mod.moduleName, []);

  albumCollectionDirective.controller('albumCollectionController', ['$scope', function($scope){
  }]);

  albumViewDirective.directive('albumCollection', function(){
    return {
      restrict: 'E',
      scope: {
    	  collection: '='
      },
      controller: 'albumCollectionController'
    };
  });
  return mod;
});
