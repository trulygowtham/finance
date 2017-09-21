<title>Check List - Update Department</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{route('group')}}">Departments</a>
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
                    <span class="title">Update Department</span>
                </div>
                <div class="widget-content form-container">
                    @if (session('success-status'))
                    <div class="alert alert-success">
                        {{ session('success-status') }}
                    </div>
                    @endif
                    <form class="form-horizontal"  method="post">
                        {!! csrf_field() !!}
                        <div class="control-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input type="text" id="name" class="span12" name="name" value="{{ old('name', @$groups->name) }}"/>
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
                                <textarea id="description" name="description" class="span12">{{ old('description', @$groups->description) }}</textarea>
                            </div>
                        </div>
                        <?php
                        $user_arr = array();
                        foreach ($user_groups as $user_row) {
                            $user_arr[] = $user_row->user_id;
                        }
                        ?>
                        <div class="control-group">
                            <label class="control-label" for="user_id">Users</label>
                            <div class="controls">
                                <select id="user_id" multiple name="user_id[]" class="select2-select-00 span12" multiple="" size="5" data-placeholder="Select a user">
                                    <option value=''>Select</option>
                                    <?php foreach ($users as $key => $userRow) { ?>
                                        <option value="<?php echo $userRow['id']; ?>" <?php echo in_array($userRow['id'], $user_arr) ? 'SELECTED' : ''; ?>><?php echo $userRow['username'] . '(' . $userRow['name'] . ')'; ?></option>
                                    <?php } ?>
                                </select>
                                @if ($errors->has('group_id'))
                                <div class="help-block">
                                    {{ $errors->first('group_id') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn" type="reset">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Select2 -->

