(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        init : function(ed, url) {
            ed.addButton('dropcap', {
                title : 'Картинка',
                cmd : 'dropcap',
                image : url + '/panda20.png'
            });
 
 
            ed.addCommand('dropcap', function() {
                var selected_text = ed.selection.getContent(),
				shotcode;
				shortcode = '[cr_img href="" alt="" text=""]';
				ed.execCommand('mceInsertContent', 0, shortcode);
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();