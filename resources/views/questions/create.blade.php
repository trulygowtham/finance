<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - New User</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('questions')}}">Questions</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">New</a>
                <span class="divider">&raquo;</span>
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
                    <span class="title">New Question</span>
                </div>
                <div class="widget-content form-container">
                    @if (session('success-status'))
                    <div class="alert alert-success">
                        {{ session('success-status') }}
                    </div>
                    @endif
                    <form class="form-horizontal" id="question_frm"  method="post">
                        {!! csrf_field() !!}
                        <div class="control-group">
                            <label class="control-label" for="name">Category</label>

                            <div class="controls">
                                <select class="select2-select-00 span12" id="category_id" name="category_id" data-placeholder="Select category">
                                    <option value=""></option>
                                    @foreach($category as $cats)
                                    <option value="{{ $cats->id }}">{{ $cats->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('name'))
                                <div class="help-block">
                                    {{ $errors->first('category_id') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="blockArea" id="category_div_0">
                            <div class="control-group">
                                <label class="control-label" for="name">Question</label>

                                <div class="controls">
                                    <input type="text" class="span10" name="name[0]" id="name" placeholder="Question">
                                    @if ($errors->has('name'))
                                    <div class="help-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                    <span class="span2 pull-right" id="input_cloning_add">
                                        <a class="btn btn-mini btn-success  addQstn" rel="0"> <i class="icon-plus"></i></a>
                                        <!--a class="btn btn-mini"> <i class="icol-cross"></i></a-->
                                    </span> 
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="option_type">Answer Type</label>

                                <div class="controls">
                                    <select class="span10 option_type" id="option_type_0" name="option_type[0]" rel="0">
                                        <option value="">Answer Type</option>
                                        <option value="input">Input</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="dropdown">Dropdown</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                    @if ($errors->has('option_type'))
                                    <div class="help-block">
                                        {{ $errors->first('option_type') }}
                                    </div>
                                    @endif 
                                </div>
                            </div>


                            <div class="control-group no_of_options_div_0" id="no_of_options_div_0" style="display: none;">
                                <label class="control-label" for="no_of_options">No. of Options</label> 
                                <div class="controls">
                                    <input type="number" min="1" value="1" class="span10" id="no_of_options" name="no_of_options[0]" placeholder="No. of Options">
                                </div>
                            </div>                
                            <div class="control-group options_cls_0" id="options_id" style="display: none;">
                                <label class="control-label" for="options">Label / Option Name</label>
                                <div class="controls"> 
                                    <span class="span10 ">
                                        <input type="text" class="span10" id="options_1"  name="options[0][]" placeholder="Label / Option Name">

                                        <input type="hidden" id="hid_opt_val" value="1">
                                        <input type="hidden" id="manhid_0" name="manhid[0][]" value="0">
                                        <input type="checkbox" class="chkmandatory" id="mandatory_1" opt_val='0' name="mandatory[0][]" value="1" > Is Expected
                                    </span>

                                    <span class="span2 pull-right" id="input_cloning_add">
                                        <a class="btn btn-mini btn-success  option_btn_0 option_add_btn"  rel="0"> <i class="icon-plus"></i></a>
                                        <!--a class="btn btn-mini"> <i class="icol-cross"></i></a-->
                                    </span> 
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label" for="description">Description</label>
                                <div class="controls">  
                                    <textarea type="text" class="span10" name="description[0]" id="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{route('questions')}}" ><button type="button" class="btn" type="reset">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Select2 -->
<script>
    $(document).ready(function () {
        $('.select2-select-00').select2();
        $("#question_frm").on("change", ".option_type", function () {
            var rel = $(this).attr('rel');

            var option_type = $(this).val();

            if (option_type == "") {
                $(".options_cls_" + rel + ", .no_of_options_div_" + rel).hide();
            } else {
                if (jQuery.inArray(option_type, ['input', 'textarea']) >= 0) {
                    $(".no_of_options_div_" + rel).show();
                    $(".options_cls_" + rel).hide();
                } else if (jQuery.inArray(option_type, ['radio', 'checkbox', 'dropdown']) >= 0) {
                    $(".no_of_options_div_" + rel).hide();
                    $(".options_cls_" + rel).show();
                    if (jQuery.inArray(option_type, ['radio']) >= 0) {

                        if ($(".option_btn_" + rel).length == 1) {
                            //$(".option_add_btn").trigger("click");
                        }
                    }
                }
            }
        });

        $("#question_frm").on("click", ".option_add_btn", function () {
            var rel = $(this).attr('rel');
            var opt_val = $('#hid_opt_val').val();
            var content = '<div class="control-group  options_cls_' + rel + '">\n\
                <div class="controls">\n\
                    \n\
                    <span class="span10">\n\
                        <input type="hidden" id="manhid_' + opt_val + '" name="manhid[' + rel + '][]" value="0">\n\
                        <input type="text" class="span10" id="options_1"   name="options[' + rel + '][]" placeholder="Label / Option Name">\n\
                        <input type="checkbox" class="chkmandatory" opt_val=' + opt_val + ' id="mandatory_' + rel + '" name="mandatory[' + rel + '][]" value="1" > Is Expected \n\
                    </span>\n\
                    <span class="span2 pull-right" id="input_cloning_add">\n\
                        <a class="btn btn-mini btn-success  option_btn_' + rel + ' option_add_btn"  rel="' + rel + '"> <i class="icon-plus"></i></a>\n\
                        <a class="btn btn-mini option_remove_btn"> <i class="icol-cross"></i></a>\n\
                    </span>\n\
                </div>\n\
            </div>';
            $(content).insertAfter($(this).parent().parent().parent());
            opt_val++;
            $('#hid_opt_val').val(opt_val);
        });

        $("#question_frm").on("click", ".option_remove_btn", function () {
            $(this).parent().parent().parent().remove();
        });

    });
</script>
<script>
    $(document).ready(function () {

        var cat_number = 1;
        var que_number = 1;
        // Add Category
        $("#question_frm").on("click", ".addQstn", function () {
           
            if (true) { //confirm("Are you sure you want add another category?")
                var opt_val = $('#hid_opt_val').val();
                var cat_rel = $(this).attr("rel");
                var category_options = $("#option_type_0").html();//"<option value=''>Select</option>";//$("#category_" + cat_rel).html();//
                //var category_content = '<div class="blockArea" id="category_div_' + cat_number + '"><div class="form-group"><label class="col-sm-2 control-label" for="">Category</label><div class="col-sm-9"><select class="form-control category" name="category[' + cat_number + ']" id="category_' + cat_number + '"  rel = "' + cat_number + '">' + category_options + '</select></div><div class="col-sm-1 padL0"><div class="pull-right btn btnIcon bgGreen btnAdd addCat" rel="' + cat_number + '">&nbsp;</div><div class="pull-right btn btnIcon bgRed btnCancel mrzR5 delCat" rel="' + cat_number + '" >&nbsp;</div></div></div><div class="form-group question_div_' + cat_number + '"><label class="col-sm-2 control-label padL40" for="question[' + cat_number + '][' + que_number + ']">Question</label><div class="col-sm-8"><select class="form-control category_' + cat_number + ' questions" rel=' + cat_number + ' que_no=' + que_number + ' name="question[' + cat_number + '][' + que_number + ']" id="question_' + cat_number + '_' + que_number + '"><option>Select</option></select></div><div class="col-sm-1 padL0"><div class="pull-right btn btnIcon bgGreen btnAdd addQue" rel="' + cat_number + '" que="' + que_number + '">&nbsp;</div></div></div></div>';
                var category_content = '<div class="blockArea" id="category_div_' + cat_number + '">\n\
                    <div class="control-group">\n\
                        <label class="control-label" for="name">Question</label>\n\
                        <div class="controls"> <input type="text" class="span10" name="name[' + cat_number + ']" id="name" placeholder="Question">\n\
                            <span class="span2 pull-right" id="input_cloning_add">\n\
                                <a class="btn btn-mini btn-success  addQstn" rel="' + cat_number + '"> <i class="icon-plus"></i> </a>\n\
                                <a class="btn btn-mini delQstn" rel="' + cat_number + '" >  <i class="icol-cross"></i>  </a>\n\
                            </span>\n\
                        </div>\n\
                    </div>\n\
                    <div class="control-group">\n\
                        <label class="control-label" for="option_type">Answer Type</label>\n\
                        <div class="controls"> <select class="span10 option_type" id="option_type_' + cat_number + '" name="option_type[' + cat_number + ']"  rel="' + cat_number + '"> ' + category_options + ' </select> </div>\n\
                    </div>\n\
                    <div class="control-group no_of_options_div_' + cat_number + '" id="no_of_options_div_' + cat_number + '" style="display: none;">\n\
                        <label class="control-label" for="no_of_options">No. of Options</label>\n\
                        <div class="controls"> <input type="number" min="1" value="1" class="span10" id="no_of_options" name="no_of_options[' + cat_number + ']" placeholder="No. of Options"> </div>\n\
                    </div>\n\
                    <div class="control-group options_cls_' + cat_number + '" id="options_id_' + cat_number + '" style="display: none;">\n\
                        <label class="control-label" for="options">Label / Option Name</label>\n\
                        <div class="controls"> <span class="span10"><input type="hidden" id="manhid_' + opt_val + '" name="manhid[' + cat_number + '][]" value="0"><input type="text" class="span10"   id="options_' + cat_number + '"  name="options[' + cat_number + '][]" placeholder="Label / Option Name"> <input type="checkbox" class="chkmandatory" opt_val=' + opt_val + ' id="mandatory_' + cat_number + '" name="mandatory[' + cat_number + '][]" value="1" > Is Expected</span> \n\
                        <span class="span2 pull-right" id="input_cloning_add"> <a class="btn btn-mini btn-success option_btn_' + cat_number + ' option_add_btn" rel="' + cat_number + '"> <i class="icon-plus"></i> </a> </span>\n\
                        </div>\n\
                    </div>\n\
                    <div class="control-group">\n\
                        <label class="control-label" for="description">Description</label>\n\
                        <div class="controls"> <textarea type="text" class="span10" name="description[' + cat_number + ']" id="description" placeholder="Description"></textarea></div>\n\
                    </div>\n\
                </div>';


                $(this).parent().parent().parent().parent().after(category_content);
                cat_number++;
                que_number++;
                opt_val++;
                $('#hid_opt_val').val(opt_val);
            }
        });
        // Remove Category
        $("#question_frm").on("click", ".delQstn", function () {
            if (confirm("Are you sure you want remove this block of questions?")) {
                var cat_rel = $(this).attr("rel");
                $("#category_div_" + cat_rel).remove();
            }
        });
        $("#question_frm").on("click", ".chkmandatory", function () {
            var chkoptVal = $(this).attr('opt_val');

            if ($(this).is(':checked')) {
                $('#manhid_' + chkoptVal).val(1);
            } else {
                $('#manhid_' + chkoptVal).val(0);
            }
        });
    });
</script>
<!-- Bootstrap FileInput -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>
<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>


 