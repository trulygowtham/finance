<title>Check List - Category</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{ route('category') }}">Category Page</a>
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
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <span class="title">Category View</span>
                    </div>
                    <div class="widget-content table-container">
                        <table class="table table-striped table-detail-view">
                            <tbody>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ @$categories->name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ @$categories->description }}</td>
                                </tr>
                                

                            </tbody>
                        </table>

                        
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<!-- Bootstrap FileInput -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>





<div class="dataContent pad10">
    <div class="card posRel padT10 padB10 padL15 padR15" style="min-height: 400px;">
        <div class="clearfix">
            <h3 class="mrzT0 mrzB10 pull-left lh34">Category View</h3>
            <a href="{{route('category')}}" ><div class="pull-right btn btnIcon bgRed btnCancel">
                    &nbsp;
                </div></a>
        </div>
        <div class="posAbs divider fullWidth clearfix" style="margin-left: -15px; margin-right: -20px;">
            &nbsp;
        </div>
        <div class="contentDisplay mrzT15 mrzB15">
            <form class="form-horizontal">

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="fName">Category</label>
                    <div class="col-sm-10 LH34 dataFont">
                        {{ old('name', @$categories->name) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hospital">Description</label>
                    <div class="col-sm-10 LH34 dataFont">
                        {{ old('description', @$categories->description) }}
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>