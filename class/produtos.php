<?php
if($ProdutosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Produtos {
		
		protected $filtros = array();
		protected $addWhere;
		
		protected $exibeRelacaoFiltroNome;
		protected $exibeRelacaoFiltroIdMenu;
		
		private $pdo = null;  

		private static $Produtos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Produtos)):    
				self::$Produtos = new Produtos($conexao);   
			endif;
			return self::$Produtos;    
		}
		
		public function add_filtro($filtro) {
			$this->filtros[] = $filtro;
		}
		
		public function add_exibeRelacaoFiltro($nome, $idMenuFiltro) {
			$this->exibeRelacaoFiltroNome[] = $nome;
			$this->exibeRelacaoFiltroIdMenu[] = $idMenuFiltro;
			//$this->exibe_relacao_filtro_id_lista_grupo[] = $id_lista_grupo;
		}
		
		public function ReiniciaAddExibeRelacaoFiltro() {
			unset($this->exibeRelacaoFiltroNome);
			unset($this->exibeRelacaoFiltroIdMenu);
		}
		
		function hiddenAcaoComprar($id_produto='') { 
			if($id_produto == '') {
				$id_produto = $_GET['id'];
			}
			?>
            <input type="hidden" name="acao" value="comprar">
          	<input type="hidden" name="id" value="<?=$id_produto;?>">
          	<?
		}
		
		function rsDados($id='', $orderBy='', $limite='', $id_categoria='', $promocao='', $id_sub_categoria='', $id_op_especificacao='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and tbl_pecas.id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($promocao <> '') {
				$sql .= " and tbl_pecas.promocao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $promocao;
			}
			
			if($id_categoria <> '') {
				$sql .= " and tbl_pecas.id_categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_categoria;
			}
			
			if($id_sub_categoria <> '') {
				$sql .= " and tbl_pecas.subcategoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_sub_categoria;
			}
			
			if($id_op_especificacao <> '') {
				$sql .= " and tbl_relaciona_produto_outras_especificacoes.id_opcao_especificacao = ?"; 
				$joins .= " left join tbl_relaciona_produto_outras_especificacoes on tbl_pecas.id = tbl_relaciona_produto_outras_especificacoes.id_produto";
				$nCampos++;
				$campo[$nCampos] = $id_op_especificacao;
			}
			
			if($_GET['busca'] <> '' and $_GET['acao'] == 'buscar') {
				$sql .= " and (tbl_pecas.nome like ? or tbl_categorias.titulo like ? or tbl_pecas.detalhes like ?)"; 
			}
		
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
				
				if($orderBy == 'mais_vendidos') {
					$sqlOrdem = " order by (select count(1) from tbl_pedidos_por_id_compra inner join tbl_compras on tbl_pedidos_por_id_compra.id_compra = tbl_compras.id where tbl_pecas.id = tbl_pedidos_por_id_compra.produto) desc";
				}
				
				if($orderBy == 'novidades') {
					$sqlOrdem = " order by tbl_pecas.id desc";
				}
				
				if($orderBy == 'vCrescente') {
					//$sqlOrdem = " order by tbl_pecas.preco_por asc";
					$sqlOrdem = " order by tbl_pecas.pontos1 asc";
				}
				
				if($orderBy == 'vDecrescente') {
					$sqlOrdem = " order by tbl_pecas.pontos1 desc";
				}
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
		
			// EXIBE CAMPOS
			foreach($this->filtros as $filtro) {
				if($filtro == 'lista_desejos') {
					$sql = " and (select count(1) from tbl_lista_desejos where tbl_lista_desejos.id_cliente = '{$_SESSION['dadosLogadoCLiente']->id}' and tbl_lista_desejos.id_produto = tbl_pecas.id) > 0";
				}
				if($filtro == 'lista_presentes') {
					$sql = " and (select count(1) from tbl_lista_presentes where tbl_lista_presentes.id_cliente = '{$_SESSION['dadosLogadoCLiente']->id}' and tbl_lista_presentes.id_produto = tbl_pecas.id) > 0";
				}
			}
			
			try{   
				$sql = "SELECT tbl_pecas.*, tbl_categoria.categoria as nomeCategoria FROM tbl_pecas left join tbl_categoria on tbl_pecas.categoria = tbl_categoria.id where 1=1 $sql $sqlOrdem $sqlLimite";
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
		
		function rs_categorias($tipo='categoria', $acao='') {
			
			if($tipo <> '') {
				$sql .= " and tbl_noticias.tipo = ?"; 
				$nCampos++;
				$campo[$nCampos] = $tipo;
			}
			
			if($acao == 'mais_categorias') {
				if($tipo == 'categoria') {
					$campo_filtro = 'id_categoria';
				} else {
					$campo_filtro = 'subcategoria';
				}
				
				$labels_adicionais .= ", (select count(1) from tbl_pecas where tbl_pecas.{$campo_filtro} = tbl_noticias.id) as total_produtos_cat, (select tbl_pecas.foto from tbl_pecas where tbl_pecas.{$campo_filtro} = tbl_noticias.id limit 0,1) as foto_produto";
				$sql .= " and (select count(1) from tbl_pecas where tbl_pecas.{$campo_filtro} = tbl_noticias.id) > 0"; 
			}
			
			try{   
				$sql = "SELECT tbl_noticias.* $labels_adicionais from tbl_noticias $joins where idMenu = 1 $sql $sqlOrdem $sqlLimite";
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
		
		function rsEspecificacoesDoProduto($id_produto='', $orderBy='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id_produto <> '') {
				$sql .= " and tbl_relaciona_produto_outras_especificacoes.id_produto = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_produto;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0, {$limite}";
			}
			
			try{   
				$sql = "SELECT tbl_noticias.titulo as especificacao, tbl_op_especificacao.titulo as nome_opcao_especificacao FROM tbl_noticias inner join tbl_relaciona_produto_outras_especificacoes on tbl_relaciona_produto_outras_especificacoes.id_especificacao = tbl_noticias.id and tbl_relaciona_produto_outras_especificacoes.id_opcao_especificacao <> 0 INNER join tbl_noticias as tbl_op_especificacao on tbl_op_especificacao.id = tbl_relaciona_produto_outras_especificacoes.id_opcao_especificacao where tbl_noticias.tipo = 'conteudos' and tbl_noticias.idMenu = '3' $sql $sqlOrdem $sqlLimite";
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
		
		function rsVerificaEspecificacao($id_produto='', $id_especificacao='', $id_opcao_especificacao='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id_produto <> '') {
				$sql .= " and tbl_relaciona_produto_outras_especificacoes.id_produto = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_produto;
			}
			
			if($id_especificacao <> '') {
				$sql .= " and tbl_relaciona_produto_outras_especificacoes.id_especificacao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_especificacao;
			}
			
			if($id_opcao_especificacao <> '') {
				$sql .= " and tbl_relaciona_produto_outras_especificacoes.id_opcao_especificacao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_opcao_especificacao;
			}
			
			try{   
				$sql = "SELECT count(1) as total FROM tbl_relaciona_produto_outras_especificacoes where 1=1 $sql ";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados[0]);
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
		function tem_variacao($id_produto='') {
			?>
            <input type="hidden" name="sistema_variacao" value="presente">
            <?
			/// FILTROS
			$nCampos = 0;
			
			if($id_produto <> '') {
				$sqlWhere .= " and tbl_noticias.tipo = 'variacoesProd".intval($id_produto)."'"; 
			}
					
			try{   
				$sql = "SELECT tbl_noticias.* FROM tbl_noticias where tipo = 'categoria' and idMenu = '2' ";
				$stm = $this->pdo->prepare($sql);
				$stm->execute();
				$rsCategorias = $stm->fetchAll(PDO::FETCH_OBJ);
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
			
			foreach($rsCategorias as $categoria) {
				try{   
					$sql = "SELECT tbl_noticias.* FROM tbl_noticias where categoria = '{$categoria->id}' $sqlWhere ";
					$stm = $this->pdo->prepare($sql);
					$stm->execute();
					$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
					
					if(count($rsDados) > 0) {
						$tem = 'S';
					}
				} catch(PDOException $erro){   
					echo $erro->getMessage(); 
				}
					
				if($tem <> '') {
					return('S');
				}
			}
		}
		
		function selectVariacoes($id_produto='', $exibicao='select') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id_produto <> '') {
				$sqlWhere .= " and tbl_noticias.tipo = 'variacoesProd".intval($id_produto)."'"; 
			}
					
			try{   
				$sql = "SELECT tbl_noticias.* FROM tbl_noticias where tipo = 'categoria' and idMenu = '2' ";
				$stm = $this->pdo->prepare($sql);
				$stm->execute();
				$rsCategorias = $stm->fetchAll(PDO::FETCH_OBJ);
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
			
			
			if($exibicao == 'select') {
				foreach($rsCategorias as $categoria) {
					try{   
						$sql = "SELECT tbl_noticias.* FROM tbl_noticias where categoria = '{$categoria->id}' $sqlWhere ";
						$stm = $this->pdo->prepare($sql);
						$stm->execute();
						$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
					} catch(PDOException $erro){   
						echo $erro->getMessage(); 
					}
						
					if(count($rsDados) > 0) {
					?>
<div class="form-group">
						<select class="form-control ordering" name="id_variacao[]">
						  <option selected="selected" value=""><?php echo $categoria->titulo;?></option>
						  <?php
							foreach($rsDados as $item) {
						  ?>
						  <option value="<?php echo $item->id;?>"><?php 
							echo $item->titulo;
							
							if($item->por <> '') {
								echo ' - R$ ' . number_format($item->por,2,',','.');
							}?></option>
						  <?php } ?>
						 
						</select>
					</div>
					<?php
					}
				}
			}
			
			
			if($exibicao == 'radio') {
				foreach($rsCategorias as $categoria) {
					try{   
						$sql = "SELECT tbl_noticias.* FROM tbl_noticias where categoria = '{$categoria->id}' $sqlWhere order by por ";
						$stm = $this->pdo->prepare($sql);
						$stm->execute();
						$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
					} catch(PDOException $erro){   
						echo $erro->getMessage(); 
					}
						
					if(count($rsDados) > 0) {
					?>
                    <table width="100%" border="0" class="table table-hover table-condensed borderless">
                      <tbody>
                        <?php
							foreach($rsDados as $item) {
						  ?>
                          <tr>
                        
                          <td width="11%" style="float:left; padding:5px;"><input type="radio" name="id_variacao[]" value="<?php echo $item->id; ?>"></td>
                          <td width="54%" style="float:left; color:rgba(0,0,0,1.00); padding:3px;"><?php 
							echo $item->titulo; ?></td>
                          <td width="35%" align="right" nowrap="nowrap" style="float:left; color:rgba(0,0,0,1.00); padding:3px;">R$ <?php 
							echo number_format($item->por,2,',','.');
							?></td>
                        </tr>
                        <? } ?>
                      </tbody>
                    </table>
					<?php
					}
				}
			}
			?>
            <input type="hidden" name="sistema_variacao" value="presente">
            <?
			
		}
		
		function selectOrdenar() { ?>
			<select name="ordernar" class="ct-select ct-select--full" id="ordernar" onChange="window.location='?&<?=$_SERVER['QUERY_STRING'];?>&ordenar='+this.value">
                <option value="novidades" <?php if($_GET['ordenar'] == 'novidades') { echo 'selected'; } ?>>Novidades</option>
                <option value="vCrescente" <?php if($_GET['ordenar'] == 'vCrescente') { echo 'selected'; } ?> >Valor Crescente</option>
                <option value="vDecrescente" <?php if($_GET['ordenar'] == 'vDecrescente') { echo 'selected'; } ?>>Valor Decrescente</option>
                <option value="mais_vendidos" <?php if($_GET['ordenar'] == 'mais_vendidos') { echo 'selected'; } ?>>Mais Vendidos</option>
              </select>
        <?
		}
		
		
		function add() {
			if($_POST['acao'] == 'addProdutos') {
				
				try{   
					$sql = "INSERT INTO tbl_pecas (nome, id_categoria, detalhes, peso, foto, preco_por, preco_de, ativo, breve_detalhes, subcategoria, estoque, codigo, mostrar_preco, venda_minima, itens_inclusos, especificacoes, fornecedor, promocao, palavras_chaves, altura, largura, comprimento, preco_de_atacado, preco_por_atacado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
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
		
		function add_lista_desejos() {
			$_SESSION['volta_login'] = $_SERVER['HTTP_REFERER'];
			
			if($_SESSION['dadosLogadoCLiente']->id == '') {
				echo "	<script>
						alert('Por favor. Primeiro realize seu login.');
						parent.window.location='../login.php?volta=lista_desejos';
						</script>";
						exit;
			}
			
			if($_GET['id_produto'] == '') {
				echo "	<script>
						alert('Erro: Parâmetro ".'$_GET["id_produto"]'." inexistente.');
						history.back();
						</script>";
						exit;
			}
			
			try{   
				$sql = "SELECT count(1) as total FROM tbl_lista_desejos where id_cliente = '{$_SESSION['dadosLogadoCLiente']->id}' and id_produto = '{$_GET['id_produto']}' ";
				$stm = $this->pdo->prepare($sql);
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				if($rsDados[0]->total > 0) {
					echo "	<script>
							alert('Este produto já está guardado em sua lista de desejos.');
							parent.history.back();
							</script>";
							exit;
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		
			try {   
				$sql = "INSERT INTO tbl_lista_desejos (id_cliente, id_produto) VALUES (?, ?)";   
				$stm = $this->pdo->prepare($sql);   
				$stm->bindValue(1, $_SESSION['dadosLogadoCLiente']->id);   
				$stm->bindValue(2, $_GET['id_produto']);   
				$stm->execute(); 
			} catch(PDOException $erro){
				echo $erro->getMessage(); 
			}
			
			echo "	<script>
					alert('Produto guardado na sua lista de desejos.');
					history.back();
					</script>";
					exit;
		}
		
		function excluir_lista_desejos() {
			if($_GET['acao'] == 'excluir_itemlista') {
				
				// deleta foto
				if($_GET['foto'] <> '') {
					unlink ("../img_noticias/{$_GET['foto']}");
				}
				
				try{   
					$sql = "DELETE FROM tbl_lista_desejos WHERE id_produto=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
		
		function link_lista_desejos($id) {
			return('checkout/add-lista-desejos.php?id_produto='.intval($id));
		}
		
		function editar() {
			
			if($_POST['acao'] == 'editarProdutos') {
				
				try{
					
					$sql = "UPDATE tbl_pecas SET nome=?, id_categoria=?, detalhes=?, foto=?, preco_por=?, preco_de=?, peso=?, breve_detalhes=?, subcategoria=?, estoque=?, venda_minima=?, itens_inclusos=?, especificacoes=?, fornecedor=?, promocao=?, parcelamento=?, valor_parcela=?, variacoes=?, sub_variacao=?, palavras_chaves=?, altura=?, largura=?, comprimento=?, ativo=?, marca=?, modelo=?, preco_por_atacado=?, preco_de_atacado=? WHERE id=?";   
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
					$sql = "DELETE FROM tbl_pecas WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}

		//Excluir item da lista de desejos.
		function excluir_item_desejo() {
			if($_GET['acao'] == 'excluirItemDesejo') {

				try{   
					$sql = "DELETE FROM tbl_lista_desejos WHERE id_cliente = ? and id_produto = ?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id_cliente']); 
					$stm->bindValue(2, $_GET['id_produto']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$ProdutosInstanciada = 'S';
}