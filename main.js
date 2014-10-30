"use strict";
require.config({
    baseUrl: "/photos/scripts",
    paths: {
        "angular": "//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular",
        "angular-resource": "//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular-resource",
        "domReady": "//cdnjs.cloudflare.com/ajax/libs/require-domReady/2.0.1/domReady"
    },
    shim: {
        "angular": {
            exports: "angular"
        },
        "angular-resource": {
            deps: ["angular"],
        },
    }
});

require(['domReady!', 'angular', 'app'], function (document, angular) {
  angular.bootstrap(document, ['app']);
});