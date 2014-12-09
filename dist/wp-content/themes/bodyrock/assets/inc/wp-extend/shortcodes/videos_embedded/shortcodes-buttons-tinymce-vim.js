(function() {  
    tinymce.create('tinymce.plugins.vimPlug', {  
        init : function(ed, url) {  
            ed.addButton('vimBtn', {  
                title : 'Vim', image : url+'/vimeo.png',  
				onclick : function() { ed.selection.setContent('[thumb from="vimeo" code="'+ed.selection.getContent()+'"] <!--more--><!--noteaser--> [video from="vimeo" code="'+ed.selection.getContent()+'"]'); }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('vimBtn', tinymce.plugins.vimPlug);  
})();
