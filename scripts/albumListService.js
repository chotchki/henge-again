"use strict";
define(['angular', 'angular-resource'], function(angular, resource){
  var mod = { moduleName: 'albumListService' };
  var albumListService = angular.module(mod.moduleName, ['ngResource']);

  albumListService.factory('AlbumList', ['$resource',
    function($resource){
      return $resource('list.php', {}, {
        contents: {
          method: 'GET', 
          isArray: true
        },
        subContents: {
          method: 'GET',
          params: {
            album: '@album'
          },
          isArray: true
        }
      });
    }
  ]);

  return mod;
});
