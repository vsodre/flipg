(function () {
    var app = angular.module("mockup", ['ngTouch', 'infinite-scroll', 'ui.bootstrap']);

    app.controller('DashboardController', ['$http', '$modal', function (http, modal) {
            var dashboard = this;
            dashboard.page = 0;
            dashboard.activeFilter = 0;
            dashboard.menuState = false;
            dashboard.filters = [{"name": "All"}, {"name": "News"}, {"name": "Photos"}, {"name": "Videos"}];
            dashboard.feeds = [];
            dashboard.model = {};
            dashboard.openAccountForm = function () {
                modal.open({
                    templateUrl: 'templates/account.form.tpl.html',
                    controller: 'ProfileController as ProfileCtrl'
                });
            };
            dashboard.openChannelsForm = function () {
                modal.open({
                    templateUrl: 'templates/channels.form.tpl.html',
                    controller: 'ChannelsController as ChannelCtrl',
                    resolve: {
                        dashboard: function () {
                            return dashboard;
                        }
                    }
                });
            };
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

    app.controller('ProfileController', ['$http', '$modalInstance', function (http, modal) {
            var form = this;
            form.profile = {};
            form.alerts = [];
            form.submit = function () {
                http.post('/profile', form.profile, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            if (data.error) {
                                var m = '';
                                for (var key in data.result) {
                                    m += key + ': ' + data.result[key].join(' ');
                                }
                                form.alerts.push({type: 'danger', message: m});
                            } else {
                                form.alerts.push({type: 'success', message: "Profile updated."});
                                form.profile = {name: data.result.name};
                            }
                        });
            };
            form.close = function () {
                modal.dismiss('');
            };
            http.get('/profile').success(function (data) {
                form.profile.name = data.result.name;
            });
        }]);
    app.controller('ChannelsController', ['$http', '$modalInstance', 'dashboard', '$timeout', function (http, modal, dashboard, timeout) {
            var form = this;
            form.channel = {};
            form.channels = [];
            form.alerts = [];
            form.setAlert = function(alert){
                form.alerts.push(alert);
                /*timeout(function(){
                    form.alerts.splice(form.alerts.length-1, 1);
                }, 4000);*/
            };
            form.load = function () {
                http.get('profile/channels').success(function (data) {
                    form.channels = data.result;
                });
            };
            form.unsubscribe = function (id) {
                form.channels.splice(id, 1);
                http.post('/profile/channels-update', {'channels': form.channels}, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            if(!data.error) form.alerts.push({type:'success', message:'Channel removed.'});
                            form.channels = data.result;
                            dashboard.page = 0;
                            dashboard.feeds = [];
                            dashboard.moreFeed();
                        });
            };
            form.submit = function () {
                http.post('/profile/channels', form.channel, {'Content-Type': 'application/x-www-form-urlencoded'})
                        .success(function (data) {
                            form.channel = {};
                            if (data.error) {
                                form.alerts.push({type: 'danger', message: 'Address: ' + data.result.address.join(' ')});
                            } else {
                                form.alerts.push({type: 'success', message: 'Channel added successfully.'});
                                form.channels = data.result;
                                dashboard.page = 0;
                                dashboard.feeds = [];
                                dashboard.moreFeed();
                            }
                        });
            };
            form.close = function () {
                modal.dismiss('');
            };
            http.get('/profile/channels').success(function (data) {
                form.channels = data.result.name;
            });
        }]);
})();
