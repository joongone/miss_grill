<?php
global $smof_data, $ts_options;
    echo ts_get_bottom_ad();
?>

        </div>
        
        <div id="footer-copyright-wrap">
            <?php
            ts_footer_widgets();
            ?>
            
            <?php
            if(ts_option_vs_default('show_copyright', 1) == 1) :
            ?>
            <div id="copyright-nav-wrap">
                <div id="copyright-nav" class="container">
                    <div class="row">
                        <div class="copyright span6">
                            <?php $copyright_content = do_shortcode(ts_option_vs_default('copyright_text'));?>
                            <p><?php echo $copyright_content;?></p>
                        </div>
                        <div class="nav span6">
                            <?php
                            wp_nav_menu(array('container' => false, 'theme_location' => 'footer_nav', 'echo' => 1, 'depth' => 1));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php 
$ts_disqus_shortname = ts_option_vs_default('disqus_shortname', '');
if((ts_option_vs_default('use_disqus', 1) == 1) && trim($ts_disqus_shortname)) :
?>
<script type="text/javascript">
/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
var disqus_shortname = '<?php echo esc_attr($ts_disqus_shortname);?>'; // required: replace example with your forum shortname

/* * * DON'T EDIT BELOW THIS LINE * * */
(function () {
    var s = document.createElement('script'); s.async = true;
    s.type = 'text/javascript';
    s.src = '//' + disqus_shortname + '.disqus.com/count.js';
    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>
<?php
endif;
if(ts_enable_style_selector()) :
    get_template_part('style_selector');
endif;
wp_footer();
?>
</body>
</html>