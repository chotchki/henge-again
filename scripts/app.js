"use strict";
define(['angular',  'albumLoaderDirective', 'albumViewDirective'], function(angular) {
  var mod = { moduleName: 'app' };
  var photoDirApp = angular.module(mod.moduleName, ['albumCollectionDirective', 'albumLoaderDirective', 'albumViewDirective']);
  return mod;
});
