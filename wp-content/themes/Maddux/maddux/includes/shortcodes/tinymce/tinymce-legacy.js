(function() {	
    tinymce.create('tinymce.plugins.tsShortcodes', {
        init : function(ed, url){
            tinymce.plugins.tsShortcodes.theurl = url;
            
            ed.addCommand("tsPopup", function ( a, params )
            {
            
                var popup = 'shortcode-generator';
                var preset = '';
                var preset_value = '';

                if(typeof params != 'undefined') {
                    popup = (typeof params.preset != 'undefined') ? params.identifier : 'shortcode-generator';                
                    preset = (typeof params.preset != 'undefined') ? params.preset : '';
                    preset_value = (typeof params.preset_value != 'undefined') ? params.preset_value : '';
                }
                
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
                    text: 'Shortcodes',
                    icons: false,
                });
                
                btn.onRenderMenu.add(function (c, b) {
                    
                    b.add({title : 'Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                
                
                // Blog
                c = b.addMenu({title:"Blog"});
                
                    a.render( c, "Blog", "blog" );
                    a.render( c, "Blog Slider", "blog_slider" );
                    a.render( c, "Blog Widget", "blog_widget" );
                
                //b.addSeparator();
                
                
                // Columns
                c = b.addMenu({title:"Columns"});
                
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
                    a.render( c, "Highlight", "highlight" );
                
                b.addSeparator();
                
                
                
                
                // Animations
                c = b.addMenu({title:"Animations"});
                
                    a.render( c, "Fade In", "fadein" );
                
                //b.addSeparator();
                
                
                // Audio & Video
                c = b.addMenu({title:"Audio & Video"});
                
                    a.render( c, "Youtube", "youtube" );
                    a.render( c, "Vimeo", "vimeo" );
                    //a.render( c, "Vine", "vine" );
                    a.render( c, "SoundCloud", "soundcloud" );
                
                //b.addSeparator();
                
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
                
                
                // Galleries & Slideshows
                c = b.addMenu({title:"Galleries & Slideshows"});
                
                    a.render( c, "Lightbox Gallery", "lightbox_gallery" );
                    a.render( c, "Carousel Gallery", "carousel_gallery" );
                    a.render( c, "Slider Gallery", "slider_gallery" );
                
                //b.addSeparator();
                
                
                // Helpers
                c = b.addMenu({title:"Other"});
                
                    a.render( c, "Clear Floats", "clear" );
                    a.render( c, "Clip", "clip" );
                    a.render( c, "Email Link", "email" );
                    a.render( c, "FontAwesome Icon", "fontawesome" );                       
                    
                });
                
                return btn;
            }
            return null;               
        },
        render : function(ed, title, id, preset, preset_value) {
            ed.add({
                title: title,
                onclick: function () {
                    var url = ajaxurl + "?action=ts_shortcodes_popup&popup=" + id + "&width=" + 800 + "&preset=" +preset+ "&preset_value="+preset_value; 
                    tb_show("ThemeStockyard Shortcodes", url);                    
                    
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
