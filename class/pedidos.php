<?php
if($PedidosInstanciada == '') {
	if(file_exists('Connections/con-pdo.php')) {
		include('funcoes.php');
		if(file_exists('class/info-site.php')) {
			include('class/info-site.php');
		} else {
			include('../class/info-site.php');
		}
	} else {
		include('../funcoes.php');
		include('../class/info-site.php');
	}
	
	include(dirname(__FILE__).'/../funcoes/enviar-email.php');
	
	class Pedidos {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		private $pdo = null;  

		private static $Pedidos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Pedidos)):    
				self::$Pedidos = new Pedidos($conexao);   
			endif;
			return self::$Pedidos;    
		}
		
		/*public function add_exibeCampos($campo) {
			$this->exibeCampos[] = $campo;
		}*/
		
		function dadosCarrinho() {
			if($_SESSION['compra'] <> '') {
				$tensCarrinho = $this->rsItens($_SESSION['compra']);
			
				foreach($tensCarrinho as $itens) {
					$totalCarrinho += ($itens->valor_c_acrecimo*$itens->qtd);
					$qtdCarrinho += $itens->qtd;
				}
			}
			
			$dados = (object) array('qtd' => intval($qtdCarrinho), 'total' => floatval($totalCarrinho));
			return($dados);
		}
		
		function rsDados($id='', $fechado='S', $orderBy='id desc', $status='', $idCliente='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and tbl_compras.id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($fechado <> '') {
				$sql .= " and tbl_compras.fechado = ?"; 
				$nCampos++;
				$campo[$nCampos] = $fechado;
			}
			
			if($status <> '') {
				$sql .= " and tbl_compras.status = ?"; 
				$nCampos++;
				$campo[$nCampos] = $status;
			}
			
			if($idCliente <> '') {
				$sql .= " and tbl_compras.id_cliente = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idCliente;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "
				SELECT 
					tbl_compras.*, 
					tbl_users.nome as nomeCliente, 
					tbl_users.email as email_cliente, 
					tbl_status.status as nomeStatus 
				FROM 
					tbl_compras 
					left join tbl_users on tbl_compras.id_cliente = tbl_users.id 
					left join tbl_status on tbl_compras.status = tbl_status.id 
				where 
					1=1 
					$sql 
					$sqlOrdem 
					$sqlLimite";
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
		
		
		function rsStatus($id='', $orderBy='status asc') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and tbl_status.id = ?"; 
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
				$sql = "
				SELECT 
					tbl_status.*
				FROM 
					tbl_status
				where 
					1=1 
					$sql 
					$sqlOrdem 
					$sqlLimite";
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
		
		
		function rsItens($id_compra='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id_compra <> '') {
				$sql .= " and tbl_pedidos_por_id_compra.id_compra = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_compra;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT tbl_pedidos_por_id_compra.*, tbl_pedidos_por_id_compra.produto as id_produto, tbl_pedidos_por_id_compra.valor_c_acrecimo as valor, tbl_produtos.nome as nomeProduto, tbl_produtos.nome,  tbl_produtos.peso, tbl_produtos.altura, tbl_produtos.largura, tbl_produtos.comprimento, tbl_produtos.foto, tbl_produtos.estoque FROM tbl_pedidos_por_id_compra left join tbl_produtos on tbl_pedidos_por_id_compra.produto = tbl_produtos.id where 1=1 $sql $sqlOrdem $sqlLimite";
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
		
		
		function editar() {
			if($_POST['acao'] == 'editarPedidos') {
				try{   
					$sql = "UPDATE tbl_compras SET status=?, protocolo_entrega=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['id_status']);   
					$stm->bindValue(2, $_POST['protocolo_entrega']);   
					$stm->bindValue(3, $_POST['id']);   
					$stm->execute(); 
					$idConteudo = $this->pdo->lastInsertId();
					
					if($_POST['id_status_atual'] <> $_POST['id_status']) {
						
						$dados_pedido = $this->rsDados($_POST['id']);
						$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();
						
						$layout = file_get_contents("layout-alteracao-status.html");
						$layout = str_replace('[codigo_pedido]', $_POST['id'], $layout);
						$layout = str_replace('[nome_cliente]', $dados_pedido->nomeCliente, $layout);
						$layout = str_replace('[status_pagamento]', $dados_pedido->nomeStatus, $layout);
						$layout = str_replace('[data_pedido]', formataData($dados_pedido->data), $layout);
						$layout = str_replace('[mensagem_codigo_rastreio]', ($_POST['protocolo_entrega'] <> '') ? "Seu código de rastreio é: {$_POST['protocolo_entrega']}" : 'Assim que seu produto for postado você receberá um e-mail com o código de postagem.', $layout);
						$layout = str_replace('[nome_site]', $infoSite->nome, $layout);
						$layout = str_replace('[telefone_site]', $infoSite->telefone, $layout);
						$layout = str_replace('[email_site]', $infoSite->email, $layout);
						$layout = str_replace('[endereco_site]', 'www.'.str_replace('www.','',$_SERVER['HTTP_HOST']), $layout);
						
						EnviarEmail('Alteração do Pedido: '.$_POST['id'], $infoSite->nome, $infoSite->email, $dados_pedido->email_cliente, $infoSite->email, $layout, 'N');
					}
					
					echo "	<script>
							window.location='pedidos.php';
							</script>";
							exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirPedidos') {
				
				try{   
					$sql = "DELETE FROM tbl_compras WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$PedidosInstanciada = 'S';
}