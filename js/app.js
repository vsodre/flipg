(function () {
    var app = angular.module("mockup", ['ngTouch']);
    app.controller('DashboardController', ['$http', function (http) {
        var dashboard = this;
        dashboard.activeFilter = 0;
        dashboard.menuState = false;
        dashboard.filters = [{"name":"All"}, {"name":"Personal Filter 1"}, {"name":"Personal Filter 2"}, {"name":"Personal Filter 3"}];
        dashboard.feeds = [];
        dashboard.isActive = function(i){
            return i == dashboard.activeFilter;
        };
        dashboard.activeFilterName = function(){
            return dashboard.filters[dashboard.activeFilter].name;
        };
        dashboard.setActiveFilter = function(i){
            dashboard.activeFilter = i;
        };
        dashboard.toggleMenu = function(){
           dashboard.menuState = !dashboard.menuState; 
        };
        http.get('data/only-text.json').success(function(data){dashboard.feeds = data});
    }]);
})();