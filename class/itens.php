<?php
if($ItensInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Itens {
		
		protected $filtros = array();
		protected $addWhere;
		
		protected $exibeRelacaoFiltroNome;
		protected $exibeRelacaoFiltroIdMenu;
		
		private $pdo = null;  

		private static $Itens = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Itens)):    
				self::$Itens = new Itens($conexao);   
			endif;
			return self::$Itens;    
		}
		
	
		
		function rsDados($id='', $id_cliente='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($id_cliente <> '') {
				$sql .= " and id_cliente = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_cliente;
			}
			
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
				
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
		
			
			try{   
				$sql = "SELECT * FROM tbl_item where 1=1 $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				if($_GET['busca'] <> '') {
					$stm->bindValue($i, "%{$_GET['busca']}%");
					$i++;
					$stm->bindValue($i, "%{$_GET['busca']}%");
					$i++;
					$stm->bindValue($i, "%{$_GET['busca']}%");
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
		
		
	}
	
	$ItensInstanciada = 'S';
}