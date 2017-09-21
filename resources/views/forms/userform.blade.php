<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - User Forms</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">User Forms</a>
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
                    <span class="title">Forms</span>
                    <div class="toolbar">
                        <!--div class="btn-group">
                            <a href="{{route('questions.add')}}"  class="btn" title="New User">
                                New
                            </a>
                        </div-->
                    </div>
                </div>

                <div class="widget-content ">
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
                    <form  method="post" enctype="multipart/form-data" class="form-vertical">
                        {!! csrf_field() !!}
                        <div class="control-group clearfix">
                            <div class="span3" >
                                <label class="control-label" for="user_id">User</label>
                                <div class="controls">
                                    <select class="select2-select-00 span12" name="user_id" id="user_id">
                                        <option>All</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" <?php echo ($user_id == $user->id) ? 'SELECTED' : ''; ?>>{{$user->name}} {{$user->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="span6">
                                <label for="event_cloning_#index#_ename" class="control-label">Date</label>
                                <div class="controls controls-row">
                                    <input type="text" id="event_cloning_#index#_estart" class="span6 datepicker_s" name="from_date" value="{{ $from_date }}" placeholder="From date" readonly=""/>
                                    <input type="text" id="event_cloning_#index#_eend" class="span6 datepicker_e" name="to_date" value="{{ $to_date }}" placeholder="To date" readonly=""/>
                                </div>
                            </div>
                            <div class="span3">
                                <label for="" class="control-label">&nbsp;</label>
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
                <div class="widget-content table-container ">

                    <table id="users-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>User</th> 
                                <th>Template</th> 
                                <th>Description</th>
                                <th>Form Id</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @foreach($forms as $page)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td> {{ $page->name }} {{ $page->last_name }}   </td> 
                                <td> {{ $page->form_name }}   </td> 
                                <td>{{ $page->description }}</td>
                                <td>{{ $page->form_number }}</td>
                                <td> <?php
                                    if ($page->status == "2") {
                                        echo '<button class="btn btn-mini btn-success">Completed</button>';
                                    } else if ($page->status == "3") {
                                        echo '<button class="btn btn-mini btn-danger">Cancelled</button>';
                                    } else {
                                        echo '<button class="btn btn-mini btn-info">Pending</button>';
                                    }
                                    ?>  </td>
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

                                    $buttons.=' <a class="btn btn-small btn-primary" href="' . route("form.userFormView", base64_encode($page->id)) . '"  >View</a>';
                                    $buttons.='</div>';
                                    echo $buttons;
                                    ?>  </td> 
                            </tr>
                            <?php $sno++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID </th>
                                <th>User</th> 
                                <th>Template</th> 
                                <th>Description</th>
                                <th>Form Id</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>


<script>
    var d = new Date();
    var month = d.getMonth();
    var day = d.getDate();
    var year = d.getFullYear();
    $(document).ready(function () {
        $('.select2-select-00').select2();
        
        $('#users-table').dataTable().columnFilter();


        $(".datepicker_s").datepicker({
            showOtherMonths: true,
            onSelect: function (selectedDate) {
                $(".datepicker_e").datepicker("option", "minDate", selectedDate);
            }
        });
        
        $(".datepicker_e").datepicker({
            showOtherMonths: true,
            onSelect: function (selectedDate) {
                $(".datepicker_s").datepicker("option", "maxDate", selectedDate);
            }
        });
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

<!-- timepicker -->
<script src="<?php echo asset('public/assets/jui/timepicker/jquery-ui-timepicker.min.js') ?>"></script>

<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>
