<title>Check List - Notifications</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Notifications</a>
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
                    <span class="title">Notifications</span>
                </div>
               
                <div class="widget-content table-container">

                    <table id="users-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th> S.No </th>
                                <th> Notification </th> 
                                <th> Created Date </th>
                                <th> Created By </th>
                                <th>  Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @foreach($users as $page)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td> {{ $page->notification_text }} </td> 
                                <td> {{ dateTimeFormat($page->created_at) }} </td>
                                <td> {{ ($page->created_name) }} </td> 
                                <td><?php
                                    if ($page->notification_type_id == 1) {
                                        $link = 'form.view';
                                    } else {
                                        $link = 'form.userFormView';
                                    }
                                    $buttons = "";
                                    $buttons.="<div class='btn-group'>";
                                    $buttons.=' <a class="btn btn-small btn-primary" href="' . route("$link", base64_encode($page->notification_links)) . '"  onclick="return read_notification('. @$page['id'].');">View</a>';
                                    
                                    $buttons.='</div>';
                                    echo $buttons;
                                    ?>  </td>                                 
                            </tr>
                            <?php $sno++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> S.No </th>
                                <th> Notification </th> 
                                <th> Created Date </th>
                                <th> Created By </th>
                                <th>  Action </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    $(document).ready(function () {
        $('#users-table').dataTable().columnFilter();
        ;
    });
</script>

<!-- DataTables -->
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.columnFilter.js') ?>"></script>