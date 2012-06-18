(function() {  
    tinymce.create('tinymce.plugins.quote', {  
        init : function(ed, url) {  
            ed.addButton('you', {  
                title : 'You', image : url+'/image.png',  
                onclick : function() { ed.selection.setContent('[thumb from="youtube" code="'+ed.selection.getContent()+'"]<!--more-->[video from="youtube" code="'+ed.selection.getContent()+'"]'); }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('you', tinymce.plugins.quote);  
})();
