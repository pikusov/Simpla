/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Denis Pikusov
 * @copyright Copyright © 2009
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('jaretypograph');

	tinymce.create('tinymce.plugins.JareTypograph', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceJareTypograph', function() {

				var request = null;
				if(!request) try {
					request=new ActiveXObject('Msxml2.XMLHTTP');
				} catch (e){}
				if(!request) try {
					request=new ActiveXObject('Microsoft.XMLHTTP');
				} catch (e){}
				if(!request) try {
					request=new XMLHttpRequest();
				} catch (e){}

				request.open("POST", url+'/handler.php');
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset:UTF-8');
				request.onreadystatechange = function(aEvt){

				if (request.readyState == 4){
					ed.setProgressState(0);
					if(request.status == 200 && request.responseText!=''){
										
						var response_text = request.responseText.replace(/^[\ufeff]+/g, '');
						
						//var sel = ed.selection.isCollapsed()?false:true;
						// dont use selection
						var sel=false
						
						if(sel)
							ed.selection.setContent(response_text, {format: 'raw'});
						else
							ed.setContent(response_text);
						}
						
					}
				}
				
				//var sel = ed.selection.isCollapsed()?false:true;
				// dont use selection
				var sel=false
								
				// Handle selection
				if (sel) {

					var anchorStart = "{mceTypograf-selection-start}"; // This is pretty unique ;)
					var anchorEnd = "{mceTypograf-selection-end}";
					
					// Remember current state of content and selection
					var orig = ed.getContent({format:'raw'});
					var mark = ed.selection.getBookmark();
					
					var range = ed.selection.getRng()
					var h1 = 0, h2 = 0, text = "";
					
					alert(range);
					// Range object has two parts, we will parse them separately
					// Known issues — script can die here if selection goes through the table, we should handle it somehow
						
					// Start anchor
					start_offset = range.startOffset;
					end_offset = range.endOffset;


					text = range.startContainer.data;
					h1 = text.substr(0, start_offset);
					h2 = text.substr(start_offset);
					
					text = h1 + anchorStart + h2;
					range.startContainer.data = text; // Replace original content with anchored one
					
					// End anchor
					text = range.endContainer.data;
					h1 = text.substr(0, end_offset+anchorStart.length);
					h2 = text.substr(end_offset+anchorStart.length);
					
					text = h1 + anchorEnd + h2;
					range.endContainer.data = text; // Replace original content with anchored one
					
					var alltext = ed.getContent({format: 'raw'});
					var send = alltext.substring(alltext.indexOf(anchorStart)+anchorStart.length, alltext.indexOf(anchorEnd));
			 					 
					// Put back original content while transaction. Sometimes content may twitch
					ed.setContent(orig, {format: 'raw'}); 
					ed.selection.moveToBookmark(mark);					
				}
				else
				{
					send = ed.getContent({format: 'raw'});
				}
				ed.setProgressState(1);
		
				request.send('text='+encodeURIComponent(send));								
				
			});

			// Register example button
			ed.addButton('jaretypograph', {
				title : 'typograph.desc',
				cmd : 'mceJareTypograph',
				image : url + '/img/typograph.png'
			});

		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Jare Typograph',
				author : 'Denis Pikusov',
				authorurl : 'http://pikusov.kiev.ua',
				infourl : 'http://emuravjev.ru/works/tg/',
				version : "2.0"
			};
		}
								
	
	});

	// Register plugin
	tinymce.PluginManager.add('jaretypograph', tinymce.plugins.JareTypograph);
	
})();