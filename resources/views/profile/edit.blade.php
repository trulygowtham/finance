<!-- Bootstrap InputMask -->
<script src="<?php echo asset('public/custom-plugins/bootstrap-inputmask.min.js') ?>"></script>
  
<title>Check List - Dashboard</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="{{ url('/profile') }}">Profile Page</a>
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
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <span class="title">Profile Update</span>
                    </div>
                    <div class="widget-content form-container">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="control-group">
                                <label class="control-label" for="name">First Name</label>
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
                                <label class="control-label" for="last_name">Last Name</label>
                                <div class="controls">
                                    <input type="text" id="last_name" name="last_name" class="span12" value="{{ old('last_name', @$users->last_name) }}"/>
                                    @if ($errors->has('last_name'))
                                    <div class="help-block">
                                        {{ $errors->first('last_name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="title">Title </label>
                                <div class="controls">
                                    <input type="text" id="title" name="title" class="span12" value="{{ old('title', @$users->title) }}"/>
                                    @if ($errors->has('title'))
                                    <div class="help-block">
                                        {{ $errors->first('title') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="title">Email </label>
                                <div class="controls">
                                    <input type="email" id="email" name="email" class="span12" value="{{ old('email', @$users->email) }}"/>
                                    @if ($errors->has('email'))
                                    <div class="help-block">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="phone">Contact No.</label>
                                <div class="controls">
                                    <input type="text" id="phone" name="phone" data-mask="(999)-999-9999" class="span12" value="{{ old('phone', @$users->phone) }}"/>
                                    @if ($errors->has('phone'))
                                    <div class="help-block">
                                        {{ $errors->first('phone') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Change Password</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="isChangePass" name="isChangePass" <?php echo (old('isChangePass') != '') ? 'checked' : '' ?>  value="1"/>
                                        Yes
                                    </label>                                    
                                </div>
                            </div>

                            <div class="control-group showPass"  style="display: none;">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" class="span12" value="{{ old('password') }}"/>
                                    @if ($errors->has('password'))
                                    <div class="help-block">
                                        {{ $errors->first('password') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group showPass"  style="display: none;">
                                <label class="control-label" for="confirm_password">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="confirm_password" name="confirm_password" class="span12" value="{{ old('confirm_password') }}"/>
                                    @if ($errors->has('confirm_password'))
                                    <div class="help-block">
                                        {{ $errors->first('confirm_password') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <?php
                $path = url('/public/images');
                $file_name = @$users->profile_avatar;
                ?>
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
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn" type="reset">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
<script>
    jQuery(document).ready(function () {
        jQuery('#isChangePass').click(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('.showPass').show();
            } else {
                jQuery('.showPass').hide();
            }
        });
        <?php if (old('isChangePass') != '') { ?>
                    jQuery('.showPass').show();
        <?php } ?>
    });
</script>
<!-- Bootstrap FileInput -->
    <script src="<?php echo asset('public/custom-plugins/bootstrap-fileinput.min.js') ?>"></script>
