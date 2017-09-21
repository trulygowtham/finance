<title>Check List - Profile</title>
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>Checklist
                <span class="divider">&raquo;</span>
            </li>
            <li>
                <a href="#">Profile Page</a>
            </li>
        </ul>
    </div>

    <div id="main-content">

        <?php
        $path = url('public/images');
        $file_name = @$users->profile_avatar;
        if ($file_name == "") {
            $path = url('public/assets/images');
            $file_name = 'person.jpg';
        }
        ?>
        @if (session('success-status'))
        <div class="alert alert-success">
            {{ session('success-status') }}
        </div>
        @endif
        @if (session('error-status'))
        <div class="alert alert-danger">
            {{ session('error-status') }}
        </div>
        @endif
        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ old('name', @$users->name.' '.@$users->last_name) }} ({{ old('name', @$users->username) }})</h1>
                        <ul class="profile-attributes">
<!--                            <li><i class="icon-map-marker"></i> Seoul, South Korea</li>-->
                            <li><i class="icon-briefcase"></i> {{ old('name', @$users->title) }}</li>
                        </ul>
                    </div>
                    <!--                    <div class="btn-toolbar pull-right">
                                            <a href="#" class="btn btn-primary"><i class="icon-envelope"></i> Send Message</a>
                                            <a href="#" class="btn btn-success"><i class="icon-users"></i> Hire Me</a>
                                        </div>-->
                </div>
                <div class="profile-sidebar">
                    <div class="thumbnail">
                        <img src="<?php echo "$path/$file_name" ?>" alt="" />
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#"><i class="icos-user"></i> Profile</a></li>
                        <li><a href="{{route("profile.update", base64_encode(@$users->id))}}"><i class="icos-cog"></i> Update</a></li>
<!--                        <li><a href="#"><i class="icos-heart-favorite"></i> Apps</a></li>
                        <li><a href="#"><i class="icos-polaroids"></i> Widgets</a></li>-->
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h4 class="sub"><span>About Me</span></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus faucibus tortor, eu imperdiet libero feugiat ut. Proin imperdiet, lectus ut rutrum adipiscing, velit nisl pharetra justo, at egestas quam ante sed ligula. Morbi ac cursus ligula. Curabitur dolor felis, dignissim a consequat lobortis, semper laoreet ante. Aliquam erat volutpat.</p>
                            <p>Cras ligula leo, consectetur a facilisis sed, volutpat ac urna. Duis porta tincidunt tempor. Quisque mi justo, porta vel eleifend quis, pharetra eget lectus. Ut gravida dui eu nibh faucibus ultrices. Nam ipsum nulla, eleifend eu ultrices nec, egestas in magna. Nulla tristique tempor odio a venenatis. Nulla lacinia, erat quis consectetur lobortis, libero magna iaculis turpis, eget sodales libero ante vitae neque. Nunc dolor tortor, viverra eget fringilla nec, varius venenatis massa. Fusce mi mi, molestie ut semper sed, tincidunt id urna. Morbi quis quam suscipit dolor rhoncus cursus non vitae enim. Suspendisse ullamcorper dui urna, id rutrum enim.</p>

                            <h4 class="sub"><span>Job Experience</span></h4>
                            <ul>
                                <li>Duis semper orci ac nulla pretium a tincidunt nibh interdum.</li>
                                <li>Morbi euismod arcu nec felis commodo vel semper ante accumsan.</li>
                                <li>Nulla ullamcorper egestas sem, eu mattis sem mattis vitae.</li>
                                <li>Sed porttitor diam vitae justo egestas aliquam.</li>
                                <li>Phasellus suscipit ante ac mi sodales tempus.</li>
                            </ul>

                            <h4 class="sub"><span>Contact Me</span></h4>
                            <address>
                                1023, Shindaebang-dong, <br />
                                Dongjak-ku<br />
                                Seoul, South Korea<br /><br />
                                <abbr title="Phone">P:</abbr> {{ old('name', @$users->phone) }}<br />
                                <abbr title="Email">E:</abbr> <a href="#">{{ old('email', @$users->email) }}</a>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
