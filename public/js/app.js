(function () {
    var app = angular.module("mockup", ['ngTouch', 'infinite-scroll']);
    
    app.controller('DashboardController', ['$http', function (http) {
            var dashboard = this;
            dashboard.page = 0;
            dashboard.activeFilter = 0;
            dashboard.menuState = false;
            dashboard.filters = [{"name": "All"}, {"name": "News"}, {"name": "Photos"}, {"name": "Videos"}];
            dashboard.feeds = [];
            dashboard.model={};
            dashboard.isActive = function (i) {
                return i === dashboard.activeFilter;
            };
            dashboard.activeFilterName = function () {
                return dashboard.filters[dashboard.activeFilter].name;
            };
            dashboard.setActiveFilter = function (i) {
                dashboard.activeFilter = i;
            };
            dashboard.toggleMenu = function () {
                dashboard.menuState = !dashboard.menuState;
            };
            dashboard.moreFeed = function () {
                http.post('/dashboard/feeds/' + dashboard.page, dashboard.model)
                        .success(function (data) { 
                            for (var i = 0; i < data.result.length; i++) {
                                dashboard.feeds.push(data.result[i]);
                            }
                            if (data.result.length)
                                dashboard.page++;
                        });
            };
        }]);
    
    app.controller('SearchController', ['$http', function(http){
        var search=this;
        search.filter="";
        search.submit = function(keyEvent, dashboard) {
            if(keyEvent.which !== 13) return;
            
            dashboard.page=0;
            dashboard.feeds=[];
            dashboard.moreFeed();
        };
        
    }]);
    
    app.controller('ProfileController', ['$http', function (http) {
            var form = this;
            form.profile = {};
            form.alert = {
                hide: 1
            };
            form.submit = function () {
                http.post('/profile', form.profile, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            form.alert.hide = 0;
                            form.alert.message = data.result;
                            if (data.error) {
                                form.alert.type = 'alert-danger';
                            } else {
                                form.alert.type = 'alert-success';
                                form.profile = {name: data.result.name};
                            }
                        });
            };
        }]);
    app.controller('ChannelsController', ['$http', function (http) {

            var form = this;
            form.channel = {};
            form.channels = [];
            form.alert = {
                hide: 1
            };
            form.load = function () {
                http.get('profile/channels').success(function (data) {
                    form.channels = data.result;
                });
            };
            form.unsubscribe = function (id, dashboard) {
                form.channels.splice(id, 1);
                http.post('/profile/channels-update', {'channels': form.channels}, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            form.channels = data.result;
                            dashboard.page = 0;
                            dashboard.feeds = [];
                            dashboard.moreFeed();
                        });
            };
            form.submit = function (dashboard) {
                http.post('/profile/channels', form.channel, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            form.alert.hide = 0;
                            form.alert.message = data.result;
                            form.channel = {};
                            if (data.error) {
                                form.alert.type = 'alert-danger';
                            } else {
                                form.alert.type = 'alert-success';
                                form.channels = data.result;
                                dashboard.page = 0;
                                dashboard.feeds = [];
                                dashboard.moreFeed();
                            }
                        });
            };

        }]);
})();
