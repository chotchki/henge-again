"use strict";
define(['angular', 'service/albumInfo'], function(angular){
  var mod = { moduleName: 'directive/albumLoader' };
  var albumLoader = angular.module(mod.moduleName, ['service/albumInfo']);

  
  albumLoader.controller('albumLoaderController', ['$scope', 'AlbumInfo', function($scope, AlbumInfo){
	$scope.albums = [];
	
	$scope.loading = false;
	
	$scope.loadNextAlbum = function(){
		var a = AlbumInfo;
		var s = $scope;
		
		if(s.loading == true){
			return;
		}
		
		s.loading = true;
		
		if(s.albums.length == 0){
			a.next(function(album){
	            var s2 = s;
	            s2.albums.push(album);
	            s2.loading = false;
			});
		} else {
		  a.next({current: s.albums[s.albums.length - 1].name}, function(album){
            var s2 = s;
            s2.albums.push(album);
            s2.loading = false;
		  });
		}
	}
	
	$scope.loadNextAlbum();
  }]);

  albumLoader.directive('albumLoader', ['$window', 'AlbumInfo', function($window, AlbumInfo){
    return {
      restrict: 'A',
      controller: 'albumLoaderController',
      replace: true,
      link: function (scope, elem, attrs) {
        var windowEl = angular.element($window);
        var rawElement = elem[0];
        
        windowEl.bind('scroll', function () {
          var a = AlbumInfo;
          var s = scope;
          
          var scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
          var scrolledToBottom = (scrollTop + window.innerHeight) >= ((document.documentElement && document.documentElement.scrollHeight) || document.body.scrollHeight);
          if(scrolledToBottom){
            s.loadNextAlbum();
          }
        });
      }
    };
  }]);
  return mod;
});