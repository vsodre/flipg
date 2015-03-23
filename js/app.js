(function () {
    var app = angular.module("mockup", ['ngTouch']);
    app.controller('DashboardController', ['$http', function (http) {
        var dashboard = this;
        dashboard.feeds = [];
        dashboard.menuState = false;
        dashboard.toggleMenu = function(){
           dashboard.menuState = !dashboard.menuState; 
        };
        http.get('data/only-text.json').success(function(data){dashboard.feeds = data});
    }]);
})();