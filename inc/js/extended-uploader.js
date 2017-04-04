(function( $ ) {
/* global wp, console */
	$(function() {

		var workflows = {};

  		var mediaExtended = {
			modelTag      : '',
			modelTagClass : '',
			imgAlignment  : '',
			linkTo        : '',
			pWrapper      : ''
		};
  			 
  			

  		// we are extending/hijacking  wp.media.editor

  		wp.media.editor.open = function( id, options ){
			/* DEFAULT WP */
			var workflow;

			options = options || {};

			id = this.id( id );
			this.activeEditor = id;

			workflow = this.get( id );

			// Redo workflow if state has changed
			if ( ! workflow || ( workflow.options && options.state !== workflow.options.state ) ) {
			workflow = this.add( id, options );
			}

			/* OUR CODE */
			setTimeout(function() {

				$('.media-button-insert').on('mousedown' , function (event){
					mediaExtended.modelTag = $('.media-sidebar #model_tag option:selected').val();
					mediaExtended.modelTagClass = $('.media-sidebar .model_tag_class').val();
					mediaExtended.pWrapper = $('.media-sidebar .p_wrapper').val();
					mediaExtended.imgAlignment = $('.attachment-display-settings .alignment option:selected').val();
					mediaExtended.linkTo = $('.attachment-display-settings .link-to option:selected').val();
				});
			}, 150);

			/* DEFAULT WP */
			return workflow.open();
  		};


		wp.media.editor.insert = function(html){
			/* OUR CODE */
			console.log(mediaExtended.linkTo);
			//if(model_tag == 1 && linkTo == 'none'){ // only add if 'link-to' is 'none'
			if(mediaExtended.modelTag == 1){
				var _arg = [];

				a = arguments[0];
				a = a.split("\n");
				a = a.filter(Boolean);

				$(a).each(function(index, el) {
					imgAlignment = 'align'+mediaExtended.imgAlignment;
					imgW = $(el).attr('width');
					_arg.push('<span style="width:'+imgW+'px" class="'+ mediaExtended.modelTagClass +' '+ imgAlignment +'">' + el + '</span>');
				});
				_arg = _arg.join("\n\n");
				_arg = [_arg];
				var arguments = _arg;
			}
			if(mediaExtended.pWrapper == 1){
				var _arg = [];

				a = arguments[0];
				a = a.split("\n");
				a = a.filter(Boolean);

				$(a).each(function(index, el) {

					_arg.push('<p class="p-imgwrap">' + el + '</p>');
				});
				_arg = _arg.join("\n\n");
				_arg = [_arg];
				var arguments = _arg;
			}

			/* DEFAULT WP */
			var editor, wpActiveEditor,
			   hasTinymce = ! _.isUndefined( window.tinymce ),
			   hasQuicktags = ! _.isUndefined( window.QTags );

			if ( this.activeEditor ) {
			   wpActiveEditor = window.wpActiveEditor = this.activeEditor;
			} else {
			   wpActiveEditor = window.wpActiveEditor;
			}

			// Delegate to the global `send_to_editor` if it exists.
			// This attempts to play nice with any themes/plugins that have
			// overridden the insert functionality.
			if ( window.send_to_editor ) {
			   return window.send_to_editor.apply( this, arguments );
			}

			if ( ! wpActiveEditor ) {
			   if ( hasTinymce && tinymce.activeEditor ) {
			       editor = tinymce.activeEditor;
			       wpActiveEditor = window.wpActiveEditor = editor.id;
			   } else if ( ! hasQuicktags ) {
			       return false;
			   }
			} else if ( hasTinymce ) {
			   editor = tinymce.get( wpActiveEditor );
			}

			if ( editor && ! editor.isHidden() ) {
			   editor.execCommand( 'mceInsertContent', false, html );
			} else if ( hasQuicktags ) {
			   QTags.insertContent( html );
			} else {
			   document.getElementById( wpActiveEditor ).value += html;
			}

			// If the old thickbox remove function exists, call it in case
			// a theme/plugin overloaded it.
			if ( window.tb_remove ) {
			   try { window.tb_remove(); } catch( e ) {}
			}
		}

	});

})( jQuery );
console.log('we are GOOD!');

