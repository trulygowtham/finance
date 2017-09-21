<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> </html><![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> </html><![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> </html><![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

    <head>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Bootstrap Stylesheet -->
        <link rel="stylesheet" href = "<?php echo asset('public/bootstrap/css/bootstrap.min.css') ?>" media="all" />

        <!-- jquery-ui Stylesheets -->
        <link rel="stylesheet" href = "<?php echo asset('public/assets/jui/css/jquery-ui.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/jui/jquery-ui.custom.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/jui/timepicker/jquery-ui-timepicker.css') ?>" media="screen" />

        <!-- Uniform Stylesheet -->
        <link rel="stylesheet" href = "<?php echo asset('public/plugins/uniform/css/uniform.default.css') ?>" media="screen" />

        <!-- Plugin Stylsheets first to ease overrides -->

        <!-- iButton -->
        <link rel="stylesheet" href = "<?php echo asset('public/plugins/ibutton/jquery.ibutton.css') ?>" media="screen" />

        <!-- Circular Stat -->
        <link rel="stylesheet" href = "<?php echo asset('public/custom-plugins/circular-stat/circular-stat.css') ?>" />


        <!-- End Plugin Stylesheets -->

        <!-- Main Layout Stylesheet -->
        <link rel="stylesheet" href = "<?php echo asset('public/assets/css/fonts/icomoon/style.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/css/mooncake.min.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/css/plugins/plugins.min.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/css/customizer.css') ?>" media="screen" />
        <link rel="stylesheet" href = "<?php echo asset('public/assets/css/demo.css') ?>" media="screen" />

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

<!--        <title>Check List</title>-->

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		
        <!-- Core Scripts -->
        <script src = "<?php echo asset('public/assets/js/libs/jquery-1.8.3.min.js') ?>"></script>
        <script src = "<?php echo asset('public/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src = "<?php echo asset('public/assets/js/libs/jquery.placeholder.min.js') ?>"></script>
        <script src = "<?php echo asset('public/assets/js/libs/jquery.mousewheel.min.js') ?>"></script>
	
       <!-- Google Analytics Scripts -->
		<script src = "<?php echo asset('public/assets/js/ga.js') ?>"></script>
		<script src = "<?php echo asset('public/assets/js/ipaddress.js') ?>"></script>
        
        <meta name="_token" content="{!! csrf_token() !!}"/>
    </head>

    <body data-show-sidebar-toggle-button="true" data-fixed-sidebar="false">

        <!--        <div id="customizer">
                    <div id="showButton"><i class="icon-cogs"></i></div>
                    <div id="layoutMode">
                        <label class="checkbox"><input type="checkbox" class="uniform" name="layout-mode" value="boxed" /> Boxed</label>
                    </div>
                </div>
        
                <div id="style-changer"><a href = "<?php echo asset('public/plugins/uniform/jquery.uniform.min.js') ?>../simple/index.html"></a></div>-->

        <div id="wrapper">
            <header id="header" class="navbar navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">
                        <div class="brand-wrap pull-left">
                            <div class="brand-img">
                                <a class="brand" href = "{{route('dashboard')}}">
                                    <img src="http://offsiteassets.com/assets/images_offsite/login/logo.png" alt="" style="width: 117px; height: 21px;" />
                                </a>
                            </div>
                        </div>

                        <div id="header-right" class="clearfix">
                            <div id="nav-toggle" data-toggle="collapse" data-target="#navigation" class="collapsed">
                                <i class="icon-caret-down"></i>
                            </div>
                            <!--                            <div id="header-search">
                                                            <span id="search-toggle" data-toggle="dropdown">
                                                                <i class="icon-search"></i>
                                                            </span>
                                                            <form class="navbar-search" />
                                                            <input type="text" class="search-query" placeholder="Search" />
                                                            </form>
                                                        </div>-->
                            <div id="dropdown-lists">
                                <div class="item-wrap">
                                    <a class="item" href = "#" data-toggle="dropdown">
                                        <span class="item-icon"><i class="icon-exclamation-sign"></i></span>
                                        <span class="item-label">Notifications</span>
                                        <span class="item-count">{{ count($notifications)}}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item-wrap">
                                            <ul>
                                                @foreach($notifications as $page)
                                                @php
                                                 $notification_page_url = (($page['notification_type_id'] == "1")? route("form.view", base64_encode($page['notification_links'])):(($page['notification_type_id'] == "2")? route("form.userFormView", base64_encode($page['notification_links'])):'#'));                                                
                                                @endphp
                                                <li id="notification_li_{{ @$page['id']}}">
                                                    <a href = "{{$notification_page_url}}" onclick="return read_notification({{ @$page['id']}});">
<!--                                                        <span class="thumbnail"><img src="./assets/images/pp.jpg" alt="" /></span>-->
                                                        <span class="details" style="margin-left: 10px !important;">
                                                            <strong> {{ @$page['notification_text']}}</strong>
                                                            <span class="time">{{ dateTimeFormat(@$page['created_at']) }}</span>
                                                        </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                                @if(count($notifications) == 0)
                                                <li>
                                                    <a href = "#" >
<!--                                                        <span class="thumbnail"><img src="./assets/images/pp.jpg" alt="" /></span>-->
                                                        <span class="details" style="margin-left: 10px !important;">
                                                            No Data                                                            
                                                        </span>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </li>
                                        <li><a href = "{{ route('notifications') }}">View all notifications</a></li>
                                    </ul>
                                </div>
                                
                            <!--    <div class="item-wrap">
                                    <a class="item" href = "#" data-toggle="dropdown1">
                                        <span class="item-icon"><i class="icon-envelope"></i></span>
                                        <span class="item-label">Messages</span>
                                        <span class="item-count">0</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item-wrap">
                                            <ul>
                                                <li>
                                                    <a href = "#">
                                                        <span class="thumbnail"><img src="./assets/images/pp.jpg" alt="" /></span>
                                                        <span class="details">
                                                            <strong>John Doe</strong><br /> Hello, do you have time to go out tomorrow?
                                                            <span class="time">13 minutes ago</span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href = "#">
                                                        <span class="thumbnail"><img src="./assets/images/pp.jpg" alt="" /></span>
                                                        <span class="details">
                                                            <strong>Jane Roe</strong><br /> Hey, the reports said that you were...
                                                            <span class="time">27 minutes ago</span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href = "#">
                                                        <span class="thumbnail"><img src="./assets/images/pp.jpg" alt="" /></span>
                                                        <span class="details">
                                                            <strong>Billy John</strong><br /> Can I borrow your new camera for taking...
                                                            <span class="time">About an hour ago</span>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href = "<?php echo asset('public/plugins/uniform/jquery.uniform.min.js') ?>./mail.html">View all messages</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <?php
                            $data = Session::all();
                            $path = url('public/images');
                            $file_name = @$data['user'][0]['profile_avatar'];
                            if ($file_name == "") {
                                $path = url('public/assets/images');
                                $file_name = asset('public/assets/images/person.jpg');
                            }

                            if (!file_exists($file_name)) {
                                //$file_name = asset('public/assets/images/person.jpg');
                            }
                            ?>
                            <div id="header-functions" class="pull-right">
                                <div id="user-info" class="clearfix">
                                    <span class="info">
                                        Welcome
                                        <span class="name">{{ $data['user'][0]['name'] }}</span>
                                    </span>
                                    <div class="avatar">
                                        <a class="dropdown-toggle" href = "#" data-toggle="dropdown">
                                            <img src="<?php echo $file_name; ?>" alt="Avatar" />
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href = "{{ url('/profile') }}"><i class="icol-user"></i> My Profile</a></li>
<!--                                            <li><a href = "#"><i class="icol-layout"></i> My Invoices</a></li>                                        -->
                                            <li class="divider"></li>
                                            <li><a href = "{{ url('/logout') }}"><i class="icol-key"></i> Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="logout-ribbon">
                                    <a href = "{{ url('/logout') }}"><i class="icon-off"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div id="content-wrap">
                <div id="content" class="sidebar-minimized">
                    <div id="content-outer">
                        <div id="content-inner">


