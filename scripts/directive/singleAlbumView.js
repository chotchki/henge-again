"use strict";
define(['angular', 'ui-router'], function(angular){
  var mod = { moduleName: 'directive/singleAlbumView' };
  angular.module(mod.moduleName, ['service/albumInfo'])
	  
  .controller('singleAlbumViewController', ['$scope', '$stateParams', 'AlbumInfo', function($scope, $stateParams, AlbumInfo){
    $scope.album = [];
		
    $scope.loading = true;
  
    AlbumInfo.getFirst({album: $stateParams.album}, function(album){
      var s = $scope;
      s.album = album[0];
      s.loading = false;
	});
  }])

  .directive('singleAlbumView', function(){
    return {
      restrict: 'A',
      controller: 'singleAlbumViewController',
      replace: true
    };
  });
  return mod;
});