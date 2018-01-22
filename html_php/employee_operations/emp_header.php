<!-- Initialize Bootstrap functionality -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <link rel="apple-touch-icon" sizes="60x60" href="../../app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../../app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../../app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="../../assets/images/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->

    <link rel="stylesheet" type="text/css" href="../../assets/css/pinesh_style/pinesh-style.css">
    <!--Start & End Calendar-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/datetimepicker/bootstrap-datetimepicker.css">
    <!--/Start & End Calendar-->
    <!--Star Rating-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../../assets/css/starrating/star-rating.css">
    <!--/Star Rating-->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                            class="icon-menu5 font-large-1"></i></a></li>
                <li class="nav-item"><a href="#" class="navbar-brand nav-link"><img alt="branding logo"
                                                                                    src="../../assets/images/logo_50.png"
                                                                                    data-expand="../../assets/images/logo_50.png"
                                                                                    data-collapse="../../assets/images/logo_xsmall.png"
                                                                                    class="brand-logo"></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                            class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                class="icon-menu5"> </i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-xs-right">

                    <li class="dropdown dropdown-user nav-item">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                            <span class="avatar avatar-online">
                                <img src="../../assets/images/portrait_img/<?= $_SESSION['portraintImg']; ?>" alt="portraitImg"><i></i>
                            </span>
                            <span class="user-name"><?= $_SESSION['userName']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
<!--                            <a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a>-->
<!--                            <a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>-->
<!--                            <div class="dropdown-divider"></div>-->
                            <a href="../login/logout.php" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
