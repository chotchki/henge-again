"use strict";
define(['angular', 'albumController'], function(angular) {
  var mod = { moduleName: 'app' };
  var photoDirApp = angular.module(mod.moduleName, ['albumController']);
  return mod;
});
