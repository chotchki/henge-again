"use strict";
define(['angular', 'ui-router'], function(angular){
  var mod = { moduleName: 'routes/routes' };
  angular.module(mod.moduleName, ['ui.router'])
  
  .run(['$rootScope', '$state', '$stateParams', function($rootScope, $state, $stateParams){
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams
  }])

  .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
    $urlRouterProvider.otherwise('/');
	  
    $stateProvider
      .state("stream", {
        url: "/",
        templateUrl: 'views/albumStream.html',
        data : { pageTitle: 'Album Stream'}
      })
      .state("album", {
        url: "/album/:album",
        templateUrl: 'views/singleAlbumView.html',
        data : { pageTitle: 'Album View'}
      });
  }]);

  return mod;
});
