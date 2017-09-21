<?php
$classname = Request::segment(1);
$methodname = Request::segment(2);
$session_data = Session::all();
$role_id = $session_data['user'][0]['role_id'];
?>
<aside id="sidebar">
    <nav id="navigation" class="collapse">
        <ul>
            <?php if ($role_id == 3) { ?>
            <li class="<?php echo ($classname == 'dashboard') ? 'active' : ''; ?>"><a href="{{route('dashboard')}}">
                    <span title="Dashboard">
                        <i class="icon-home"></i>
                        <span class="nav-title">Dashboard</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'users') ? 'active' : ''; ?>"><a href="{{route('admin.users')}}">
                    <span title="Users">
                        <i class="icon-user"></i>
                        <span class="nav-title">Users</span>
                    </span></a>
            </li>
            <?php } else { ?>
            <li class="<?php echo ($classname == 'dashboard') ? 'active' : ''; ?>"><a href="{{route('dashboard')}}">
                    <span title="Dashboard">
                        <i class="icon-home"></i>
                        <span class="nav-title">Dashboard</span>
                    </span></a>
            </li>
            <?php if ($role_id != 4) { ?>
            <li class="<?php echo ($classname == 'group') ? 'active' : ''; ?>"><a href="{{route('group')}}">
                    <span title="Departments">
                        <i class="icon-users"></i>
                        <span class="nav-title">Departments</span>
                    </span></a>
            </li>
             <?php } ?>
            <li class="<?php echo ($classname == 'users') ? 'active' : ''; ?>"><a href="{{route('users')}}">
                    <span title="Users">
                        <i class="icon-user"></i>
                        <span class="nav-title">Users</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'category') ? 'active' : ''; ?>"><a href="{{route('category')}}">
                    <span title="Category">
                        <i class="icon-list"></i>
                        <span class="nav-title">Category</span>
                    </span></a>
            </li>
            
            <li class="<?php echo ($classname == 'questions') ? 'active' : ''; ?>"><a href="{{route('questions')}}">
                    <span title="Questions">
                        <i class="icon-pencil"></i>
                        <span class="nav-title">Questions</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'form' && $methodname != 'getUserForms' && $methodname != 'userFormView') ? 'active' : ''; ?>"><a href="{{route('form')}}">
                    <span title="Templates">
                        <i class="icon-list-2"></i>
                        <span class="nav-title">Templates</span>
                    </span></a>
            </li>
            <li class="<?php echo ($methodname == 'getUserForms' || $methodname == 'userFormView') ? 'active' : ''; ?>"><a href="{{route('form.getUserForms')}}">
                    <span title="User Forms">
                        <i class="icon-tasks"></i>
                        <span class="nav-title">User Forms</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'auditlogs') ? 'active' : ''; ?>"><a href="{{route('auditlogs')}}">
                    <span title="Audit Logs">
                        <i class="icon-check"></i>
                        <span class="nav-title">Audit Logs</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'notifications') ? 'active' : ''; ?>"><a href="{{route('notifications')}}">
                    <span title="Notifications">
                        <i class="icon-paper-airplane"></i>
                        <span class="nav-title">Notifications</span>
                    </span></a>
            </li>
            <li class="<?php echo ($classname == 'reports') ? 'active' : ''; ?>"><a href="{{route('reports')}}">
                    <span title="Reports">
                        <i class="icon-graph"></i>
                        <span class="nav-title">Reports</span>
                    </span></a>
            </li>
            <?php }  ?>
        </ul>
    </nav>
</aside>

<div id="sidebar-separator"></div>