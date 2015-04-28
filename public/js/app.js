(function () {
    var app = angular.module("mockup", ['ngTouch']);
    app.controller('DashboardController', ['$http', function (http) {
        var dashboard = this;
        dashboard.activeFilter = 0;
        dashboard.menuState = false;
        dashboard.filters = [{"name":"All"}, {"name":"News"}, {"name":"Photos"}, {"name":"Videos"}];
        dashboard.feeds = [];
        dashboard.isActive = function(i){
            return i === dashboard.activeFilter;
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
    app.controller('ProfileController', ['$http', function (http){
        var form = this;
        form.profile = {};
        form.alert = {
            hide : 1
        };
        form.submit = function(){
            http.post('/profile', form.profile, {'Content-Type': 'application/x-www-form-urlencoded'})
                    .success(function(data){
                        form.alert.hide = 0;
                        form.alert.message = data.result;
                        if(data.error){
                            form.alert.type = 'alert-danger'
                        } else {
                            form.alert.type = 'alert-success'
                            form.profile = {name:data.result.name};
                        }
                    });
        };
    }]);
})();