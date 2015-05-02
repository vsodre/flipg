<!DOCTYPE html>
<html ng-app="mockup" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="http://getbootstrap.com/favicon.ico">

        <title>FlipG Dashboard</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

    </head>

    <body ng-controller="DashboardController as dashboard">

        <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" id="navbar-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">FlipG</a>
                </div>
                <div class="collapse navbar-collapse">
                    <form role="form" class="navbar-form navbar-left" style="width: 83%;" ng-controller="SearchController as SearchCtrl">
                        <div class="form-group" style="width: 100%;">
                            <div class="input-group">
                                <span class="input-group-addon" style="width:3.5%;"><span
                                        class="glyphicon glyphicon-search"></span></span>
                                <input class="form-control" name="search" placeholder="Search Here" autocomplete="off"
                                       type="text" ng-model="dashboard.model.searchFilter" ng-keyup="SearchCtrl.typer(dashboard)">
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-left hidden-sm hidden-xs">
                        <li id="menu-button" dropdown>
                            <a href="#" role="button" tabindex="0" dropdown-toggle>
                                <span class="glyphicon glyphicon-menu-hamburger"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" ng-click="dashboard.openAccountForm()">Account</a></li>
                                <li><a href="#" ng-click="dashboard.openChannelsForm()">Channels</a></li>
                                <li><a href="/auth/logout">Logout</a></li>
                            </ul></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container navbar-spacer">
            <div class="row">
                <div id="dashboard-tabs">
                    <ul class="nav nav-pills">
                        <li role="presentation" ng-repeat="f in dashboard.filters" ng-click="dashboard.setActiveFilter($index)"
                            ng-class="{active:dashboard.isActive($index)}"><a href="#">{{f.name}}</a></li>
                    </ul>
                </div>
                <div class="main">
                    <ul class="grid" infinite-scroll="dashboard.moreFeed()" infinite-scroll-distance="3">
                        <li ng-repeat="feed in dashboard.feeds" class="bg-primary">
                            <div>
                                <h3><a href="{{feed.permalink}}" target="_blank">{{feed.title}}</a></h3>

                                <p><a href="{{feed.permalink}}" target="_blank">{{feed.body}}</a></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
        <script type="text/javascript" src="js/angular.js"></script>
        <script type="text/javascript" src="js/ng-infinite-scroll.js"></script>
        <script type="text/javascript" src="js/angular-touch.js"></script>
        <script type="text/javascript" src="js/ui-bootstrap.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>
