<title>Check List - View User Group</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('group')}}">Groups</a>
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
                    <span class="title">Group Details</span>
                </div>
                <div class="widget-content table-container">
                    <?php
                    $group_users = array();
                    $user_arr = array();
                    foreach ($user_groups as $user_row) {
                        $user_arr[] = $user_row->user_id;
                    }
                    
                    foreach ($users as $user_row) {
                        if(in_array($user_row['id'], $user_arr)){
                            $group_users[] = $user_row->name.' '.$user_row->last_name;
                        }
                        
                    }
                    ?>
                    <table class="table table-striped table-detail-view">
                        <tbody>
                            <tr>
                                <th>Group</th>
                                <td>{{ old('name', @$groups->name) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ old('description', @$groups->description) }}</td>
                            </tr>
                            <tr>
                                <th>Users</th>
                                <td><?php echo implode(", ",$group_users); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Select2 -->

