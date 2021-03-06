"use strict";
define(['angular', 'service/albumInfo'], function(angular){
  var mod = { moduleName: 'directive/albumLoader' };
  
  angular.module(mod.moduleName, ['service/albumInfo'])
  
  .controller('albumLoaderController', ['$scope', 'AlbumInfo', function($scope, AlbumInfo){
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
			a.getFirst(function(album){
	            var s2 = s;
	            s2.albums = s2.albums.concat(album);
	            s2.loading = false;
	            s2.loadNextAlbum(); //Since one album is not enough!
			});
		} else {
		  a.getNext({album: s.albums[s.albums.length - 1].name}, function(album){
            var s2 = s;
            s2.albums = s2.albums.concat(album);
            s2.loading = false;
		  });
		}
	}
	
	$scope.loadNextAlbum();
  }])

  .directive('albumLoader', ['$window', 'AlbumInfo', function($window, AlbumInfo){
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