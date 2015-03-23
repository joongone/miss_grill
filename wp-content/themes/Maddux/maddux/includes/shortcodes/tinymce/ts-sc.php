<?php

if ( ! defined( 'ABSPATH' ) ) {
}

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

$popup = (isset($_GET['popup'])) ? trim( $_GET['popup'] ) : '';
$preset = (isset($_GET['preset'])) ? trim( $_GET['preset'] ) : '';
$preset_value = (isset($_GET['preset_value'])) ? trim( $_GET['preset_value'] ) : '';

// presets
if($popup == 'parallax') :
    $popup = 'fullwidth';
    $preset = 'style';
    $preset_value = 'parallax';
endif;

// get popup type
$shortcode = new ts_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="ts-popup">

	<div id="ts-shortcode-wrap">

		<div id="ts-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => __('Choose a Shortcode', 'ThemeStockyard'),
					'_1' => __('Blog &amp; Blog Widget(s)', 'ThemeStockyard'),
                        'blog' => __('Blog', 'ThemeStockyard'),
                        'blog_slider' => __('Blog Slider', 'ThemeStockyard'),
                        'blog_widget' => __('Blog Widget', 'ThemeStockyard'),
					'_2' => __('Columns', 'ThemeStockyard'),
                        'columns' => __('Add Column(s)...', 'ThemeStockyard'),
                    '_3' => __('Elements', 'ThemeStockyard'),
                        'accordion' => __('Accordion', 'ThemeStockyard'),
                        'alert' => __('Alert', 'ThemeStockyard'),
                        'blockquote' => __('Blockquote', 'ThemeStockyard'),
                        'button' => __('Button', 'ThemeStockyard'),
                        'callout' => __('Callout', 'ThemeStockyard'),
                        'code' => __('Code', 'ThemeStockyard'),
                        'googlemap' => __('Google Map', 'ThemeStockyard'),
                        'iconboxes' => __('Iconboxes', 'ThemeStockyard'),
                        'list' => __('List', 'ThemeStockyard'),
                        'pricingtable' => __('Pricing Table', 'ThemeStockyard'),
                        'progressbar' => __('Progress Bar', 'ThemeStockyard'),
                        'social_links' => __('Social Links', 'ThemeStockyard'),
                        'title' => __('Title', 'ThemeStockyard'),
					'_4' => __('Sections', 'ThemeStockyard'),
                        'fullwidth' => __('Full Width Section', 'ThemeStockyard'),
                        'parallax' => __('Parallax Section', 'ThemeStockyard'),
					'_5' => __('Tabs &amp; Toggles', 'ThemeStockyard'),
                        'accordion' => __('Accordion', 'ThemeStockyard'),
                        'tabs' => __('Tabs', 'ThemeStockyard'),
                        'toggles' => __('Toggles', 'ThemeStockyard'),
					'_6' => __('Typography', 'ThemeStockyard'),
                        'small' => __('Small Text', 'ThemeStockyard'),
                        'dropcap' => __('Dropcap', 'ThemeStockyard'),
                        'highlight' => __('Highlight', 'ThemeStockyard'),
                    '_7' => __('Animations', 'ThemeStockyard'),
                        'fadein' => __('Fade In', 'ThemeStockyard'),
                    '_8' => __('Audio &amp; Video', 'ThemeStockyard'),
                        'youtube' => __('Youtube', 'ThemeStockyard'),
                        'vimeo' => __('Vimeo', 'ThemeStockyard'),
                        'soundcloud' => __('SoundCloud', 'ThemeStockyard'),
                    '_9' => __('Dividers', 'ThemeStockyard'),
                        'divider' => __('Add a Divider...', 'ThemeStockyard'),
                    '_10' => __('Galleries &amp; Slideshows', 'ThemeStockyard'),
                        'lightbox_gallery' => __('Lightbox Gallery', 'ThemeStockyard'),
                        'carousel_gallery' => __('Carousel Gallery', 'ThemeStockyard'),
                        'slider_gallery'  => __('Slider Gallery', 'ThemeStockyard'),
                    '_11' => __('Show/Hide', 'ThemeStockyard'),
                        'show_if' => __('Show if...', 'ThemeStockyard'),
                        'hide_if' => __('Hide if...', 'ThemeStockyard'),
                    '_12' => __('Other', 'ThemeStockyard'),
                        'clear' => __('Clear Floats', 'ThemeStockyard'),
                        'email' => __('Email Link', 'ThemeStockyard'),
                        'fontawesome' => __('FontAwesome', 'ThemeStockyard'),
			);
			?>
			<table id="ts-sc-form-table" class="ts-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label"><?php _e('Choose Shortcode','ThemeStockyard');?></td>
						<td class="field">
							<div class="ts-form-select-field">
							<div class="ts-shortcodes-arrow">&#xf107;</div>
								<select name="ts_select_shortcode" id="ts_select_shortcode" class="ts-form-select ts-input">
									<?php 
									$i = 0;
									foreach($select_shortcode as $shortcode_key => $shortcode_value): 
                                        $sdata = '';
                                        if(substr($shortcode_key, 0, 1) == '_') :
                                            if($i > 0) echo '</optgroup>';
                                            
                                            echo '<optgroup label="'.esc_attr($shortcode_value).'">';
                                            
                                            $i++;
                                        else :
                                            if($shortcode_key == $popup) : 
                                                $selected = 'selected="selected"'; 
                                            else : 
                                                $selected = ''; 
                                            endif; 
                                            
                                            if(is_array($shortcode_value)) :
                                                // not yet complete
                                                foreach($shortcode_value AS $svalue) :
                                                    $selected = ($shortcode_key == $popup && $preset_value == $svalue[2]) ? 'selected="selected"' : '';
                                                    $sdata = 'data-preset="'.esc_attr($svalue[1]).'" data-preset-value="'.esc_attr($svalue[2]).'"';
                                                    $sval = $svalue[0];
                                                    echo '<option value="'.esc_attr($shortcode_key).'" '.$selected.' '.$sdata.'>'.$sval.'</option>';
                                                endforeach;
                                            else :
                                                $selected = ($shortcode_key == $popup) ? 'selected="selected"' : '';
                                                echo '<option value="'.esc_attr($shortcode_key).'" '.$selected.'>'.$shortcode_value.'</option>';
                                            endif;
                                        endif;
									endforeach; 
									if($i > 0) echo '</optgroup>';
									?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="ts-sc-form">

				<table id="ts-sc-form-table">

					<?php echo $shortcode->output;?>
                    
                    <?php
                    if($preset && $preset_value) :
                    ?>
                    <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        if($('#ts-sc-form-table #ts_<?php echo esc_js($preset);?>').length) {
                            $('#ts-sc-form-table #ts_<?php echo esc_js($preset);?>').val('<?php echo esc_js($preset_value);?>');
                        }
                    });
                    </script>
                    <?php
                    endif;
                    ?>
                    
					<tbody class="ts-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="javascript:void(0)" class="ts-insert"><?php _e('Insert Shortcode','ThemeStockyard');?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#ts-sc-form-table -->

			</form>
			<!-- /#ts-sc-form -->

		</div>
		<!-- /#ts-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#ts-shortcode-wrap -->

</div>
<!-- /#ts-popup -->

</body>
</html>