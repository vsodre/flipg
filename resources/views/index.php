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
            <form class="navbar-form navbar-left" style="margin-left: 4%; width: 87%;">
                <div class="form-group" style="width: 100%;">
                    <div class="input-group">
                        <span class="input-group-addon" style="width:3.5%;"><span
                                class="glyphicon glyphicon-search"></span></span>
                        <input class="form-control" name="search" placeholder="Search Here" autocomplete="off"
                               type="text">
                    </div>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-left hidden-sm hidden-xs">
                <li id="menu-button">
                    <a href="#" role="button" tabindex="0" data-trigger="focus" data-toggle="popover">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </a></li>
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
            <ul class="grid">
                <li ng-repeat="feed in dashboard.feeds" class="bg-primary">
                    <div>
                        <h3>{{feed.title}}</h3>

                        <p>{{feed.text}}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="MyAccount" aria-hidden="true">
    <div class="modal-dialog" style="z-index: 2020;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Account</h4>
            </div>
            <div class="modal-body">
                <form class="" name="form_profle" role="form" ng-controller="ProfileController as ProfileCtrl" ng-submit="ProfileCtrl.submit()">
                    <div class="alert {{ProfileCtrl.alert.type}}" ng-hide="ProfileCtrl.alert.hide" role="alert">{{ProfileCtrl.alert.message}}</div>

                    <div class="form-group form-group-lg">
                        <label>Name</label>
                        <input type="text" ng-model="ProfileCtrl.profile.name" class="form-control" name="name" ng-init="ProfileCtrl.profile.name = '<?php echo $name ?>'">
                    </div>

                    <div class="form-group form-group-lg">
                        <label>Password</label>
                        <input type="password" ng-model="ProfileCtrl.profile.password" class="form-control" name="password">
                    </div>

                    <div class="form-group form-group-lg">
                        <label>Confirm Password</label>
                        <input type="password" ng-model="ProfileCtrl.profile.password_confirmation" class="form-control" name="password_confirmation">
                    </div>
                    <div class="form-group form-group-lg">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="channelsModal" tabindex="-1" role="dialog" aria-labelledby="MySubscriptions"
     aria-hidden="true">
    <div class="modal-dialog" style="z-index: 2020;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">My Channels</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/angular.js"></script>
<script type="text/javascript" src="js/angular-touch.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script>$(function () {
        $('[data-toggle="popover"]').popover({
            placement: "bottom",
            content: "<ul class=\"nav nav-sidebar\"><li><a href=\"#\" data-toggle=\"modal\" data-target=\"#accountModal\">Account</a></li><li><a href=\"#\" data-toggle=\"modal\" data-target=\"#channelsModal\">Channels</a></li><li><a href=\"/auth/logout\">Logout</a></li></ul>",
            html: true
        });
    });        </script>
</body>
</html>