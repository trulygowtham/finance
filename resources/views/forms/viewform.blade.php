 @foreach(@$form_data->questions as $iqKey=>$iqVal )       
        <div class="row-fluid">
            
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"> {{@$category[$iqKey]}}</span>
                </div>
                <div class="widget-content form-container">
                    @foreach(@$form_data->questions[$iqKey] as $iiqKey=>$iiqVal ) 
                    <div class="control-group">
                        <label class="control-label" for="input06"><b>{{@$questions[$iiqVal]['name']}}</b></label>
                        @if (in_array(@$questions[$iiqVal]['options']['option_type'], array('input', 'textarea')))
                        <div class="controls">
                            @for($i = 0; $i < @$questions[$iiqVal]['options']['no_of_options']; $i++)
                            @if(@$questions[$iiqVal]['options']['option_type'] == "input")
                            <input type="text" class="span12" id="input06" />
                            @endif

                            @if(@$questions[$iiqVal]['options']['option_type'] == "textarea")
                            <textarea class="span12" placeholder="Enter form text" name="Name" rows="1" cols="1"></textarea>
                            @endif

                            @endfor
                        </div>
                        @endif

                        @if (in_array(@$questions[$iiqVal]['options']['option_type'], array('radio', 'checkbox')))
                        <div class="controls">
                            @foreach(@$questions[$iiqVal]['options']['options'] as $optKey=>$optVal)
                            @if(@$questions[$iiqVal]['options']['option_type'] == "radio")
                            <label class="radio">
                                <input type="radio" value="option1" class="uniform" />
                                {{$optVal}}
                            </label>
                            @endif

                            @if(@$questions[$iiqVal]['options']['option_type'] == "checkbox")
                            <label class="checkbox">
                                <input type="checkbox" value="option1" class="uniform" />
                                {{$optVal}}
                            </label>
                            @endif
                            @endforeach

                        </div>
                        @endif

                        @if (in_array(@$questions[$iiqVal]['options']['option_type'], array('dropdown')))
                        <div class="controls">
                            <select id="input07" class="span12">
                                <option value="">Select</option>
                                @foreach(@$questions[$iiqVal]['options']['options'] as $optKey=>$optVal)
                                <option value="{{$optVal}}">{{$optVal}}</option>
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