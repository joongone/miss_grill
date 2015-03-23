<?php
/*
Plugin Name: Sidebar Generator
Plugin URI: http://www.getson.info
Description: This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish. Version 1.1 now supports themes with multiple sidebars. 
Version: 1.1.0
Author: Kyle Getson
Author URI: http://www.kylegetson.com
Copyright (C) 2009 Kyle Robert Getson
*/

/*
Copyright (C) 2009 Kyle Robert Getson, kylegetson.com and getson.info

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class sidebar_generator {
	
	function sidebar_generator(){
		add_action('init',array('sidebar_generator','init'));
		add_action('admin_menu',array('sidebar_generator','admin_menu'));
		add_action('admin_print_scripts', array('sidebar_generator','admin_print_scripts'));
		add_action('wp_ajax_add_sidebar', array('sidebar_generator','add_sidebar') );
		add_action('wp_ajax_remove_sidebar', array('sidebar_generator','remove_sidebar') );
			
		//edit posts/pages
		//add_action('edit_form_advanced', array('sidebar_generator', 'edit_form'));
		//add_action('edit_page_form', array('sidebar_generator', 'edit_form'));
		add_action( 'admin_menu', array( 'sidebar_generator', 'add_edit_form' ) );
		
		//save posts/pages
		add_action('edit_post', array('sidebar_generator', 'save_form'));
		add_action('publish_post', array('sidebar_generator', 'save_form'));
		add_action('save_post', array('sidebar_generator', 'save_form'));
		add_action('edit_page_form', array('sidebar_generator', 'save_form'));
        
	}
	
	public static function init(){
		//go through each sidebar and register it
	    $sidebars = sidebar_generator::get_sidebars();
	    

	    if(is_array($sidebars)){
			foreach($sidebars as $sidebar){
				$sidebar_class = sidebar_generator::name_to_class($sidebar);
				register_sidebar(array(
					'name'=>$sidebar,
					'id' => 'sc-custom-sidebar-'.strtolower($sidebar_class),
					'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
					'after_widget' => '</div>',
					'before_title' => '<div class="page-title clearfix"><h5>',
					'after_title' => '</h5></div>',
		    	));
			}
		}
	}
	
	public static function admin_print_scripts(){
		//wp_print_scripts( array( 'sack' ));
		?>
			<script>
				function add_sidebar( sidebar_name )
				{
				  	
				  	jQuery.ajax({
                        data: {'action':'add_sidebar', 'sidebar_name':sidebar_name},
                        url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                        type: "POST",
                        error: function() { alert('Ajax error. Cannot add sidebar' )},
                        success: function(data) { 
                            jQuery('#sbg-no-sidebars-yo').remove(); 
                            jQuery('#ts-multiple-sidebars-response').html(data); 
                        }
				  	});
				  	
					return true;
				}
				
				function remove_sidebar( sidebar_name,id )
				{
					
					jQuery.ajax({
                        data: {'action':'remove_sidebar', 'sidebar_name':sidebar_name, 'row_number':id},
                        url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                        type: "POST",
                        error: function() { alert('Ajax error. Cannot remove sidebar' )},
                        success: function(data) { jQuery('#ts-multiple-sidebars-response').html(data); }
				  	});
				  	
					return true;
				}
			</script>
		<?php
	}
	
	public static function add_sidebar(){
		$sidebars = sidebar_generator::get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = sidebar_generator::name_to_class($name);
		if(isset($sidebars[$id])){
			echo "<script type=\"text/javascript\">alert('Sidebar already exists, please use a different name.')</script>";
			exit;
		}
		
		$sidebars[$id] = $name;
		sidebar_generator::update_sidebars($sidebars);
		
		$js = '<script type="text/javascript">jQuery(\'#sbg_table\').append(\'<tr id="sbg-row-'.esc_js($id).'"><td>'.esc_js($name).'</td><td>'.esc_js($id).'</td><td><a href="javascript:void(0)" onclick="remove_sidebar_link(\\\''.esc_js($name).'\\\',\\\''.esc_js($id).'\\\')">remove</a></td></tr>\')</script>';		
		
		echo $js;
		exit;
	}
	
	public static function remove_sidebar(){
		$sidebars = sidebar_generator::get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = sidebar_generator::name_to_class($name);
		if(!isset($sidebars[$id])){
			echo "<script type=\"text/javascript\">alert('Sidebar does not exist.')</script>";
			exit;
		}
		$row_number = $_POST['row_number'];
		unset($sidebars[$id]);
		sidebar_generator::update_sidebars($sidebars);
		$js = "<script type=\"text/javascript\">
			jQuery('#sbg_table #sbg-row-".esc_js($id)."').remove();
            </script>
		";
		echo $js;
		exit;
	}
	
	public static function admin_menu(){
		add_theme_page(__('Sidebar Manager', 'ThemeStockyard'), __('Sidebar Manager', 'ThemeStockyard'), 'manage_options', 'multiple_sidebars', array('sidebar_generator','admin_page'));
		
    }
	
	public static function admin_page(){
		?>
		<script>
			function remove_sidebar_link(name,id){
				answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
				if(answer){
					remove_sidebar(name,id);
				}else{
					return false;
				}
			}
			function add_sidebar_link(){
				var sidebar_name = prompt("<?php _e('Sidebar Name:', 'ThemeStockyard');?>","");
				if(jQuery.trim(sidebar_name)) {
                    add_sidebar(sidebar_name);
				} else {
                    return false
				}
			}
		</script>
		<div class="wrap">
			<h2><?php _e('Sidebar Manager', 'ThemeStockyard');?></h2>
			<div id="ts-multiple-sidebars-response" style="display:none"></div>
			<br />
			<table class="widefat page" id="sbg_table" style="width:600px;">
				<tr>
					<th><?php _e('Sidebar Name', 'ThemeStockyard');?></th>
					<th><?php _e('CSS class', 'ThemeStockyard');?></th>
					<th><?php _e('Remove', 'ThemeStockyard');?></th>
				</tr>
				<?php
				$sidebars = sidebar_generator::get_sidebars();
				//$sidebars = array('bob','john','mike','asdf');
				if(is_array($sidebars) && !empty($sidebars)){
					$cnt=0;
					foreach($sidebars as $sidebar){
						$alt = ($cnt%2 == 0 ? 'alternate' : '');
						$id = sidebar_generator::name_to_class($sidebar);
				?>
				<tr class="<?php echo $alt?>" id="sbg-row-<?php echo $id;?>">
					<td><?php echo $sidebar; ?></td>
					<td><?php echo $id ?></td>
					<td><a href="javascript:void(0);" onclick="return remove_sidebar_link('<?php echo $sidebar; ?>','<?php echo $id; ?>');" title="Remove this sidebar"><?php _e('remove', 'ThemeStockyard');?></a></td>
				</tr>
				<?php
						$cnt++;
					}
				}else{
					?>
					<tr id="sbg-no-sidebars-yo">
						<td colspan="3"><?php _e('No Sidebars defined', 'ThemeStockyard');?></td>
					</tr>
					<?php
				}
				?>
			</table><br /><br />
            <div class="add_sidebar">
				<a href="javascript:void(0);" onclick="return add_sidebar_link()" title="Add a sidebar" class="button-primary"><?php _e('+ Add New Sidebar', 'ThemeStockyard');?></a>

			</div>
			
		</div>
		<?php
	}
	
	/**
	 * for saving the pages/post
	*/
	public static function save_form($post_id){
		if(isset($_POST['sbg_edit'])){
		$is_saving = $_POST['sbg_edit'];
		if(!empty($is_saving)){
			delete_post_meta($post_id, '_sbg_selected_sidebar');
			delete_post_meta($post_id, '_sbg_selected_sidebar_replacement');
			add_post_meta($post_id, '_sbg_selected_sidebar', $_POST['sidebar_generator']);
			add_post_meta($post_id, '_sbg_selected_sidebar_replacement', $_POST['sidebar_generator_replacement']);
		}
		}
	}
	
	public static function add_edit_form() {
        add_meta_box('_p_sidebar_select', __('Sidebar', 'ThemeStockyard'), array('sidebar_generator', 'edit_form'),'post','side','default');
        add_meta_box('_page_sidebar_select', __('Sidebar', 'ThemeStockyard'), array('sidebar_generator', 'edit_form'),'page','side','default');
	}
	
	public static function edit_form(){
	    global $post;
	    $post_id = $post;
	    if (is_object($post_id)) {
	    	$post_id = $post_id->ID;
	    }
	    $selected_sidebar = get_post_meta($post_id, '_sbg_selected_sidebar', true);
	    if(!is_array($selected_sidebar)){
	    	$tmp = $selected_sidebar; 
	    	$selected_sidebar = array(); 
	    	$selected_sidebar[0] = $tmp;
	    }
	    $selected_sidebar_replacement = get_post_meta($post_id, '_sbg_selected_sidebar_replacement', true);
		if(!is_array($selected_sidebar_replacement)){
	    	$tmp = $selected_sidebar_replacement; 
	    	$selected_sidebar_replacement = array(); 
	    	$selected_sidebar_replacement[0] = $tmp;
	    }
		?>
	 
	<!--<div id='sbg-sortables' class='meta-box-sortables'>
		<div id="sbg_box" class="postbox " >
			<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e('Sidebar', 'ThemeStockyard');?></span></h3>
			<div class="inside">-->
				<div class="sbg_container">
					<input name="sbg_edit" type="hidden" value="sbg_edit" />
					<ul>
					<?php 
					global $wp_registered_sidebars;		
						for($i=0;$i<1;$i++){ ?>
							<li>
							<select name="sidebar_generator[<?php echo $i?>]" style="display: none;">
								<option value="0"<?php if($selected_sidebar[$i] == ''){ echo " selected";} ?>><?php _e('WP Default Sidebar', 'ThemeStockyard');?></option>
							<?php
							$sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
							if(is_array($sidebars) && !empty($sidebars)){
								foreach($sidebars as $sidebar){
									if($selected_sidebar[$i] == $sidebar['name']){
										echo '<option value="'.esc_attr($sidebar['name']).'" selected>'.$sidebar['name'].'</option>'."\n";
									}else{
										echo '<option value="'.esc_attr($sidebar['name']).'">'.$sidebar['name'].'</option>'."\n";
									}
								}
							}
							?>
							</select>
							<select name="sidebar_generator_replacement[<?php echo $i?>]">
								<!--<option value="0"<?php if($selected_sidebar_replacement[$i] == ''){ echo " selected";} ?>><?php _e('None', 'ThemeStockyard');?></option>-->
							<?php
							
							$sidebar_replacements = $wp_registered_sidebars;//sidebar_generator::get_sidebars();
							if(is_array($sidebar_replacements) && !empty($sidebar_replacements)){
								foreach($sidebar_replacements as $sidebar){
									if($selected_sidebar_replacement[$i] == $sidebar['name']){
										echo '<option value="'.$sidebar['name'].'" selected>'.$sidebar['name'].'</option>'."\n";
									}else{
										echo '<option value="'.$sidebar['name'].'">'.$sidebar['name'].'</option>'."\n";
									}
								}
							}
							?>
							</select> 
							
							</li>
						<?php } ?>
					</ul>
					<p><?php _e('Select the sidebar you would like to display on this post/page. <strong>Note:</strong> To create or remove sidebars, go to the <a href="themes.php?page=multiple_sidebars">Sidebar Manager</a>', 'ThemeStockyard');?>
					</p>
				</div>
			<!--</div>
		</div>
	</div>-->

		<?php
	}
	
	/**
	 * called by the action get_sidebar. this is what places this into the theme
	*/
	public static function get_sidebar($name="0"){
		if(!is_singular()){
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar('ts-primary-sidebar');
			}
			return;//dont do anything
		}
		wp_reset_query();
		global $wp_query;
		$post = $wp_query->get_queried_object();
		$selected_sidebar = get_post_meta($post->ID, '_sbg_selected_sidebar', true);
		$selected_sidebar_replacement = get_post_meta($post->ID, '_sbg_selected_sidebar_replacement', true);
		$did_sidebar = false;
		//this page uses a generated sidebar
		if($selected_sidebar != '' && $selected_sidebar != "0"){
			if(is_array($selected_sidebar) && !empty($selected_sidebar)){
				for($i=0;$i<sizeof($selected_sidebar);$i++){					
					
					if($name == "0" && $selected_sidebar[$i] == "0" &&  $selected_sidebar_replacement[$i] == "0"){
						dynamic_sidebar('ts-primary-sidebar');//default behavior
						$did_sidebar = true;
						break;
					}elseif($name == "0" && $selected_sidebar[$i] == "0"){
						//we are replacing the default sidebar with something
						dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
						$did_sidebar = true;
						break;
					}elseif($selected_sidebar[$i] == $name){
						//we are replacing this $name
						$did_sidebar = true;
						dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
						break;
					}
				}
			}
			if($did_sidebar == true){
				echo "";
				return;
			}
			//go through without finding any replacements, lets just send them what they asked for
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar('ts-primary-sidebar');
			}
			echo "";
			return;			
		}else{
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar('ts-primary-sidebar');
			}
		}
	}
	
	/**
	 * replaces array of sidebar names
	*/
	public static function update_sidebars($sidebar_array){
		$sidebars = update_option('sbg_sidebars',$sidebar_array);
	}	
	
	/**
	 * gets the generated sidebars
	*/
	public static function get_sidebars(){
		$sidebars = get_option('sbg_sidebars');
		return $sidebars;
	}
	public static function name_to_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}
	
}
$sbg = new sidebar_generator;

/*
 * This function is now called in /[theme]/includes/theme-functions.php
 */
/*
function generated_dynamic_sidebar($name='0'){
	sidebar_generator::get_sidebar($name);
	return true;
}
*/