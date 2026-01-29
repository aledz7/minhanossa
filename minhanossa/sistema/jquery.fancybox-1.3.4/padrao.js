function abrePgFancybox(pagina) {
		/// abri o colorbox
		$(document).ready(function() {  
       	$.fancybox({href:pagina, 
		overlayOpacity:0.1, 
		transitionIn:'elastic', 
		transitionOut:'elastic'
			});
    	});	
}

function abrePgFancyboxTela(pagina) {
		/// abri o colorbox
		$(document).ready(function() {  
       	$.fancybox({href:pagina, 
		'titlePosition'	: 'over',
		transitionIn:'elastic', 
		transitionOut:'elastic',
		title:'teste',
			});
    	});	
}




function abrePgFancyboxSemFechar(pagina) {
		/// abri o colorbox
		$(document).ready(function() {  
       	$.fancybox({href:pagina, 
		overlayOpacity:0.1, 
		transitionIn:'elastic', 
		transitionOut:'elastic', 
		autoScale:false,
			});
    	});	
}