"use strict";
define(['angular', 'service/albumInfo'], function(angular){
  var mod = { moduleName: 'directive/timelineLoader' };
  
  angular.module(mod.moduleName, ['service/albumInfo'])
  
  .controller('timelineLoaderController', ['$scope', 'AlbumInfo', function($scope, AlbumInfo){
	$scope.albums = [];
	
	$scope.loading = false;
	
	$scope.loadAllAlbums = function(){
		var a = AlbumInfo;
		var s = $scope;
		
		if(s.loading == true){
			return;
		}
		
		s.loading = true;
		
		a.getAll(function(albums){
			var s2 = s;
			s2.albums = albums;
			s2.loading = false;
		});
	};
	
	$scope.loadAllAlbums();
  }])

  .directive('timelineLoader', ['$window', 'AlbumInfo', function($window, AlbumInfo){
    return {
      restrict: 'A',
      controller: 'timelineLoaderController',
      replace: true
    };
  }]);
  return mod;
});