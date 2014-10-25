"use strict";
define(['angular', 'angular-resource'], function(angular, resource){
  var mod = { moduleName: 'albumListService' };
  var albumListService = angular.module(mod.moduleName, ['ngResource']);

  albumListService.factory('Album', ['$resource',
    function($resource){
      return $resource('list.php', {}, {
        contents: {method: 'GET', isArray: true}
      });
    }
  ]);

  return mod;
});
