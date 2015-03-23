//(function() {

    tinymce.PluginManager.add('ts_button', function(ed, url) {
        var a = this;
        ed.addCommand("tsPopup", function ( a, params )
        {
            var popup = 'shortcode-generator';
            var preset = '';
            var preset_value = '';

            if(typeof params != 'undefined') {
                popup = (typeof params.identifier != 'undefined') ? params.identifier : popup;                
                preset = (typeof params.preset != 'undefined') ? params.preset : preset;
                preset_value = (typeof params.preset_value != 'undefined') ? params.preset_value : preset_value;
            }
            
            jQuery('#TB_window').hide();
            
            var popup_url = ajaxurl + "?action=ts_shortcodes_popup&popup=" + popup + "&preset="+preset+"&preset_value="+preset_value+"&width=" + 800;

            // load thickbox
            tb_show("ThemeStockyard Shortcodes", popup_url);
        });

        // Add a button that opens a window
        ed.addButton('ts_button', {
            //type: 'menubutton',
            text: 'Shortcodes',
            icon: 'ts-tinymce-shortcode',
            image: tsShortcodes.theurl +"/images/shortcodes.png",
            cmd: 'tsPopup',
            title: "Insert Shortcode",
            //classes: 'ts-tinymce-shortcode-menu widget btn',
            
            // menu is disabled for now...
            menu: [
                {text: 'Shortcodes', 'class' : 'mceMenuItemTitle', disabled: 1},
                {text: 'Blog', menu: [
                    {text: 'Blog / Recent Posts', onclick: function() { sc_tsPopup( "blog" ) } },
                    {text: 'Blog Slider', onclick: function() { sc_tsPopup( "blog_slider" ) } },
                    {text: 'Blog Widget', onclick: function() { sc_tsPopup( "blog_widget" ) } }
                ]},
                {text: 'Columns', menu: [
                    {text: 'One Half (1/2)', onclick: function() { sc_tsPopup("columns", "column", "one_half") } },
                    {text: 'One Third (1/3)', onclick: function() { sc_tsPopup("columns", "column", "one_third" ) } },
                    {text: 'One Fourth (1/4)', onclick: function() { sc_tsPopup("columns", "column", "one_fourth" ) } },
                    {text: 'One Fifth (1/5)', onclick: function() { sc_tsPopup("columns", "column", "one_fifth" ) } },
                    {text: 'One Sixth (1/6)', onclick: function() { sc_tsPopup("columns", "column", "one_sixth" ) } },
                    {text: '-'},
                    {text: 'Two Third (2/3)', onclick: function() { sc_tsPopup("columns", "column", "two_third" ) } },
                    {text: 'Three Fourth (3/4)', onclick: function() { sc_tsPopup("columns", "column", "three_fourth" ) } },
                    {text: 'Two Fifth (2/5)', onclick: function() { sc_tsPopup("columns", "column", "two_fifth" ) } },
                    {text: 'Three Fifth (3/5)', onclick: function() { sc_tsPopup("columns", "column", "three_fifth" ) } },
                    {text: 'Four Fifth (4/5)', onclick: function() { sc_tsPopup("columns", "column", "four_fifth" ) } },
                    {text: 'Five Sixth (5/6)', onclick: function() { sc_tsPopup("columns", "column", "five Sixth" ) } }
                ]},
                {text: 'Elements', menu: [
                    {text: 'Alert', onclick: function() { sc_tsPopup("alert") } },
                    {text: 'Button', onclick: function() { sc_tsPopup("button") } },
                    {text: 'Callout', onclick: function() { sc_tsPopup("callout") } },
                    {text: 'Code', onclick: function() { sc_tsPopup("code") } },
                    {text: 'Google Map', onclick: function() { sc_tsPopup("googlemap") } },
                    {text: 'Iconboxes', onclick: function() { sc_tsPopup("iconboxes") } },
                    {text: 'List', onclick: function() { sc_tsPopup("list") } },
                    {text: 'Pricing Table', onclick: function() { sc_tsPopup("pricingtable") } },
                    {text: 'Progress Bar', onclick: function() { sc_tsPopup("progressbar") } },
                    {text: 'Social Links', onclick: function() { sc_tsPopup("social_links") } },
                    {text: 'Title', onclick: function() { sc_tsPopup("title") } }
                ]},
                {text: 'Sections', menu: [
                    {text: 'Fullwidth', onclick: function() { sc_tsPopup("fullwidth") } },
                    {text: 'Parallax', onclick: function() { sc_tsPopup("fullwidth", "style", "parallax") } },
                ]},
                {text: 'Tabs & Toggles', menu: [
                    {text: 'Accordion', onclick: function() { sc_tsPopup("accordion") } },
                    {text: 'Tabs', onclick: function() { sc_tsPopup("tabs") } },
                    {text: 'Toggles', onclick: function() { sc_tsPopup("toggles") } }
                ]},
                {text: 'Typography', menu: [
                    {text: 'Dropcap', onclick: function() { sc_tsPopup("dropcap") } },
                    {text: 'Highlight', onclick: function() { sc_tsPopup("highlight") } }
                ]},
                {text: '-'},
                {text: 'Animations', menu: [
                    {text: 'Fade In', onclick: function() { sc_tsPopup("fadein") } },
                ]},
                {text: 'Audio & Video', menu: [
                    {text: 'Youtube', onclick: function() { sc_tsPopup("youtube") } },
                    {text: 'Vimeo', onclick: function() { sc_tsPopup("vimeo") } },
                    {text: 'SoundCloud', onclick: function() { sc_tsPopup("soundcloud") } }
                ]},
                {text: 'Dividers', menu: [
                    {text: 'Invisible', onclick: function() { sc_tsPopup("divider","style","invisible") } },
                    {text: 'Single Line', onclick: function() { sc_tsPopup("divider","style","single") } },
                    {text: 'Dashed Line', onclick: function() { sc_tsPopup("divider","style","dashed") } },
                    {text: 'Double Line', onclick: function() { sc_tsPopup("divider","style","double") } },
                    {text: 'Double-Dashed', onclick: function() { sc_tsPopup("divider","style","double-dashed") } },
                    {text: 'Circle', onclick: function() { sc_tsPopup("divider","style","circle") } },
                    {text: 'Square', onclick: function() { sc_tsPopup("divider","style","square") } },
                ]},
                {text: 'Galleries & Slideshows', menu: [
                    {text: 'Lightbox Gallery', onclick: function() { sc_tsPopup("lightbox_gallery") } },
                    {text: 'Carousel Gallery', onclick: function() { sc_tsPopup("carousel_gallery") } },
                    {text: 'Slider Gallery', onclick: function() { sc_tsPopup("slider_gallery") } }
                ]},
                {text: 'Other', menu: [
                    {text: 'Clear Floats', onclick: function() { sc_tsPopup("clear") } },
                    {text: 'Clip', onclick: function() { sc_tsPopup("clip") } },
                    {text: 'Email Link', onclick: function() { sc_tsPopup("email") } },
                    {text: 'FontAwesome Icon', onclick: function() { sc_tsPopup("fontawesome") } }
                ]}                        
            ]
        });
        
    });
    
    
//});