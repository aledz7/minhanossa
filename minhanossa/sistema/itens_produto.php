<?php 
include('../Connections/conexao.php'); 
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
	$query_rs_itens_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
	$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
	$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
	$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);


	mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_adverso_produto = "SELECT * FROM tbl_produto where id = '{$_GET['qtdItemProduto']}'";
	$rs_editar_adverso_produto = mysql_query($query_rs_editar_adverso_produto, $conexao) or die(mysql_error());
	$row_rs_editar_adverso_produto = mysql_fetch_assoc($rs_editar_adverso_produto);
	$totalRows_rs_editar_adverso_produto = mysql_num_rows($rs_editar_adverso_produto);
	
?>


                           
                                <div class="col-md-2">
                                    Qtde<br>
                                    <div class="input-prepend">
                                    <input type="text" name="quantidade_produto[]" id="quantidade_produto<?=$i;?>" class="input-small" value="<?=$row_rs_editar_adverso['quantidade_produto'];?>">
                                    	
                                		
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Valor Unitário<br>
                                    <div class="input-prepend">
                                    <input type="text" name="valor_unitario_produto[]" id="valor_unitario_produto<?=$i;?>" value="<?=$row_rs_editar_adverso['valor_unitario_produto'];?>" class="input-small">
                                    
                                    	<span class="add-on"><i class="fa fa-usd" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Desconto<br>
                                    <div class="input-prepend">
                                    <input type="text" name="desconto_produto[]" id="desconto_produto<?=$i;?>" class="input-small" value="<?=$row_rs_editar_adverso['desconto_produto'];?>">
                                    	
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    Valor Total<br>
                                    <div class="input-prepend">
                                    <input type="text" name="valor_total_produto[]" id="valor_total_produto<?=$i;?>" value="<?=$row_rs_editar_adverso['valor_total_produto'];?>" class="input-small">
                                    	<span class="add-on"><i class="fa fa-usd" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            
                        
      
    


        
             
      