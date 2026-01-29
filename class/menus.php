<?php
if($MenusInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Menus {

		private $pdo = null;  

		private static $Menus = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Menus)):    
				self::$Menus = new Menus($conexao);   
			endif;
			return self::$Menus;    
		}
		
		function rsDados($id='', $lista='', $idIn='', $opcoesAdicionais='', $mostrar_em_produtos='', $vinculos_produtos='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($idIn <> '') {
				$sql .= " and tbl_menus.id in ({$idIn})"; 
			}
			
			if($lista <> '') {
				$sql .= " and lista = ?"; 
				$nCampos++;
				$campo[$nCampos] = $lista;
			}
			
			if($opcoesAdicionais <> '') {
				$sql .= " and opcoesAdicionaisCliente = ?"; 
				$nCampos++;
				$campo[$nCampos] = $opcoesAdicionais;
			}
			
			if($mostrar_em_produtos <> '') {
				$sql .= " and mostrar_em_produtos = ?"; 
				$nCampos++;
				$campo[$nCampos] = $mostrar_em_produtos;
			}
			
			if($vinculos_produtos <> '') {
				$sql .= " and vinculos_produtos = ?"; 
				$nCampos++;
				$campo[$nCampos] = $vinculos_produtos;
			}
			
			try{   
				$sql = "SELECT tbl_menus.* FROM tbl_menus where 1=1 $sql order by nome asc";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
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
	
	$MenusInstanciada = 'S';
}