"use strict";
define(['angular', 'albumListService'], function(angular){
  var mod = { moduleName: 'albumViewDirective' };
  var albumViewDirective = angular.module(mod.moduleName, ['albumListService']);

  albumViewDirective.controller('albumViewController', ['$scope', 'AlbumList', function($scope, AlbumList){
    $scope.items = AlbumList.subContents({album: $scope.album.name});
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
