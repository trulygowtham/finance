<title>Check List - View User Details</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('users')}}">Users</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">View</a>
                <span class="divider">&raquo;</span>
            </li>
        </ul>

        <!--        <h1 id="main-heading">
                    Users <span>  This is the place where everything started  </span>
                </h1>-->
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">User Details</span>
                </div>
                <div class="widget-content table-container">
                    
                    <table class="table table-striped table-detail-view">
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td>{{ @$users->name }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ @$users->title }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td> {{$role_name}} </td>
                            </tr>
                            <tr>
                                <th>Groups</th>
                                <td> {{$group_name}} </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ @$users->email }}</td>
                            </tr>
                            <tr>
                                <th>Contact No.</th>
                                <td> {{ @$users->phone }}</td>
                            </tr>
                             <tr>
                                <th>Username</th>
                                <td> {{ @$users->username }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Select2 -->

