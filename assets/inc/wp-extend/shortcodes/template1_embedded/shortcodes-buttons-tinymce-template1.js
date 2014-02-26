(function() {  
    tinymce.create('tinymce.plugins.tplPlug', {  
        init : function(ed, url) {  
            ed.addButton('tplBtn', {  
                title : 'Template 1', image : url+'/tpl1.png',  
				onclick : function() { ed.selection.setContent(''+'<h1>TITRE</h1> <blockquote>Intro</blockquote> Texte <p style="text-align: center;">Image</p>  <h2>TITRE2</h2> Texte <p style="text-align: center;">Image</p>  <h2>TITRE2</h2> <strong>Conclusion</strong>'+''); }             });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('tplBtn', tinymce.plugins.tplPlug);  
})();
