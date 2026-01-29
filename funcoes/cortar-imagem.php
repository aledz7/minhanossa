<?php
// include('funcoes/cortar-imagem.php');
if($funcaoCortarImagens == '') {
	if(file_exists('class/class.upload.php')) {	
		include('class/class.upload.php');
	} else {
		include('../class/class.upload.php');
	}
	
	function cortaImagem($foto, $pasta, $largura, $altura, $tipo='img', $fundo='#000000') {
		if($foto) {
			
			$nomeFoto = str_replace(array('-', '.'),array('_', ''),substr($foto,0,-4));
			if(substr($foto,-4,1) <> '.') {
				$extensao = strtolower(substr($foto,-5));
			} else {
				$extensao = strtolower(substr($foto,-4));
			}

			//echo "{$pasta}/img_".$nomeFoto.'.jpg'; 
			
			if(!file_exists("{$pasta}/{$tipo}_".$nomeFoto.$extensao)) {
				//echo "{$dir}{$pasta}/{$foto}"; 
				
				@$foto = new upload("{$pasta}/{$foto}");
				//print_r($foto);
				
				if($foto->uploaded){
					// Altero o tamanho da imagem
					$foto->image_x = $largura;
					
					$foto->image_y = $altura;
					$foto->image_ratio_fill = true;
					// estas opções abaixo colocam as opções personalizadas, como medida x ou y
					$foto->image_resize = true;
					$foto->image_background_color = $fundo;
					//$foto->image_ratio_y = true;
					$fotoBanco = $foto->file_new_name_body = $tipo.'_'.$nomeFoto;
					$foto->process($pasta);
					return($fotoBanco.$extensao);
				}
			} else {
				return($tipo.'_'.$nomeFoto.$extensao);
			}
		}
	}


	function cortaImagemSemFundo($foto, $pasta, $largura, $altura, $tipo='img') {
		if($foto) {
			
			$nomeFoto = str_replace(array('-', '.'),array('_', ''),substr($foto,0,-4));
			if(substr($foto,-4,1) <> '.') {
				$extensao = strtolower(substr($foto,-5));
			} else {
				$extensao = strtolower(substr($foto,-4));
			}
			//echo "{$pasta}/img_".$nomeFoto.'.jpg'; 
			
			if(!file_exists("{$pasta}/{$tipo}_".$nomeFoto.$extensao)) {
				//echo "{$dir}{$pasta}/{$foto}"; 
				
				@$foto = new upload("{$pasta}/{$foto}");
				//print_r($foto);
				
				if($foto->uploaded){
					// Altero o tamanho da imagem
					$foto->image_resize          = true;
					$foto->image_ratio_crop      = true;
					$foto->image_crop            = '0 10';
					$foto->image_y               = $altura;
					$foto->image_x               = $largura;
	
					//$foto->image_ratio_y = true;
					$fotoBanco = $foto->file_new_name_body = $tipo.'_'.$nomeFoto;
					$foto->process($pasta);
					return($fotoBanco.$extensao);
				}
			} else {
				return($tipo.'_'.$nomeFoto.$extensao);
			}
		}
	}
	
	$funcaoCortarImagens = 'instanciada';
}

