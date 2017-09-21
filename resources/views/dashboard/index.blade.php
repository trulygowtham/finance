<title>Check List - Dashboard</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
<!--        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
        </ul>-->

        <h1 id="main-heading">
            Dashboard <span> <!-- This is the place where everything started --> </span>
        </h1>
    </div>

    <div id="main-content">
        <ul class="stats-container">
            <h4>Today</h4>

            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-ok"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Completed</span>
                        <?php echo count($today_completed); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-pencil"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Pending</span>
                        <?php echo count($today_pending); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-red">
                        <i class="icon-remove-sign"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Cancelled</span>
                        <?php echo count($today_cancel); ?>
                    </span>
                </a>
            </li>
              <li>
                <span class="stat circular inline">
                    <span id="cs-2" data-provide="circular" data-fill-color="#0088cc" data-value="<?php echo $today_expected_cnt;?>" data-decimals="1" data-radius="36" data-percent="true" data-thickness="8"></span>
                    <span class="text">Exp Vs UnExp</span>
                </span>
            </li>
        </ul>
        <ul class="stats-container">
            <h4>Last 7 days</h4>

            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-ok"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Completed</span>
                        <?php echo count($weekly_completed); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-pencil"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Pending</span>
                        <?php echo count($weekly_pending); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-red">
                        <i class="icon-remove-sign"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Cancelled</span>
                        <?php echo count($weekly_cancel); ?>
                    </span>
                </a>
            </li>
              <li>
                <span class="stat circular inline">
                    <span id="cs-2" data-provide="circular" data-fill-color="#0088cc" data-value="<?php echo $weekly_expected_cnt;?>" data-decimals="1" data-radius="36" data-percent="true" data-thickness="8"></span>
                    <span class="text">Exp Vs UnExp</span>
                </span>
            </li>
        </ul>
        <ul class="stats-container">
            <h4>June Month</h4>

            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-ok"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Completed</span>
                        <?php echo count($montly_completed); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-pencil"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Pending</span>
                        <?php echo count($montly_pending); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-red">
                        <i class="icon-remove-sign"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Cancelled</span>
                        <?php echo count($montly_cancel); ?>
                    </span>
                </a>
            </li>
              <li>
                <span class="stat circular inline">
                    <span id="cs-2" data-provide="circular" data-fill-color="#0088cc" data-value="<?php echo $monthly_expected_cnt;?>" data-decimals="1" data-radius="36" data-percent="true" data-thickness="8"></span>
                    <span class="text">Exp Vs UnExp</span>
                </span>
            </li>
        </ul>
        
        
        <ul class="stats-container">
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-users"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Total Departments</span>
                        <?php echo count($total_departments); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-blue">
                        <i class="icon-user"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Total Users</span>
                        <?php echo count($total_users); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-list-2"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Total Templates</span>
                        <?php echo count($total_templates); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="stat summary">
                    <span class="icon icon-circle bg-info">
                        <i class="icon-list"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Total Categories</span>
                        <?php echo count($total_category); ?>
                    </span>
                </a>
            </li>
          
             
        </ul>

    </div>
</section>
<script src="<?php echo asset('public/plugins/custom-plugins/circular-stat/circular-stat.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo asset('public/plugins/custom-plugins/circular-stat/circular-stat.css') ?>" />
