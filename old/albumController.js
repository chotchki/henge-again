"use strict";
define(['angular', 'albumListService'], function(angular) {
  var mod = { moduleName: 'albumController' };
  var albumController = angular.module(mod.moduleName, ['albumListService']);
  albumController.controller('AlbumCtrl', ['$scope', 'Album',
    function($scope, Album){
      $scope.albums = Album.contents();
    }
  ]);

  return mod;
});
