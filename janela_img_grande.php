	<!--Zoomple-->
	<?php include( 'funcoes/cortar-imagem.php' );?>
	<link rel="stylesheet" href="zoomple/zoomple.css">
	<script src="zoomple/jquery-1.10.2.min.js"  type="text/javascript"></script>
	
	<script src="zoomple/zoomple.js" type="text/javascript"></script>
	<style type="text/css">
		a:focus{outline:none;} 
		#wrapper{text-align:center;}
		a img{border:0;}
		a {text-decoration:none;color:#fff;}
	</style>
	<script>
	$(document).ready(function() { 	
	$('.zoomple').zoomple({ 
		blankURL : 'zoomple/blank.gif',
		bgColor : '#90D5D9',
		loaderURL : 'zoomple/loader.gif',
		attachWindowToMouse: true,
		windowPosition: {x:100,y:100},
		delay : 0,
		source : 'href',
		offset : {x:-100,y:-100},
		zoomWidth : 150,  
		zoomHeight : 150,
		appendTimestamp : true,
		roundedCorners : true,
		timestamp : new Date().getTime()
		
		});
	});
	
	</script>

<?php 
if($_GET['img_grande'] <> '' or $_GET['img_pequena'] <> ''){ 
	$row_rs_pecas['foto'] = $_GET['img_grande'];
	$img_prim  = $_GET['img_pequena'];} ?>
<?php //$img_pecas = "minhanossa/img_noticias/".cortaImagem($row_rs_pecas['foto'], 'minhanossa/img_noticias', '650', '1000', 'img_pecas', '#FFFFFF');?>
<a href="<?php echo $img_prim?>" class="zoomple">
	<img src="<?php echo $img_prim;?>" class="item_rep"/>
</a>   
 

 