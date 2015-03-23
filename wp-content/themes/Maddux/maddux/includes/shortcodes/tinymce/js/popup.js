// popup specific scripts
// safe to use $
jQuery(document).ready(function($) {
    if(typeof tsShortcodes != 'undefined' && tsShortcodes.wp_version && tsShortcodes.wp_version >= 3.9) {
        jQuery('body').addClass('ts-wp-version-3-9-plus');
    }
    window.ts_tb_height = (92 / 100) * jQuery(window).height();
    window.ts_shortcodes_height = (71 / 100) * jQuery(window).height();
    if(window.ts_shortcodes_height > 550) {
        window.ts_shortcodes_height = (74 / 100) * jQuery(window).height();
    }

    jQuery(window).resize(function() {
        window.ts_tb_height = (92 / 100) * jQuery(window).height();
        window.ts_shortcodes_height = (71 / 100) * jQuery(window).height();

        if(window.ts_shortcodes_height > 550) {
            window.ts_shortcodes_height = (74 / 100) * jQuery(window).height();
        }
    });

    ts_shortcodes = {
    	loadVals: function()
    	{
    		var shortcode = $('#_ts_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.ts-input').each(function() {
    			var input = $(this),
    				id = input.is('[type="radio"]') ? input.attr('name') : input.attr('id'),
    				id = id.replace('ts_', ''),
    				re = new RegExp("{{"+id+"}}","g");
                var value = input.is('[type="radio"]') ? $('.ts-input[name="ts_'+id+'"]:checked').val() : input.val();
                if(value == null) {
                  value = '';
                }
                var mceContent = tinyMCE.activeEditor.selection.getContent();
                if(input.hasClass('ts-use-selection') && $.trim(mceContent)) {
                    value = mceContent;
                    input.val(value).removeClass('ts-use-selection');
                }
    			uShortcode = uShortcode.replace(re, value);
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_ts_ushortcode').remove();
    		$('#ts-sc-form-table').prepend('<div id="_ts_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_ts_cshortcode').text(),
    			pShortcode = '';

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = '<br />';
    			} else {
    				shortcodes = '';
    			}

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
                if($(this).find('#ts_slider_type').length >= 1) {
                    if($(this).find('#ts_slider_type').val() == 'image') {
                        rShortcode = '[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]';
                    } else if($(this).find('#ts_slider_type').val() == 'video') {
                        rShortcode = '[slide type="{{slider_type}}"]{{video_content}}[/slide]';
                    }
                }
    			$('.ts-cinput', this).each(function() {
    				var input = $(this),                        
                        id = input.is('[type="radio"]') ? input.attr('name') : input.attr('id'),
                        id = id.replace('ts_', ''),
                        re = new RegExp("{{"+id+"}}","g");
                    var value = input.is('[type="radio"]') ? $('.ts-cinput[name="ts_'+id+'"]:checked').val() : input.val();
                    if(value == null) {
                      value = '';
                    }
                    var mceContent = tinyMCE.activeEditor.selection.getContent();
                    if(input.hasClass('ts-use-selection') && $.trim(mceContent)) {
                        value = mceContent;
                        input.val(value).removeClass('ts-use-selection');
                    }
                        
    				rShortcode = rShortcode.replace(re, value);
    			});

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = shortcodes + rShortcode + '<br />';
    			} else {
    				shortcodes = shortcodes + rShortcode;
    			}
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_ts_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_ts_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_ts_ushortcode').html().replace('{{child_shortcode}}', shortcodes);
            
    		// add updated parent shortcode
    		$('#_ts_ushortcode').remove();
    		$('#ts-sc-form-table').prepend('<div id="_ts_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false,
    			maxRows: ($('.child-clone-rows').attr('data-max-rows')) ? $('.child-clone-rows').attr('data-max-rows') : 50,
                onAdd: function(row) {
                    // Get Upload ID
                    var prev_upload_id = jQuery(row).prev().find('.ts-upload-button').data('upid');
                    var new_upload_id = prev_upload_id + 1;
                    jQuery(row).find('.ts-upload-button').attr('data-upid', new_upload_id);
                    jQuery(row).find('.ts-use-selection').removeClass('ts-use-selection');

                    // activate chosen
                    jQuery('.ts-form-multiple-select').chosen({
                        width: '100%',
                        placeholder_text_multiple: 'Select Options or Leave Blank for All'
                    });

                    // activate color picker
                    jQuery('.wp-color-picker-field').wpColorPicker({
                        change: function(event, ui) {
                            ts_shortcodes.loadVals();
                            ts_shortcodes.cLoadVals();
                        }
                    });

                    // changing slide type
                    var type = $(row).find('#ts_slider_type').val();

                    if(type == 'video') {
                        $(row).find('#ts_image_content, #ts_image_url, #ts_image_target, #ts_image_lightbox').closest('li').hide();
                        $(row).find('#ts_video_content').closest('li').show();

                        $(row).find('#_ts_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
                    }

                    if(type == 'image') {
                        $(row).find('#ts_image_content, #ts_image_url, #ts_image_target, #ts_image_lightbox').closest('li').show();
                        $(row).find('#ts_video_content').closest('li').hide();

                        $(row).find('#_ts_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
                    }

                    ts_shortcodes.loadVals();
                    ts_shortcodes.cLoadVals(false);
                }
    		});
    		
    		// remove button
    		$('.child-clone-rows').on('click', '.child-clone-row-remove', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').length > 1 )
    			{
    				row.slideUp(function () { 
                        row.remove(); 
                    });
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row',
                cancel: 'div.iconpicker, input, select, textarea, a'
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				tsPopup = $('#ts-popup');

            tbWindow.css({
                height: window.ts_tb_height,
                width: tsPopup.outerWidth(),
                marginLeft: -(tsPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: window.ts_tb_height,
				overflow: 'auto', // IMPORTANT
				width: tsPopup.outerWidth()
			});

            tbWindow.show();

			$('#ts-popup').addClass('no_preview');
            $('#ts-sc-form-wrap #ts-sc-form').height(window.ts_shortcodes_height);
    	},
    	load: function()
    	{
    		var	ts = this,
    			popup = $('#ts-popup'),
    			form = $('#ts-sc-form', popup),
    			shortcode = $('#_ts_shortcode', form).text(),
    			popupType = $('#_ts_popup', form).text(),
    			uShortcode = '';
    		
            // if its the shortcode selection popup
            if($('#_ts_popup').text() == 'shortcode-generator') {
                $('.ts-sc-form-button').hide();
            }

    		// resize TB
    		ts_shortcodes.resizeTB();
    		$(window).resize(function() { ts_shortcodes.resizeTB() });
    		
    		// initialise
            ts_shortcodes.loadVals();
    		ts_shortcodes.children();
    		ts_shortcodes.cLoadVals();
    		
    		// update on children value change
    		$('.ts-cinput', form).live('change', function() {
    			ts_shortcodes.cLoadVals();
    		});
    		
    		// update on value change
    		$('.ts-input', form).live('change', function() {
    			ts_shortcodes.loadVals();
    		});

            // change shortcode when a user selects a shortcode from choose a dropdown field
            $('#ts_select_shortcode').change(function() {
                var name = $(this).val();
                var label = $(this).text();
                var preset = $(this).find('option:selected').attr('data-preset');
                var preset_value = $(this).find('option:selected').attr('data-preset-value');
                
                if(name != 'select') {
                    tinyMCE.activeEditor.execCommand("tsPopup", false, {
                        title: label,
                        identifier: name,
                        preset: preset,
                        preset_value: preset_value
                    });

                    $('#TB_window').hide();
                }
            });

            // activate chosen
            $('.ts-form-multiple-select').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Options'
            });

            // update upload button ID
            jQuery('.ts-upload-button:not(:first)').each(function() {
                var prev_upload_id = jQuery(this).data('upid');
                var new_upload_id = prev_upload_id + 1;
                jQuery(this).attr('data-upid', new_upload_id);
            });
    	}
	}
    
    // run
    $('#ts-popup').livequery(function() {
        ts_shortcodes.load();

        $('#ts-popup').closest('#TB_window').addClass('ts-shortcodes-popup');

        $('#ts_video_content').closest('li').hide();

            // activate color picker
            $('.wp-color-picker-field').wpColorPicker({
                change: function(event, ui) {
                    setTimeout(function() {
                        ts_shortcodes.loadVals();
                        ts_shortcodes.cLoadVals();
                    },
                    1);
                }
            });
    });

    // when insert is clicked
    $('.ts-insert').live('click', function() {                        
        if(window.tinyMCE)
        {
            if(tsShortcodes.wp_version < '3.9') {
                window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_ts_ushortcode').html());
                tb_remove();
            } else {
                window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, $('#_ts_ushortcode').html());
                tb_remove();
            }
        }
    });
    
    // enahnced color picker option
    $('.ts-form-checkbox-alt').live('click', function() {
        var key = $(this).attr('data-key');
        var parent = $(this).closest('td.field');
        if(!parent.length) {
            parent = $(this).closest('.child-clone-row-field');
        }
        if($(this).is(':checked')) {
            parent.find('.ts-default').addClass('hidden').find('#'+key).attr('name', key+'_alt').attr('id', key+'_alt');
            parent.find('.ts-alt').removeClass('hidden').find('#'+key+'_alt').attr('name', key).attr('id', key);
        } else {
            parent.find('.ts-alt').addClass('hidden').find('#'+key).attr('name', key+'_alt').attr('id', key+'_alt');
            parent.find('.ts-default').removeClass('hidden').find('#'+key+'_alt').attr('name', key).attr('id', key);
        }
    });

    // activate upload button
    $('.ts-upload-button').live('click', function(e) {
	    e.preventDefault();

        upid = $(this).attr('data-upid');

        if($(this).hasClass('remove-image')) {
            $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', '').hide();
            $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', '');
            $('.ts-upload-button[data-upid="' + upid + '"]').text('Upload').removeClass('remove-image');

            return;
        }

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image',
            },
	        frame: 'post',
            multiple: false  // Set to true to allow multiple files to be selected
        });

	    file_frame.open();

        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
                selection.map( function( attachment ) {
                attachment = attachment.toJSON();

                $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
                $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

                ts_shortcodes.loadVals();
                ts_shortcodes.cLoadVals();
            });

            $('.ts-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
            $('.media-modal-close').trigger('click');
        });

	    file_frame.on( 'insert', function() {
		    var selection = file_frame.state().get('selection');
		    var size = jQuery('.attachment-display-settings .size').val();

		    selection.map( function( attachment ) {
			    attachment = attachment.toJSON();

			    if(!size) {
				    attachment.url = attachment.url;
			    } else {
				    attachment.url = attachment.sizes[size].url;
			    }

			    $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
			    $('.ts-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

			    ts_shortcodes.loadVals();
			    ts_shortcodes.cLoadVals();
		    });

		    $('.ts-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
		    $('.media-modal-close').trigger('click');
	    });
    });

    // activate iconpicker
    $('.iconpicker i').live('click', function(e) {
        e.preventDefault();

        var iconWithPrefix = $(this).attr('class');
        var fontName = $(this).attr('data-name').replace('fa-', '');

        if($(this).hasClass('active')) {
            $(this).parent().find('.active').removeClass('active');

            $(this).parent().parent().find('input').attr('value', '');
        } else {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().find('input').attr('value', fontName);
        }

        ts_shortcodes.loadVals();
        ts_shortcodes.cLoadVals();
    });

    // table shortcode
    $('#ts-sc-form-table .ts-insert').live('click', function(e) {
        e.stopPropagation();

        var shortcodeType = $('#ts_select_shortcode').val();

        if(shortcodeType == 'table') {
            var type = $('#ts-sc-form-table #ts_type').val();
            var columns = $('#ts-sc-form-table #ts_columns').val();

            var text = '<div class="table-' + type + '"><table width="100%"><thead><tr>';

            for(var i=0;i<columns;i++) {
                text += '<th>Column ' + (i + 1) + '</th>';
            }

            text += '</tr></thead><tbody>';

            for(var i=0;i<columns;i++) {
                text += '<tr>';
                if(columns >= 1) {
                    text += '<td>Item #' + (i + 1) + '</td>';
                }
                if(columns >= 2) {
                    text += '<td>Description</td>';
                }
                if(columns >= 3) {
                    text += '<td>Discount:</td>';
                }
                if(columns >= 4) {
                    text += '<td>$' + (i + 1) + '.00</td>';
                }
                text += '</tr>';
            }

            text += '<tr>';
            
            if(columns >= 1) {
                text += '<td><strong>All Items</strong></td>';
            }
            if(columns >= 2) {
                text += '<td><strong>Description</strong></td>';
            }
            if(columns >= 3) {
                text += '<td><strong>Your Total:</strong></td>';
            }
            if(columns >= 4) {
                text += '<td><strong>$10.00</strong></td>';
            }
            text += '</tr>';
            text += '</tbody></table></div>';

            if(window.tinyMCE)
            {
                window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, text);
                tb_remove();
            }
        }
    });

    // slider shortcode
    $('#ts_slider_type').live('change', function(e) {
        e.preventDefault();

        var type = $(this).val();
        if(type == 'video') {
            $(this).parents('ul').find('#ts_image_content, #ts_image_url, #ts_image_target, #ts_image_lightbox').closest('li').hide();
            $(this).parents('ul').find('#ts_video_content').closest('li').show();

            $('#_ts_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
        }

        if(type == 'image') {
            $(this).parents('ul').find('#ts_image_content, #ts_image_url, #ts_image_target, #ts_image_lightbox').closest('li').show();
            $(this).parents('ul').find('#ts_video_content').closest('li').hide();

            $('#_ts_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
        }
    });

    $('.ts-add-video-shortcode').live('click', function(e) {
        e.preventDefault();

        var shortcode = $(this).attr('href');
        var content = $(this).parents('ul').find('#ts_video_content');
        
        content.val(content.val() + shortcode);
    });

    /*
    $('#ts-popup textarea').live('focus', function() {
        var text = $(this).val();

        if(text == 'Your Content Goes Here') {
            $(this).val('');
        }
    });
    */

    $('.ts-gallery-button').live('click', function(e) {
	    var gallery_file_frame;

        e.preventDefault();

	    alert('To add images to this post or page for attachments layout, navigate to "Upload Files" tab in media manager and upload new images.');

        gallery_file_frame = wp.media.frames.gallery_file_frame = wp.media({
            title: 'Attach Images to Post/Page',
            button: {
                text: 'Go Back to Shortcode',
            },
            frame: 'post',
            multiple: true  // Set to true to allow multiple files to be selected
        });

	    gallery_file_frame.open();

        $('.media-menu-item:contains("Upload Files")').trigger('click');

        gallery_file_frame.on( 'select', function() {
            $('.media-modal-close').trigger('click');

            ts_shortcodes.loadVals();
            ts_shortcodes.cLoadVals();
        });
    });
});