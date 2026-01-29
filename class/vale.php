<?php
if($ValeInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Vale {
		
		private $pdo = null;  

		private static $Vale = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Vale)):    
				self::$Vale = new Vale($conexao);   
			endif;
			return self::$Vale;    
		}
		
		function rsDados($id='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			
			try{   
				$sql = "SELECT * FROM tbl_valos_desconto WHERE id is not null $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				//print_r($rsDados);
				if($id <> '' or $limite == 1) {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
		
		function add() {
			if($_POST['acao'] == 'addVale') {
				try{   
					$sql = "INSERT INTO tbl_valos_desconto (valor, porcentagem, codigo_vale, utilizado, data_utilizacao) VALUES (?, ?, ?, ?, ?)";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['valor']);   
					$stm->bindValue(2, $_POST['porcentagem']);   
					$stm->bindValue(3, $_POST['codigo_vale']);   
					$stm->bindValue(4, $_POST['utilizado']);   
					$stm->bindValue(5, $_POST['data_utilizacao']);   
					$stm->execute(); 
					$idConteudo = $this->pdo->lastInsertId();
					
					echo "	<script>
							window.location='vale-desconto.php';
							</script>";
							exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function editar() {
			if($_POST['acao'] == 'editarVale') {
				try{   
					$sql = "UPDATE tbl_valos_desconto SET valor=?, porcentagem=?, codigo_vale=?, utilizado=?, data_utilizacao=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['valor']);   
					$stm->bindValue(2, $_POST['porcentagem']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['codigo_vale']);   
					$stm->bindValue(4, $_POST['utilizado']);   
					$stm->bindValue(5, $_POST['data_utilizacao']);   
					$stm->bindValue(6, $_POST['id']);  
					$stm->execute(); 
					$idConteudo = $this->pdo->lastInsertId();
					
					echo "	<script>
							window.location='vale-desconto.php';
							</script>";
							exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirVale') {
				
				try{   
					$sql = "DELETE FROM tbl_valos_desconto WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$ValeInstanciada = 'S';
}