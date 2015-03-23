<?php
global $ts_style_selector_default_primary_color;
$ts_style_selector_default_primary_color = ts_option_vs_default('primary_color', '#E8B71A');
global $ts_style_selector_colors;
$ts_style_selector_colors = array(
    __('Magenta', 'ThemeStockyard') => '#D91C5C',
    __('Red', 'ThemeStockyard') => '#ec1a23',
    __('Peach', 'ThemeStockyard') => '#F28D7B',
    __('Purple', 'ThemeStockyard') => '#601848',
    __('Navy', 'ThemeStockyard') => '#002238',
    __('Blue', 'ThemeStockyard') => '#1071fe',
    __('Teal', 'ThemeStockyard') => '#1E7775',
    __('Sage', 'ThemeStockyard') => '#3ab54b',
    __('Green', 'ThemeStockyard') => '#7F9614',
    __('Mustard Yellow', 'ThemeStockyard') => '#E8B71A',
    __('Orange', 'ThemeStockyard') => '#F28707',
    __('Brown', 'ThemeStockyard') => '#4E1D0C',
    __('Gray', 'ThemeStockyard') => '#3b3b3b',
);
global $ts_style_selector_bg_options;
$ts_style_selector_bg_options = array(
    __('Grunge Wall', 'ThemeStockyard') => 'grunge-wall',
    __('Bright Squares', 'ThemeStockyard') => 'bright-squares',
    __('Retina Wood', 'ThemeStockyard') => 'retina_wood',
    __('Sneaker Mesh', 'ThemeStockyard') => 'sneaker_mesh_fabric',
    __('Arches', 'ThemeStockyard') => 'arches',
    __('Cartographer', 'ThemeStockyard') => 'cartographer',
    __('Dark Wood', 'ThemeStockyard') => 'dark_wood',
    __('Diagmonds', 'ThemeStockyard') => 'diagmonds',
    __('Escheresque 1', 'ThemeStockyard') => 'escheresque_ste',
    __('Escheresque 2', 'ThemeStockyard') => 'escheresque',
    __('Google Play pattern', 'ThemeStockyard') => 'gplaypattern',
    __('Graphy', 'ThemeStockyard') => 'graphy',
    __('3 pixel squares', 'ThemeStockyard') => 'px_by_Gr3g',
    __('Shattered', 'ThemeStockyard') => 'shattered',
    __('Stresses Linen', 'ThemeStockyard') => 'stressed_linen',
    __('Tileable Wood', 'ThemeStockyard') => 'tileable_wood_texture',
    __('Type', 'ThemeStockyard') => 'type',
    __('Food', 'ThemeStockyard') => 'food',
    __('Green Cup', 'ThemeStockyard') => 'green_cup',
    __('School', 'ThemeStockyard') => 'school',
    __('Skulls', 'ThemeStockyard') => 'skulls',
    __('Swirl Pattern', 'ThemeStockyard') => 'swirl_pattern',
    __('Symphony', 'ThemeStockyard') => 'symphony',
);

function ts_print_style_selector_colors()
{
    global $ts_style_selector_colors, $ts_style_selector_default_primary_color;
    
    $current_color = strtolower($ts_style_selector_default_primary_color);
    
    foreach($ts_style_selector_colors AS $key => $value)
    {
        $value = strtolower($value);
        $active = ('#'.$current_color == $value || $current_color == $value) ? 'active' : '';
        $_value = (substr($value, 0, 1) == '#') ? strtolower(substr($value, 1)) : strtolower($value);
        echo '<a title="'.esc_attr($key).'" data-color="'.esc_attr($value).'" class="'.esc_attr($active).' ts-demo-test-color ts-demo-test-color-'.esc_attr($_value).'">&nbsp;</a>';
    }
}
function ts_print_style_selector_bg_options()
{
    global $ts_style_selector_bg_options;
    
    $current_bg = '';
    
    foreach($ts_style_selector_bg_options AS $key => $value)
    {
        $active = ($current_bg == $value) ? 'active border-primary' : '';
        echo '<a title="'.esc_attr($key).'" data-bg="'.esc_attr($value).'" class="'.esc_attr($active).'">&nbsp;</a>';
    }
}
function ts_print_style_selector_skin_options()
{
    $ts_style_selector_skins = array(
        'Light' => 'light',
        'Dark' => 'dark'
    );
    
    $current_skin = 'light';
    
    foreach($ts_style_selector_skins AS $key => $value)
    {
        echo '<option value="'.esc_attr($value).'" '.selected( $current_skin, $value, false ).'>'.esc_attr($key).'</option>';
    }
}
?>
<!-- for demo purposes only -->
<div id="ts-style-selector-wrap" class="closed">
    <a id="ts-style-selector-toggle"><span><i class="fa fa-cog"></i></span></a>
    <div id="ts-style-selector">
        <h3><?php _e('Style Switcher', 'ThemeStockyard');?></h3>
        <div class="ts-style-selector-pocket">
            <h4><?php _e('Skin:', 'ThemeStockyard');?></h4>
            <p><select name="ts_style_skin" id="ts_style_skin"><?php ts_print_style_selector_skin_options();?></select></p>
        </div>
        <div class="ts-style-selector-pocket">
            <h4><?php _e('Backgrounds:', 'ThemeStockyard');?></h4>
            <p id="ts-style-selector-bg-options" class="ts-style-bg-options clearfix"><?php ts_print_style_selector_bg_options();?></p>
            <p class="small"><?php _e('You can also upload your own background from the Admin Panel.', 'ThemeStockyard');?></p>
        </div>
        <div class="ts-style-selector-pocket">
            <h4><?php _e('Highlight Color:', 'ThemeStockyard');?></h4>
            <p id="ts-style-selector-color-options" class="ts-style-color-options clearfix"><?php ts_print_style_selector_colors();?></p>
            <p class="mimic-small subtle-text-color"><?php _e('Best viewed within <a href="/maddux/shop"><u>the shop</u></a>.', 'ThemeStockyard');?></p>
            <p class="small"><?php _e('You can also create your own highlight color from the Admin Panel.', 'ThemeStockyard');?></p>
        </div>
        <div class="ts-style-selector-pocket">
            <p><a id="ts-style-selector-reset-button"><u><?php echo _e('Reset Styles', 'ThemeStockyard');?></u></a></p>
        </div>
    </div>
</div>
<!-- for demo purposes only -->
<div id="dev-style-div" class="hidden" data-color="<?php echo esc_attr($ts_style_selector_default_primary_color);?>" data-bg-classes="bg_<?php echo esc_attr(implode(' bg_', $ts_style_selector_bg_options));?>" data-orig-color="<?php echo esc_attr($ts_style_selector_default_primary_color);?>">
.widget_calendar table td#today,
#title-bar ul.post-categories li a,
#ts-news-ticker-nav .flex-direction-nav a,
button,
.button,
.wpcf7-submit,
#button,
.spinner > div,
.woocommerce input[type="submit"], 
.woocommerce input[type="button"], 
.woocommerce .product-remove a.remove { background-color: <?php echo $ts_style_selector_default_primary_color;?>; }
.post a,
#sidebar a,
#comments .comment-message a { color: <?php echo $ts_style_selector_default_primary_color;?>; }
.woocommerce p.stars span a:hover, 
.woocommerce-page p.stars span a:hover,
.woocommerce p.stars span a.active, 
.woocommerce-page p.stars span a.active { color: <?php echo $ts_style_selector_default_primary_color;?>; }
.highlight { background-color: rgba(232, 183, 26, .1); color: <?php echo $ts_style_selector_default_primary_color;?>; }
.ts-pricing-column.featured,
button.outline,
.button.outline,
#button.outline { border-color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
.loop-slider-wrap .ts-item-details .comment-bubble:after { border-top-color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
.border-primary { border-color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
.bg-primary { background-color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
.primary-color, 
.color-shortcode.primary,
.color-primary { color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
.button.default,
.button.primary { background-color: <?php echo $ts_style_selector_default_primary_color;?> !important; }
</div>