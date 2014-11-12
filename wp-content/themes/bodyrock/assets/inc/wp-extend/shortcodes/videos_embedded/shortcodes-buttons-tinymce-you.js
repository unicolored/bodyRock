(function() {  
    tinymce.create('tinymce.plugins.youPlug', {  
        init : function(ed, url) {  
            ed.addButton('youBtn', {  
                title : 'You', image : url+'/youtube.png',  
//                onclick : function() { ed.selection.setContent('[thumb from="youtube" code="'+ed.selection.getContent()+'"] <!--more--><!--noteaser--> [video from="youtube" code="'+ed.selection.getContent()+'"]'); }  
                onclick : function() { ed.selection.setContent('[video from="youtube" code="'+ed.selection.getContent()+'"]'); }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('youBtn', tinymce.plugins.youPlug);  
})();
