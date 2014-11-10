"use strict";
define(['angular', 'albumListService'], function(angular){
  var mod = { moduleName: 'albumViewDirective' };
  var albumViewDirective = angular.module(mod.moduleName, ['albumListService']);

  albumViewDirective.controller('albumViewController', ['$scope', 'AlbumList', function($scope, AlbumList){
    AlbumList.subContents({album: $scope.album.name}, function(items){
    	var s = $scope;
    	s.items = items.slice(0, 7);	
    });
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
