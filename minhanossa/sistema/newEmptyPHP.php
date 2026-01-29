    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="formProduto" class="stdform" id="formProduto">
                    	
                        
                        
<p>


    <div class="row">
        <div class="col-md-2">
            C&oacute;digo<br>
            <div class="input-prepend">
                
                <input type="text" name="id" class="input-small" placeholder="Código" disabled value="<?php echo $row_rs_editar_produto['id'];?>" />
                <span class="add-on"><i class="iconfa-qrcode"></i></span>
            </div>
        </div>
        <div class="col-md-3">
        	Origem<br>
            <div class="input-prepend">
                 <select name="origem" class="uniformselect">
                        <option value="L" <?php if($row_rs_editar_produto['origem'] == 'L'){ echo "selected";}?> >Loja</option>
		    	<option value="E" <?php if($row_rs_editar_produto['origem'] == 'E'){ echo "selected";}?>>E-commerce</option>
                </select>
            </div>    
        </div>
        
   
    </div>

     <div class="row">
        
        <div class="col-md-3">
        	Categoria<br>
            <div class="input-prepend">
                <select name="categoria" class="uniformselect">
					<?php do{?>
                    	<option value="<?php echo $row_rs_categoria['id'];?>" ><?php echo $row_rs_categoria['categoria'];?></option>
                    <?php }while($row_rs_categoria = mysql_fetch_assoc($rs_categoria));?>         
                </select>
            </div>    
        </div>
        
        <div class="col-md-3">
        	Fornecedor<br>
            <div class="input-prepend">
                <select name="id_fornecedor" class="uniformselect">
					<?php do{?>
                    	<option value="<?php echo $row_rs_fornecedor['id'];?>" ><?php echo $row_rs_fornecedor['nome'];?></option>
                    <?php }while($row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor));?>         
                </select>
            </div>    
        </div>
    </div>

     <div class="row">
        <div class="col-md-4">
        	Nome<br>
            <div class="input-prepend">
                <input type="text" name="nome" class="input-xlarge" placeholder="Nome"/>
                <span class="add-on"><i class="iconfa-edit"></i></span>
            </div>    
        </div>
         <div class="col-md-2">
        	Quantidade de estoque<br>
            <div class="input-prepend">
            	
                <input type="number" name="qnt_estoque" class="input-small"/>
                <span class="add-on"><i class="iconfa-shopping-cart"></i></span>
            </div>    
        </div>
         <div class="col-md-2">
        	Numeração<br>
            <div class="input-prepend">
            	
                <input type="text" name="numeracao" class="input-small"/>
                <span class="add-on"><i class="iconfa-shopping-cart"></i></span>
            </div>    
        </div>
    </div>

    <div class="row">
      
        <div class="col-md-3">
        	Coleção<br>
            <div class="input-prepend">
                <select name="id_colecao" class="uniformselect">
					<?php do{?>
                    	<option value="<?php echo $row_rs_colecao['id'];?>" ><?php echo $row_rs_colecao['nome'];?></option>
                    <?php }while($row_rs_colecao = mysql_fetch_assoc($rs_colecao));?>         
                </select>
            </div>    
        </div>
        <div class="col-md-3">
        	Cor<br>
            <div class="input-prepend">
                <select name="id_cor" class="uniformselect">
					<?php do{?>
                    	<option value="<?php echo $row_rs_cores['id'];?>" ><?php echo $row_rs_cores['nome'];?></option>
                    <?php }while($row_rs_cores = mysql_fetch_assoc($rs_cores));?>         
                </select>
            </div>    
        </div>
        <div class="col-md-3">
        	Composição<br>
            <div class="input-prepend">
                <select name="id_cor" class="uniformselect">
					<?php do{?>
                    	<option value="<?php echo $row_rs_composicao['id'];?>" ><?php echo $row_rs_composicao['nome'];?></option>
                    <?php }while($row_rs_composicao = mysql_fetch_assoc($rs_composicao));?>         
                </select>
            </div>    
        </div>
    </div>

     <div class="row">
        <div class="col-md-3">
            Pre&ccedil;o de custo<br>
            <div class="input-prepend">
            	
                <input type="text" name="preco_custo" class="input-medium"/>
                <span class="add-on"><i class="fa fa-usd"></i></span>
            </div>
        </div>
        <div class="col-md-3">
        	Valor do aluguel<br>
            <div class="input-prepend">
            	
                <input type="text" name="valor_aluguel" class="input-medium"/>
                <span class="add-on"><i class="fa fa-usd"></i></span>
            </div>    
        </div>
        <div class="col-md-3">
        	Valor de venda<br>
            <div class="input-prepend">
            	
                <input type="text" name="valor_venda" class="input-medium"/>
                <span class="add-on"><i class="fa fa-usd"></i></span>
            </div>    
        </div>
    </div>
 
    <div class="row">
        <div class="col-md-6">
            Imagem<br>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3">
                        <i class="iconfa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                <span class="btn btn-file"><span class="fileupload-new">Selecione arquivo</span>
                <span class="fileupload-exists">Mudar</span>
                <input type="file" name="foto" /></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        	Tipo<br>
            <div class="input-prepend">
                <select name="tipo" class="uniformselect">
				<option >Selecione...</option>
                <option value="1" >MASCULINO</option>
                <option value="2" >FEMININO</option>
                    
                </select>
            </div>    
        </div>
</div>

<div class="row">
       <div class="col-md-3">
        	Pontuação<br>
            <div class="input-prepend">
            	
                <input type="text" name="pontuacao" class="input-medium"/>
                <span class="add-on"><i class="fa fa-pencil"></i></span>
            </div>    
        </div>
       
</div>

    <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Descrição<br>
                                    <div class="input-prepend">
                                        <textarea name="descricao" id="descricao" rows="5" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Modo de Lavagem<br>
                                    <div class="input-prepend">
                                        <textarea name="modo_lavagem" id="modo_lavagem" rows="5" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="row">
<div class="col-md-11" align="right">
                                
                                <a href="produto.php" class="btn btn-danger btn-mini"> 
                                	<i class="iconfa-remove"></i> &nbsp; Cancelar
                                </a>
                                    
                                <a href="javascript:;" onClick="document.getElementById('formProduto').submit();" class="btn btn-mini btn-success">
                                	<i class="iconfa-ok"></i> &nbsp; Salvar
                                </a> 
</div>                                          
                            </div>
<input type="hidden" name="id" value="<?php echo $row_rs_editar_produto['id'];?>">
<input type="hidden" name="foto_Atual" value="<?php echo $row_rs_editar_produto['foto'];?>">
<input type="hidden" name="MM_update" value="formProduto">
</p>

  </form>