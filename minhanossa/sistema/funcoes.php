<?php
$dadosSite['titulo'] = 'MINHA NOSSA';
$dadosSite['email'] = 'contato@minhanossa.net.br';

if (!function_exists("verificaIncludeFuncoes")) {
function verificaIncludeFuncoes() {}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

function marcaHistoricoAlteracao($texto) {
	global $database_conexao, $conexao;
	@session_start();
	
	if($_SESSION['dadosUser']['id'] <> '') {
		$insertSQL = sprintf("INSERT INTO tbl_logs (texto, id_usuario) VALUES (%s, %s)",
			   GetSQLValueString($texto, "text"),
			   GetSQLValueString($_SESSION['dadosUser']['id'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	}
}



function fotoHistoricoAlteracao($texto) {
	global $database_conexao, $conexao;
	@session_start();
	
	if($_SESSION['dadosUser']['id'] <> '') {
		$insertSQL = sprintf("INSERT INTO tbl_logs (texto, id_usuario) VALUES (%s, %s)",
			   GetSQLValueString($texto, "text"),
			   GetSQLValueString($_SESSION['dadosUser']['id'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	}
}









function marcaCheckSelecionado($Marcados, $Atual) {
	
	$Marcados = explode(', ', $Marcados);
	for($i=0; $i < count($Marcados); $i++) {
		if($Marcados[$i] == $Atual) {
			return('checked="checked"');
			die; 
		} // fim if
	} // fim for
}


function hora_to_seg($time) {
	$hours = substr($time, 0, -6);
	$minutes = substr($time, -5, 2);
	$seconds = substr($time, -2);
	
	return $hours * 3600 + $minutes * 60 + $seconds;
}


function m2h($mins) {
// Se os minutos estiverem negativos
	if ($mins < 0)
	$min = abs($mins);
	else
	$min = $mins;
	
	// Arredonda a hora
	$h = floor($min / 60);
	$m = ($min - ($h * 60)) / 100;
	$horas = $h + $m;
	
	// Matemática da quinta série
	// Detalhe: Aqui também pode se usar o abs()
	if ($mins < 0)
	$horas *= -1;
	
	// Separa a hora dos minutos
	$sep = explode('.', $horas);
	$h = $sep[0];
	if (empty($sep[1]))
	$sep[1] = 00;
	
	$m = $sep[1];
	
	// Aqui um pequeno artifício pra colocar um zero no final
	if (strlen($m) < 2)
	$m = $m . 0;
	
	return sprintf('%02d horas e %02d', $h, substr($m,0,2))." minutos.";
}

function descEstado($estado, $tipo) {
global $database_conexao;
global $conexao;

mysql_select_db($database_conexao, $conexao);
$query_rs_estados = "SELECT * FROM dados_estados where id = '$estado' ";
$rs_estados = mysql_query($query_rs_estados, $conexao) or die(mysql_error());
$row_rs_estados = mysql_fetch_assoc($rs_estados);
$totalRows_rs_estados = mysql_num_rows($rs_estados);

return($row_rs_estados[$tipo]); }


function descStatus($status) {
global $database_conexao;
global $conexao;

mysql_select_db($database_conexao, $conexao);
$query_rs_status = "SELECT * FROM tbl_status where id = '$status' ";
$rs_status = mysql_query($query_rs_status, $conexao) or die(mysql_error());
$row_rs_status = mysql_fetch_assoc($rs_status);
$totalRows_rs_status = mysql_num_rows($rs_status);

return ($row_rs_status[status]); }


function fundoZebra() {
	global $zebra;
	if($zebra/2 == 0) { 
		$zebra=1; 
		return('background:#f1f1f1;');
	} else { 
		$zebra=0; 
		return('background:#FFF;');
	}
}


function timestamp($data) { //  DATA BR
	//redefine a data
	$ano = substr($data,6,4);
	$mes = substr($data,3,2);
	$dia = substr($data,0,2);
	
	//calcula timestamp das datas
	return($timestamp1 = mktime(0,0,0,$mes,$dia,$ano));
}


function buscaGenericad($inputCampo, $campoId, $targetParent, $tituloBusca, $tituloBanco, $javascript, $tabelas, $concatCampos, $where, $inputId='') { 

	if($inputId == '') {
		$inputId = $inputCampo;
	}

	$_SESSION['javascript_'.$inputId] = $javascript;
	$gets = "targetParent=".$targetParent."&inputCampo=".$inputId."&tituloBanco=".$tituloBanco."&tabelas=".$tabelas."&campoId=".$campoId."&concatCampos=".$concatCampos."&where=".urlencode($where);
	$onClick = $targetParent."abreJanelaJquery('select-busca-generica.php?$gets', 'Busca de ".$tituloBusca."', '', '450px', '200', ".$targetParent."rand(1,9999))";
	?>
    <script>
	var tempoDados = '';
	
	function pegaDadosBGen<?php echo $inputId;?>() {
		if(document.getElementById('<?php echo $inputId;?>').value != document.getElementById('digitadoBusGen<?php echo $inputId;?>').value && document.getElementById('<?php echo $inputId;?>').value != '') {
			document.getElementById('enviaBuscaGenerica<?php echo $inputId;?>').src='select-busca-generica.php?busca=***&id=' + document.getElementById('<?php echo $inputId;?>').value + '&<?php echo $gets;?>';
			document.getElementById('digitadoBusGen<?php echo $inputId;?>').value = document.getElementById('<?php echo $inputId;?>').value;
		}
	}
	
	function clickDados<?php echo $inputId;?>() {
		document.getElementById('desc_<?php echo $inputId;?>').innerHTML='<img src="images/loading2.gif" width="16" height="11" />';
		if(document.getElementById('<?php echo $inputId;?>').value == '') {
			document.getElementById('desc_<?php echo $inputId;?>').innerHTML='';
		}
		tempoDados<?php echo $inputId;?> = window.setTimeout(pegaDadosBGen<?php echo $inputId;?>, 1000);
	}
	
	</script>
	<input name="<?php echo $inputCampo;?>" ondblclick="<?php echo $onClick;?>" placeholder="C&oacute;digo" type="text" class="txtbox55px" id="<?php echo $inputId;?>" autocomplete="off" onkeyup="clickDados<?php echo $inputId;?>(); " value="<?php echo $_GET['idAtual'];?>" style="width:60px; margin-bottom:2px; text-align:center;" />
	<input type="hidden" name="digitadoBusGen" id="digitadoBusGen<?php echo $inputId;?>" value="" />
    <span id="desc_<?php echo $inputId;?>"><?php echo '&nbsp;&nbsp;'.$_GET['label'];?></span>
    <a href="javascript:;" onclick="<?php echo $onClick;?>" title="Buscar <?php echo $tituloBusca;?>"><img src="images/Search.png" width="19" style="margin-bottom:-3px;" /></a>
    <iframe id="enviaBuscaGenerica<?php echo $inputId;?>" name="enviaBuscaGenerica<?php echo $inputId;?>" src="" style="width:0px;height:0px;border:0px;"></iframe>
<?php
}


function marcaSelectSelecionado($Marcados, $Atual) {
	
$Marcados = explode(', ', $Marcados);
for($i=0; $i < count($Marcados); $i++) {
if($Marcados[$i] == $Atual) {
	return("selected=\"selected\"");
	die; } // fim if
	} // fim for
}


function dataEscrita($data) {
	return(substr($data,8,2).' de '.exibe_mes(substr($data,5,2)).' de '.substr($data,0,4));
}


function mensagemVazio($var, $mensagem) {
	if($var == '') {
		return(texto($mensagem)); } else {
		return(texto($var)); }
}




function Loading($var) {

$script = "<script>

function loading() {
if(";

$gera = explode(", ",$var);
for ($i=0; $i< count($gera); $i++)  { 
$campos .= "document.getElementById('$gera[$i]').value == '' || ";
}

$campos = substr($campos,0,-3);

$script .= $campos.") { 
document.getElementById('Loading').innerHTML = ''; } else {
document.getElementById('Loading').innerHTML = '<img src=images/loading2.gif />'; }
}
</script>";
 
echo $script;
}




function valorCalculavel($valor) {
$formatado = str_replace('.','',$valor);
$formatado = str_replace(',','.',$formatado);
$formatado = str_replace('R$ ','',$formatado);
$formatado = str_replace('U$ ','',$formatado);

if(strpos(strrev($valor),',')) {
return(floatval($formatado));
} else {
return(floatval($valor)); }
}



function texto($var) {
$var = str_replace('&#8217;',"'",$var);
return(htmlentities($var, ENT_COMPAT, 'iso-8859-1')); }

///// FUNÇÃO PARA EXIBIÇÃO DE MESES
function exibe_mes($mes) {
    switch ($mes) {
      case "1": return "Janeiro"; break;
      case "2": return "Fevereiro"; break;
      case "3": return "Março"; break;
      case "4": return "Abril"; break;
      case "5": return "Maio"; break;
      case "6": return "Junho"; break;
      case "7": return "Julho"; break;
      case "8": return "Agosto"; break;
      case "9": return "Setembro"; break;
      case "10": return "Outubro"; break;
      case "11": return "Novembro"; break;
      case "12": return "Dezembro"; break;
      default: return "";
    }
  }
  
  function formaPagamento($caso){
	  switch($caso){
		  case "1": return "Dinheiro"; break;
		  case "2": return "Cheque"; break;
		  case "3": return "1x no Cartão"; break;
		  case "4": return "2x no Cartão"; break;
		  default: return "";
		  }
	  }
  
 /////// #######  EXIBIR STATUS #######  
  function ativo($status){
	  
	  switch($status){
		  case "A": return "Ativo"; break;
		  case "I": return "Inativo"; break;
		  default: return "";
		  }
	  }
	  
////// ######### FIM EXIBIR STATUS ########

function retira_acentos($texto) {

        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");

        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");

        return str_replace($array1, $array2, $texto);
    }

function upload($campo, $pasta, $array) {
	list($usec, $sec) = explode(" ", microtime());
	$tmp = (float)$usec + (float)$sec;	
	
	if($array == 'N' and $array != '0') {
		if($_FILES[$campo][name]) {
			$file = $_FILES[$campo];
			$file[name];
			$ext = substr($file[name],strrpos($file[name],"."));
			copy($file[tmp_name],$pasta."/$tmp-$campo-$array$ext");
			return("$tmp-$campo-$array$ext"); 
		} else { 
			return($_POST[$campo.'_Atual']); 
		} // hidden com a foto _Atual.
	} else {
		if($_FILES[$campo][name][$array]) {
			$file = $_FILES[$campo];
			$file[name][$array];
			$ext = substr($file[name][$array],strrpos($file[name][$array],"."));
			copy($file[tmp_name][$array],$pasta."/$tmp-$campo-$array$ext");
			return("$tmp-$campo-$array$ext"); 
		} else { 
			return($_POST[$campo.'_Atual'][$array]); 
		} // hidden com a foto _Atual.
	}
}




function uploadComMarca($campo, $pasta, $array) {
	global $database_conexao, $conexao;
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_config = "SELECT * FROM tbl_config";
	$rs_config = mysql_query($query_rs_config, $conexao) or die(mysql_error());
	$row_rs_config = mysql_fetch_assoc($rs_config);
	$totalRows_rs_config = mysql_num_rows($rs_config);

	list($usec, $sec) = explode(" ", microtime());
	$tmp = (float)$usec + (float)$sec;	
	
	if($array == 'N' and $array != '0') {
		echo 'Não tá ativo';
		/*if($_FILES[$campo][name]) {
			$file = $_FILES[$campo];
			$file[name];
			$ext = substr($file[name],strrpos($file[name],"."));
			copy($file[tmp_name],$pasta."/$tmp-$campo-$array$ext");
			return("$tmp-$campo-$array$ext"); 
		} else { 
			return($_POST[$campo.'_Atual']); 
		} // hidden com a foto _Atual.*/
	} else {
		if($_FILES[$campo]['name'][$array]) { // verifica se tem nova imagem cadastrada, senão vale a última
			include('class.upload.php');
			$foto = new upload($_FILES[$campo]['tmp_name'][$array]);
			
			// A foto foi enviada?
			if($foto->uploaded){
				$aprox = "650";
				$filename = $_FILES[$campo]['tmp_name'][$array];
				
				// Tamanho da imagem.
				list($width, $height, $type, $attr) = getimagesize($filename); 
				$x = $width;
				$y = $height;
			  
				if($x >= $y) {
					if($x > $aprox) {      
						$x1= (int)($x * ($aprox/$x));    
						$y1= (int)($y * ($aprox/$x));
					} else {
						$x1= $x;
						$y1= $y;
					}
				} else {
					if($y > $aprox) {
						$x1 = (int)($x * ($aprox/$y));
						$y1 = (int)($y * ($aprox/$y));
					} else {
						$x1= $x;
						$y1= $y;
					}
				}
				
				$x = $xImg = $x1;
				$y = $yImg = $y1;
			
				// Altero o tamanho da imagem
				$foto->image_x = $x;
				$foto->image_y = $y;
				$foto->image_crop = "0%";
				// estas opções abaixo colocam as opções personalizadas, como medida x ou y
				$foto->image_resize = true;
				//$foto->image_ratio_y = true;
				//$foto->image_y = 650;
				
				function getmicrotime(){
					list($usec, $sec) = explode(" ", microtime());
					return ((float)$usec + (float)$sec); 
				}
				
				$tmp = str_replace('.','',getmicrotime());
				
				$fotoBanco = $foto->file_new_name_body = $tmp;
				$fotoBanco = $fotoBanco.".jpg";
				$foto->image_convert = "jpg";
				$foto->jpeg_quality = 100;
				
				
								
				// se quiser que redimensiona $foto->image_resize = true;
				$marca = "../img_noticias/{$row_rs_config['marcaDagua']}";
				
				$foto->image_watermark = $marca; // só botar que é png ai pega kkk
				$foto->image_watermark_position = "R";
				
				/// Tamanho marca d'agua
				list($width, $height, $type, $attr) = getimagesize($marca); 
				$aprox = 100;
				$x = $width;
				$y = $height;
			  
				if($x >= $y) {
					if($x > $aprox) {      
						$x1 = (int)($x * ($aprox/$x));    
						$y1 = (int)($y * ($aprox/$x));
					} else {
						$x1 = $x;
						$y1 = $y;
					}
				} else {
					if($y > $aprox) {
						$x1 = (int)($x * ($aprox/$y));
						$y1 = (int)($y * ($aprox/$y));
					} else {
						$x1 = $x;
						$y1 = $y;
					}
				}
				
				// $foto->image_watermark_x = -10;
				// $foto->image_watermark_y = $yImg-$y1-10;
				// $foto->image_watermark_no_zoom_in = false;
				
				$foto->image_watermark_x = 230;
				$foto->image_watermark_y = 220;
				$foto->image_watermark_no_zoom_in = true;
				$foto->process("../img_noticias/");
		
				if($foto->processed){ } else {
					echo "Erro";
				}
				// limpar as informações de arquivos temp..
				$foto->clean();
			}
		}
		
		return($fotoBanco);
	}
}

  
function formataData($var) {
if($var <> '') {
return(substr($var,8,2).'/'.substr($var,5,2).'/'.substr($var,0,4)); } }

function formataDataSQL($var) {
return(substr($var,6,4).'-'.substr($var,3,2).'-'.substr($var,0,2)); }

} /// verifica include funções