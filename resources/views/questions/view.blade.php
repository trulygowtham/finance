
<title>Check List - View Template</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{ route('questions') }}">Questions</a>
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
                    <span class="title"> {{ old('name', @$question[0]->category_name) }}</span>
                </div>
                <div class="widget-content form-container">

                    <div class="control-group">
                        <label class="control-label" for="input06"><b>{{ old('name', @$question[0]->name) }} ({{@$question[0]->description}})</b></label>
                        @if (in_array(@$question[0]->options['option_type'], array('input', 'textarea')))
                        <div class="controls">
                            @for($i = 0; $i < @count($question[0]->options['no_of_options']); $i++)
                            @if(@$question[0]->options['option_type'] == "input")
                            <input type="text" class="span12" id="input06" />
                            @endif

                            @if(@$question[0]->options['option_type'] == "textarea")
                            <textarea class="span12" placeholder="Enter form text" name="Name" rows="1" cols="1"></textarea>
                            @endif

                            @endfor
                        </div>
                        @endif
                        <?php $mandatoryArr = isset($question[0]->options['mandatory']) ? $question[0]->options['mandatory'] : array(); ?>
                        @if (in_array(@$question[0]->options['option_type'], array('radio', 'checkbox'))) 
                        <div class="controls">
                            @foreach(@$question[0]->options['options'] as $optKey=>$optVal)
                            @if(@$question[0]->options['option_type'] == "radio")
                            <label class="radio">
                                <input type="radio" value="option1" class="uniform" />
                                {{$optVal}}
                                <?php echo (isset($mandatoryArr[$optKey]) && $mandatoryArr[$optKey] == 1) ? ' (Manadatory)' : ''; ?>
                            </label>
                            @endif

                            @if(@$question[0]->options['option_type'] == "checkbox")
                            <label class="checkbox">
                                <input type="checkbox" value="option1" class="uniform" />
                                {{$optVal}}
                            </label>
                            @endif
                            @endforeach

                        </div>
                        @endif

                        @if (in_array(@$question[0]->options['option_type'], array('dropdown')))
                        <div class="controls">
                            <select id="input07" class="span12">
                                <option value="">Select</option>
                                @foreach(@$question[0]->options['options'] as $optKey=>$optVal)
                                <option value="{{$optVal}}">{{$optVal}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>


    </div>
</section>
<!-- Select2 -->





