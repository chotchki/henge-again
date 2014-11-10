"use strict";
define(['angular', 'angular-resource'], function(angular, resource){
  var mod = { moduleName: 'service/albumInfo' };
  var albumInfo = angular.module(mod.moduleName, ['ngResource']);

  albumInfo.factory('AlbumInfo', ['$resource',
    function($resource){
      return $resource('/photos/api/albumInfo.php', {}, {
        next: {
          method: 'GET'
        }
      });
    }
  ]);

  return mod;
});
