<?php 
/**
 * SMOF Options Machine Class
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.0.0
 * @author      Syamil MJ
 */

class Options_Machine {

    static public $Options;

	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct($options) {
	
        self::$Options = $options;
		
		/*
		$return = $this->optionsframework_machine($options);
		
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
		*/
	}
	
	
	public function Defaults() {

		$options = self::$Options;
		
		$defaults = array();
		
		foreach ($options as $value) {
            //create array of defaults		
            if ($value['type'] == 'multicheck'){
                if (is_array($value['std'])){
                    foreach($value['std'] as $i=>$key){
                        $defaults[$value['id']][$key] = true;
                    }
                } else {
                        $defaults[$value['id']][$value['std']] = true;
                }
            } else {
                if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
            }
        }
        
        return $defaults;
	}
	
	
	public function Menu() {

		$options = self::$Options;
		
		$menu = '';
		
		foreach ($options as $value) {
			
            //tab heading
			if($value['type'] == 'heading') {
                $caption = (isset($value['caption'])) ? trim($value['caption']) : '';
                $caption = ($caption) ? '<span class="caption">'.$caption.'</span>' : '';
                $class = str_replace(' ','',strtolower($value['name']));
                $header_class = (isset($value['class'])) ? $value['class'].' '.$class : $class;
                $jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
                $jquery_click_hook = "of-option-" . $jquery_click_hook;
                
                echo '<li class="'. esc_attr($header_class) .'"><a title="'. esc_attr($value['name']) .'" href="#'. $jquery_click_hook .'">'. $value['name'] .$caption .'</a></li>';
            }
            else
            {
                continue;
            }
        }
        
        //return $menu;
	}


	/**
	 * Process options data and build option fields
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function Inputs() {
	
        $options = self::$Options;

	    $smof_data = of_get_options();
	    global $ts_all_fonts;

		   
	    $counter = 0;
		$menu = '';
		$output = '';
		
		
		foreach ($options as $value) {
		
			$counter++;
			$val = '';
			$output = '';
			
			//Start Heading
			 if ( $value['type'] != "heading" )
			 {
			 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
			 	$caption = ''; if(isset( $value['caption'] )) { $caption = $value['caption']; }
				
				//hide items in checkbox group
				$fold='';
				if (array_key_exists("fold",$value)) {
					if ($smof_data[$value['fold']]) {
						$fold="f_".$value['fold']." ";
					} else {
						$fold="f_".$value['fold']." temphide ";
					}
				}
	
				$output .= '<div id="section-'.esc_attr($value['id']).'" class="'.esc_attr($fold).'section section-'.esc_attr($value['type']).' '. esc_attr($class) .'">'."\n";
				
				//only show header if 'name' value exists
				if($value['name']) $output .= '<h3 class="heading">'. $value['name'] . '</h3>'."\n";
				
				//produce caption if there is one
				if(trim($caption)) $caption = '<div class="caption">'.$caption.'</div>'."\n";
				
				$output .= '<div class="option">'."\n" . $caption .'<div class="controls">'."\n";
	
			 } 
			 //End Heading
			
			//switch statement to handle various options type                              
			switch ( $value['type'] ) {
                //radiobox option
				case "hidden":
                    $t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
                    $output .= '<input class="of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" type="'. esc_attr($value['type']) .'" value="'. esc_attr($t_value) .'" />';
				break;
				
				//text input
				case 'text':
					$t_value = '';
					$t_value = (isset($smof_data[$value['id']])) ? stripslashes($smof_data[$value['id']]) : stripslashes($value['std']);
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					
					$output .= '<input class="of-input '.esc_attr($mini).'" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" type="'. esc_attr($value['type']) .'" value="'. esc_attr($t_value) .'" />';
				break;
				
				//select option
				case 'select':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select_wrapper ' . esc_attr($mini) . '">';
					$output .= '<select class="select of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'">';
					$selected_option = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : ((isset($value['std'])) ? $value['std'] : "");
					foreach ($value['options'] as $select_ID => $option) {	
                        $select_ID = (!isset($select_ID)) ? $option : $select_ID;
						$output .= '<option id="' . esc_attr($select_ID) . '" value="'.esc_attr($select_ID).'" ' . selected($selected_option, $select_ID, false) . ' />'.$option.'</option>';	 
					 } 
					$output .= '</select></div>';
				break;
				
				//select option
				case 'multiselect':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select-multiple-wrapper ' . esc_attr($mini) . '">';
					$output .= '<select class="select-multiple of-input" name="'.esc_attr($value['id']).'[]" id="'. esc_attr($value['id']) .'" multiple>';
					$selected_option = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : ((isset($value['std'])) ? $value['std'] : "");
					foreach ($value['options'] as $select_ID => $option) {	
                        $select_ID = (!isset($select_ID)) ? $option : $select_ID;
                        
                        if(is_array($selected_option)) {
                            $selected = (in_array($select_ID, $selected_option)) ? 'selected="selected"' : '';
                        } else {
                            $selected = selected($selected_option, $select_ID, false);
                        }
                        
						$output .= '<option id="' . esc_attr($select_ID) . '" value="'.esc_attr($select_ID).'" ' . $selected . ' />'.$option.'</option>';	 
					 } 
					$output .= '</select></div>';
				break;
				
				//textarea option
				case 'textarea':	
					$cols = '8';
					$ta_value = '';
					
					if(isset($value['options'])){
							$ta_options = $value['options'];
							if(isset($ta_options['cols'])) {
                                $cols = $ta_options['cols'];
							} 
						}
						
						$ta_value = (isset($smof_data[$value['id']])) ? stripslashes($smof_data[$value['id']]) : stripslashes($value['std']);			
						$output .= '<textarea class="of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" cols="'. esc_attr($cols) .'" rows="8">'.$ta_value.'</textarea>';		
				break;
				
				//radiobox option
				case "radio":
                    $checked_val = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : ((isset($value['std'])) ? $value['std'] : '');
					 foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="'.esc_attr($value['id']).'" type="radio" value="'.esc_attr($option).'" ' . checked($checked_val, $option, false) . ' /><label class="radio">'.$name.'</label><br/>';				
					}
				break;
				
				//checkbox option
				case 'checkbox':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = (isset($value['std'])) ? $value['std'] : 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
		
					$output .= '<input type="hidden" class="'.esc_attr($fold).'checkbox of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" value="0"/>';
					$output .= '<input type="checkbox" class="'.esc_attr($fold).'checkbox of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
				break;
				
				//multiple checkbox option
				case 'multicheck': 			
					//(isset($smof_data[$value['id']]))? $multi_stored = $smof_data[$value['id']] : $multi_stored="";
					$multi_stored = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : ((isset($value['std'])) ? $value['std'] : '');
								
					foreach ($value['options'] as $key => $option) {
                        if(is_array($multi_stored)) {
                            if(isset($value['keyAsValue']) && $value['keyAsValue'] === true)
                                $check_this = (in_array($key, $multi_stored)) ? $key : '';
                            else
                                $check_this = (isset($multi_stored[$key])) ? $multi_stored[$key] : '';
                        } else {
                            $check_this = $multi_stored;
                        }
						$of_key_string = $value['id'] . '_' . $key;
						$_val = (isset($value['keyAsValue']) && $value['keyAsValue'] === true) ? $key : '1';
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.esc_attr($value['id']).'['.esc_attr($key).']'.'" id="'. esc_attr($of_key_string) .'" value="'.esc_attr($_val).'" '. checked($check_this, $_val, false) .' /><label class="multicheck" for="'. esc_attr($of_key_string) .'">'. $option .'</label><br />';								
					}			 
				break;
				
				//ajax image upload option
				case 'upload':
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_uploader_function($value['id'],$value['std'],$value['mod']);			
				break;
				
				// native media library uploader - @uses optionsframework_media_uploader_function()
				case 'media':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_media_uploader_function( $value['id'], $value['std'], $int, $value['mod'] ); // New AJAX Uploader using Media Library			
				break;
				
				//colorpicker option
				case 'color':	
                    $color_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					$output .= '<div id="' . esc_attr($value['id']) . '_picker" class="colorSelector"><div style="background-color: '.esc_attr($color_stored).'"></div></div>';
					$output .= '<input class="of-color" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" type="text" value="'. esc_attr($color_stored) .'" />';
				break;
				
				//typography option
				case 'big_typography':	
				case 'typography':
				
					$typography_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					if(is_array($value['std'])) {
                        foreach($value['std'] AS $key => $val) {
                            $typography_stored[$key] = (isset($typography_stored[$key])) ? $typography_stored[$key] : $val;
                        }
					}
					
					/* Font Size */
					
					if(isset($typography_stored['size']) && isset($value['std']['size'])) {
					//if(isset($value['std']['size'])) {
                        $typography_stored['size'] = (isset($typography_stored['size'])) ? $typography_stored['size'] : $value['std']['size'];
						$output .= '<div class="select_wrapper typography-size" original-title="Font size">';
						$output .= '<select class="of-typography of-typography-size select" name="'.esc_attr($value['id']).'[size]" id="'. esc_attr($value['id']).'_size">';
                        $sizes = array(9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 21, 24, 26, 28, 30, 32, 36, 42, 48, 52, 56, 60, 64, 68, 72);
                        foreach($sizes AS $i){ 
                            $test = $i.'px';
                            $output .= '<option value="'. intval($i) .'px" ' . selected($typography_stored['size'], $test, false) . '>'. intval($i) .'px</option>'; 
                        }
				
						$output .= '</select></div>';
					
					}
					
					/* Line Height */
					if(isset($typography_stored['height']) && isset($value['std']['height'])) {
					//if(isset($value['std']['height'])) {
                        $typography_stored['height'] = (isset($typography_stored['height'])) ? $typography_stored['height'] : $value['std']['height'];
						$output .= '<div class="select_wrapper typography-height" original-title="Line height">';
						$output .= '<select class="of-typography of-typography-height select" name="'.esc_attr($value['id']).'[height]" id="'. esc_attr($value['id']).'_height">';
							for ($i = 20; $i < 48; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. intval($i) .'px" ' . selected($typography_stored['height'], $test, false) . '>'. intval($i) .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
						
					/* Font Face */
					if(isset($typography_stored['face']) && isset($value['std']['face'])) {
					//if(isset($value['std']['face'])) {
                        $typography_stored['face'] = (isset($typography_stored['face'])) ? $typography_stored['face'] : $value['std']['face'];
						$output .= '<div class="select_wrapper typography-face" original-title="Font family">';
						$output .= '<select class="of-typography of-typography-face select" name="'.esc_attr($value['id']).'[face]" id="'. esc_attr($value['id']).'_face">';
											
						$faces = array('arial'=>'Arial',
										'verdana'=>'Verdana, Geneva',
										'trebuchet'=>'Trebuchet',
										'georgia' =>'Georgia',
										'times'=>'Times New Roman',
										'tahoma'=>'Tahoma, Geneva',
										'palatino'=>'Palatino',
										'helvetica'=>'Helvetica' );			
						$faces = $ts_all_fonts;
						
						foreach ($faces as $i=>$face) {
							$output .= '<option value="'. esc_attr($i) .'" ' . selected($typography_stored['face'], $i, false) . '>'. $face .'</option>';
						}			
										
						$output .= '</select></div>';
					
					}
					
					/* Font Weight */
					if(isset($typography_stored['style']) && isset($value['std']['style'])) {
					//if(isset($value['std']['style'])) {
                        $typography_stored['style'] = (isset($typography_stored['style'])) ? $typography_stored['style'] : $value['std']['style'];
						$output .= '<div class="select_wrapper typography-style" original-title="Font style">';
						$output .= '<select class="of-typography of-typography-style select" name="'.esc_attr($value['id']).'[style]" id="'. esc_attr($value['id']).'_style">';
						$styles = array('normal'=>'Normal',
										'italic'=>'Italic',
										'bold'=>'Bold',
										'bold italic'=>'Bold Italic');
										
						foreach ($styles as $i=>$style){
						
							$output .= '<option value="'. esc_attr($i) .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
						}
						$output .= '</select></div>';
					
					}
					
					/* Font Color */
					if(isset($typography_stored['color']) && isset($value['std']['color'])) {
					//if(isset($value['std']['color'])) {
                        $typography_stored['color'] = (isset($typography_stored['color'])) ? $typography_stored['color'] : $value['std']['color'];
						$output .= '<div id="' . esc_attr($value['id']) . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="'.esc_attr($value['id']).'[color]" id="'. esc_attr($value['id']) .'_color" type="text" value="'. esc_attr($typography_stored['color']) .'" />';
					
					}
					
				break;
				
				case 'background_positioning':
				
					$bg_pos_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					if(is_array($value['std'])) {
                        foreach($value['std'] AS $key => $val) {
                            $bg_pos_stored[$key] = (isset($bg_pos_stored[$key])) ? $bg_pos_stored[$key] : $val;
                        }
					}
					
					/* Background Repeat */
					
					if(isset($bg_pos_stored['repeat'])) {
						$output .= '<div class="select_wrapper typography-style" original-title="Background Repeat">';
						$output .= '<select class="of-typography of-typography-style select" name="'.esc_attr($value['id']).'[repeat]" id="'. esc_attr($value['id']).'_repeat">';
						foreach($value['options']['repeat'] AS $option) {
                            $output .= '<option value="'.esc_attr($option).'" ' . selected($bg_pos_stored['repeat'], $option, false) . '>'. $option .'</option>';
						}
				
						$output .= '</select></div>';
					
					}
					
					/* Background Position */
					
					if(isset($bg_pos_stored['position'])) {
						$output .= '<div class="select_wrapper typography-style" original-title="Background Position">';
						$output .= '<select class="of-typography of-typography-style select" name="'.esc_attr($value['id']).'[position]" id="'. esc_attr($value['id']).'_position">';
						foreach($value['options']['position'] AS $option) {
                            $output .= '<option value="'.esc_attr($option).'" ' . selected($bg_pos_stored['position'], $option, false) . '>'. $option .'</option>';
						}
				
						$output .= '</select></div>';
					
					}
					
					/* Background Attachment */
					
					if(isset($bg_pos_stored['attachment'])) {
						$output .= '<div class="select_wrapper typography-style" original-title="Background Attachment">';
						$output .= '<select class="of-typography of-typography-style select" name="'.esc_attr($value['id']).'[attachment]" id="'. esc_attr($value['id']).'_attachment">';
                        foreach($value['options']['attachment'] AS $option) {
                            $output .= '<option value="'.esc_attr($option).'" ' . selected($bg_pos_stored['attachment'], $option, false) . '>'. $option .'</option>';
						}
						$output .= '</select></div>';
					
					}
					
				break;
				
				
				case 'css_shadow':
				
					$shadow_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					if(is_array($value['std'])) {
                        foreach($value['std'] AS $key => $val) {
                            $shadow_stored[$key] = (isset($shadow_stored[$key])) ? $shadow_stored[$key] : $val;
                        }
					}
					
					/* X-Offset */
					
					if(isset($shadow_stored['xoffset'])) {
						$output .= '<div class="select_wrapper shadow-unit" original-title="X-Offset">';
						$output .= '<select class="of-typography of-shadow-unit select" name="'.esc_attr($value['id']).'[xoffset]" id="'. esc_attr($value['id']).'_xoffset">';
						$min = (isset($value['options']['min'])) ? $value['options']['min'] : '-10';
						$max = (isset($value['options']['max'])) ? $value['options']['max'] : '10';
						for($i = $min; $i <= $max; $i++) {
                            $test = $i.'px';
                            $output .= '<option value="'. intval($i) .'px" ' . selected($shadow_stored['xoffset'], $test, false) . '>'. intval($i) .'px</option>';
						}
				
						$output .= '</select></div>';
					
					}
					
					/* Y-Offset */
					
					if(isset($shadow_stored['yoffset'])) {
						$output .= '<div class="select_wrapper shadow-unit" original-title="Y-Offset">';
						$output .= '<select class="of-typography of-shadow-unit select" name="'.esc_attr($value['id']).'[yoffset]" id="'. esc_attr($value['id']).'_yoffset">';
						$min = (isset($value['options']['min'])) ? $value['options']['min'] : '-10';
						$max = (isset($value['options']['max'])) ? $value['options']['max'] : '10';
						for($i = $min; $i <= $max; $i++) {
                            $test = $i.'px';
                            $output .= '<option value="'. intval($i) .'px" ' . selected($shadow_stored['yoffset'], $test, false) . '>'. intval($i) .'px</option>';
						}
				
						$output .= '</select></div>';
					
					}
					
					/* Blur */
					
					if(isset($shadow_stored['blur'])) {
						$output .= '<div class="select_wrapper shadow-unit" original-title="Blur">';
						$output .= '<select class="of-typography of-shadow-unit select" name="'.esc_attr($value['id']).'[blur]" id="'. esc_attr($value['id']).'_blur">';
						$min = (isset($value['options']['min'])) ? $value['options']['min'] : '-10';
						$max = (isset($value['options']['max'])) ? $value['options']['max'] : '10';
						for($i = $min; $i <= $max; $i++) {
                            $test = $i.'px';
                            $output .= '<option value="'. intval($i) .'px" ' . selected($shadow_stored['blur'], $test, false) . '>'. intval($i) .'px</option>';
						}
				
						$output .= '</select></div>';
					
					}
					
					/* Shadow Color */
					
					if(isset($shadow_stored['color'])) {
					
						$output .= '<div id="' . esc_attr($value['id']) . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.esc_attr($shadow_stored['color']).'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Shadow Color" name="'.esc_attr($value['id']).'[color]" id="'. esc_attr($value['id']) .'_color" type="text" value="'. esc_attr($shadow_stored['color']) .'" style="float:left" />';
					
					}
					
					/* Shadow Opacity */
					
					if(isset($shadow_stored['opacity'])) {
                        $s_val = $s_min = $s_max = $s_step = $s_edit = '';//no errors, please
					
                        $s_val = isset($shadow_stored['opacity']) ? stripslashes($shadow_stored['opacity']) : 100;
					
						//values
                        $s_data = 'data-id="'.esc_attr($value['id']).'_opacity" data-val="'.esc_attr($s_val).'" data-min="1" data-max="100" data-step="1"';
                        
                        //html output
                        $output .= '<div style="clear:left;margin-top:10px"><input type="text" name="'.esc_attr($value['id']).'[opacity]" id="'.esc_attr($value['id']).'_opacity" value="'. esc_attr($s_val) .'" class="mini" />';
                        $output .= '<div id="'.esc_attr($value['id']).'-opacity-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div></div>';
					
					}
					
				break;
				
				//border option
				case 'border':
						
					/* Border Width */
					$border_stored = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : $value['std'];
					
					if(is_array($value['std'])) {
                        foreach($value['std'] AS $key => $val) {
                            $border_stored[$key] = (isset($border_stored[$key])) ? $border_stored[$key] : $val;
                        }
					}
					
					$output .= '<div class="select_wrapper border-width">';
					$output .= '<select class="of-border of-border-width select" name="'.esc_attr($value['id']).'[width]" id="'. esc_attr($value['id']).'_width">';
                    for ($i = 0; $i < 21; $i++) { 
						$output .= '<option value="'. intval($i) .'" ' . selected($border_stored['width'], $i, false) . '>'. intval($i) .'</option>';				     }
					$output .= '</select></div>';
					
					/* Border Style */
					$output .= '<div class="select_wrapper border-style">';
					$output .= '<select class="of-border of-border-style select" name="'.esc_attr($value['id']).'[style]" id="'. esc_attr($value['id']).'_style">';
					
					$styles = array('none'=>'None',
									'solid'=>'Solid',
									'dashed'=>'Dashed',
									'dotted'=>'Dotted');
									
					foreach ($styles as $i=>$style){
						$output .= '<option value="'. esc_attr($i) .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
					}
					
					$output .= '</select></div>';
					
					/* Border Color */		
					$output .= '<div id="' . esc_attr($value['id']) . '_color_picker" class="colorSelector"><div style="background-color: '.esc_attr($border_stored['color']).'"></div></div>';
					$output .= '<input class="of-color of-border of-border-color" name="'.esc_attr($value['id']).'[color]" id="'. esc_attr($value['id']) .'_color" type="text" value="'. esc_attr($border_stored['color']) .'" />';
					
				break;
				
				//images checkbox - use image as checkboxes
				case 'images':
				
					$i = 0;
					
					$select_value = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : $value['std'];
					
					foreach ($value['options'] as $key => $option) 
					{ 
                        $i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $key, false)) {
							$checked = checked($select_value, $key, false);
							$selected = 'of-radio-img-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . esc_attr($value['id'] . $i) . '" class="checkbox of-radio-img-radio" value="'.esc_attr($key).'" name="'.esc_attr($value['id']).'" '.$checked.' />';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.esc_url($option).'" alt="" id="of-radio-img-' . esc_attr($value['id']) .'-button" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. esc_js($value['id'] . $i).'\').checked = true;" />';
						$output .= '</span>';				
					}
					
				break;
				
				//info (for small intro box etc)
				case "info":
					$info_text = $value['std'];
					$output .= '<div class="of-info">'.$info_text.'</div>';
				break;
				
				//display a single image
				case "image":
					$src = $value['std'];
					$output .= '<img src="'.esc_url($src).'">';
				break;
				
				//tab heading
				case 'heading':
					if($counter >= 2){
					   $output .= '</div>'."\n";
					}
					$caption = (isset($value['caption'])) ? trim($value['caption']) : '';
					$caption = ($caption) ? '<span class="caption">'.$caption.'</span>' : '';
					$class = str_replace(' ','',strtolower($value['name']));
					$header_class = (isset($value['class'])) ? $value['class'].' '.$class : $class;
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "of-option-" . $jquery_click_hook;
					//$menu .= '<li class="'. esc_attr($header_class) .'"><a title="'. esc_attr($value['name']) .'" href="#'. $jquery_click_hook .'">'. $value['name'] .$caption .'</a></li>';
					$output .= '<div class="group" id="'. esc_attr($jquery_click_hook)  .'"><h2>'.$value['name'].'</h2>'."\n";
				break;
				
				//drag & drop slide manager
				case 'slider':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					$output .= '<div class="slider"><ul id="'.esc_attr($value['id']).'" rel="'.esc_attr($int).'">';
					$slides = $smof_data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button">'.__('Add New Slide','ThemeStockyard').'</a></div>';
					
				break;
				
				//drag & drop block manager
				case 'sorter':
				
					$sortlists = isset($smof_data[$value['id']]) && !empty($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					$output .= '<div id="'.esc_attr($value['id']).'" class="sorter">';
					
					
					if ($sortlists) {
					
						foreach ($sortlists as $group=>$sortlist) {
						
							$output .= '<ul id="'.esc_attr($value['id'].'_'.$group).'" class="sortlist_'.esc_attr($value['id']).'">';
							$output .= '<h3>'.$group.'</h3>';
							
							foreach ($sortlist as $key => $list) {
							
								$output .= '<input class="sorter-placebo" type="hidden" name="'.esc_attr($value['id'].'['.$group.'][placebo]').'" value="placebo">';
									
								if ($key != "placebo") {
								
									$output .= '<li id="'.esc_attr($key).'" class="sortee">';
									$output .= '<input class="position" type="hidden" name="'.esc_attr($value['id'].'['.$group.']['.$key.']').'" value="'.esc_attr($list).'">';
									$output .= $list;
									$output .= '</li>';
									
								}
								
							}
							
							$output .= '</ul>';
						}
					}
					
					$output .= '</div>';
				break;
				
				//background images option
				case 'tiles':
					
					$i = 0;
					$select_value = isset($smof_data[$value['id']]) && !empty($smof_data[$value['id']]) ? $smof_data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $option, false)) {
							$checked = checked($select_value, $option, false);
							$selected = 'of-radio-tile-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-tile-' . esc_attr($value['id'] . $i) . '" class="checkbox of-radio-tile-radio" value="'.esc_attr($option).'" name="'.esc_attr($value['id']).'" '.$checked.' />';
						$output .= '<div class="of-radio-tile-img '. esc_attr($selected) .'" style="background: url('.esc_url($option).')" onClick="document.getElementById(\'of-radio-tile-'. esc_js($value['id'] . $i).'\').checked = true;"></div>';
						$output .= '</span>';				
					}
					
				break;
				
				//backup and restore options data
				case 'backup':
				
					$instructions = $value['desc'];
					$backup = get_option(BACKUPS);
					
					if(!isset($backup['backup_log'])) {
						$log = 'No backups yet';
					} else {
						$log = $backup['backup_log'];
					}
					
					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">'.$instructions."\n";
					$output .= '<p><strong>'. __('Last Backup : ', 'ThemeStockyard').'<span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
					$output .= '<a href="#" id="of_backup_button" class="button" title="'.__('Backup Options','ThemeStockyard').'">'.__('Backup Options','ThemeStockyard').'</a>';
					$output .= '<a href="#" id="of_restore_button" class="button" title="'.__('Restore Options','ThemeStockyard').'">'.__('Restore Options','ThemeStockyard').'</a>';
					$output .= '</div>';
				
				break;
				
				//export or import data between different installs
				case 'transfer':
				
					$instructions = $value['desc'];
					$output .= '<textarea id="export_data" rows="8">'.base64_encode(serialize($smof_data)) /* 100% safe - ignore theme check nag */ .'</textarea>'."\n";
					$output .= '<a href="#" id="of_import_button" class="button" title="'.__('Import Options','ThemeStockyard').'">'.__('Import Options','ThemeStockyard').'</a>';
				
				break;
				
				// google font field
				case 'select_google_font':
					$output .= '<div class="select_wrapper">';
					$output .= '<select class="select of-input google_font_select" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'">';
					$selected_option = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : ((isset($value['std'])) ? $value['std'] : "");
					/*foreach ($value['options'] as $select_key => $option) {
						$output .= '<option value="'.$select_key.'" ' . selected($selected_option, $option, false) . ' />'.$option.'</option>';
					} */
					foreach ($value['options'] as $option) {
						$output .= '<option value="'.esc_attr($option).'" ' . selected($selected_option, $option, false) . ' />'.$option.'</option>';
					} 
					$output .= '</select></div>';
					
					if(isset($value['preview']['text'])){
						$g_text = $value['preview']['text'];
					} else {
						$g_text = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';
					}
					if(isset($value['preview']['size'])) {
						$g_size = 'style="font-size: '. esc_attr($value['preview']['size']) .';"';
					} else { 
						$g_size = '';
					}
					
					$output .= '<p class="'.esc_attr($value['id']).'_ggf_previewer google_font_preview" '. $g_size .'>'. $g_text .'</p>';
				break;
				
				//JQuery UI Slider
				case 'sliderui':
					$s_val = $s_min = $s_max = $s_step = $s_edit = '';//no errors, please
					
					// new-edit
					//$s_val  = stripslashes($smof_data[$value['id']]);
					$s_val = isset($smof_data[$value['id']]) ? stripslashes($smof_data[$value['id']]) : $value['std'];
					
					if(!isset($value['min'])){ $s_min  = '0'; }else{ $s_min = $value['min']; }
					if(!isset($value['max'])){ $s_max  = $s_min + 1; }else{ $s_max = $value['max']; }
					if(!isset($value['step'])){ $s_step  = '1'; }else{ $s_step = $value['step']; }
					
					if(!isset($value['edit'])){ 
						$s_edit  = ' readonly="readonly"'; 
					}
					else
					{
						$s_edit  = '';
					}
					
					if ($s_val == '') $s_val = $s_min;
					
					//values
					$s_data = 'data-id="'.esc_attr($value['id']).'" data-val="'.esc_attr($s_val).'" data-min="'.esc_attr($s_min).'" data-max="'.esc_attr($s_max).'" data-step="'.esc_attr($s_step).'"';
					
					//html output
					$output .= '<input type="text" name="'.esc_attr($value['id']).'" id="'.esc_attr($value['id']).'" value="'. esc_attr($s_val) .'" class="mini" '. $s_edit .' />';
					$output .= '<div id="'.esc_attr($value['id']).'-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div>';
					
				break;
				
				
				//Switch option
				case 'switch':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = (isset($value['std'])) ? $value['std'] : 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="s_fld ";
					
					$cb_enabled = $cb_disabled = '';//no errors, please
					
					//Get selected
					//if ($smof_data[$value['id']] == 1){
					if ($smof_data[$value['id']]){
						$cb_enabled = ' selected';
						$cb_disabled = '';
					}else{
						$cb_enabled = '';
						$cb_disabled = ' selected';
					}
					
					//Label ON
					if(!isset($value['on'])){
						$on = "On";
					}else{
						$on = $value['on'];
					}
					
					//Label OFF
					if(!isset($value['off'])){
						$off = "Off";
					}else{
						$off = $value['off'];
					}
					
					$output .= '<p class="switch-options">';
						$output .= '<label class="'.esc_attr($fold).'cb-enable'. esc_attr($cb_enabled) .'" data-id="'.esc_attr($value['id']).'"><span>'. $on .'</span></label>';
						$output .= '<label class="'.esc_attr($fold).'cb-disable'. esc_attr($cb_disabled) .'" data-id="'.esc_attr($value['id']).'"><span>'. $off .'</span></label>';
						
						$output .= '<input type="hidden" class="'.esc_attr($fold).'checkbox of-input" name="'.esc_attr($value['id']).'" id="'. esc_attr($value['id']) .'" value="0"/>';
						$output .= '<input type="checkbox" id="'.esc_attr($value['id']).'" class="'.esc_attr($fold).'checkbox of-input main_checkbox" name="'.esc_attr($value['id']).'"  value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
						
					$output .= '</p>';
					
				break;
				
			}
			
			//description of each option
			if ( $value['type'] != 'heading') { 
				if(!isset($value['desc'])){ $explain_value = ''; } else{ 
					$explain_value = '<div class="explain">'. $value['desc'] .'</div>'."\n"; 
				} 
				$output .= '</div>'.$explain_value."\n";
				$output .= '<div class="clear"> </div></div></div>'."\n";
            }
            
            echo $output; // new
		   
		}
		
		$output = ''; // new
	    $output .= '</div>';
	    
	    echo $output;
	    
	}


	/**
	 * Ajax image uploader - supports various types of image types
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_uploader_function($id,$std,$mod){

	    $smof_data = of_get_options();
		
		$uploader = '';
	    $upload = $val = (isset($smof_data[$id])) ? $smof_data[$id] : $std;
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    //if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.esc_attr($hide).' upload of-input" name="'. esc_attr($id) .'" id="'. esc_attr($id) .'_upload" value="'. esc_attr($val) .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">'.__('Upload','ThemeStockyard').'</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button image_reset_button '. esc_attr($hide).'" id="reset_'. esc_attr($id) .'" title="' . esc_attr($id) . '">'.__('Remove','ThemeStockyard').'</span>';
		$uploader .='</div>' . "\n";
	    $uploader .= '<div class="clear"></div>' . "\n";
		if(!empty($upload)){
			$uploader .= '<div class="screenshot">';
	    	$uploader .= '<a class="of-uploaded-image" href="'. esc_url($upload) . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.esc_attr($id).'" src="'.esc_url($upload).'" alt="" />';
	    	$uploader .= '</a>';
			$uploader .= '</div>';
			}
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
	
	}

	/**
	 * Native media library uploader
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_media_uploader_function($id,$std,$int,$mod){

	    $smof_data = of_get_options();
		
		$uploader = '';
	    $upload = $val = (isset($smof_data[$id])) ? $smof_data[$id] : $std;
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    //if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.esc_attr($hide).' upload of-input" name="'. esc_attr($id) .'" id="'. esc_attr($id) .'_upload" value="'. esc_attr($val) .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.esc_attr($id).'" rel="' . esc_attr($int) . '">'.__('Upload','ThemeStockyard').'</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button mlu_remove_button '. esc_attr($hide).'" id="reset_'. esc_attr($id) .'" title="' . esc_attr($id) . '">'.__('Remove','ThemeStockyard').'</span>';
		$uploader .='</div>' . "\n";
		$uploader .= '<div class="screenshot">';
		if(!empty($upload)){	
	    	$uploader .= '<a class="of-uploaded-image" href="'. esc_url($upload) . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.esc_attr($id).'" src="'.esc_url($upload).'" alt="" />';
	    	$uploader .= '</a>';			
			}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
		
	}

	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_slider_function($id,$std,$oldorder,$order,$int){
		
	    $smof_data = of_get_options();
		
		$slider = '';
		$slide = array();
	    $slide = $smof_data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','url','link','description');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		//begin slider interface	
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes($val['title']).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>Slide '.$order.'</strong>';
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. esc_attr($id.'['.$order.'][order]').'" id="'. esc_attr($id.'_'.$order) .'_slide_order" value="'.esc_attr($order).'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">'.__('Edit','ThemeStockyard').'</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		$slider .= '<label>'.__('Title','ThemeStockyard').'</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. esc_attr($id.'['.$order.'][title]').'" id="'. esc_attr($id.'_'.$order) .'_slide_title" value="'. esc_attr(stripslashes($val['title'])) .'" />';
		
		$slider .= '<label>'.__('Image URL','ThemeStockyard').'</label>';
		$slider .= '<input class="slide of-input" name="'. esc_attr($id.'['.$order.'][url]').'" id="'. esc_attr($id.'_'.$order) .'_slide_url" value="'. esc_attr($val['url']) .'" />';
		
		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.esc_attr($id.'_'.$order) .'" rel="' . esc_attr($int) . '">'.__('Upload','ThemeStockyard').'</span>';
		
		if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
		$slider .= '<span class="button mlu_remove_button '. esc_attr($hide).'" id="reset_'. esc_attr($id.'_'.$order) .'" title="' . esc_attr($id.'_'.$order) .'">'.__('Remove','ThemeStockyard').'</span>';
		$slider .='</div>' . "\n";
		$slider .= '<div class="screenshot">';
		if(!empty($val['url'])){
			
	    	$slider .= '<a class="of-uploaded-image" href="'. esc_url($val['url']) . '">';
	    	$slider .= '<img class="of-option-image" id="image_'.esc_attr($id.'_'.$order) .'" src="'.esc_url($val['url']).'" alt="" />';
	    	$slider .= '</a>';
			
			}
		$slider .= '</div>';	
		$slider .= '<label>'.__('Link URL (optional)','ThemeStockyard').'</label>';
		$slider .= '<input class="slide of-input" name="'. esc_attr($id.'['.$order.'][link]').'" id="'. esc_attr($id .'_'.$order) .'_slide_link" value="'. esc_attr($val['link']) .'" />';
		
		$slider .= '<label>'.__('Description (optional)','ThemeStockyard').'</label>';
		$slider .= '<textarea class="slide of-input" name="'. esc_attr($id .'['.$order.'][description]').'" id="'. esc_attr($id .'_'.$order) .'_slide_description" cols="8" rows="8">'.stripslashes($val['description']).'</textarea>';
	
		$slider .= '<a class="slide_delete_button" href="#">'.__('Delete','ThemeStockyard').'</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
}//end Options Machine class