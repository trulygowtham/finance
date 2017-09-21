<title>Check List - User Forms Details</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('form.getUserForms') }}">User Forms</a>
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">View</a>
            </li>
        </ul>

        <h1 id="main-heading">
            {{ $form_data->form_name }} <span>    </span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">Basic Details</span>
                </div>
                <div class="widget-content table-container">

                    <table class="table table-striped table-detail-view">
                        <tbody>

                            <tr>
                                <th>Number</th>
                                <td>{{ @$form_data->form_number }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{  @$form_data->description }}</td>
                            </tr>
<!--                            <tr>
                                <th>User</th>
                                <td>{{ @$form_data->name }} {{ @$form_data->last_name }}</td>
                            </tr>-->
                            <tr>
                                <th>Created Date</th>
                                <td>{{  dateTimeFormat(@$form_data->created_at) }}</td>
                            </tr>
                            <tr>
                                <th>Current Status</th>
                                <td><?php if(@$form_data->status == "2" ){
                                    echo '<button class="btn btn-mini btn-success">Completed</button>';
                                }else if(@$form_data->status == "3" ){
                                    echo '<button class="btn btn-mini btn-danger">Cancelled</button>';
                                }else{
                                    echo '<button class="btn btn-mini btn-info">Pending</button>';
                                } ?></td>
                            </tr>
<!--                            <tr>
                                <th>% of completion</th>
                                <td><div class="progress">
                                                                <div class="bar" style="width: 67%; ">67%</div>
                                                            </div></td>
                            </tr>-->
                            
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        @foreach($form_data->form_info as $iqKey=>$iqVal ) 
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"> {{@$iqVal['cat_name']}}</span>
                    <div class="toolbar">
                        <span class="label label-success">{{@$iqVal['percentage']}}%</span>

                    </div>
                </div>
                <div class="widget-content form-container">
                    @foreach($iqVal['questions'] as $iiqKey=>$iiqVal ) 
                    <div class="control-group">
                        <label class="control-label" for="input06"><b>{{@$iiqVal['name']}}</b></label>
                        @if (in_array(@$iiqVal['options']['option_type'], array('input', 'textarea')))                        
                        <div class="controls">
                            @for($i = 0; $i < @$iiqVal['options']['no_of_options']; $i++)
                            @if(@$iiqVal['options']['option_type'] == "input")
                            <input type="text" class="span12" id="input06" value="<?php echo isset($iiqVal['answers'][$i]) ? $iiqVal['answers'][$i] : '' ?>"  />
                            @endif

                            @if(@$iiqVal['options']['option_type'] == "textarea")
                            <textarea class="span12" placeholder="Enter form text" name="Name" rows="1" cols="1"><?php echo isset($iiqVal['answers'][$i]) ? $iiqVal['answers'][$i] : '' ?></textarea>
                            @endif

                            @endfor
                        </div>
                        @endif

                        @if (in_array(@$iiqVal['options']['option_type'], array('radio', 'checkbox')))
                        <div class="controls">
                            @foreach(@$iiqVal['options']['options'] as $optKey=>$optVal)
                            @if(@$iiqVal['options']['option_type'] == "radio")
                            <label class="radio">
                                <input type="radio" value="option1" class="uniform" <?php echo (isset($iiqVal['answers'][$optKey]) && $iiqVal['answers'][$optKey] == true) ? 'checked' : '' ?>/>
                                {{$optVal}}
                            </label>
                            @endif

                            @if(@$iiqVal['options']['option_type'] == "checkbox")
                            <label class="checkbox">
                                <input type="checkbox" value="option1" class="uniform" <?php echo (isset($iiqVal['answers'][$optKey]) && $iiqVal['answers'][$optKey] == true) ? 'checked' : '' ?>/>
                                {{$optVal}}
                            </label>
                            @endif
                            @endforeach

                        </div>
                        @endif

                        @if (in_array(@$iiqVal['options']['option_type'], array('dropdown')))
                        <div class="controls">
                            <select id="input07" class="span12">
                                <option value="">Select</option>
                                @foreach(@$iiqVal['options']['options'] as $optKey=>$optVal)
                                <option value="{{$optVal}}" <?php echo (isset($iiqVal['answers'][$optKey]) && $iiqVal['answers'][$optKey] == true) ? 'selected' : '' ?>>{{$optVal}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>
<!-- Select2 -->

