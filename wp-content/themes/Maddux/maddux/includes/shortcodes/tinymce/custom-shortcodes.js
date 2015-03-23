(function() {	
	tinymce.create('tinymce.plugins.tsShortcodes', {
		init : function(ed, url){
			tinymce.plugins.tsShortcodes.theurl = url;
			
			ed.addCommand("tsPopup", function ( a, params )
			{
				var popup = params.identifier;
				var preset = (typeof params.preset != 'undefined') ? params.preset : '';
				var preset_value = (typeof params.preset_value != 'undefined') ? params.preset_value : '';
				
				var popup_url = ajaxurl + "?action=ts_shortcodes_popup&popup=" + popup + "&preset="+preset+"&preset_value="+preset_value+"&width=" + 800;
				
				// load thickbox
				tb_show("ThemeStockyard Shortcodes", popup_url);
			});
		},
		createControl : function(btn, e) {
			if ( btn == "ts_button" ) {
				var a = this;	
				
                var btn = e.createSplitButton('ts_button', {
                    title: "Insert Shortcode",
                    image: tinymce.plugins.tsShortcodes.theurl +"/images/shortcodes.png",
                    icons: false,
                });
                
                btn.onRenderMenu.add(function (c, b) {
                    
                    b.add({title : 'Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    
                    
                    // Blog & Portfolio
                    c = b.addMenu({title:"Blog"});
                    
                        a.render( c, "Blog", "blog" );
                        a.render( c, "Blog Slider", "blog_slider" );
                        a.render( c, "Blog Widget", "blog_widget" );
                    
                    //b.addSeparator();
                    
                    
                    // Columns
                    c = b.addMenu({title:"Columns"});
                        
                        if(tsShortcodes.dev == 'false') {
                            a.render( c, "One Half", "columns", "column", "one_half");
                            a.render( c, "One Third", "columns", "column", "one_third" );
                            a.render( c, "One Fourth", "columns", "column", "one_fourth" );
                            a.render( c, "One Fifth", "columns", "column", "one_fifth" );
                            a.render( c, "One Sixth", "columns", "column", "one_sixth" )
                            
                            c.addSeparator();		
                                    
                            a.render( c, "Two Third", "columns", "column", "two_third" );
                            a.render( c, "Three Fourth", "columns", "column", "three_fourth" );
                            a.render( c, "Two Fifth", "columns", "column", "two_fifth" );
                            a.render( c, "Three Fifth", "columns", "column", "three_fifth" );
                            a.render( c, "Fourth Fifth", "columns", "column", "four_fifth" );
                            a.render( c, "Five Sixth", "columns", "column", "five_sixth" );
                        } else {
                            a.render( c, "One Half", "half");
                            a.render( c, "One Third", "third" );
                            a.render( c, "One Fourth", "fourth" );
                            a.render( c, "One Fifth", "fifth" );
                            a.render( c, "One Sixth", "sixth" )
                            
                            c.addSeparator();		
                                    
                            a.render( c, "Two Third", "twothird" );
                            a.render( c, "Three Fourth", "threefourth" );
                            a.render( c, "Two Fifth", "twofifth" );
                            a.render( c, "Three Fifth", "threefifth" );
                            a.render( c, "Fourth Fifth", "fourfifth" );
                            a.render( c, "Five Sixth", "fivesixth" );
                        }
                    
                    //b.addSeparator();
                    
                    
                    // Elements
                    c = b.addMenu({title:"Elements"});
                        
                        a.render( c, "Alert", "alert" );			
                        a.render( c, "Button", "button" );
                        a.render( c, "Callout", "callout" );
                        a.render( c, "Code", "code" );
                        a.render( c, "Google Map", "googlemap" );
                        a.render( c, "Iconboxes", "iconboxes" );
                        a.render( c, "List", "list" );
                        a.render( c, "Pricing Table", "pricingtable" );
                        a.render( c, "Progress Bar", "progressbar" );
                        a.render( c, "Social Links", "social_links" );	
                        //a.render( c, "Testimonial", "testimonial" );
                        a.render( c, "Title", "title" );
                        
                    //b.addSeparator();
                    
                    
                    // Sections
                    c = b.addMenu({title:"Sections"});
                                    
                        a.render( c, "Full Width", "fullwidth" );
                        a.render( c, "Parallax", "fullwidth", "style", "parallax");
                        
                    //b.addSeparator();
                    
                    
                    // Tabs & Toggles
                    c = b.addMenu({title:"Tabs & Toggles"});
                    
                        a.render( c, "Accordion", "accordion" );
                        a.render( c, "Tabs", "tabs" );
                        a.render( c, "Toggles", "toggles" );
                    
                    
                    // Typography
                    c = b.addMenu({title:"Typography"});
                    
                        a.render( c, "Dropcap", "dropcap" );
                        if(tsShortcodes.dev == 'false') {
                            a.render( c, "Highlight", "highlight" );
                        }
                    
                    b.addSeparator();
                    
                    
                    
                    
                    // Animations
                    c = b.addMenu({title:"Animations"});
                    
                        a.render( c, "Fade In", "fadeIn" );
                        if(tsShortcodes.dev == 'true') {
                            a.render( c, "Fade In From Left", "fadeInFromLeft" );
                            a.render( c, "Fade In From Right", "fadeInFromRight" );
                            a.render( c, "Fade In From Above", "fadeInFromAbove" );
                            a.render( c, "Fade In From Below", "fadeInFromBelow" );
                        }
                    
                    //b.addSeparator();
                    
                    
                    // Audio & Video
                    c = b.addMenu({title:"Audio & Video"});
                    
                        a.render( c, "Youtube", "youtube" );
                        a.render( c, "Vimeo", "vimeo" );
                        //a.render( c, "Vine", "vine" );
                        a.render( c, "SoundCloud", "soundcloud" );
                    
                    //b.addSeparator();
                    
                    if(tsShortcodes.dev == 'true') {
                        // Dividers
                        c = b.addMenu({title:"Dividers"});
                        
                            a.render( c, "Invisible", "spacingDivider" );
                            a.render( c, "Single", "singleDivider" );
                            a.render( c, "Dashed", "dashedDivider" );
                            a.render( c, "Double", "doubleDivider" );
                            a.render( c, "Double Dashed", "doubleDashedDivider" );
                            a.render( c, "Circle", "circleDivider" );
                            a.render( c, "Square", "squareDivider" );
                            
                        //b.addSeparator();
                    } else {
                        // Dividers
                        c = b.addMenu({title:"Dividers"});
                        
                            a.render( c, "Invisible", "divider", "style", "invisible" );
                            a.render( c, "Single", "divider", "style", "single" );
                            a.render( c, "Dashed", "divider", "style", "dashed" );
                            a.render( c, "Double", "divider", "style", "double" );
                            a.render( c, "Double Dashed", "divider", "style", "double-dashed" );
                            a.render( c, "Circle", "divider", "style", "circle" );
                            a.render( c, "Square", "divider", "style", "square" );
                            
                        //b.addSeparator();
                    }
                    
                    
                    // Galleries & Slideshows
                    c = b.addMenu({title:"Galleries & Slideshows"});
                    
                        a.render( c, "Lightbox Gallery", "lightbox_gallery" );
                        a.render( c, "Carousel Gallery", "carousel_gallery" );
                        a.render( c, "Slider Gallery", "slider_gallery" );
                    
                    //b.addSeparator();
                    
                    if(tsShortcodes.dev == 'true') {
                        // Highlights
                        c = b.addMenu({title:"Highlighted Text"});
                        
                            a.render( c, "Yellow", "yellowHighlight" );
                            a.render( c, "Dark", "darkHighlight" );
                            a.render( c, "Custom", "customHighlight" );
                            
                        //b.addSeparator();
                    }
                    
                    
                    // Helpers
                    c = b.addMenu({title:"Other"});
                    
                        a.render( c, "Clear Floats", "clear" );
                        a.render( c, "Clip", "clip" );
                        a.render( c, "Email Link", "email" );
                        a.render( c, "FontAwesome Icon", "fontawesome" );
                        
                        if(tsShortcodes.dev == 'true') {
                            a.render( c, "Non-breaking Spaces", "nbsp" );
                        }
                        
                    
                    
                });
                
                return btn;
			}
			return null;               
		},
		render : function(ed, title, id, preset, preset_value) {
			ed.add({
				title: title,
				onclick: function () {
                    if(tsShortcodes.dev == 'false') {
                        var url = ajaxurl + "?action=ts_shortcodes_popup&popup=" + id + "&width=" + 800 + "&preset=" +preset+ "&preset_value="+preset_value; 
                        tb_show("ThemeStockyard Shortcodes", url);
                    }
                    else
                    {
                        // Selected content
                        var mceSelected = tinyMCE.activeEditor.selection.getContent();
                        
                        // Add highlighted content inside the shortcode when possible - yay!
                        if ( mceSelected ) {
                            var dummy_content = mceSelected;
                        } else {
                            var dummy_content = 'Sample Content';
                        }
                        
                        // Accordion
                        if(id == "accordion") {
                            tinyMCE.activeEditor.selection.setContent('[accordion open_icon="" closed_icon=""]<br/>[toggle title="Toggle" open="yes"]...toggle content...[/toggle]<br/>[toggle title="Toggle" open="no"]...toggle content...[/toggle]<br/>[toggle title="Toggle" open="no"]...toggle content...[/toggle]<br/>[/accordion]');
                        }
                        
                        
                        // Alert
                        if(id == "alert") {
                            tinyMCE.activeEditor.selection.setContent('[alert type="e.g. general, error, danger, success, info, notice"]' + dummy_content + '[/alert]');
                        }
                        
                        
                        // Animations
                        if(id == "fadeIn") {
                            tinyMCE.activeEditor.selection.setContent('[animation style="fadein"]<br />' + dummy_content + '<br />[/animation]');
                        }
                        if(id == "fadeInFromLeft") {
                            tinyMCE.activeEditor.selection.setContent('[animation style="fadein" from="left"]<br />' + dummy_content + '<br />[/animation]');
                        }
                        if(id == "fadeInFromRight") {
                            tinyMCE.activeEditor.selection.setContent('[animation style="fadein" from="right"]<br />' + dummy_content + '<br />[/animation]');
                        }
                        if(id == "fadeInFromAbove") {
                            tinyMCE.activeEditor.selection.setContent('[animation style="fadein" from="above"]<br />' + dummy_content + '<br />[/animation]');
                        }
                        if(id == "fadeInFromBelow") {
                            tinyMCE.activeEditor.selection.setContent('[animation style="fadein" from="below"]<br />' + dummy_content + '<br />[/animation]');
                        }
                        
                        
                        
                        // Audio & Video
                        if(id == "vimeo") {
                            tinyMCE.activeEditor.selection.setContent('[vimeo id="https://vimeo.com/65227571" width="600" height="337"]');
                        }
                        if(id == "youtube") {
                            tinyMCE.activeEditor.selection.setContent('[youtube id="http://youtube.com/watch?v=dQw4w9WgXcQ" width="600" height="337"]');
                        }
                        if(id == "soundcloud") {
                            tinyMCE.activeEditor.selection.setContent('[soundcloud url="http://api.soundcloud.com/tracks/89016681" width="100%" height="81px"]');
                        }
                        if(id == "vine") {
                            tinyMCE.activeEditor.selection.setContent('[vine url="https://vine.co/v/hWdqKDuOLM0" autoplay="false" style="simple"]');
                        }	
                        
                        
                        
                        
                        // Blog
                        if(id == "blog") {
                            tinyMCE.activeEditor.selection.setContent('[blog layout="e.g. default, 2column, 3column, cards, grid, medium-image" posts_per_page="10" show_pagination="yes" title_align="" meta_align="" excerpt_align="" read_more_align="" show_sharing_options="yes"]');
                        }
                        
                        
                        
                        
                        // Button
                        if(id == "button") {
                            tinyMCE.activeEditor.selection.setContent('[button color="" url="http://..." target="blank"]' + dummy_content + '[/button]');
                        }
                        
                        
                        
                        
                        // Callout
                        if(id == "callout") {
                            tinyMCE.activeEditor.selection.setContent('[callout link="#" add_shadow="no" link_target="_self" button_text="button text here..." button_color="primary" title="Title text..." description="Description here..." align="left" button_position="right" border_color="" background_color="" title_color="" description_color=""]');
                        }
                        
                        
                        
                        
                        // Clear Floats
                        if(id == "clear") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="clear"]');
                        }
                        
                        
                        
                        // Clip
                        if(id == "clip") {
                            tinyMCE.activeEditor.selection.setContent('[clip height="200" no_unclip="false" show_more_text="show more"]<br />' + dummy_content + '<br />[/clip]');
                        }
                        
                        
                        
                        
                        // Code
                        if(id == "code") {
                            tinyMCE.activeEditor.selection.setContent('[code style="inline or block"]<br />' + dummy_content + '<br />[/code]');
                        }
                        
                        
                        
                        
                        // Columns
                        if(id == "half") {
                            tinyMCE.activeEditor.selection.setContent('[column size="one-half" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "third") {
                            tinyMCE.activeEditor.selection.setContent('[column size="one-third" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "fourth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="one-fourth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "fifth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="one-fifth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "sixth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="one-sixth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        
                        
                        if(id == "twothird") {
                            tinyMCE.activeEditor.selection.setContent('[column size="two-third" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "threefourth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="three-fourth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "twofifth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="two-fifth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "threefifth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="three-fifth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "fourfifth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="four-fifth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }
                        if(id == "fivesixth") {
                            tinyMCE.activeEditor.selection.setContent('[column size="five-sixth" last="no"]<br />' + dummy_content + '<br />[/column]');
                        }	
                        
                                        
                    
                        // Divider
                        
                        if(id == "spacingDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider height="40px"]');
                        }
                        if(id == "singleDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="single" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        if(id == "dashedDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="dashed" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        if(id == "doubleDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="double" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        if(id == "doubleDashedDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="double-dashed" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        if(id == "circleDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="circle" align="left" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        if(id == "squareDivider") {
                            tinyMCE.activeEditor.selection.setContent('[divider style="square" align="left" padding_top="20px" padding_bottom="20px" color=""]');
                        }
                        
                        
                        
                        // Dropcap
                        
                        if(id == "dropcap") {
                            tinyMCE.activeEditor.selection.setContent('[dropcap text_color="" background_color=""]' + dummy_content + '[/dropcap]');
                        }
                        
                        
                        // Email
                        
                        if(id == "email") {
                            tinyMCE.activeEditor.selection.setContent('[email display=""]you@your-address.com[/email]');
                        }
                        
                        
                        // FontAwesome
                        
                        if(id == "fontawesome") {
                            tinyMCE.activeEditor.selection.setContent('[fontawesome icon="" size="14px" color=""]');
                        }
                        
                        
                        
                        // Galleries
                        if(id == "lightbox_gallery") {
                            tinyMCE.activeEditor.selection.setContent('[thumb_gallery]<br />Put a WordPress gallery here<br />[/thumb_gallery]');
                        }
                        if(id == "carousel_gallery") {
                            tinyMCE.activeEditor.selection.setContent('[carousel_gallery height=""]<br />Put a WordPress gallery here<br />[/carousel_gallery]');
                        }
                        if(id == "slider_gallery") {
                            tinyMCE.activeEditor.selection.setContent('[slider_gallery crop="false"]<br />Put a WordPress gallery here<br />[/slider_gallery]');
                        }
                        
                        
                        
                        
                        // Google Map
                        if(id == "googlemap") {
                            tinyMCE.activeEditor.selection.setContent('[map address="1600 Pennsylvania Avenue NW, Washington, DC" zoom="10" height="250" scrollwheel="no" hue=""]');
                        }
                        
                        
                        
                        
                        // Highlight
                        if(id == "yellowHighlight") {
                            tinyMCE.activeEditor.selection.setContent('[highlight color="yellow"]' + dummy_content + '[/highlight]');
                        }
                        if(id == "darkHighlight") {
                            tinyMCE.activeEditor.selection.setContent('[highlight color="dark"]' + dummy_content + '[/highlight]');
                        }
                        if(id == "customHighlight") {
                            tinyMCE.activeEditor.selection.setContent('[highlight text_color="#fff" background_color="#808080"]' + dummy_content + '[/highlight]');
                        }	
                        
                        
                        //Iconboxes
                        if(id == "iconboxes") {
                            tinyMCE.activeEditor.selection.setContent('[iconboxes icon_position="e.g. outside-left, inside-left, top"]<br/>[iconbox icon="" icon_color="" icon_background_color="" title="This is a title" title_color="" description_color=""]This is a description.[/iconbox]<br/>[iconbox icon="" icon_color="" icon_background_color="" title="This is a title" title_color="" description_color=""]This is a description.[/iconbox]<br/>[iconbox icon="" icon_color="" icon_background_color="" title="This is a title" title_color="" description_color=""]This is a description.[/iconbox]<br/>[/iconboxes]');
                        }
                        
                        
                        
                        // List
                        if(id == "list") {
                            tinyMCE.activeEditor.selection.setContent('[list icon="" icon_color=""]<ul><li>Item #1</li><li>Item #2</li><li>Item #3</li></ul>[/list]');
                        }		
                        
                        
                        
                        // Portfolio
                        if(id == "portfolio") {
                            tinyMCE.activeEditor.selection.setContent('[portfolio layout="e.g. 2column, 3column, 4column, 5column, cards, grid" show_filter="yes" align_filter="e.g. left, center, right" limit="none"]');
                        }
                        
                        
                        
                        // Pricing
                        if(id == "pricingtable") {
                            dummy_content = '[pricing_table separate_columns="false"]<br/>';
                            dummy_content += '[pricing_column price="$30" per="month" title="Column Title" subtitle="column subtitle" featured="false"]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_footer][button color="primary" url="http://"]Choose[/button][/pricing_footer]<br/>';
                            dummy_content += '[/pricing_column]<br/>';
                            dummy_content += '[pricing_column price="$30" per="month" title="Column Title" subtitle="column subtitle" featured="true"]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_footer][button color="primary" url="http://"]Choose[/button][/pricing_footer]<br/>';
                            dummy_content += '[/pricing_column]<br/>';
                            dummy_content += '[pricing_column price="$30" per="month" title="Column Title" subtitle="column subtitle" featured="false"]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_row color="default" strikethrough="false" bold="false" italics="false"]Lorem ipsum dolor[/pricing_row]<br/>';
                            dummy_content += '[pricing_footer][button color="primary" url="http://"]Choose[/button][/pricing_footer]<br/>';
                            dummy_content += '[/pricing_column]<br/>';
                            dummy_content += '[/pricing_table]';
                            tinyMCE.activeEditor.selection.setContent(dummy_content);
                        }
                        
                        
                        
                        
                        //Progress Bar
                        if(id == "progressbar") {
                            tinyMCE.activeEditor.selection.setContent('[progress percentage="100" unit="%" filled_color="primary" unfilled_color="#eee" text_color="white" show_text="yes"]'+dummy_content+'[/progress]');
                        }
                        
                        
                        
                        // Sections
                        if(id == "fullwidth") {
                            tinyMCE.activeEditor.selection.setContent('[fullwidth padding_top="50" padding_bottom="50" border_color="" background_color="" background_image="" background_repeat="" background_position="" background_size=""]<br/>' + dummy_content + '<br/>[/fullwidth]');
                        }
                        if(id == "parallax") {
                            tinyMCE.activeEditor.selection.setContent('[parallax padding_top="50" padding_bottom="50" border_color="" background_color="" background_image="" background_repeat="" background_position="" background_size=""]<br/>' + dummy_content + '<br/>[/parallax]');
                        }
                        
                        
                        
                        //Spaces
                        if(id == "nbsp") {
                            tinyMCE.activeEditor.selection.setContent('[spaces count="4"]');
                        }
                        
                        
                        
                        
                        //Social
                        if(id == "social_links") {
                            tinyMCE.activeEditor.selection.setContent('[social_links rss="#" twitter="#" facebook="#" pinterest="#" dribbble="#" google_plus="#"  youtube="#" vimeo="#" flickr="#" instagram="#" github="#" tumblr="#" linkedin="#" behance="#" reddit="#" skype="#"]');
                        }
                        
                        
                        
                        
                        //Tabs
                        if(id == "tabs") {
                            tinyMCE.activeEditor.selection.setContent('[tabs style="simple or traditional"]<br/>[tab title="Tab title" icon=""]Tab content...[/tab]<br/>[tab title="Tab title" icon=""]Tab content...[/tab]<br/>[tab title="Tab title" icon=""]Tab content...[/tab]<br/>[/tabs]');
                        }
                        
                        
                        
                        //Testimonial
                        if(id == "testimonial") {
                            tinyMCE.activeEditor.selection.setContent('[testimonial by=""]<br />' + dummy_content + '<br />[/testimonial]');
                        }
                        
                        
                        
                        
                        // Title
                        if(id == "title") {
                            tinyMCE.activeEditor.selection.setContent('[title size="1-6" style="e.g. plain, single, double, dashed, double-dashed" padding_top="20px" padding_bottom="20px" align="left, center, right"]' + dummy_content + '[/title]');
                        }
                        
                        
                        
                        //Toggles
                        if(id == "toggles") {
                            tinyMCE.activeEditor.selection.setContent('[toggles open_icon="" closed_icon=""]<br/>[toggle title="Toggle" open="yes"]...toggle content...[/toggle]<br/>[toggle title="Toggle" open="no"]...toggle content...[/toggle]<br/>[toggle title="Toggle" open="no"]...toggle content...[/toggle]<br/>[/toggles]');
                        }
					}
					
					
					return false;
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'ThemeStockyard Shortcodes',
				author: 'ThemeStockyard',
				authorurl: 'http://themestockyard.com',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	
	});
	tinymce.PluginManager.add("tsShortcodes", tinymce.plugins.tsShortcodes);
})();