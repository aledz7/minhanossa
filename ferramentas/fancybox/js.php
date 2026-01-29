<?php 
// include('ferramentas/fancybox/js.php');
// <a href="javascript:;" onClick="$.fancybox.open({href : 'https://www.youtube.com/embed/c20jH8qO-5s?autoplay=1',type : 'iframe',padding : 5});">
?>
<script type="text/javascript" src="ferramentas/fancybox/jquery.fancybox.js?v=2.1.5"></script> 
<script type="text/javascript" src="ferramentas/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script> 
<script type="text/javascript" src="ferramentas/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script> 
<script type="text/javascript" src="ferramentas/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script>
$(document).ready(function() {
	/*
	*   Examples - images
	*/
	
	$("a#zoom").fancybox();
	
	$("a#example2").fancybox({
		'overlayOpacity'	: 0.1,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'width'				: '97%',
		'height'			: '98%',
		'autoScale'			: false,
		'type'				: 'iframe'
	
	});
	
	$("a#example3").fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none'	
	});
	
	$("a#example4").fancybox({
		'opacity'		: true,
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'none'
	});
	
	$("a#example5").fancybox();
	
	$("a#example6").fancybox({
		'titlePosition'		: 'outside',
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.9
	});
	
	$("a#example7").fancybox({
		'titlePosition'	: 'inside'
	});
	
	$("a#example8").fancybox({
		'titlePosition'	: 'over'
	});
	
	$("a[rel=example_group]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	
	/*
	*   Examples - various
	*/
	
	$("#various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
	
	$("#various2").fancybox();
	
	$("#various3").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	
	$("#various4").fancybox({
		'padding'			: 0,
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});
</script>