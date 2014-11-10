"use strict";
define(['angular', 'albumListService'], function(angular){
  var mod = { moduleName: 'albumLoaderDirective' };
  var albumLoaderDirective = angular.module(mod.moduleName, ['albumListService']);

  
  albumLoaderDirective.controller('albumLoaderController', ['$scope', 'AlbumList', function($scope, AlbumList){
	AlbumList.contents(function(albums){
		var s = $scope;
		
		s.bottom_albums = albums;
		s.top_albums = [];
		
		s.albums = [];
		s.albums.push(s.bottom_albums.shift());
		s.albums.push(s.bottom_albums.shift());
	});
  }]);

  albumLoaderDirective.directive('albumLoader', function($window){
    return {
      restrict: 'A',
      controller: 'albumLoaderController',
      replace: true,
      link: function (scope, elem, attrs) {
        var windowEl = angular.element($window);
        var rawElement = elem[0];
        windowEl.bind('scroll', function () {
          var scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
          var scrolledToBottom = (scrollTop + window.innerHeight) >= ((document.documentElement && document.documentElement.scrollHeight) || document.body.scrollHeight);
          if(scrolledToBottom){
            if(scope.bottom_albums.length > 0){
              scope.$apply(scope.albums.push(scope.bottom_albums.shift()));
            }
                  
            if(scope.albums.length > 5){
              scope.$apply(scope.top_albums.push(scope.albums.shift()));
            }
            
            return; //Only top or bottom can fire
          }
              
          var scrolledToTop = scrollTop === 0;
          if(scrolledToTop){
            if(scope.top_albums.length > 0){
              scope.$apply(scope.albums.unshift(scope.top_albums.pop()));
            }
            	  
            if(scope.albums.length > 5){
              scope.$apply(scope.bottom_albums.unshift(scope.albums.pop()));
            }
          }
        });
      }
    };
  });
  return mod;
});