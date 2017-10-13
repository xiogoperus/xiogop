<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Real Tech Project</title>
<link rel="stylesheet" href="./css/main.css">
<base href="/public" />
</head>
<body>
<header>
    <div class="top">
        <div class="container-fluid container-max">
            <nav class="navbar margin-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle transition" data-toggle="collapse" data-target="#mainNavbar">
                        <span class="fa fa-list"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <div class="display-table display-table-fill">
                        <div class="display-row">
                            <div class="display-cell display-table-sm-reset">
                                <ul class="navi nav_justified">
                                    <li class="navigation-item" ng-repeat="menu in menuList" ui-sref-active="active">
                                        <a ui-sref="{{menu.sref}}" ng-bind="menu.caption"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="display-cell display-table-sm-reset">
                                <div class="pull-right">
                                    <form action="/search/" class="navbar-form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="questions" required="required" maxlength="50" class="form-control" placeholder="Поиск...">
                                                <div class="input-group-btn">
                                                    <button type="submit" name="submit" class="btn btn-default">
                                                        <span class="glyphicon glyphicon-search">
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="bot">
        <div class="container-fluid container-max logos">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <a href="/">
                        <img src="./img/logo2.png" alt="">
                    </a>
                    <!-- <a class="navbar-brand" ui-sref=".^.menufull.main" ui-sref-opts="{ reload: true }">
                        <div class="logo">
                            <img ng-if="globalPG.logo" style="background-image: url({{ globalPG.logo + '/178x82' }})" src="./img/pixel.png" alt />
                            <img ng-if="!globalPG.logo" src="./img/pixel.png" alt />
                        </div>
                    </a> -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 order">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <span class="glyphicon glyphicon-phone-alt"></span>
                        <i data-toggle="modal" data-target="#orderphone">заказать звонок</i>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <span class="glyphicon glyphicon-phone-alt"></span>
                        <i data-toggle="modal" data-target="#orderphone">оставить заявку</i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <p class="par">
                        <span class="gra">+7 (495) 744-87-30</span>
                    </p>
                    <br>
                    <p class="fl">
                        <a href="https://www.facebook.com/artkonstruktor.ru" target="_blank">
                            <img src="./img/fb.png" alt="" style="margin-right: 15px;display: block;">
                        </a>
                    </p>
                    <p class="fl">
                        <a href="https://www.facebook.com/artkonstruktor.ru" target="_blank">
                            <img src="./img/you.jpg" width="50px" height="48px" alt="" style="margin-right: 15px;display: block;">
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>