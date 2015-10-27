(function() {  
    tinymce.create('tinymce.plugins.linkPlug', {  
        init : function(ed, url) {  
            ed.addButton('linkBtn', {  
                title : 'Bouton avancé', image : url+'/links.png',  
				onclick : function() { ed.selection.setContent('[advlink type="button" value="" url="'+ed.selection.getContent()+'"]'); }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('linkBtn', tinymce.plugins.linkPlug);  
})();
