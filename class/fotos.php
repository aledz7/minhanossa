<?php
@session_start();

if($FotosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Fotos {

		private $pdo = null;  

		private static $Fotos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Fotos)):    
				self::$Fotos = new Fotos($conexao);   
			endif;
			return self::$Fotos;    
		}
		
		
		function rsFotos($id='', $tipo='Conteudos', $orderBy='', $limite='') {
			
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id_galeria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($tipo <> '') {
				$sql .= " and tipo = ?"; 
				$nCampos++;
				$campo[$nCampos] = "{$tipo}";
			}
			
			
			if($orderBy <> '') {
				$sqlOrderBy = "order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0, {$limite}";
			}
		
			try {   
				$sql = "SELECT * FROM tbl_fotos where 1=1 $sql $sqlOrderBy $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados);
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
		function add() {
			if($_POST['acao'] == 'addFotos') {
				
				if($_SESSION['fotosUp'] <> '') {
					for($i=0; $i<count($_SESSION['fotosUp']); $i++) {
						$randLinha = rand(0,999999);
						$nomeBanco = $randLinha.str_replace(array(' ', '(', ')', 'jpeg', '+', '-',"'", '}', '{'), array('', '_', '_', 'jpg', '_', '_', "_", '', ''), retira_acentos($_SESSION['fotosUp'][$i]));
						$fotosOk[] = $nomeBanco;
						
						$novoCaminho = "../img_noticias/".$nomeBanco;
						
						if($_SESSION['fotosUp'][$i] <> '') {
							rename("jquery-upload-file-master/php/uploads/{$_SESSION['fotosUp'][$i]}", $novoCaminho);
						}
						//exit;
					}
					
					for($i=0; $i<=count($fotosOk); $i++) {
						if($fotosOk[$i] <> '') {	
							try {
								$sql = "INSERT INTO tbl_fotos (id_galeria, foto, tipo) VALUES (?, ?, ?)";   
								$stm = $this->pdo->prepare($sql);   
								$stm->bindValue(1, $_POST['id_conteudo']);   
								$stm->bindValue(2, $fotosOk[$i]);   
								$stm->bindValue(3, $_POST['tipo'].$_POST['id_conteudo']);   
								$stm->execute(); 
							} catch(PDOException $erro){
								echo $erro->getMessage();
							}
						}
					}
				}
				
				echo "	<script>
						window.location='fotos.php?id={$_POST['id_conteudo']}&tipo={$_POST['tipo']}'
						</script>";
						exit;
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirFoto') {
				// deleta foto
				if($_GET['foto'] <> '') {
					unlink ("../img_noticias/{$_GET['foto']}");
				}
				
				try{   
					$sql = "DELETE FROM tbl_fotos WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id_foto']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		
		
		function editarLegenda() {
			if($_GET['acao'] == 'editarLegendaFoto') {
				try{   
					$sql = "UPDATE tbl_fotos SET descricao=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['descricao']);   
					$stm->bindValue(2, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				exit;
			}
		}
		
	}
	
	$FotosInstanciada = 'S';
}