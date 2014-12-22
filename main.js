"use strict";
require.config({
    baseUrl: "/photos/scripts",
    paths: {
        "angular": "//ajax.googleapis.com/ajax/libs/angularjs/1.3.8/angular",
        "angular-resource": "//ajax.googleapis.com/ajax/libs/angularjs/1.3.8/angular-resource",
        "domReady": "//cdnjs.cloudflare.com/ajax/libs/require-domReady/2.0.1/domReady",
        "ui-router": "//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.11/angular-ui-router"
    },
    shim: {
        "angular": {
            exports: "angular"
        },
        "angular-resource": {
            deps: ["angular"]
        },
        "ui-router": {
        	deps: ["angular"]
        }
    }
});

require(['domReady!', 'angular', 'app'], function (document, angular) {
  angular.bootstrap(document, ['app']);
});
