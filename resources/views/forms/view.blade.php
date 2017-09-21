<title>Check List - View Template</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{ route('form') }}">Templates</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">View</a>
            </li>
        </ul>

        <!--        <h1 id="main-heading">
                    Profile Update <span>  This is the place where everything started  </span>
                </h1>-->
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">Template Basic Details</span>
                </div>
                <div class="widget-content table-container">

                    <table class="table table-striped table-detail-view">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ @$form_data->name }}</td>
                            </tr>
                            <tr>
                                <th>Number</th>
                                <td>{{ @$form_data->template_id }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{  @$form_data->description }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{  ((@$form_data->status == 2)?'Draft':'Completed') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

       @include('forms/viewform')

    </div>
</section>
<!-- Select2 -->

