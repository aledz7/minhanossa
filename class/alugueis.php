<?php
if($AlugueisInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Alugueis {
		
		protected $filtros = array();
		protected $addWhere;
		
		protected $exibeRelacaoFiltroNome;
		protected $exibeRelacaoFiltroIdMenu;
		
		private $pdo = null;  

		private static $Alugueis = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Alugueis)):    
				self::$Alugueis = new Alugueis($conexao);   
			endif;
			return self::$Alugueis;    
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
				$sql .= " and codigo_cliente = ?"; 
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
				$sql = "SELECT * FROM tbl_contrato where 1=1 $sql $sqlOrdem $sqlLimite";
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
		
		
		
		function add() {
			if($_POST['acao'] == 'addProdutos') {
				
				try{   
					$sql = "INSERT INTO tbl_produto (nome, id_categoria, detalhes, peso, foto, preco_por, preco_de, ativo, breve_detalhes, subcategoria, estoque, codigo, mostrar_preco, venda_minima, itens_inclusos, especificacoes, fornecedor, promocao, palavras_chaves, altura, largura, comprimento, preco_de_atacado, preco_por_atacado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['id_categoria']);   
					$stm->bindValue(3, $_POST['detalhes']);   
					$stm->bindValue(4, valorCalculavel($_POST['peso']));   
					$stm->bindValue(5, upload('foto', '../img_noticias', 'N'));   
					$stm->bindValue(6, valorCalculavel($_POST['preco_por']));   
					$stm->bindValue(7, valorCalculavel($_POST['preco_de']));   
					$stm->bindValue(8, $_POST['ativo']);   
					$stm->bindValue(9, $_POST['breve_detalhes']);   
					$stm->bindValue(10, ($_POST['idSub'][0] <> '') ? $_POST['idSub'][0] : NULL);  
					$stm->bindValue(11, $_POST['estoque']);   
					$stm->bindValue(12, $_POST['codigo']);   
					$stm->bindValue(13, $_POST['mostrar_preco']);   
					$stm->bindValue(14, $_POST['venda_minima']);   
					$stm->bindValue(15, $_POST['itens_inclusos']);   
					$stm->bindValue(16, $_POST['especificacoes']);   
					$stm->bindValue(17, $_POST['fornecedor']);   
					$stm->bindValue(18, $_POST['promocao']);   
					$stm->bindValue(19, $_POST['palavras_chaves']);   
					$stm->bindValue(20, $_POST['altura']);   
					$stm->bindValue(21, $_POST['largura']);   
					$stm->bindValue(22, $_POST['comprimento']); 
					$stm->bindValue(23, valorCalculavel($_POST['preco_de_atacado']));   
					$stm->bindValue(24, valorCalculavel($_POST['preco_por_atacado']));     
					$stm->execute(); 
					$idProduto = $this->pdo->lastInsertId();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				if($_POST['idsFiltros'] <> '') {
					$filtros = explode(', ', $_POST['idsFiltros']);
					//$grupos = explode(', ', $_POST['ids_campos_grupos']);
					
					for($i=0; $i<count($filtros); $i++) {
						try{   
							$sql = "INSERT INTO tbl_relaciona_filtros (id_produto, id_menuFiltro, id_filtro, id_lista_grupo) VALUES (?, ?, ?, ?)";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $idProduto);   
							$stm->bindValue(2, $filtros[$i]);   
							$stm->bindValue(3, $_POST['id_filtro'.$filtros[$i].$grupos[$i]][0]);   
							$stm->bindValue(4, $grupos[$i]);   
							$stm->execute();
						} catch(PDOException $erro){
							echo $erro->getMessage(); 
						}
					}
				}
				
				// Outras Especificações
				if($_POST['id_especificacao'] <> '') {
					foreach($_POST['id_especificacao'] as $i => $id_especificacao) {
						try{   
							$sql = "INSERT INTO tbl_relaciona_produto_outras_especificacoes (id_especificacao, id_opcao_especificacao, id_produto) VALUES (?, ?, ?)";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $id_especificacao);   
							$stm->bindValue(2, $_POST['id_opcao_especificacao'][$i]);
							$stm->bindValue(3, $idProduto);
							$stm->execute(); 
							$idEspecificacao = $this->pdo->lastInsertId();
						} catch(PDOException $erro){
							echo $erro->getMessage(); 
						}
					}
				}
				
				echo "	<script>
						if(confirm('Deseja incluir mais fotos neste produto?')) {
							window.location='fotos.php?id={$idProduto}&tipo=Produtos';
						} else {
							window.location='produtos.php';
						}
						</script>";
						exit;
			}
		}
		
		function editar() {
			
			if($_POST['acao'] == 'editarProdutos') {
				
				try{
					
					$sql = "UPDATE tbl_produto SET nome=?, id_categoria=?, detalhes=?, foto=?, preco_por=?, preco_de=?, peso=?, breve_detalhes=?, subcategoria=?, estoque=?, venda_minima=?, itens_inclusos=?, especificacoes=?, fornecedor=?, promocao=?, parcelamento=?, valor_parcela=?, variacoes=?, sub_variacao=?, palavras_chaves=?, altura=?, largura=?, comprimento=?, ativo=?, marca=?, modelo=?, preco_por_atacado=?, preco_de_atacado=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['id_categoria']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['detalhes']);   
					$stm->bindValue(4, upload('foto', '../img_noticias', 'N'));   
					$stm->bindValue(5, valorCalculavel($_POST['preco_por']));   
					$stm->bindValue(6, valorCalculavel($_POST['preco_de']));  
					$stm->bindValue(7, $_POST['peso']);   
					$stm->bindValue(8, $_POST['breve_detalhes']);   
					$stm->bindValue(9, ($_POST['idSub'][0] <> '') ? $_POST['idSub'][0] : NULL);   
					$stm->bindValue(10, $_POST['estoque']);   
					$stm->bindValue(11, $_POST['venda_minima']);   
					$stm->bindValue(12, $_POST['itens_inclusos']);   
					$stm->bindValue(13, $_POST['especificacoes']);   
					$stm->bindValue(14, $_POST['fornecedor']);   
					$stm->bindValue(15, $_POST['promocao']);   
					$stm->bindValue(16, $_POST['parcelamento']);   
					$stm->bindValue(17, $_POST['valor_parcela']);   
					$stm->bindValue(18, $_POST['variacoes']);   
					$stm->bindValue(19, $_POST['sub_variacao']);   
					$stm->bindValue(20, $_POST['palavras_chaves']);   
					$stm->bindValue(21, $_POST['altura']);   
					$stm->bindValue(22, $_POST['largura']);   
					$stm->bindValue(23, $_POST['comprimento']);   
					$stm->bindValue(24, $_POST['ativo']);   
					$stm->bindValue(25, $_POST['marca']);   
					$stm->bindValue(26, $_POST['modelo']);   
					$stm->bindValue(27, valorCalculavel($_POST['preco_por_atacado']));   
					$stm->bindValue(28, valorCalculavel($_POST['preco_de_atacado']));  
					$stm->bindValue(29, $_POST['id']);     
					$stm->execute();  
					$idConteudo = $this->pdo->lastInsertId();
					
					// CADASTRA FILTROS
					if($_POST['idsFiltros'] <> '') {
						try{   
							$sql = "DELETE FROM tbl_relaciona_filtros WHERE id_produto=?";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $_POST['id']);   
							$stm->execute();
						} catch(PDOException $erro){
							echo $erro->getMessage(); 
						}
					}
					
					if($_POST['idsFiltros'] <> '') {
						$filtros = explode(', ', $_POST['idsFiltros']);
						//$grupos = explode(', ', $_POST['ids_campos_grupos']);
						
						for($i=0; $i<count($filtros); $i++) {
							try{   
								$sql = "INSERT INTO tbl_relaciona_filtros (id_produto, id_menuFiltro, id_filtro, id_lista_grupo) VALUES (?, ?, ?, ?)";   
								$stm = $this->pdo->prepare($sql);   
								$stm->bindValue(1, $_POST['id']);   
								$stm->bindValue(2, $filtros[$i]);   
								$stm->bindValue(3, $_POST['id_filtro'.$filtros[$i].$grupos[$i]][0]);   
								$stm->bindValue(4, $grupos[$i]);   
								$stm->execute();
							} catch(PDOException $erro){
								echo $erro->getMessage(); 
							}
						}
					}
						
					
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				// Outras Especificações
				try{   
					$sql = "DELETE FROM tbl_relaciona_produto_outras_especificacoes WHERE id_produto = ? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				if(count($_POST['id_especificacao']) > 0) {
					foreach($_POST['id_especificacao'] as $i => $id_especificacao) {
						try{   
							$sql = "INSERT INTO tbl_relaciona_produto_outras_especificacoes (id_especificacao, id_opcao_especificacao, id_produto) VALUES (?, ?, ?)";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $id_especificacao);   
							$stm->bindValue(2, $_POST['id_opcao_especificacao'][$i]);
							$stm->bindValue(3, $_POST['id']);
							$stm->execute(); 
							$idEspecificacao = $this->pdo->lastInsertId();
						} catch(PDOException $erro){
							echo $erro->getMessage(); 
						}
					}
				}
				
				echo "	<script>
						window.location='produtos.php';
						</script>";
						exit;
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirProduto') {
				
				// deleta foto
				if($_GET['foto'] <> '') {
					unlink ("../img_noticias/{$_GET['foto']}");
				}
				
				try{   
					$sql = "DELETE FROM tbl_produto WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$AlugueisInstanciada = 'S';
}