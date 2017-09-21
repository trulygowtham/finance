</div>
</div>
</div>
</div>

<footer id="footer">
    <div class="footer-left">Pycubevault - Checklist</div>
    <div class="footer-right"><p>Copyright 2017. All Rights Reserved.</p></div>
</footer>

</div>



<!-- Template Script -->
<!--    <script src = "<?php echo asset('public/assets/js/template.js') ?>"></script>-->
<script src = "<?php echo asset('public/assets/js/setup.js') ?>"></script>

<!-- Customizer, remove if not needed -->
<script src = "<?php echo asset('public/assets/js/customizer.js') ?>"></script>

<!-- Uniform Script -->
<script src = "<?php echo asset('public/plugins/uniform/jquery.uniform.min.js') ?>"></script>

<!-- jquery-ui Scripts -->
<script src = "<?php echo asset('public/assets/jui/js/jquery-ui-1.9.2.min.js') ?>"></script>
<script src = "<?php echo asset('public/assets/jui/jquery-ui.custom.min.js') ?>"></script>
<script src = "<?php echo asset('public/assets/jui/timepicker/jquery-ui-timepicker.min.js') ?>"></script>
<script src = "<?php echo asset('public/assets/jui/jquery.ui.touch-punch.min.js') ?>"></script>

<!-- Plugin Scripts -->

<!-- Flot -->
<!--[if lt IE 9]>
<script src = "<?php echo asset('public/assets/js/libs/excanvas.min.js') ?>"></script>
<![endif]-->
<script src = "<?php echo asset('public/plugins/flot/jquery.flot.min.js') ?>"></script>
<script src = "<?php echo asset('public/plugins/flot/plugins/jquery.flot.tooltip.min.js') ?>"></script>
<script src = "<?php echo asset('public/plugins/flot/plugins/jquery.flot.pie.min.js') ?>"></script>
<script src = "<?php echo asset('public/plugins/flot/plugins/jquery.flot.resize.min.js') ?>"></script>

<!-- Circular Stat -->
<script src = "<?php echo asset('public/custom-plugins/circular-stat/circular-stat.min.js') ?>"></script>

<!-- SparkLine -->
<script src = "<?php echo asset('public/plugins/sparkline/jquery.sparkline.min.js') ?>"></script>

<!-- iButton -->
<script src = "<?php echo asset('public/plugins/ibutton/jquery.ibutton.min.js') ?>"></script>




<!-- Demo Scripts -->
<!--    <script src = "<?php echo asset('public/assets/js/demo/dashboard.js') ?>"></script>-->

<script src="<?php echo asset('public/plugins/select2/select2.min.js') ?>"></script>


<script>
    function read_notification(id) {
        $("#notification_li_"+id).append("<p>Please wait..</p>");
        var actionurl = "{{route('updateNotification')}}";
        $.ajax({
            url: actionurl,
            type: 'post',
            async: false,
            data: {'id': id, '_token': "<?php echo csrf_token(); ?>"},
            success: function (data) {
               
            }
        });     
        return true; 
    }

</script>
</body>

</html>
