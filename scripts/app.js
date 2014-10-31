"use strict";
define(['angular',  'albumLoaderDirective', 'albumViewDirective'], function(angular) {
  var mod = { moduleName: 'app' };
  var photoDirApp = angular.module(mod.moduleName, ['albumLoaderDirective', 'albumViewDirective']);
  return mod;
});