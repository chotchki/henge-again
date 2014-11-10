"use strict";
define(['angular', 'directive/albumLoader', 'directive/albumView', 'filter/hidpi', 'filter/urlEscape'], function(angular) {
  var mod = { moduleName: 'app' };
  var photoDirApp = angular.module(mod.moduleName, ['directive/albumLoader', 'directive/albumView', 'filter/hidpi', 'filter/urlEscape']);
  return mod;
});