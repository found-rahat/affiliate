<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Affiliate - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="user/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Fonts and icons -->
    <script src="user/assets/js/plugin/webfont/webfont.min.js"></script>


    <!-- Fonts and icons -->
    <script src="user/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["user/assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="user/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="user/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="user/assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="user/assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{route('user.dashboard')}}" class="logo">
                        <img src="user/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                            height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="{{route('user.dashboard')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.orderlist')}}">
                                <i class="fas fa-list"></i>
                                <p>Order List</p>
                                <span class="badge badge-success">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.product')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-upload"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.ordernow')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-store"></i>
                                <p>Order Now</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.payment')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-money-bill"></i>
                                <p>Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.track')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-route"></i>
                                <p>Order Track</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.charge')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-truck"></i>
                                <p>Delivery Charge</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.howtowork')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-lightbulb"></i>
                                <p>How to Work</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.about')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-circle-info"></i>
                                <p>About Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{route('user.report')}}" class="collapsed" aria-expanded="false">
                                <i class="fas fa-clipboard"></i>
                                <p>Report Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.blank')}}" >
                                <i class="fas fa-clipboard"></i>
                                <p>Blank</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
