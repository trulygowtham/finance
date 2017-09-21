<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - Templates</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Templates</a>
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
                    <span class="title">Templates</span>
                    <div class="toolbar">
                        <div class="btn-group">
                            <a href="{{route('form.add')}}"  class="btn" title="New User">
                                New
                            </a>
                        </div>
                    </div>
                </div>
                <div class="widget-content table-container">
                    @if (session('success-status'))
                    <div class="alert alert-success">
                        {{ session('success-status') }}
                    </div>
                    @endif
                    @if (session('error-status'))
                    <div class="alert alert-danger">
                        {{ session('error-status') }}
                    </div>
                    @endif
                    <table id="users-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Form Name </th> 
                                <th>Description</th>
                                <th>Number of Questions</th>
                                <th> Created Date </th>
                                <th>  Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @foreach($forms as $page)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td> {{ $page->name }}   </td> 
                                <td> {{ $page->description }}   </td> 
                                <td>{{ $page->no_of_questions }}</td>
                                <td> {{ dateTimeFormat($page->created_at) }}  </td>
<!--                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="#" class="btn btn-small"><i class="icon-search"></i></a>
                                        <a href="#" class="btn btn-small"><i class="icon-pencil"></i></a>
                                        <a href="#" class="btn btn-small"><i class="icon-trash"></i></a>
                                    </span>
                                </td>-->
                                <td><?php
                                    $buttons = "";
                                    $buttons.="<div class='btn-group'>";




                                    // --------------------------

                                    $buttons.=' <a class="btn btn-small btn-primary" href="' . route("form.view", base64_encode($page->id)) . '"  >View</a>';


                                    if ($page->status == 2) {
                                        $buttons.='<a class="btn btn-small btn-info" href="' . route("form.edit", base64_encode($page->id)) . '"  >Edit</a>';
                                        $buttons.='<a class="btn btn-small btn-danger" href="' . route("form.delete", base64_encode($page->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this template?'" . ')" >Delete</a>';
                                    } else {
                                        $buttons.='<a class="btn btn-small btn-info" title="Assign users" href="" onclick="show_users(' . $page->id . ',' . "'" . $page->name . "'" . ')"  data-toggle="modal" data-target="#myUserModal" ><i class="icon-user"></i></a>';
                                        $buttons.='<a class="btn btn-small btn-inverse" title="Assign groups" href="" onclick="show_groups(' . $page->id . ',' . "'" . $page->name . "'" . ')"  data-toggle="modal" data-target="#myModal" ><i class="icon-users"></i></a>';
                                    }
                                    $buttons.='</div>';
                                    echo $buttons;
                                    ?>  </td> 
                            </tr>
                            <?php $sno++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> ID </th>
                                <th> Form Name </th> 
                                <th>Description</th>
                                <th>Number of Questions</th>
                                <th> Created Date </th>
                                <th>  Action </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Assign Groups to template -->
<div id="myModal" class="modal fade hide">
    <form class="form-vertical" method="post" action="{{route('form.linkGroup')}}" id="form_frm">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">&times;</button>
            Assign Groups to <span id="title"></span>
        </div>

        <div class="modal-body">

            {!! csrf_field() !!}
            <input type="hidden" name="form_id" id="form_id" value="" />
            <div class="" id="form_preview_questions">
                <div class="control-group">
                    <label class="control-label" for="group_id">Group</label>
                    <div class="controls" id="form-groups">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <button type="button" onclick="saveFormGroup()" class="btn btn-primary bgBlue clWhite">
                Save
            </button>
        </div>
    </form>
</div>
<!-- Assign Groups to template -->
<!-- Assign Users to template -->
<div id="myUserModal" class="modal fade hide">
    <form class="form-vertical" method="post" action="{{route('form.linkUser')}}" id="form_user">
        {!! csrf_field() !!}
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">&times;</button>
            Assign Users to <span id="usertitle"></span>
        </div>
        <div class="modal-body">            
            <input type="hidden" name="user_form_id" id="user_form_id" value="" />

            <div class="control-group">
                <label class="control-label" for="User_id">User</label>
                <div class="controls" id="form-users">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <button type="button" onclick="saveFormUser()" class="btn btn-primary bgBlue clWhite">
                Save
            </button>
        </div>
    </form>
</div>
<!-- Assign Users to template -->


<!--
<div class="modal fade" id="myUserModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Assign Users to <span id="usertitle"></span></h4>
            </div>
            <form class="form-horizontal" method="post" action="{{route('form.linkUser')}}" id="form_user">
                {!! csrf_field() !!}
                <div class="modal-body">

                    <input type="hidden" name="user_form_id" id="user_form_id" value="">
                    <div class="" id="form_preview_questions">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="User_id">User</label>
                            <div class="col-sm-10" id="form-users">


                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" onclick="saveFormUser()" class="btn btn-default bgBlue clWhite">
                            Save
                        </button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
</div>
-->
<script>
    $(document).ready(function () {
        $('#users-table').dataTable().columnFilter();

    });
</script>
<script>
    function show_groups(form_id, form_name) {
        $('#form_id').val(form_id);
        $("#form-groups").html("Please Wait..");
        $("#title").html(form_name);
        var que_content = '';
        var actionurl = "{{route('form.group')}}";
        $.ajax({
            url: actionurl,
            type: 'post',
            data: {'form_id': form_id, '_token': "<?php echo csrf_token(); ?>"},
            success: function (data) {
                $("#form-groups").html(data);
                $('.select2-select-00').select2("destroy");
                $('.select2-select-00').select2();
            }
        });
    }
    function saveFormGroup() {
        var options = $('#group_id > option:selected');
        if (options.length == 0) {
            alert('Please select groups');
            return false;
        } else {
            $('#form_frm').submit();
        }
    }
</script>
<script>
    function show_users(form_id, form_name) {
        $('#user_form_id').val(form_id);
        $("#form-users").html("Please Wait..");
        $("#usertitle").html(form_name);
        var que_content = '';
        var actionurl = "{{route('form.user')}}";
        $.ajax({
            url: actionurl,
            type: 'post',
            data: {'form_id': form_id, '_token': "<?php echo csrf_token(); ?>"},
            success: function (data) {
                $("#form-users").html(data);
                $('.select2-select-00').select2("destroy");
                $('.select2-select-00').select2();
            }
        });
    }

    function saveFormUser() {
        var options = $('#user_id > option:selected');
        if (options.length == 0) {
            alert('Please select users');
            return false;
        } else {
            $('#form_user').submit();
        }
    }
</script>
<!-- DataTables -->
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.columnFilter.js') ?>"></script>
<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>