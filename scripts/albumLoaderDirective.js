"use strict";
define(['angular'], function(angular){
  var mod = { moduleName: 'albumLoaderDirective' };
  var albumLoaderDirective = angular.module(mod.moduleName, ['albumListService']);

  albumLoaderDirective.controller('albumLoaderController', ['$scope', 'AlbumList', function($scope, AlbumList){
	$scope.raw_albums = AlbumList.contents();
	$scope.albums = $scope.raw_albums.slice(0, 5);
  }]);

  albumLoaderDirective.directive('albumLoader', function(){
    return {
      restrict: 'A',
      controller: 'albumLoaderController',
      transclude: true
    };
  });
  return mod;
});
