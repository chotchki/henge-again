"use strict";
define(['angular', 'directive/albumLoader', 'directive/albumView', 'filter/urlEscape'], function(angular) {
  var mod = { moduleName: 'app' };
  var photoDirApp = angular.module(mod.moduleName, ['directive/albumLoader', 'directive/albumView', 'filter/urlEscape']);
  return mod;
});