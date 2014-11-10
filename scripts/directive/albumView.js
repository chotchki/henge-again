"use strict";
define(['angular', 'directive/imgDelayLoad'], function(angular){
  var mod = { moduleName: 'directive/albumView' };
  var albumViewDirective = angular.module(mod.moduleName, ['directive/imgDelayLoad']);

  albumViewDirective.controller('albumViewController', ['$scope', function($scope){
  }]);

  albumViewDirective.directive('albumView', function(){
    return {
      restrict: 'E',
      controller: 'albumViewController',
      templateUrl: 'views/albumView.html'
    };
  });
  return mod;
});
