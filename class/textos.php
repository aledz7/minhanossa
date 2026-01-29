<?php
if($TextosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Textos {

		private $pdo = null;  

		private static $Textos = null; 
	
		/*  
		* Construtor da classe como private  
		* @param $conexao - Conexão com o banco de dados  
		*/  
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Textos)):    
				self::$Textos = new Textos($conexao);   
			endif;
			return self::$Textos;    
		}
		
		var $titulo;
		var $textos;
		var $breve;
		var $foto;
		var $palavra_chave;
		
		function rsDados($id='', $pagInicial='') {

			global $conInstanciada, $InfoSiteInstanciada;
			
			if(file_exists('Connections/conexao.php')) {
				
				$infoSite = InfoSite2::getInstance(Conexao::getInstance())->rsDados();
				$sql_replace = " , replace(replace(tbl_textos.textos,'[telefone_site]','{$infoSite->telefone}'),'[email_loja]','{$infoSite->email}') as textos";
			}

			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($pagInicial == 'S') {
				$sql .= " and paginaInicial = ?"; 
				$nCampos++;
				$campo[$nCampos] = 'S'; // Valor
			}
			
			if($pagInicial == 'N') {
				$sql .= " and (paginaInicial is null or paginaInicial = ?)"; 
				$nCampos++;
				$campo[$nCampos] = 'N'; // Valor
			}
			
			try{   
				$sql = "SELECT tbl_textos.* {$sql_replace} FROM tbl_textos where 1=1 $sql ";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				
				if($id <> '') {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
		function desc_texto($id, $palavra_chave_foto='img') {
			global $conInstanciada;
			
			$desc_textos = $this->rsDados($id);
			if($desc_textos->foto <> '') { ?>
          		<img src="img_noticias/<?=$desc_textos->foto;?>" style="max-width:40%; float:left; margin-right:25px;" alt="<?=$_GET['nome'];?>">
          	<?php } ?>
			<div class="row">
		  	<?php echo $desc_textos->textos; ?>
		  	</div>
		  	<?php 
		  	include('class/fotos.php');
			$fotos = Fotos::getInstance(Conexao::getInstance());
		
			include('funcoes/cortar-imagem.php');

		  	$rs_fotos = $fotos->rsFotos($id, 'Textos');
		  	foreach($rs_fotos as $item) { ?>
          		<a href="img_noticias/<?=$item->foto;?>" id="zoom" rel="textos" class="col-md-3" style="margin-bottom:20px;" ><img src="img_noticias/<?php
          		echo cortaImagemSemFundo($item->foto, 'img_noticias', 640, 430, $palavra_chave_foto); ?>" alt="<?=$item->descricao?>"></a>
          	<?php }
			include('ferramentas/redes-sociais.php');
		}
		
		function seo_meta_tags($id='', $description='') {
			global $conInstanciada, $InfoSiteInstanciada, $HTMLInstanciada;
			
			include('class/html.php');
			$html = new HTML;
			
			if($description <> '') {
				$descricao = $description;
			} else {
				$descricao = $this->rsDados($id)->palavra_chave;
			}
			
			$html->seo_metas_tag($_GET['nome'], $_GET['nome'].' - '.$descricao);
		}
		
		function editar() {
			if($_POST['acao'] == 'editarTexto') {
				try{   
					$sql = "UPDATE tbl_textos SET titulo=?, textos=?, breve=?, palavra_chave=?, foto=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['titulo']);   
					$stm->bindValue(2, $_POST['textos']);   
					$stm->bindValue(3, $_POST['breve']);   
					$stm->bindValue(4, $_POST['palavra_chave']);   
					$stm->bindValue(5, upload('foto', '../img_noticias', 'N'));   
					$stm->bindValue(6, $_POST['id']);   
					$stm->execute();  
					
					echo "	<script>
							window.location='textos.php';
							</script>";
							exit;
				} catch(PDOException $erro){   
					echo $erro->getMessage();
				}
			}
		}
	}
	
	$TextosInstanciada = 'S';
}