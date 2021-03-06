<title>Check List - Category</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Category</a>
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
                    <span class="title">Category</span>
                    <div class="toolbar">
                        <div class="btn-group">
                            <<a href="{{route('category.add')}}"  class="btn" title="New User">
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
                                <th> S.No </th>
                                <th> Category </th> 
                                <th> Created Date </th>
                                <th>  Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @foreach($users as $page)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td> {{ $page->name }} </td> 
                                
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
                                    $buttons.=' <a class="btn btn-small btn-primary" href="' . route("category.view", base64_encode($page->id)) . '"  >View</a>';
                                    $buttons.='<a class="btn btn-small btn-info" href="' . route("category.edit", base64_encode($page->id)) . '"  >Edit</a>';

                                    $buttons.='<a class="btn btn-small btn-danger" href="' . route("category.delete", base64_encode($page->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this category?'" . ')" >';
                                    $buttons.='Delete</a>';
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
                                <th> Category </th> 
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