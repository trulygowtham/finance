<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - New Template</title>
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
                <a href="#">Create</a>
            </li>
        </ul>

        <!--        <h1 id="main-heading">
                    Profile Update <span>  This is the place where everything started  </span>
                </h1>-->
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" id="form_frm">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <span class="title">Basic Info</span>
                        </div>
                        <div class="widget-content form-container">

                            {!! csrf_field() !!}
                            <div class="control-group">
                                <label class="control-label" for="name">Template Name</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" class="span12" value="{{ old('name') }}"/>
                                    @if ($errors->has('name'))
                                    <div id="name-err" class="help-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                    <div id="name-err" class="help-block">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="description">Template Description</label>
                                <div class="controls">
                                    <textarea id="description" name="description" class="span12" value="{{ old('description') }}" ></textarea>
                                    @if ($errors->has('description'))
                                    <div class="help-block">
                                        {{ $errors->first('description') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group" >
                                <label class="control-label" for="status">Status</label>
                                <div class="controls">
                                    <select class="select2-select-00 span12" name="status" id="status">
                                        <option>Select</option>
                                        <option value="2" selected="true">Draft</option>
                                        <option value="1">Completed</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget"  id="category_div_0">
                        <div class="widget-content form-container">
                            <div class="control-group shoppingcart" >
                                <label class="control-label" for="category[0]">Category</label>
                                <div class="controls">
                                    <select style="display:none" class="span12 category_hid" name="category_hid[0]" id="category_hid_0"  rel = "0"  data-placeholder="Select a category">
                                        <option value="">Select</option>
                                        @foreach($category as $cats)
                                        <option value="{{ $cats->id }}">{{ $cats->name }}</option>
                                        @endforeach
                                    </select>
                                    <select class="select2-select-00 span10 category" name="category[0]" id="category_0"  rel = "0"  data-placeholder="Select a category">
                                        <option value="">Select</option>
                                        @foreach($category as $cats)
                                        <option value="{{ $cats->id }}">{{ $cats->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="  span2 pull-right" id="input_cloning_add">
<!--                                        <a class="btn btn-small delCat" rel="0"><i class="icol-cross"></i></a>-->
                                        <a class="btn btn-small addCat" rel="0"><i class="icon-plus"></i></a>  
                                    </span>
                                </div>
                            </div>
                            <div class="control-group question_div_0" >
                                <label class="control-label" for="question[0][0]">Question</label>
                                <div class="controls">
                                    <select class="select2-select-00 span8  category_0 questions" que_no='0' rel='0' name="question[0][0]" id="question_0_0">                                        <option>Select</option>
                                    </select>
                                    <span class="  span4 pull-right" id="input_cloning_add">
<!--                                        <a class="btn btn-small delQue" rel="0"><i class="icol-cross"></i></a>-->
                                        <a class="btn btn-small addQue" rel="0" que="0"><i class="icon-plus"></i></a>    
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-content" style="text-align: center;">
                            <div class="btn-toolbar">
                                <button class="btn btn-primary" id="show_preview" data-toggle="modal" data-target="#myModal">Preview</button>
                                <button class="btn btn-success" id="form-sub" type="submit">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Preview :: <span id="form_preview_title"></span></h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" method="post" id="form_frm">

                    <div class="" id="form_preview_questions">

                    </div>
                </form>    
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-default bgRed clWhite" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap FileInput -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>

<script>


$(document).ready(function () {
   // $('.select2-select-00').select2();
    var cat_number = 1;
    var que_number = 1;
    // Remove Category
    $("#form_frm").on("click", ".delCat", function () {
        if (confirm("Are you sure you want remove this block of questions?")) {
            var cat_rel = $(this).attr("rel");
            $("#category_div_" + cat_rel).remove();
        }
    });
    // Remove Question
    $("#form_frm").on("click", ".delQue", function () {
        if (confirm("Are you sure you want remove this questions?")) {

            $(this).parent().parent().parent().remove();
        }
    });
    //Get list of questions based on category selection
    $("#form_frm").on("change", ".category", function () {
        var cat_rel = $(this).attr("rel");
        var cat_val = $("#category_" + cat_rel).val();
        $(".category_" + cat_rel).html("<option value=''>Select</option>");
        if (cat_val != "") {
            $.ajax({
                url: "{{route('questions.all')}}",
                type: 'POST',
                data: {'_token': $('meta[name=_token]').attr('content'), 'category_id': cat_val},
                dataType: 'JSON',
                success: function (data) {
                    var option_content = "<option value=''>Select</option>";
                    if (data.length > 0) {
                        for (var ii in data) {
                            option_content += "<option value='" + data[ii].id + "'>" + data[ii].name + "</option>";
                        }
                    }
                    $(".category_" + cat_rel).html(option_content);
                    
                }
            });
        }
    });

    // Add Question
    $("#form_frm").on("click", ".addQue", function () {
        if (true) {  //confirm("Are you sure you want add another question?")

            var cat_rel = $(this).attr("rel");
            var que_rel = $(this).attr("que");
            var question_options = $('#question_' + cat_rel + '_' + que_rel).html();
            var question_content = '<div class="control-group question_div_' + cat_rel + '" ><label class="control-label" for="question[' + cat_rel + '][' + que_number + ']">Question</label><div class="controls"><select class="select2-select-00 span8  category_' + cat_rel + ' questions" rel=' + cat_rel + ' que_no=' + que_number + ' name="question[' + cat_rel + '][' + que_number + ']" id="question_' + cat_rel + '_' + que_number + '">' + question_options + '</select><span class="  span4 pull-right" id="input_cloning_add"><a class="btn btn-small delQue" rel="' + cat_rel + '"><i class="icol-cross"></i></a><a class="btn btn-small addQue" rel="' + cat_rel + '" que="' + que_number + '"><i class="icon-plus"></i></a>  </span></div> </div>';

            $(this).parent().parent().parent().after(question_content);
            
            que_number++;
        }
    });

    // Add Category
    $("#form_frm").on("click", ".addCat", function () {
        if (true) { //confirm("Are you sure you want add another category?")

            var cat_rel = $(this).attr("rel");
            var category_options = $("#category_hid_0").html();//"<option value=''>Select</option>";//$("#category_" + cat_rel).html();//
            var category_content = '<div class="widget"  id="category_div_' + cat_number + '"><div class="widget-content form-container"><div class="control-group shoppingcart" ><label class="control-label" for="category[' + cat_number + ']">Category</label><div class="controls"><select class="select2-select-00 span10 category" name="category[' + cat_number + ']" id="category_' + cat_number + '"  rel = "' + cat_number + '"  data-placeholder="Select a category">' + category_options + '</select><span class="  span2 pull-right" id="input_cloning_add"><a class="btn btn-small delCat" rel="' + cat_number + '"><i class="icol-cross"></i></a><a class="btn btn-small addCat" rel="' + cat_number + '"><i class="icon-plus"></i></a></span></div></div> <div class="control-group question_div_' + cat_number + '" ><label class="control-label" for="question[' + cat_number + '][' + que_number + ']">Question</label><div class="controls"><select class="select2-select-00 span8  category_' + cat_number + ' questions" rel=' + cat_number + ' que_no=' + que_number + ' name="question[' + cat_number + '][' + que_number + ']" id="question_' + cat_number + '_' + que_number + '"><option>Select</option></select><span class="  span4 pull-right" id="input_cloning_add"><a class="btn btn-small delQue" rel="' + cat_number + '" que="' + que_number + '"><i class="icol-cross"></i></a><a class="btn btn-small addQue" rel="' + cat_number + '" que="' + que_number + '"><i class="icon-plus"></i></a></span></div></div></div> </div>';
            //var category_content = '<div class="blockArea" id="category_div_' + cat_number + '"><div class="form-group"><label class="col-sm-2 control-label" for="">Category</label><div class="col-sm-9"><select class="form-control category" name="category[' + cat_number + ']" id="category_' + cat_number + '"  rel = "' + cat_number + '">' + category_options + '</select></div><div class="col-sm-1 padL0"><div class="pull-right btn btnIcon bgGreen btnAdd addCat" rel="' + cat_number + '">&nbsp;</div><div class="pull-right btn btnIcon bgRed btnCancel mrzR5 delCat" rel="' + cat_number + '" >&nbsp;</div></div></div><div class="form-group question_div_' + cat_number + '"><label class="col-sm-2 control-label padL40" for="question[' + cat_number + '][' + que_number + ']">Question</label><div class="col-sm-8"><select class="form-control category_' + cat_number + ' questions" rel=' + cat_number + ' que_no=' + que_number + ' name="question[' + cat_number + '][' + que_number + ']" id="question_' + cat_number + '_' + que_number + '"><option>Select</option></select></div><div class="col-sm-1 padL0"><div class="pull-right btn btnIcon bgGreen btnAdd addQue" rel="' + cat_number + '" que="' + que_number + '">&nbsp;</div></div></div></div>';
            $(this).parent().parent().parent().parent().parent().after(category_content);
            
            cat_number++;
            que_number++;
        }
    });

    $("#show_preview").click(function () {
        $("#form_preview_title").html($("#name").val());
        $("#form_preview_questions").html("Please Wait..");
        var que_content = '';
        var actionurl = "{{route('form.preview')}}";
        $.ajax({
            url: actionurl,
            type: 'post',
            data: $("#form_frm").serialize(),
            success: function (data) {
                $("#form_preview_questions").html(data);
            }
        });

//            $(".category").each(function () {
//                var cat_opt_id = $(this).attr("id");
//                var cat_opt_rel = $(this).attr("rel");
//                var cat_opt_text = $("#" + cat_opt_id + " option:selected").text();
//                que_content += '<p>' + cat_opt_text + '</p><ol>';
//                $(".category_" + cat_opt_rel).each(function () {
//                    var que_opt_id = $(this).attr("id");
//                    var que_opt_text = $("#" + que_opt_id + " option:selected").text();
//                    que_content += '<li>' + que_opt_text + '</li>';
//                });
//                que_content += '</ol>';
//            });
//            
    });
});
</script>
<script>
    //function to category duplicate values
    $("#form_frm").on("click", ".category", function () {
        var cat_rel = $(this).attr("rel");
        //var category_options = $("#category_" + cat_rel).html();
        var sel_list = [];
        var sel_val = $(this).val();
        $("#category_" + cat_rel).html("<option value=''>Select</option>");
        var cat_options = $('#category_hid_0').html();
        $("#category_" + cat_rel).html(cat_options);

        $('.category').each(function () {
            var cat_val = $(this).val()
            if (sel_val != cat_val && cat_val != '') {
                sel_list.push($(this).val());
                $("#category_" + cat_rel + " option[value=" + cat_val + "]").remove();
            }
        });
        if (sel_val != '') {
            $("#category_" + cat_rel + " option[value=" + sel_val + "]").attr('selected', 'selected');
        }


        /*var actionurl = "{{route('form.getCatInfo')}}";
         $.ajax({
         url: actionurl,
         type: 'post',
         async: false,
         data: {'_token': $('meta[name=_token]').attr('content'), 'sel_list': sel_list, 'sel_val': sel_val},
         success: function (data) {
         // console.log('ajax');
         $("#category_" + cat_rel).html('Please wait.............');
         $("#category_" + cat_rel).html(data); 
         /*if (sel_val != '') {
         $('#category_' + cat_rel + ' option[value=' + sel_val + ']').attr('selected', 'selected');
         }*/
        /*  }
         });*/

    });
    //function to questions duplicate values
    $("#form_frm").on("click", ".questions", function () {

        var cat_rel = $(this).attr("rel");
        var que_no = $(this).attr('que_no');
        // alert(cat_rel);
        // var category_options = $("#category_" + cat_rel).html();
        var sel_list = [];
        var sel_val = $(this).val();
        //if (sel_val != '') { 
        $('.category_' + cat_rel).each(function () {
            var sel_rel = $(this).attr("rel");
            sel_list.push($(this).val());
            var cat_val = $(this).val();
            if (sel_val != cat_val && cat_val != '') {
                $("#question_" + cat_rel + "_" + que_no + " option[value=" + cat_val + "]").remove();
            }


        });
        // console.log(sel_list);
        //}

    });
</script>
<script>
$('#form-sub').click(function(){
    if($('#name').val().trim()==''){
        $('#name-err').html('The name field is required.');
        $('#name').focus();
        return false;
    } 
});
</script>


<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>