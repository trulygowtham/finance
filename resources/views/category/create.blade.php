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
                <a href="#">Create</a>
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
                        <span class="title">Category Create</span>
                    </div>
                    <div class="widget-content form-container">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="control-group">
                                <label class="control-label" for="Category">Category</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" class="span12" value="{{ old('name', @$users->name) }}"/>
                                    @if ($errors->has('name'))
                                    <div class="help-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="description">Description</label>
                                <div class="controls">
                                    <textarea id="description" name="description" class="span12" value="{{ old('description', @$users->description) }}" ></textarea>
                                    @if ($errors->has('last_name'))
                                    <div class="help-block">
                                        {{ $errors->first('last_name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
 
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{route('category')}}" ><button type="button" class="btn" type="reset">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
 
<!-- Bootstrap FileInput -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>

 