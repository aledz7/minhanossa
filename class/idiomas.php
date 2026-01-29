<?php
@ session_start();

if($IdiomasInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Idiomas {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		private $pdo = null;  

		private static $Idiomas = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Idiomas)):    
				self::$Idiomas = new Idiomas($conexao);   
			endif;
			return self::$Idiomas;    
		}
		
		function rsDados($id='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and tbl_idiomas.id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			try {   
				$sql = "SELECT tbl_idiomas.* FROM tbl_idiomas where 1=1 $sql $sqlOrdem $sqlLimite";
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
	
	}
	
	$IdiomasInstanciada = 'S';
}