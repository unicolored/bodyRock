(function() {  
    tinymce.create('tinymce.plugins.soundPlug', {  
        init : function(ed, url) {  
            ed.addButton('soundBtn', {  
                title : 'Soundcloud', image : url+'/sound.png',  
				onclick : function() { ed.selection.setContent('[advsound code="'+ed.selection.getContent()+'"]'); }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('soundBtn', tinymce.plugins.soundPlug);  
})();
