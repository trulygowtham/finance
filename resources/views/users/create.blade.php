<style>
.important-field{
    color : #ff0000;
}
</style>
<!-- Bootstrap InputMask -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-inputmask.min.js') ?>"></script>
    
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
                <a href="{{route('users')}}">Users</a>
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
                    <span class="title">New User</span>
                </div>
                <div class="widget-content form-container">
                    @if (session('success-status'))
                    <div class="alert alert-success">
                        {{ session('success-status') }}
                    </div>
                    @endif
                    <form class="form-horizontal"  method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="control-group">
                            <label class="control-label" for="name">First Name<span class="important-field">*</span></label>
                            <div class="controls">
                                <input type="text" id="name" class="span12" name="name" value="{{ old('name') }}"/>
                                @if ($errors->has('name'))
                                <div class="help-block">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="last_name">Last Name</label>
                            <div class="controls">
                                <input type="text" id="last_name" class="span12" name="last_name" value="{{ old('last_name') }}"/>
                                @if ($errors->has('last_name'))
                                <div class="help-block">
                                    {{ $errors->first('last_name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title">Title</label>
                            <div class="controls">
                                <input type="text" id="title" class="span12" name="title" value="{{ old('title') }}"/>
                                @if ($errors->has('title'))
                                <div class="help-block">
                                    {{ $errors->first('title') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email">Email<span class="important-field">*</span></label>
                            <div class="controls">
                                <input type="text" id="email" class="span12" name="email" value="{{ old('email') }}"/>
                                @if ($errors->has('email'))
                                <div class="help-block">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="phone">Contact No.<span class="important-field">*</span></label>
                            <div class="controls">
                               
                                <input type="text" id="phone" class="span12" data-mask="(999)-999-9999" name="phone" value="{{ old('phone') }}"/>
                                @if ($errors->has('phone'))
                                <div class="help-block">
                                    {{ $errors->first('phone') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <?php
                        $session_data = Session::all();
                        $role_id = $session_data['user'][0]['role_id'];
                        if ($role_id != 4) {
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="role">Role</label>
                                <div class="controls">
                                    <select id="role"  name="role" class="select2-select-00 span12"  >
                                        <option value="2" <?php echo (old('role', @$users->role_id) == 2) ? 'SELECTED' : ''; ?> >User</option>
                                        <option value="4" <?php echo (old('role', @$users->role_id) == 4) ? 'SELECTED' : ''; ?> >Dept Admin</option>
                                    </select>
                                    @if ($errors->has('role'))
                                    <div class="help-block">
                                        {{ $errors->first('role') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <?php $temp_arr = old('group_id', array()); ?>
                            <div class="control-group" id="user-role">
                                <label class="control-label" for="group_id">Departments</label>
                                <div class="controls">
                                    <select id="group_id" multiple name="group_id[]" class="select2-select-00 span12" multiple=""  data-placeholder="Select  departments">
                                        
                                        <?php foreach ($groups as $key => $groupRow) { ?>
                                            <option value="<?php echo $groupRow['id']; ?>" <?php echo (in_array($groupRow['id'], $temp_arr)) ? 'SELECTED' : ''; ?>><?php echo $groupRow['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    @if ($errors->has('group_id'))
                                    <div class="help-block">
                                        {{ $errors->first('group_id') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group" id="dept-role">
                                <label class="control-label" for="group_id">Department</label>
                                <div class="controls">
                                    <select id="group_id"  name="dept_group_id" class="select2-select-00 span12"   data-placeholder="Select a department">
                                        
                                        <?php foreach ($groups as $key => $groupRow) { ?>
                                            <option value="<?php echo $groupRow['id']; ?>" <?php echo (old('dept_group_id', @$users->dept_group_id) == $groupRow['id']) ? 'SELECTED' : ''; ?>><?php echo $groupRow['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    @if ($errors->has('dept_group_id'))
                                    <div class="help-block">
                                        {{ $errors->first('dept_group_id') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        <?php } ?>
                        <div class="control-group">
                            <label class="control-label" for="username">Username<span class="important-field">*</span></label>
                            <div class="controls">
                                <input type="text" id="username" class="span12" name="username" value="{{ old('username') }}"/>
                                @if ($errors->has('username'))
                                <div class="help-block">
                                    {{ $errors->first('username') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="password">Password<span class="important-field">*</span></label>
                            <div class="controls">
                                <input type="password" id="password" class="span12" name="password" value="{{ old('password') }}"/>
                                @if ($errors->has('password'))
                                <div class="help-block">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="confirm_password">Confirm Password<span class="important-field">*</span></label>
                            <div class="controls">
                                <input type="password" id="cofirm_password" class="span12" name="confirm_password" value="{{ old('confirm_password') }}"/>
                                @if ($errors->has('confirm_password'))
                                <div class="help-block">
                                    {{ $errors->first('confirm_password') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="profile_avatar">Profile Avator</label>
                            <div class="controls">
                                <input type="file" id="profile_avatar" name="profile_avatar" data-provide="fileinput" />
                                @if ($errors->has('profile_avatar'))
                                <div class="help-block">
                                    {{ $errors->first('profile_avatar') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <button type="reset" class="btn" type="reset">Clear</button>
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
        $('#dept-role').hide();
<?php if (old('role', @$users->role_id) == '4') { ?>
            $('#dept-role').show();
            $('#user-role').hide();
<?php } ?>
        $('#role').change(function () {
            var role_id = $(this).val().trim();
            if (role_id == "2") {
                $('#dept-role').hide();
                $('#user-role').show();
            }
            if (role_id == "4") {
                $('#dept-role').show();
                $('#user-role').hide();
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