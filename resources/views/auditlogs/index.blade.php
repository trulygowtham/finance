<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - Audit Logs</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Audit Logs</a>
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
                    <span class="title">Audit Logs</span>
                </div>
                <div class="widget-content ">
                    <form  method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="control-group clearfix">
                            <div class="span3" >
                               
                                <div class="controls">
                                    <select class="select2-select-00 span12" id="module_id"   name="module_id" data-placeholder="Select a module">
                                        <option value=''></option>
                                        <?php foreach ($modules as $key => $module_row) { ?>
                                            <option value="<?php echo $key ?>" <?php echo ($module_id==$key) ? 'SELECTED' : ''; ?>><?php echo $module_row; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="span3">
                                
                                <div class="controls">
                                    <button type="submit" class="btn">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="span3">

                            </div>

                        </div>
                        
                    </form>
                </div>
                <div class="widget-content table-container">

                    <table id="users-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th> S.No. </th> 
                                <th> Message </th> 
                                <th> Created Name </th>
                                <th> Created Date </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @foreach($users as $page)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td> {{ $page->message }} </td> 
                                <td> {{ $page->created_name }} </td> 

                                <td> {{ dateTimeFormat($page->created_at) }}  </td>
                            </tr>
                            <?php $sno++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> S.No. </th> 
                                <th> Message </th> 
                                <th> Created Name </th>
                                <th> Created Date </th> 
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
         $('.select2-select-00').select2();
        $('#users-table').dataTable().columnFilter();
        ;
    });
</script>

<!-- DataTables -->
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.columnFilter.js') ?>"></script>
<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>