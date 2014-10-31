"use strict";
define(['angular', 'albumListService'], function(angular){
  var mod = { moduleName: 'albumLoaderDirective' };
  var albumLoaderDirective = angular.module(mod.moduleName, ['albumListService']);

  
  albumLoaderDirective.controller('albumLoaderController', ['$scope', 'AlbumList', function($scope, AlbumList){
	AlbumList.contents(function(albums){
		var s = $scope;
		s.all_albums = albums;
		s.albums = albums.slice(0,5);
	});
  }]);

  albumLoaderDirective.directive('albumLoader', function(){
    return {
      restrict: 'A',
      controller: 'albumLoaderController',
      replace: true
    };
  });
  return mod;
});
