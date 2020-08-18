<script language="javascript">
    // Encode special characters
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    
    // Translation characters
    var translation = {
        "mm103":htmlEntities("<?php echo $this->lang->line("mm103"); ?>"),
        "mm111":htmlEntities("<?php echo $this->lang->line("mm111"); ?>"),
        "mm112":htmlEntities("<?php echo $this->lang->line("mm112"); ?>"),
        "mm113":htmlEntities("<?php echo $this->lang->line("mm113"); ?>"),
        "mm116":htmlEntities("<?php echo $this->lang->line("mm116"); ?>"),
        "mm104":htmlEntities("<?php echo $this->lang->line("mm104"); ?>"),
        "mm105":htmlEntities("<?php echo $this->lang->line("mm105"); ?>"),
        "mm106":htmlEntities("<?php echo $this->lang->line("mm106"); ?>"),
        "mm107":htmlEntities("<?php echo $this->lang->line("mm107"); ?>"),
        "mm3":htmlEntities("<?php echo $this->lang->line("mm3"); ?>"),
        "mm142":htmlEntities("<?php echo $this->lang->line("mm142"); ?>"),
        "mm143":htmlEntities("<?php echo $this->lang->line("mm143"); ?>"),
        "mm144":htmlEntities("<?php echo $this->lang->line("mm144"); ?>"),
        "mm145":htmlEntities("<?php echo $this->lang->line("mm145"); ?>"),
        "mm187":htmlEntities("<?php echo $this->lang->line("mm187"); ?>"),
        "mm188":htmlEntities("<?php echo $this->lang->line("mm188"); ?>"),
        "ma18":htmlEntities("<?php echo $this->lang->line("ma18"); ?>"),
        "ma91":htmlEntities("<?php echo $this->lang->line("ma91"); ?>"),
        "ma141":htmlEntities("<?php echo $this->lang->line("ma141"); ?>"),
        "ma142":htmlEntities("<?php echo $this->lang->line("ma142"); ?>"),
        "mm128":htmlEntities("<?php echo $this->lang->line("mm128"); ?>"),
        "mm129":htmlEntities("<?php echo $this->lang->line("mm129"); ?>"),
        "mm200":htmlEntities("<?php echo $this->lang->line("mm200"); ?>"),
        "mm201":htmlEntities("<?php echo $this->lang->line("mm201"); ?>"),
        "mm130":htmlEntities("<?php echo $this->lang->line("mm130"); ?>"),
        "mm154":htmlEntities("<?php echo $this->lang->line("mm154"); ?>"),
        "mm135":htmlEntities("<?php echo $this->lang->line("mm135"); ?>")
    };
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/main.js?ver=<?php echo MD_VER ?>"></script>
<?php if ($this->router->fetch_method() === 'dashboard'): ?>
    <script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/morris-0.4.1.min.js"></script>
    <?php
    $sent_posts = "";
    $colors = "";
    if($sent)
	{
        foreach ($sent as $key => $value) {
            $sent_posts .= '{label: "' . ucwords(str_replace("_"," ",$key)) . '", value: ' . $value . '},';
            switch ($key) {
                case 'blogger':
                    $colors .= "'#f1a56b',";
                    break;
                case 'facebook':
                    $colors .= "'#86B9EA',";
                    break;
                case 'facebook_pages':
                    $colors .= "'#5492d3',";
                    break;
                case 'facebook_groups':
                    $colors .= "'#365899',";
                    break;
                case 'linkedin':
                    $colors .= "'#287bbc',";
                    break;
                case 'instagram':
                    $colors .= "'#517fa6',";
                    break;
                case 'medium':
                    $colors .= "'#4fffbd',";
                    break;
                case 'pinterest':
                    $colors .= "'#ff80a3',";
                    break;
                case 'tumblr':
                    $colors .= "'#AACAE8',";
                    break;
                case 'twitter':
                    $colors .= "'#7BDFE8',";
                    break;
                case 'vk':
                    $colors .= "'#9aabc3',";
                    break;
                case 'wordpress':
                    $colors .= "'#52c6fb',";
                    break;
                case 'flickr':
                    $colors .= "'#ea85b6',";
                    break;
                case 'reddit':
                    $colors .= "'#e1584b',";
                    break;
                case 'youtube':
                    $colors .= "'#ca3737',";
                    break;
                case 'google_plus':
                    $colors .= "'#dd4b39',";
                    break;
                case 'dailymotion':
                    $colors .= "'#0066dc',";
                    break;
                case 'imgur':
                    $colors .= "'#1bb76e',";
                    break;
                default:
                    $colors .= "'#" . rand(100000, 999999) . "',"; // get a random color
                    break;
            }
        }
        $colors = substr($colors, 0, -1);
    }
    ?>
    <script language="javascript">
        jQuery(".order-by ul li a").click(function (e)
        {
            e.preventDefault();
            var num = jQuery(this).attr("data-time");
            jQuery(".order-by ul li a").removeClass("active");
            jQuery(this).addClass("active");
			show_admin_statistics(num);
        });
        function statistics(dati)
        {
            // display statistics in Dashboard
            Morris.Area({
                element: 'statistics',
                data: dati,
                xkey: 'period',
                xLabelFormat: function (date) {
                    return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                },
                xLabels: 'day',
                ykeys: ['newusers'],
                labels: ['New Users'],
                pointSize: 2,
                hideHover: 'auto',
                lineColors: ['#AACAE8'],
                lineWidth: 1,
            });
        }
        Morris.Donut({
            element: 'soci-networks',
            data: [<?php echo $sent_posts ?>],
            colors: [<?php echo $colors ?>]
        });
        function show_admin_statistics(num)
        {
            // display admin statistics
            var url = jQuery(".navbar-brand").attr("href");
            jQuery.ajax({
                url: url + "admin/statistics/" + num,
                type: "GET",
                dataType: "json",
                success: function (data)
                {
                    var dati = eval(data);
                    jQuery("#statistics").empty();
                    statistics(dati);
                },
                error: function (jqXHR, textStatus)
                {
                    console.log("Request failed:" + textStatus);
                }
            });
        }
        // show statistics from the last week
        if (jQuery(document).width() > 1500)
        {
            show_admin_statistics(7);
        }
        else
        {
            setTimeout(function () {
                show_admin_statistics(7);
            }, 1000);
        }
    </script>
<?php elseif (($this->router->fetch_method() === 'scheduled_posts')): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/scheduled.js?ver=<?php echo MD_VER ?>"></script>
<?php elseif (($this->router->fetch_method() === 'users') || ($this->router->fetch_method() === 'new_user') || ($this->router->fetch_method() === 'user_activities')): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/users.js?ver=<?php echo MD_VER ?>"></script>
<?php elseif (($this->router->fetch_method() === 'settings') || ($this->router->fetch_method() === 'appearance') || ($this->router->fetch_method() === 'network') || ($this->router->fetch_method() === 'payment') || ($this->router->fetch_method() === 'tools') || ($this->router->fetch_method() === 'manage_bots')): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/settings.js?ver=<?php echo MD_VER ?>"></script>
<?php elseif (($this->router->fetch_method() === 'admin_plans')): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/plans.js?ver=<?php echo MD_VER ?>"></script>
<?php elseif (($this->router->fetch_method() === 'all_tickets') || ($this->router->fetch_method() === 'new_faq_article') || ($this->router->fetch_method() === 'faq_articles')): ?>
    <script src="<?php echo base_url(); ?>assets/admin/summernote/dist/summernote.js"></script>   
    <script src="<?php echo base_url(); ?>assets/admin/js/tickets.js?ver=<?php echo MD_VER ?>"></script>
    <script language="javascript">
        translation.mi26 = htmlEntities("<?php echo $this->lang->line('mi26'); ?>");
        translation.mi27 = htmlEntities("<?php echo $this->lang->line('mi27'); ?>");
        translation.mi29 = htmlEntities("<?php echo $this->lang->line('mi29'); ?>");
        translation.mi30 = htmlEntities("<?php echo $this->lang->line('mi30'); ?>");
        translation.mi31 = htmlEntities("<?php echo $this->lang->line('mi31'); ?>");
        translation.mi32 = htmlEntities("<?php echo $this->lang->line('mi32'); ?>");
    </script>
<?php elseif ( ($this->router->fetch_method() === 'notifications') || ($this->router->fetch_method() === 'terms_policies') || ($this->router->fetch_method() === 'all_guides') || ($this->router->fetch_method() === 'contents') ): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/settings.js?ver=<?php echo MD_VER ?>"></script>
    <script src="<?php echo base_url(); ?>assets/admin/summernote/dist/summernote.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/notifications.js?ver=<?php echo MD_VER ?>"></script>
    <script language="javascript">
        translation.ma11 = htmlEntities("<?php echo $this->lang->line('ma11'); ?>");
        translation.ma249 = htmlEntities("<?php echo $this->lang->line('ma249'); ?>");
    </script>    
<?php elseif ( ($this->router->fetch_method() === 'codes') ): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/coupon-codes.js?ver=<?php echo MD_VER ?>"></script>
<?php elseif ( ($this->router->fetch_method() === 'admin_apps') ): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/apps.js?ver=<?php echo MD_VER ?>"></script>    
<?php elseif ( ($this->router->fetch_method() === 'invoice_settings') || ($this->router->fetch_method() === 'invoices') ): ?>
    <script src="<?php echo base_url(); ?>assets/admin/js/settings.js?ver=<?php echo MD_VER ?>"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/invoices.js?ver=<?php echo MD_VER ?>"></script>
    <script src="<?php echo base_url(); ?>assets/user/js/bootstrap-datetimepicker.js"></script>
    <script language="javascript">
        translation.ma210 = htmlEntities("<?php echo $this->lang->line('ma210'); ?>");
        translation.ma211 = htmlEntities("<?php echo $this->lang->line('ma211'); ?>");
        translation.ma212 = htmlEntities("<?php echo $this->lang->line('ma212'); ?>");
        translation.ma214 = htmlEntities("<?php echo $this->lang->line('ma214'); ?>");
    </script>
<?php endif; ?>
<?php
if ( isset($component_scripts) ) {
?>
<!-- Custom Scripts -->
<?php
echo $component_scripts;
}
?>
<?php 
if ( function_exists('md_the_component_variable') ) {
    md_get_the_js_urls();
}
?>
</body>
</html>