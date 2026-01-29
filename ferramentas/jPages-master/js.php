<script type="text/javascript" src="ferramentas/jPages-master/js/highlight.pack.js"></script>
<script type="text/javascript" src="ferramentas/jPages-master/js/tabifier.js"></script>
<script src="ferramentas/jPages-master/js/js.js"></script>
<script src="ferramentas/jPages-master/js/jPages.js"></script>

<script>
/* when document is ready */
$(function() {
	/* initiate plugin */
	$("div.holder").jPages({
		containerID: "itemContainer",
		previous: 'Voltar',
		next: 'Mais Notícias',
		perPage: 4,
		callback    : function( pages, items ){
			/*$("#legend1").html("Page " + pages.current + " of " + pages.count);
			$("#legend2").html(items.range.start + " - " + items.range.end + " of " + items.count);*/
			if(pages.current != 1) {
				$('html, body').animate({scrollTop:$('#itemContainer').offset().top-150}, 1500);
			}
      }
	});
});
  
document.getElementById('itemContainer').style.display='';
document.getElementById('carregando_registros').style.display='none';
</script>