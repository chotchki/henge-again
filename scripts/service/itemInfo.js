"use strict";
define(['angular', 'angular-resource'], function(angular, resource){
  var mod = { moduleName: 'service/itemInfo' };
  
  angular.module(mod.moduleName, ['ngResource'])

  .factory('ItemInfo', ['$resource',
    function($resource){
      return $resource('/photos/api/itemInfo.php', {}, {
        get: {
          method: 'GET',
          isArray: false,
          responseType: 'json'
        }
      });
    }
  ]);

  return mod;
});
