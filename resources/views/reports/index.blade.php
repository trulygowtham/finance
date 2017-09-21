<title>Check List - Reports</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Reports</a>
            </li>
        </ul>

        <h1 id="main-heading">
            Reports <span>    </span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">

            <ul class="stats-container">
                <li>
                    <a href="{{route('reports.userforms')}}" class="stat summary">
                        <span class="text">User Completed Forms</span>
                    </a>
                </li>


                <li>
                    <a href="{{route('reports.userFormCount')}}" class="stat summary">
                        <span class="text">User Forms Count</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('reports.questionExpectedReport')}}" class="stat summary">
                        <span class="text">Question Expected Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('reports.categoryExpectedReport')}}" class="stat summary">
                        <span class="text">Category Expected Report</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

</section>
