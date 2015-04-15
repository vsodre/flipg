<!DOCTYPE html>
<html ng-app="mockup" lang="en">
    <head>
        <title>Password page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="http://getbootstrap.com/favicon.ico">
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <style>
            body, html{ height: 100%; }
        </style>
    </head>
    <body>
        <div id="main" class="stk-footer">
            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">
                            FlipG
                        </a>
                    </div>
                </div>
            </nav>
            <div class="container navbar-spacer">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <?php if (count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    <?php foreach ($errors->all() as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form role="form" method="POST" action="<?php echo url('/password/email'); ?>">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                                    <div class="form-group form-group-lg">
                                        <label>E-Mail Address</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo old('email'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Send Password Reset Link
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/js/angular.js"></script>
        <script type="text/javascript" src="/js/angular-touch.js"></script>
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/jquery-2.1.3.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    </body>
</html>
