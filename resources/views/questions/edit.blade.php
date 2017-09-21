<!-- PickList -->
<link rel="stylesheet" href="<?php echo asset('public/custom-plugins/picklist/picklist.css') ?>" media="screen" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo asset('public/plugins/select2/select2.css') ?>" media="screen" />
<title>Check List - Update Question Details</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('questions')}}">Question</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Update</a>
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
                    <span class="title">Update Question Details</span>
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
                            <label class="control-label" for="category_id">Category</label>

                            <div class="controls">
                                <select class="select2-select-00 span12" id="category_id" name="category_id"  data-placeholder="Select category">
                                    <option value=""></option>
                                    @foreach($category as $cats)
                                    <option value="{{ $cats->id }}" {{ @$question[0]->category_id == $cats->id ? 'selected="selected"' : '' }}>{{ $cats->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('name'))
                                <div class="help-block">
                                    {{ $errors->first('category_id') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="name">Question</label>

                            <div class="controls">
                                <input type="text" class="span12" name="name" id="name" placeholder="Question" value="{{@$question[0]->name}}" />
                                @if ($errors->has('name'))
                                <div class="help-block">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="option_type">Answer Type</label>

                            <div class="controls">
                                <select class="span12" id="option_type" name="option_type">
                                    <option value="">Answer Type</option>
                                    <option value="input" {{ @$question[0]->options['option_type'] == 'input' ? 'selected="selected"' : '' }}>Input</option>
                                    <option value="textarea" {{ @$question[0]->options['option_type'] == 'textarea' ? 'selected="selected"' : '' }}>Textarea</option>
                                    <option value="dropdown" {{ @$question[0]->options['option_type'] == 'dropdown' ? 'selected="selected"' : '' }}>Dropdown</option>
                                    <option value="radio" {{ @$question[0]->options['option_type'] == 'radio' ? 'selected="selected"' : '' }}>Radio</option>
                                    <option value="checkbox" {{ @$question[0]->options['option_type'] == 'checkbox' ? 'selected="selected"' : '' }}>Checkbox</option>
                                </select>
                                @if ($errors->has('option_type'))
                                <div class="help-block">
                                    {{ $errors->first('option_type') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group no_of_options_div" id="no_of_options_div" style="display: none;">
                            <label class="control-label" for="no_of_options">No. of Options</label>

                            <div class="controls">
                                <input type="number" min="1" value="{{@count($question[0]->options['no_of_options'])}}" class="span12" id="no_of_options" name="no_of_options" placeholder="No. of Options">
                                @if ($errors->has('name'))
                                <div class="help-block">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <?php $mandatoryArr = isset($question[0]->options['mandatory']) ? $question[0]->options['mandatory'] : array(); ?>
                        @if (in_array(@$question[0]->options['option_type'], array('radio', 'checkbox', 'dropdown')))
                        @foreach(@$question[0]->options['options'] as $optKey=>$optVal)
                        <div class="control-group options_cls" id="options_id" style="display: none;">
                            @if ($optKey == 0)
                            <label class="control-label" for="options">Label / Option Name</label>
                            @endif

                            <div class="controls"> 
                                <span class="span10 ">
                                    <input type="text" class="span10" id="options_1" value="{{$optVal}}"  name="options[]" placeholder="Label / Option Name">

                                    <input type="hidden" id="hid_opt_val" value="<?php echo count($question[0]->options['options']); ?>">
                                    <input type="hidden" id="manhid_{{$optKey}}" name="manhid[]" value="<?php echo (isset($mandatoryArr[$optKey]) && $mandatoryArr[$optKey] == 1) ? 1 : 0; ?>"><input type="checkbox" id="mandatory_1" class="chkmandatory" opt_val={{$optKey}} name="mandatory[]" <?php echo (isset($mandatoryArr[$optKey]) && $mandatoryArr[$optKey] == 1) ? 'checked' : ''; ?> value="1" > Is Expected
                                </span>

                                <span class="span2 pull-right" id="input_cloning_add">
                                    <a class="btn btn-mini btn-success option_add_btn">
                                        <i class="icon-plus"></i>
                                    </a>
                                    @if ($optKey > 0)
                                    <a class="btn btn-mini  option_remove_btn">
                                        <i class="icol-cross"></i>
                                    </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="control-group options_cls" id="options_id" style="display: none;">
                            <label class="control-label" for="options">Label / Option Name</label>
                            <div class="controls">
                                <input type="text" class="span10" id="options_1"  name="options[]" placeholder="Label / Option Name">

                                <span class="span2 pull-right" id="input_cloning_add">
                                    <a class="btn btn-mini btn-success option_add_btn">
                                        <i class="icon-plus"></i>
                                    </a>
                                    <!--                        <div class="pull-right btn btnIcon bgRed btnCancel mrzR5  option_remove_btn">
                                                                &nbsp;
                                                            </div>-->
                                </span>
                            </div>
                        </div>
                        @endif
                        <div class="control-group">
                            <label class="control-label" for="description">Description</label>
                            <div class="controls">  
                                <textarea type="text" class="span12" name="description" id="description" placeholder="Description">{{@$question[0]->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{route('questions')}}" ><button type="button" class="btn" type="reset">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Select2 -->

<!-- Bootstrap FileInput -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>
<!-- PickList -->
<script src="<?php echo asset('public/custom-plugins/picklist/picklist.min.js') ?>"></script>





<script>
$(document).ready(function () {
    $('.select2-select-00').select2();
    $("#option_type").change(function () {
        var option_type = $(this).val();
        if (option_type == "") {
            $(".options_cls, .no_of_options_div").hide();
        } else {
            if (jQuery.inArray(option_type, ['input', 'textarea']) >= 0) {
                $(".no_of_options_div").show();
                $(".options_cls").hide();
            } else if (jQuery.inArray(option_type, ['radio', 'checkbox', 'dropdown']) >= 0) {
                $(".no_of_options_div").hide();
                $(".options_cls").show();
                if (jQuery.inArray(option_type, ['radio']) >= 0) {
                    if ($(".option_add_btn").length == 1) {
                        $(".option_add_btn").trigger("click");
                    }
                }
            }
        }
    });

    $("#question_frm").on("click", ".option_add_btn", function () {
        var opt_val = $('#hid_opt_val').val();
        var content = '<div class="control-group  options_cls">\n\
                <div class="controls">\n\
                    <span class="span10 ">\n\ \n\
                     <input type="text" class="span10" id="options_1"  name="options[]" placeholder="Label / Option Name">\n\
                         <input type="hidden" id="manhid_' + opt_val + '" name="manhid[]" value="0">\n\
                            <input type="checkbox" id="mandatory_1" class="chkmandatory" opt_val=' + opt_val + ' name="mandatory[]" value="1" > Is Expected\n\
                     </span>\n\
                       <span class="span2 pull-right">\n\
                           <a class="btn btn-mini btn-success option_add_btn"><i class="icon-plus"></i></a>\n\
                           <a class="btn btn-mini  option_remove_btn"><i class="icol-cross"></i></a>\n\
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
    $("#option_type").trigger("change");
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
<!-- Select2 -->
<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>
