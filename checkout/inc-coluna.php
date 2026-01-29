<?php 
include('Connections/conexao.php');
include('funcoes.php');

include('../class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedores_produtos = "SELECT * FROM tbl_fornecedores ORDER BY nome ASC";
$rs_fornecedores_produtos = mysql_query($query_rs_fornecedores_produtos, $conexao) or die(mysql_error());
$row_rs_fornecedores_produtos = mysql_fetch_assoc($rs_fornecedores_produtos);
$totalRows_rs_fornecedores_produtos = mysql_num_rows($rs_fornecedores_produtos);

?>
<div class="col-md-3 col-sm-3">
             <div class="narrow-by-list">
              <div class="block layered-attribute">
               <div class="block-title">
                <h2>Ordenar por</h2>
               </div>
               <div class="odd">
                <ul>
                 <li>
                  <a href="?ordem=novidades" >
                   Novidades
                  </a>
                 </li>
                 <li>
                  <a href="?ordem=mais_vendidos" >
                   Mais Vendidos
                  </a>
                 </li>
                 <li>
                  <a href="?ordem=vCrescente" >
                   Menor Pre&ccedil;o
                  </a>
                 </li>
                 <li>
                  <a href="?ordem=vDecrescente" >
                   Maior Pre&ccedil;o
                  </a>
                 </li>
               </ul>
              </div>
             </div>
            </div>
	<!--
             <div class="narrow-by-list">
              <div class="block layered-attribute">
               <div class="block-title">
                <h2>Categorias</h2>
               </div>
               <div class="odd">
                <ul>
                 <?/* $rsCategorias = $conteudos->rsDados(1, '', '', 'categoria');
					 foreach($rsCategorias as $item) { ?>
					 <li>
					  <a href="?id-cat=<?php echo $item->id?>" >
					   <?php echo $item->titulo; ?>
					  </a>
					 </li>
                 	<?php } 
				*/?>
               </ul>
              </div>
             </div>
            </div>
	-->
            <?php /*?><div class="narrow-by-list">
             <div class="block layered-attribute">
              <div class="block-title">
               <h2>Fornecedores</h2>
              </div>
              <div class="odd">
               <ul>
                <?php do { ?>
                <li>
                 <a href="?id-for=<?php echo $row_rs_fornecedores_produtos['id']?>" style="text-transform:uppercase;">
                  <?php echo $row_rs_fornecedores_produtos['nome'] ?>
                 </a>
                </li>
                <?php } while($row_rs_fornecedores_produtos = mysql_fetch_assoc($rs_fornecedores_produtos)); ?>
               </ul>
              </div>
             </div>
            </div><?php */?>
           </div>