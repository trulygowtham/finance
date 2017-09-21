<title>Check List - Reports - Userforms</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('reports')}}">Reports </a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">User forms</a>
            </li>
        </ul>

        <h1 id="main-heading">
            Reports :: User forms <span>    </span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">
                        List of User Completed Forms
                    </span>
                </div>
                <div class="widget-content ">
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
                <div class="widget-content table-container">
                    <table id="users-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>User</th> 
                                <th>Template</th> 
                                <th>Description</th>
                                <th>Form Id</th>
                                <th>Created Date</th>
                                <th>Completed Date</th>
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
                                <td> {{ dateTimeFormat($page->created_at) }}  </td>
                                <td> {{ dateTimeFormat($page->updated_at) }}  </td>
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
                                <th>Created Date</th>
                                <th>Completed Date</th>
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

    $(document).ready(function () {
        $('#users-table').dataTable().columnFilter();


    });


</script>
<script>
    var d = new Date();
    var month = d.getMonth();
    var day = d.getDate();
    var year = d.getFullYear();
    $(document).ready(function () {
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
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo asset('public/plugins/datatables/jquery.dataTables.columnFilter.js') ?>"></script>

