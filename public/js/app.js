(function () {
    var app = angular.module("mockup", ['ngTouch', 'infinite-scroll']);

    app.controller('DashboardController', ['$http', function (http) {
            var dashboard = this;
            dashboard.page = 0;
            dashboard.activeFilter = 0;
            dashboard.menuState = false;
            dashboard.filters = [{"name": "All"}, {"name": "News"}, {"name": "Photos"}, {"name": "Videos"}];
            dashboard.feeds = [];
            dashboard.model = {};
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

    app.controller('SearchController', ['$http', '$timeout', function (http, timeout) {
            var search = this;
            search.filter = "";
            search.delta = 0;
            search.typer = function (dashboard) {
                if (search.delta < 3) {
                    search.delta++;
                    timeout(function () {
                        search.timer(dashboard);
                    }, 500);
                }
            };
            search.timer = function (dashboard) {
                search.delta--;
                if (search.delta === 0) {
                    search.submit(dashboard);
                }
            };
            search.submit = function (dashboard) {
                dashboard.page = 0;
                dashboard.feeds = [];
                dashboard.moreFeed();
            };

        }]);

    app.controller('ProfileController', ['$http', '$timeout', function (http, timeout) {
            var form = this;
            form.profile = {};
            form.alert = {
                hide: 1
            };
            form.submit = function () {
                http.post('/profile', form.profile, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            form.alert.hide = 0;
                            if (data.error) {
                                var m = '';
                                form.alert.type = 'alert-danger';
                                for(var key in data.result){
                                    m += '<p><b>' + key + '</b>: ' + data.result[key].join(' ')+"</p>";
                                }
                                form.alert.message = m;
                            } else {
                                form.alert.type = 'alert-success';
                                form.alert.message = "Profile updated.";
                                form.profile = {name: data.result.name};
                            }
                            timeout(function(){
                                form.alert.hide = 1;
                            }, 4000);
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
                            timeout(function(){
                                form.alert.hide = 1;
                            }, 4000);
                        });
            };

        }]);
})();
