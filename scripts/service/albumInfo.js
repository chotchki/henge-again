"use strict";
define(['angular', 'angular-resource'], function(angular, resource){
  var mod = { moduleName: 'service/albumInfo' };
  
  angular.module(mod.moduleName, ['ngResource'])

  .factory('AlbumInfo', ['$resource',
    function($resource){
      return $resource('/photos/api/albumInfo.php', {}, {
        getFirst: {
          method: 'GET',
          isArray: true,
          responseType: 'json'
        },
        getNext: {
          params: {next: true},
          method: 'GET',
          isArray: true
        },
        getPrevious: {
          params: {previous: true},
          method: 'GET',
          isArray: true
        },
        getAll: {
          params: {all: true},
          method: 'GET',
          isArray: true
        }
      });
    }
  ]);

  return mod;
});
