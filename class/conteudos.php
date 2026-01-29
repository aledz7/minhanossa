<?php
if($conteudosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Conteudos {
		
		protected $exibeCampos = array();
		
		protected $buscaCampo = array();
		protected $buscaCampoValor = array();
		
		protected $buscaVinculoRaiz = array();
		protected $buscaVinculoRaizValor = array();
		
		protected $camposPersonalizados = array();
		protected $nomeCamposPersonalizados = array();
		
		protected $exibeRelacaoFiltroNome;
		protected $exibeRelacaoFiltroIdMenu;
		
		protected $addWhere;
		
		protected $filtroCatProdutoComEspecificao;
		
		private $pdo = null;  

		private static $Conteudos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Conteudos)):    
				self::$Conteudos = new Conteudos($conexao);   
			endif;
			return self::$Conteudos;    
		}
		
		var $titulo;
		var $data;
		var $noticia;
		var $categoria;
		var $foto;
		var $destaque;
		var $arquivo;
		var $idMenu;
		var $tipo;
		var $id_cliente;
		var $de;
		var $por;
		var $breve;
		var $link;
		var $breve2;
		var $ordem;
		var $id_idioma;
		var $id_conteudoPrincipal;
		var $ultimaAtualizacao;
		var $id_estado;
		var $id_cidade;
		var $id_subcat;
		var $fortawesome_icone;
		var $breve3;
		var $id_select_adicional;
		var $ativo;
		
		public function add_exibeCampos($campo) {
			$this->exibeCampos[] = $campo;
		}
		
		public function ReiniciaBuscaCampo() {
			unset($this->buscaCampo);
			unset($this->buscaCampoValor);
		}
		
		public function buscaCampo($campo, $valorBusca) {
			$this->buscaCampo[] = $campo;
			$this->buscaCampoValor[] = $valorBusca;
		}
		
		public function busca_filtro($campo, $valorBusca) {
			$this->busca_filtro[] = $campo;
			$this->busca_filtro_valor[] = $valorBusca;
		}
		
		public function reinicia_busca_filtro() {
			unset($this->busca_filtro);
			unset($this->busca_filtro_valor);
		}
		
		public function ReiniciaBuscaVinculoRaiz() {
			unset($this->buscaVinculoRaiz);
			unset($this->buscaVinculoRaizValor);
		}
		
		public function buscaVinculoRaiz($campo, $valorBusca) {
			$this->buscaVinculoRaiz[] = $campo;
			$this->buscaVinculoRaizValor[] = $valorBusca;
		}
		
		public function ReiniciaAddCamposPersonalizados() {
			unset($this->camposPersonalizados);
			unset($this->nomeCamposPersonalizados);
		}
		
		public function add_campoPersonalizado($campo, $asCampoNome) {
			$this->camposPersonalizados[] = $campo;
			$this->nomeCamposPersonalizados[] = $asCampoNome;
		}
		
		public function add_exibeRelacaoFiltro($nome, $idMenuFiltro, $id_lista_grupo='') {
			$this->exibeRelacaoFiltroNome[] = $nome;
			$this->exibeRelacaoFiltroIdMenu[] = $idMenuFiltro;
			$this->exibe_relacao_filtro_id_lista_grupo[] = $id_lista_grupo;
		}
		
		public function ReiniciaAddExibeRelacaoFiltro() {
			unset($this->exibeRelacaoFiltroNome);
			unset($this->exibeRelacaoFiltroIdMenu);
		}
		
		public function add_where($andWhere) {
			$this->addWhere = $andWhere;
		}
		
		public function ReiniciaAddFiltroCatProdutoComEspecificao() {
			$this->filtroCatProdutoComEspecificao = '';
		}
		
		public function add_filtroCatProdutoComEspecificao($categoria) {
			$this->filtroCatProdutoComEspecificao = $categoria;
		}
		
		public function add_query_paginacao($n_pagina=1, $limite_pagina=20) {
			$this->n_pagina = $n_pagina;
			$this->limite_pagina = $limite_pagina;
		}
		
		public function retira_query_paginacao() {
			unset($this->n_pagina);
			unset($this->limite_pagina);
		}	
		
		function data_extenso($data) {
			return(substr($data,8,2).' de '.exibe_mes(substr($data,5,2)).' de '.substr($data,0,4));
		}
		
		function rsDados($idMenu='', $id='', $orderBy='', $tipo="", $limite='', $categoria='', $oferta='', $destaque='', $select_adicional='', $subcategoria='', $idIdioma='', $idCliente='', $idIn='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($idMenu <> '') {
				$sql .= " and tbl_noticias.idMenu = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idMenu;
			}
			
			if($_SESSION['id_idioma'] <> '' and $idIdioma == '') {
				$sql .= " and tbl_noticias.id_idioma = ?"; 
				$nCampos++;
				$campo[$nCampos] = $_SESSION['id_idioma'];
			}
			
			if($idIdioma == '' and $_SESSION['id_idioma'] == '') {
				$idIdioma = 1;
			}
			
			if($_SESSION['id_idioma'] == '1' or $idIdioma == '1') {
				$labelCamposAdds .= ", tbl_noticias.id as id_conteudoPrincipal";
			}
			
			if($idIdioma <> '') {
				$sql .= " and tbl_noticias.id_idioma = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idIdioma;
			}
			
			if($idCliente <> '') {
				$sql .= " and tbl_noticias.id_cliente = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idCliente;
			}
			
			if($id <> '') {
				$sql .= " and (tbl_noticias.id = ? or tbl_noticias.id_conteudoPrincipal = ?)"; 
				$nCampos++;
				$campo[$nCampos] = $id;
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($idIn <> '') {
				$sql .= " and tbl_noticias.id in (?)"; 
				$nCampos++;
				$campo[$nCampos] = $idIn;
			}
			
			if($tipo <> '') {
				$sql .= " and tbl_noticias.tipo = ?"; 
				$nCampos++;
				$campo[$nCampos] = $tipo;
			}
			
			if($categoria <> '') {
				$sql .= " and tbl_noticias.categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $categoria;
			}
			
			if($subcategoria <> '') {
				$sql .= " and tbl_noticias.id_subcat = ?"; 
				$nCampos++;
				$campo[$nCampos] = $subcategoria;
			}
			
			if($select_adicional <> '') {
				$sql .= " and tbl_noticias.id_select_adicional = ?"; 
				$nCampos++;
				$campo[$nCampos] = $select_adicional;
			}
			
			if($oferta <> '') {
				$sql .= " and tbl_noticias.promocao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $oferta;
			}
			
			if($destaque <> '') {
				$sql .= " and tbl_noticias.destaque = ?"; 
				$nCampos++;
				$campo[$nCampos] = $destaque;
			}
			
			if($_GET['busca'] <> '') {
				$sql .= " and (tbl_noticias.titulo like ? or tbl_noticias.noticia like ? or tbl_noticias.breve like ?)"; 
			}
			
			if($this->filtroCatProdutoComEspecificao <> '') {
				$sql .= " and (select COUNT(1) from tbl_relaciona_produto_outras_especificacoes left join tbl_produtos on tbl_relaciona_produto_outras_especificacoes.id_produto = tbl_produtos.id where tbl_relaciona_produto_outras_especificacoes.id_opcao_especificacao = tbl_noticias.id and tbl_produtos.id_categoria = ?) > 0"; 
				$nCampos++;
				$campo[$nCampos] = $this->filtroCatProdutoComEspecificao;
			}
			
			// OUTRAS BUSCAS
			if($this->buscaCampo <> '') {
				foreach($this->buscaCampo as $campoBusca) {
					$iBusca++;
					$valorCampoBusca = $this->buscaCampoValor[($iBusca-1)];
					
					if($valorCampoBusca <> '') {
						if($campoBusca == 'data') {
							$sql .= " and tbl_noticias.data = ?"; 
							$nCampos++;
							$campo[$nCampos] = $valorCampoBusca;
						}
						
						if($campoBusca == 'ativo') {
							$sql .= " and tbl_noticias.ativo = '$valorCampoBusca'"; 
						}
						
						if($campoBusca == 'breve') {
							$sql .= " and tbl_noticias.breve = ?"; 
							$nCampos++;
							$campo[$nCampos] = $valorCampoBusca;
						}
						
						if($campoBusca == 'cidade') {
							$sql .= " and tbl_noticias.id_cidade = ?"; 
							$nCampos++;
							$campo[$nCampos] = $valorCampoBusca;
						}
						
						if($campoBusca == 'estado') {
							$sql .= " and tbl_noticias.id_estado = ".intval($valorCampoBusca); 
						}
					}
				}
			}
			
			// OUTRAS BUSCAS
			if($this->busca_filtro <> '') {
				$i_busca_filtro = 0;
				foreach($this->busca_filtro as $campoBusca) {
					if($this->busca_filtro_valor[$i_busca_filtro] <> '') {
						$joins .= " left join tbl_relaciona_filtros as tbl_rel_filtro_{$campoBusca} on tbl_noticias.id = tbl_rel_filtro_{$campoBusca}.id_conteudo and tbl_rel_filtro_{$campoBusca}.id_menuFiltro = {$campoBusca} ";
						$sql .= " and tbl_rel_filtro_{$campoBusca}.id_filtro = ".intval($this->busca_filtro_valor[$i_busca_filtro]); 
					}
					$i_busca_filtro++;
				}
			}
			
			
			// BUSCA VINCULO RAIZ
			if($this->buscaVinculoRaiz <> '') {
				foreach($this->buscaVinculoRaiz as $campoBusca) {
					$iBuscaVinculo++;
					$valorCampoBusca = $this->buscaVinculoRaizValor[($iBuscaVinculo-1)];
					
					$joins .= " left join tbl_noticias as tbl_vinculo_{$campoBusca} on tbl_noticias.id = substring(tbl_vinculo_{$campoBusca}.tipo, 10)";

					if($campoBusca == 'data') {
						$sql .= " and date(tbl_vinculo_{$campoBusca}.{$campoBusca}) = ?";
					} else {
						$sql .= " and tbl_vinculo_{$campoBusca}.{$campoBusca} = ?";
					}
					$nCampos++;
					$campo[$nCampos] = $valorCampoBusca; 
				}
			}
			
			// BUSCA FILTRO
			if($this->exibeRelacaoFiltroNome <> '') {
				foreach($this->exibeRelacaoFiltroNome as $i => $nome) {
					
					if($this->exibe_relacao_filtro_id_lista_grupo[$i] <> '') {
						$sql_lista_grupo = " and tbl_rel_filtro_{$nome}.id_lista_grupo = {$this->exibe_relacao_filtro_id_lista_grupo[$i]}  ";
					}
					
					$joins .= " 
						left join tbl_relaciona_filtros as tbl_rel_filtro_{$nome} on tbl_noticias.id = tbl_rel_filtro_{$nome}.id_conteudo and tbl_rel_filtro_{$nome}.id_menuFiltro = {$this->exibeRelacaoFiltroIdMenu[$i]} $sql_lista_grupo
						left join tbl_noticias as tbl_filtro_{$nome} on tbl_rel_filtro_{$nome}.id_filtro = tbl_filtro_{$nome}.id";
					$labelCamposAdds .= ", tbl_filtro_{$nome}.titulo as nome_{$nome}, tbl_filtro_{$nome}.breve as breve_{$nome}, tbl_filtro_{$nome}.por as por_{$nome}, tbl_filtro_{$nome}.id as id_{$nome}";
				}
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			
			// EXIBE CAMPOS
			foreach($this->exibeCampos as $campoAdicional) {
				if($campoAdicional == 'categoria') {
					$joins .= " left join tbl_noticias as tbl_categorias on tbl_noticias.categoria = tbl_categorias.id";
					$labelCamposAdds .= ", tbl_categorias.titulo as nome_{$campoAdicional}";
				}
				
				if($campoAdicional == 'sub_categoria') {
					$joins .= " left join tbl_noticias as tbl_sub_categorias on tbl_noticias.id_subcat = tbl_sub_categorias.id";
					$labelCamposAdds .= ", tbl_sub_categorias.titulo as nome_{$campoAdicional}";
				}
				
				if($campoAdicional == 'select_adicional') {
					$joins .= " left join tbl_noticias as tbl_select_adicional on tbl_noticias.id_select_adicional = tbl_select_adicional.id";
					$labelCamposAdds .= ", tbl_select_adicional.titulo as nome_{$campoAdicional}";
				}
				
				if($campoAdicional == 'estado') {
					$joins .= " left join dados_estados on tbl_noticias.id_estado = dados_estados.id";
					$labelCamposAdds .= ", dados_estados.nome as nome_{$campoAdicional}, dados_estados.uf as nome_uf";
				}
				
				if($campoAdicional == 'uf') {
					$joins .= " left join dados_estados on tbl_noticias.id_estado = dados_estados.id";
					$labelCamposAdds .= ", dados_estados.uf as nome_{$campoAdicional}";
				}
				
				if($campoAdicional == 'cidade') {
					$joins .= " left join dados_cidades on tbl_noticias.id_cidade = dados_cidades.id";
					$labelCamposAdds .= ", dados_cidades.nome as nome_{$campoAdicional}";
				}
				
				if($campoAdicional == 'cliente') {
					$joins .= " left join tbl_users on tbl_noticias.id_cliente = tbl_users.id";
					$labelCamposAdds .= ", tbl_users.nome as nome_{$campoAdicional}";
				}
			}
			
			// EXIBE CAMPOS PERSONALIZADOS
			if($this->camposPersonalizados <> '') {
				foreach($this->camposPersonalizados as $idCampoPersonalizado) {
					$iCampo++;
					$nomeCampo = $this->nomeCamposPersonalizados[($iCampo-1)];
					
					$joins .= " left join tbl_relaciona_campos as tbl_campo_{$nomeCampo} on tbl_noticias.id = tbl_campo_{$nomeCampo}.id_conteudo and tbl_campo_{$nomeCampo}.id_campo = {$idCampoPersonalizado}";
					$labelCamposAdds .= ", tbl_campo_{$nomeCampo}.valor as {$nomeCampo}";
				}
			}
			
			if($limite <> '' and $this->limite_pagina == '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			if($this->limite_pagina <> '') {
				if($this->n_pagina == '') {
					$this->n_pagina = 1;
				}
				$inicio = ($this->n_pagina-1)*$this->limite_pagina;
				$final = $inicio+$this->limite_pagina;
				$sqlLimite = " limit {$inicio},{$final}";
			}
			
			try{   
				$sql = "SELECT tbl_noticias.* {$labelCamposAdds} FROM tbl_noticias $joins where 1=1 $sql $this->addWhere $sqlOrdem $sqlLimite";
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
				//print_r($stm);
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
		
		function rs_campos_do_grupo($id_menu) {
			
			if($id_menu <> '') {
				$sql .= " and tbl_lista_campos_grupo.id_menu = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_menu;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try {   
				$sql = "SELECT tbl_lista_campos_grupo.* FROM tbl_lista_campos_grupo $joins where 1=1 $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				//print_r($stm);
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
		
		function desc_conteudo($id, $largura_imagem='35') {
			$desc_item = $this->rsDados('', $id);
			
			if($desc_item->foto <> '') {
			?>
                <img src="img_noticias/<?=$desc_item->foto;?>" alt="<?=$desc_item->titulo;?>" style="float:left; margin-right:20px; max-width:<?=$largura_imagem;?>%; margin-bottom:10px;">
			<?php
			}
			
            echo $desc_item->noticia;
			include('ferramentas/redes-sociais.php');
		}
		
		function rs_cidades_estados_distintos($idMenu='', $orderBy='', $tipo="conteudos", $limite='', $categoria='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($idMenu <> '') {
				$sql .= " and tbl_noticias.idMenu = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idMenu;
			}
			
			if($_SESSION['id_idioma'] <> '' and $idIdioma == '') {
				$sql .= " and tbl_noticias.id_idioma = ?"; 
				$nCampos++;
				$campo[$nCampos] = $_SESSION['id_idioma'];
			}
			
			if($idIdioma == '' and $_SESSION['id_idioma'] == '') {
				$idIdioma = 1;
			}
			
			if($_SESSION['id_idioma'] == '1' or $idIdioma == '1') {
				$labelCamposAdds .= ", tbl_noticias.id as id_conteudoPrincipal";
			}
			
			if($idIdioma <> '') {
				$sql .= " and tbl_noticias.id_idioma = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idIdioma;
			}
			
			if($idIn <> '') {
				$sql .= " and tbl_noticias.id in (?)"; 
				$nCampos++;
				$campo[$nCampos] = $idIn;
			}
			
			if($tipo <> '') {
				$sql .= " and tbl_noticias.tipo = ?"; 
				$nCampos++;
				$campo[$nCampos] = $tipo;
			}
			
			if($categoria <> '') {
				$sql .= " and tbl_noticias.categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $categoria;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			$joins .= " left join dados_cidades on tbl_noticias.id_cidade = dados_cidades.id";
			$labelCamposAdds .= ", dados_cidades.nome as nome_cidade, dados_cidades.id as id_cidade";
					
			$joins .= " left join dados_estados on tbl_noticias.id_estado = dados_estados.id";
			$labelCamposAdds .= ", dados_estados.nome as nome_estado, dados_estados.uf as nome_uf";
			
			try{   
				$sql = "SELECT tbl_noticias.* {$labelCamposAdds} 
				FROM 
					tbl_noticias 
					$joins 
				where 
					1=1 
					$sql 
					$sqlOrdem
				group by 
					tbl_noticias.id_estado, tbl_noticias.id_cidade
					$sqlLimite";
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
		
		function add($mensagemAlert='', $redireciona='') {
			global $conInstanciada, $InfoSiteInstanciada; 
			
			if($_POST['acao'] == 'addConteudos') {
				
				$i=0;
				$idiomas = explode(', ', $_POST['idsIdiomas']);
				foreach($idiomas as $idioma) {
					try{
						
						if($idioma == '') {
							$idioma = 1;
						}
						
						if(file_exists('../class/conteudos.php')) {
							$pastaArquivos = '../img_noticias';
						} else {
							$pastaArquivos = 'img_noticias';
						}
						
						$sql = "INSERT INTO tbl_noticias (titulo, data, noticia, categoria, foto, destaque, arquivo, promocao, idMenu, tipo, id_cliente, de, por, breve, link, breve2, ordem, id_idioma, id_conteudoPrincipal, ultimaAtualizacao, id_estado, id_cidade, id_subcat, fortawesome_icone, ativo, breve3, id_select_adicional) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['titulo'][$i]);   
						$stm->bindValue(2, ($_POST['data'][$i] <> '') ? ($_POST['data'][$i].' '.$_POST['hora'][$i]) : date('Y-m-d H:i:s'));   
						$stm->bindValue(3, $_POST['noticia'][$i]);   
						$stm->bindValue(4, $_POST['categoria'][$i]);   
						$stm->bindValue(5, upload('foto', $pastaArquivos, $i));   
						$stm->bindValue(6, $_POST['destaque'][$i]);   
						$stm->bindValue(7, upload('arquivo', $pastaArquivos, $i));   
						$stm->bindValue(8, $_POST['promocao'][$i]);   
						$stm->bindValue(9, $_POST['idMenu']);   
						$stm->bindValue(10, $_POST['tipo']);   
						$stm->bindValue(11, $_POST['id_cliente'][$i]);   
						$stm->bindValue(12, valorCalculavel($_POST['de'][$i]));   
						$stm->bindValue(13, valorCalculavel($_POST['por'][$i]));   
						$stm->bindValue(14, $_POST['breve'][$i]);   
						$stm->bindValue(15, $_POST['link'][$i]);   
						$stm->bindValue(16, $_POST['breve2'][$i]);   
						$stm->bindValue(17, $_POST['ordem'][$i]);   
						$stm->bindValue(18, $idioma);   
						$stm->bindValue(19, $idConteudoPrincipal);   
						$stm->bindValue(20, $_POST['ultimaAtualizacao'][$i]);   
						$stm->bindValue(21, $_POST['id_estado'][$i]);   
						$stm->bindValue(22, $_POST['id_cidade'][$i]);   
						$stm->bindValue(23, $_POST['idSub'][$i]);   
						$stm->bindValue(24, $_POST['fortawesome_icone'][$i]);   
						$stm->bindValue(25, $_POST['ativo'][$i]);   
						$stm->bindValue(26, $_POST['breve3'][$i]);   
						$stm->bindValue(27, $_POST['id_select_adicional'][$i]);  
						$stm->execute();
						$idConteudo = $this->pdo->lastInsertId();
						
						if($i == 0) {
							$idConteudoPrincipal = $idConteudo;
							
							for($n_foto=0; $n_foto<=count($_FILES['foto_extra']['tmp_name']); $n_foto++) {
								if($_FILES['foto_extra']['tmp_name'][$n_foto] <> '') {	
									try {
										$stm = '';
										$sql = "INSERT INTO tbl_fotos (id_galeria, foto, tipo) VALUES (?, ?, ?)";   
										$stm = $this->pdo->prepare($sql);   
										$stm->bindValue(1, $idConteudo);   
										$stm->bindValue(2, upload('foto_extra', $pastaArquivos, $n_foto));   
										$stm->bindValue(3, ($_POST['tipo'].$idConteudo));   
										$stm->execute(); 
									} catch(PDOException $erro){
										echo $erro->getMessage();
									}
								}
							}
						}
						
						if($_POST['enviar_notificacao_email'] == 'S') {
							include('../class/info-site.php');
							$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();
							
							$nomeRemente = $infoSite->nome;
							$emailRemente = $infoSite->email;
							
							include('../funcoes/enviar-email.php');
							$msg .= "Titulo: {$_POST['titulo'][0]}<br>";
							
							if($_POST['breve'][0] <> '') {
								$msg .= "Titulo: {$_POST['titulo'][0]}<br>";
							}
							
							if($_POST['por'][0] <> '') {
								$msg .= "Por: R$ {$_POST['por'][0]}<br>";
							}
							
							if($_POST['noticia'][0] <> '') {
								$msg .= $_POST['noticia[]'][0];
							}
							
							EnviarEmail('Novo item cadastro no site: '.$_POST['titulo'][0], $infoSite->nome, $emailRemente, $emailRemente, $infoSite->email, $msg);
						}
						
						
						/// CAMPOS PERSONALIZADOS
						if($_POST['idsCamposPersonalizados'] <> '') {
							$camposPersonalizados = explode(', ', $_POST['idsCamposPersonalizados']);
							for($i=0; $i<count($camposPersonalizados); $i++) {
								try{   
									$sql = "INSERT INTO tbl_relaciona_campos (id_conteudo, id_campo, valor, id_idioma) VALUES (?, ?, ?, ?)";   
									$stm = $this->pdo->prepare($sql);   
									$stm->bindValue(1, $idConteudo);   
									$stm->bindValue(2, $camposPersonalizados[$i]);   
									$stm->bindValue(3, $_POST['campoPersonalizado_'.$camposPersonalizados[$i]]);   
									$stm->bindValue(4, 1);   
									$stm->execute();
								} catch(PDOException $erro){
									echo $erro->getMessage(); 
								}
							}
						} 
						/// FIM CAMPO PERSONALIZADO
						
						// CADASTRA FILTROS
						$iIdioma = 0;
						foreach($idiomas as $idioma) {
							if($_POST['idsFiltros'] <> '') {
								$filtros = explode(', ', $_POST['idsFiltros']);
								$grupos = explode(', ', $_POST['ids_campos_grupos']);
								for($i=0; $i<count($filtros); $i++) {
									try{   
										$sql = "INSERT INTO tbl_relaciona_filtros (id_conteudo, id_menuFiltro, id_filtro, id_lista_grupo) VALUES (?, ?, ?, ?)";   
										$stm = $this->pdo->prepare($sql);   
										$stm->bindValue(1, $idConteudo);   
										$stm->bindValue(2, $filtros[$i]);   
										$stm->bindValue(3, $_POST['id_filtro'.$filtros[$i].$grupos[$i]][$iIdioma]);   
										$stm->bindValue(4, ($grupos[$i] <> '') ? $grupos[$i] : NULL);   
										$stm->execute();
									} catch(PDOException $erro){
										echo $erro->getMessage(); 
									}
								}
								$iIdioma++;
							}
						}
						/////////////
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					$i++;
				}
				
				
				if($mensagemAlert <> '') {
					echo "	<script>
							alert('{$mensagemAlert}');
							</script>";
				}
				
				$linkRedireciona = "conteudos.php?idMenu={$_POST['idMenu']}&tipo={$_POST['tipo']}";
				
				if($redireciona <> '') {
					$linkRedireciona = $redireciona;
				}
				
				if($_POST['incluir_mais'] == 'S' and $_POST['tipo'] <> 'categoria') {
					echo "	<script>
							if(confirm('Deseja incluir mais um registro?')) {
								//window.location='add-conteudo.php?idMenu={$_POST['idMenu']}&tipo={$_POST['tipo']}&nome=Novo%20registro';
								alert('Registro incluído com sucesso.');
								history.back();
							} else {
								window.location='{$linkRedireciona}';
							}
							</script>";
							exit;
				}
				
				if($_POST['linkRedirecionaIncluir'] <> '' and $_POST['tipo'] <> 'categoria') {
					echo "	<script>
							if(confirm('{$_POST['msgRedirecionaIncluir']}')) {
								window.location='".str_replace('[id_conteudo]', $idConteudo, $_POST['linkRedirecionaIncluir'])."';
							} else {
								window.location='{$linkRedireciona}';
							}
							</script>";
							exit;
				}
				
				echo "	<script>
						window.location='{$linkRedireciona}';
						</script>";
						exit;
			}
		}
		
		function editar($redireciona='') {
			if($_POST['acao'] == 'editarConteudos') {
				$idiomas = explode(', ', $_POST['idsIdiomas']);
				
				$i=0;
				foreach($_POST['id'] as $id) {
					try{   
						$sql = "UPDATE tbl_noticias SET titulo=?, data=?, noticia=?, categoria=?, foto=?, destaque=?, arquivo=?, promocao=?, idMenu=?, tipo=?, id_cliente=?, de=?, por=?, breve=?, link=?, breve2=?, ordem=?, id_idioma=?, id_select_adicional=?, ultimaAtualizacao=?, id_estado=?, id_cidade=?, id_subcat=?, fortawesome_icone=?, ativo=?, breve3=? WHERE id=?";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['titulo'][$i]);   
						$stm->bindValue(2, ($_POST['data'][$i] <> '') ? ($_POST['data'][$i] . ' ' . $_POST['hora'][$i]) : date('Y-m-d H:i:s'));  //echo $_POST['data']; exit; 
						$stm->bindValue(3, str_replace('\"',"",$_POST['noticia'][$i]));   
						$stm->bindValue(4, $_POST['categoria'][$i]);   
						$stm->bindValue(5, upload('foto', '../img_noticias', $i));   
						$stm->bindValue(6, $_POST['destaque'][$i]);  
						$stm->bindValue(7, upload('arquivo', '../img_noticias', $i));   
						$stm->bindValue(8, $_POST['promocao'][$i]);   
						$stm->bindValue(9, $_POST['idMenu']);   
						$stm->bindValue(10, $_POST['tipo']);   
						$stm->bindValue(11, ($_POST['id_cliente'][$i] <> '') ? $_POST['id_cliente'][$i] : NULL);   
						$stm->bindValue(12, valorCalculavel($_POST['de'][$i]));   
						$stm->bindValue(13, valorCalculavel($_POST['por'][$i]));   
						$stm->bindValue(14, $_POST['breve'][$i]);   
						$stm->bindValue(15, $_POST['link'][$i]);   
						$stm->bindValue(16, $_POST['breve2'][$i]);   
						$stm->bindValue(17, $_POST['ordem'][$i]);   
						$stm->bindValue(18, $idiomas[$i]);   
						$stm->bindValue(19, $_POST['id_select_adicional'][$i]);   
						$stm->bindValue(20, $_POST['ultimaAtualizacao'][$i]);   
						$stm->bindValue(21, $_POST['id_estado'][$i]);   
						$stm->bindValue(22, $_POST['id_cidade'][$i]);   
						$stm->bindValue(23, $_POST['idSub'][0]);   
						$stm->bindValue(24, $_POST['fortawesome_icone'][$i]);   
						$stm->bindValue(25, $_POST['ativo'][$i]);   
						$stm->bindValue(26, $_POST['breve3'][$i]);   
						$stm->bindValue(27, $id);   
						$stm->execute(); 
						
						if($id == '') {
							$sql = "INSERT INTO tbl_noticias (titulo, data, noticia, categoria, foto, destaque, arquivo, promocao, idMenu, tipo, id_cliente, de, por, breve, link, breve2, ordem, id_idioma, id_conteudoPrincipal, ultimaAtualizacao, id_estado, id_cidade, id_subcat, fortawesome_icone, ativo, breve3, id_select_adicional) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $_POST['titulo'][$i]);   
							$stm->bindValue(2, ($_POST['data'][$i] <> '') ? $_POST['data'][$i] : date('Y-m-d H:i:s'));   
							$stm->bindValue(3, $_POST['noticia'][$i]);   
							$stm->bindValue(4, $_POST['categoria'][$i]);   
							$stm->bindValue(5, upload('foto', $pastaArquivos, $i));   
							$stm->bindValue(6, $_POST['destaque'][$i]);   
							$stm->bindValue(7, upload('arquivo', $pastaArquivos, $i));   
							$stm->bindValue(8, $_POST['promocao'][$i]);   
							$stm->bindValue(9, $_POST['idMenu']);   
							$stm->bindValue(10, $_POST['tipo']);   
							$stm->bindValue(11, $_POST['id_cliente'][$i]);   
							$stm->bindValue(12, valorCalculavel($_POST['de'][$i]));   
							$stm->bindValue(13, valorCalculavel($_POST['por'][$i]));   
							$stm->bindValue(14, $_POST['breve'][$i]);   
							$stm->bindValue(15, $_POST['link'][$i]);   
							$stm->bindValue(16, $_POST['breve2'][$i]);   
							$stm->bindValue(17, $_POST['ordem'][$i]);   
							$stm->bindValue(18, $idioma);   
							$stm->bindValue(19, $_POST['id'][0]);   
							$stm->bindValue(20, $_POST['ultimaAtualizacao'][$i]);   
							$stm->bindValue(21, $_POST['id_estado'][$i]);   
							$stm->bindValue(22, $_POST['id_cidade'][$i]);   
							$stm->bindValue(23, $_POST['idSub'][$i]);   
							$stm->bindValue(24, $_POST['fortawesome_icone'][$i]);   
							$stm->bindValue(25, $_POST['ativo'][$i]);   
							$stm->bindValue(26, $_POST['breve3'][$i]);   
							$stm->bindValue(27, $_POST['id_select_adicional'][$i]);  
							$stm->execute();
						}
						
						/// CAMPOS PERSONALIZADOS
						try{   
							$sql = "DELETE FROM tbl_relaciona_campos WHERE id_conteudo=?";   
							$stm = $this->pdo->prepare($sql);   
							$stm->bindValue(1, $id);   
							$stm->execute();
						} catch(PDOException $erro){
							echo $erro->getMessage(); 
						}
					
						if($_POST['idsCamposPersonalizados'] <> '') {
							$camposPersonalizados = explode(', ', $_POST['idsCamposPersonalizados']);
							for($i=0; $i<count($camposPersonalizados); $i++) {
								try{   
									$sql = "INSERT INTO tbl_relaciona_campos (id_conteudo, id_campo, valor, id_idioma) VALUES (?, ?, ?, ?)";   
									$stm = $this->pdo->prepare($sql);   
									$stm->bindValue(1, $id);   
									$stm->bindValue(2, $camposPersonalizados[$i]);   
									$stm->bindValue(3, $_POST['campoPersonalizado_'.$camposPersonalizados[$i]]);   
									$stm->bindValue(4, 1);   
									$stm->execute();
								} catch(PDOException $erro){
									echo $erro->getMessage(); 
								}
							}
						}
						
						
						// CADASTRA FILTROS
						if($_POST['idsFiltros'] <> '') {
							try{   
								$sql = "DELETE FROM tbl_relaciona_filtros WHERE id_conteudo=?";   
								$stm = $this->pdo->prepare($sql);   
								$stm->bindValue(1, $id);   
								$stm->execute();
							} catch(PDOException $erro){
								echo $erro->getMessage(); 
							}
						}
						
						$iIdioma = 0;
						foreach($idiomas as $idioma) {
							if($_POST['idsFiltros'] <> '') {
								$filtros = explode(', ', $_POST['idsFiltros']);
								$grupos = explode(', ', $_POST['ids_campos_grupos']);
								
								for($i=0; $i<count($filtros); $i++) {
									try{   
										$sql = "INSERT INTO tbl_relaciona_filtros (id_conteudo, id_menuFiltro, id_filtro, id_lista_grupo) VALUES (?, ?, ?, ?)";   
										$stm = $this->pdo->prepare($sql);   
										$stm->bindValue(1, $id);   
										$stm->bindValue(2, $filtros[$i]);   
										$stm->bindValue(3, $_POST['id_filtro'.$filtros[$i].$grupos[$i]][$iIdioma]);   
										$stm->bindValue(4, ($grupos[$i] <> '') ? $grupos[$i] : NULL);   
										$stm->execute();
									} catch(PDOException $erro){
										echo $erro->getMessage(); 
									}
								}
								$iIdioma++;
							}
						}
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					$i++;
				}
				
				$linkRedireciona = "conteudos.php?idMenu={$_POST['idMenu']}&tipo={$_POST['tipo']}";
				
				if($redireciona <> '') {
					$linkRedireciona = $redireciona;
				}
				
				echo "	<script>
						window.location='{$linkRedireciona}';
						</script>";
						exit;
						
			}
		}
		
		function marcaVisita($id, $acao='marcaVisita') {
			if($acao == 'marcaVisita') {
				try{   
					$sql = "UPDATE tbl_noticias SET visitas=visitas+1 WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $id);   
					$stm->execute(); 
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirConteudo') {
				
				// deleta foto
				if($_GET['foto'] <> '') {
					unlink ("../img_noticias/{$_GET['foto']}");
				}
				
				try{   
					$sql = "DELETE FROM tbl_noticias WHERE id=? or id_conteudoPrincipal = ?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->bindValue(2, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				try{   
					$sql = "DELETE FROM tbl_relaciona_filtros WHERE id_conteudo=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				try{   
					$sql = "DELETE FROM tbl_relaciona_campos WHERE id_conteudo=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
				try{   
					$sql = "DELETE FROM tbl_relaciona_idiomas WHERE id_conteudo=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$conteudosInstanciada = 'S';
}