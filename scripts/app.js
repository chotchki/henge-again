"use strict";
define(['angular',
        
        'directive/albumLoader', 
        'directive/albumView',
        'directive/singleAlbumView',
        'directive/timelineLoader',
        
        'filter/hidpi', 
        'filter/urlEscape',
        
        'routes/routes'], function(angular) {
  var mod = { moduleName: 'app' };
  angular.module(mod.moduleName, ['ui.router',
                                  
                                  'directive/albumLoader', 
                                  'directive/albumView',
                                  'directive/singleAlbumView',
                                  'directive/timelineLoader',
                                  
                                  'filter/hidpi', 
                                  'filter/urlEscape',
                                  
                                  'routes/routes']);
  return mod;
});