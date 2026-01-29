<?php
if($CamposPersonalizadosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class CamposPersonalizados {

		private $pdo = null;  

		private static $CamposPersonalizados = null; 
	
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
		
		public static function getInstance($conexao){   
			if (!isset(self::$CamposPersonalizados)):    
				self::$CamposPersonalizados = new CamposPersonalizados($conexao);   
			endif;
			return self::$CamposPersonalizados;    
		}
		
		function rsDados($idMenu, $idConteudo='', $idCliente='') {
			
			if($idConteudo <> '') {
				$sql .= " and tbl_relaciona_campos.id_conteudo = :idConteudo";
			}
			
			if($idCliente <> '') {
				$sql .= " and tbl_relaciona_campos.id_cliente = :idCliente";
			}
			
			if($idConteudo <> '' or $idCliente) {
				$joins .= "left join tbl_relaciona_campos on tbl_campos_personalizados.id = tbl_relaciona_campos.id_campo {$sql}";
				$exibirCampos .= ', tbl_relaciona_campos.valor';
			}
			
			try{   
				$sql = "SELECT tbl_campos_personalizados.* $exibirCampos FROM tbl_campos_personalizados $joins WHERE (tbl_campos_personalizados.ids_menu = :idMenu or tbl_campos_personalizados.ids_menu LIKE :idMenu) order by tbl_campos_personalizados.ordem asc";
				$stm = $this->pdo->prepare($sql);
				$stm->bindValue(':idMenu', $idMenu);
				$stm->bindValue(':idMenu', '%'.$idMenu.'%');
				
				if($idConteudo <> '') {
					$stm->bindValue(':idConteudo', $idConteudo, PDO::PARAM_INT);
				}
				
				if($idCliente <> '') {
					$stm->bindValue(':idCliente', $idCliente, PDO::PARAM_INT);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados);
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
	}
	
	$CamposPersonalizadosInstanciada = 'S';
}