(function() {  
    tinymce.create('tinymce.plugins.chessPlug', {  
        init : function(ed, url) {  
            ed.addButton('chessBtn', {  
                title : 'Chess embed', image : url+'/chess.png',  
				onclick : function() { ed.selection.setContent('[pgn layout=vertical squareSize=58 initialHalfmove=28 autoplayMode=none showMoves=figurine]'+ed.selection.getContent()+'[/pgn]'); } });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('chessBtn', tinymce.plugins.chessPlug);  
})();
