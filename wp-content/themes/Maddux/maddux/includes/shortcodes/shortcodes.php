<?php       

//////////////////////////////////////////////////////////////////
// Accordion
//////////////////////////////////////////////////////////////////
add_shortcode('accordion', 'ts_accordion_shortcode');
function ts_accordion_shortcode( $atts = null, $content = null ) {
    $atts = shortcode_atts(array(
        'open_icon' => 'minus',
        'closed_icon' => 'plus',
    ), $atts);
    
    global $open_icon, $closed_icon, $ts_toggles;
    
    $ts_toggles = array();
    
    $open_icon = (trim($atts['open_icon'])) ? $atts['open_icon'] : 'chevron-down';
    $open_icon = ts_fontawesome_class($open_icon);
    
    $closed_icon = (trim($atts['closed_icon'])) ? $atts['closed_icon'] : 'chevron-right';        
    $closed_icon = ts_fontawesome_class($closed_icon);
    
    $html = '';
            
    $html .= '<div class="accordion-wrapper tog-acc-wrapper ts-shortcode-block" data-open-icon="'.esc_attr($open_icon).'" data-closed-icon="'.esc_attr($closed_icon).'">';
    $_html = do_shortcode($content);     
    if(count($ts_toggles) > 0) :
        $count = count($ts_toggles);
        
        $i = 1;
        foreach($ts_toggles AS $toggle) :
            $position = ($i == $count) ? 'last' : (($i == 1) ? 'first' : 'not-first-or-last');
            $html .= str_replace('<div class="accordion-block', '<div class="accordion-block '.$position, $toggle);
            $i++;
        endforeach;
    else :
        $html .= $_html;
    endif;     
    $html .= '</div>';
    
    $ts_toggles = array();
    
    unset($GLOBALS['open_icon'], $GLOBALS['closed_icon']);

    return $html;
}

//////////////////////////////////////////////////////////////////
// Alert shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('alert', 'ts_alert_shortcode');
	function ts_alert_shortcode( $atts = null, $content = null ) {
        $atts = shortcode_atts(
			array(
				'type' => '',
			), $atts);
	
	extract($atts);
	
	$type_options = array('general','error','danger','success','info','notice');		
	$type = (in_array($type, $type_options)) ? $type : '';
	$type = ($type == 'error') ? 'danger' : (($type == 'notice') ? 'info' : $type);
	
	$html  = '<div class="alert alert-'.esc_attr($type).' ts-shortcode-block">';
	$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	$html .= do_shortcode($content);
	$html .= '</div>';
	
	return $html;
	
}

//////////////////////////////////////////////////////////////////
// Animation Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'animation', 'ts_animation_shortcode' );
function ts_animation_shortcode($atts = null, $content = null) {
    $style = (isset($atts['style'])) ? strtolower($atts['style']) : '';
    $from = (isset($atts['from'])) ? $atts['from'] : '';
    $delay = (isset($atts['delay'])) ? $atts['delay'] : '';
    if(ts_starts_with($style, 'fadein')) :
        $html = do_shortcode('[fadein from="'.esc_attr($from).'" delay="'.esc_attr($delay).'"]'.$content.'[/fadein]');
    endif;
    
    return $html;
}

//////////////////////////////////////////////////////////////////
// Blockquote shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('blockquote', 'ts_blockquote_shortcode');
	function ts_blockquote_shortcode( $atts = null, $content = null ) {
        $atts = shortcode_atts(
			array(
				'align' => 'left',
				'attributed_to' => '',
				'attributed_to_url' => '',
				'pull' => ''
			), $atts);
	
	extract($atts);
	
	$pull_options = array('left','right');		
	$pull = (in_array($atts['pull'], $pull_options)) ? 'pull-'.$atts['pull'] : '';
	
	$align_options = array('left','right');		
	$align = (in_array($atts['align'], $align_options)) ? $atts['align'] : 'left';
	
	$attributed_to = (trim($atts['attributed_to'])) ? $atts['attributed_to'] : '';
	$attributed_to_url = (trim($atts['attributed_to_url'])) ? $atts['attributed_to_url'] : '';
	
	$link_begin = ($attributed_to_url) ? '<a href="'.esc_url($attributed_to_url).'" class="primary-color">' : '';
	$link_end = ($attributed_to_url) ? '</a>' : '';
	
	$dash = '<span class="subtle-text-color">&mdash;</span> ';
	$attribution = ($attributed_to) ? '<cite class="mimic-smaller uppercase">'.$dash.$link_begin.trim($attributed_to).$link_end.'</cite>' : '';
	
	$html  = '<div class="ts-blockquote-shortcode ts-bq-align-'.esc_attr($align).' '.esc_attr($pull).'"><blockquote>';
	$html .= wpautop(do_shortcode($content));
	$html .= $attribution;
	$html .= '</blockquote></div>';
	
	return $html;
	
}


//////////////////////////////////////////////////////////////////
// Blog Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'blog', 'ts_blog_shortcode' );
function ts_blog_shortcode($atts = null, $content = null) {
    $layout = (isset($atts['layout'])) ? $atts['layout'] : '';
    $atts = (isset($atts) && is_array($atts)) ? $atts : array();
    
    
    ob_start();
    ts_blog($layout, $atts);
    $output = ob_get_contents();
    $output = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $output);
    ob_end_clean();
    
    return $output;
}

add_shortcode('blog_slider', 'ts_blog_slider_shortcode');
function ts_blog_slider_shortcode($atts = null, $content = null) {
    
    $atts = (is_array($atts)) ? $atts : array();
    $atts['layout'] = 'slider';
    
    return ts_blog_shortcode($atts, $content);
}
add_shortcode('blog_widget', 'ts_blog_widget_shortcode');
function ts_blog_widget_shortcode($atts = null, $content = null) {
    
    $atts = (is_array($atts)) ? $atts : array();
    $atts['layout'] = 'widget';
    
    return ts_blog_shortcode($atts, $content);
}
	
//////////////////////////////////////////////////////////////////
// Button shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('button', 'ts_button_shortcode');
	function ts_button_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'color' => 'default',
                'style' => '',
                'size' => '',
                'link' => '',
                'url' => '',
                'target' => '',
                'icon' => '',
                'icon_position' => 'left',
            ), $atts);
            
        $style = ts_slugify($atts['style']);
        $style = (in_array($style, array('flat','outline','outline-thin', 'thin-outline', 'thin'))) ? $style : 'traditional';
        $style = (in_array($style, array('outline-thin','thin','thin-outline'))) ? 'outline thin' : $style;
        $atts['color'] = ($atts['color'] == '#fff' || $atts['color'] == '#ffffff') ? 'white' : $atts['color'];
        $color = (substr($atts['color'], 0, 1) == '#') ? '' : esc_attr($atts['color']);
        $csscolor = (substr($atts['color'], 0, 1) == '#') ? 'style="background-color:'.esc_attr($atts['color']).' !important"' : '';
        $link = (trim($atts['link'])) ? $atts['link'] : ((trim($atts['url'])) ? $atts['url'] : '#');
        
        $icon = ts_fontawesome_class($atts['icon']);
        $icon = ($icon) ? '<i class="'.$icon.'"></i>' : '';
        $text = (trim($content)) ? do_shortcode($content) : '';
        $icon_text_space = ($icon && $text) ? '&nbsp;' : '';
        
        $target = (trim($atts['target']) && substr($atts['target'], 0, 1) != '_') ? '_'.$atts['target'] : $atts['target'];
        $target = (trim($target)) ? 'target="'.esc_attr($target).'"' : ''; 
        $size = (in_array($atts['size'], array('small','medium','large'))) ? $atts['size'] : 'medium';
        $button_text = ($atts['icon_position'] == 'right') ? $text . $icon_text_space . $icon : $icon . $icon_text_space . $text;
        
        $hover = '';
        if($style == 'outline' || $style == 'outline thin') :
            $color = ($csscolor) ? '' : 'border-'.$color.' color-shortcode '.$color;
            $csscolor = ($csscolor) ? 'style="color:'.esc_attr($atts['color']).' !important;border-color:'.esc_attr($atts['color']).' !important"' : '';
        endif;
        
        
        return '<a class="button '.esc_attr($size).' '.esc_attr($color).' '.esc_attr($style).'" href="'.esc_url($link).'" '.$target.' '.$csscolor.'>'.$button_text. '</a>';
	}

//////////////////////////////////////////////////////////////////
// center shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('center', 'ts_center_shortcode');
function ts_center_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'style' => ''
    ), $atts);
    
    $html = '<div class="text-center">'.do_shortcode($content).'</div>';
    
    return $html;
}


//////////////////////////////////////////////////////////////////
// Clip Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'clip', 'ts_clip_shortcode' );
function ts_clip_shortcode($atts = null, $content = null) {
    $height = $oheight = (isset($atts['height'])) ? preg_replace("/[^0-9]*/", "", $atts['height']) : 320;
    $height = (is_numeric($height)) ? $height.'px' : '330px';
    
    $no_unclip = (isset($atts['no_unclip'])) ? $atts['no_unclip'] : ((isset($atts['nounclip'])) ? $atts['nounclip'] : 'false');
    $no_unclip = (in_array($no_unclip, array('none','yes','true','1','no_unclip','nounclip','no-unclip'))) ? true : false;
    
    $allow_reclip = (isset($atts['allow_reclip'])) ? $atts['allow_reclip'] : '';
    $allow_reclip = (in_array($allow_reclip, array('yes','true','1'))) ? true : false;
    
    $text = (isset($atts['text']) && trim($atts['text'])) ? $atts['text'] : ((isset($atts['show_more_text'])) ? $atts['show_more_text'] : 'show more');
    
    $sections = array('section','color_section','fullwidth_section');
    $section_class = '';
    
    foreach($sections AS $section) {
        if(substr($content, 0, strlen($section) + 1) == '['.$section) {
            $section_class = 'ts-section';
            break;
        }
    }
    
    $output  = '<div class="ts-clip-shortcode-wrap '.esc_attr($section_class).'" data-height="'.esc_attr($oheight).'">';
    $output .= '<div class="ts-clip-shortcode" style="height:'.esc_attr($height).';overflow:hidden;">';
    $output .= '<div class="ts-clip-shortcode-content">'.do_shortcode($content).'</div>';
    $output .= '</div>';
    if(!$no_unclip) :
        $output .= '<div class="ts-clip-button-wrap">';
        $output .= '<p><a><i class="icon-caret-down primary-color pr5"></i><span>'.$text.'</span><i class="icon-caret-down primary-color pl5"></i></a></p>';
        $output .= '</div>';
    endif;
    $output .= '</div>';
    
    return $output;
}



//////////////////////////////////////////////////////////////////
// Code Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('code', 'ts_code_shortcode');
function ts_code_shortcode($atts = null, $content = null) {
    $code = str_replace(array('[', ']', '<', '>'), array('&#91;','&#93;','&#60;','&#62;'), trim(strip_tags($content)));
    
    $style = (isset($atts['style'])) ? $atts['style'] : ((isset($atts['type'])) ? $atts['type'] : '');
    $style = (in_array($style, array('block','inline','simple'))) ? $style : 'block';
    
    if($style == 'inline' || $style == 'simple')
    {
        return '<code class="ts-inline-code">'.$code.'</code>';
    }
    else
    {
        $lines = explode("\n", $code);
        $html = '';
        $j = 0;
        $i = 1;
        foreach($lines AS $line) {
            if(trim($line) && trim($line) != '&nbsp;') :
                $line = $line;
                $j = 0;
            else :
                $line = '&nbsp;';
                $j++;
            endif;
            if($j == 0 || $j == 2) :
                $html .= '<li class="line"><span class="line-number">'.$i.'.</span><pre><code>'.$line.'</code></pre></li>';
                $i++;
                $j = ($j == 2) ? 0 : $j;
            endif;
        }
        
        return '<div class="ts-code-wrapper"><div class="ts-notepad"><ul class="ts-code-shortcode">'.$html.'</ul></div></div>';
    }
}
	
//////////////////////////////////////////////////////////////////
// Color shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('color', 'ts_color_shortcode');
	function ts_color_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'color' => 'primary',
            ), $atts);
        $color = (substr($atts['color'], 0, 1) == '#') ? '' : 'class="color-shortcode '.esc_attr($atts['color']).'"';
        $stylecolor = (substr($atts['color'], 0, 1) == '#') ? 'style="color:'.esc_attr($atts['color']).' !important"' : '';
        return '<span '.$color.' '.$stylecolor.'>' .do_shortcode($content). '</span>';
	}

//////////////////////////////////////////////////////////////////
// Color Section Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'parallax', 'ts_parallax_shortcode' );
add_shortcode( 'parallax_section', 'ts_parallax_shortcode' );
function ts_parallax_shortcode($atts = null, $content = null) {
    $atts = (is_array($atts)) ? $atts : array();
    $atts['parallax'] = 'true';
    return ts_section_shortcode($atts, $content);
}
add_shortcode( 'section', 'ts_section_shortcode' );
add_shortcode( 'color_section', 'ts_section_shortcode' );
add_shortcode( 'fullwidth_section', 'ts_section_shortcode' );
add_shortcode( 'fullwidth', 'ts_section_shortcode' );
function ts_section_shortcode($atts = null, $content = null) {
    $atts = shortcode_atts(array(
                //'align' => '',
                'id' => '',
                'style' => '',
                'border_color'  => '',
                'border_size' => '',
                'border_width' => '',
                'border_top' => '',
                'border_top_color' => '',
                'border_top_style' => 'solid',
                'border_top_width' => '',
                'border_top_size' => '',
                'border_bottom' => '',
                'border_bottom_color' => '',
                'border_bottom_style' => 'solid',
                'border_bottom_width' => '',
                'border_bottom_size' => '',
                'background_color' => '',
                'background_image_url' => '',
                'background_image' => '',
                'background_position' => 'left top',
                'background_repeat' => 'repeat',
                'background_size' => '',
                'padding_top' => '20px',
                'padding_bottom' => '20px',
                'padding_left' => '20px',
                'padding_right' => '20px',
                'width' => 'fullwidth',
                'parallax' => 'false',
                'mesh_overlay' => 'false',
                'fullwidth' => 'true',
                'text_align' => '',
                'text_color' => ''
            ), $atts);
        
        
        $style = ($atts['style'] == 'parallax') ? 'parallax' : '';
        $parallax = (in_array($atts['parallax'], array('1', 'yes', 'true'))) ? 'parallax' : $style;
        $fullwidth = (ts_attr_is_true($atts['fullwidth'])) ? 'ts-color-section-fullwidth' : '';
        $mesh = (ts_attr_is_true($atts['mesh_overlay'])) ? 'mesh-overlay' : '';
        
        $css = '';
           
        $align = (in_array($atts['text_align'], array('left', 'center', 'centered', 'middle', 'right'))) ? $atts['text_align'] : '';
        $align = (in_array($align, array('centered', 'middle'))) ? 'center' : $align;
        $align = (trim($align)) ? 'text-'.$align : $align;
        
        $id = (trim($atts['id'])) ? 'id="'.esc_attr($id).'"' : '';
        
        $border_color = ($atts['border_color']) ? $atts['border_color'] : '';
        
        $border_width = (trim($atts['border_width'])) ? $atts['border_width'] : ((trim($atts['border_size'])) ? $atts['border_size'] : '1');
        $border_width = ($border_width != 'none') ? preg_replace("/[^0-9]*/", "", $border_width) : 0;
        $border_width = (is_numeric($border_width)) ? $border_width.'px' : '1px';
        
        $border_top_color = ($atts['border_top_color']) ? $atts['border_top_color'] : (($border_color) ? $border_color : '');
        $border_top_style = (in_array($atts['border_top_style'], array('solid','dotted','dashed'))) ? $atts['border_top_style'] : 'solid';
        $border_top_width = ($atts['border_top_width'] != 'none') ? preg_replace("/[^0-9]*/", "", $atts['border_top_width']) : 0;
        $border_top_width = (!$atts['border_top_width'] && $atts['border_top'] == 'none') ? 0 : $border_top_width;
        $border_top_width = (is_numeric($border_top_width)) ? $border_top_width.'px' : $border_width;
        
        if($border_top_color) {
            $css .= 'border-top:'.$border_top_width.' '.$border_top_style.' '.$border_top_color.';';
        }
        
        $border_bottom_color = ($atts['border_bottom_color']) ? $atts['border_bottom_color'] : (($border_color) ? $border_color : '');
        $border_bottom_style = (in_array($atts['border_bottom_style'], array('solid','dotted','dashed'))) ? $atts['border_bottom_style'] : 'solid';
        $border_bottom_width = ($atts['border_bottom_width'] != 'none') ? preg_replace("/[^0-9]*/", "", $atts['border_bottom_width']) : 0;
        $border_bottom_width = (!$atts['border_bottom_width'] && $atts['border_bottom'] == 'none') ? 0 : $border_bottom_width;
        $border_bottom_width = (is_numeric($border_bottom_width)) ? $border_bottom_width.'px' : $border_width;
        
        if($border_bottom_color) {
            $css .= 'border-bottom:'.$border_bottom_width.' '.$border_bottom_style.' '.$border_bottom_color.';';
        }
        
        $background_color = ($atts['background_color']) ? $atts['background_color'] : '';
        if($background_color && $background_color[0] == '#') {
            $css .= 'background-color:'.$background_color.';';
            $background_color = '';
        }
        $background_color = ($background_color) ? 'bg-'.$background_color.' ' : '';
        
        $background_image = ($atts['background_image_url']) ? esc_url($atts['background_image_url']) : '';
        $background_image = ($background_image) ? $background_image : (($atts['background_image']) ? esc_url($atts['background_image']) : '');
        $background_repeat = (in_array($atts['background_repeat'], array('no-repeat','repeat','repeat-x','repeat-y'))) ? $atts['background_repeat'] : 'repeat';
        //$background_repeat = ($parallax == 'parallax') ? 'no-repeat' : $background_repeat;
        $background_position = (isset($atts['background_position'])) ? $atts['background_position'] : '50% 50%';
        $background_position = ($parallax == 'parallax') ? 'center center' : $background_position;
        $background_size = (isset($atts['background_size'])) ? $atts['background_size'] : '';
        if($parallax == 'parallax') {
            $background_size = 'cover';
            $background_repeat = 'no-repeat';
        }
        if($background_image) {
            $css .= 'background-image:url('.$background_image.');';
            $css .= 'background-repeat:'.$background_repeat.';';
            $css .= 'background-position:'.$background_position.';';
            if($background_size) {
                $css .= 'background-size:'.$background_size.';';
                $css .= '-moz-background-size:'.$background_size.';';
                $css .= '-webkit-background-size:'.$background_size.';';
                $css .= '-o-background-size:'.$background_size.';';
            }
        }
        
        $_css = '';
        $_css .= 'padding-top:'.preg_replace("/[^0-9]*/","",$atts['padding_top']).'px;';
        $_css .= 'padding-bottom:'.preg_replace("/[^0-9]*/","",$atts['padding_bottom']).'px;';
        $_css .= 'padding-left:'.preg_replace("/[^0-9]*/","",$atts['padding_left']).'px;';
        $_css .= 'padding-right:'.preg_replace("/[^0-9]*/","",$atts['padding_right']).'px;';
        
        $text_color = ($atts['text_color']) ? $atts['text_color'] : (($atts['textcolor']) ? $atts['textcolor'] : '');
        if($text_color && $text_color[0] == '#') {
            $_css .= 'color:'.$text_color.';';
            $text_color = '';
        }
        $text_color = ($text_color) ? ' color-shortcode '.$text_color.' ' : '';
        
        $classes = $parallax.' '.$fullwidth.' '.$mesh.' '.$background_color;
        $_classes = $text_color.' '.$align;
        
        $str = '';
        $str .= '<div class="ts-color-section-wrap-wrap ts-shortcode-block">';
		$str .= '<div class="ts-color-section-wrap ts-color-section-shortcode ts-section '.esc_attr($classes).'" style="'.esc_attr($css).'" '.$id.'>';
		$str .= '<div class="ts-color-section container">';
		$str .= '<div class="ts-color-section-content-wrap" style="'.esc_attr($_css).'">';
		$str .= '<div class="ts-color-section-content '.esc_attr($_classes).'">';
        $str .= do_shortcode($content);
        $str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';

		return $str;
}
	
//////////////////////////////////////////////////////////////////
// Column one_half shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_half', 'ts_one_half_shortcode');
	function ts_one_half_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-one-half ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-one-half">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column one_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_third', 'ts_one_third_shortcode');
	function ts_one_third_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-one-third ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-one-third">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column two_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('two_thirds', 'ts_two_third_shortcode');
add_shortcode('two_third', 'ts_two_third_shortcode');
	function ts_two_third_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-two-third ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-two-third">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column one_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_fourth', 'ts_one_fourth_shortcode');
	function ts_one_fourth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-one-fourth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-one-fourth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column three_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('three_fourths', 'ts_three_fourth_shortcode');
add_shortcode('three_fourth', 'ts_three_fourth_shortcode');
	function ts_three_fourth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-three-fourth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-three-fourth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column one_fifth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_fifth', 'ts_one_fifth_shortcode');
	function ts_one_fifth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-one-fifth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-one-fifth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column two_fifth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('two_fifths', 'ts_two_fifth_shortcode');
add_shortcode('two_fifth', 'ts_two_fifth_shortcode');
	function ts_two_fifth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-two-fifth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-two-fifth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column three_fifth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('three_fifths', 'ts_three_fifth_shortcode');
add_shortcode('three_fifth', 'ts_three_fifth_shortcode');
	function ts_three_fifth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-three-fifth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-three-fifth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column four_fifth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('four_fifths', 'ts_four_fifth_shortcode');
add_shortcode('four_fifth', 'ts_four_fifth_shortcode');
	function ts_four_fifth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-four-fifth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-four-fifth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column one_sixth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_sixth', 'ts_one_sixth_shortcode');
	function ts_one_sixth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-one-sixth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-one-sixth">' .do_shortcode($content). '</div>';
			}

	}
	
//////////////////////////////////////////////////////////////////
// Column five_sixth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('five_sixths', 'ts_five_sixth_shortcode');
add_shortcode('five_sixth', 'ts_five_sixth_shortcode');
	function ts_five_sixth_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);
			
			if($atts['last'] == 'yes') {
				return '<div class="ts-five-sixth ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
			} else {
				return '<div class="ts-five-sixth">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Columns (all) shortcode
//////////////////////////////////////////////////////////////////
function ts_column_shortcode( $atts, $content = null ){
    
    global $ts_within_column;
    
    $atts = shortcode_atts( array(
        'size' => 'one-third',
        'last' =>'no',
    ), $atts );
      
    $_size = $atts['size'];
    $size = preg_replace("/[^0-9a-z]*/", "", $atts['size']);
      
    if(ts_starts_with('onehalf', $size))
        $size = 'one-half';
    elseif(ts_starts_with('onethird', $size))
        $size = 'one-third';
    elseif(ts_starts_with('onefourth', $size))
        $size = 'one-fourth';
    elseif(ts_starts_with('onefifth', $size))
        $size = 'one-fifth';
    elseif(ts_starts_with('onesixth', $size))
        $size = 'one-sixth';
    elseif(ts_starts_with('twothird', $size))
        $size = 'two-third';
    elseif(ts_starts_with('threefourth', $size))
        $size = 'three-fourth';
    elseif(ts_starts_with('twofifth', $size))
        $size = 'two-fifth';
    elseif(ts_starts_with('threefifth', $size))
        $size = 'three-fifth';
    elseif(ts_starts_with('fourfifth', $size))
        $size = 'four-fifth';
    elseif(ts_starts_with('fivesixth', $size))
        $size = 'five-sixth';
      
    $size = ($ts_within_column === true) ? 'boxed-'.$size : $size;
    
    if(isset($atts['last']) && $atts['last'] == 'yes' && $ts_within_column !== true) {
        return '<div class="ts-'.esc_attr($size).' ts-column-last">' .do_shortcode($content). '</div><div class="clear"></div>';
    } else {
        return '<div class="ts-'.esc_attr($size).'">' .do_shortcode($content). '</div>';
    }
}
add_shortcode('column', 'ts_column_shortcode');

//////////////////////////////////////////////////////////////////
// Column Row shortcode
//////////////////////////////////////////////////////////////////
function ts_column_row_shortcode( $atts, $content = null ){
      
    global $ts_within_column;
    
    $atts = shortcode_atts( array(
        'margin_top' => '0px',
        'margin_bottom' =>'0px',
    ), $atts );
    
    $ts_within_column = true;
      
    $margin = '';
	$margin_top = preg_replace("/[^0-9]*/","",$atts['margin_top']);
	$margin_top = ($margin_top) ? 'margin-top:'.$margin_top.'px;' : '';
	$margin_bottom = preg_replace("/[^0-9]*/","",$atts['margin_bottom']);
	$margin_bottom = ($margin_bottom) ? 'margin-bottom:'.$margin_bottom.'px;' : '';
	
    $margin = (trim($margin_top.$margin_bottom)) ? 'style="'.esc_attr($margin_top.$margin_bottom).'"' : '';
    
    $content = do_shortcode($content);
    
    //unset($GLOBALS['ts_within_column']);
    
    return '<div class="container" '.$margin.'><div class="row">' .$content. '</div></div>';
}
add_shortcode('column_row', 'ts_column_row_shortcode');
add_shortcode('columns_row', 'ts_column_row_shortcode');
add_shortcode('columns', 'ts_column_row_shortcode');

//////////////////////////////////////////////////////////////////
// Date Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('date', 'ts_date_shortcode');
function ts_date_shortcode($atts = null) {
    $atts = shortcode_atts(array(
				'format' => 'F j, Y',
			), $atts);
    $atts['format'] = (trim($atts['format'])) ? $atts['format'] : 'F j, Y';
    return date_i18n($atts['format']);
}

//////////////////////////////////////////////////////////////////
// divider shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('clear', 'ts_divider_shortcode');
add_shortcode('clear_floats', 'ts_divider_shortcode');
add_shortcode('divider', 'ts_divider_shortcode');
function ts_divider_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
                'style' => '',
                'line_style' => '',
				'padding_top' => '0',
				'padding_bottom' => '0',
				'margin_top' => '0',
				'margin_bottom' => '0',
				'height' => '0',
				'color' => '',
				'align' => 'center',
				'width' => '',
				'opacity' => '',
				'pull' => '',
			), $atts);
    $color = ($atts['color']) ? $atts['color'] : '';
    $hex = '';
    if($color && $color[0] == '#') {
        $hex = 'style="border-color:'.esc_attr($color).'"';
        $color = '';
    }
    $color = ($color) ? 'border-'.$color : '';
    
	$style_options = array('line','single','solid','single-line','dashed','dotted','double','double-line','double-dashed','double-dotted','circle','square');
	$style = ($atts['line_style']) ? $atts['line_style'] : $atts['style'];
	$style = (in_array($style, $style_options)) ? $style : 'none';
	$style = (in_array($style, array('single','single-line','solid'))) ? 'line' : $style;
	$style = (in_array($style, array('double','doubleline'))) ? 'double-line' : $style;
	
	$align_options = array('center','centered','middle','right');
    $align = (in_array($atts['align'], $align_options)) ? (($atts['align'] == 'right') ? 'text-right' : 'text-center') : 'text-left';
    
    $pull_options = array('center','centered','middle','right','left');
    $pull = (in_array($atts['pull'], $pull_options)) ? (($atts['pull'] == 'right') ? 'pull-right' : 'pull-'.$atts['pull']) : '';
	
	$width = ts_css_num($atts['width'], true);
	
	$padding = '';
	$padding_top = max(preg_replace("/[^0-9]*/","",$atts['margin_top']), preg_replace("/[^0-9]*/","",$atts['padding_top']));
	$padding_top = preg_replace("/[^0-9]*/","",$padding_top);
	$padding_bottom = max(preg_replace("/[^0-9]*/","",$atts['margin_bottom']), preg_replace("/[^0-9]*/","",$atts['padding_bottom']));
	$padding_bottom = preg_replace("/[^0-9]*/","",$padding_bottom);
	
	
	$opacity = $atts['opacity'];
	$opacity = ($opacity > 1 && $opacity <= 100) ? $opacity / 100 : (($opacity > 0 && $opacity <= 1) ? $opacity : 1);
	$opacity = ($opacity != 1) ? 'opacity:'.$opacity.';' : '';
	
	if($style == 'none' && (!$padding_top && !$padding_bottom) && $atts['height']) :
        $height = 'height:'.preg_replace("/[^0-9]*/","",$atts['height']).'px';;
	else :
        $padding = 'padding-top:'.$padding_top.'px;padding-bottom:'.$padding_bottom.'px;';
        $height = '';
    endif;
	
	if(($width || $pull) && $style != 'clear') :
        $wrap_begin = '<div class="divider-shortcode-wrap clearfix"><div class="'.esc_attr($pull).'" style="max-width:'.esc_attr($width).';">';
        $wrap_end = '</div></div>';
    else :
        $wrap_begin = '';
        $wrap_end = '';
	endif;
	
	
	$html = '';
	$html .= $wrap_begin;
	
	if(in_array($style, array('circle','square'))) :
        $html .= '<div class="divider-shortcode has-shapes '.esc_attr($style).' '.esc_attr($align).'" style="'.esc_attr($padding.$opacity).'">';
        
        $shape = '<p class="shapes"><span class="ts-'.esc_attr($style).' '.esc_attr($color).'" '.$hex.'>&nbsp;</span></p>';
        
        if($align == 'text-center') :
            $html .= '<div class="divider-sep-container"><div class="divider-sep '.esc_attr($color).'" '.$hex.'>&nbsp;</div></div>';
            $html .= $shape;
            $html .= '<div class="divider-sep-container"><div class="divider-sep '.esc_attr($color).'" '.$hex.'>&nbsp;</div></div>';
        elseif($align == 'text-right') :
            $html .= '<div class="divider-sep-container"><div class="divider-sep '.esc_attr($color).'" '.$hex.'></div></div>';
            $html .= $shape;
        else :
            $html .= $shape;
            $html .= '<div class="divider-sep-container"><div class="divider-sep '.esc_attr($color).'" '.$hex.'></div></div>';
        endif;
        $html .= '</div>';
    elseif($style == 'clear') :
        $html .= '<div class="clear"></div>';
	else :
        $html .= '<div class="divider-shortcode '.esc_attr($style).'" style="'.esc_attr($padding.$height.$opacity).'">';
        $html .= '<div class="divider '.esc_attr($color).'" '.$hex.'>&nbsp;</div>';
        $html .= '</div>';
	endif;
	$html .= $wrap_end;
	return $html;
}

//////////////////////////////////////////////////////////////////
// Dropcap shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('dropcap', 'ts_dropcap_shortcode');
	function ts_dropcap_shortcode( $atts = null, $content = null ) { 
        $atts = shortcode_atts(
            array(
                'background_color' => '',
                'backgroundcolor' => '',
                'textcolor' => '',
                'text_color' => '',
            ), $atts);
        
        $class = $style = '';
    
        $text_color = ($atts['text_color']) ? $atts['text_color'] : (($atts['textcolor']) ? $atts['textcolor'] : '');
        if($text_color && $text_color[0] == '#') {
            $style .= 'color:'.$text_color.';';
            $text_color = '';
        }
        $class .= ($text_color) ? ' color-shortcode '.$text_color.' ' : '';
        
        $bg_color = ($atts['background_color']) ? $atts['background_color'] : (($atts['backgroundcolor']) ? $atts['backgroundcolor'] : '');
        if($bg_color && $bg_color[0] == '#') {
            $style .= 'background-color:'.$bg_color.';';
            $bg_color = '';
        }
        $class .= ($bg_color) ? ' bg-'.$bg_color.' ' : '';
		
		return '<span class="dropcap '.esc_attr($class).'" style="'.esc_attr($style).'">' .do_shortcode($content). '</span>';  
		
    }

//////////////////////////////////////////////////////////////////
// Email Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('email', 'ts_email_shortcode');
function ts_email_shortcode($atts = null, $content = null) {
    $atts = shortcode_atts(array(
				'display' => '',
				'text' => '',
				'address' => '',
				'email' => '',
			), $atts);
    $display = (trim($atts['display'])) ? $atts['display'] : (trim($atts['text']) ? $atts['text'] :'');
    $email = (trim($atts['address'])) ? $atts['address'] : (trim($atts['email']) ? $atts['email'] :'');
    
    if($display && !$email) :
        $email = $content;
    elseif($email && !$display) :
        $display = (trim($content)) ? $content : $email;
    elseif(!$email && !$display) :
        $email = $content;
        $display = $content;
    endif;
    
    $pattern = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
    $valid_email = (preg_match($pattern, $email)) ? $email : '';
    if(trim($valid_email)) :
        $output = explode('@', $valid_email);
        $output = '<a href="mailto:'.esc_attr(ts_encode_all($valid_email)).'">'.ts_encode_all($valid_email).'</a>';
    else :
        $output = $display;
    endif;  
    return $output;
}

//////////////////////////////////////////////////////////////////
// Facebook Like Button Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'facebook_like_button', 'ts_facebook_like_button_shortcode' );
function ts_facebook_like_button_shortcode($atts = null, $content = null) {
    $atts = shortcode_atts(array(
				'url' => '',
			), $atts);
    
    global $wp;
    
    $url = (isset($atts['url']) && trim($atts['url'])) ? $atts['url'] : add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    
    $output  = '<span class="ts-facebook-like-button-shortcode inline-block" data-url="'.$url.'">';
    $output .= '<iframe src="https://www.facebook.com/plugins/like.php?href='.urlencode($url);
    $output .= '&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=false';
    $output .= '&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35" ';
    $output .= 'style="border:none; overflow:hidden; width:300px; height:35px;">';
    $output .= '</iframe></span>';
    
    return $output;
}

//////////////////////////////////////////////////////////////////
// Fadein Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'fadein', 'ts_fadein_shortcode' );
function ts_fadein_shortcode($atts = null, $content = null) {
    $from = (isset($atts['from'])) ? $atts['from'] : '';
    $from = ts_fade_in_class($from);
    $from = (trim($from)) ? $from : 'ts-fade-in';
    
    $delay = (isset($atts['delay'])) ? $atts['delay'] : '';
    $dealy = ($delay > 49) ? $delay : (($delay) ? $delay * 100 : '');
    
    return '<div class="'.esc_attr($from).' ts-fade-shortcode" data-delay="'.esc_attr($delay).'">'.do_shortcode($content).'</div>';
}

//////////////////////////////////////////////////////////////////
// FontAwesome Icons
//////////////////////////////////////////////////////////////////
add_shortcode('fontawesome', 'ts_fontawesome_shortcode');
function ts_fontawesome_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'size' => '',
            'icon' => '',
            'color' => '',
        ), $atts);
    
    $color = (isset($atts['color'])) ? $atts['color'] : '';
    $size = (ctype_digit(trim(str_replace('px', '', $atts['size'])))) ? 'font-size:'.trim(str_replace('px', '', $atts['size'])).'px !important' : '';
    $icon = ts_fontawesome_class($atts['icon']);
    $hex = $class = '';
    if($color && $color[0] == '#') {
        $hex = 'color:'.$color;
        $color = '';
    } else {
        $class = ($color) ? 'color-shortcode '.$color : '';
    }
    $styles = implode(';', array($size, $hex));
	$html = '';
	$html .= '<i class="fontawesome-icon '.esc_attr($icon).' '.esc_attr($class).'" style="'.esc_attr($styles).'"></i>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Gallery shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('thumb_gallery', 'ts_thumb_gallery_shortcode');
add_shortcode('lightbox_gallery', 'ts_thumb_gallery_shortcode');
function ts_thumb_gallery_shortcode($atts = null, $content = null) {

    $content = strip_tags($content, '<img>');
    
    $hover_zoom = (isset($atts['hover_zoom'])) ? $atts['hover_zoom'] : (isset($atts['zoom_on_hover']) ? $atts['zoom_on_hover'] : 'no');
    $hover_zoom = (in_array($hover_zoom, array('true','yes','1'))) ? 'true' : 'false';
    
    if(preg_match("/\[gallery/", $content))
    {
        $content = do_shortcode(preg_replace("/\[gallery/", '[ts_gallery hover_zoom="'.esc_attr($hover_zoom).'"', $content));
    }
    elseif(preg_match("/\[image/", $content))
    {
        $atts = (is_array($atts)) ? $atts : array();
        $atts['hover_zoom'] = $hover_zoom;
        
        global $ts_gallery_images;
        $ts_gallery_images = array();
        do_shortcode($content);
        $content = ts_gallery_shortcode($atts);
        unset($GLOBALS['ts_gallery_images']);
    }
    
    return $content;
}
add_shortcode('ts_gallery', 'ts_gallery_shortcode');
function ts_gallery_shortcode($atts = null) {
    global $post, $ts_gallery_images;
    
    $type               = '';
    $container_el       = 'ul';
    $item_el            = 'li';
    $wrap_class         = '';
    $container_class    = '';
    $li_class           = '';
    $li_clas            = '';
    
    $ids_array          = (isset($atts['ids'])) ? explode(",",$atts['ids']) : ((isset($atts['include'])) ? explode(",",$atts['include']) : array());
    $ids                = (isset($atts['ids'])) ? $atts['ids'] : ((isset($atts['include'])) ? $atts['include'] : '');
    $exclude_array      = (isset($atts['exclude'])) ? explode(",",$atts['exclude']) : array();
    $exclude            = (isset($atts['exclude'])) ? $atts['exclude'] : '';
    $link               = (isset($atts['link'])) ? $atts['link'] : '';
    $li_class          .= (isset($atts['hover_zoom']) && $atts['hover_zoom'] == 'true') ? 'hover-zoom' : '';
    $crop = (isset($atts['crop']) && in_array($atts['crop'], array('false','0','no'))) ? false : true;
    $size = (isset($atts['size'])) ? $atts['size'] : 'thumb_215x175';
    $resize = false;
    $width = 300;
    $height = 300;
    $slider_height = (isset($atts['height']) && trim($atts['height'])) ? ts_css_num($atts['height'], false, 480) : 480;
    $carousel_height = (isset($atts['height']) && trim($atts['height'])) ? ts_css_num($atts['height'], false, 420) : 420;
    $carousel_width = 630;
    $custom_size = false;
    $container_data = '';
        
    $columns    = (isset($atts['columns']) && ts_number_within_range($atts['columns'], 1, 12)) ? $atts['columns'] : (!isset($atts['columns']) ? 3 : 0);
    
    if(isset($atts['type']) && (in_array($atts['type'], array('slides', 'slider', 'slideshow')))) 
    {
        $type = 'slider';
        $wrap_class = 'flexslider';
        $container_class = 'slides';
    }
    elseif(isset($atts['type']) && (in_array($atts['type'], array('carousel', 'fullwidth-slider')))) 
    {
        $type = 'carousel';
        $wrap_class = 'loop-slider-wrap';
        $container_class = 'owl-carousel';
        $container_el = 'div';
        $item_el = 'div';
        $container_data = 'data-slide-width="'.esc_attr($carousel_width).'"';
    }
    else 
    {
        $type = 'thumbs';
        $wrap_class = 'thumb-gallery';
        $container_class = 'thumbs clearfix';
        
        $link = (trim($link)) ? $link : 'file';
    
        if($columns == 1)
            $li_clas = 'ts-boxed-one-whole';
        elseif($columns == 2)
            $li_clas = 'ts-boxed-one-half';
        elseif($columns == 3)
            $li_clas = 'ts-boxed-one-third';
        elseif($columns == 4)
            $li_clas = 'ts-boxed-one-fourth';
        elseif($columns == 5)
            $li_clas = 'ts-boxed-one-fifth';
        elseif($columns == 6)
            $li_clas = 'ts-boxed-one-sixth';
        elseif($columns == 7)
            $li_clas = 'ts-boxed-one-seventh';
        elseif($columns == 8)
            $li_clas = 'ts-boxed-one-eighth';
        elseif($columns == 9)
            $li_clas = 'ts-boxed-one-ninth';
        elseif($columns == 10)
            $li_clas = 'ts-boxed-one-tenth';
        elseif($columns == 11)
            $li_clas = 'ts-boxed-one-eleventh';
        elseif($columns >= 12)
            $li_clas = 'ts-boxed-one-twelfth';
        else
            $li_clas = 'ts-normal';
    }
    
    $id         = (isset($atts['id'])) ? $atts['id'] : $post->ID;
    $id         = (count($ids_array)) ? '' : $id;
    $orderby    = (isset($atts['orderby'])) ? $atts['orderby'] : 'post__in';
    $order      = (isset($atts['order'])) ? $atts['order'] : 'ASC';
    $link_class = (isset($atts['link']) && $atts['link'] == 'file') ? 'class="ts-image-link"' : '';
    
    if(!in_array($size, array('thumbnail', 'medium','large', 'full')))
    {
        if(preg_match('/^[0-9]{0,4}[^0-9\.]{1}[0-9]{0,4}$/', $size))
        {
            $resize = true;
            $custom_size = true;
            $width = current(preg_split("/[^0-9]*/", $size));
            $height = end(preg_split("/[^0-9]*/", $size));
        }
        else
        {
            $resize = true;
            //$width = 215;
            //$height = 175;
        }
    }
    else
    {
        $custom_size = true;
    }
    
    $container_class .= ($custom_size) ? ' custom-size' : '';
    $container_class .= ($type == 'thumbs') ? ' clearfix' : '';
    
    $output  = '';   
    $output .= (in_array($type, array('slider','carousel'))) ? '<div class="ts-gallery-wrapper ts-shortcode-block">' : ''; 
    $output .= '<div class="'.$wrap_class .' gallery ts-mfp-gallery ts-gallery-shortcode"><'.tag_escape($container_el).' class="'.esc_attr($container_class).'" '.$container_data.'>';
    
    $images_array = array();

    if(is_array($ts_gallery_images)) 
    {
        $images_array = $ts_gallery_images;
    }
    else
    {
        $args = array(
            'order'          => $order,
            'orderby'        => $orderby,
            'post_type'      => 'attachment',
            'post_parent'    => $id,
            'post__in'       => $ids_array,
            'post__not_in'   => $exclude_array,
            'post_mime_type' => 'image',
            'post_status'    => null,
            'numberposts'    => -1,            
        );
        $attachments = get_posts($args);
        if(count($attachments))
        {
            $images_array = array();
            foreach($attachments AS $attachment)
            {
                $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                $images_array[] = array('id' => $attachment->ID, 'caption'=>$attachment->post_excerpt, 'alt'=>$alt);
            }
        }
    }
    
    $i = 1;
    foreach ($images_array as $image) 
    { 
        $li_class .= ($columns && $i == $columns) ? ' '.$li_clas . ' last' : ' '.$li_clas;
        
        $caption_title = (isset($image['caption'])) ? ' title="'.esc_attr($image['caption']).'"' : '';
        $caption_html = (isset($image['caption']) && trim($image['caption'])) ? '<div class="caption"><div>'.$image['caption'].'</div></div>' : '';
        
        $oembed_html = (isset($image['video_url'])) ? wp_oembed_get($image['video_url']) : false;
        
        if(isset($image['video_url']) && trim($image['video_url']) && $oembed_html) : 
            $slide_html = '';
            $slide_html .= '<div class="fluid-width-video-wrapper">';
            $slide_html .= '<div>';
            $slide_html .= $oembed_html;
            $slide_html .= '</div>';
            $slide_html .= '</div>';
        elseif(isset($image['id'])) : 
            if($link == 'file') :
                $medium_size = ($size == 'full') ? 'full' : 'large';
                $medium = wp_get_attachment_image_src($image['id'], $medium_size, false);
                $medium = $medium[0];
                $link_begin = '<a href="'.esc_url($medium).'" '.$link_class.$caption_title.'>';
                $link_end = '</a>';
            elseif($link == 'none') :
                $link_begin = '';
                $link_end = '';
            else :
                $link_begin = '<a href="'.get_attachment_link($image['id']).'" '.$caption_title.'>';
                $link_end = '</a>';
            endif;
        elseif(isset($image['url'])) :
            if($link == 'file') :
                $link_begin = '<a href="'.esc_url($image['src']).'" class="ts-image-link">';
                $link_end = '</a>';
            else :
                $link_begin = (trim($image['url'])) ? '<a href="'.esc_url($image['url']).'" target="'.esc_attr($image['target']).'" '.$caption_title.'>' : '';
                $link_end = (trim($image['url'])) ? '</a>' : '';
            endif;
        else :
            continue;
        endif;
            
        $image_id = (isset($image['id'])) ? $image['id'] : '';
        
        if($type == 'slider') :
            if($oembed_html) :
                $output .= '<li>'.$slide_html.'</li>';
            else :
                $slide = (isset($image['id'])) ? wp_get_attachment_image_src($image['id'], 'large', false) : $image['src'];
                $slide = (is_array($slide)) ? $slide[0] : $slide;
                if($slide) :
                    $h = (!$crop) ? '' : (($slider_height) ? $slider_height : 480);
                    $slide = aq_resize($slide, 940, $h, true, true, true, $image_id);
                    $alt = (isset($image['alt'])) ? esc_attr($image['alt']) : '';
                    $output .= '<li>'.$link_begin.'<img src="'.esc_url($slide).'" alt="'.esc_attr($alt).'"/>'.$link_end.$caption_html.'</li>';
                else :
                    continue;
                endif;
            endif;
        elseif($type == 'carousel') :
            if($oembed_html) :
                $style = 'style="width:'.esc_attr($carousel_width).';height:'.esc_attr($carousel_height).'"';
                $output .= '<'.tag_escape($item_el).' '.$style.' class="carousel-item ts-slider-item">'.$slide_html.'</'.tag_escape($item_el).'>';
            else :
                $slide = (isset($image['id'])) ? wp_get_attachment_image_src($image['id'], 'large', false) : $image['src'];
                $slide = (is_array($slide)) ? $slide[0] : $slide;
                if($slide) :
                    $slide = aq_resize($slide, $carousel_width, $carousel_height, true, false, true, $image_id);
                    $img = $slide[0];
                    $w = $slide[1];
                    $h = $slide[2];
                    $style = 'style="width:'.esc_attr($w).';height:'.esc_attr($h).'"';
                    $alt = (isset($image['alt'])) ? esc_attr($image['alt']) : '';
                    $output .= ($slide) ? '<'.tag_escape($item_el).' '.$style.' class="carousel-item ts-slider-item">'.$link_begin.'<img src="'.esc_url($img).'" width="'.esc_attr($w).'" height="'.esc_attr($h).'" alt="'.esc_attr($alt).'"/>'.$link_end.$caption_html.'</'.tag_escape($item_el).'>' : '';
                else :
                    continue;
                endif;
            endif;
        else :
            $slide = (isset($image['id'])) ? wp_get_attachment_image_src($image['id'], 'large', false) : $image['src'];
            $slide = (is_array($slide)) ? $slide[0] : $slide;
            if($slide) :
                $thumb = aq_resize($slide, $width, $height, true, true, true, $image_id);
            else :
                continue;
            endif;
            $alt = (isset($image['alt'])) ? esc_attr($image['alt']) : '';
            
            $img_id = (isset($image['id'])) ? $image['id'] : rand(1, 1000);
            
            $output .= '<li class="'.esc_attr($li_class).'"><span>';
            $output .= $link_begin.'<img src="'.esc_url($thumb).'" data-attachment-id="'.esc_attr($img_id).'" alt="'.esc_attr($alt).'"/>'.$link_end;
            $output .= '</span></li>';
        endif;
        $i++;
        if(ts_number_within_range($columns, 1, 12) && $i > $columns)
            $i = 1;
    }
    
    $output .= '</'.tag_escape($container_el).'></div>';    
    $output .= (in_array($type, array('slider','carousel'))) ? '</div>' : '';
    $output .= '<div class="clear"></div>';
    
    return $output;
}

//////////////////////////////////////////////////////////////////
// Image shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('image', 'ts_image_shortcode');
function ts_image_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'video_url' => '',
            'url'       => '',
            'target'    => '_self',
            'src'       => '',
            'alt'       => ''
        ), $atts);
        
    $target = (substr($atts['target'], 0, 1) == '_') ? trim($atts['target'], '_') : $atts['target'];
    $target = (in_array($target, array('self','blank'))) ? '_'.$target : '_self';
    
    global $ts_gallery_images;
    
    if(is_array($ts_gallery_images)) :
        $ts_gallery_images[] = array(
            'video_url' => $atts['video_url'],
            'url'       => $atts['url'],
            'target'    => $target,
            'src'       => $atts['src'],
            'alt'       => $atts['alt']
        );
    else :
        if(trim($atts['src'])) :
            $link_begin = (trim($atts['url'])) ? '<a href="'.esc_url($atts['url']).'" target="'.esc_attr($target).'">' : '';
            $link_end = (trim($atts['url'])) ? '</a>' : '';
            return $link_begin . '<img src="'.esc_url($atts['src']).'" alt="'.esc_attr($atts['alt']).'"/>' . $link_end;
        else :
            return '<!-- no image -->';
        endif;
    endif;
}

//////////////////////////////////////////////////////////////////
// Google Maps shortcode
//////////////////////////////////////////////////////////////////
    add_shortcode('map', 'ts_googlemap_shortcode');
    add_shortcode('googlemap', 'ts_googlemap_shortcode');
    function ts_googlemap_shortcode( $atts, $content = null ) {
        $atts = shortcode_atts(array(
            'address'     => '',
            'coordinates' => '',
            'zoom'        => '15',
            'height'      => '300px',
            'hue'         => '',
            'scrollwheel' => 'disabled',
        ), $atts);
        
        extract($atts);

        wp_enqueue_script('googlemaps');
        $out = '';

        if(!$address && !$coordinates) {
            $out .= __('Address was not specified', 'ThemeStockyard');
            return $out;
        }
        
        if(!$coordinates) {
            $coordinates = aq_get_map_coordinates($address);
            if (is_array($coordinates)) {
                $coordinates = $coordinates['lat'] . ',' . $coordinates['lng'];
            } else {
                $out .= __('Wrong coordinates', 'ThemeStockyard');
                return $out;
            }
        }
        
        $height = 'height:'.preg_replace("/[^0-9]*/","",$atts['height']).'px';
        
        $data = '';
        
        $data .= ($atts['hue']) ? ' data-hue="'.esc_attr($atts['hue']).'"' : '';
        $data .= (in_array($atts['scrollwheel'], array('enabled','yes','1','true','on'))) ? ' data-scrollwheel="enabled"' : '';
        
        $out .= '<div id="map_canvas_' . rand(1, 100) . '" class="flexible-map ts-shortcode-block" style="'.esc_attr($height). '" '.$data.'>';
            $out .= '<input class="location" type="hidden" value="' . esc_attr($address) . '" />';
            $out .= '<input class="coordinates" type="hidden" value="' . esc_attr($coordinates) . '" />';
            $out .= '<input class="zoom" type="hidden" value="' . esc_attr($zoom) . '" />';
            $out .= '<div class="map_canvas"></div>';
        $out .= '</div>';

        return $out;
    }

//////////////////////////////////////////////////////////////////
// Hidden/hide shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('hide', 'ts_hidden_shortcode');
add_shortcode('hidden', 'ts_hidden_shortcode');
	function ts_hidden_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'block',
            ), $atts);
        $tag = ($atts['style'] == 'inline') ? 'span' : 'div';
        return '<'.tag_escape($tag).' class="hidden">'."\n" .do_shortcode($content). "\n".'</'.tag_escape($tag).'>';
	}
	
//////////////////////////////////////////////////////////////////
// Highlight shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('highlight', 'ts_highlight_shortcode');
	function ts_highlight_shortcode($atts = null, $content = null) {		
		$atts = shortcode_atts(
            array(
                'background_color' => '',
                'backgroundcolor' => '',
                'background_opacity' => '',
                'backgroundopacity' => '',
                'text_color' => '',
                'textcolor' => '',
                'color' => 'black'
            ), $atts);
        
        $class = $style = '';
    
        $text_color = ($atts['text_color']) ? $atts['text_color'] : (($atts['textcolor']) ? $atts['textcolor'] : '');
        if($text_color && $text_color[0] == '#') {
            $style .= 'color:'.$text_color.';';
            $text_color = '';
        }
        $class .= ($text_color) ? ' color-shortcode '.$text_color.' ' : '';
        
        $bg_color = $atts_bg_color = ($atts['background_color']) ? $atts['background_color'] : (($atts['backgroundcolor']) ? $atts['backgroundcolor'] : '');
        if($bg_color && $bg_color[0] == '#') {
            $style .= 'background-color:'.$bg_color.';';
            $bg_color = '';
        }
        $class .= ($bg_color) ? ' bg-'.$bg_color.' ' : '';
        
        $bg_opacity = ($atts['background_opacity']) ? $atts['background_opacity'] : (($atts['backgroundopacity']) ? $atts['backgroundopacity'] : '');
        if($bg_opacity && strlen($atts_bg_color) >= 1 && $atts_bg_color[0] == '#') {
            $bg_opacity = preg_replace("/[^0-9.]/","",$bg_opacity);
            $bg_opacity = ($bg_opacity > 1 && $bg_opacity <= 100) ? $bg_opacity / 100 : (($bg_opacity >= 0 && $bg_opacity <= 1) ? $bg_opacity : 1); 
            $style .= 'background-color:rgba('.ts_hex2rgb($atts_bg_color,'string').','.$bg_opacity.');';
            $bg_color = '';
        }
        
        if($class || $style)
        {
            $style = ($style) ? 'style="'.esc_attr($style).'"' : '';
            return '<span class="ts-highlight highlight1 '.esc_attr($class).'" '.$style.'>' .do_shortcode($content). '</span>';
        }
        else
        {
            if($atts['color'] == 'yellow') {
                return '<span class="ts-highlight highlight1">' .do_shortcode($content). '</span>';
            } else {
                return '<span class="ts-highlight highlight2">' .do_shortcode($content). '</span>';
            }
        }

	}


//////////////////////////////////////////////////////////////////
// Iconboxes shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('iconboxes', 'ts_iconboxes_shortcode');
function ts_iconboxes_shortcode($atts, $content = null) {
    global $ts_iconboxes;
    $ts_iconboxes = array();
    
    $atts = shortcode_atts(array(
                'style' => '',
                'layout' => '',
                'icon_position' => '',
			), $atts);
    
    
    $style = (trim($atts['style'])) ? $atts['style'] : ((trim($atts['icon_position'])) ? $atts['icon_position'] : $atts['layout']);
    $style = (trim($style)) ? $style : 'icon-outside-left';
    $style = (substr($style, 0, 5) == 'icon-') ? substr($style, 5) : $style;
	$style_options = array('inside-left','outside-left','top');
	$style = (in_array($style, $style_options)) ? $style : 'outside-left';
	
	
	$html = '';
	$html .= '<div class="iconboxes clearfix ts-icon-'.esc_attr($style).' ts-shortcode-block">';
	$_html = do_shortcode($content);
    if(count($ts_iconboxes) > 0) :
        $count = count($ts_iconboxes);
        if($count == 1) :
            $span = '12';
        elseif($count == 2) :
            $span = '6';
        elseif($count == 3) :
            $span = '4';
        else :              // max columns is 4
            $count = 4;
            $span = '3'; 
        endif;
        
        $i = 1;
        foreach($ts_iconboxes AS $iconbox) :
            $position = ($i == $count) ? 'ts-column-last' : (($i == 1) ? 'ts-column-first' : 'ts-column-not-first-or-last');
            $html .= str_replace('<div class="ts-iconbox-wrap', '<div class="ts-iconbox-wrap span'.esc_attr($span).' '.$position, $iconbox);
            $html .= ($i == $count) ? '<div class="clear"></div>' : '';
            $i++;
            $i = ($i > $count) ? $count : $i;
        endforeach;
    else :
        $html .= $_html;
    endif;
	$html .= '</div>';
	
	$ts_iconboxes = array();
	
	return $html;
}


//////////////////////////////////////////////////////////////////
// Iconbox Shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('iconbox', 'ts_iconbox_shortcode');
function ts_iconbox_shortcode($atts, $content = null) 
{
    global $ts_iconboxes;
    
    $atts = shortcode_atts(array(
                'link' => '',
                'icon' => 'question-sign',
				'icon_size' => '',
				'iconsize' => '',
				'icon_color' => '',
				'iconcolor' => '',
				'icon_background_color' => '',
				'iconbackgroundcolor' => '',
				'title' => '',
				'title_color' => '',
				'titlecolor' => '',
				'description' => '',
				'description_color' => '',
				'descriptioncolor' => '',
				'align' => '',
				'linktext' => '',
				'link_text' => '',
			), $atts);
    
    extract($atts);
    
    $icon = ts_fontawesome_class($atts['icon']);
    
    $default_align = (ts_option_vs_default('rtl', 0) == 1) ? 'right' : 'left';
    $align_options = array('center','centered','middle','right','left');
    $align = (in_array($align, $align_options)) ? ((in_array($align, array('centered','middle'))) ? 'center' : $align) : $default_align;
    
    $iconbox_class = '';
    
    $icon_color = ($atts['icon_color']) ? $atts['icon_color'] : (($atts['iconcolor']) ? $atts['iconcolor'] : '');
    $icon_class = '';
    $icon_style = '';
    if($icon_color && $icon_color[0] == '#') {
        $icon_style = 'style="color:'.esc_attr($icon_color).'"';
        $icon_color = '';
    }
    $icon_class = ($icon_color) ? 'color-shortcode '.$icon_color : '';
    
    $icon_bg_color = ($atts['icon_background_color']) ? $atts['icon_background_color'] : (($atts['iconbackgroundcolor']) ? $atts['iconbackgroundcolor'] : '');
    $iconwrap_style = '';
    if($icon_bg_color && $icon_bg_color[0] == '#') {
        $iconwrap_style = 'style="background-color:'.esc_attr($icon_bg_color).'"';
        $icon_bg_color = '';
    }
    $iconwrap_class = ($icon_bg_color) ? 'with-bg bg-'.$icon_bg_color : (($iconwrap_style) ? 'with-bg' : '');
    
    $iconbox_class .= (preg_match("/with-bg/", $iconwrap_class)) ? 'with-icon-bg' : '';
    
    $title_color = ($atts['title_color']) ? $atts['title_color'] : (($atts['titlecolor']) ? $atts['titlecolor'] : '');
    $title_hex = '';
    if($title_color && $title_color[0] == '#') {
        $title_hex = 'style="color:'.esc_attr($title_color).'"';
        $title_color = '';
    }
    $title_color = ($title_color) ? 'color-shortcode '.$title_color : '';
    
    $desc_color = ($atts['description_color']) ? $atts['description_color'] : (($atts['descriptioncolor']) ? $atts['descriptioncolor'] : '');
    $desc_hex = '';
    if($desc_color && $desc_color[0] == '#') {
        $desc_hex = 'style="color:'.esc_attr($desc_color).'"';
        $desc_color = '';
    }
    $desc_color = ($desc_color) ? 'color-shortcode '.$desc_color : '';
    
    $read_more_text = ($atts['linktext']) ? $atts['linktext'] : (($atts['link_text']) ? $atts['link_text'] : '');
    $read_more_text = (trim($read_more_text)) ? $read_more_text : __('Read more', 'ThemeStockyard');
    
    $description = (trim($content)) ? do_shortcode($content) : ((trim($atts['description'])) ? $atts['description'] : '');
	
	
	$html = '';
	$html .= '<div class="ts-iconbox-wrap">';
	$html .= '<div class="iconbox iconbox-align-'.esc_attr($align).' '.esc_attr($iconbox_class).'">';
	$html .= '<div class="iconbox-title text-'.esc_attr($align).'">';
	$html .= '<div class="iconbox-icon-wrap '.esc_attr($iconwrap_class).'" '.$iconwrap_style.'><i class="'.esc_attr($icon).' '.esc_attr($icon_class).'" '.$icon_style.'></i></div>';
	$html .= '<h3 class="text-'.esc_attr($align).' '.esc_attr($title_color).'" '.$title_hex.'>'.$title.'</h3></div>';
	$html .= '<p class="text-'.esc_attr($align).' '.$desc_color.'" '.$desc_hex.'>'.$description.'</p>';
	$html .= ($link) ? '<p class="read-more text-'.esc_attr($align).'"><a href="'.esc_url($link).'">'.$read_more_text.'</a></p>' : '';
	$html .= '</div>';
	$html .= '</div>';
	
	if(isset($ts_iconboxes) && is_array($ts_iconboxes))
        $ts_iconboxes[] = $html;
    else
        return $html;
}

//////////////////////////////////////////////////////////////////
// Link Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('link', 'ts_link_shortcode');
add_shortcode('url', 'ts_link_shortcode');
function ts_link_shortcode($atts = null, $content = null) {
    $atts = shortcode_atts(array(
				'url' => '',
				'target' => '',
				'rel' => '',
				'class' => '',
				'onclick' => '',
				'id' => '',
			), $atts);
    $html = '';
    if(trim($atts['url']) && trim($content)) :
        $target = (trim($atts['target'])) ? $atts['target'] : '';
        $target = (substr($target, 1) == '_') ? $target : (($target == 'blank' || $target == 'self') ? '_'.$target : $target);
        $href = (trim($atts['url'])) ? $atts['url'] : ((trim($atts['href'])) ? $atts['href'] : '');
        $rel = $atts['rel'];
        $class = $atts['class'];
        $onclick = $atts['onclick'];
        $id = $atts['id']; 
        $html .= '<a href="'.esc_url($href).'" rel="'.esc_attr($rel).'" target="'.esc_attr($target).'" class="'.esc_attr($class).'" id="'.esc_attr($id).'" onclick="'.esc_attr($onclick).'">'.$content.'</a>';
    else :
        $html .= $content;
    endif;
    return $html;
}
	
//////////////////////////////////////////////////////////////////
// List shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('list', 'ts_list_shortcode');
	function ts_list_shortcode( $atts = null, $content = null ) {
        $atts = shortcode_atts(
			array(
				'type' => 'ok',
				'icon_color' => '',
				'iconcolor' => '',
			), $atts);
	
	$color = ($atts['icon_color']) ? $atts['icon_color'] : (($atts['iconcolor']) ? $atts['iconcolor'] : '');
    $hex = '';
    if($color && $color[0] == '#') {
        $hex = 'style="border-color:'.esc_attr($color).'"';
        $color = '';
    }
    $color = ($color) ? 'color-shortcode '.$color : '';		
	$icon = ts_fontawesome_class($atts['icon']);
	$content = str_replace('<ul>', '<ul class="list-shortcode">', do_shortcode($content));
	$content = str_replace('<li>', '<li><i class="'.esc_attr($icon).' '.esc_attr($color).'" '.$hex.'></i>', do_shortcode($content));
	
	return $content;
	
}

//////////////////////////////////////////////////////////////////
// Portfolio Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode( 'portfolio', 'ts_portfolio_shortcode' );
function ts_portfolio_shortcode($atts) {
    $layout = (isset($atts['layout'])) ? $atts['layout'] : '';
    $atts = (isset($atts) && is_array($atts)) ? $atts : array();
    
    
    ob_start();
    ts_portfolio($layout, $atts);
    $output = ob_get_contents();
    $output = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $output);
    ob_end_clean();
    
    return $output;
}

//////////////////////////////////////////////////////////////////
// Pricing Column
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_column', 'ts_pricing_column_shortcode');
	function ts_pricing_column_shortcode($atts, $content = null) 
	{
        global $ts_pricing_columns;
        
        $atts = shortcode_atts(array(
                'price' => '',
				'per' => '',
				'title' => '',
				'subtitle' => '',
				'featured' => '',
			), $atts);
        
        $featured = (in_array($atts['featured'], array('true','yes','1'))) ? 'featured border-primary' : 'not-featured border-standard';
		$str = '<div class="ts-pricing-column-wrap ts-shortcode-block"><div class="ts-pricing-column '.esc_attr($featured).'">';
		$str .= '<ul>';
		if($atts['title'] || $atts['price'] || $atts['subtitle']):
            $str .= '<li class="pricing-title-row">';
            $str .= ($atts['title']) ? '<h3 class="primary-color">'.$atts['title'].'</h3>' : '';            
            $per_divider = ($atts['price'] && $atts['per']) ? '/' : '';
            $str .= ($atts['title']) ? '<h4>'.$atts['price'].$per_divider.$atts['per'].'</h4>' : '';
            $str .= ($atts['subtitle']) ? '<p class="small">'.$atts['subtitle'].'</p>' : '';
            $str .= '</li>';
		endif;
		$str .= do_shortcode($content);
		$str .= '</ul>';
		$str .= '</div></div>';
        
        if(isset($ts_pricing_columns) && is_array($ts_pricing_columns))
            $ts_pricing_columns[] = $str;
        else
            return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Footer
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_footer', 'ts_pricing_footer_shortcode');
	function ts_pricing_footer_shortcode($atts, $content = null) 
	{
		$str = '';
		$str .= '<li class="pricing-footer-row border-standard">';
		$str .= do_shortcode($content);
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Price
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_row', 'ts_pricing_row_shortcode');
function ts_pricing_row_shortcode($atts, $content = null) 
{
	$atts = shortcode_atts(array(
                'link' => '',
                'color' => '',
				'strikethrough' => '',
				'bold' => '',
				'italics' => '',
			), $atts);
	
	
    $color = ($atts['color']) ? $atts['color'] : '';
    $color_class = '';
    $color_style = '';
    if($color && $color[0] == '#') {
        $color_style = 'style="color:'.esc_attr($color).'"';
        $color = '';
    }
    $color_class = ($color) ? 'color-shortcode '.$color : '';
    
    
    $link = (trim($atts['link'])) ? $atts['link'] : '';
    
    if($link) :
        $item_begin = '<a href="'.esc_url($link).'" class="'.esc_attr($color_class).'" '.$color_style.'>';
        $item_end = '</a>';
    else :
        $item_begin = '<span class="'.esc_attr($color_class).'" '.$color_style.'>';
        $item_end = '</span>';
    endif;
    
    $strikethrough_begin = (in_array($atts['strikethrough'], array('true','yes','1'))) ? '<strike>' : '';
    $strikethrough_end = (in_array($atts['strikethrough'], array('true','yes','1'))) ? '</strike>' : '';
    
    $bold_begin = (in_array($atts['bold'], array('true','yes','1'))) ? '<strong>' : '';
    $bold_end = (in_array($atts['bold'], array('true','yes','1'))) ? '</strong>' : '';
    
    $italics_begin = (in_array($atts['italics'], array('true','yes','1'))) ? '<em>' : '';
    $italics_end = (in_array($atts['italics'], array('true','yes','1'))) ? '</em>' : '';
    
    $str = '';
    $str .= '<li class="pricing-normal-row border-standard">';
    $str .= $item_begin.$strikethrough_begin.$bold_begin.$italics_begin;
    $str .= do_shortcode($content);
    $str .= $italics_end.$bold_end.$strikethrough_end.$item_end;
    $str .= '</li>';

    return $str;
}

//////////////////////////////////////////////////////////////////
// Pricing table
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_table', 'ts_pricing_table_shortcode');
	function ts_pricing_table_shortcode($atts, $content = null) 
	{			
        global $ts_pricing_columns;
        $ts_pricing_columns = array();
        
        $atts = shortcode_atts(array(
                'separate_columns' => '',
			), $atts);
		
		$sep = (in_array($atts['separate_columns'], array('1','true','yes'))) ? 'separate-columns' : 'joined-columns';
		
		$str = '';
		$str .= '<div class="ts-pricing-table '.esc_attr($sep).'">';
		$_str = do_shortcode($content);
		if(count($ts_pricing_columns) > 0) :
            $count = count($ts_pricing_columns);
            if($count == 1) :
                $span = '12';
            elseif($count == 2) :
                $span = '6';
            elseif($count == 3) :
                $span = '4';
            elseif($count == 4) :
                $span = '3';
            elseif($count == 5) :
                $span = '2-5';
            else :              // max columns is 6
                $count = 6;
                $span = '2';
            endif;
            
            $i = 1;
            foreach($ts_pricing_columns AS $column) :
                $position = ($i == $count) ? 'ts-column-last' : (($i == 1) ? 'ts-column-first' : 'ts-column-not-first-or-last');
                $str .= str_replace('<div class="ts-pricing-column-wrap', '<div class="ts-pricing-column-wrap span'.esc_attr($span).' '.$position, $column);
                $str .= ($i == $count) ? '<div class="clear"></div>' : '';
                $i++;
                $i = ($i > $count) ? $count : $i;
            endforeach;
		else :
            $str .= $_str;
		endif;
		$str .= '</div><div class="clear"></div>';
        
        $ts_pricing_columns = array();
        
		return $str;
	}


//////////////////////////////////////////////////////////////////
// Progess Bar
//////////////////////////////////////////////////////////////////
add_shortcode('progressbar', 'ts_progress_shortcode');
add_shortcode('progress_bar', 'ts_progress_shortcode');
add_shortcode('progress', 'ts_progress_shortcode');
function ts_progress_shortcode($atts, $content = null) {

	$atts = shortcode_atts(array(
		'filled_color' => '',
		'filledcolor' => '',
		'unfilled_color' => '',
		'unfilledcolor' => '',
		'text_color' => '',
		'textcolor' => '',
		'percentage' => '10',
		'unit' => '%',
		'hidetext' => '',
		'hide_text' => '',
	), $atts);

	$filled_color = (trim($atts['filled_color'])) ? $atts['filled_color'] : ((trim($atts['filledcolor'])) ? $atts['filledcolor'] : 'primary');
	$unfilled_color = (trim($atts['unfilled_color'])) ? $atts['unfilled_color'] : ((trim($atts['unfilledcolor'])) ? $atts['unfilledcolor'] : '');
	$text_color = (trim($atts['text_color'])) ? $atts['text_color'] : ((trim($atts['textcolor'])) ? $atts['textcolor'] : 'white');
	
    $filled_hex = '';
    if($filled_color && $filled_color[0] == '#') {
        $filled_hex = 'style="background-color:'.esc_attr($filled_color).'"';
        $filled_color = '';
    }
    $filled_color = ($filled_color) ? 'bg-'.$filled_color : '';
    
    $unfilled_hex = '';
    if($unfilled_color && $unfilled_color[0] == '#') {
        $unfilled_hex = 'style="background-color:'.esc_attr($unfilled_color).'"';
        $unfilled_color = '';
    }
    $unfilled_color = ($unfilled_color) ? 'bg-'.$unfilled_color : '';
    
    $text_hex = '';
    if($text_color && $text_color[0] == '#') {
        $text_hex = 'style="color:'.esc_attr($text_color).'"';
        $text_color = '';
    }
    $text_color = ($text_color) ? 'color-shortcode '.$text_color : '';
    
    $hide_text = (trim($atts['hide_text'])) ? $atts['hide_text'] : ((trim($atts['hidetext'])) ? $atts['hidetext'] : '');
    $hide_text = (ts_attr_is_true($hide_text)) ? true : false;
    $hide_text_class = ($hide_text) ? 'no-text' : '';    

	$html = '';
	$html .= '<div class="ts-progress-bar-wrap ts-shortcode-block '.esc_attr($unfilled_color).' '.esc_attr($hide_text_class).'" '.$unfilled_hex.'>';
	$html .= '<div class="ts-progress-bar '.esc_attr($filled_color).' '.esc_attr($hide_text_class).'" data-percentage="'.esc_attr($atts['percentage']).'" '.$filled_hex.'>';
	$html .= '</div>';
	if($hide_text) :
        $html .= '<div class="ts-progress-title ts-progress-no-text">&nbsp;</div>';
	else :
        $content = (trim($content)) ? $content . ' ' : '';
        $html .= '<div class="ts-progress-title '.esc_attr($text_color).'" '.$text_hex.'>' . $content . $atts['percentage'] . $atts['unit'].'</div>';
	endif;
	$html .= '</div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// right shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('right', 'ts_right_shortcode');
function ts_right_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'style' => ''
    ), $atts);
    
    $html = '<div class="text-right">'.do_shortcode($content).'</div>';
    
    return $html;
}

//////////////////////////////////////////////////////////////////
// show if shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('show_if', 'ts_show_if_shortcode');
function ts_show_if_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'user_is' => '',
            'pagination_page_is' => ''
    ), $atts);
    
    $show = true;
    
    $user_is = preg_replace("/[^0-9a-zA-Z]*/", "", $atts['user_is']);
    $pagination_page_is = preg_replace("/[^0-9,\-\+]*/", "", $atts['pagination_page_is']);
    $pagination_page_is = explode(',', $pagination_page_is);
    
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    if(in_array($user_is, array('loggedin','signedin')) && !is_user_logged_in())
        $show = false;
    
    if(in_array($user_is, array('loggedout','signedout','notloggedin','notsignedin')) && is_user_logged_in())
        $show = false;
    
    $continue = true;
    if($show && is_array($pagination_page_is) && count($pagination_page_is) > 0)
    {
        $show = false;
    
        if($continue && (in_array($page, $pagination_page_is) || in_array('+'.$page, $pagination_page_is))) {
            $show = true;
            $continue = false;
        }
        
        if($continue && in_array('-'.$page, $pagination_page_is)) {
            $continue = false;
            $show = false;
        }
        
        if($continue) {
            $ranges = preg_grep("/^\d+\-\d+$/", $pagination_page_is);
            if(is_array($ranges) && count($ranges) > 0) {
                foreach($ranges AS $range) {
                    $nums = explode('-', $range);
                    if(ts_number_within_range($page, $nums[0], $nums[1])) {
                        $continue = false;
                        $show = true;
                        break;
                    }
                }
            }
        }
        
        if($continue) {            
            $plusses = preg_grep("/^\d+\+$/", $pagination_page_is);
            if(is_array($plusses) && count($plusses) > 0) {
                $plusses = str_replace('+', '', $plusses);
                asort($plusses);
                if($page >= current($plusses)) {
                    $continue = false;
                    $show = true;
                }
            }
        }
    }
    
    $html = ($show) ? do_shortcode($content) : '';
    
    return $html;
}

//////////////////////////////////////////////////////////////////
// hide if shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('hide_if', 'ts_hide_if_shortcode');
function ts_hide_if_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
            'user_is' => '',
            'pagination_page_is' => ''
    ), $atts);
    
    $hide = false;
    
    $user_is = preg_replace("/[^0-9a-zA-Z]*/", "", $atts['user_is']);
    $pagination_page_is = preg_replace("/[^0-9,\-\+]*/", "", $atts['pagination_page_is']);
    $pagination_page_is = explode(',', $pagination_page_is);
    
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    if(in_array($user_is, array('loggedin','signedin')) && is_user_logged_in())
        $hide = true;
    
    if(in_array($user_is, array('loggedout','signedout','notloggedin','notsignedin')) && !is_user_logged_in())
        $hide = true;
    
    $continue = true;
    if(!$hide && is_array($pagination_page_is) && count($pagination_page_is) > 0)
    {    
        if($continue && (in_array($page, $pagination_page_is) || in_array('+'.$page, $pagination_page_is))) {
            $hide = true;
            $continue = false;
        }
        
        if($continue && in_array('-'.$page, $pagination_page_is)) {
            $continue = false;
        }
        
        if($continue) {
            $ranges = preg_grep("/^\d+\-\d+$/", $pagination_page_is);
            if(is_array($ranges) && count($ranges) > 0) {
                foreach($ranges AS $range) {
                    $nums = explode('-', $range);
                    if(ts_number_within_range($page, $nums[0], $nums[1])) {
                        $continue = false;
                        $hide = true;
                        break;
                    }
                }
            }
        }
        
        if($continue) {
            $plusses = preg_grep("/^\d+\+$/", $pagination_page_is);
            if(is_array($plusses) && count($plusses) > 0) {
                $plusses = str_replace('+', '', $plusses);
                asort($plusses);
                if($page >= current($plusses)) {
                    $continue = false;
                    $hide = true;
                }
            }
        }
    }
    
    $html = ($hide) ? '' : do_shortcode($content);
    
    return $html;
}


//////////////////////////////////////////////////////////////////
// Slider shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('carousel_gallery', 'ts_carousel_shortcode');
function ts_carousel_shortcode($atts = null, $content = null) {

    $content = strip_tags($content, '<img>');
    
    if(preg_match("/\[gallery/", $content))
    {
        $height = (isset($atts['height']) && trim($atts['height'])) ? ' height="'.esc_attr($height).'"' : '';
        $content = do_shortcode(preg_replace("/\[gallery/", '[ts_gallery type="carousel"'.$height, $content));
    }
    elseif(preg_match("/\[image/", $content))
    {
        $atts = (is_array($atts)) ? $atts : array();
        $atts['type'] = 'carousel';
        
        global $ts_gallery_images;
        $ts_gallery_images = array();
        do_shortcode($content);
        $content = ts_gallery_shortcode($atts);
        unset($GLOBALS['ts_gallery_images']);
    }
    
    return $content;
}
add_shortcode('slider_gallery', 'ts_slider_shortcode');
add_shortcode('slider', 'ts_slider_shortcode');
function ts_slider_shortcode($atts = null, $content = null) {

    $content = strip_tags($content, '<img>');
    
    $crop = (isset($atts['crop'])) ? $atts['crop'] : 'true';
    $crop = ($crop == '0' || $crop == 'false' || $crop == 'no') ? 'false' : 'true';
    
    if(preg_match("/\[gallery/", $content))
    {
        $content = do_shortcode(preg_replace("/\[gallery/", '[ts_gallery type="slider" crop="'.esc_attr($crop).'"', $content));
    }
    elseif(preg_match("/\[image/", $content))
    {
        $atts = (is_array($atts)) ? $atts : array();
        $atts['type'] = 'slider';
        $atts['crop'] = $crop;
    
        global $ts_gallery_images;
        $ts_gallery_images = array();
        $content = do_shortcode($content);
        $content = ts_gallery_shortcode($atts);
        unset($GLOBALS['ts_gallery_images']);
    }
    
    return $content;
}


//////////////////////////////////////////////////////////////////
// small shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('small', 'ts_small_shortcode');
function ts_small_shortcode($atts, $content = null) {
    
    $html = '<span class="small">'.do_shortcode($content).'</span>';
    
    return $html;
}

//////////////////////////////////////////////////////////////////
// Social Links
//////////////////////////////////////////////////////////////////
add_shortcode('social_links', 'ts_social_links_shortcode');
function ts_social_links_shortcode($atts, $content = null) {
    $atts = (is_array($atts)) ? $atts : array();
    $atts['style'] = isset($atts['style']) ? $atts['style'] : 'graphic';
    $atts['size'] = isset($atts['size']) ? $atts['size'] : 16;
    $color = isset($atts['color']) ? $atts['color'] : '';
    $atts['linktarget'] = isset($atts['linktarget']) ? $atts['linktarget'] : '';
    $atts['linktarget'] = (in_array($atts['linktarget'], array('blank','new','_blank'))) ? '_blank' : '_self';
    
    if($atts['style'] == 'fontawesome')
    {
        $size = (ctype_digit(trim(str_replace('px', '', $atts['size'])))) ? 'font-size:'.trim(str_replace('px', '', $atts['size'])).'px !important' : '';
        $hex = '';
        if($color && $color[0] == '#') {
            $hex = 'color:'.$color;
            $color = '';
        }
        else {
            $color = (trim($color)) ? 'color-shortcode '.$color : '';
        }
        $html = '<span class="social-links-shortcode" style="'.esc_attr($size).'">';
        $all = array();
        foreach($atts as $key => $link) {
            $key = str_replace('_', '-', $key);
            $key = ($key == 'googleplus') ? 'google-plus' : $key;
            if(in_array($key, array('reddit','blogger','deviantart','forrst','myspace','vimeo'))) continue;
            if(trim($link) && !in_array($key, array('linktarget', 'color', 'size', 'style'))) {
                $_html  = '<a href="'.esc_url($link).'" target="'.esc_attr($atts['linktarget']).'" class="'.esc_attr($color).'" style="'.esc_attr($hex).'">';
                $_html .= '<i class="'.ts_fontawesome_class($key).'"></i>';
                $_html .= '</a>';
                $all[] = $_html;
            }
        }
        $html .= implode('<em>&nbsp;</em>', $all);
        $html .= '</span>';
	}
	else
	{
        $size = (strtolower($atts['size']) == 'small') ? '16px' : '32px';
        $html = '<span class="social-links-shortcode">';
        $all = array();
        foreach($atts as $key => $link) {
            $key = str_replace('_', '-', $key);
            $key = ($key == 'googleplus') ? 'google-plus' : $key;
            if($link && !in_array($key, array('linktarget', 'color', 'size', 'style'))) {
                $_html  = '<a href="'.esc_url($link).'" target="'.esc_attr($atts['linktarget']).'">';
                $_html .= '<img src="'.get_template_directory_uri().'/images/zilla-social/'.esc_url($size).'/'.esc_url($key).'.png" alt=""/>';
                $_html .= '</a>';
                $all[] = $_html;
            }
        }
        $html .= implode('<em>&nbsp;</em>', $all);
        $html .= '</span>';
	}

	return (count($all)) ? $html : '';
}
    
//////////////////////////////////////////////////////////////////
// SoundCloud shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('soundcloud', 'ts_soundcloud_shortcode');
	function ts_soundcloud_shortcode($atts = null) {
		$atts = shortcode_atts(
			array(
				'url' => '',
				'width' => '100%',
				'height' => 166,
				'comments' => 'true',
				'auto_play' => 'false',
				'color' => '',
			), $atts);
			
			$width = ts_css_num($atts['width'], true);
			$height = ts_css_num($atts['height'], true);
			$color = trim($atts['color']) ? $atts['color'] : ts_option_vs_default('primary_color', 'ff7700');
			$color = (substr($color, 0, 1) == '#') ? substr($color, 1) : $color;
			
			return '<div class="video-shortcode-wrap ts-shortcode-block"><div class="video-shortcode fluid-width-video-wrapper"><iframe width="'.esc_attr($width).'" height="'.esc_attr($height).'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . urlencode($atts['url']) . '&amp;show_comments=' . esc_attr($atts['comments']) . '&amp;auto_play=' . esc_attr($atts['auto_play']) . '&amp;color=' . esc_attr($color) . '&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe></div></div>';
	}

//////////////////////////////////////////////////////////////////
// Spaces Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('spaces', 'ts_space_shortcode');
add_shortcode('space', 'ts_space_shortcode');
function ts_space_shortcode($atts = null) {
    $atts = shortcode_atts(array(
				'count' => '1',
			), $atts);
    $html = '';
    $count = (ctype_digit($atts['count'])) ? $atts['count'] : '1';
    for($i = 0; $i < $atts['count']; $i++) {
        $html .= '&nbsp;';
    }
    return $html;
}


//////////////////////////////////////////////////////////////////
// Spotify shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('spotify', 'ts_spotify_shortcode');
	function ts_spotify_shortcode($atts = null) {
		$atts = shortcode_atts(
			array(
				'url' => '',
			), $atts);
			
			$audio_url = ts_get_audio_embed_url($atts['url']);
			
			return ($audio_url) ? '<div class="ts-audio-shortcode-wrap ts-shortcode-block"><div class="ts-audio-shortcode fluid-width-audio-wrapper"><iframe class="ts-spotify-embed" src="'.esc_url($audio_url).'" width="100%" height="80" frameborder="0"></iframe></div></div>' : '';
	}


//////////////////////////////////////////////////////////////////
// Tab shortcode (single tab)
//////////////////////////////////////////////////////////////////
add_shortcode('tab', 'ts_tab_shortcode');
	function ts_tab_shortcode( $atts, $content = null ) {
        $atts = shortcode_atts(array(
            'title' => '',
            'icon' => '',
        ), $atts);
    
        global $tabs;
        
        $tabs[] = array('title' => esc_attr($atts['title']), 'icon' => esc_attr($atts['icon']), 'content' => $content);
    }
    
//////////////////////////////////////////////////////////////////
// Tabs shortcode
//////////////////////////////////////////////////////////////////

add_shortcode('tabs', 'ts_tabs_shortcode');
	function ts_tabs_shortcode( $atts = null, $content = null ) {
        $atts = shortcode_atts(
			array(
				'style' => 'simple',
				'layout' => 'horizontal',
				'position' => 'left'
			), $atts);
        
        global $tabs;
        $tabs = array();
        do_shortcode($content);
        
        $style = (isset($atts['style']) && $atts['style'] == 'traditional') ? 'traditional-tabs' : 'simple-tabs';
        $layout = (isset($atts['layout']) && preg_match('/vertical/i', $atts['layout'])) ? 'vertical-tabs' : 'horizontal-tabs';
        if($layout == 'vertical-tabs') :
            $layout .= (preg_match('/right/i', $atts['layout'])) ? ' vertical-tabs-right' : ' vertical-tabs-left';
            $convert_layout = 'vertical';
            $convert_position = (preg_match('/right/i', $atts['layout'])) ? 'right' : 'left';
        else :
            $convert_layout = 'horizontal';
            $convert_position = 'left';
        endif;
    
        $out = '';
        
        $out .= '<div class="ts-tabs-widget tabs-widget widget shortcode-tabs '.esc_attr($style).' '.esc_attr($layout).' ts-shortcode-block">';

        $out .= '<div class="tab-widget">';
        
        $out .= ts_convert_to_tabs($tabs, $convert_layout, $convert_position);
        
        //$out .= '<div class="clear"></div>';

        $out .= '</div></div>';
        
        unset($GLOBALS['tabs']);
        
        return $out;
    }
    function ts_convert_to_tabs(array $arr, $layout = 'horizontal', $position = 'left')
    {
        global $tabs;
        
        $out = '';
        $tab_header = '';
        $tab_contents = '';
        
        $tab_header .= '<ul class="tab-header clearfix">';
        $i = 1;
        foreach($tabs AS $tab) {
            $class = ($i == 1) ? 'active' : '';
            $icon = ts_fontawesome_class($tab['icon']);
            $title = (trim($tab['title'])) ? $tab['title'] : '';
            $icon_title_space = ($icon && $title) ? '&nbsp;' : '';
            $title = ($icon) ? '<i class="'.esc_attr($icon).'"></i>' . $icon_title_space . $title : (($title) ? $title : '???');
            $tab_header .= '<li class="'.esc_attr($class).'">' . $title . '</li>';
            $i++;
        }
        $tab_header .= '</ul>';
        
        $i = 1;
        $tab_contents .= '<div class="tab-contents">';
        foreach($tabs AS $tab) {
            $content = (trim($tab['content'])) ? $tab['content'] : '&nbsp;';
            $tab_contents .= '<div id="tab' . $i . '" class="tab-context">' . wpautop(do_shortcode($content)) . '</div>';
            $i++;
        }
        $tab_contents .= '</div>';
        
        if($layout == 'vertical' && $position == 'right') :
            $out = $tab_contents.$tab_header;
        else :
            $out = $tab_header.$tab_contents; 
        endif;
        
        return $out;
    }



//////////////////////////////////////////////////////////////////
// Table shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table', 'ts_table_shortcode');
	function ts_table_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
            
        $style_options = array('basic','striped','bordered','hover');
        $style = (in_array($style, $style_options)) ? $style : 'basic';
        
        $html  = '<table class="table table-'.esc_attr($style).' ts-shortcode-block">'."\n";
        $html .= do_shortcode($content);
        $html .= '</table>'. "\n";
        
        return $html;
	}



//////////////////////////////////////////////////////////////////
// Table Body shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table_body', 'ts_table_body_shortcode');
	function ts_table_body_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
        
        return '<tbody>' .do_shortcode($content). '</tbody>'. "\n";
	}



//////////////////////////////////////////////////////////////////
// Table Cell shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table_cell', 'ts_table_cell_shortcode');
	function ts_table_cell_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
        
        return '<td>' .do_shortcode($content). '</td>'. "\n";
	}



//////////////////////////////////////////////////////////////////
// Table Head Row shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table_heading_row', 'ts_table_head_row_shortcode');
add_shortcode('table_head_row', 'ts_table_head_row_shortcode');
	function ts_table_head_row_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
        
        return '<thead><tr>'."\n" .do_shortcode($content). '</tr></thead>'. "\n";
	}



//////////////////////////////////////////////////////////////////
// Table Heading shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table_heading', 'ts_table_heading_shortcode');
	function ts_table_heading_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
        
        return '<th>' .do_shortcode($content). '</th>'. "\n";
	}



//////////////////////////////////////////////////////////////////
// Table Row shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('table_row', 'ts_table_row_shortcode');
	function ts_table_row_shortcode($atts = null, $content = null) {
        $atts = shortcode_atts(array(
                'style' => 'basic',
            ), $atts);
        
        extract($atts);
        
        return '<tr>'."\n" .do_shortcode($content) .'</tr>'. "\n";
	}

//////////////////////////////////////////////////////////////////
// Tagline / Callout shortcode
//////////////////////////////////////////////////////////////////
    add_shortcode('tagline', 'ts_tagline_shortcode');
    add_shortcode('callout', 'ts_tagline_shortcode');
	function ts_tagline_shortcode($atts, $content = null) {
        $atts = shortcode_atts(array(
                'link' => '',
                'align' => '',
                'add_shadow' => 'no',
                'button_text' => '',
                'buttontext' => '',
                'button_color' => '',
                'buttoncolor' => '',
                'button_size' => '',
                'buttonsize' => '',
                'button_position' => '',
                'buttonposition' => '',
                'link_target' => '',
                'linktarget' => '',
                'background_color' => '',
                'background_image' => '',
                'background_position' => '',
                'background_repeat' => '',
                'border_color' => '',
                'title' => '',
                'title_color' => '',
                'description' => '',
                'description_color' => '',
            ), $atts);
        
        $wrap_css = $inner_css = array();
        $button_text = ($atts['button_text']) ? $atts['button_text'] : (($atts['buttontext']) ? $atts['buttontext'] : '');
        
        $default_align = (ts_option_vs_default('rtl', 0) == 1) ? 'right' : 'left';
        $align = (in_array($atts['align'], array('left', 'center', 'centered', 'middle', 'right'))) ? $atts['align'] : $default_align;
        $align = (in_array($align, array('centered', 'middle'))) ? 'text-center' : 'text-'.$align;
        
        $link_target = ($atts['link_target']) ? $atts['link_target'] : (($atts['linktarget']) ? $atts['linktarget'] : '');
        $link_target = (in_array($link_target, array('_self', '_blank'))) ? esc_attr($link_target) : '';
        
        $button_size = ($atts['button_size']) ? $atts['button_size'] : (($atts['buttonsize']) ? $atts['buttonsize'] : '');
        $button_size = (in_array($button_size, array('small', 'medium', 'large'))) ? esc_attr($button_size) : 'medium';
        
        $button_color = ($atts['button_color']) ? $atts['button_color'] : (($atts['buttoncolor']) ? $atts['buttoncolor'] : '');
        $button_style_color = (substr($button_color, 0, 1) == '#') ? 'style="background-color:'.esc_attr($button_color).' !important"' : '';
        $button_color = (substr($button_color, 0, 1) == '#') ? '' : esc_attr($button_color);
		
		$default_button_position = (ts_option_vs_default('rtl', 0) == 1) ? 'left' : 'right';
        $button_position = ($atts['button_position']) ? $atts['button_position'] : (($atts['buttonposition']) ? $atts['buttonposition'] : '');
        $button_position = (in_array($button_position, array('left', 'right', 'bottom'))) ? esc_attr($button_position) : $default_button_position;
        
        $button_size = ($atts['button_size']) ? $atts['button_size'] : (($atts['buttonsize']) ? $atts['buttonsize'] : '');
        $button_size = (in_array($button_size, array('small', 'medium', 'large'))) ? esc_attr($button_size) : 'medium';
        
        $shadow = ($atts['add_shadow'] == 'yes') ? 'shadow' : '';
        
        $border_color = ($atts['border_color']) ? $atts['border_color'] : '';
        if(substr($border_color, 0, 1) == '#') {
            $wrap_css['border-color'] = esc_attr($border_color).' !important';
            $inner_css['border-color'] = esc_attr($border_color).' !important';
            $border_color = '';
        }
        else {
            $border_color = ($border_color) ? 'border-'.$border_color : '';
        }
        
        $background_color = ($atts['background_color']) ? $atts['background_color'] : '';
        if(substr($background_color, 0, 1) == '#') {
            $inner_css['background-color'] = $background_color;
            $background_color = '';
        }
        else {
            $background_color = ($background_color) ? 'bg-'.$background_color : '';
        }
        
        $title_css = '';
        $title_color = ($atts['title_color']) ? $atts['title_color'] : '';
        if(substr($title_color, 0, 1) == '#') {
            $title_css .= 'color:'.esc_attr($title_color).' !important;';
            $title_color = '';
        }
        else {
            $title_color = ($title_color) ? 'color-'.$title_color : '';
        }
        
        $description_css = '';
        $description_color = ($atts['description_color']) ? $atts['description_color'] : '';
        if(substr($description_color, 0, 1) == '#') {
            $description_css .= 'color:'.esc_attr($description_color).' !important;';
            $description_color = '';
        }
        else {
            $description_color = ($description_color) ? 'color-'.$description_color : '';
        }
        
        $background_image = str_replace('%%template_directory_uri%%', get_template_directory_uri(), $atts['background_image']);
        $background_image = ($background_image) ? esc_url($background_image) : '';
        $background_repeat = (in_array($atts['background_repeat'], array('no-repeat','repeat','repeat-x','repeat-y'))) ? $atts['background_repeat'] : 'repeat';
        //$background_repeat = ($parallax == 'parallax') ? 'no-repeat' : $background_repeat;
        $background_position = (isset($atts['background_position'])) ? $atts['background_position'] : '50% 50%';
        $background_size = (isset($atts['background_size'])) ? $atts['background_size'] : '';
        if($background_image) {
            $inner_css['background-image'] = "url(".$background_image.")";
            $inner_css['background-repeat'] = $background_repeat;
            $inner_css['background-position'] = $background_position;
            if($background_size) {
                $inner_css['background-size'] = $background_size;
                $inner_css['-moz-background-size'] = $background_size;
                $inner_css['-webkit-background-size'] = $background_size;
                $inner_css['-o-background-size'] = $background_size;
            }
        }
        
        $wrap_style = '';
        foreach($wrap_css AS $key => $value) {
            $wrap_style .= $key .':'.$value.';';
        }
        
        $inner_style = '';
        foreach($inner_css AS $key => $value) {
            $inner_style .= $key .':'.$value.';';
        }
        
        $description = (trim($content)) ? do_shortcode($content) : (($atts['description']) ? $atts['description'] : '');
        
		$str = '';
		$str .= '<div class="tagline-shortcode ts-shortcode-block '.esc_attr($align).' '.esc_attr($shadow).' '.esc_attr($border_color).'" style="'.esc_attr($wrap_style).'">';
		$str .= '<div class="tagline '.esc_attr($background_color).' '.esc_attr($border_color).'" style="'.esc_attr($inner_style).'">';
			if($atts['link'] && $button_text && in_array($button_position, array('left', 'right'))):
                $str .= '<div class="desktop-button pull-'.esc_attr($button_position).'"><a href="'.esc_url($atts['link']).'" target="'.esc_attr($link_target).'" class="button '.esc_attr($button_color).' '.esc_attr($button_size).'" '.esc_attr($button_style_color).'>'.stripslashes($button_text).'</a></div>';
			endif;
			if($atts['title']):
                $str .= '<h2 class="'.esc_attr($align).' '.esc_attr($title_color).'" style="'.esc_attr($title_css).'">'.stripslashes($atts['title']).'</h2>';
			endif;
			if($description):
                $str.= '<p class="'.esc_attr($align).' '.esc_attr($description_color).'" style="'.esc_attr($description_css).'">'.stripslashes($description).'</p>';
			endif;
			if($atts['link'] && $button_text) :
                $mobile_button =  (in_array($button_position, array('left', 'right'))) ? 'mobile-button' : '';
                $str .= '<div class="'.esc_attr($align).' '.esc_attr($mobile_button).'"><a href="'.esc_url($atts['link']).'" target="'.esc_attr($link_target).'" class="bottom-button button '.esc_attr($button_color).' '.esc_attr($button_size).'" '.esc_attr($button_style_color).'>'.stripslashes($button_text).'</a></div>';
			endif;
		$str .= '</div></div>';

		return $str;
	}


//////////////////////////////////////////////////////////////////
// Theme Directory Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('theme_directory', 'ts_template_directory_shortcode');
add_shortcode('template_directory', 'ts_template_directory_shortcode');
function ts_template_directory_shortcode($atts = null) {
    return get_template_directory_uri();
}

//////////////////////////////////////////////////////////////////
// Title Shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('title', 'ts_title_shortcode');
function ts_title_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
				'size' => '3',
				'align' => '',
				'line_style' => '',
				'style' => '',
				'padding_top' => '0',
				'padding_bottom' => '0',
				'margin_top' => '0',
				'margin_bottom' => '0',
				'color' => '',
				'border_color' => '',
			), $atts);
    
    $hex = $class = $style = $h_atts ='';
    
    $size = $font_size = preg_replace("/[^0-9]*/","",$atts['size']);
    $size = (ts_number_within_range($size, 1, 6)) ? $size : 3;
    if($font_size > 6) {
        $style .= 'font-size:'.$font_size.'px;';
        $size = 1;
    }
    
    $default_align = (ts_option_vs_default('rtl', 0) == 1) ? 'right' : 'left';
    $align_options = array('center','centered','middle','right','left');
    $align = (in_array($atts['align'], $align_options)) ? ((in_array($atts['align'], array('centered','middle'))) ? 'text-center' : 'text-'.$atts['align']) : 'text-'.$default_align;
    
    
    $line_style_options = array('none','line','single','single-line','dashed','dotted','double-line','double-dashed','double-dotted');
    $line_style = ($atts['line_style']) ? $atts['line_style'] : $atts['style'];
    $line_style = (in_array($line_style, $line_style_options)) ? $line_style : 'none';
    $line_style = (in_array($line_style, array('single','single-line'))) ? 'line' : $line_style;
    
    $padding_top = max(preg_replace("/[^0-9]*/","",$atts['margin_top']), preg_replace("/[^0-9]*/","",$atts['padding_top']));
	$padding_top = preg_replace("/[^0-9]*/","",$padding_top);
	$padding_bottom = max(preg_replace("/[^0-9]*/","",$atts['margin_bottom']), preg_replace("/[^0-9]*/","",$atts['padding_bottom']));
	$padding_bottom = preg_replace("/[^0-9]*/","",$padding_bottom);
	
	$color = ($atts['color']) ? $atts['color'] : '';
    if($color && $color[0] == '#') {
        $style .= 'color:'.$color.';';
        $color = '';
    } else {
        $class = ($color) ? 'color-shortcode '.$color : '';
    }
    
    $border_color = ($atts['border_color']) ? $atts['border_color'] : '';
    $title_sep_class_style = 'class="title-sep"';
    if(substr($border_color, 0, 1) == '#') {
        $title_sep_class_style = 'class="title-sep" style="border-color:'.esc_attr($border_color).' !important;"';
        $border_color = '';
    }
    $title_sep_class_style = ($border_color) ? 'class="title-sep border-'.esc_attr($border_color).'"' : $title_sep_class_style;
    
    $h_atts .= ' style="'.esc_attr($style).'"'; 
    $h_atts .= ' class="'.esc_attr($class).'"';
    
    
	$html  = '<div class="title-shortcode '.esc_attr($align).' '.esc_attr($line_style).'" style="padding-top:'.intval($padding_top).'px;padding-bottom:'.intval($padding_bottom).'px;">';
	if($align == 'text-center') :
        $html .= ($line_style == 'none') ? '' : '<div class="title-sep-container"><div '.$title_sep_class_style.'>&nbsp;</div></div>';
        $html .= '<h'.absint($size).' '.$h_atts.'><span>'.do_shortcode($content).'</span></h'.absint($size).'>';
        $html .= ($line_style == 'none') ? '' : '<div class="title-sep-container"><div '.$title_sep_class_style.'>&nbsp;</div></div>';
	elseif($align == 'text-right') :
        $rtl = (ts_option_vs_default('rtl', 0) == 1) ? true : false;
        $html .= ($line_style == 'none') ? '' : ($rtl ? '' : '<div class="title-sep-container"><div '.$title_sep_class_style.'></div></div>');
        $html .= '<h'.absint($size).' '.$h_atts.'><span>'.do_shortcode($content).'</span></h'.absint($size).'>';
        $html .= ($line_style == 'none') ? '' : ($rtl ? '<div class="title-sep-container"><div '.$title_sep_class_style.'></div></div>' : '');
	else :
        $rtl = (ts_option_vs_default('rtl', 0) == 1) ? true : false;
        $html .= ($line_style == 'none') ? '' : ($rtl ? '<div class="title-sep-container"><div '.$title_sep_class_style.'></div></div>' : '');
        $html .= '<h'.absint($size).' '.$h_atts.'><span>'.do_shortcode($content).'</span></h'.absint($size).'>';
        $html .= ($line_style == 'none') ? '' : ($rtl ? '' : '<div class="title-sep-container"><div '.$title_sep_class_style.'></div></div>');
	endif;
	
	$html .= '</div>';
	
	return $html;
}

//////////////////////////////////////////////////////////////////
// Toggle shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('toggle', 'ts_toggle_shortcode');
function ts_toggle_shortcode( $atts = null, $content = null ) {
    $atts = shortcode_atts(array(
        'title' => '',
        'open'  => '',
    ), $atts);
    
    extract($atts);
    
    global $open_icon, $closed_icon, $ts_toggles;

    $opens = $open == 'yes' ? 'open' : 'closed';
    $icon = $open == 'yes' ? $open_icon : $closed_icon;
    $active = $open == 'yes' ? 'active' : '';

    $html = '';

    $html .= '<div class="accordion-block">';
        $html .= '<h5 class="tab-head ' . esc_attr($active) . '"><i class="'.esc_attr($icon).'"></i>' . $title . '</h5>';
        $html .= '<div class="tab-body ' . esc_attr($opens) . '">';
            $html .= wpautop(do_shortcode(htmlspecialchars_decode($content)));
        $html .= '</div>';
    $html .= '</div>';
	
	if(isset($ts_toggles) && is_array($ts_toggles))
        $ts_toggles[] = $html;
    else
        return $html;
}

//////////////////////////////////////////////////////////////////
// Toggles shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('toggles', 'ts_toggles_shortcode');
function ts_toggles_shortcode( $atts = null, $content = null ) {
    $atts = shortcode_atts(array(
        'open_icon' => 'minus',
        'closed_icon' => 'plus',
    ), $atts);
    
    global $open_icon, $closed_icon, $ts_toggles;
    
    $ts_toggles = array();
    
    $open_icon = (trim($atts['open_icon'])) ? $atts['open_icon'] : 'chevron-down';
    $open_icon = ts_fontawesome_class($open_icon);
    
    $closed_icon = (trim($atts['closed_icon'])) ? $atts['closed_icon'] : 'chevron-right';        
    $closed_icon = ts_fontawesome_class($closed_icon);

    $html = '';
            
    $html .= '<div class="toggles-wrapper tog-acc-wrapper toggles ts-shortcode-block" data-open-icon="'.esc_attr($open_icon).'" data-closed-icon="'.esc_attr($closed_icon).'">';
    $_html = do_shortcode($content);     
    if(count($ts_toggles) > 0) :
        $count = count($ts_toggles);
        
        $i = 1;
        foreach($ts_toggles AS $toggle) :
            $position = ($i == $count) ? 'last' : (($i == 1) ? 'first' : 'not-first-or-last');
            $html .= str_replace('<div class="accordion-block', '<div class="accordion-block '.$position, $toggle);
            $i++;
            $i = ($i > $count) ? $count : $i;
        endforeach;
    else :
        $html .= $_html;
    endif;     
    $html .= '</div>';
    
    $ts_toggles = array();

    return $html;
}
	
//////////////////////////////////////////////////////////////////
// Vimeo shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('vimeo', 'ts_vimeo_shortcode');
    function ts_vimeo_shortcode($atts = null) {
        $atts = shortcode_atts(
            array(
                'id' => '',
                'url' => '',
                'width' => 600,
                'height' => 337,
                'autoplay' => ''
            ), $atts);
            
            $_id = (trim($atts['id'])) ? $atts['id'] : ((trim($atts['url'])) ? $atts['url'] : '');
			$id = ts_get_video_id($_id);
			
			$autoplay = (in_array($atts['autoplay'], array('true','1','yes'))) ? '&amp;autoplay=1' : '';

            if($id) {        
                return '<div class="video-shortcode-wrap ts-shortcode-block"><div class="video-shortcode fluid-width-video-wrapper"><iframe src="'.esc_url('https://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;api=1'.$autoplay).'" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" frameborder="0" id="'.esc_attr('vimeo_'.$id).'" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div>';
            }
    }
	
	
//////////////////////////////////////////////////////////////////
// Vine shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('vine', 'ts_vine_shortcode');
    function ts_vine_shortcode($atts = null) {
        $atts = shortcode_atts(
            array(
                'url' => '',
                'width' => '100%',
                'height' => 'auto'
            ), $atts);
            
            $id = ts_get_video_id($atts['url']);

            if($id) {        
                return '<div class="video-shortcode-wrap ts-shortcode-block"><div class="vine-shortcode fluid-width-video-wrapper fluid-width-video-wrapper-vine"><iframe class="vine-embed" src="'.esc_attr('https://vine.co/v/'.$id.'/embed/simple').'" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script></div></div>';
            }
    }

//////////////////////////////////////////////////////////////////
// Year Shortcode.
//////////////////////////////////////////////////////////////////
add_shortcode('year', 'ts_year_shortcode');
function ts_year_shortcode($atts = null) {
    return date_i18n('Y');
}

//////////////////////////////////////////////////////////////////
// Youtube shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('youtube', 'ts_youtube_shortcode');
	function ts_youtube_shortcode($atts = null) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'url' => '',
				'width' => 600,
				'height' => 337,
				'autoplay' => '',
				'controls' => 1,
				'showinfo' => 1,
				
				
			), $atts);
			
			$_id = (trim($atts['id'])) ? $atts['id'] : ((trim($atts['url'])) ? $atts['url'] : '');
			$id = ts_get_video_id($_id);
			
			$autoplay = (in_array($atts['autoplay'], array('true','1','yes'))) ? '&amp;autoplay=1' : '';
			//$controls = ($atts['controls'] == 2 || in_array($atts['controls'], array('hidden','none'))) ? '&amp;controls=2' : '&amp;controls=2';
			//$showinfo = ($atts['showinfo'] == 0 || in_array($atts['showinfo'], array('no','false'))) ? '&amp;showinfo=0' : '&amp;showinfo=0';
			$controls = '';
			$showinfo = '';

            if($id) {
                return '<div class="video-shortcode-wrap ts-shortcode-block"><div class="video-shortcode fluid-width-video-wrapper"><iframe title="YouTube video player" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" src="'.esc_url('https://www.youtube.com/embed/' . $id . '?hd=1'.$autoplay.$controls.$showinfo).'" frameborder="0" id="'.esc_attr('youtube_'.$id).'" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div>';
			}
	}