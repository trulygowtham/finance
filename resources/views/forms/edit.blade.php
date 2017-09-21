<title>Check List - Update Template</title>
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
                <a href="#">Update</a>
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
                                    <input type="text" id="name" name="name" class="span12" value="{{ old('name', @$form_data->name) }}"/>
                                    @if ($errors->has('name'))
                                    <div class="help-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="description">Template Description</label>
                                <div class="controls">
                                    <textarea id="description" name="description" class="span12" value="{{ old('description', @$form_data->description) }}" ></textarea>
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
                                        <option value="2"  <?php echo (@$form_data->status == 2) ? 'SELECTED' : ''; ?> >Draft</option>
                                        <option value="1"  <?php echo (@$form_data->status == 1) ? 'SELECTED' : ''; ?> >Completed</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $i = 0;
                    $k = 0;
                    @endphp
                    <select style="display:none" class="form-control category_hid" name="category_hid[0]" id="category_hid_0"  rel = "0">
                        <option value="">Select</option>
                        @foreach($category as $cats)
                        <option value="{{ $cats->id }}">{{ $cats->name }}</option>
                        @endforeach
                    </select>
                    @php
$catArr = array();
@endphp
                    @foreach(@$form_data->questions as $iqKey=>$iqVal )
                    <div class="widget"  id="category_div_{{$i}}">
                        <div class="widget-content form-container">
                            <div class="control-group shoppingcart" >
                                <label class="control-label" for="category[{{$i}}]">Category</label>
                                <div class="controls">

                                    <select class="select2-select-00 span10 category" name="category[{{$i}}]" id="category_{{$i}}"  rel = "{{$i}}"  data-placeholder="Select a category">
                                        <option value="">Select</option>
                                        @foreach($category as $cats)
                                        <option value="{{ $cats->id }}" <?php echo ($cats->id == $iqKey) ? 'SELECTED' : ''; ?>>{{ $cats->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="  span2 pull-right" id="input_cloning_add">

                                        <a class="btn btn-mini btn-success addCat" rel="{{$i}}"><i class="icon-plus"></i></a> 
                                        @if(@$i>0)
                                        <a class="btn btn-small delCat" rel="{{$i}}"><i class="icol-cross"></i></a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @php
                            $j = 0; 
                            $catArr[] = $iqKey;
                            @endphp
                            
                            <select style="display:none" class="form-control question_hid_{{$iqKey}}" name="question_hid[{{$iqKey}}]" id="question_hid_{{$iqKey}}" >
                                <option value="">Select</option>
                                <?php if (isset($allQuestions[$iqKey])) { ?>
                                    @foreach(@$allQuestions[$iqKey] as $qRow)
                                    <option value='{{$qRow->id}}' >{{$qRow->name}}</option>
                                    @endforeach 
                                <?php } ?>
                            </select>
                            
                            @foreach(@$form_data->questions[$iqKey] as $iiqKey=>$iiqVal ) 
                            <div class="control-group question_div_{{$j}}" >
                                <label class="control-label" for="question[{{$i}}][{{$j}}]">Question</label>
                                <div class="controls">
                                    <select class="select2-select-00 span8  category_{{$i}} questions" que_no="{{$j}}" rel="{{$i}}" name="question[{{$i}}][{{$j}}]" id="question_{{$i}}_{{$j}}">
                                        <option value="">Select</option>
                                        <?php if (isset($allQuestions[$iqKey])) { ?>
                                            @foreach(@$allQuestions[$iqKey] as $qRow)
                                            <option value='{{$qRow->id}}' <?php echo ($qRow->id == $iiqVal) ? 'SELECTED' : ''; ?> >{{$qRow->name}}</option>
                                            @endforeach 
                                        <?php } ?>
                                    </select>
                                    <span class="  span4 pull-right" id="input_cloning_add">

                                        <a class="btn btn-mini btn-success addQue" rel="0" que="0" cat_id="<?php echo $iqKey; ?>"><i class="icon-plus"></i></a>   
                                        @if(@$j>0)
                                        <a class="btn btn-small delQue" rel="0"><i class="icol-cross"></i></a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @php
                            $j++;
                            $k++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                    <div class="widget">
                        <div class="widget-content" style="text-align: center;">
                            <div class="btn-toolbar">
                                <button class="btn btn-primary" id="show_preview" data-toggle="modal" data-target="#myModal">Preview</button>
                                <button class="btn btn-success" type="submit">Update</button>
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
   var cat_number = {{count($form_data->questions)}};
     var que_number = {{$k}};
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
            var cat_id = $(this).attr("cat_id");
            
             var isCatExist = 0;
             <?php foreach($catArr as $cat_row_id){ ?>
                 if(cat_id==<?php echo $cat_row_id; ?>){
                     isCatExist = 1;
                 }
             <?php } ?>
                 if(isCatExist==1){
                    var question_options = $('#question_hid_' + cat_id).html(); 
                }else{
                    var question_options = $('#question_' + cat_rel + '_' + que_rel).html();
                }
            //var question_options = $('#question_' + cat_rel + '_' + que_rel).html();
           
            var question_content = '<div class="control-group question_div_' + cat_rel + '" ><label class="control-label" for="question[' + cat_rel + '][' + que_number + ']">Question</label><div class="controls"><select class="select2-select-00 span8  category_' + cat_rel + ' questions" rel=' + cat_rel + ' que_no=' + que_number + ' name="question[' + cat_rel + '][' + que_number + ']" id="question_' + cat_rel + '_' + que_number + '">' + question_options + '</select><span class="  span4 pull-right" id="input_cloning_add"><a class="btn btn-mini btn-success addQue" rel="' + cat_rel + '" que="' + que_number + '" cat_id="' + cat_id + '"><i class="icon-plus"></i></a><a class="btn btn-small delQue" rel="' + cat_rel + '"><i class="icol-cross"></i></a>  </span></div> </div>';

            $(this).parent().parent().parent().after(question_content);
            que_number++;
        }
    });

    // Add Category
    $("#form_frm").on("click", ".addCat", function () {
        if (true) { //confirm("Are you sure you want add another category?")

            var cat_rel = $(this).attr("rel");
            var cat_id = $(this).val();
            var category_options = $("#category_hid_0").html();//"<option value=''>Select</option>";//$("#category_" + cat_rel).html();//
            var category_content = '<div class="widget"  id="category_div_' + cat_number + '"><div class="widget-content form-container"><div class="control-group shoppingcart" ><label class="control-label" for="category[' + cat_number + ']">Category</label><div class="controls"><select class="select2-select-00 span10 category" name="category[' + cat_number + ']" id="category_' + cat_number + '"  rel = "' + cat_number + '"  data-placeholder="Select a category">' + category_options + '</select><span class="span2 pull-right" id="input_cloning_add"><a class="btn btn-mini btn-success addCat" rel="' + cat_number + '"><i class="icon-plus"></i></a><a class="btn btn-small delCat" rel="' + cat_number + '"><i class="icol-cross"></i></a></span></div></div> <div class="control-group question_div_' + cat_number + '" ><label class="control-label" for="question[' + cat_number + '][' + que_number + ']">Question</label><div class="controls"><select class="select2-select-00 span8  category_' + cat_number + ' questions" rel=' + cat_number + ' que_no=' + que_number + ' name="question[' + cat_number + '][' + que_number + ']" id="question_' + cat_number + '_' + que_number + '"><option>Select</option></select><span class="  span4 pull-right" id="input_cloning_add"><a class="btn btn-mini btn-success addQue" rel="' + cat_number + '" que="' + que_number + '" cat_id="' + cat_id + '"><i class="icon-plus"></i></a><a class="btn btn-small delQue" rel="' + cat_number + '" que="' + que_number + '"><i class="icol-cross"></i></a></span></div></div></div> </div>';
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
        // alert("#question_" + cat_rel + "_" + que_no );
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